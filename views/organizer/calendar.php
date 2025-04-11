<?php
/**
 * Archivo para registrar un partido nuevo
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0.0  28-12-2024
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once("template/header.php");
require_once("../../controllers/teamsController.php");
require_once("../../controllers/torneosControllers.php");

$objEquiposController = new teamsController();
$objTorneosControllers = new torneosController();

$idTorneo = $_GET['idTorneo'];
$idGrupo = $_GET['grupo'];
$row = $objTorneosControllers->readOneTorneos($idTorneo);
$equipos = $objEquiposController->readTeamsByTournament($idTorneo);

$equipos = [];
if (!empty($idGrupo)) {
    $equipos = $objEquiposController->readTeamsByGroupAndTournament($idTorneo, $idGrupo);
}
?>

<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white text-center">
            <h3>Calendario de Juegos - Torneo: <?= htmlspecialchars($row['nombreTorneo']) ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="mb-3">Capturar un Juego</h5>
                    <form action="calendarInsert.php" method="POST">
                        <input type="hidden" name="idTorneo" value="<?= htmlspecialchars($idTorneo) ?>">

                        <!-- Seleccionar equipos -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="equipoLocal" class="form-label">Equipo Local</label>
                                <select name="equipoLocal" id="equipoLocal" class="form-select" required>
                                    <option value="">Seleccione un equipo local</option>
                                    <?php foreach ($equipos as $equipo): ?>
                                        <option value="<?= htmlspecialchars($equipo['id']) ?>">
                                            <?= htmlspecialchars($equipo['nombreEquipo']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="equipoVisitante" class="form-label">Equipo Visitante</label>
                                <select name="equipoVisitante" id="equipoVisitante" class="form-select" required>
                                    <option value="">Seleccione un equipo visitante</option>
                                    <?php foreach ($equipos as $equipo): ?>
                                        <option value="<?= htmlspecialchars($equipo['id']) ?>">
                                            <?= htmlspecialchars($equipo['nombreEquipo']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Datos del Juego -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha del Juego</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hora" class="form-label">Hora del Juego</label>
                                <input type="time" name="hora" id="hora" class="form-control" required>
                            </div>
                        </div>

                        <!-- Categoría y Tipo de Juego -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select name="categoria" id="categoria" class="form-select" required>
                                    <option value="1raFuerza">1ra Fuerza</option>
                                    <option value="2daFuerza">2da Fuerza</option>
                                    <option value="Libre">Libre</option>
                                    <option value="Veteranos">Veteranos</option>
                                    <option value="Empresarial">Empresarial</option>
                                    <option value="Infantil">Infantil</option>
                                    <option value="Juvenil">Juvenil</option>
                                    <option value="MiniBasket">MiniBasket</option>
                                    <option value="Femenil">Femenil</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rol" class="form-label">Rol</label>
                                <select name="rol" id="rol" class="form-select" required>
                                    <option value="Regular">Regular</option>
                                    <option value="Exhibición">Exhibición</option>
                                    <option value="Playoff">Playoff</option>
                                    <option value="Semifinal">Semifinal</option>
                                    <option value="Final">Final</option>
                                </select>
                            </div>
                        </div>

                        <!-- Sede -->
                        <div class="mb-3">
                            <label for="sede" class="form-label">Sede</label>
                            <input type="text" name="sede" id="sede" class="form-control" placeholder="Especifique la sede o cancha" required>
                        </div>

                        <!-- Botón para guardar -->
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fa-solid fa-calendar-check"></i> Registrar Juego
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-footer text-center text-muted">
            Gestión del Calendario de Juegos - Web App Basket-Ball.
        </div>
    </div>
    <a href="submodulesTorneo.php?id=<?= htmlspecialchars($idTorneo) ?>" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>
