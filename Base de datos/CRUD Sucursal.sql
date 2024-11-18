-- Crear sucursal
CREATE OR REPLACE PROCEDURE sp_create_sucursal (
    p_nombre VARCHAR2,
    p_direccion VARCHAR2,
    p_telefono VARCHAR2
) AS
BEGIN
    INSERT INTO SUCURSALES (NOMBRE, DIRECCION, TELEFONO)
    VALUES (p_nombre, p_direccion, p_telefono);
END sp_create_sucursal;
/

-- Leer sucursal
CREATE OR REPLACE PROCEDURE sp_get_sucursal (
    p_id_sucursal NUMBER,
    p_nombre OUT VARCHAR2,
    p_direccion OUT VARCHAR2,
    p_telefono OUT VARCHAR2
) AS
BEGIN
    SELECT NOMBRE, DIRECCION, TELEFONO
    INTO p_nombre, p_direccion, p_telefono
    FROM SUCURSALES
    WHERE ID_SUCURSAL = p_id_sucursal;
END sp_get_sucursal;
/

-- Actualizar sucursal
CREATE OR REPLACE PROCEDURE sp_update_sucursal (
    p_id_sucursal NUMBER,
    p_nombre VARCHAR2,
    p_direccion VARCHAR2,
    p_telefono VARCHAR2
) AS
BEGIN
    UPDATE SUCURSALES
    SET NOMBRE = p_nombre, DIRECCION = p_direccion, TELEFONO = p_telefono
    WHERE ID_SUCURSAL = p_id_sucursal;
END sp_update_sucursal;
/

-- Eliminar sucursal
CREATE OR REPLACE PROCEDURE sp_delete_sucursal (
    p_id_sucursal NUMBER
) AS
BEGIN
    DELETE FROM SUCURSALES WHERE ID_SUCURSAL = p_id_sucursal;
END sp_delete_sucursal;
/