FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pcntl \
    opcache \
    pdo \
    pdo_mysql \
    intl \
    zip \
    gd \
    exif \
    ftp \
    bcmath \
    mbstring \
    xml

# Install Redis extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Configure PHP
RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.jit=tracing" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.jit_buffer_size=256M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "memory_limit=512M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize=64M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size=64M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "display_errors=On" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "error_reporting=E_ALL" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "log_errors=On" >> /usr/local/etc/php/conf.d/custom.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Enable Apache modules
RUN a2enmod rewrite headers expires

# Set working directory
WORKDIR /var/www/html

# Copy Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Create necessary directories
RUN mkdir -p /var/www/html/core/storage \
    /var/www/html/core/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Copy application files
COPY --chown=www-data:www-data . /var/www/html

# Ensure .env exists in core directory (copy from root if exists)
RUN if [ -f /var/www/html/.env ]; then \
        cp /var/www/html/.env /var/www/html/core/.env; \
    fi

# Set permissions for Laravel directories
RUN chown -R www-data:www-data /var/www/html/core/storage \
    /var/www/html/core/bootstrap/cache \
    && chmod -R 775 /var/www/html/core/storage \
    /var/www/html/core/bootstrap/cache

# Install Composer dependencies
RUN cd /var/www/html/core && \
    composer install --prefer-dist --optimize-autoloader --no-interaction --no-dev


# Ensure proper permissions after composer install
RUN chown -R www-data:www-data /var/www/html/core/vendor \
    && chmod -R 755 /var/www/html/core/vendor
    
# Create storage symlink
RUN cd core && php artisan storage:link

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port
EXPOSE 80

# Set entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

# Start Apache
CMD ["apache2-foreground"]
