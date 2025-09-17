# 🖥️ Compuzoneapp

Sistema web desarrollado en Laravel para la gestión de productos, marcas y categorías, como parte de la evidencia GA7-220501096-AA3-EV01 del programa Tecnológico en Desarrollo de Software — SENA.

---

## 📌 Objetivo del proyecto

Implementar un sistema modular que permita administrar productos, marcas y categorías con validación, relaciones entre tablas, y documentación técnica formal. El proyecto cumple con los estándares académicos y técnicos exigidos por el programa formativo.

---

## ⚙️ Requisitos del sistema

- PHP >= 8.2.12
- Composer
- MySQL / MariaDB
- Laravel >= 12.28.1
- XAMPP / Laragon (entorno local recomendado)

---

## 🚀 Instalación del proyecto

```bash
# Clonar el repositorio
git clone https://github.com/javierArMuz/compuzoneapp.git

# Acceder al directorio
cd compuzoneapp

# Instalar dependencias
composer install

# Copiar archivo de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Configurar base de datos en .env
DB_DATABASE=order_compuzoneapp
DB_USERNAME=root
DB_PASSWORD=

# Ejecutar migraciones
php artisan migrate

# Iniciar servidor local
php artisan serve
