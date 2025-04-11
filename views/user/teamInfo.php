<?php
/**
 * Archivo para ver la información/estadísticas de un equipo específico
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0.0  28-12-2024
 */

require_once("template/header.php");

/**
 * @var string URL de la API de los equipos
 */
$apiEquipo = "https://practicas.fimaz.uas.edu.mx/~lisi4104/WEBAPPBASKET/api/teams/infoTeam.php?idEquipo=";

/**
 * @var string URL de la API de los jugadores
 */
$apiJugadores = "https://practicas.fimaz.uas.edu.mx/~lisi4104/WEBAPPBASKET/api/players/infoPlayer.php?idEquipo=";

/**
 * @var int ID del equipo a consultar
 */
$idEquipo = $_GET['id'];

/**
 * @var int ID del torneo al que pertenece el equipo
 */
$idTorneo = $_GET['idTorneo'];

/**
 * @var bool|string Respuesta de la API de los equipos
 */
$responseEquipo = file_get_contents($apiEquipo . $idEquipo);

/**
 * @var array|null Datos del equipo obtenidos de la API
 */
$equipo = json_decode($responseEquipo, true);

/**
 * @var bool|string Respuesta de la API de los jugadores
 */
$responseJugadores = file_get_contents($apiJugadores . $idEquipo);

/**
 * @var array|null Datos de los jugadores obtenidos de la API
 */
$jugadores = json_decode($responseJugadores, true); 

/**
 * @var int Cantidad de los partidos jugados en total
 */
$jugados = $equipo['juegosGanados'] + $equipo['juegosPerdidos'];

/**
 * @var int Cantidad de la diferencia de los puntos 
 */
$diferencia = $equipo['puntosAFavor'] - $equipo['puntosEnContra'];

?>

<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-black">
            <h3 class="text-white text-center">Información del Equipo:
                <?= htmlspecialchars($equipo['nombreEquipo']) ?>
            </h3>
        </div>
        <div class="card-body">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img src="../img/teams/<?= $equipo['logo'] ?>" alt="Logo del equipo"
                                class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                        <div class="col-md-9">
                            <h3 class="card-title"><strong> <?= htmlspecialchars($equipo['nombreEquipo']) ?></strong>
                            </h3>
                            <p class="p-1"><strong>Total de partidos jugados en el torneo:
                                </strong><?= htmlspecialchars($jugados) ?></p>
                            <p class="p-1"><strong>Capitán:</strong> <?= htmlspecialchars($equipo['capitan']) ?></p>
                            <p class="p-1"><strong>Correo:</strong> <?= htmlspecialchars($equipo['correo']) ?></p>
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-5">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="bg-secondary text-white">
                            <tr class="text-center">
                                <th>Ganados</th>
                                <th>Perdidos</th>
                                <th>Puntos a Favor</th>
                                <th>Puntos en Contra</th>
                                <th>Diferencia</th>
                                <th>Puntaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td><?= htmlspecialchars($equipo['juegosGanados']) ?></td>
                                <td><?= htmlspecialchars($equipo['juegosPerdidos']) ?></td>
                                <td><?= htmlspecialchars($equipo['puntosAFavor']) ?></td>
                                <td><?= htmlspecialchars($equipo['puntosEnContra']) ?></td>
                                <td><?= htmlspecialchars($diferencia) ?></td>
                                <td><?= htmlspecialchars($equipo['puntaje']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="text-center mt-3">
                    <h4>¡Conoce a los jugadores!</h4>
                </div>
                <div class="card-body table-responsive p-5">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="bg-secondary text-white">
                            <tr class="text-center">
                                <th>Fotografía</th>
                                <th>Nombre del Jugador</th>
                                <th>Puntos anotados</th>
                                <th>Tiros de 3 puntos</th>
                                <th>Faltas cometidas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($jugadores)): ?>
                                <?php foreach ($jugadores as $index => $jugador): ?>
                                    <tr class="text-center">
                                        <td><img src="../img/players/<?= $jugador['fotografia'] ?>" alt="Fotografia del jugador" class="img-fluid rounded" style="max-height: 90px;"></td>
                                        <td><?= htmlspecialchars($jugador['nombre']) . " " . htmlspecialchars($jugador['apellidos']) ?>
                                        </td>
                                        <td><?= htmlspecialchars($jugador['puntos']) ?></td>
                                        <td><?= htmlspecialchars($jugador['tiros3']) ?></td>
                                        <td><?= htmlspecialchars($jugador['faltas']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No hay jugadores registrados en este equipo.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <a href="standingGeneral.php?id=<?= $idTorneo ?>" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>
