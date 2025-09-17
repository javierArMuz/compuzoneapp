<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>CompuzoneApp | Panel de Administración</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      padding: 40px;
    }

    h1 {
      color: #333;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      margin: 12px 0;
    }

    a {
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <h1>Bienvenido: Admin</h1>

  <!-- Enlaces de las rutas del panel de Admin -->
  <ul>
    <li><a href="{{ route('admin.products.index') }}">🛒 Productos</a></li>
    <li><a href="{{ route('admin.brands.index') }}">🏷️ Marcas</a></li>
    <li><a href="{{ route('admin.categories.index') }}">📂 Categorías</a></li>
  </ul>
</body>

</html>