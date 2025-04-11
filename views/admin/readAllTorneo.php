<?php
/**
 * Página para capturar la información de un torneo.
 * 
 * Este archivo genera un formulario que permite a los usuarios registrar los datos de un torneo, 
 * incluyendo información como nombre, organizador, patrocinadores, premios y usuario. 
 * Los datos ingresados se envían al script `torneoInsert.php` para ser procesados.
 * 
 * PHP version 8.1
 * 
 * @category Views
 * @package  WebAppBasketBall
 * @author   Saúl Valenzuela Osuna
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("template/header.php");
require_once("../../controllers/torneosControllers.php");
require_once("../../controllers/organizerController.php");

$objTorneoController = new torneosController();
$objOrganizerController = new organizerController();
$rows = $objTorneoController->readTorneos();
?>

<div class="mx-auto p-5">
    <div class="card text-center shadow-lg rounded">
        <div class="card-header bg-primary text-white">
            <h5><i class="fa-solid fa-trophy"></i> Listado de Torneos </h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">TORNEO</th>
                        <th scope="col">ORGANIZADOR</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($rows): ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <th> <?= $row['id'] ?></th>
                                <th> <?= $row['nombreTorneo']; ?></th>
                                <th>
                                    <?php
                                        $organizador = $objOrganizerController->readOneOrganizer($row['idOrganizador']);
                                        echo $organizador['nombre'];
                                    ?>
                                </th>
                                <th>
                                    <a href="readOneTorneo.php?id=<?= $row['id'] ?>"
                                        class="btn btn-primary fa-solid fa-list-check"></a>

                                    <a href="updateTorneo.php?id=<?= $row['id'] ?>"
                                        class="btn btn-success fa-solid fa-pen-to-square"></a>

                                    <button type="button" class="btn btn-danger fa-solid fa-trash" data-bs-toggle="modal"
                                        data-bs-target="#idModal<?= $row['id'] ?>"></button>

                                    <div class="modal fade" id="idModal<?= $row['id'] ?>" tabindex="-1"
                                        aria-labelledby="modal<?= $row['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modal<?= $row['id'] ?>">¿Deseas eliminar el
                                                        torneo?</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    La acción no se puede deshacer.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <a href="deleteTorneo.php?id=<?= $row['id'] ?>"
                                                        class="btn btn-danger">Eliminar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                No hay torneos aún.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="admin.php" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("../admin/template/footer.php");
?>