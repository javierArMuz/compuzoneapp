<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CompuzoneApp | Admin</title>
	<!-- Vite para los estilos y scripts del proyecto -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<style>
		body {
			background-color: #f8f9fa;
			font-family: 'Inter', sans-serif;
			overflow-x: hidden;
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
		}

		#sidebar-wrapper.collapsed {
			min-width: 60px;
			max-width: 60px;
			overflow: hidden;
		}

		#sidebar-wrapper.collapsed .list-group-item span {
			display: none;
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
			background-color: transparent !important;
			border: none;
			color: rgba(255, 255, 255, 0.8) !important;
			padding: 1rem 1.5rem;
			transition: all 0.2s;
			display: flex;
			align-items: center;
			gap: 1rem;
		}

		.list-group-item:hover {
			color: #fff !important;
			background-color: rgba(255, 255, 255, 0.1) !important;
		}

		.hamburger-icon {
			cursor: pointer;
			padding: 0.5rem;
			border-radius: 0.25rem;
		}

		.hamburger-icon:hover {
			background-color: rgba(255, 255, 255, 0.1);
		}

		@media (min-width: 768px) {
			#sidebar-wrapper {
				min-width: 250px;
				max-width: 250px;
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
				<a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action" title="Productos">🛒 <span>Productos</span></a>
				<a href="{{ route('admin.brands.index') }}" class="list-group-item list-group-item-action" title="Marcas">🏷️ <span>Marcas</span></a>
				<a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action" title="Categorías">📂 <span>Categorías</span></a>
			</div>
		</div>

		<!-- Contenido de la página -->
		<div id="page-content-wrapper" class="flex-grow-1 p-4">
			<button class="btn btn-secondary d-md-none" onclick="toggleSidebar()">☰</button>
			<div class="container-fluid">
				@yield('content')
			</div>
		</div>
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
				// Remove previous listeners to prevent duplicates
				sidebar.removeEventListener('mouseenter', expandSidebar);
				sidebar.removeEventListener('mouseleave', collapseSidebar);
				hamburgerDesktop.removeEventListener('click', toggleToggledClass);

				// Add listeners for desktop mode
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

			// Initial check on page load
			if (window.innerWidth >= 768) {
				setupDesktopListeners();
				sidebar.classList.add('collapsed');
			}

			// Update listeners on window resize
			window.addEventListener('resize', function() {
				if (window.innerWidth >= 768) {
					setupDesktopListeners();
				} else {
					// Clean up desktop listeners when resizing to mobile
					sidebar.removeEventListener('mouseenter', expandSidebar);
					sidebar.removeEventListener('mouseleave', collapseSidebar);
					hamburgerDesktop.removeEventListener('click', toggleToggledClass);
				}
			});
		});
	</script>
</body>

</html>