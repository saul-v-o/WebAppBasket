<?php
    /**
     * Controlador para el Calendario de Juegos
     * 
     * @package WebAppBasketBall
     * @subpackage Controllers
     * @author Saúl Valenzuela Osuna
     * @version 1.0   26-12-2024
     */
    require_once("../../models/calendarModel.php");
    class calendarController
    {
        /**
         * @var calendarModel Instancia del modelo para gestionar el calendario de juegos.
         */
        private $model;

        public function __construct()
        {
            $this->model = new calendarModel();
        }

        /**
         * Guarda un nuevo juego en el calendario.
         *
         * @param int $idTorneo Identificador único del torneo.
         * @param int $equipoLocal ID del equipo local.
         * @param int $equipoVisitante ID del equipo visitante.
         * @param string $fecha Fecha del juego.
         * @param string $hora Hora del juego.
         * @param string $categoria Categoria del juego
         * @param string $rol Tipo de juego (Regular, Exhibición, Play-off, Semifinal, Final).
         * @param string $sede Sede donde se jugará el partido.
         * @return void Redirige a la página de calendario del torneo o muestra un mensaje de error.
         */
        public function saveGame($idTorneo, $equipoLocal, $equipoVisitante, $fecha, $hora, $categoria, $rol, $sede)
        {
            /**
             * @var bool|int Variable que devuelve el id del juego insertado
             */
            $id = $this->model->insert($idTorneo, $equipoLocal, $equipoVisitante, $fecha, $hora, $categoria, $rol, $sede);

            if ($id !== false) {
                header("Location: submodulesTorneo.php?id=".$idTorneo);
            } else {
                header("Location: calendar.php?id=".$idTorneo);
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
            return ($this->model->getGamesByTournament($idTorneo)) ? $this->model->getGamesByTournament($idTorneo) : false;
        }

        /**
         * Obtiene un juego específico por su ID.
         * 
         * @param int $id ID del juego.
         * @return array|false Datos del juego si existe, redirige en caso contrario.
         */
        public function getGameById($id)
        {
            /**
             * @var array|bool Variable que contiene los datos del juego
             */
            $game = $this->model->getGameById($id);

            if ($game !== false) {
                return $game;
            } else {
                header("Location: gamesSchedule.php");
                return false;
            }
        }

        /**
         * Actualiza un juego existente en el calendario.
         * 
         * @param int $id Identificador único del juego.
         * @param int $equipoLocal ID del equipo local.
         * @param int $equipoVisitante ID del equipo visitante.
         * @param string $fecha Fecha del juego.
         * @param string $hora Hora del juego.
         * @param string $rol Tipo de juego.
         * @param string $sede Sede del juego.
         * @return void Redirige al calendario o muestra un mensaje de error.
         */
        public function updateGame($id, $equipoLocal, $equipoVisitante, $fecha, $hora, $rol, $sede)
        {
            /**
             * @var string|bool|array Variable que contiene el id del torneo
             */
            $idTorneo = $this->model->getGameById($id)['idTorneo'];

            /**
             * @var bool Variable que dice si se pudo actualizar el juego
             */
            $update = $this->model->update($id, $equipoLocal, $equipoVisitante, $fecha, $hora, $rol, $sede);

            if ($update !== false) {
                header("Location: gamesSchedule.php?idTorneo=" . $idTorneo);
            } else {
                header("Location: editGame.php?id=" . $id);
            }
        }

        /**
         * Elimina un juego del calendario.
         * 
         * @param int $id ID del juego.
         * @return void Redirige al calendario de juegos.
         */
        public function deleteGame($id)
        {
            /**
             * @var string|bool|array Variable que contiene el id del torneo
             */
            $idTorneo = $this->model->getGameById($id)['idTorneo'];

            if ($this->model->delete($id)) {
                header("Location: gamesSchedule.php?idTorneo=" . $idTorneo);
            } else {
                header("Location: gameDetails.php?id=" . $id);
            }
        }
    }
?>
