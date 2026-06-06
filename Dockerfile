FROM php:8.3-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

# Fix Apache MPM conflict: forcefully disable mpm_event and mpm_worker before
# enabling mpm_prefork. The base php:8.3-apache image pre-enables both
# mpm_event and mpm_worker, so we must disable them first with -f (force) to
# avoid "More than one MPM loaded" errors at runtime.
RUN a2dismod -f mpm_event mpm_worker || true \
 && a2enmod mpm_prefork \
 && a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Apache config
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Start script
COPY docker-start.sh /docker-start.sh
RUN chmod +x /docker-start.sh

EXPOSE 80

CMD ["/docker-start.sh"]
