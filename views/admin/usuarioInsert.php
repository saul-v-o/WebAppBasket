<?php
    require_once("../../controllers/usuariosControllers.php"); 

    $nombre = $_POST['txtNombre'];
    $apellidoP = $_POST['txtApellidoP'];
    $apellidoM = $_POST['txtApellidoM'];
    $usuario = $_POST['txtUsuario'];
    $correo = $_POST['txtCorreo'];
    $contrasena = $_POST['txtContrasena'];
   
    $objController = new usuariosController();

    $objController->saveUsuario($nombre, $apellidoP, $apellidoM, $usuario, $correo, $contrasena);
?>
