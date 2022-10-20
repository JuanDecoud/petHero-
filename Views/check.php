<?php
    session_start();
    if(isset($_SESSION["email"]))
    {
        $email=$_SESSION["email"];
    }
    else{
        header("location: login.php");
        echo "Debes iniciar sesion";
    }

?>