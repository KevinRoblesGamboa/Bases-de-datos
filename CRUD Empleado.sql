-- Crear empleado
CREATE OR REPLACE PROCEDURE sp_create_empleado (
    p_nombre VARCHAR2,
    p_apellido VARCHAR2,
    p_telefono VARCHAR2,
    p_id_sucursal NUMBER
) AS
BEGIN
    INSERT INTO EMPLEADOS (NOMBRE, APELLIDO, TELEFONO, ID_SUCURSAL)
    VALUES (p_nombre, p_apellido, p_telefono, p_id_sucursal);
END sp_create_empleado;
/

-- Leer empleado
CREATE OR REPLACE PROCEDURE sp_get_empleado (
    p_id_empleado NUMBER,
    p_nombre OUT VARCHAR2,
    p_apellido OUT VARCHAR2,
    p_telefono OUT VARCHAR2,
    p_id_sucursal OUT NUMBER
) AS
BEGIN
    SELECT NOMBRE, APELLIDO, TELEFONO, ID_SUCURSAL
    INTO p_nombre, p_apellido, p_telefono, p_id_sucursal
    FROM EMPLEADOS
    WHERE ID_EMPLEADO = p_id_empleado;
END sp_get_empleado;
/

-- Actualizar empleado
CREATE OR REPLACE PROCEDURE sp_update_empleado (
    p_id_empleado NUMBER,
    p_nombre VARCHAR2,
    p_apellido VARCHAR2,
    p_telefono VARCHAR2,
    p_id_sucursal NUMBER
) AS
BEGIN
    UPDATE EMPLEADOS
    SET NOMBRE = p_nombre, APELLIDO = p_apellido, TELEFONO = p_telefono,
        ID_SUCURSAL = p_id_sucursal
    WHERE ID_EMPLEADO = p_id_empleado;
END sp_update_empleado;
/

-- Eliminar empleado
CREATE OR REPLACE PROCEDURE sp_delete_empleado (
    p_id_empleado NUMBER
) AS
BEGIN
    DELETE FROM EMPLEADOS WHERE ID_EMPLEADO = p_id_empleado;
END sp_delete_empleado;
/