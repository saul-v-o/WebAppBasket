<?php
/**
 * Página que muestra el menú principal para un organizador
 * 
 * @package WebAppBasketBall
 * @author Saúl Valenzuela Osuna
 * @version 1.0   23-12-2024
 */

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once("template/header.php");
require_once("../../controllers/torneosControllers.php");

$objTorneoController = new torneosController();
$rows = $objTorneoController->readTorneosByOrganizer($_SESSION['id']);
?>

<div class="container mt-5 mb-4 text-center">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white text-center">
            <h4><i class="fa-solid fa-trophy"></i> Listado de Torneos Asignados</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Logo</th>
                        <th scope="col">Torneo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($rows): ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td> 
                                    <?php
                                        if (!empty($row['logoTorneo'])) {
                                            echo '<img src="' . $row['logoTorneo'] . '" alt="Logo del equipo" class="img-fluid rounded"
                                                style="max-height: 100px;">';
                                        } else {
                                            echo "No hay logo del Torneo";
                                        }
                                    ?>
                                </td>
                                <td><?= $row['nombreTorneo'] ?></td>
                                <td>
                                    <a href="submodulesTorneo.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-eye"></i> Ver Submódulos
                                    </a>
                                    <a href="playersStats.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-user"></i> Jugadores
                                    </a>
                                    <a href="teamsStats.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-users"></i> Equipos
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No hay torneos aún.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
require_once("template/footer.php");
?>