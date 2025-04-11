<?php
/**
 * Archivo para ver el Standing General del torneo
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0   26-12-2024
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once("template/header.php");
require_once("../../controllers/torneosControllers.php");
require_once("../../controllers/teamsController.php");
require_once("../../controllers/groupsController.php");

$objTorneoController = new torneosController();
$objTeamsController = new teamsController();
$objGroupsController = new groupsController();
$id = $_GET['id'];
$torneo = $objTorneoController->readOneTorneos($id);

$categorias = $objGroupsController->readCategoriesByTournament($id);

$categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : null;

if ($categoriaSeleccionada) {
    $equipos = $objTeamsController->readTeamsByGroupAndTournament($categoriaSeleccionada, $id);
} else {
    $equipos = $objTeamsController->readTeamsByTournament($id);
}
?>
<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-black text-white text-center">
            <h3>Standing General - Torneo: <?= htmlspecialchars($torneo['nombreTorneo']) ?></h3>
        </div>
        <div class="text-center p-3">
            <span class="text-muted">* Haga click en el logo del equipo para ver su información *</span>
        </div>
        <div class="card-body">
            <form method="GET" class="mb-4">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <div class="mb-3">
                    <label for="categoria" class="form-label">Seleccionar categoria</label>
                    <select name="categoria" id="categoria" class="form-select" onchange="this.form.submit()" required>
                        <option value="" disabled selected>Seleccione una categoria</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['categoria']) ?>" <?= $cat['categoria'] == $categoriaSeleccionada ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['categoria']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
            <table class="table table-bordered table-striped table-hover">
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
                                        <a href="teamInfo.php?id=<?= urlencode($equipo['id']) ?>&idTorneo=<?= urlencode($id) ?>">
                                            <img src="../img/teams/<?= htmlspecialchars($equipo['logo']) ?>"
                                                alt="Logo de <?= htmlspecialchars($equipo['nombreEquipo']) ?>"
                                                style="width: 50px; height: 50px;">
                                            </>
                                        <?php else: ?>
                                            <a
                                                href="teamInfo.php?id=<?= urlencode($equipo['id']) ?>&idTorneo=<?= urlencode($id) ?>">
                                                <span>Sin logo</span>
                                            </a>
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
                            <td colspan="6" class="text-center">No hay equipos registrados en este torneo.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 p-4">
            <div class="card shadow-lg rounded">
                <div class="card-header">
                    <h5 class="card-title text-center">Sede, Premios y Patrocinadores</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-primary text-white text-center">
                                    <h5><i class="fa-solid fa-map-marker-alt"></i> Sede</h5>
                                </div>
                                <div class="card-body text-center">
                                    <p class="mb-0">
                                        <strong><?= htmlspecialchars($torneo['sede'] ?? 'Por definir') ?></strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-success text-white text-center">
                                    <h5><i class="fa-solid fa-trophy"></i> Premios</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <strong>Premio 1er Lugar:
                                        </strong><?= htmlspecialchars($torneo['premio1']) ?><br>
                                        <strong>Premio 2do Lugar:
                                        </strong><?= htmlspecialchars($torneo['premio2']) ?><br>
                                        <strong>Premio 3er Lugar:
                                        </strong><?= htmlspecialchars($torneo['premio3']) ?><br>
                                        <strong>Premio Extra: </strong><?= htmlspecialchars($torneo['otroPremio']) ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-warning text-black text-center">
                                    <h5><i class="fa-solid fa-handshake"></i> Patrocinadores</h5>
                                </div>
                                <div class="card-body text-center">
                                    <strong>Patrocinadores:
                                        <?= htmlspecialchars($torneo['patrocinadores']) ?></strong><br>
                                    <?php
                                    $logosPatrocinadoresStr = $torneo['logoPatrocinadores'];
                                    if (!empty($logosPatrocinadoresStr)) {
                                        $logosPatrocinadores = explode(',', $logosPatrocinadoresStr);
                                        foreach ($logosPatrocinadores as $logo) {
                                            if (!empty($logo)) {
                                                echo '<img src="' . htmlspecialchars($logo) . '" alt="Logo del patrocinador" class="img-fluid rounded" style="max-height: 100px;">';
                                            }
                                        }
                                    } else {
                                        echo 'No hay logos de patrocinadores.';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2 p-3 text-center">
            <a class="btn btn-warning" href="rolSemanal.php?idTorneo=<?= $id ?>"><i class="fa-solid fa-file-pdf"></i>
                Consultar el rol semanal</a>
        </div>
        <div class="card-footer text-muted text-center">
            Standing General del Torneo - Basket-Ball Web App.
        </div>
    </div>
    <a href="user.php" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>
<?php
require_once("template/footer.php");
?>