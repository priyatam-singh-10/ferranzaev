#!/bin/bash
set -e

echo "Starting Laravel application setup..."

# Ensure .env file exists in core directory
# if [ ! -f /var/www/html/core/.env ]; then
#     echo "ERROR: .env file not found in /var/www/html/core/"
#     if [ -f /var/www/html/.env ]; then
#         echo "Copying .env from root to core directory..."
#         cp /var/www/html/.env /var/www/html/core/.env
#     else
#         echo "WARNING: No .env file found. Application may not work correctly."
#     fi
# fi

# Navigate to core directory
cd /var/www/html/core

# Ensure storage and cache directories exist with correct permissions
echo "Setting up storage and cache directories..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set correct permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Clear and optimize Laravel caches
echo "Clearing Laravel caches..."
php artisan optimize:clear 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Cache configuration for production
echo "Optimizing Laravel..."
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true
php artisan optimize 2>/dev/null || true

# Run migrations if AUTO_MIGRATE is set
if [ "${AUTO_MIGRATE}" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force
fi

echo "Laravel application setup complete!"

# Execute the main command (Apache)
exec "$@"
