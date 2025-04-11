<?php

/**
 * Este archivo procesa los datos del formulario de inserción de un juego y los guarda en la base de datos
 * 
 * @author Valenzuela Osuna Saúl
 * @version 1.0  26-12-2024
 */
ini_set('display_errors', 1);
    error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("../../controllers/calendarController.php");

// Recibir los datos del formulario
$idTorneo = $_POST['idTorneo'];
$equipoLocal = $_POST['equipoLocal'];
$equipoVisitante = $_POST['equipoVisitante'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$categoria = $_POST['categoria'];
$rol = $_POST['rol'];
$sede = $_POST['sede'];

/**
 * Instancia del controlador de calendario para manejar la lógica y guardar los datos en la base de datos.
 * 
 * @var calendarController $objController Instancia del controlador.
 */
$objController = new calendarController();

// Guardar el juego en la base de datos
$objController->saveGame($idTorneo, $equipoLocal, $equipoVisitante, $fecha, $hora, $categoria, $rol, $sede);

?>