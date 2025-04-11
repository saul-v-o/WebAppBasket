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
    require_once("../../controllers/adminController.php"); 

    /**
     * Variables que contienen los datos recibidos desde el formulario de inserción del torneo.
     * 
     * @var string $usuario Nombre de usuario del organizador.
     * @var string $contrasena Contraseña del organizador.
     * @var string $nombre Nombre del organizador.
     * @var string $apellidoP Apeliido Paterno del organizador.
     * @var string $apellidoM Apellido Materno del organizador.
     * @var string $correo Correo del organizador.
     */
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $apellidoP = $_POST['apellidoP'];
    $apellidoM = $_POST['apellidoM'];
    $correo = $_POST['correo'];


    /**
     * Instancia del controlador de organizadores para manejar la lógica y guardar los datos en la base de datos.
     * 
     * @var adminController $objController Instancia del controlador.
     */
    $objController = new adminController();

    /**
     * Guarda el organizador en la base de datos.
     * 
     * Llama al método saveOrganizer() del controlador para guardar los datos en la base de datos.
     * 
     * @param string $usuario Usuario del organizador.
     * @param string $contrasena Contraseña del organizador.
     * 
     * @return void
     */
    $objController->saveAdmin($usuario, $contrasena, $nombre, $apellidoP, $apellidoM, $correo);

?>
