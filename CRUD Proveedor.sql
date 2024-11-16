-- Crear proveedor
CREATE OR REPLACE PROCEDURE sp_create_proveedor (
    p_nombre VARCHAR2,
    p_contacto VARCHAR2,
    p_telefono VARCHAR2,
    p_direccion VARCHAR2
) AS
BEGIN
    INSERT INTO PROVEEDORES (NOMBRE, CONTACTO, TELEFONO, DIRECCION)
    VALUES (p_nombre, p_contacto, p_telefono, p_direccion);
END sp_create_proveedor;
/

-- Leer proveedor
CREATE OR REPLACE PROCEDURE sp_get_proveedor (
    p_id_proveedor NUMBER,
    p_nombre OUT VARCHAR2,
    p_contacto OUT VARCHAR2,
    p_telefono OUT VARCHAR2,
    p_direccion OUT VARCHAR2
) AS
BEGIN
    SELECT NOMBRE, CONTACTO, TELEFONO, DIRECCION
    INTO p_nombre, p_contacto, p_telefono, p_direccion
    FROM PROVEEDORES
    WHERE ID_PROVEEDOR = p_id_proveedor;
END sp_get_proveedor;
/

-- Actualizar proveedor
CREATE OR REPLACE PROCEDURE sp_update_proveedor (
    p_id_proveedor NUMBER,
    p_nombre VARCHAR2,
    p_contacto VARCHAR2,
    p_telefono VARCHAR2,
    p_direccion VARCHAR2
) AS
BEGIN
    UPDATE PROVEEDORES
    SET NOMBRE = p_nombre, CONTACTO = p_contacto, TELEFONO = p_telefono, 
        DIRECCION = p_direccion
    WHERE ID_PROVEEDOR = p_id_proveedor;
END sp_update_proveedor;
/

-- Eliminar proveedor
CREATE OR REPLACE PROCEDURE sp_delete_proveedor (
    p_id_proveedor NUMBER
) AS
BEGIN
    DELETE FROM PROVEEDORES WHERE ID_PROVEEDOR = p_id_proveedor;
END sp_delete_proveedor;
/