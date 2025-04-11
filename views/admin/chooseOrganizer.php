<?php
/**
 * Página para capturar la información de un admin
 * 
 * @category Views
 * @package  WebAppBasketBall
 * @author   Saúl Valenzuela Osuna
 * @version  1.0   23-12-2024
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("template/header.php");

require_once('../../controllers/organizerController.php');

$objOrganizadorController = new OrganizerController();

$organizadores = $objOrganizadorController->readOrganizers();
?>

<div class="mx-auto p-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Elegir Organizador</h4>
                </div>
                <div class="card-body text-center">
                    <form action="frmTorneosOrganizer.php" method="POST">
                        <div class="mb-3">
                            <label for="organizador" class="form-label">Elige a un Organizador para el torneo</label>
                            <select name="organizador" id="organizador" class="form-select" required>
                                <option value="">Seleccione un organizador</option>
                                <?php foreach ($organizadores as $organizador):?>
                                    <option value="<?= htmlspecialchars($organizador['id'])?>">
                                        <?= htmlspecialchars($organizador['nombre'])?> -- <?= htmlspecialchars($organizador['usuario'])?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                       <div class="text-center p-4">
                            <a class="text-muted" href="frmTorneos.php"><h6>O puedes hacer un organizador nuevo</h6></a>
                       </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Continuar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <a href="admin.php" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>