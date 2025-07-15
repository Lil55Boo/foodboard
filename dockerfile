# Étape 1 : build frontend avec Node 20 (version alpine légère)
FROM node:20-alpine as frontend-build

WORKDIR /app

COPY foodboard-front/package*.json ./
RUN npm install

COPY foodboard-front/ .
RUN npm run build

# Étape 2 : backend Laravel (PHP 8.2-fpm)
FROM php:8.2-fpm

# Installer dépendances PHP nécessaires (pdo, mbstring, zip, ...)
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo mbstring zip exif pcntl

# Copier l'app Laravel
WORKDIR /var/www

COPY . .

# Copier le build frontend dans public/
COPY --from=frontend-build /app/dist ./public

# Configurer permissions, etc. si besoin

CMD ["php-fpm"]