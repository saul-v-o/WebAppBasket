<?php

/**
 * Este archivo procesa los datos del formulario de inserción de un torneo y los guarda en la base de datos.
 * 
 * Se recibe la información del formulario a través del método POST, se sanitizan y luego se pasa a un controlador
 * para que sea almacenada en la base de datos.
 * 
 * @package Torneos
 * @subpackage Save
 * @author Saúl Valenzuela Osuna
 * @version 1.0
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once("../../controllers/torneosControllers.php");
require_once("../../controllers/organizerController.php");

$nombreTorneo = $_POST['txtNombreTorneo'];
$patrocinadores = $_POST['txtPatrocinador'];
$sede = $_POST['txtSede'];
$premio1 = $_POST['txtPremio1'];
$premio2 = $_POST['txtPremio2'];
$premio3 = $_POST['txtPremio3'];
$otroPremio = $_POST['txtOtroPremio'];
$nombre = $_POST['txtOrganizador'];
$usuario = $_POST['txtUsuarioOrganizador'];
$contrasena = $_POST['txtContrasenaOrganizador'];

// Manejo de archivos (logo del torneo)
if (isset($_FILES['fileLogoTorneo']) && $_FILES['fileLogoTorneo']['error'] == UPLOAD_ERR_OK) {
    $logoTorneo = '../img/logoTorneos/' . basename($_FILES['fileLogoTorneo']['name']);
    move_uploaded_file($_FILES['fileLogoTorneo']['tmp_name'], $logoTorneo);
} else {
    $logoTorneo = null; // Si no se sube archivo, se deja nulo
}

// Manejo de múltiples logotipos de patrocinadores
$logosPatrocinadores = [];
if (isset($_FILES['fileLogosPatrocinadores'])) {
    foreach ($_FILES['fileLogosPatrocinadores']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['fileLogosPatrocinadores']['error'][$index] == UPLOAD_ERR_OK) {
            $logoPatrocinador = '../img/logoPatrocinadores/' . basename($_FILES['fileLogosPatrocinadores']['name'][$index]);
            move_uploaded_file($tmpName, $logoPatrocinador);
            $logosPatrocinadores[] = $logoPatrocinador;
        }
    }
}
$logosPatrocinadoresStr = implode(',', $logosPatrocinadores);

/**
 * Instancia del controlador de torneos para manejar la lógica de negocio y guardar los datos en la base de datos.
 * 
 * @var torneosController $objController Instancia del controlador.
 */
$objController = new torneosController();

/**
 * Instancia del controlador de organizadores.
 * 
 * @var organizerController $objOrganizerController Instancia del controlador.
 */
$objOrganizerController = new organizerController();

$idOrganizador = $objOrganizerController->saveOrganizer($usuario, $contrasena, $nombre);
var_dump($idOrganizador);

$objController->saveTorneo(
    $nombreTorneo,
    $logoTorneo,
    $patrocinadores,
    $logosPatrocinadoresStr,
    $sede,
    $premio1,
    $premio2,
    $premio3,
    $otroPremio,
    $idOrganizador
);

?>

