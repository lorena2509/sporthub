<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Fuente Bebas Neue de Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        /* From Uiverse.io by vinodjangid07 */ 
.Btnn {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 45px;
  height: 45px;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition-duration: .3s;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
  background-color: rgb(255, 65, 65);
}

/* plus sign */
.sign {
  width: 100%;
  transition-duration: .3s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.sign svg {
  width: 17px;
}

.sign svg path {
  fill: white;
}
/* text */
.text {
  position: absolute;
  right: 0%;
  width: 0%;
  opacity: 0;
  color: white;
  font-size: 1.2em;
  font-weight: 600;
  transition-duration: .3s;
}
/* hover effect on button width */
.Btn:hover {
  width: 125px;
  border-radius: 40px;
  transition-duration: .3s;
}

.Btn:hover .sign {
  width: 30%;
  transition-duration: .3s;
  padding-left: 20px;
}
/* hover effect button's text */
.Btn:hover .text {
  opacity: 1;
  width: 70%;
  transition-duration: .3s;
  padding-right: 10px;
}
/* button click effect*/
.Btn:active {
  transform: translate(2px ,2px);
}

        /* Fuente general para el sitio */
        body {
            font-family: 'Bebas Neue', sans-serif;
        }

        .navbar {
            background-color: #111;
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

        .navbar .container-fluid {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .navbar .saludo {
            color: white;
            font-weight: bold;
            font-size: 3rem;
        }

        /* Cuando el usuario NO ha iniciado sesión, el saludo se alinea a la derecha */
        .navbar.no-buttons .saludo {
            margin-left: auto; /* Empuja el saludo hacia la derecha */
        }

        /* Botones con mismo tamaño de fuente */
        .btn {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-outline-light, .btn-danger {
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación superior -->
    <nav class="navbar navbar-expand-lg @guest no-buttons @endguest">
        <div class="container-fluid">
            
            <!-- Logo y nombre de la empresa -->
            <a class="navbar-brand" href="{{ route('home') }}" style="transition: font-size 0.3s; color: white;">
                <img src="{{ asset('storage/images/logotback.png') }}" alt="SportHub Logo" class="logo me-2">
                SportHub
            </a>

            <!-- Saludo alineado dinámicamente -->
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
<button type="submit" class="Btnn">                        <!-- Icono SVG para el botón -->
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
