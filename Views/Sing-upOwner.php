<?php include_once("Header.php") ?>

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

<?php include_once("Footer.php") ?>