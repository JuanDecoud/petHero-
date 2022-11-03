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
    hasta date not null
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