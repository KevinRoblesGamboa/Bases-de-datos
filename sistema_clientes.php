<?php
session_start();


if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header('Location: login.php');
    exit;
}
// Suponiendo que tienes una sesión activa y los datos del usuario
$usuario = $_SESSION['usuario'];
$rol=$_SESSION['rol'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .welcome-message {
            margin-bottom: 20px;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
        }
        .user-info {
            font-size: 14px;
        }
        footer {
            background-color: #000000; /* Fondo negro */
            color: white; /* Texto blanco */
            padding: 30px 0; /* Aumento del padding para mayor espacio */
            text-align: center;
            width: 100%; /* Asegurar que ocupe todo el ancho */
            bottom: 0;
        }

        footer .social-icons {
            margin-top: 15px;
        }

        footer .social-icons a {
            color: white;
            margin: 0 20px; /* Más espacio entre los iconos */
            font-size: 30px; /* Aumento de tamaño de iconos */
            transition: color 0.3s ease;
        }

        footer .social-icons a:hover {
            color: #000000; /* Color de hover para los iconos */
        }

        .info-section, .clients-section, .stats-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        h2 {
            color: #000000; /* Color de los títulos */
        }

        .table {
            margin-top: 20px;
        }

        .product-carousel {
            margin-top: 20px;
            text-align: center;
        }

        .carousel-caption h5 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .carousel-caption p {
            font-size: 1rem;
            color: #fff;
        }
        .carousel-inner img {
            width: 100%; /* Fuerza todas las imágenes a ocupar el 100% del contenedor */
            height: 400px; /* Establece una altura uniforme */
            object-fit: cover; /* Ajusta la imagen sin distorsionar la relación de aspecto */
        }

        .carousel-inner img {
            width: 100%; /* Ocupa todo el ancho del contenedor */
            height: 600px; /* Incrementa la altura para un carrusel más grande */
            object-fit: cover; /* Ajusta la imagen sin distorsionarla, pero puede recortar */
        }

        @media (max-width: 768px) {
            .carousel-inner img {
                height: 400px; /* Reduce la altura en dispositivos pequeños */
            }
        }

        .navbar-brand {
            color: #28a745;
        }

    </style>
</head>
<body>

<!-- Navbar con menú y submenú -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://www.instagram.com/gamba.store/?hl=es-la">Gamba Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
      <li class="nav-item">
          <a class="nav-link active" href="http://localhost/Bases-de-datos/sistema_clientes.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/bases-de-datos/Productos/mostrar_inventario.php">Productos</a>
        </li>
          
        <?php
        
            // Variables de sesión (ejemplo)
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] =  $rol;
        ?>
        <li class="nav-item">
            <a class="nav-link active" href="http://localhost/bases-de-datos/Sucusal/mostrar_sucursal.php">Sucursales </a>
        </li>
        
      </ul>
    </div>
    <div class="d-flex align-items-center">
      <!-- Información de usuario -->
      <span class="user-info me-3"><?php echo "Correo: $usuario"; ?></span>
      <!-- Botón de salir -->
      <a href="logout.php" class="btn logout-btn">Salir</a>
    </div>
  </div>
</nav>
<body>

<!-- Mensaje de bienvenida -->
<div class="container">
    <h1 class="welcome-message">Bienvenido estimado cliente</h1>
    
    <!-- Sección de información general -->
    <section class="info-section">
        <h2>Bienvenidos a Gamba Store</h2>
        <p>En Gamba Store nos apasiona ofrecerte lo mejor en moda y estilo. Descubre nuestra amplia selección de ropa y zapatos de alta calidad, pensados ​​para brindarte comodidad, elegancia y tendencia en cada paso. Nos enorgullece ofrecer productos de las mejores marcas, con opciones para todos los gustos y estilos. Además, trabajamos constantemente para ofrecerte las últimas novedades en moda. ¡Explora nuestra tienda en línea y encuentra tus nuevos favoritos hoy mismo!</p>
    </section>

    <!-- Sección de clientes -->
    <section class="product-carousel">
        <h2>Productos Destacados</h2>
        <p>En Gamba Store siempre tenemos lo mejor para ti. Descubre nuestros productos más destacados, cuidadosamente seleccionados para ofrecerte lo último en moda y comodidad.</p>

        <!-- Carousel de productos -->
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Producto 1 -->
                <div class="carousel-item active">
                    <img 
                        src="https://static.nike.com/a/images/t_PDP_1280_v1/f_auto,q_auto:eco,u_126ab356-44d8-4a06-89b4-fcdcc8df0245,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/9fcc3257-f71e-436d-bc2b-aaa5377971d8/calzado-grandes-air-jordan-1-low-og-SR5bqn.png" 
                        alt="Producto 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Tenis</h5>
                        <p>Las mejores tenis para vos</p>
                    </div>
                </div>
                <!-- Producto 2 -->
                <div class="carousel-item">
                    <img src="https://i.pinimg.com/736x/bc/03/13/bc03134040fd512dd60030f64e059cc9.jpg" alt="Producto 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>T-Shirt</h5>
                        <p>Las mejores camisas para vos</p>
                    </div>
                </div>
                <!-- Producto 3 -->
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/800x400?text=Producto+3" alt="Producto 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Producto 3</h5>
                        <p>Descripción breve del producto 3.</p>
                    </div>
                </div>
            </div>
            <!-- Controles de navegación -->
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </section>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<!-- Footer con redes sociales y fondo negro -->
<footer>
    <p>&copy; 2024 Sistema de Clientes. Todos los derechos reservados.</p>
    <div class="social-icons">
        <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
        <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
