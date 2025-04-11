<?php

/**
 * Este archivo procesa los datos del formulario de inserción de un equipo y los guarda en la base de datos
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0  23-12-2024
 */

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once("../../controllers/teamsController.php");


$nombreEquipo = $_POST['nombreEquipo'];
$nombreCapitán = $_POST['nombreCapitán'];
$correoCapitán = $_POST['correoCapitán'];
$celularCapitán = $_POST['celularCapitán'];
$idTorneo = $_POST['idTorneo'];
$idGrupo = $_POST['grupo']; 

$logo = null;
if ($_FILES['logoEquipo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = "../img/teams/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileName = uniqid('equipo') . "_" . basename($_FILES['logoEquipo']['name']);
    $uploadFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['logoEquipo']['tmp_name'], $uploadFile)) {
        $logo = $fileName;
    } else {
        die("Error al subir la fotografía.");
    }
}
var_dump($logo);

/**
 * Instancia del controlador de organizadores para manejar la lógica y guardar los datos en la base de datos.
 * 
 * @var teamsController $objController Instancia del controlador.
 */
$objController = new teamsController();


$objController->saveTeam($nombreEquipo, $nombreCapitán, $correoCapitán, $celularCapitán, $idTorneo, $logo, $idGrupo);

?>