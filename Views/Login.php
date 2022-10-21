<?php
  require_once("Header.php");
  require_once("check.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
</head>
<body>
    <center>
  <form action="..Session/session.php" method="post">
    <label for="iemail">Email:</label><br>
    <input type="email" name="email" placeholder="Email" id="iemail" required><br>
    <label for="ipass">Contraseña:</label><br>
    <input type="password" name="password" placeholder="Password" id="ipass" required><br>
    <button type="submit">Iniciar sesión</button>
    </center>
  </form>

<?php  require_once("Footer.php") ?>