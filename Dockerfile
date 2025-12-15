FROM php:8.3-fpm

# Dependency sistem
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    python3 python3-pip python3-venv \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Alias python
RUN ln -sf /usr/bin/python3 /usr/bin/python

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node 20
RUN curl -fsSL https:#deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --prefer-dist

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

CMD ["php-fpm"]