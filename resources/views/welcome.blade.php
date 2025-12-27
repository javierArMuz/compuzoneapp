<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CompuzoneApp | Inicio</title>
	<link rel="icon" type="image/png" href="{{ asset('assets/faviconCompuzone.png')}}">

	<!-- Carga de Bootstrap 5 CSS -->
	<!-- Vite para los estilos y scripts del proyecto -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])

	<!-- Carga de Font Awesome 6 (Recomendado) -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ9W1xBLFvYgXjtiAw/3T9jL6S3zF7B5p5E/A4T/8yLqFm9U4d4F8+8p7Y9kQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<style>
		/* Estilo personalizado para el ícono/logo simulado (similar al anterior, adaptado a Bootstrap) */
		.logo-icon {
			/* Simula el ícono de una placa base o chip */
			display: inline-block;
			width: 24px;
			height: 24px;
			background-color: #0d6efd;
			/* Color azul primario de Bootstrap */
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

		/* Asegura que el body use toda la altura disponible */
		html,
		body {
			height: 100%;
		}

		/* Flexbox para centrar el contenido principal */
		.main-content {
			flex-grow: 1;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		/* Estilo específico para el botón de Admin para diferenciarlo */
		.btn-admin {
			background-color: #6c757d;
			/* Gris oscuro para Admin */
			border-color: #6c757d;
			color: white;
		}

		.btn-admin:hover {
			background-color: #5a6268;
			border-color: #545b62;
			color: white;
		}
	</style>
</head>

<body class="bg-light min-vh-100 d-flex flex-column font-sans">

	<!-- 1. Header/Barra de Navegación con Bootstrap Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
		<div class="container-fluid container-lg">

			<!-- Logo y Nombre de la Aplicación -->
			<a class="navbar-brand d-flex align-items-center" href="#">
				<!-- <span class="logo-icon me-2"></span> -->
				<img src="{{ asset('assets/logoCompuzone.png') }}" width="35" alt="Logo Compuzone">
				<span class="h5 m-0 text-dark fw-bold">CompuzoneApp</span>
			</a>

			<!-- Grupo de Íconos de Sesión -->
			<div class="d-flex align-items-center gap-2">
				<!-- 1. Ícono de Registro (Nuevo Usuario) -->
				<a href="{{ route('auth.register') }}" class="btn btn-sm btn-outline-info rounded-pill px-3 py-1 d-none d-sm-block" aria-label="Registrar Nuevo Usuario">
					<i class="fa-solid fa-user-plus me-1"></i>
					Registro
				</a>

				<!-- 2. Ícono de Inicio de Sesión (Usuario Estándar) -->
				<a href="{{ route('auth.login') }}" class="btn btn-outline-primary rounded-circle p-2" aria-label="Iniciar Sesión de Usuario">
					<!-- Icono de Usuario de Font Awesome -->
					<i class="fa-solid fa-user fa-lg"></i>
				</a>

				<!-- 3. Ícono de Inicio de Sesión (Admin) -->
				<a href="{{ route('admin.login') }}" class="btn btn-admin rounded-circle p-2" aria-label="Iniciar Sesión de Administrador">
					<!-- Icono de Candado/Admin de Font Awesome -->
					<i class="fa-solid fa-shield-alt fa-lg"></i>
				</a>
			</div>

		</div>
	</nav>

	<!-- 2. Contenido Principal / Mensaje de Bienvenida -->
	<main class="main-content p-4">
		<div class="text-center">
			<div class="card shadow-lg border-0 mx-auto p-4 p-md-5" style="max-width: 600px;">
				<h2 class="display-5 fw-bold text-dark mb-3">
					¡Bienvenido a CompuzoneApp!
				</h2>
				<p class="lead text-secondary mb-4">
					Tu plataforma integral para la gestión de inventario y ventas de productos tecnológicos.
				</p>
				<p class="text-muted">
					Usa los iconos de la esquina superior derecha para iniciar sesión o registrarte.
				</p>
				<a href="#" class="btn btn-primary btn-lg mt-3 shadow-sm rounded-pill">Explorar Productos</a>
			</div>
		</div>
	</main>

	<!-- 3. Footer -->
	<footer class="bg-dark text-white p-3 text-center mt-auto">
		<p class="text-sm m-0">© <script>
				document.write(new Date().getFullYear())
			</script> CompuzoneApp. Todos los derechos reservados.</p>
	</footer>

	<!-- Carga de Bootstrap JS (opcional para navbars y dropdowns, pero buena práctica) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>