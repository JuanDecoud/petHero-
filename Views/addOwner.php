<?php
  require_once "Config/Autoload.php";

  use Models\Owner as Owner;
  use DAO\OwnerDAO as OwnerDAO;

  if ($_POST) {
    $email = $_POST["email"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);

    $owner = new Owner($id, $nombreUser, $contrasena, $dni, $email);

    $ownerDAO = new OwnerDAO();
    $ownerDAO->Add($owner);

    header("location: login.php");
  }
?>