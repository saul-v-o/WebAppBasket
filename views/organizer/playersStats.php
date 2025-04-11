<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once("template/header.php");
require_once("../../controllers/torneosControllers.php");
require_once("../../controllers/playerController.php");
require_once("../../controllers/groupsController.php");
require_once("../../controllers/teamsController.php");

$objTorneoController = new torneosController();
$objPlayerController = new playerController();
$objGroupsController = new groupsController();
$objTeamsController = new teamsController();

$id = $_GET['id'];
$row = $objTorneoController->readOneTorneos($id);
$grupos = $objGroupsController->readGroupsByTournament($id);

$selectedGroupId = isset($_GET['grupo']) ? $_GET['grupo'] : null;
if ($selectedGroupId) {
    $equipos = $objTeamsController->readTeamsByGroupAndTournament($id, $selectedGroupId);
    $jugadores = [];
    foreach ($equipos as $equipo) {
        $jugadoresEquipo = $objPlayerController->readPlayersByTeam($equipo['id']);
        if ($jugadoresEquipo !== false) {
            $jugadores = array_merge($jugadores, $jugadoresEquipo);
        }
    }
} else {
    $jugadores = $objPlayerController->readPlayersByTournament($id);
}

?>
<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-black text-white text-center">
            <h3>Estadísticas de Jugadores - Torneo: <?= $row['nombreTorneo'] ?></h3>
        </div>
        <div class="card-body">
            <form method="GET" class="mb-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <div class="mb-3">
                    <label for="grupo" class="form-label">Seleccionar Grupo</label>
                    <select name="grupo" id="grupo" class="form-select" required>
                        <option value="" disabled selected>Seleccione un grupo</option>
                        <?php foreach ($grupos as $grupo): ?>
                            <option value="<?= htmlspecialchars($grupo['id']) ?>" <?= $selectedGroupId == $grupo['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($grupo['nombre']) ?> - <?= htmlspecialchars($grupo['categoria']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ver Jugadores</button>
            </form>
            <table class="table table-bordered table-striped table-hover mt-4">
                <thead class="bg-secondary text-white">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nombre del Jugador</th>
                        <th>Puntos</th>
                        <th>Tiros de 3</th>
                        <th>Faltas</th>
                        <th>Equipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($jugadores)): ?>
                        <?php foreach ($jugadores as $index => $jugador): ?>
                            <tr class="text-center">
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($jugador['nombre']) . " " . htmlspecialchars($jugador['apellidos']) ?>
                                </td>
                                <td><?= htmlspecialchars($jugador['puntos']) ?></td>
                                <td><?= htmlspecialchars($jugador['tiros3']) ?></td>
                                <td><?= htmlspecialchars($jugador['faltas']) ?></td>
                                <td><?= htmlspecialchars($jugador['nombreEquipo']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay jugadores registrados en este grupo.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted text-center">
            Histórico de las Estadísticas de los Jugadores - Basket-Ball Web App.
        </div>
    </div>
    <a href="organizer.php" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>