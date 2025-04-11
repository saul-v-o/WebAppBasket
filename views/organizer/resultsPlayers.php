<?php
/**
 * Archivo para capturar todos los resultados de un pjuego en específico
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

$idTorneo = $_POST['idTorneo'];
$row = $objTorneosControllers->readOneTorneos($idTorneo);
$equipos = $objEquiposController->readTeamsByTournament($idTorneo);
$partidos = $objGamesController->getGamesByTournament($idTorneo);

$idPartido = $_POST['idPartido'];
$partidoSeleccionado = null;

foreach ($partidos as $partido) {
    if ($partido['idPartido'] == $idPartido) {
        $partidoSeleccionado = $partido;
        break;
    }
}

if ($partidoSeleccionado !== null) {

    $idEquipoLocal = $partidoSeleccionado['idEquipoLocal'];
    $idEquipoVisitante = $partidoSeleccionado['idEquipoVisitante'];

    $jugadoresLocal = $objPlayersController->readPlayersByTeam($idEquipoLocal);
    $jugadoresVisitante = $objPlayersController->readPlayersByTeam($idEquipoVisitante);
} else {
    echo "No se encontró el partido seleccionado.";
}

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
                    <form action="resultsInsert.php" method="POST">
                        <input type="hidden" name="idTorneo" value="<?= htmlspecialchars($idTorneo) ?>">
                        <input type="hidden" name="idPartido" value="<?= htmlspecialchars($idPartido) ?>">

                        <!-- Marcadores -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marcadorLocal" class="form-label">Marcador Equipo Local</label>
                                <input type="number" name="marcadorLocal" id="marcadorLocal" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marcadorVisitante" class="form-label">Marcador Equipo Visitante</label>
                                <input type="number" name="marcadorVisitante" id="marcadorVisitante"
                                    class="form-control" required>
                            </div>
                        </div>

                        <!-- Jugadores del Equipo Local -->
                        <h6 class="mb-3">Jugadores Equipo Local</h6>
                        <div class="mb-3" id="jugadoresLocal">
                            <?php if (!empty($jugadoresLocal)): ?>
                                <?php foreach ($jugadoresLocal as $jugador): ?>
                                    <div class="card-body bg-light rounded">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label for="jugadorLocal_<?= $jugador['idJugador'] ?>" class="form-label">
                                                    <?= htmlspecialchars($jugador['nombre']) ?>
                                                    <?= htmlspecialchars($jugador['apellidos']) ?>
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="jugadorLocal_<?= $jugador['idJugador'] ?>_puntos"
                                                    class="form-control" placeholder="Puntos" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="jugadorLocal_<?= $jugador['idJugador'] ?>_3puntos"
                                                    class="form-control" placeholder="Tiros 3 puntos" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="jugadorLocal_<?= $jugador['idJugador'] ?>_faltas"
                                                    class="form-control" placeholder="Faltas" required>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay jugadores para el equipo local.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Jugadores del Equipo Visitante -->
                        <h6 class="mb-3">Jugadores Equipo Visitante</h6>
                        <div class="mb-3" id="jugadoresVisitante">
                            <?php if (!empty($jugadoresVisitante)): ?>
                                <?php foreach ($jugadoresVisitante as $jugador): ?>
                                    <div class="card-body bg-light rounded">
                                        <div class="row mb-2">
                                        <div class="col-md-4">
                                                <label for="jugadorVisitante_<?= $jugador['idJugador'] ?>" class="form-label">
                                                    <?= htmlspecialchars($jugador['nombre']) ?>
                                                    <?= htmlspecialchars($jugador['apellidos']) ?>
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="jugadorVisitante_<?= $jugador['idJugador'] ?>_puntos"
                                                    class="form-control" placeholder="Puntos" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="jugadorVisitante_<?= $jugador['idJugador'] ?>_3puntos"
                                                    class="form-control" placeholder="Tiros 3 puntos" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="jugadorVisitante_<?= $jugador['idJugador'] ?>_faltas"
                                                    class="form-control" placeholder="Faltas" required>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay jugadores para el equipo visitante.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Ganador por default -->
                        <div class="mb-3">
                            <label for="ganadorDefault" class="form-label">¿Ganó por Default?</label>
                            <div>
                                <input type="radio" id="ganadorDefaultNo" name="ganadorDefault" value="no"
                                    class="form-check-input">
                                <label for="ganadorDefaultNo" class="form-check-label">No</label>
                            </div>
                            <div>
                                <input type="radio" id="ganadorDefaultSi" name="ganadorDefault" value="si"
                                    class="form-check-input">
                                <label for="ganadorDefaultSi" class="form-check-label">Sí</label>
                            </div>
                        </div>

                        <!-- Botón para guardar -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-save"></i> Guardar Resultado
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