<?php
/**
 * Archivo que sirve para insertar los resultados
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
require_once("../../controllers/gamesController.php");
require_once("../../controllers/torneosControllers.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

$objEquiposController = new teamsController();
$objPlayersController = new playerController();
$objGamesController = new gamesController();
$objTorneosControllers = new torneosController();

$idTorneo = $_POST['idTorneo'];
$idPartido = $_POST['idPartido'];

// Recuperamos la información del partido
$partido = $objGamesController->getGameById($idPartido);

// Recuperamos los jugadores de ambos equipos
$idEquipoLocal = $partido['equipoLocal'];
$idEquipoVisitante = $partido['equipoVisitante'];
$jugadoresLocal = $objPlayersController->readPlayersByTeam($idEquipoLocal);
$jugadoresVisitante = $objPlayersController->readPlayersByTeam($idEquipoVisitante);

// Marcadores
$marcadorLocal = $_POST['marcadorLocal'];
$marcadorVisitante = $_POST['marcadorVisitante'];

// Variables para el caso de ganador por default
$ganadorDefault = $_POST['ganadorDefault'];

// Si hay ganador por default
if ($ganadorDefault == 'si') {
    if (isset($_POST['ganadorEquipo'])) {
        if ($_POST['ganadorEquipo'] == 'local') {
            $marcadorLocal = 20;
            $marcadorVisitante = 0;
        } else {
            $marcadorLocal = 0;
            $marcadorVisitante = 20;
        }
    }
} else {

    foreach ($jugadoresLocal as $jugador) {
        $puntosLocal = $_POST["jugadorLocal_{$jugador['idJugador']}_puntos"];
        $tiros3Local = $_POST["jugadorLocal_{$jugador['idJugador']}_3puntos"];
        $faltasLocal = $_POST["jugadorLocal_{$jugador['idJugador']}_faltas"];

        // Actualizar estadísticas del jugador
        $objPlayersController->completePlayer($jugador['idJugador'], $puntosLocal, $tiros3Local, $faltasLocal);
    }

    foreach ($jugadoresVisitante as $jugador) {
        $puntosVisitante = $_POST["jugadorVisitante_{$jugador['idJugador']}_puntos"];
        $tiros3Visitante = $_POST["jugadorVisitante_{$jugador['idJugador']}_3puntos"];
        $faltasVisitante = $_POST["jugadorVisitante_{$jugador['idJugador']}_faltas"];


        $objPlayersController->completePlayer($jugador['idJugador'], $puntosVisitante, $tiros3Visitante, $faltasVisitante);
    }
}


// Aquí actualizamos el partido con los resultados
$objGamesController->updateGameResult($idPartido, $marcadorLocal, $marcadorVisitante, $idEquipoLocal, $idEquipoVisitante, $ganadorDefault);

// Calculamos los máximos anotadores del equipo local y visitante
$maximosLocal = calcularMaximosAnotadores($jugadoresLocal);
$maximosVisitante = calcularMaximosAnotadores($jugadoresVisitante);

// Actualizamos los equipos con los resultados
$objEquiposController->updateTeamResults($idEquipoLocal, $marcadorLocal, $marcadorVisitante, $ganadorDefault);
$objEquiposController->updateTeamResults($idEquipoVisitante, $marcadorVisitante, $marcadorLocal, $ganadorDefault);

header("Location: results.php?id=$idTorneo");
exit();


// Función para calcular los dos máximos anotadores
function calcularMaximosAnotadores($jugadores) {
    usort($jugadores, function($a, $b) {
        return $b['puntos'] - $a['puntos']; // Ordenamos por puntos
    });
    return array_slice($jugadores, 0, 2); // Retornamos los dos primeros jugadores
}
?>
