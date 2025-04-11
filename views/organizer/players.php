<?php
/**
 * Archivo para capturar los jugadores de los equipos participantes
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
require_once("../../controllers/teamsController.php");
require_once("../../controllers/playerController.php");
require_once("../../controllers/torneosControllers.php");

$objEquiposController = new teamsController();
$objTorneosControllers = new torneosController();
$objPlayersController = new playerController();
$idTorneo = $_GET['id'];
$row = $objTorneosControllers->readOneTorneos($idTorneo);
$equipos = $objEquiposController->readTeamsByTournament($idTorneo);
?>

<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white text-center rounded-top">
            <h3>Captura de Jugadores - Torneo: <?= htmlspecialchars($row['nombreTorneo']) ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h5 class="mb-3 text-center">Capturar Jugadores para un Equipo</h5>
                    <form action="playerInsert.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="idTorneo" value="<?= htmlspecialchars($idTorneo) ?>">

                        <!-- Seleccionar equipo -->
                        <div class="mb-3">
                            <label for="idEquipo" class="form-label">Seleccionar Equipo</label>
                            <select name="idEquipo" id="idEquipo" class="form-select form-control-lg shadow-sm" required>
                                <option value="">Seleccione un equipo</option>
                                <?php foreach ($equipos as $equipo): ?>
                                    <option value="<?= htmlspecialchars($equipo['id']) ?>">
                                        <?= htmlspecialchars($equipo['nombreEquipo']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Datos del Jugador -->
                        <div class="mb-3">
                            <label for="nombreJugador" class="form-label">Nombre del Jugador</label>
                            <input type="text" name="nombreJugador" id="nombreJugador" class="form-control form-control-lg shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidosJugador" class="form-label">Apellidos del Jugador</label>
                            <input type="text" name="apellidosJugador" id="apellidosJugador" class="form-control form-control-lg shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control form-control-lg shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="correoJugador" class="form-label">Correo Electrónico</label>
                            <input type="email" name="correoJugador" id="correoJugador" class="form-control form-control-lg shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="celularJugador" class="form-label">Celular</label>
                            <input type="text" name="celularJugador" id="celularJugador" class="form-control form-control-lg shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipoSangre" class="form-label">Tipo de Sangre</label>
                            <input type="text" name="tipoSangre" id="tipoSangre" class="form-control form-control-lg shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactoEmergencia" class="form-label">Contacto de Emergencia</label>
                            <input type="text" name="contactoEmergencia" id="contactoEmergencia" class="form-control form-control-lg shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label for="fotografiaJugador" class="form-label">Fotografía del Jugador</label>
                            <input type="file" name="fotografiaJugador" id="fotografiaJugador" class="form-control form-control-lg shadow-sm" accept="image/*" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 shadow-sm">
                            <i class="fa-solid fa-plus"></i> Agregar Jugador
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-footer text-center text-muted">
            Gestión de Jugadores. Web App Basket-Ball.
        </div>
    </div>
    <a href="submodulesTorneo.php?id=<?= htmlspecialchars($idTorneo) ?>" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>
