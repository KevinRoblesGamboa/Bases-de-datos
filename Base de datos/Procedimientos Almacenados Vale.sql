//Crear un envio
CREATE OR REPLACE PROCEDURE sp_create_envio (
    p_id_orden NUMBER,
    p_estado VARCHAR2,
    p_fecha_entrega_estimada DATE,
    p_direccion_envio VARCHAR2
) AS
BEGIN
    INSERT INTO ENVIOS (ID_ORDEN, ESTADO, FECHA_ENTREGA_ESTIMADA, DIRECCION_ENVIO)
    VALUES (p_id_orden, p_estado, p_fecha_entrega_estimada, p_direccion_envio);
END sp_create_envio;
/

//Obtener un envio
CREATE OR REPLACE PROCEDURE sp_get_envio (
    p_id_envio NUMBER,
    p_id_orden OUT NUMBER,
    p_estado OUT VARCHAR2,
    p_fecha_envio OUT DATE,
    p_fecha_entrega_estimada OUT DATE,
    p_direccion_envio OUT VARCHAR2
) AS
BEGIN
    SELECT ID_ORDEN, ESTADO, FECHA_ENVIO, FECHA_ENTREGA_ESTIMADA, DIRECCION_ENVIO
    INTO p_id_orden, p_estado, p_fecha_envio, p_fecha_entrega_estimada, p_direccion_envio
    FROM ENVIOS
    WHERE ID_ENVIO = p_id_envio;
END sp_get_envio;
/

//Actualizar envio
CREATE OR REPLACE PROCEDURE sp_update_envio (
    p_id_envio NUMBER,
    p_id_orden NUMBER,
    p_estado VARCHAR2,
    p_fecha_entrega_estimada DATE,
    p_direccion_envio VARCHAR2
) AS
BEGIN
    UPDATE ENVIOS
    SET ID_ORDEN = p_id_orden, ESTADO = p_estado, 
        FECHA_ENTREGA_ESTIMADA = p_fecha_entrega_estimada, 
        DIRECCION_ENVIO = p_direccion_envio
    WHERE ID_ENVIO = p_id_envio;
END sp_update_envio;
/

//Eliminar Envio
CREATE OR REPLACE PROCEDURE sp_delete_envio (
    p_id_envio NUMBER
) AS
BEGIN
    DELETE FROM ENVIOS WHERE ID_ENVIO = p_id_envio;
END sp_delete_envio;
/