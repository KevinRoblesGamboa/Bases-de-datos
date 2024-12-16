<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
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
        .navbar-brand {
    color: #28a745;
}

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://www.instagram.com/gamba.store/?hl=es-la">Gamba Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/Bases-de-datos/sistema_gestion_tienda.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="http://localhost/Bases-de-datos/categorias.php">Categorias</a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Productos
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Productos/insertar_productos.php">Agregar productos</a></li>
            <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Productos/mostrar_inventario.php">Mostrar inventario</a></li>
            <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Productos/actualizar_producto.php">Actualizar producto</a></li>
        </ul>
    </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sucursales
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Agregar Sucursales</a></li>
            <li><a class="dropdown-item" href="#">Mostrar Sucursales</a></li>
            <li><a class="dropdown-item" href="#">Actualizar Sucursales</a></li>
          </ul>
          </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Clientes
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Cliente/actualizar_cliente.php">Actualizar clientes</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Cliente/mostrar_clientes.php">Mostrar clientes</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Cliente/insertar_clientes.php">Insertar clientesliente</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Empleados
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Empleado/actualizar_empleado.php">Actualizar empleados</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Empleado/mostrar_empleados.php">Mostrar empleados</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Empleado/insertar_empleados.php">Insertar empleados</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Proveedores
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Proveedor/actualizar_proveedor.php">Actualizar proveedor</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Proveedor/mostrar_proveedor.php">Mostrar proveedor</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Proveedor/insertar_proveedor.php">Insertar proveedor</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Sucursales
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Sucursal/actualizar_sucursal.php">Actualizar sucursal</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Sucursal/mostrar_sucursal.php">Mostrar sucursal</a></li>
                <li><a class="dropdown-item" href="http://localhost/Bases-de-datos/Sucursal/insertar_sucursal.php">Insertar sucursal</a></li>
            </ul>
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

<!-- Mensaje de bienvenida -->
<div class="container">
    <h1>Bienvenido al sistema de gestión de tienda estimado Administrador.</h1>
    
    <!-- Sección de información general -->
    <section class="info-section">
        <h2>Información General para el Administrador</h2>
        <p>En esta sección, encontrarás herramientas para gestionar todos los aspectos importantes de la tienda, incluyendo la actualización de productos, la gestión de inventarios y el control de clientes.

Es esencial que, como administrador, maneje los datos de la empresa de manera responsable y segura. Los datos relacionados con nuestros productos, ventas, inventarios y clientes deben ser tratados con la máxima confidencialidad y de acuerdo con las políticas internas de protección de datos.</p>
    </section>

        <!-- Carousel de productos -->
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Producto 1 -->
                <div class="carousel-item active">
                    <img src="https://via.placeholder.com/800x400?text=Producto+1" class="d-block w-100" alt="Producto 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Producto 1</h5>
                        <p>Descripción breve del producto 1.</p>
                    </div>
                </div>
                <!-- Producto 2 -->
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/800x400?text=Producto+2" class="d-block w-100" alt="Producto 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Producto 2</h5>
                        <p>Descripción breve del producto 2.</p>
                    </div>
                </div>
                <!-- Producto 3 -->
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/800x400?text=Producto+3" class="d-block w-100" alt="Producto 3">
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

