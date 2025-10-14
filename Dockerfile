# Usa una imagen base de PHP optimizada para Composer
FROM composer:2.7 as vendor

# Establece el directorio de trabajo
WORKDIR /app

# Copia los archivos de configuración y dependencia de PHP y Laravel
COPY composer.json composer.lock ./

# Instala las dependencias de PHP (Laravel)
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# --- Etapa de Node.js (para frontend con Vite) ---
FROM node:20 as node

WORKDIR /app

# Copia los archivos de Node.js
COPY package.json package-lock.json vite.config.js ./

# Instala y construye los assets de frontend
RUN npm install
COPY . .
RUN npm run build


# --- Etapa Final (Servicio Web) ---
FROM php:8.3-fpm-alpine

# Instala extensiones de PHP necesarias (como pdo_pgsql)
RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copia los archivos de la aplicación
WORKDIR /var/www/html
COPY . .

# Copia las dependencias de PHP de la etapa 'vendor'
COPY --from=vendor /app/vendor/ vendor/

# Copia los assets de frontend de la etapa 'node'
COPY --from=node /app/public/build/ public/build/

# Asegura permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Exponer el puerto para el servidor web (aunque Nginx/Apache lo manejarán)
EXPOSE 9000

# Define el comando de inicio (se usará con el Web Service de Render)
# ENTRYPOINT ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]