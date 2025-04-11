<?php
/**
 * Archivo que sirve para elegir el partido para capturar sus resultados
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0  28-12-2024
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once("template/header.php");
require_once("../../controllers/teamsController.php");
require_once("../../controllers/playerController.php");
require_once("../../controllers/torneosControllers.php");
require_once("../../controllers/gamesController.php");

$objEquiposController = new teamsController();
$objTorneosControllers = new torneosController();
$objPlayersController = new playerController();
$objGamesController = new gamesController();

$idTorneo = $_GET['id'];
$row = $objTorneosControllers->readOneTorneos($idTorneo);
$equipos = $objEquiposController->readTeamsByTournament($idTorneo);
$partidos = $objGamesController->getGamesByTournament($idTorneo);
?>

<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-warning text-white text-center">
            <h3>Captura de Resultado de Jornadas - Torneo: <?= htmlspecialchars($row['nombreTorneo']) ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-3">Capturar Resultado de Juego</h5>
                    <form action="resultsPlayers.php" method="POST">
                        <input type="hidden" name="idTorneo" value="<?= htmlspecialchars($idTorneo) ?>">

                        <!-- Selección de Partido -->
                        <div class="mb-3">
                            <label for="idPartido" class="form-label">Seleccione el Partido</label>
                            <select name="idPartido" id="idPartido" class="form-select" required>
                                <option value="">Seleccione un partido</option>
                                <?php foreach ($partidos as $partido): ?>
                                    <option value="<?= htmlspecialchars($partido['idPartido']) ?>">
                                        <?= htmlspecialchars($partido['equipoLocal']) ?> vs
                                        <?= htmlspecialchars($partido['equipoVisitante']) ?>
                                         - - Fecha: <?= htmlspecialchars($partido['fecha']) ?>
                                         - - Estatus: <?= htmlspecialchars($partido['estatus']) ?> 
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Botón para ir a la siguiente página -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-next"></i> Capturar Resultado
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-footer text-center text-muted">
            Gestión de Resultados - Web App Basket-Ball.
        </div>
    </div>
    <a href="submodulesTorneo.php?id=<?= htmlspecialchars($idTorneo) ?>" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>
