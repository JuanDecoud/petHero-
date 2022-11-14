<?php
    if(!isset($_SESSION["loggedUser"]))
    {
        $email=$_SESSION["loggedUser"];
        echo '<script language="javascript">alert("Por favor , inicie session");</script>';
        header("location:" .FRONT_ROOT."/index.php");
    }
 
?>