<?php
  require_once "Config/Autoload.php";

  use Models\Pet as Pet;
  use DAO\PetDAO as PetDAO;

  if ($_POST) {
    $nombre = $_POST["nombre"];
    $nombre = $_POST["owner"];
    $nombre = $_POST["raza"];
    $nombre = $_POST["tamaño"];
    $nombre = $_POST["planVacunacion"];
    $nombre = $_POST["observacionesGrals"];

    $pet = new Pet();
    $pet->setNombre($nombre);
    $pet->setOwner($owner);
    $pet->setRaza($raza);
    $pet->setTamano($tamaño);
    $pet->setPlanVacunacion($planVacunacion);
    $pet->setObservacionesGrals($observacionesGrals);

    $PetDAO = new PetDAO();
    $PetDAO->Add($pet);

    header("location: menu-owner.php");
  }
?>