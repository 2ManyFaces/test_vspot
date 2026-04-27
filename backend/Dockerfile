# Build stage
FROM php:8.5-fpm-alpine AS builder

# Install system dependencies needed for compiling PHP extensions
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    libpq-dev \
    postgresql-dev \
    icu-dev \
    libzip-dev \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    linux-headers \
    autoconf \
    g++ \
    make

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql bcmath opcache intl zip gd

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files
COPY composer.json composer.lock* ./

# Install dependencies
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader

# Production stage
FROM php:8.5-fpm-alpine

# Install runtime dependencies
RUN apk add --no-cache \
    libpq \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    icu-libs \
    postgresql-client \
    supervisor \
    fcgi \
    && rm -rf /var/cache/apk/*

# Copy PHP extensions from builder
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /app

# Copy application code
COPY . . 

# Copy vendor from builder
COPY --from=builder /app/vendor ./vendor

# Create necessary directories and set permissions
RUN mkdir -p storage/logs storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Ensure entrypoint is executable
RUN chmod +x docker-entrypoint.sh

# Expose port
EXPOSE 9000

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1

# Use entrypoint script to handle migrations and key generation
ENTRYPOINT ["/app/docker-entrypoint.sh"]
