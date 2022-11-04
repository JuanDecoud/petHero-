create database pet_home;
use pet_home;
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
    idTarjeta int not null,
    idUser int not null,
    constraint fk_idUser foreign key (idUser) 
    references user(idUser) on update cascade on delete cascade,
    constraint fk_idTarjeta foreign key(idTarjeta) 
    references tarjeta(numero) on update cascade on delete cascade
);
create table keeper(
	idKeeper int primary key not null auto_increment,
    tipoMascota varchar(50) not null,
    remuneracion float not null,
    idUserr int not null,
    idFechasDisp int not null,
    constraint fk_idUserr foreign key (idUserr) 
    references user(idUser) on update cascade on delete cascade,
    constraint fk_idFechasDisp foreign key(idFechasDisp) 
    references fechasDisponibles(idFechasDisp) on update cascade on delete cascade
);
create table fechasDisponibles(
	idFechasDisp int primary key not null auto_increment,
    desde date not null,
    hasta date not null,
    idKeeper int not null,
    constraint fk_idKeeper foreign key(idKeeper) 
    references keeper(idKeeper) on update cascade on delete cascade
);
create table pet(
	idPet int primary key not null auto_increment,
    nombre varchar(50) not null,
    raza varchar(50) not null,
    tamaño varchar(50) not null,
    imagen varchar(100),
    planVacunacion varchar(100),
    observacionesGrals varchar(150),
    video longblob,
    idDueño int not null,
    constraint fk_idOwnerr foreign key (idDueño) 
    references owner(idOwner) on update cascade on delete cascade
);
create table tarjeta(
	numero int primary key not null,
    nombre varchar(50) not null,
    fechaVenc date not null,
    codigo int not null
);
create table reserva(
	idReserva int primary key not null auto_increment,
    idKeeper int not null,
    idFechasDis int not null,
    idPet int not null,
    importeReserva float not null,
    importeTotal float not null,
    estado ENUM('Pendiente','Cumplida','Aceptada','Confirmada') not null,
    constraint fk_idKeeper foreign key (idKeeper) 
    references keeper(idKeeper) on update cascade on delete cascade,
    constraint fk_idFechasDis foreign key (idFechasDis) 
    references fechasDisponibles(idFechasDisp) on update cascade on delete cascade,
    constraint fk_idPet foreign key (idPet) 
    references pet(idPet) on update cascade on delete cascade
);
create table reviews(
	idReview int primary key not null auto_increment,
    descripcion varchar(150) not null,
    fecha date not null,
    puntuacion float not null
);

delimiter //
create procedure insertarUser(nomU varchar(50), pass varchar(50),  tipo varchar(50),
nom varchar(50), apell varchar(50), docu int, tel long)
BEGIN
	declare existe_persona int;
    declare id int;
    set existe_persona =(select count(*) from user where nomU=nombreUser);
    IF existe_persona=0 THEN
		INSERT INTO user(nombreUser,contrasena,tipoDeCuenta,nombre,apellido,dni,telefono)
        VALUES (nomU,pass,tipo,nom,apell,docu, tel);
		SET id=last_insert_id();
	ELSE
		SET id=0;
    END IF;
END;
--verifica si exitste el nombre de usuario

create procedure insertarTarjeta(nro int, nom varchar(50),  venc date, cod int)
BEGIN
	declare existe_tarjeta int;
    declare id int;
    set existe_tarjeta =(select count(*) from tarjeta where nro=numero);
    IF existe_tarjeta=0 THEN
		INSERT INTO tarjeta(numero,nombre,fechaVenc,codigo) VALUES (nro,nom,venc,cod);
		SET id=last_insert_id();
	ELSE
		SET id=0;
    END IF;
END;

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
END;
--el id del owner se pasa por parametro hasta encontrar una mejor manera