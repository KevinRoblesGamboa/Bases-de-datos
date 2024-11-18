-- Crear orden
CREATE OR REPLACE PROCEDURE sp_create_orden (
    p_id_cliente NUMBER,
    p_id_empleado NUMBER,
    p_fecha DATE,
    p_total NUMBER
) AS
BEGIN
    INSERT INTO ORDENES (ID_CLIENTE, ID_EMPLEADO, FECHA, TOTAL)
    VALUES (p_id_cliente, p_id_empleado, p_fecha, p_total);
END sp_create_orden;
/

-- Leer orden
CREATE OR REPLACE PROCEDURE sp_get_orden (
    p_id_orden NUMBER,
    p_id_cliente OUT NUMBER,
    p_id_empleado OUT NUMBER,
    p_fecha OUT DATE,
    p_total OUT NUMBER
) AS
BEGIN
    SELECT ID_CLIENTE, ID_EMPLEADO, FECHA, TOTAL
    INTO p_id_cliente, p_id_empleado, p_fecha, p_total
    FROM ORDENES
    WHERE ID_ORDEN = p_id_orden;
END sp_get_orden;
/

-- Actualizar orden
CREATE OR REPLACE PROCEDURE sp_update_orden (
    p_id_orden NUMBER,
    p_id_cliente NUMBER,
    p_id_empleado NUMBER,
    p_fecha DATE,
    p_total NUMBER
) AS
BEGIN
    UPDATE ORDENES
    SET ID_CLIENTE = p_id_cliente, ID_EMPLEADO = p_id_empleado,
        FECHA = p_fecha, TOTAL = p_total
    WHERE ID_ORDEN = p_id_orden;
END sp_update_orden;
/

-- Eliminar orden
CREATE OR REPLACE PROCEDURE sp_delete_orden (
    p_id_orden NUMBER
) AS
BEGIN
    DELETE FROM ORDENES WHERE ID_ORDEN = p_id_orden;
END sp_delete_orden;
/