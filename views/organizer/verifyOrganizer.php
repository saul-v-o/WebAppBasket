<?php

    /**
     * Este archivo procesa los datos del formulario de inserción de un organizador y los guarda en la base de datos
     * 
     * @package Torneos
     * @subpackage Save
     * @author Valenzuela Osuna Saúl
     * @version 1.0  23-12-2024
     */
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once("../../controllers/organizerController.php"); 

    /**
     * Variables que contienen los datos recibidos desde el formulario de inserción del torneo.
     * 
     * @var string $txtUsuario Nombre de usuario del organizador.
     * @var string $contrasena Contraseña del organizador.
     */
    $txtUsuario = $_POST['txtUsuario'];
    $contrasena = $_POST['txtContrasena'];

    /**
     * Instancia del controlador de organizadores para manejar la lógica y guardar los datos en la base de datos.
     * 
     * @var organizerController $objController Instancia del controlador.
     */
    $objController = new organizerController();

    /**
     * Guarda el organizador en la base de datos.
     * 
     * Llama al método verifyData() del controlador para guardar los datos en la base de datos.
     * 
     * @param string $txtUsuario Usuario del organizador.
     * @param string $contrasena Contraseña del organizador.
     * 
     * @return void
     */
    $objController->verifyData($txtUsuario, $contrasena);

?>
