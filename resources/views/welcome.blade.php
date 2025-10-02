<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Vite para los estilos y scripts del proyecto -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
	<div class="">
		<header class="mx-4">
			<nav class="navbar bg-body-tertiary fixed-top">
				{{-- Cierre de inicio de sesión temporal --}}
				<a
					href="{{ route('auth.temp_logout') }}"
					class="btn btn-danger">
					Cerrar Sesión
				</a>
			</nav>
		</header>

		<main class="mt-5">
			<h1 class="">Bienvenido</h1>
			{{-- Muestra mensaje de éxito al iniciar sesión --}}
			@if(session('success'))
			<div class="alert alert-success" role="alert">
				{{ session('success') }}
			</div>
			@endif
		</main>
	</div>
</body>

</html>