create table tipoCuenta (
descripcion varchar (100) primary key unique key 
);


CREATE TABLE  owners (
    nombreUser varchar (100)PRIMARY KEY   UNIQUE,
    contrasena varchar (100) NOT NULL,
    tipodeCuenta varchar (100) ,
    nombre  varchar (100),
    apellido varchar (100),
    dni varchar (100),
    telefono varchar (100),
    CONSTRAINT fk_tipo_cuenta foreign key (tipodeCuenta) references tipoCuenta (descripcion)
)


DELIMITER $$

CREATE PROCEDURE owners_add (IN nombreUser VARCHAR(100) , IN contrasena VARCHAR(100) , IN tipodeCuenta varchar (100), IN nombre varchar (100),
IN apellido varchar (100) , IN dni varchar (100) ,   IN telefono varchar(100))
BEGIN
	INSERT INTO owners
        (nombreUser, contrasena, tipodeCuenta,nombre , apellido , dni , telefono)
    VALUES
        (nombreUser, contrasena, tipodeCuenta, nombre , apellido , dni , telefono);
END$$

DELIMITER ;

create procedure owner_getAll ()
BEGIN
	SELECT nombreUser from owners
END$$

DELIMITER $$


create procedure get_IdtipoCuenta (IN descripcion varchar (100))

BEGIN 
	SELECT * FROM tipoCuenta  where descripcion = descripcion ;
end$$

DELIMITER ;

DELIMITER $$ 

CREATE procedure get_tipoCuenta ()
Begin
	select descripcion from tipoCuenta ;
End$$ 

delimiter ;
