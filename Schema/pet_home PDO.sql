
use pet_home;

create table IF NOT EXISTS user(
	idUser int primary key not null auto_increment,
    nombreUser varchar(50) not null,
    contrasena varchar(50) not null,
    tipoDeCuenta varchar(50) not null,
    nombre varchar(50) not null,
    apellido varchar(50) not null,
    dni varchar (50) unique key not null,
    telefono long not null
);
create table IF NOT EXISTS owner(
	idOwner int primary key not null auto_increment,
    idUser int not null,
    foreign key (idUser) references user(idUser) on update cascade on delete cascade
);
create table IF NOT EXISTS tarjeta(
    numero int not null,
    nombre varchar(50) not null,
    apellido varchar(50) not null,
    fechaVenc date not null,
    codigo int not null,
    idOwner int not null,
    foreign key(idOwner) references owner(idOwner) on update cascade on delete cascade
);
create table IF NOT EXISTS keeper(
	idKeeper int primary key not null auto_increment,
    remuneracion float not null,
    idUser int not null,
    foreign key (idUser) references user(idUser) on update cascade on delete cascade
);
create table IF NOT EXISTS fechasDisponibles(
	idFechasDisp int primary key auto_increment,
    desde date not null,
    hasta date not null,
    idKeeper int not null,
    foreign key (idKeeper) references keeper(idKeeper) on update cascade on delete cascade
);
create table IF NOT EXISTS pet(
	idPet int primary key not null auto_increment,
    nombre varchar(50) not null,
    raza varchar(50) not null,
    tamaño varchar(50) not null,
    imagen varchar(100),
    planVacunacion varchar(100),
    observacionesGrals varchar(150),
    video varchar(150),
    idOwner int not null,
    foreign key (idOwner) references owner(idOwner) on update cascade on delete cascade
);
create table IF NOT EXISTS reserva(
	idReserva int primary key not null auto_increment,
    idKeeper int not null,
    idPet int not null,
    importeReserva float not null,
    importeTotal float not null,
    estado varchar(50) not null,
	foreign key (idKeeper) references keeper(idKeeper) on update cascade on delete cascade,
    foreign key (idPet) references pet(idPet) on update cascade on delete cascade
);
create table IF NOT EXISTS reviews(
	idReview int primary key not null auto_increment,
    descripcion varchar(150) not null,
    fecha date not null,
    puntuacion float not null
);

create table IF NOT EXISTS tipoMascotaxKeeper (
	id int not null auto_increment primary key ,
    idKeeper int not null ,
    tipo_mascota varchar (50) not null unique key ,
    constraint fk_tipomascota foreign key (idKeeper) references keeper (idKeeper)    
);

create table IF NOT EXISTS diasxrango (
iddxr int not null auto_increment primary key ,
fecha date not null,
idrango int not null,
idReserva int,
unique key (fecha , idrango) ,
constraint fk_idReserva foreign key (idReserva) references reserva(idReserva)

);


/*PROCEDURES*______________________________________________________________________________ */

DROP procedure IF EXISTS `buscar_reservaiD`

DELIMITER $$

create procedure buscar_reservaiD (in idKeeper int , in idPet int)

BEGIN 
	select idReserva from reserva r 
    inner join keeper k on k.idKeeper = r.idKeeper 
    inner join  pet p on p.idPet = r.idPet 
    where r.idPet = idPet  and r.idKeeper = idKeeper ;
END $$


DELIMITER ;

DROP procedure IF EXISTS `buscarDias`

delimiter $$

create procedure buscarDias (in desde date , in hasta date , in nombreUser varchar (50))
	
begin
	select  fecha from fechasdisponibles fr
    inner join diasxrango dr on dr.idrango = fr.idFechasDisp
    inner join keeper k on k.idKeeper = fr.idKeeper 
    inner join user u  on u.idUser = k.idUser 
    where fr.desde = desde and fr.hasta = hasta and u.nombreUser = nombreUser ;  

end$$

delimiter ;

DROP procedure IF EXISTS `buscarDias_Reserva`

delimiter $$
create procedure buscar_diasReserva (in idReserva int)

BEGIN 
	select  fecha from diasxrango 
    where diasxrango.idReserva = idReserva ;
END $$

delimiter ;

DROP procedure IF EXISTS `cambiarEstado`

DELIMITER $$ 

create procedure cambiarEstado (in idPet int , in nombreUser varchar(50) , in estado varchar (50))
 BEGIN 
	UPDATE reserva r 
	INNER JOIN  keeper k on k.idKeeper = r.idKeeper
    INNER JOIN USER U on u.idUser = k.idUser 
	SET r.estado = estado 
    where r.idPet = idPet and u.nombreUser = nombreUser;
 END$$


DELIMITER ;

DROP procedure IF EXISTS `eliminar_diasReserva`

delimiter $$

create procedure eliminar_diasReserva (in idReserva int )
 BEGIN 
	DELETE dr from diasxrango dr
   where dr.idReserva = idReserva;
 END$$

delimiter ;

DROP procedure IF EXISTS `eliminar_Reserva`

delimiter $$ 
create procedure eliminar_Reserva (in idReserva int)

begin 
	delete from reserva
    where idReserva = idReserva;
end$$

delimiter ;

DROP procedure IF EXISTS `add_pet`

DELIMITER $$
create procedure add_pet (in nombre varchar (50) , in raza varchar (50) , in tamaño varchar (50) 
, in imagen varchar (100) , in planVacunacion varchar (100) ,  in observacionesGrals varchar (150), in video varchar (100) , in idOwner int )

BEGIN
	INSERT INTO pet (nombre , raza , tamaño , imagen , planVacunacion ,observacionesGrals , video , idOwner) 
    VALUES (nombre , raza , tamaño , imagen ,planVacunacion , observacionesGrals , video , idOwner );
END$$

DELIMITER ;

DROP procedure IF EXISTS `comprobarUser_owner`

DELIMITER $$

CREATE PROCEDURE comprobarUser_owner (in nombreUser varchar (50) , in contrasena varchar (50) )
BEGIN 
	select * from user u 
    inner join owner o on o.idUser = u.idUser 
    where u.nombreUser = nombreUser and o.idUser = u.idUser and u.contrasena = contrasena  ;
END$$ 

DELIMITER ;

DROP procedure IF EXISTS `get_owners`

DELIMITER $$

CREATE PROCEDURE get_owners (in userId int )
BEGIN 
	select * from user u 
    inner join owner o on o.idUser = u.idUser ;
END$$
DELIMITER ;

DROP procedure IF EXISTS `buscar_owner`

DELIMITER $$ 
CREATE PROCEDURE buscar_owner (in nombreUser varchar (50))

BEGIN 
	select idOwner from owner o 
    inner join user u on o.idUser = u.idUser 
    where o.idUser = u.idUser ;
END$$

DELIMITER ;

DROP procedure IF EXISTS `add_user`


DELIMITER $$
CREATE PROCEDURE add_user (in nombreUser varchar (50) , in contrasena varchar (50) , in tipoDeCuenta varchar(50) , in nombre varchar (50) , in apellido varchar (50),
in dni varchar (50) , in telefono varchar (50))

BEGIN 
	INSERT INTO user (nombreUser , contrasena ,  tipoDeCuenta  ,  nombre  ,  apellido, dni  , telefono )
    
    VALUES 
    (nombreUser,contrasena,tipoDeCuenta,nombre,apellido,dni,telefono);
END$$
DELIMITER ;

DROP procedure IF EXISTS `buscar_user`

DELIMITER $$
	create PROCEDURE buscar_user (in nombreUser varchar (50))
    BEGIN
		SELECT idUser from user u
        where  u.nombreUser = nombreUser ;
    END$$
    
DELIMITER ;

DROP procedure IF EXISTS `add_keeper`

DELIMITER $$
create PROCEDURE add_keeper (, in remuneracion float , in idUser int)

BEGIN 
		insert into keeper ( remuneracion , idUser) 
        values ( remuneracion , idUser);
END$$
DELIMITER ;


DROP procedure IF EXISTS `add_reserva`

DELIMITER $$
CREATE PROCEDURE add_reserva (in idKeeper int , in idFechasDis INT , in idPet int , in importeReserva double , in importeTotal double , in estado varchar (100) )
BEGIN 
	INSERT INTO  reserva (idKeeper , idFechasDis , idPet , importeReserva , importeTotal , estado )
    values (idKeeper,idFechasDis,idPet,importeReserva,importeTotal,estado);
END$$
DELIMITER ;

DROP procedure IF EXISTS `buscar_keeper`

DELIMITER $$ 

CREATE PROCEDURE buscar_keeper (in nombreUser varchar (50))

BEGIN 
	select idKeeper from keeper k 
    inner join user u on u.idUser = k.idUser 
    where u.nombreUser = nombreUser and u.idUser = k.idUser ;
END$$


DELIMITER ;

DROP procedure IF EXISTS `buscar_fechas`

DELIMITER $$ 

CREATE PROCEDURE buscar_fechas (in desde date , in hasta date)
BEGIN
	select idFechasDisp from fechasdisponibles f
    where f.desde = desde and f.hasta = hasta ;
END$$

DELIMITER ;

DROP procedure IF EXISTS `buscar_pet`
DELIMITER $$ 
CREATE PROCEDURE  buscar_pet (in userName varchar (50))
BEGIN
	select * from pet p 
    inner join owner o on o.idOwner = p.idOwner 
	inner join user u on u.idUser = o.idUser 
    Where u.nombreUser = userName and o.idOwner = p.idOwner ;
END$$

DELIMITER ;

DROP procedure IF EXISTS `buscar_fechasKeeper`

DELIMITER $$ 

CREATE PROCEDURE buscar_fechasKeeper (in  nombreUser varchar (50) )

BEGIN 
	SELECT desde , hasta from  fechasdisponibles f
    inner join keeper k on k.idKeeper = f.idKeeper 
    inner join user u on u.idUser = k.idUser 
    where  u.idUser = k.idUser and k.idKeeper = f.idKeeper ;
    
END$$

DELIMITER ;

DROP procedure IF EXISTS `buscar_tipoMascota`

DELIMITER $$ 

CREATE PROCEDURE buscar_tipoMascota (in idKeeper varchar (50))
BEGIN
	select tipo_mascota from tipomascotaxkeeper tm
    where tm.idKeeper = idKeeper;
END$$

DELIMITER ;

DROP procedure IF EXISTS `add_tipoMascota`

DELIMITER $$ 

CREATE PROCEDURE add_tipoMascota (in idKeeper int , in tipoMascota varchar (50))
BEGIN
	insert into tipomascotaxkeeper (idKeeper , tipo_mascota) values (idKeeper , tipoMascota);
    
END$$

DELIMITER ;