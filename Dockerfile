# -----------------------------------------------------
# ETAPA 1: Dependencias de PHP (Laravel) - SOLO Composer
# -----------------------------------------------------
FROM composer:2.7 as vendor

WORKDIR /app
COPY composer.json composer.lock ./
# Instala las dependencias de producción de PHP (Composer)
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts


# ---
# -----------------------------------------------------
# ETAPA 2: Dependencias de Node.js (Vite/Frontend)
# *** Cambio: Instalamos con --force y limpiamos caché NPM ***
# -----------------------------------------------------
FROM node:20-alpine as node  # Usamos la versión Alpine de Node, que es más ligera

WORKDIR /app

# 1. Copiamos los archivos de Node
COPY package.json package-lock.json vite.config.js ./

# 2. Copiamos todo el código fuente del proyecto (incluyendo resources)
COPY . .

# 3. Instalamos dependencias y forzamos la reconstrucción
# El flag --force ayuda a resolver problemas de dependencias opcionales (Rollup)
RUN npm install --force --legacy-peer-deps

# 4. Limpiamos la caché de NPM después de la instalación (opcional, pero buena práctica)
RUN npm cache clean --force

# 5. Compilamos los assets de frontend
RUN npm run build


# ---
# -----------------------------------------------------
# ETAPA 3: Imagen Final del Servicio Web (Servidor PHP FPM)
# -----------------------------------------------------
FROM php:8.3-fpm-alpine

# Instala paquetes del sistema necesarios
RUN apk add --no-cache \
    mysql-client \
    git \
    supervisor \
    # Instala las dependencias de BuildKit para binarios si son necesarios
    g++ \
    make \
    # Instala las extensiones de PHP
    && docker-php-ext-install pdo_mysql opcache \
    # Limpia los archivos de compilación
    && apk del g++ make

WORKDIR /var/www/html

# Copia los archivos del proyecto (excluyendo vendor y node_modules)
COPY . .

# Copia las dependencias de Composer desde la etapa 'vendor'
COPY --from=vendor /app/vendor /var/www/html/vendor

# Desde la etapa 'node', copia los assets compilados por Vite (la carpeta 'build') a 'public'
COPY --from=node /app/public/build /var/www/html/public/build

# Permisos para el usuario web
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Comando de inicio: (Deja esto según tu configuración de Render)
# Si necesitas ejecutar Nginx y FPM en el mismo contenedor o si Render lo maneja
# Si usas Render, usualmente el comando de inicio es solo para FPM:
# CMD ["php-fpm"]