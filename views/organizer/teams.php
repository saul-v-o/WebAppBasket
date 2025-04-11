<?php
/**
 * Archivo para mostrar y gestionar los equipos participantes del torneo
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0   26-12-2024
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once("template/header.php");
require_once("../../controllers/teamsController.php");
require_once("../../controllers/torneosControllers.php");
require_once("../../controllers/groupsController.php");

$objEquiposController = new teamsController();
$idTorneo = $_GET['id'];
$equipos = $objEquiposController->readTeamsByTournament($idTorneo);


$objTorneoController = new torneosController();
$row = $objTorneoController->readOneTorneos($idTorneo);

$objGruposController = new groupsController();
$grupos = $objGruposController->readGroupsByTournament($idTorneo);

$idGrupoSeleccionado = isset($_POST['grupo']) ? $_POST['grupo'] : '';

$equipos = [];
if (!empty($idGrupoSeleccionado)) {
    $equipos = $objEquiposController->readTeamsByGroupAndTournament($idTorneo, $idGrupoSeleccionado);
}

?>

<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white text-center">
            <h3>Equipos Participantes - Torneo: <?= htmlspecialchars($row['nombreTorneo']) ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <form action="" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="grupo" class="form-label">Seleccionar Grupo</label>
                            <select name="grupo" id="grupo" class="form-select">
                                <option value="" disabled selected>Seleccione un grupo</option>
                                <?php foreach ($grupos as $grupo): ?>
                                    <option value="<?= htmlspecialchars($grupo['id']) ?>"
                                        <?= ($grupo['id'] == $idGrupoSeleccionado) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($grupo['nombre']) ?> --
                                        <?= htmlspecialchars($grupo['categoria']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button type="submit" class="btn btn-primary">Mostrar Equipos</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <h5 class="mb-3">Lista de Equipos</h5>
                    <?php if (!empty($equipos)): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Nombre del Equipo</th>
                                    <th>Capitán</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($equipos as $equipo): ?>
                                    <tr>
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
                                        <td><?= htmlspecialchars($equipo['capitan']) ?></td>
                                        <td><?= htmlspecialchars($equipo['correo']) ?></td>
                                        <td><?= htmlspecialchars($equipo['celular']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning">No hay equipos registrados para el grupo seleccionado.</div>
                    <?php endif; ?>

                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Agregar Nuevo Equipo</h5>
                    <form action="teamInsert.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="idTorneo" value="<?= htmlspecialchars($idTorneo) ?>">
                        <div class="mb-3">
                            <label for="grupoEquipo" class="form-label">Grupo del Equipo</label>
                            <select name="grupo" id="grupo" class="form-select">
                                <option value="" disabled selected>Seleccione un grupo</option>
                                <?php foreach ($grupos as $grupo): ?>
                                    <option value="<?= htmlspecialchars($grupo['id']) ?>">
                                        <?= htmlspecialchars($grupo['nombre']) ?> -
                                        <?= htmlspecialchars($grupo['categoria']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nombreEquipo" class="form-label">Nombre del Equipo</label>
                            <input type="text" name="nombreEquipo" id="nombreEquipo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombreCapitán" class="form-label">Nombre del Capitán</label>
                            <input type="text" name="nombreCapitán" id="nombreCapitán" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="correoCapitán" class="form-label">Correo del Capitán</label>
                            <input type="email" name="correoCapitán" id="correoCapitán" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="celularCapitán" class="form-label">Celular del Capitán</label>
                            <input type="text" name="celularCapitán" id="celularCapitán" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="logoEquipo" class="form-label">Logo del Equipo</label>
                            <input type="file" name="logoEquipo" id="logoEquipo" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fa-solid fa-plus"></i> Agregar Equipo
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-footer text-center text-muted">
            Gestión de Equipos. Web App Basket-Ball.
        </div>
    </div>
    <a href="submodulesTorneo.php?id=<?= htmlspecialchars($idTorneo) ?>" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>