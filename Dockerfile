# -----------------------------------------------------
# ETAPA 1: Dependencias de PHP (Laravel) - SOLO Composer
# -----------------------------------------------------
FROM composer:2.7 as vendor

# Establece el directorio de trabajo
WORKDIR /app

# Copia solo los archivos necesarios para la instalación de Composer
# NO se necesita artisan en esta etapa, por eso usamos --no-scripts
COPY composer.json composer.lock ./

# Instala las dependencias de PHP. --no-scripts es CRUCIAL.
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts

# -----------------------------------------------------
# ETAPA 2: Dependencias de Node.js (Vite/Frontend)
# -----------------------------------------------------
FROM node:20 as node

WORKDIR /app

# Copia los archivos de Node.js
COPY package.json package-lock.json vite.config.js ./

# Instala y construye los assets de frontend
RUN npm install
# Copia todo el código fuente para que 'npm run build' pueda encontrar rutas, etc.
COPY . .
RUN npm run build

# -----------------------------------------------------
# ETAPA 3: Imagen Final del Servicio Web (Servidor PHP FPM)
# -----------------------------------------------------
FROM php:8.3-fpm-alpine

# Instala extensiones de PHP necesarias (como pdo_pgsql y pdo_mysql si usas ambos)
RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copia todo el código fuente de la aplicación al directorio del servidor
WORKDIR /var/www/html
COPY . .

# Copia las dependencias de PHP de la etapa 'vendor'
COPY --from=vendor /app/vendor/ vendor/

# Copia los assets de frontend de la etapa 'node'
# Asegúrate que esta ruta coincida con el directorio de salida de Vite (public/build)
COPY --from=node /app/public/build/ public/build/

# Configuración y Optimización de Laravel
# 1. Borrar y generar caches de configuración/rutas
RUN php artisan optimize:clear
RUN php artisan optimize

# 2. Ejecutar las migraciones (CRUCIAL para inicializar la DB)
# El flag --force es necesario en producción.
# Asegúrate de que las variables de entorno de la DB (DB_HOST, etc.) estén configuradas en Render.
RUN php artisan migrate --force

# 3. Asegurar permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Comando de Inicio (Render lo usará para arrancar el contenedor)
CMD ["php-fpm"]