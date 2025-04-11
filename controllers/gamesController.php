<?php
/**
 * Controlador para gestionar los juegos de un torneo.
 * 
 * @package WebAppBasketBall
 * @subpackage Controllers
 * @author Saúl Valenzuela Osuna
 * @version 1.0   26-12-2024
 */

require_once("../../models/gamesModel.php");

class gamesController
{
    /**
     * @var gamesModel Instancia del modelo para gestionar los juegos.
     */
    private $model;

    public function __construct()
    {
        $this->model = new gamesModel();
    }

    /**
     * Guarda un nuevo juego en la base de datos.
     *
     * @param int $idTorneo Identificador único del torneo.
     * @param int $equipoLocal ID del equipo local.
     * @param int $equipoVisitante ID del equipo visitante.
     * @param string $fecha Fecha del juego.
     * @param string $hora Hora del juego.
     * @param string $rol Tipo de juego (Regular, Exhibición, Playoff, Semifinal, Final).
     * @param string $sede Sede donde se jugará el partido.
     * @return void Redirige al calendario del torneo o muestra un mensaje de error.
     */
    public function saveGame($idTorneo, $equipoLocal, $equipoVisitante, $fecha, $hora, $rol, $sede)
    {
        /**
         * @var bool|int Variable que contiene el id del juego guardado
         */
        $id = $this->model->insert($idTorneo, $equipoLocal, $equipoVisitante, $fecha, $hora, $rol, $sede);

        if ($id !== false) {
            header("Location: tournamentGames.php?idTorneo=" . $idTorneo);
        } else {
            header("Location: addGame.php?idTorneo=" . $idTorneo . "&error=1");
        }
    }

    /**
     * Obtiene todos los juegos de un torneo específico.
     * 
     * @param int $idTorneo ID del torneo.
     * @return array|false Lista de juegos si existen, false en caso contrario.
     */
    public function getGamesByTournament($idTorneo)
    {
        return $this->model->getGamesByTournament($idTorneo);
    }

    /**
     * Obtiene un juego específico por su ID.
     * 
     * @param int $id ID del juego.
     * @return array|false Datos del juego si existe, false en caso contrario.
     */
    public function getGameById($id)
    {
        return $this->model->getGameById($id);
    }

    /**
     * Actualiza el resultado de un partido en la base de datos.
     *
     * Este método permite actualizar el marcador de un partido, incluyendo los marcadores del equipo local y visitante, 
     * así como identificar al ganador en caso de ser un resultado por default.
     *
     * @param int $idPartido El ID del partido que se va a actualizar.
     * @param int $marcadorLocal El marcador del equipo local.
     * @param int $marcadorVisitante El marcador del equipo visitante.
     * @param int $idEquipoLocal El ID del equipo local.
     * @param int $idEquipoVisitante El ID del equipo visitante.
     * @param bool $ganadorDefault Indica si el ganador fue determinado por default (true) o no (false).
     * 
     * @return bool Indica si la actualización fue exitosa o no.
     */
    public function updateGameResult($idPartido, $marcadorLocal, $marcadorVisitante, $idEquipoLocal, $idEquipoVisitante, $ganadorDefault)
    {
        return $this->model->updateGameResult($idPartido, $marcadorLocal, $marcadorVisitante, $idEquipoLocal, $idEquipoVisitante, $ganadorDefault);
    }

    /**
     * Actualiza un juego existente en la base de datos.
     * 
     * @param int $id ID del juego.
     * @param int $equipoLocal ID del equipo local.
     * @param int $equipoVisitante ID del equipo visitante.
     * @param string $fecha Fecha del juego.
     * @param string $hora Hora del juego.
     * @param string $rol Tipo de juego.
     * @param string $sede Sede del juego.
     * @return void Redirige al calendario del torneo o muestra un mensaje de error.
     */
    public function updateGame($id, $equipoLocal, $equipoVisitante, $fecha, $hora, $rol, $sede)
    {
        /**
         * @var string|bool|array Variable que contiene el id del torneo
         */
        $idTorneo = $this->model->getGameById($id)['idTorneo'];

        if ($this->model->update($id, $equipoLocal, $equipoVisitante, $fecha, $hora, $rol, $sede)) {
            header("Location: tournamentGames.php?idTorneo=" . $idTorneo);
        } else {
            header("Location: editGame.php?id=" . $id . "&error=1");
        }
    }

    /**
     * Elimina un juego de la base de datos.
     * 
     * @param int $id ID del juego.
     * @return void Redirige al calendario del torneo.
     */
    public function deleteGame($id)
    {
        /**
         * @var string|bool|array Variable que contiene el id del torneo
         */
        $idTorneo = $this->model->getGameById($id)['idTorneo'];

        if ($this->model->delete($id)) {
            header("Location: tournamentGames.php?idTorneo=" . $idTorneo);
        } else {
            header("Location: gameDetails.php?id=" . $id . "&error=1");
        }
    }

    public function getGamesByGroupAndTournament($idTorneo, $idGrupo){
        return $this->model->getGamesByTournamentAndGroup($idTorneo, $idGrupo);
    }
}
?>