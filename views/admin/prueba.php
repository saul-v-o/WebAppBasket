<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../../controllers/torneosControllers.php");

$objTorneoController = new torneosController();
$rows = $objTorneoController->readTorneos();

if ($rows) {
    echo "<pre>";
    print_r($rows);
    echo "</pre>";
} else {
    echo "No se encontraron datos.";
}
?>
