<?php
/**
 * Este archivo presenta un formulario para editar los detalles de un torneo en la base de datos.
 * 
 * Se obtiene la información del torneo a través de su ID, se muestran los datos en un formulario y, al enviarlo, se actualizan los datos en la base de datos.
 * 
 * @package Torneos
 * @subpackage Update
 * @author Saúl Valenzuela Osuna
 * @version 1.0
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("../admin/template/header.php");
require_once("../../controllers/torneosControllers.php");
require_once("../../controllers/organizerController.php");

/**
 * Instancia del controlador de torneos para manejar la lógica de negocio.
 * 
 * @var torneosController $objTorneoController Controlador que maneja las operaciones relacionadas con los torneos.
 */
$objTorneoController = new torneosController();

/**
 * Instancia del controlador de torneos para manejar la lógica de negocio.
 * 
 * @var organizerController $objOrganizerController Controlador que maneja las operaciones relacionadas con los torneos.
 */
$objOrganizerController = new organizerController();

/**
 * Recupera la información del torneo especificado por su ID.
 * 
 * @var array $lstTorneo Datos del torneo que se mostrarán en el formulario para su edición.
 */
$lstTorneo = $objTorneoController->readOneTorneos($_GET['id']);

$idOrganizador = $lstTorneo['idOrganizador'];

$organizador = $objOrganizerController->readOneOrganizer($idOrganizador);
require_once("template/header.php");
?>
<div class="container py-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0"><i class="fa-solid fa-trophy"></i>Información del Torneo</h5>
        </div>
        <div class="card-body">
            <form action="torneoUpdate.php?id=<?= $_GET['id'] ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <h6 for="nombreTorneo" class="form-h6">Nombre del Torneo</h6>
                    <input type="text" class="form-control" name="txtNombreTorneo" id="nombreTorneo"
                        value="<?= $lstTorneo['nombreTorneo'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <h6 for="logoTorneo" class="form-h6">Logotipo del Torneo</h6><br>
                    <?php
                    if (!empty($lstTorneo['logoTorneo'])) {
                        echo '<img src="' . $lstTorneo['logoTorneo'] . '" alt="Logo del equipo" class="img-fluid rounded"
                        style="max-height: 100px;">';
                    } else {
                        echo "No hay logo del Torneo";
                    }
                    ?>

                </div>
                <div class="mb-3">
                    <h6 for="patrocinador" class="form-h6">Patrocinador(es)</h6>
                    <textarea name="txtPatrocinador" id="patrocinador" rows="2" class="form-control"
                        readonly><?= $lstTorneo['patrocinadores'] ?></textarea>
                    <small class="form-text text-muted">Separa los nombres con una coma si hay más de un
                        patrocinador.</small>
                </div>
                <div class="mb-3">
                    <h6 for="logosPatrocinadores" class="form-h6">Logos de Patrocinadores</h6><br>
                    <?php
                    $logosPatrocinadoresStr = $lstTorneo['logoPatrocinadores'];
                    if (!empty($logosPatrocinadoresStr)) {
                        $logosPatrocinadores = explode(',', $logosPatrocinadoresStr);
                        foreach ($logosPatrocinadores as $logo) {
                            if(!empty($logo)){
                                echo '<img src="' . htmlspecialchars($logo) . '" alt="Logo del patrocinador" class="img-fluid rounded" style="max-height: 100px;">';
                            }
                        }
                    } else {
                        echo 'No hay logos de patrocinadores.';
                    }
                    ?>

                </div>
                <div class="mb-3">
                    <h6 for="organizador" class="form-h6">Organizador</h6>
                    <input type="text" class="form-control" name="txtOrganizador" id="organizador"
                        value="<?= $organizador['nombre'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <h6 for="sede" class="form-h6">Sede (lugar donde se realizará el torneo)</h6>
                    <input type="text" class="form-control" name="txtSede" id="sede" value="<?= $lstTorneo['sede'] ?>"
                        readonly>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 for="premio1" class="form-h6">Premio 1er Lugar</h6>
                        <input type="text" class="form-control" name="txtPremio1" id="premio1"
                            value="<?= $lstTorneo['premio1'] ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 for="premio2" class="form-h6">Premio 2do Lugar</h6>
                        <input type="text" class="form-control" name="txtPremio2" id="premio2"
                            value="<?= $lstTorneo['premio2'] ?>" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 for="premio3" class="form-h6">Premio 3er Lugar</h6>
                        <input type="text" class="form-control" name="txtPremio3" id="premio3"
                            value="<?= $lstTorneo['premio3'] ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 for="otroPremio" class="form-h6">Otro Premio</h6>
                        <input type="text" class="form-control" name="txtOtroPremio" id="otroPremio"
                            value="<?= $lstTorneo['otroPremio'] ?>" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 for="usuario" class="form-h6">Usuario Organizador</h6>
                        <input type="text" class="form-control" name="txtUsuarioOrganizador" id="usuario"
                            value="<?= $organizador['usuario'] ?>" readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <a href="readAllTorneo.php" class="btn btn-danger mt-4">
                        <i class="fa-solid fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </form>
        </div>
        <div class="card-footer text-muted text-center">
            <small>Detalles del torneo</small>
        </div>
    </div>
</div>



<?php
require_once("/template/footer.php");
?>