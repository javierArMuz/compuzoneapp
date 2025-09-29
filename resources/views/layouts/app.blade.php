<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title')</title>
	<!-- Vite para los estilos y scripts del proyecto -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<!-- Font Awesome (Iconos) -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" xintegrity="sha512-1ycn6IcaQQ40N8S3aWlD6ZIz8w4P5+u2I8v6Iu2Z9j+d+2g0/s+G/tF/Xz8uN/E/D5L/1i/jM/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<style>
		body {
			background-color: #f8f9fa;
			font-family: 'Inter', sans-serif;
			overflow-x: hidden;
		}

		a {
			text-decoration: none;
		}

		#wrapper {
			display: flex;
			min-height: 100vh;
		}

		#sidebar-wrapper {
			background-color: #343a40;
			color: white;
			transition: all 0.3s ease-in-out;
			box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);

			&.collapsed {
				min-width: 60px;
				max-width: 60px;
				overflow: hidden;

				.list-group-item span {
					display: none;
				}
			}
		}

		.sidebar-heading {
			padding: 1.5rem 1rem;
			text-align: center;
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		#sidebar-wrapper.collapsed .sidebar-heading h5 {
			display: none;
		}

		.list-group-item {
			background-color: transparent;
			border: none;
			color: rgba(255, 255, 255, 0.8);
			padding: 1rem 1.5rem;
			transition: all 0.2s;
			display: flex;
			align-items: center;
			gap: 1rem;

			&:hover {
				color: #fff !important;
				background-color: rgba(255, 255, 255, 0.1) !important;
			}
		}

		.hamburger-icon {
			cursor: pointer;
			padding: 0.5rem;
			border-radius: 0.25rem;

			&:hover {
				background-color: rgba(255, 255, 255, 0.1);
			}
		}

		@media (min-width: 768px) {
			#sidebar-wrapper {
				min-width: 155px;
				max-width: 155px;
			}
		}

		@media (max-width: 767px) {
			#sidebar-wrapper {
				transform: translateX(-100%);
				position: fixed;
				top: 0;
				left: 0;
				height: 100vh;
				z-index: 999;
				min-width: 250px;
				max-width: 250px;
			}

			#wrapper.toggled #sidebar-wrapper {
				transform: translateX(0);

			}

			#page-content-wrapper {
				width: 100%;
				transition: all 0.3s ease-in-out;
			}

			#wrapper.toggled #page-content-wrapper {
				transform: translateX(50px);
			}

			.hamburger-icon {
				display: none;
			}
		}
	</style>
</head>

<body>
	<div class="d-flex" id="wrapper">
		<!-- Sidebar -->
		<div id="sidebar-wrapper" class="collapsed">
			<div class="sidebar-heading d-flex justify-content-between align-items-center">
				<div class="hamburger-icon" id="hamburger-desktop">☰</div>
				<h5 class="my-0">Admin</h5>
			</div>
			<div class="list-group list-group-flush">
				<a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action" title="Home"><i class="fas fa-home"></i></a>
				<a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action" title="Productos"><i class="fas fa-box"></i><span>Productos</span></a>
				<a href="{{ route('admin.brands.index') }}" class="list-group-item list-group-item-action" title="Marcas"><i class="fas fa-tags"></i><span>Marcas</span></a>
				<a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action" title="Categorías"><i class="fas fa-folder"></i><span>Categorías</span></a>
				<a href="#"
					title="Cerrar"
					class="list-group-item"
					onclick="event.preventDefault(); if (confirm('¿Estás seguro de que quieres cerrar la sesión?')) { document.getElementById('logout-form').submit(); }">
					<i class="fas fa-sign-out-alt"></i><span>Cerrar</span>
				</a>
			</div>
		</div>

		<!-- Contenido de la página -->
		<div id="page-content-wrapper" class="flex-grow-1 p-4">
			<button class="btn btn-secondary d-md-none" onclick="toggleSidebar()">☰</button>
			<div class="container-fluid">
				@yield('content')
			</div>
		</div>

		<!-- Formulario oculto de cerrar de sesión-->
		<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
			@csrf
		</form>
	</div>

	<script>
		function toggleSidebar() {
			const wrapper = document.getElementById('wrapper');
			wrapper.classList.toggle('toggled');
		}

		document.addEventListener('DOMContentLoaded', function() {
			const sidebar = document.getElementById('sidebar-wrapper');
			const hamburgerDesktop = document.getElementById('hamburger-desktop');
			const wrapper = document.getElementById('wrapper');

			function setupDesktopListeners() {
				// Eliminar EventListener anteriores para evitar duplicados
				sidebar.removeEventListener('mouseenter', expandSidebar);
				sidebar.removeEventListener('mouseleave', collapseSidebar);
				hamburgerDesktop.removeEventListener('click', toggleToggledClass);

				// Agregar EventListener para el modo de escritorio
				sidebar.addEventListener('mouseenter', expandSidebar);
				sidebar.addEventListener('mouseleave', collapseSidebar);
				hamburgerDesktop.addEventListener('click', toggleToggledClass);
			}

			function expandSidebar() {
				sidebar.classList.remove('collapsed');
			}

			function collapseSidebar() {
				if (!wrapper.classList.contains('toggled')) {
					sidebar.classList.add('collapsed');
				}
			}

			function toggleToggledClass() {
				wrapper.classList.toggle('toggled');
			}

			// Comprobación inicial de la carga de la página
			if (window.innerWidth >= 768) {
				setupDesktopListeners();
				sidebar.classList.add('collapsed');
			}

			// Actualizar los EventListener al cambiar el tamaño de la ventana
			window.addEventListener('resize', function() {
				if (window.innerWidth >= 768) {
					setupDesktopListeners();
				} else {
					// Limpie los EventListener de escritorio al cambiar el tamaño a dispositivos móviles
					sidebar.removeEventListener('mouseenter', expandSidebar);
					sidebar.removeEventListener('mouseleave', collapseSidebar);
					hamburgerDesktop.removeEventListener('click', toggleToggledClass);
				}
			});
		});
	</script>
</body>

</html>