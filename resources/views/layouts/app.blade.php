<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        body {
            font-family: 'Bebas Neue', sans-serif;
            background-color:rgba(27, 27, 27, 0.84); /* Blue background */
        }

        .navbar {
            background-color: #111; /* Dark background for navbar */
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-link {
            color: white !important;
        }

        .logo {
            width: 120px;
            height: auto;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: white;
            font-size: 4rem;
            font-weight: bold;
        }

        .saludo {
            color: white;
            font-weight: bold;
            font-size: 3rem;
        }

        .container {
            margin: 0 auto; /* Center container */
            max-width: 1200px; /* Max width for larger screens */
            padding: 20px; /* Padding around container */
        }

        button {
            background-color:rgb(230, 117, 113); /* Green button */
            transition: background-color 0.3s; /* Smooth transition */
            color: #ffffff; /* White text */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            padding: 10px 20px; /* Padding */
            cursor: pointer; /* Pointer cursor on hover */
        }

    </style>
</head>
<body>

    <!-- Barra de navegación superior -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('storage/images/logotback.png') }}" alt="SportHub Logo" class="logo me-2">
                SportHub
            </a>

            <span class="saludo" style="text-align: center; flex-grow: 1; display: flex; justify-content: center;">
                @auth
                    Hola, {{ auth()->user()->name }}!
                @else
                    Hola, Invitado!
                @endauth
            </span>

            @auth
                <form action="{{ route('logout') }}" method="POST" class="d-inline" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="logout-button">
                        Cerrar Sesión
                        <div class="sign">
                            <svg viewBox="0 0 512 512">
                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                            </svg>
                        </div>
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Contenido dinámico -->
    <div class="container mt-5">
        @yield('content')
    </div>
</body>
</html>
