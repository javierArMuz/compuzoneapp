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
            background-color: #f8f9fa; /* bg-light de Bootstrap */
            font-family: 'Inter', sans-serif;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar-wrapper {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40; /* bg-dark de Bootstrap */
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

        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: -250px;
            }
            #sidebar-wrapper.toggled {
                margin-left: 0;
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
    </style>
</head>
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper" class="collapsed">
        <div class="sidebar-heading d-none d-md-flex justify-content-between align-items-center">
            <h5 class="my-0">Admin</h5>
            <div class="hamburger-icon" id="hamburger-desktop">☰</div>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">🛒 <span>Productos</span></a>
            <a href="{{ route('admin.brands.index') }}" class="list-group-item list-group-item-action">🏷️ <span>Marcas</span></a>
            <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action">📂 <span>Categorías</span></a>
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
        const sidebar = document.getElementById('sidebar-wrapper');
        sidebar.classList.toggle('toggled');
    }

    const sidebar = document.getElementById('sidebar-wrapper');
    const hamburgerIcon = document.getElementById('hamburger-desktop');
    
    if (window.innerWidth >= 768) {
        // Lógica para expandir/contraer al pasar el cursor
        sidebar.addEventListener('mouseenter', function() {
            sidebar.classList.remove('collapsed');
        });

        sidebar.addEventListener('mouseleave', function() {
            // El menú se contrae solo si no está en estado "fijado" (toggled)
            if (!sidebar.classList.contains('toggled')) {
                sidebar.classList.add('collapsed');
            }
        });

        // Lógica para fijar/desfijar el menú con un clic
        hamburgerIcon.addEventListener('click', function() {
            sidebar.classList.toggle('toggled');
            if (sidebar.classList.contains('toggled')) {
                sidebar.classList.remove('collapsed');
            } else {
                sidebar.classList.add('collapsed');
            }
        });
    }
</script>
</body>