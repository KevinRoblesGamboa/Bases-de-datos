-- Crear categoría
CREATE OR REPLACE PROCEDURE sp_create_categoria (
    p_nombre_categoria VARCHAR2,
    p_descripcion VARCHAR2
) AS
BEGIN
    INSERT INTO CATEGORIAS (NOMBRE_CATEGORIA, DESCRIPCION)
    VALUES (p_nombre_categoria, p_descripcion);
END sp_create_categoria;
/

-- Leer categoría
CREATE OR REPLACE PROCEDURE sp_get_categoria (
    p_id_categoria NUMBER,
    p_nombre_categoria OUT VARCHAR2,
    p_descripcion OUT VARCHAR2
) AS
BEGIN
    SELECT NOMBRE_CATEGORIA, DESCRIPCION
    INTO p_nombre_categoria, p_descripcion
    FROM CATEGORIAS
    WHERE ID_CATEGORIA = p_id_categoria;
END sp_get_categoria;
/

-- Actualizar categoría
CREATE OR REPLACE PROCEDURE sp_update_categoria (
    p_id_categoria NUMBER,
    p_nombre_categoria VARCHAR2,
    p_descripcion VARCHAR2
) AS
BEGIN
    UPDATE CATEGORIAS
    SET NOMBRE_CATEGORIA = p_nombre_categoria, DESCRIPCION = p_descripcion
    WHERE ID_CATEGORIA = p_id_categoria;
END sp_update_categoria;
/

-- Eliminar categoría
CREATE OR REPLACE PROCEDURE sp_delete_categoria (
    p_id_categoria NUMBER
) AS
BEGIN
    DELETE FROM CATEGORIAS WHERE ID_CATEGORIA = p_id_categoria;
END sp_delete_categoria;
/