CREATE OR REPLACE FUNCTION obtenerNombreCompletoCliente(p_id_cliente NUMBER)
RETURN VARCHAR2
IS
    v_nombre_completo VARCHAR2(100);
BEGIN
    SELECT NOMBRE || ' ' || APELLIDO INTO v_nombre_completo
    FROM CLIENTES
    WHERE ID_CLIENTE = p_id_cliente;

    RETURN v_nombre_completo;
END;

CREATE OR REPLACE FUNCTION calcularPrecioConImpuesto(p_id_producto NUMBER, p_porcentaje_impuesto NUMBER)
RETURN NUMBER
IS
    v_precio NUMBER;
    v_precio_con_impuesto NUMBER;
BEGIN
    SELECT PRECIO INTO v_precio
    FROM PRODUCTOS
    WHERE ID_PRODUCTO = p_id_producto;

    v_precio_con_impuesto := v_precio + (v_precio * (p_porcentaje_impuesto / 100));

    RETURN v_precio_con_impuesto;
END;

CREATE OR REPLACE FUNCTION consultarDisponibilidadProducto(p_id_sucursal NUMBER, p_id_producto NUMBER)
RETURN NUMBER
IS
    v_cantidad NUMBER;
BEGIN
    SELECT CANTIDAD INTO v_cantidad
    FROM INVENTARIO
    WHERE ID_SUCURSAL = p_id_sucursal
    AND ID_PRODUCTO = p_id_producto;

    RETURN v_cantidad;
END;

CREATE OR REPLACE FUNCTION obtenerDescripcionCategoria(p_id_categoria NUMBER)
RETURN VARCHAR2
IS
    v_descripcion VARCHAR2(255);
BEGIN
    SELECT DESCRIPCION INTO v_descripcion
    FROM CATEGORIAS
    WHERE ID_CATEGORIA = p_id_categoria;

    RETURN v_descripcion;
END;

CREATE OR REPLACE FUNCTION obtenerDatosProveedor(p_id_proveedor NUMBER)
RETURN VARCHAR2
IS
    v_datos_proveedor VARCHAR2(200);
BEGIN
    SELECT NOMBRE || ', ' || CONTACTO INTO v_datos_proveedor
    FROM PROVEEDORES
    WHERE ID_PROVEEDOR = p_id_proveedor;

    RETURN v_datos_proveedor;
END;