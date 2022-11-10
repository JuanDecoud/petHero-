DELIMITER $$
create procedure add_pet (in nombre varchar (50) , in raza varchar (50) , in tamaño varchar (50) 
, in imagen varchar (100) , in planVacunacion varchar (100) ,  in observacionesGrals varchar (150), in video varchar (100) , in idOwner int )

BEGIN
	INSERT INTO pet (nombre , raza , tamaño , imagen , planVacunacion ,observacionesGrals , video , idOwner) 
    VALUES (nombre , raza , tamaño , imagen ,planVacunacion , observacionesGrals , video , idOwner );
END$$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE comprobarUser_owner (in nombreUser varchar (50) , in contrasena varchar (50) )
BEGIN 
	select * from user u 
    inner join owner o on o.idUser = u.idUser 
    where u.nombreUser = nombreUser and o.idUser = u.idUser and u.contrasena = contrasena  ;
END$$ 

DELIMITER ;

select * from pet

DELIMITER $$

CREATE PROCEDURE get_owners (in userId int )
BEGIN 
	select * from user u 
    inner join owner o on o.idUser = u.idUser ;
END$$
DELIMITER ;


DELIMITER $$ 
CREATE PROCEDURE buscar_owner (in nombreUser varchar (50))

BEGIN 
	select idOwner from owner o 
    inner join user u on o.idUser = u.idUser 
    where o.idUser = u.idUser ;
END$$

DELIMITER ;


DELIMITER $$
CREATE PROCEDURE add_user (in nombreUser varchar (50) , in contrasena varchar (50) , in tipoDeCuenta varchar(50) , in nombre varchar (50) , in apellido varchar (50),
in dni varchar (50) , in telefono varchar (50))

BEGIN 
	INSERT INTO user (nombreUser , contrasena ,  tipoDeCuenta  ,  nombre  ,  apellido, dni  , telefono )
    
    VALUES 
    (nombreUser,contrasena,tipoDeCuenta,nombre,apellido,dni,telefono);
END$$
DELIMITER ;

DELIMITER $$
	create PROCEDURE buscar_user (in nombreUser varchar (50))
    BEGIN
		SELECT idUser from user u
        where  u.nombreUser = nombreUser ;
    END$$
    
DELIMITER ;


DELIMITER $$
create PROCEDURE add_keeper (in tipoMascota varchar (50) , in remuneracion float , in idUser int)

BEGIN 
		insert into keeper (tipoMascota , remuneracion , idUser) 
        values (tipoMascota , remuneracion , idUser);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE add_reserva (in idKeeper int , in idFechasDis INT , in idPet int , in importeReserva double , in importeTotal double , in estado varchar (100) )
BEGIN 
	INSERT INTO  reserva (idKeeper , idFechasDis , idPet , importeReserva , importeTotal , estado )
    values (idKeeper,idFechasDis,idPet,importeReserva,importeTotal,estado);
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE add_reserva (in idKeeper int , in idFechasDis INT , in idPet int , in importeReserva double , in importeTotal double , in estado varchar (100) )
BEGIN 
	INSERT INTO  reserva (idKeeper , idFechasDis , idPet , importeReserva , importeTotal , estado )
    values (idKeeper,idFechasDis,idPet,importeReserva,importeTotal,estado);
END$$
DELIMITER ;


DELIMITER $$ 

CREATE PROCEDURE buscar_keeper (in nombreUser varchar (50))

BEGIN 
	select idKeeper from keeper k 
    inner join user u on u.idUser = k.idUser 
    where u.nombreUser = nombreUser and u.idUser = k.idUser ;
END$$


DELIMITER ;


DELIMITER $$ 

CREATE PROCEDURE buscar_fechas (in desde date , in hasta date)
BEGIN
	select idFechasDisp from fechasdisponibles f
    where f.desde = desde and f.hasta = hasta ;
END$$

DELIMITER ;


DELIMITER $$ 
CREATE PROCEDURE  buscar_pet (in userName varchar (50))
BEGIN
	select idPet from pet p 
    inner join owner o on o.idOwner = p.idOwner 
	inner join user u on u.idUser = o.idUser 
    Where u.nombreUser = userName and o.idOwner = p.idOwner ;
END$$

DELIMITER ;

DELIMITER $$ 

CREATE PROCEDURE buscar_fechasKeeper (in  nombreUser varchar (50) )

BEGIN 
	SELECT desde , hasta from  fechasdisponibles f
    inner join keeper k on k.idKeeper = f.idKeeper 
    inner join user u on u.idUser = k.idUser 
    where  u.idUser = k.idUser and k.idKeeper = f.idKeeper ;
    
END$$

DELIMITER ;
