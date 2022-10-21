<?php
  require_once("Header.php");
  require_once("nav.php");
  
?>

  <form action="<?php echo FRONT_ROOT."Home/login"; ?>" method="post">
    <label for="iemail">Email:</label><br>
    <input type="text" name="email" placeholder="Email" id="iemail" required><br>
    <label for="ipass">Contraseña:</label><br>
    <input type="password" name="password" placeholder="Password" id="ipass" required><br>
    <button type="submit">Iniciar sesión</button>
  
  </form>

<?php  require_once("Footer.php") ?>