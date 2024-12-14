--Trigger validar nombre
CREATE OR REPLACE TRIGGER validar_nombre
BEFORE INSERT OR UPDATE ON CLIENTES
FOR EACH ROW
BEGIN
    -- Verificar si el campo 'NOMBRE' contiene algún número o caracter especial
    IF REGEXP_LIKE(:NEW.NOMBRE, '[^a-zA-Z\s]') THEN
        -- Si contiene un número o caracter especial, lanza un error para evitar la inserción
        RAISE_APPLICATION_ERROR(-20001, 'El campo nombre no debe contener números o caracteres especiales.');
    END IF;
END validar_nombre;


--insert para probar trigger validar_nombre
INSERT INTO CLIENTES (NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO) 
VALUES ('Juan123', 'Pérez', 'juan@example.com', 'Calle 123', '1234567890');


--trigger validar apellido clientes
CREATE OR REPLACE TRIGGER validar_apellido
BEFORE INSERT OR UPDATE ON CLIENTES
FOR EACH ROW
BEGIN
    -- Verificar si el campo 'APELLIDO' contiene algún número o caracter especial
    IF REGEXP_LIKE(:NEW.APELLIDO, '[^a-zA-Z\s]') THEN
        -- Si contiene un número o caracter especial, lanza un error para evitar la inserción
        RAISE_APPLICATION_ERROR(-20002, 'El campo apellido no debe contener números o caracteres especiales.');
    END IF;
END validar_apellido;

--probar trigger apellido clientes
INSERT INTO CLIENTES (NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO) 
VALUES ('Ana', 'Pérez123', 'ana@example.com', 'Calle 456', '9876543210');

--trigger validar correo
CREATE OR REPLACE TRIGGER validar_email
BEFORE INSERT OR UPDATE ON CLIENTES
FOR EACH ROW
BEGIN
    -- Verificar si el campo 'EMAIL' contiene un '@'
    IF NOT REGEXP_LIKE(:NEW.EMAIL, '.*@.*') THEN
        -- Si no contiene un '@', lanza un error para evitar la inserción o actualización
        RAISE_APPLICATION_ERROR(-20003, 'Formato de correo no válido.');
    END IF;
END validar_email;

--prueba validar_email
INSERT INTO CLIENTES (NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO) 
VALUES ('Carlos', 'Lopez', 'carlos.example.com', 'Avenida Principal', '5551234567');

--trigger telefono Clientes
CREATE OR REPLACE TRIGGER validar_telefono_cliente
BEFORE INSERT OR UPDATE ON CLIENTES
FOR EACH ROW
BEGIN
    IF NOT REGEXP_LIKE(:NEW.TELEFONO, '^[0-9]+$') THEN
        RAISE_APPLICATION_ERROR(-20004, 'El campo TELEFONO debe contener solo números.');
    END IF;
END;

--prueba trigger telefono clientes
INSERT INTO CLIENTES (NOMBRE, APELLIDO, EMAIL, DIRECCION, TELEFONO)
VALUES ('María', 'López', 'maria.lopez@example.com', 'Calle 123', '9876543210abc');







--trigger validar nombre tabla empleados
CREATE OR REPLACE TRIGGER validar_nombre_empleado
BEFORE INSERT OR UPDATE ON EMPLEADOS
FOR EACH ROW
BEGIN
    IF REGEXP_LIKE(:NEW.NOMBRE, '[0-9]') THEN
        RAISE_APPLICATION_ERROR(-20001, 'El campo NOMBRE no debe contener números.');
    END IF;
END;

--prueba trigger nombre empleado
INSERT INTO EMPLEADOS (ID_EMPLEADO, NOMBRE, APELLIDO, TELEFONO, ID_SUCURSAL)
VALUES (2, 'Juan123', 'Pérez', '1234567890', 100);

--trigger para validar apellido de empleados
CREATE OR REPLACE TRIGGER validar_apellido_empleado
BEFORE INSERT OR UPDATE ON EMPLEADOS
FOR EACH ROW
BEGIN
    IF REGEXP_LIKE(:NEW.APELLIDO, '[0-9]') THEN
        RAISE_APPLICATION_ERROR(-20002, 'El campo APELLIDO no debe contener números.');
    END IF;
END;

--prueba trigger apellido empleados
INSERT INTO EMPLEADOS (ID_EMPLEADO, NOMBRE, APELLIDO, TELEFONO, ID_SUCURSAL)
VALUES (4, 'Carlos', 'Gonzalez123', '9876543210', 100);


--trigger telefono empleado
CREATE OR REPLACE TRIGGER validar_telefono_empleado
BEFORE INSERT OR UPDATE ON EMPLEADOS
FOR EACH ROW
BEGIN
    IF NOT REGEXP_LIKE(:NEW.TELEFONO, '^[0-9]+$') THEN
        RAISE_APPLICATION_ERROR(-20003, 'El campo TELEFONO debe contener solo números.');
    END IF;
END;

--prueba trigger telefono empleado
INSERT INTO EMPLEADOS (ID_EMPLEADO, NOMBRE, APELLIDO, TELEFONO, ID_SUCURSAL)
VALUES (3, 'Ana', 'Martínez', '12345abcde', 100);

--trigger validar telefono sucursal
CREATE OR REPLACE TRIGGER validar_telefono_sucursal
BEFORE INSERT OR UPDATE ON SUCURSALES
FOR EACH ROW
BEGIN
    IF NOT REGEXP_LIKE(:NEW.TELEFONO, '^[0-9]+$') THEN
        RAISE_APPLICATION_ERROR(-20001, 'El campo TELEFONO debe contener solo números.');
    END IF;
END;

--prueba trigger telefono sucursal
INSERT INTO SUCURSALES (ID_SUCURSAL, NOMBRE, DIRECCION, TELEFONO)
VALUES (1, 'Sucursal Norte', 'Avenida Principal 123', '9876abc321');


--trigger validar nombre sucursal

CREATE OR REPLACE TRIGGER validar_nombre_sucursal
BEFORE INSERT OR UPDATE ON SUCURSALES
FOR EACH ROW
BEGIN
    IF :NEW.NOMBRE IS NULL OR LENGTH(TRIM(:NEW.NOMBRE)) = 0 THEN
        RAISE_APPLICATION_ERROR(-20002, 'El campo NOMBRE no debe estar vacío.');
    END IF;
END;

--prueba trigger validar nombre sucursal
INSERT INTO SUCURSALES (ID_SUCURSAL, NOMBRE, DIRECCION, TELEFONO)
VALUES (2, '', 'Calle Secundaria 456', '1234567890');


--trigger validar direccion sucursal
CREATE OR REPLACE TRIGGER validar_direccion_sucursal
BEFORE INSERT OR UPDATE ON SUCURSALES
FOR EACH ROW
BEGIN
    IF :NEW.DIRECCION IS NULL OR LENGTH(TRIM(:NEW.DIRECCION)) = 0 THEN
        RAISE_APPLICATION_ERROR(-20003, 'El campo DIRECCION no debe estar vacío.');
    END IF;
END;

--prueba trigger validar direccion sucrusal
INSERT INTO SUCURSALES (ID_SUCURSAL, NOMBRE, DIRECCION, TELEFONO)
VALUES (3, 'Sucursal Este', '', '0987654321');