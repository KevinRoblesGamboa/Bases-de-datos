<DOCTYPE HTML>
<meta charset = "utf8" />
<?php
        // Configuración de la conexión a la base de datos
        $host = 'localhost';
        $puerto = '1521'; // Cambia si usas un puerto diferente
        $sid = 'ORCL'; // SID de la base de datos Oracle
        $usuario = 'c##ANDERSON'; // Usuario de la base de datos
        $contraseña = '12345'; // Contraseña del usuario

        // Crear la conexión
        $conn = oci_connect($usuario, $contraseña, "$host:$puerto/$sid");

        if ($conn) {
            echo "Conexión a la base de datos realizada con éxito.";
        } else {
            $e = oci_error();
            echo "<div class='error'>Error al conectar con la base de datos: " . htmlentities($e['message']) . "</div>";
            exit;
        }
        ?>