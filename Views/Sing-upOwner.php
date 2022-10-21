<?php include_once("Header.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Owner</title>
</head>
<body>
    <center>
  <form action="addOwner.php" method="post">
        <label for:"iname">Usuario:</label>
        <input type="text" name="name" id="iname" placeholder="Escriba su Nombre de Usuario"><br>
        <label for:"ipass">Contraseña:</label>
        <input type="password" name="pass" id="ipass" placeholder="Escriba su Contraseña"><br>
    <br>
    <button type="submit">Crear usuario</button>
  </form>
  </center>
</body>
</html>


<?php include_once("Footer.php") ?>