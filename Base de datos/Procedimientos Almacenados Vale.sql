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

//Crear inventario
CREATE OR REPLACE PROCEDURE sp_create_inventario (
    p_id_sucursal NUMBER,
    p_id_producto NUMBER,
    p_cantidad NUMBER
) AS
BEGIN
    INSERT INTO INVENTARIO (ID_SUCURSAL, ID_PRODUCTO, CANTIDAD)
    VALUES (p_id_sucursal, p_id_producto, p_cantidad);
END sp_create_inventario;
/

//Obtener inventario
CREATE OR REPLACE PROCEDURE sp_get_inventario (
    p_id_inventario NUMBER,
    p_id_sucursal OUT NUMBER,
    p_id_producto OUT NUMBER,
    p_cantidad OUT NUMBER,
    p_ultima_actualizacion OUT DATE
) AS
BEGIN
    SELECT ID_SUCURSAL, ID_PRODUCTO, CANTIDAD, ULTIMA_ACTUALIZACION
    INTO p_id_sucursal, p_id_producto, p_cantidad, p_ultima_actualizacion
    FROM INVENTARIO
    WHERE ID_INVENTARIO = p_id_inventario;
END sp_get_inventario;
/

//Actualizar inventario
CREATE OR REPLACE PROCEDURE sp_update_inventario (
    p_id_inventario NUMBER,
    p_id_sucursal NUMBER,
    p_id_producto NUMBER,
    p_cantidad NUMBER
) AS
BEGIN
    UPDATE INVENTARIO
    SET ID_SUCURSAL = p_id_sucursal, ID_PRODUCTO = p_id_producto, CANTIDAD = p_cantidad,
        ULTIMA_ACTUALIZACION = SYSDATE
    WHERE ID_INVENTARIO = p_id_inventario;
END sp_update_inventario;
/

//Eliminar inventario
CREATE OR REPLACE PROCEDURE sp_delete_inventario (
    p_id_inventario NUMBER
) AS
BEGIN
    DELETE FROM INVENTARIO WHERE ID_INVENTARIO = p_id_inventario;
END sp_delete_inventario;
/