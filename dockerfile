# Étape 1 : Build frontend avec Node 20
FROM node:20-alpine AS frontend-build

WORKDIR /app

COPY foodboard-front/package*.json ./
RUN npm install

COPY foodboard-front/ ./
RUN npm run build

# Étape 2 : Backend PHP Laravel
FROM php:8.2-fpm

# Installer dépendances système
RUN apt-get update && apt-get install -y \
git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
&& docker-php-ext-install pdo mbstring zip exif pcntl

# Installer composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


WORKDIR /var/www

# Copier backend Laravel
COPY . .

# Installer dépendances PHP Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copier build frontend dans dossier public/
COPY --from=frontend-build /app/dist /var/www/public

# Permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

