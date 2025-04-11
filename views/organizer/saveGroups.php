<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../controllers/groupsController.php");

/**
 * @var groupsController Variable-instancia del controlador
 */
$objGroupsController = new groupsController();

/**
 * @var string ID del torneo
 */
$idTorneo = $_POST['idTorneo'];

for ($i = 1; isset($_POST["txtNombreGrupo$i"]); $i++) {
    $nombreGrupo = $_POST["txtNombreGrupo$i"];
    $categoria = $_POST["categoriaGrupo$i"];

    $objGroupsController->saveGroup($nombreGrupo, $idTorneo, $categoria);
}

header("Location: submodulesTorneo.php?id=" . $idTorneo);
exit();
?>
