<?php
  require_once("Header.php");
  require_once("nav.php");
  
?>

  <form action="..Session/session.php" method="post">
    <label for="iemail">Email:</label><br>
    <input type="email" name="email" placeholder="Email" id="iemail" required><br>
    <label for="ipass">Contraseña:</label><br>
    <input type="password" name="password" placeholder="Password" id="ipass" required><br>
    <button type="submit">Iniciar sesión</button>
  
  </form>

<?php  require_once("Footer.php") ?>