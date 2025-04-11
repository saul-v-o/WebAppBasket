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
            <h5 class="mb-0"><i class="fa-solid fa-trophy"></i> Actualizar la Información del Torneo</h5>
        </div>
        <div class="card-body">
            <form action="torneoUpdate.php?id=<?= $_GET['id'] ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nombreTorneo" class="form-label">Nombre del Torneo</label>
                    <input type="text" class="form-control" name="txtNombreTorneo" id="nombreTorneo"
                        value="<?= $lstTorneo['nombreTorneo'] ?>">
                </div>
                <div class="mb-3">
                    <label for="logoTorneo" class="form-label">Logotipo del Torneo</label><br>
                    <input type="hidden" name="logoTorneo" value="<?= htmlspecialchars($lstTorneo['logoTorneo']) ?>">
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
                    <label for="patrocinador" class="form-label">Patrocinador(es)</label>
                    <textarea name="txtPatrocinador" id="patrocinador" rows="2"
                        class="form-control"><?= $lstTorneo['patrocinadores'] ?></textarea>
                    <small class="form-text text-muted">Separa los nombres con una coma si hay más de un
                        patrocinador.</small>
                </div>
                <div class="mb-3">
                    <label for="logosPatrocinadores" class="form-label">Logos de Patrocinadores</label><br>
                    <input type="hidden" name="logoPatrocinadores"
                        value="<?= htmlspecialchars($lstTorneo['logoPatrocinadores']) ?>">
                    <?php
                    $logosPatrocinadoresStr = $lstTorneo['logoPatrocinadores'];
                    if (!empty($logosPatrocinadoresStr)) {
                        $logosPatrocinadores = explode(',', $logosPatrocinadoresStr);
                        foreach ($logosPatrocinadores as $logo) {
                            if (!empty($logo)) {
                                echo '<img src="' . htmlspecialchars($logo) . '" alt="Logo del patrocinador" class="img-fluid rounded" style="max-height: 100px;">';
                                echo '<a class="btn btn-danger" href="deleteLogoPatrocinador.php?id=' . $_GET['id'] . '&logo=' . $logo . '">Eliminar</a>';
                            }
                        }
                    } else {
                        echo 'No hay logos de patrocinadores.';
                    }
                    ?>

                    <label for="logosPatrocinadores" class="form-label">Subir Logos de Patrocinadores</label>
                    <input type="file" class="form-control" name="fileLogosPatrocinadores[]" id="logosPatrocinadores"
                        accept="image/*" multiple>
                </div>
                <div class="mb-3">
                    <label for="organizador" class="form-label">Organizador</label>
                    <input type="text" class="form-control" name="txtOrganizador" id="organizador"
                        value="<?= $organizador['nombre'] ?>">
                </div>
                <div class="mb-3">
                    <label for="sede" class="form-label">Sede (lugar donde se realizará el torneo)</label>
                    <input type="text" class="form-control" name="txtSede" id="sede" value="<?= $lstTorneo['sede'] ?>">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="premio1" class="form-label">Premio 1er Lugar</label>
                        <input type="text" class="form-control" name="txtPremio1" id="premio1"
                            value="<?= $lstTorneo['premio1'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="premio2" class="form-label">Premio 2do Lugar</label>
                        <input type="text" class="form-control" name="txtPremio2" id="premio2"
                            value="<?= $lstTorneo['premio2'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="premio3" class="form-label">Premio 3er Lugar</label>
                        <input type="text" class="form-control" name="txtPremio3" id="premio3"
                            value="<?= $lstTorneo['premio3'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="otroPremio" class="form-label">Otro Premio</label>
                        <input type="text" class="form-control" name="txtOtroPremio" id="otroPremio"
                            value="<?= $lstTorneo['otroPremio'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="usuario" class="form-label">Usuario Organizador</label>
                        <input type="text" class="form-control" name="txtUsuarioOrganizador" id="usuario"
                            value="<?= $organizador['usuario'] ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Guardar</button>
                    <a href="admin.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
        <div class="card-footer text-muted text-center">
            <small>Formulario para registrar torneo</small>
        </div>
    </div>
</div>



<?php
require_once("/template/footer.php");
?>