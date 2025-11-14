FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    libxml2-dev

# Extensiones necesarias para Laravel + Filament
RUN docker-php-ext-install intl pdo pdo_mysql zip

# Activar mod_rewrite
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias del proyecto
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Permisos
RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
