<?php
/**
 * Archivo para ver todas las estadísticas de todos los equipos del torneo
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0   26-12-2024
 */

require_once("template/header.php");

/**
 * @var string URL de la API del standing
 */
$apiStanding = "https://practicas.fimaz.uas.edu.mx/~lisi4104/WEBAPPBASKET/api/standing/infoStanding.php?id=";

/**
 * @var string Variable que contiene el id del torneo
 */
$id = $_GET['id'];

/**
 * @var bool|string Variable qu contiene la respuesta de la API (el standing)
 */
$responseStanding = file_get_contents($apiStanding . $id);

/**
 * @var array Variable que contiene la respuesta de la API ya decodificada
 */
$standing = json_decode($responseStanding, true);

$torneo = $standing['torneo'];
$equipos = $standing['equipos'];

?>
<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-warning text-black text-center">
            <h3>Histórico - Torneo: <?= $torneo['nombreTorneo'] ?></h3>
        </div>
        <div class="card-body">
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
                            $diferencia = $equipo['puntosAFavor'] - $equipo['puntosEnContra']?>
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
                            <td colspan="6" class="text-center">No hay equipos registrados en este torneo.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted text-center">
            Histórico de las Estadísticas de los Equipos del Torneo - Basket-Ball Web App.
        </div>
    </div>
    <a href="standingGeneral.php?id=<?= $id ?>" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>
<?php
require_once("template/footer.php");
?>