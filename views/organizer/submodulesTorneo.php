<?php
/**
 * Archivo para ver todos los submódulos que existen para determinado torneo
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0   26-12-2024
 */

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once("template/header.php");
require_once("../../controllers/torneosControllers.php");
require_once("../../controllers/groupsController.php");

$objTorneoController = new torneosController();
$id = $_GET['id'];
$row = $objTorneoController->readOneTorneos($id);

$objGruposController = new groupsController();
$grupos = $objGruposController->readGroupsByTournament($id);
?>

<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white text-center">
            <h3>Submódulos para el torneo: <?= $row['nombreTorneo'] ?></h3>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-header bg-secondary text-white">
                            Grupos
                        </div>
                        <div class="card-body">
                            <form action="groups.php" method="POST">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                                <div class="mb-3">
                                    <input type="number" placeholder="Cantidad de grupos" name="txtGroups"
                                        class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fa-solid fa-layer-group"></i> Formar grupos
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-header bg-secondary text-white">
                            Equipos
                        </div>
                        <div class="card-body">
                            <a href="teams.php?id=<?= $row['id'] ?>" class="btn btn-success w-100">
                                <i class="fa-solid fa-people-group"></i> Ver equipos
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-header bg-secondary text-white">
                            Jugadores
                        </div>
                        <div class="card-body">
                            <a href="players.php?id=<?= $row['id'] ?>" class="btn btn-success w-100">
                                <i class="fa-solid fa-basketball"></i> Registrar jugadores
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt-4">
                <div class="col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-header bg-secondary text-white">
                            Calendario de Juegos
                        </div>
                        <div class="card-body">
                            <form action="calendar.php" method="GET">
                                <input type="hidden" name="idTorneo" value="<?= htmlspecialchars($id) ?>">
                                <div class="mb-3">
                                    <label for="grupo" class="form-label">Seleccionar Grupo</label>
                                    <select name="grupo" id="grupo" class="form-select" required>
                                        <option value="" disabled selected>Seleccione un grupo</option>
                                        <?php foreach ($grupos as $grupo): ?>
                                            <option value="<?= htmlspecialchars($grupo['id']) ?>">
                                                <?= htmlspecialchars($grupo['nombre']) ?> -
                                                <?= htmlspecialchars($grupo['categoria']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fa-solid fa-calendar-days"></i> Ir al calendario
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-header bg-secondary text-white">
                            Captura de Resultados de Jornadas
                        </div>
                        <div class="card-body">
                            <a href="results.php?id=<?= $row['id'] ?>" class="btn btn-success w-100">
                                <i class="fa-solid fa-file-pen"></i> Capturar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center text-muted">
            Configuración de torneos. Web App Basket-Ball.
        </div>
    </div>
    <a href="organizer.php" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>