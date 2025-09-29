<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <!-- Vite para los estilos y scripts del proyecto -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <section class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
      @yield('content')
    </div>
  </section>

</body>

</html>