-- Procedimiento para crear un cliente
CREATE OR REPLACE PROCEDURE sp_create_cliente (
    p_nombre VARCHAR2,
    p_apellido VARCHAR2,
    p_email VARCHAR2,
    p_direccion VARCHAR2,
    p_telefono VARCHAR2
) AS
BEGIN
    INSERT INTO CLIENTES (NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO)
    VALUES (p_nombre, p_apellido, p_email, p_direccion, p_telefono);
END;
/

-- Procedimiento para leer clientes
CREATE OR REPLACE PROCEDURE sp_get_cliente (
    p_id_cliente NUMBER,
    p_nombre OUT VARCHAR2,
    p_apellido OUT VARCHAR2,
    p_email OUT VARCHAR2,
    p_direccion OUT VARCHAR2,
    p_telefono OUT VARCHAR2
) AS
BEGIN
    SELECT NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO
    INTO p_nombre, p_apellido, p_email, p_direccion, p_telefono
    FROM CLIENTES
    WHERE ID_CLIENTE = p_id_cliente;
END;
/

-- Procedimiento para actualizar un cliente
CREATE OR REPLACE PROCEDURE sp_update_cliente (
    p_id_cliente NUMBER,
    p_nombre VARCHAR2,
    p_apellido VARCHAR2,
    p_email VARCHAR2,
    p_direccion VARCHAR2,
    p_telefono VARCHAR2
) AS
BEGIN
    UPDATE CLIENTES
    SET NOMBRE = p_nombre, APELLIDO = p_apellido, EMAIL = p_email,
        DIRECCION = p_direccion, TELEFONO = p_telefono
    WHERE ID_CLIENTE = p_id_cliente;
END;
/

-- Procedimiento para eliminar un cliente
CREATE OR REPLACE PROCEDURE sp_delete_cliente (
    p_id_cliente NUMBER
) AS
BEGIN
    DELETE FROM CLIENTES WHERE ID_CLIENTE = p_id_cliente;
END;
/