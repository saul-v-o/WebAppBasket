<?php
/**
 * Controlador para los equipos
 * 
 * @package WebAppBasketBall
 * @subpackage Controllers
 * @author  Saúl Valenzuela Osuna
 * @version 1.0    26-12-2024
 */
require_once("../../models/teamsModel.php");

class teamsController
{
    /**
     * @var teamsModel Instancia del modelo para gestionar los equipos.
     */
    private $model;

    public function __construct()
    {
        $this->model = new teamsModel();
    }

    /**
     * Guarda un nuevo equipo en la base de datos.
     *
     * @param string $nombreEquipo Nombre del equipo.
     * @param string $capitan Capitán del equipo.
     * @param string $correo Correo del capitán del equipo.
     * @param string $celular Celular del capitán del equipo.
     * @param int $idTorneo Identificador único del torneo.
     * @param string $logo Logo del equipo
     * @param string $grupo ID del grupo del equipo
     * @return void Redirige a la página de equipos del torneo o al formulario en caso de error.
     */
    public function saveTeam($nombreEquipo, $capitan, $correo, $celular, $idTorneo, $logo, $grupo)
    {
        /**
         * @var bool|int Variable que contiene el id del equipo recién guardado
         */
        $id = $this->model->insert($nombreEquipo, $capitan, $correo, $celular, $idTorneo, $logo, $grupo);
        return ($id != false) ? header("Location: teams.php?id=" . $idTorneo) : header("Location: teams.php?id=" . $idTorneo);
    }

    /**
     * Lee todos los equipos de un torneo específico.
     * 
     * @param int $idTorneo Identificador único del torneo.
     * @return array|false Lista de equipos si existen, false en caso contrario.
     */
    public function readTeamsByTournament($idTorneo)
    {
        return ($this->model->getEquiposPorTorneo($idTorneo)) ? $this->model->getEquiposPorTorneo($idTorneo) : false;
    }

    /**
     * Lee los datos de un equipo específico.
     * 
     * @param int $id Identificador único del equipo.
     * @return array|false Datos del equipo si existe, redirige en caso contrario.
     */
    public function readOneTeam($id)
    {
        return ($this->model->readOne($id) != false) ? $this->model->readOne($id) : header("Location: teams.php");
    }

    /**
     * Actualiza los datos de un equipo existente.
     * 
     * @param int $id Identificador único del equipo.
     * @param string $nombreEquipo Nuevo nombre del equipo.
     * @param string $categoria Nueva categoría del equipo.
     * @return void Redirige a la página del equipo o al listado general en caso de error.
     */
    public function updateTeam($id, $nombreEquipo, $categoria)
    {
        /**
         * @var string|array|bool Variable que contiene el id del torneo del equipo
         */
        $idTorneo = $this->model->readOne($id)['idTorneo'];
        return ($this->model->update($id, $nombreEquipo, $categoria) != false)
            ? header("Location: teams.php?idTorneo=" . $idTorneo)
            : header("Location: editTeam.php?id=" . $id);
    }

    /**
     * Elimina un equipo de la base de datos.
     * 
     * @param int $id Identificador único del equipo a eliminar.
     * @return void Redirige al listado general de equipos del torneo.
     */
    public function deleteTeam($id)
    {
        /**
         * @var string|array|bool Variable que contiene el id del torneo del equipo
         */
        $idTorneo = $this->model->readOne($id)['idTorneo'];
        return ($this->model->delete($id))
            ? header("Location: teams.php?idTorneo=" . $idTorneo)
            : header("Location: teamDetails.php?id=" . $id);
    }

    /**
     * Lee todos los equipos registrados en la base de datos.
     * 
     * @return array|false Lista de equipos si existen, false en caso contrario.
     */
    public function readAllTeams()
    {
        return ($this->model->read()) ? $this->model->read() : false;
    }

    public function updateTeamResults($idEquipoLocal, $marcadorLocal, $marcadorVisitante, $default)
    {
        return ($this->model->updateTeamResults($idEquipoLocal, $marcadorLocal, $marcadorVisitante, $default)) ? true : false;
    }

    public function readTeamsByGroupAndTournament($idCategoria, $idTorneo)
    {
        return $this->model->getTeamsByGroupAndTournament($idCategoria, $idTorneo);
    }

}
?>