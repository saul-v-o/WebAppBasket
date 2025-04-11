<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("../../controllers/torneosControllers.php");

/**
 * Instancia del controlador de torneos para manejar la lógica de negocio.
 * 
 * @var torneosController $objTorneoController Controlador que maneja las operaciones relacionadas con los torneos.
 */
$objTorneoController = new torneosController();

$idTorneo = $_GET['id'];
$logo = $_GET['logo'];

$objTorneoController->deleteLogoPatrocinador($idTorneo, $logo);
?>