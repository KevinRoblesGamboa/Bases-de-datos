-- Crear carrito
CREATE OR REPLACE PROCEDURE sp_create_carrito (
    p_id_cliente NUMBER,
    p_total NUMBER,
    p_fecha DATE
) AS
BEGIN
    INSERT INTO CARRITO (ID_CLIENTE, TOTAL, FECHA)
    VALUES (p_id_cliente, p_total, p_fecha);
END sp_create_carrito;
/

-- Leer carrito
CREATE OR REPLACE PROCEDURE sp_get_carrito (
    p_id_carrito NUMBER,
    p_id_cliente OUT NUMBER,
    p_total OUT NUMBER,
    p_fecha OUT DATE
) AS
BEGIN
    SELECT ID_CLIENTE, TOTAL, FECHA
    INTO p_id_cliente, p_total, p_fecha
    FROM CARRITO
    WHERE ID_CARRITO = p_id_carrito;
END sp_get_carrito;
/

-- Actualizar carrito
CREATE OR REPLACE PROCEDURE sp_update_carrito (
    p_id_carrito NUMBER,
    p_id_cliente NUMBER,
    p_total NUMBER,
    p_fecha DATE
) AS
BEGIN
    UPDATE CARRITO
    SET ID_CLIENTE = p_id_cliente, TOTAL = p_total, FECHA = p_fecha
    WHERE ID_CARRITO = p_id_carrito;
END sp_update_carrito;
/

-- Eliminar carrito
CREATE OR REPLACE PROCEDURE sp_delete_carrito (
    p_id_carrito NUMBER
) AS
BEGIN
    DELETE FROM CARRITO WHERE ID_CARRITO = p_id_carrito;
END sp_delete_carrito;
/