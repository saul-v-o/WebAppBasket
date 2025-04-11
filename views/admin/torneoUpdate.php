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

$id = $_GET['id'];
$nombreTorneo = $_POST['txtNombreTorneo'];
$logoTorneo = $_POST['logoTorneo'];
$patrocinadores = $_POST['txtPatrocinador'];
$logosPatrocinadores = $_POST['logoPatrocinadores'];

$logosPatrocinadoresNuevos = [];
if (isset($_FILES['fileLogosPatrocinadores'])) {
    foreach ($_FILES['fileLogosPatrocinadores']['tmp_name'] as $index => $tmpName) {
        if ($_FILES['fileLogosPatrocinadores']['error'][$index] == UPLOAD_ERR_OK) {
            $logoPatrocinador = '../img/logoPatrocinadores/' . basename($_FILES['fileLogosPatrocinadores']['name'][$index]);
            move_uploaded_file($tmpName, $logoPatrocinador);
            $logosPatrocinadoresNuevos[] = $logoPatrocinador;
        }
    }
}
var_dump($logosPatrocinadoresNuevos);
$logosPatrocinadoresNuevosStr = implode(',', $logosPatrocinadoresNuevos);
$logosPatrocinadores = $logosPatrocinadores . "," . $logosPatrocinadoresNuevosStr;

$sede = $_POST['txtSede'];
$premio1 = $_POST['txtPremio1'];
$premio2 = $_POST['txtPremio2'];
$premio3 = $_POST['txtPremio3'];
$otroPremio = $_POST['txtOtroPremio'];
$nombre = $_POST['txtOrganizador'];
$usuario = $_POST['txtUsuarioOrganizador'];

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

$rows = $objController->readOneTorneos($id);
$idOrganizador = $objOrganizerController->updateOrganizer($rows['idOrganizador'], $usuario, $nombre);
var_dump($idOrganizador);
echo "<br>";
var_dump($logoTorneo);
echo "<br>";
var_dump($logosPatrocinadores);
echo "<br>";
var_dump($id);

$objController->updateTorneos(
    $id,
    $nombreTorneo,
    $logoTorneo,
    $patrocinadores,
    $logosPatrocinadores,
    $sede,
    $premio1,
    $premio2,
    $premio3,
    $otroPremio,
    $idOrganizador
);

?>

