#!/bin/sh

# Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Generate the application key if it doesn't exist
if [ -z "$APP_KEY" ]; then
    php artisan key:generate
fi

# Wait for PostgreSQL to be ready
if [ "$DB_CONNECTION" = "pgsql" ]; then
    echo "Waiting for PostgreSQL to be ready..."
    while ! nc -z $DB_HOST $DB_PORT; do
        sleep 1
    done
    echo "PostgreSQL is ready!"
fi

# Run database migrations
php artisan migrate --force

# Clear and cache configurations
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Start supervisor to manage all processes
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf