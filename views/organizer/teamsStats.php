<?php
/**
 * Archivo para ver todas las estadísticas de todos los equipos del torneo
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
require_once("../../controllers/teamsController.php");
require_once("../../controllers/groupsController.php"); 

$objTorneoController = new torneosController();
$objTeamsController = new teamsController();
$objGroupsController = new groupsController();
$id = $_GET['id'];
$row = $objTorneoController->readOneTorneos($id);

$grupos = $objGroupsController->readGroupsByTournament($id);

$selectedGroupId = isset($_GET['grupo']) ? $_GET['grupo'] : null;

if ($selectedGroupId) {
    $equipos = $objTeamsController->readTeamsByGroupAndTournament($id, $selectedGroupId);
} else {
    $equipos = $objTeamsController->readTeamsByTournament($id);
}

?>
<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-black text-white text-center">
            <h3>Estadísticas de los Equipos - Torneo: <?= $row['nombreTorneo'] ?></h3>
        </div>
        <div class="card-body">
            <form method="GET" class="mb-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <div class="mb-3">
                    <label for="grupo" class="form-label">Seleccionar Grupo</label>
                    <select name="grupo" id="grupo" class="form-select" onchange="this.form.submit()" required>
                        <option value="" disabled selected>Seleccione un grupo</option>
                        <?php foreach ($grupos as $grupo): ?>
                            <option value="<?= htmlspecialchars($grupo['id']) ?>" <?= $selectedGroupId == $grupo['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($grupo['nombre']) ?> - <?= htmlspecialchars($grupo['categoria']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
            <table class="table table-bordered table-striped table-hover mt-4">
                <thead class="bg-secondary text-white">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Logo</th>
                        <th>Nombre del Equipo</th>
                        <th>Jugados</th>
                        <th>Ganados</th>
                        <th>Perdidos</th>
                        <th>Puntos a Favor</th>
                        <th>Puntos en Contra</th>
                        <th>Diferencia de puntos</th>
                        <th>Puntaje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($equipos)): ?>
                        <?php foreach ($equipos as $index => $equipo):
                            $jugados = $equipo['juegosGanados'] + $equipo['juegosPerdidos'];
                            $diferencia = $equipo['puntosAFavor'] - $equipo['puntosEnContra'] ?>
                            <tr class="text-center">
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <?php if (!empty($equipo['logo'])): ?>
                                        <img src="../img/teams/<?= htmlspecialchars($equipo['logo']) ?>"
                                            alt="Logo de <?= htmlspecialchars($equipo['nombreEquipo']) ?>"
                                            style="width: 50px; height: 50px;">
                                    <?php else: ?>
                                        <span>Sin logo</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($equipo['nombreEquipo']) ?></td>
                                <td><?= htmlspecialchars($jugados) ?></td>
                                <td><?= htmlspecialchars($equipo['juegosGanados']) ?></td>
                                <td><?= htmlspecialchars($equipo['juegosPerdidos']) ?></td>
                                <td><?= htmlspecialchars($equipo['puntosAFavor']) ?></td>
                                <td><?= htmlspecialchars($equipo['puntosEnContra']) ?></td>
                                <td><?= htmlspecialchars($diferencia) ?></td>
                                <td><?= htmlspecialchars($equipo['puntaje']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">No hay equipos registrados en este grupo.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted text-center">
            Histórico de las Estadísticas de los Equipos del Torneo - Basket-Ball Web App.
        </div>
    </div>
    <a href="organizer.php" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>
<?php
require_once("template/footer.php");
?>
