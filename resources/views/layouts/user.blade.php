<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <!-- Vite para los estilos y scripts del proyecto -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Carga de Font Awesome (Iconos) 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ9W1xBLFvYgXjtiAw/3T9jL6S3zF7B5p5E/A4T/8yLqFm9U4d4F8+8p7Y9kQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
    }

    a {
      text-decoration: none;
    }

    /* Estilo personalizado para el ícono/logo simulado */
    .logo-icon {
      display: inline-block;
      width: 24px;
      height: 24px;
      background-color: #0d6efd;
      /* Azul primario */
      border-radius: 3px;
      position: relative;
    }

    .logo-icon::before {
      content: "";
      position: absolute;
      top: 6px;
      left: 6px;
      width: 12px;
      height: 12px;
      border: 2px solid white;
      border-radius: 1px;
    }

    /* Estilo para las imágenes dentro de las tarjetas */
    .card-img-top-custom {
      height: 200px;
      /* Altura fija para uniformidad */
      object-fit: contain;
      /* Asegura que la imagen se vea completa sin cortar */
      background-color: #ffffff;
      /* Fondo blanco para las imágenes de productos */
      padding: 1rem;
    }

    /* Efecto hover profesional en la tarjeta */
    .product-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: none;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

    /* Estilo para el ícono de carrito (Mejora profesional) */
    .cart-icon-btn {
      color: #ffffff;
      /* Icono blanco */
      transition: color 0.2s;
      padding: 0.5rem;
      text-decoration: none;
      display: inline-block;
    }

    /* Estilo para el ícono de carrito (Mejora profesional) */
    .cart-icon-btn {
      color: #ffffff;
      /* Icono blanco */
      transition: color 0.2s;
      padding: 0.5rem;
      text-decoration: none;
      display: inline-block;
    }

    .cart-icon-btn:hover {
      color: #ffc107;
      /* Amarillo suave al pasar el ratón */
    }

    /* Estilo para la insignia de conteo del carrito */
    .cart-badge {
      font-size: 0.75rem;
      /* Tamaño un poco más legible */
      top: 0;
      right: -10px;
      /* Desplazado ligeramente hacia afuera */
      background-color: #dc3545 !important;
      /* Rojo fuerte para visibilidad */
      padding: 0.3em 0.5em;
      /* Padding para hacerlo más redondo */
    }
  </style>
</head>

<body>
  <!-- Header/Barra de Navegación del Dashboard -->
  @include('partials.header')

  <!-- Contenido de la página -->
  @yield('content')

  <!-- Footer -->
  @include('partials.footer')

</body>

</html>