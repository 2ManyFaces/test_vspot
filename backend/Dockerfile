# Build stage
FROM php:8.5-fpm-alpine as builder

# Install system dependencies needed for compiling PHP extensions
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    libpq-dev \
    postgresql-dev \
    icu-dev \
    linux-headers \
    autoconf \
    g++ \
    make

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql bcmath opcache

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files
COPY backend/composer.json backend/composer.lock* ./

# Install dependencies (ignoring missing scripts temporarily)
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist

# Production stage
FROM php:8.5-fpm-alpine

# Install runtime dependencies required for PostgreSQL and general runtime
RUN apk add --no-cache \
    libpq \
    postgresql-client \
    supervisor \
    icu-libs \
    fcgi \
    && rm -rf /var/cache/apk/*

# Copy PHP extensions from builder
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /app

# Copy application code
COPY backend . 

# Copy environment file (if you have one specifically for Docker)
# COPY .env.docker .env

# Copy vendor from builder
COPY --from=builder /app/vendor ./vendor

# Create necessary directories and set permissions
RUN mkdir -p storage/logs storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# If a docker-entrypoint exists, ensure it is copied and executable
# COPY backend/docker-entrypoint.sh /usr/local/bin/
# RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port
EXPOSE 9000

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1

# Start PHP-FPM
CMD ["php-fpm"]
