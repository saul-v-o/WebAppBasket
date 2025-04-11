<?php
/**
 * Archivo para ver el rol semanal de acuerdo a las fechas y al grupo seleccionado
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.3 20-01-2025
 */
require_once("template/header.php");
require_once("../../controllers/groupsController.php");
require_once("../../controllers/teamsController.php");

/**
 * @var teamsController Variable-instancia de la clase controladora de equipos
 */
$objTeamsController = new teamsController();

/**
 * @var groupsController Variable-instancia de la clase controladora de grupos
 */
$objGroupsController = new groupsController();

/**
 * @var string ID del torneo
 */
$idTorneo = $_GET['idTorneo'];

/**
 * @var string Fecha seleccionada, si no está se pone la fecha actual
 */
$selectedDate = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

/**
 * @var string Fecha inicio de semana seleccionada, en formato Y-m-d
 */
$inicioSemana = date('Y-m-d', strtotime('monday this week', strtotime($selectedDate)));

/**
 * @var string Fecha fin de semana seleccionada, en formato Y-m-d
 */
$finSemana = date('Y-m-d', strtotime('sunday this week', strtotime($selectedDate)));

/**
 * @var array Variable que contiene los grupos del torneo
 */
$grupos = $objGroupsController->readGroupsByTournament($idTorneo);

/**
 * @var string ID del grupo seleccionado
 */
$selectedGroupId = isset($_GET['grupo']) ? $_GET['grupo'] : null;

if ($selectedGroupId) {
    $equipos = $objTeamsController->readTeamsByGroupAndTournament($idTorneo, $selectedGroupId);
} else {
    $equipos = $objTeamsController->readTeamsByTournament($idTorneo);
}

/**
 * @var string URL de la API para obtener los juegos de cierto torneo y de cierto grupo
 */
$apiJuegos = "https://practicas.fimaz.uas.edu.mx/~lisi4104/WEBAPPBASKET/api/games/getGames.php?idTorneo=" . $idTorneo;
if ($selectedGroupId) {
    $apiJuegos = $apiJuegos. "&idGrupo=" . $selectedGroupId;
}

/**
 * @var bool|string|array Variable que guarda la respuesta de la API
 */
$responseJuegos = file_get_contents($apiJuegos);

/**
 * @var array Variable que guarda la respuesta de la API decodificada
 */
$juegos = json_decode($responseJuegos, true);

/**
 * @var array Variable que guardará los juegos de la semana seleccionada
 */
$juegosSemanaActual = [];
foreach ($juegos as $juego) {
    $fechaDelJuego = date('Y-m-d', strtotime($juego['fecha']));
    if ($fechaDelJuego >= $inicioSemana && $fechaDelJuego <= $finSemana) {
        $juegosSemanaActual[] = $juego;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rol Semanal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Rol Semanal</h1>
        <form method="GET" class="form-inline justify-content-center mb-4">
            <input type="hidden" name="idTorneo" value="<?= htmlspecialchars($idTorneo) ?>">
            <div class="mt-2">
                <label for="fecha" class="form-label">Seleccionar Semana:</label>
                <input type="date" id="fecha" name="fecha" value="<?= htmlspecialchars($selectedDate) ?>" class="form-control mr-2">
            </div>
            <div class="mt-2 ml-3 mr-3">
                <label for="grupo" class="form-label">Seleccionar Grupo</label>
                <select name="grupo" id="grupo" class="form-select" onchange="this.form.submit()">
                    <option value="">Todos los grupos</option>
                    <?php foreach ($grupos as $grupo): ?>
                        <option value="<?= htmlspecialchars($grupo['id']) ?>" <?= $selectedGroupId == $grupo['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($grupo['nombre']) ?> - <?= htmlspecialchars($grupo['categoria']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Ver Juegos</button>
        </form>

        <p class="text-center">Semana del <strong><?= $inicioSemana ?></strong> al <strong><?= $finSemana ?></strong></p>

        <?php if (!empty($juegosSemanaActual)): ?>
            <table class="table table-bordered table-hover mt-4">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Equipo Local</th>
                        <th>Equipo Visitante</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Rol</th>
                        <th>Sede</th>
                        <th>Categoría</th>
                        <th>Marcador Local</th>
                        <th>Marcador Visitante</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($juegosSemanaActual as $juego): ?>
                        <tr class="text-center">
                            <td><?= htmlspecialchars($juego['nombreEquipoLocal']) ?>
                                <?php if (!empty($juego['logoEquipoLocal'])): ?>
                                    <img src="../img/teams/<?= htmlspecialchars($juego['logoEquipoLocal']) ?>" alt="Logo de <?= htmlspecialchars($juego['equipoLocal']) ?>" style="width: 60px; height: 60px;">
                                <?php else: ?>
                                    <span>Sin logo</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($juego['nombreEquipoVisitante']) ?>
                                <?php if (!empty($juego['logoEquipoVisitante'])): ?>
                                    <img src="../img/teams/<?= htmlspecialchars($juego['logoEquipoVisitante']) ?>" alt="Logo de <?= htmlspecialchars($juego['equipoVisitante']) ?>" style="width: 60px; height: 60px;">
                                <?php else: ?>
                                    <span>Sin logo</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($juego['fecha']) ?></td>
                            <td><?= htmlspecialchars($juego['hora']) ?></td>
                            <td><?= htmlspecialchars($juego['rol']) ?></td>
                            <td><?= htmlspecialchars($juego['sede']) ?></td>
                            <td><?= htmlspecialchars($juego['categoria']) ?></td>
                            <td><?= htmlspecialchars($juego['marcadorLocal']) ?></td>
                            <td><?= htmlspecialchars($juego['marcadorVisitante']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center mt-4">
                No hay juegos programados para esta semana.
            </div>
        <?php endif; ?>

        <a href="standingGeneral.php?id=<?= $idTorneo ?>" class="btn btn-danger mt-4">Regresar</a>
        <a class="btn btn-warning mt-4" href="rolPDF.php?idTorneo=<?= htmlspecialchars($idTorneo) ?>&fecha=<?= htmlspecialchars($selectedDate) ?>&idGrupo=<?= htmlspecialchars($selectedGroupId) ?>">PDF del rol</a>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
require_once("template/footer.php");
?>
