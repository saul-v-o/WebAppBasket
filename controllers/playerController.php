<?php
    /**
     * Controlador para los jugadores
     * 
     * @package WebAppBasketBall
     * @subpackage Controllers
     * @author Saúl Valenzuela Osuna
     * @version 1.0    26-12-2024
     */
    require_once("../../models/playerModel.php");

    class playerController
    {
        /**
         * @var playerModel Instancia del modelo para gestionar los jugadores.
         */
        private $model;

        public function __construct()
        {
            $this->model = new playerModel();
        }

        /**
         * Guarda un nuevo jugador en la base de datos.
         *
         * @param int $idEquipo Identificador único del equipo al que pertenece el jugador.
         * @param string $nombre Nombre del jugador.
         * @param string $apellidos Apellidos del jugador.
         * @param string $fechaNacimiento Fecha de nacimiento del jugador.
         * @param string $correo Correo electrónico del jugador.
         * @param string $celular Celular del jugador.
         * @param string $tipoSangre Tipo de sangre del jugador.
         * @param string $contactoEmergencia Contacto de emergencia del jugador.
         * @param string $fotografia Ruta de la fotografía del jugador.
         * @return void Redirige a la página de jugadores del equipo o al formulario en caso de error.
         */
        public function savePlayer($idEquipo, $nombre, $apellidos, $fechaNacimiento, $correo, $celular, $tipoSangre, $contactoEmergencia, $fotografia, $idTorneo)
        {
            /**
             * @var bool|int Variable que contien el id del jugador guardado
             */
            $id = $this->model->insert($idEquipo, $nombre, $apellidos, $fechaNacimiento, $correo, $celular, $tipoSangre, $contactoEmergencia, $fotografia);
            return ($id != false) ? header("Location: players.php?id=" . $idTorneo) : header("Location: submodulesTorneo.php?id=" . $idTorneo);
        }

        /**
         * Lee todos los jugadores de un equipo específico.
         * 
         * @param int $idEquipo Identificador único del equipo.
         * @return array|false Lista de jugadores si existen, false en caso contrario.
         */
        public function readPlayersByTeam($idEquipo)
        {
            return ($this->model->getJugadoresPorEquipo($idEquipo)) ? $this->model->getJugadoresPorEquipo($idEquipo) : false;
        }

        /**
         * Lee los datos de un jugador específico.
         * 
         * @param int $id Identificador único del jugador.
         * @return array|false Datos del jugador si existe, redirige en caso contrario.
         */
        public function readOnePlayer($id)
        {
            return ($this->model->readOne($id) != false) ? $this->model->readOne($id) : header("Location: players.php");
        }

        /**
         * Actualiza los datos de un jugador existente.
         * 
         * @param int $id Identificador único del jugador.
         * @param string $nombre Nuevo nombre del jugador.
         * @param string $apellidos Nuevos apellidos del jugador.
         * @param string $correo Nuevo correo del jugador.
         * @param string $celular Nuevo celular del jugador.
         * @param string $tipoSangre Nuevo tipo de sangre.
         * @param string $contactoEmergencia Nuevo contacto de emergencia.
         * @param string $fotografia Nueva fotografía del jugador.
         * @return void Redirige a la página del jugador o al listado general en caso de error.
         */
        public function updatePlayer($id, $nombre, $apellidos, $correo, $celular, $tipoSangre, $contactoEmergencia, $fotografia)
        {
            /**
             * @var string|array|bool Variable que contiene el id del equipo del jugador
             */
            $idEquipo = $this->model->readOne($id)['idEquipo'];
            return ($this->model->update($id, $nombre, $apellidos, $correo, $celular, $tipoSangre, $contactoEmergencia, $fotografia) != false)
                ? header("Location: players.php?idEquipo=" . $idEquipo)
                : header("Location: editPlayer.php?id=" . $id);
        }

        /**
         * Elimina un jugador de la base de datos.
         * 
         * @param int $id Identificador único del jugador a eliminar.
         * @return void Redirige al listado general de jugadores del equipo.
         */
        public function deletePlayer($id)
        {
            /**
             * @var string|array|bool Variable que contiene el id del equipo del jugdaor
             */
            $idEquipo = $this->model->readOne($id)['idEquipo'];
            return ($this->model->delete($id))
                ? header("Location: players.php?idEquipo=" . $idEquipo)
                : header("Location: playerDetails.php?id=" . $id);
        }

        /**
         * Lee todos los jugadores registrados en la base de datos.
         * 
         * @return array|false Lista de jugadores si existen, false en caso contrario.
         */
        public function readAllPlayers()
        {
            return ($this->model->read()) ? $this->model->read() : false;
        }

        public function completePlayer($idJugador, $puntos, $tiros3, $faltas) {
            return $this->model->completePlayer($idJugador, $puntos, $tiros3, $faltas);
        }

        public function readPlayersByTournament($idTorneo){
            return $this->model->readPlayersByTournament($idTorneo);
        }
    }
?>
