<?php
/**
 * Página que muestra el menú principal para un usuario/jugador
 * 
 * @package WebAppBasketBall
 * @author Saúl Valenzuela Osuna
 * @version 1.0   23-12-2024
 */
require_once("template/header.php");
require_once("../../controllers/torneosControllers.php");
require_once("../../controllers/organizerController.php");

$objTorneoController = new torneosController();

$objOrganizerController = new organizerController();

$organizadores = $objOrganizerController->readOrganizers();
$rows = $objTorneoController->readTorneos();
?>

<div class="mx-auto p-5">
    <div class="card text-center shadow-lg rounded">
        <div class="card-header">
            <span><i class="fa-solid fa-trophy"></i> Listado de Torneos </span>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light bg-dark">
                    <tr>
                        <th scope="col">Logo del Torneo</th>
                        <th scope="col">Nombre del Torneo</th>
                        <th scope="col">Organizador</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($rows): ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <th> 
                                    <?php
                                        if (!empty($row['logoTorneo'])) {
                                            echo '<img src="' . $row['logoTorneo'] . '" alt="Logo del equipo" class="img-fluid rounded"
                                                style="max-height: 100px;">';
                                        } else {
                                            echo "No hay logo del Torneo";
                                        }
                                    ?>
                                </th>
                                <th> <?= $row['nombreTorneo']; ?></th>
                                <th> 
                                    <?php 
                                        $organizador = $objOrganizerController->readOneOrganizer($row['idOrganizador']);
                                        echo $organizador['nombre'];
                                    ?>
                                </th>
                                <th>
                                    <a href="standingGeneral.php?id=<?= $row['id'] ?>" class="btn btn-success">Ver Standing
                                        General</a>
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
    <a href="../../index.php" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>