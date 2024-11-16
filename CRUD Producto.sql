-- Crear producto
CREATE OR REPLACE PROCEDURE sp_create_producto (
    p_nombre VARCHAR2,
    p_descripcion VARCHAR2,
    p_precio NUMBER,
    p_id_categoria NUMBER,
    p_id_proveedor NUMBER
) AS
BEGIN
    INSERT INTO PRODUCTOS (NOMBRE, DESCRIPCION, PRECIO, ID_CATEGORIA, ID_PROVEEDOR)
    VALUES (p_nombre, p_descripcion, p_precio, p_id_categoria, p_id_proveedor);
END sp_create_producto;
/

-- Leer producto
CREATE OR REPLACE PROCEDURE sp_get_producto (
    p_id_producto NUMBER,
    p_nombre OUT VARCHAR2,
    p_descripcion OUT VARCHAR2,
    p_precio OUT NUMBER,
    p_id_categoria OUT NUMBER,
    p_id_proveedor OUT NUMBER
) AS
BEGIN
    SELECT NOMBRE, DESCRIPCION, PRECIO, ID_CATEGORIA, ID_PROVEEDOR
    INTO p_nombre, p_descripcion, p_precio, p_id_categoria, p_id_proveedor
    FROM PRODUCTOS
    WHERE ID_PRODUCTO = p_id_producto;
END sp_get_producto;
/

-- Actualizar producto
CREATE OR REPLACE PROCEDURE sp_update_producto (
    p_id_producto NUMBER,
    p_nombre VARCHAR2,
    p_descripcion VARCHAR2,
    p_precio NUMBER,
    p_id_categoria NUMBER,
    p_id_proveedor NUMBER
) AS
BEGIN
    UPDATE PRODUCTOS
    SET NOMBRE = p_nombre, DESCRIPCION = p_descripcion, PRECIO = p_precio,
        ID_CATEGORIA = p_id_categoria, ID_PROVEEDOR = p_id_proveedor
    WHERE ID_PRODUCTO = p_id_producto;
END sp_update_producto;
/

-- Eliminar producto
CREATE OR REPLACE PROCEDURE sp_delete_producto (
    p_id_producto NUMBER
) AS
BEGIN
    DELETE FROM PRODUCTOS WHERE ID_PRODUCTO = p_id_producto;
END sp_delete_producto;
/