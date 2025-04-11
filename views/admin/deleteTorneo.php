<?php
/**
 * Archivo para eliminar un torneo.
 * 
 * Este script elimina un torneo de la base de datos utilizando el ID proporcionado
 * en la solicitud HTTP GET. Se conecta al controlador `torneosController` para realizar
 * la operación de eliminación.
 * 
 * @package WebAppBasketBall
 * @subpackage Views
 * @author Saúl Valenzuela Osuna
 * @version 1.0 2024-11-24
 */
require_once("../../controllers/torneosControllers.php");

/**
 * Instancia del controlador de torneos.
 *
 * @var torneosController $objTorneosController Controlador que maneja los torneos.
 */
$objTorneosController = new torneosController();

$objTorneosController->delete($_GET['id']);

?>