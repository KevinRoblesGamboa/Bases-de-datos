<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>/styles.css"> <!-- Ruta corregida -->

</head>
<body>
    <div class="navbar">
        <a href="<?php echo BASE_PATH; ?>/navbar.html">Inicio</a> <!-- Botón de Inicio -->
        <div class="dropdown">
          <button class="dropbtn">Clientes 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="<?php echo BASE_PATH; ?>/Cliente/insertar_clientes.php">Insertar Clientes</a>
            <a href="<?php echo BASE_PATH; ?>/Cliente/mostrar_clientes.php">Mostrar Clientes</a>
          </div>
        </div> 
        <div class="dropdown">
          <button class="dropbtn">Empleados 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="<?php echo BASE_PATH; ?>/Empleado/insertar_empleados.php">Insertar Empleados</a>
            <a href="<?php echo BASE_PATH; ?>/Empleado/mostrar_empleados.php">Mostrar Empleados</a>
          </div>
        </div> 
        <div class="dropdown">
          <button class="dropbtn">Productos 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="<?php echo BASE_PATH; ?>/Productos/insertar_productos.php">Insertar Productos</a>
            <a href="<?php echo BASE_PATH; ?>/Productos/mostrar_inventario.php">Mostrar Productos</a>
          </div>
        </div>
        <div class="dropdown">
          <button class="dropbtn">Sucursales 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="<?php echo BASE_PATH; ?>/Sucusal/insertar_sucursal.php">Insertar Sucursales</a>
            <a href="<?php echo BASE_PATH; ?>/Sucusal/mostrar_sucursal.php">Mostrar Sucursales</a>
          </div>
        </div> 
        <div class="dropdown">
          <button class="dropbtn">Proveedores 
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="<?php echo BASE_PATH; ?>/Proveedor/insertar_proveedor.php">Insertar Proveedores</a>
            <a href="<?php echo BASE_PATH; ?>/Proveedor/mostrar_proveedor.php">Mostrar Proveedores</a>
          </div>
        </div>
    </div>
</body>
</html>
