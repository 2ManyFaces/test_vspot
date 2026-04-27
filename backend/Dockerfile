# Build stage
FROM php:8.3-fpm-alpine as builder

# Install system dependencies
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    postgresql-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    redis \
    bcmath \
    opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files
COPY backend/composer.json backend/composer.lock* ./

# Install dependencies
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist

# Production stage
FROM php:8.3-fpm-alpine

# Install runtime dependencies
RUN apk add --no-cache \
    postgresql-libs \
    postgresql-client \
    supervisor \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    redis \
    bcmath \
    opcache

# Configure PHP extensions
RUN docker-php-ext-enable \
    pdo \
    pdo_pgsql \
    redis \
    bcmath \
    opcache

# Copy PHP configuration
COPY backend/docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY backend/docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy entrypoint script
COPY backend/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

WORKDIR /app

# Copy application code
COPY backend . 

# Copy environment file for Docker
COPY .env.docker .env

# Copy vendor from builder
COPY --from=builder /app/vendor /app/vendor

# Create necessary directories
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Set proper permissions
RUN chown -R www-data:www-data /app && chmod -R 755 /app

# Expose port
EXPOSE 9000

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD wget --quiet --tries=1 --spider http://localhost:9000/health || exit 1

# Start with entrypoint script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
