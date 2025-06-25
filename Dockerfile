FROM php:8.3-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip unzip git curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    supervisor \
    nginx \
    build-essential \
    openssl \
    nano \
    && docker-php-ext-install pdo_pgsql gd mbstring zip

# Install php-redis extension via PECL
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

# Tambahkan konfigurasi Directory
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Copy existing Laravel project
COPY . /var/www/html

RUN composer install

# RUN php artisan migrate:fresh

# RUN php artisan db:seed

# Set file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port
EXPOSE 80

CMD ["apache2-foreground"]
