create database pet_home;
use pet_home;
drop table reviews;
drop table reserva;
drop table pet;
drop table fechasdisponibles;
drop table tarjeta;
drop table keeper;
drop table owner;
drop table user;
create table user(
	idUser int primary key not null auto_increment,
    nombreUser varchar(50) not null,
    contrasena varchar(50) not null,
    tipoDeCuenta varchar(50) not null,
    nombre varchar(50) not null,
    apellido varchar(50) not null,
    dni int not null,
    telefono long not null
);
create table owner(
	idOwner int primary key not null auto_increment,
    idUser int not null,
    foreign key (idUser) references user(idUser) on update cascade on delete cascade
);
create table tarjeta(
    numero int not null,
    nombre varchar(50) not null,
    apellido varchar(50) not null,
    fechaVenc date not null,
    codigo int not null,
    idOwner int not null,
    foreign key(idOwner) references owner(idOwner) on update cascade on delete cascade
);
create table keeper(
	idKeeper int primary key not null auto_increment,
    tipoMascota varchar(50) not null,
    remuneracion float not null,
    idUser int not null,
    foreign key (idUser) references user(idUser) on update cascade on delete cascade
);
create table fechasDisponibles(
	idFechasDisp int primary key auto_increment,
    desde date not null,
    hasta date not null,
    idKeeper int not null,
    foreign key (idKeeper) references keeper(idKeeper) on update cascade on delete cascade
);
create table pet(
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
create table reserva(
	idReserva int primary key not null auto_increment,
    idKeeper int not null,
    idFechasDis int not null,
    idPet int not null,
    importeReserva float not null,
    importeTotal float not null,
    estado ENUM('Pendiente','Cumplida','Aceptada','Confirmada') not null,
	foreign key (idKeeper) references keeper(idKeeper) on update cascade on delete cascade,
    foreign key (idFechasDis) references fechasDisponibles(idFechasDisp) on update cascade on delete cascade,
    foreign key (idPet) references pet(idPet) on update cascade on delete cascade
);
create table reviews(
	idReview int primary key not null auto_increment,
    descripcion varchar(150) not null,
    fecha date not null,
    puntuacion float not null
);

/**______________________________________________________________________________ */
drop procedure insertarOwner;
drop procedure insertarUser;
delimiter $$
create procedure insertarUser(nomU varchar(50), pass varchar(50),  tipo varchar(50),
nom varchar(50), apell varchar(50), docu int, tel long)
BEGIN
	declare existe_persona int;
    declare id int;
    set existe_persona =(select count(*) from user where nomU=nombreUser);
    IF existe_persona=0 THEN
		INSERT INTO user(nombreUser,contrasena,tipoDeCuenta,nombre,apellido,dni,telefono)
        VALUES (nomU,pass,tipo,nom,apell,docu,tel);
		SET id=last_insert_id();
	ELSE
		SET id=0;
    END IF;
    call insertarOwner(nomU);
END $$
delimiter ;

delimiter $$
create procedure insertarOwner(nomU varchar(50))
BEGIN
	declare existe_persona int;
    declare id int;
    set existe_persona =(select count(*) from user where nomU=nombreUser);
    IF existe_persona=0 THEN
        insert into owner(idUser) select idUser from user;
		SET id=last_insert_id();
	ELSE
		SET id=0;
    END IF;
END $$
delimiter ;

call insertarUser('dany','1234','Owner','Daniel','Sciacco','33333333','222222222');
call insertarUser('damy','1234','Owner','Damian','Tacconi','44444444','555555555');
select*from user;
select*from owner;

delimiter $$
create procedure insertarTarjeta(nro int, nom varchar(50), apell varchar(50),  venc date, cod int)
BEGIN
	declare existe_tarjeta int;
    declare id int;
    set existe_tarjeta =(select count(*) from tarjeta where nro=numero);
    IF existe_tarjeta=0 THEN
		INSERT INTO tarjeta(numero,nombre,apellido,fechaVenc,codigo) VALUES (nro,nom,apell,venc,cod);
		SET id=last_insert_id();
	ELSE
		SET id=0;
    END IF;
END $$
delimiter ;
call insertarTarjeta('1234567','dan','sci','2023-11-20','666');
select*from tarjeta;

delimiter $$
create procedure insertarPet(nom varchar(50),raz varchar(50),tam varchar(50),imag varchar(100),
planVac varchar(100),obserGrals varchar(150),vidd varchar(100),idOwn int)
BEGIN
	declare existe_mascota int;
    declare id int;
    set existe_mascota =(select count(*) from pet where imag=imagen);
    IF existe_mascota=0 THEN
		INSERT INTO pet(nombre,raza,tamaño,imagen,planVacunacion,observacionesGrals,video,idDueño) 
        VALUES (nom,raz,tam,imag,planVac,obserGrals,vidd,idOwn);
		SET id=last_insert_id();
	ELSE
		SET id=0;
    END IF;
END; $$
delimiter ;

delimiter $$
create procedure seleccionarOwner(nomU varchar(50))
BEGIN
	select user.nombreUser,user.contrasena,user.tipoDeCuenta,user.nombre,user.apellido,user.dni,
    user.telefono from owner o
    inner join user u on o.idUser=u.idUser;
END $$
delimiter ;


 

