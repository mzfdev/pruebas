# Use the official PHP 8.2 FPM image as base
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    sqlite \
    nodejs \
    npm \
    supervisor \
    nginx \
    netcat-openbsd

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    zip \
    bcmath \
    gd \
    mbstring \
    xml \
    ctype \
    iconv \
    intl \
    pdo \
    dom \
    fileinfo

# Install and configure PECL extensions
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www/html

# Set permissions for the storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Create the SQLite database file if it doesn't exist
RUN touch /var/www/html/database/database.sqlite && chown www-data:www-data /var/www/html/database/database.sqlite

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node.js dependencies and build assets
RUN npm install && npm run build

# Copy the supervisor and nginx configurations
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Create a script to start the application
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Expose port 9000 for PHP-FPM and port 8000 for the application
EXPOSE 9000 8000

# Start the application
CMD ["/start.sh"]