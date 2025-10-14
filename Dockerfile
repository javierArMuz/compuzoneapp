# -----------------------------------------------------
# ETAPA 1: Dependencias de PHP (Laravel) - SOLO Composer
# -----------------------------------------------------
FROM composer:2.7 as vendor

WORKDIR /app

COPY composer.json composer.lock ./

# Instala las dependencias de PHP. --no-scripts es CRUCIAL.
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts

# ---
# -----------------------------------------------------
# ETAPA 2: Dependencias de Node.js (Vite/Frontend)
# -----------------------------------------------------
# Usamos una imagen de Node base (no Alpine) que es mejor para binarios como Rollup/Sass
FROM node:20 as node

WORKDIR /app

# Copia solo los archivos de Node.js y configuración para que Vite pueda verlos
COPY package.json package-lock.json vite.config.js ./
COPY resources/ resources/  # Copia el código fuente que necesita Vite

# Instala dependencias y fuerza la reconstrucción para evitar problemas binarios
RUN npm install --legacy-peer-deps
RUN npm run build


# ---
# -----------------------------------------------------
# ETAPA 3: Imagen Final del Servicio Web (Servidor PHP FPM)
# -----------------------------------------------------
# Volvemos a la imagen ligera de PHP Alpine para el servicio final
FROM php:8.3-fpm-alpine

# Instala extensiones de PHP necesarias (como pdo_pgsql)
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
# El orden es importante:
RUN php artisan optimize:clear
RUN php artisan optimize

# Ejecutar las migraciones
# Si ya tienes datos en tu base de datos de Render, este comando puede fallar
# si encuentra archivos de migración que ya se ejecutaron.
# Si quieres solo correr las nuevas, usa solo 'php artisan migrate --force'
# Si quieres que borre todo y vuelva a sembrar (solo para pruebas), usa:
# RUN php artisan migrate:fresh --seed --force
RUN php artisan migrate --force

# Asegurar permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Comando de Inicio (Render lo usará para arrancar el contenedor)
CMD ["php-fpm"]