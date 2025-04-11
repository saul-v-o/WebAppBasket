<?php
/**
 * Controlador para los grupos
 * 
 * @package WebAppBasketBall
 * @subpackage Controllers
 * @author  Saúl Valenzuela Osuna
 * @version 1.0    20-01-2025
 */
require_once("../../models/groupsModel.php");

class groupsController
{
    /**
     * @var groupsModel Instancia del modelo para gestionar los grupos.
     */
    private $model;

    public function __construct()
    {
        $this->model = new groupsModel();
    }

    /**
     * Guarda un nuevo grupo en la base de datos.
     *
     * @param string $nombre Nombre del grupo.
     * @param int $idTorneo Identificador único del torneo.
     * @param string $categoria Categoría del grupo.
     * @return void Redirige a la página de grupos del torneo o al formulario en caso de error.
     */
    public function saveGroup($nombre, $idTorneo, $categoria)
    {
        $id = $this->model->insert($idTorneo, $categoria, $nombre);
        return ($id != false) ? header("Location: groups.php?id=" . $idTorneo) : header("Location: groups.php?id=" . $idTorneo);
    }

    /**
     * Lee todos los grupos de un torneo específico.
     * 
     * @param int $idTorneo Identificador único del torneo.
     * @return array|false Lista de grupos si existen, false en caso contrario.
     */
    public function readGroupsByTournament($idTorneo)
    {
        return ($this->model->getGruposPorTorneo($idTorneo)) ? $this->model->getGruposPorTorneo($idTorneo) : false;
    }

    /**
     * Lee los datos de un grupo específico.
     * 
     * @param int $id Identificador único del grupo.
     * @return array|false Datos del grupo si existe, redirige en caso contrario.
     */
    public function readOneGroup($id)
    {
        return ($this->model->readOne($id) != false) ? $this->model->readOne($id) : header("Location: groups.php");
    }

    /**
     * Lee todos los grupos registrados en la base de datos.
     * 
     * @return array|false Lista de grupos si existen, false en caso contrario.
     */
    public function readAllGroups()
    {
        return ($this->model->read()) ? $this->model->read() : false;
    }

    public function readCategoriesByTournament($idTorneo){
       
        return ($this->model->readCategoriesByTournament($idTorneo)) ? $this->model->readCategoriesByTournament($idTorneo) : false;
    }
}
