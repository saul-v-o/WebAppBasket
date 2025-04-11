<?php
/**
 * Controlador torneosController
 * 
 * Maneja las operaciones de gestión de torneos mediante la interacción con el modelo `torneosModel`.
 * Permite realizar operaciones CRUD: creación, lectura, actualización y eliminación de torneos.
 * 
 * @package WebAppBasketBall
 * @subpackage Controllers
 * @author Saúl Valenzuela Osuna
 * @since 2024-11-24
 */
require_once("../../models/torneosModels.php");


class torneosController {
     /**
     * @var torneosModel Instancia del modelo para gestionar los torneos.
     */
    private $model;

    public function __construct() {
        $this->model = new torneosModel();
    }

      /**
     * Guarda un nuevo torneo en la base de datos.
     * 
     * @param string $nombreTorneo Nombre del torneo.
     * @param string $logoTorneo Logo del torneo.
     * @param string $patrocinadores Lista de patrocinadores.
     * @param string $logoPatrocinadores Logo de los patrocinadores.
     * @param string $sede Ubicación del torneo.
     * @param string $premio1 Premio para el primer lugar.
     * @param string $premio2 Premio para el segundo lugar.
     * @param string $premio3 Premio para el tercer lugar.
     * @param string $otroPremio Otros premios adicionales.
     * @param string $idOrganizador ID de la tabla de organizadoes
     * @return void Redirige a la página principal o al formulario en caso de error.
     */
    public function saveTorneo($nombreTorneo, $logoTorneo, $patrocinadores, $logoPatrocinadores, $sede, $premio1, 
    $premio2, $premio3, $otroPremio, $idOrganizador) {
        $id = $this->model->insert($nombreTorneo, $logoTorneo, $patrocinadores, $logoPatrocinadores, $sede, $premio1, 
        $premio2, $premio3, $otroPremio, $idOrganizador);
        return ($id != false) ? header("Location: frmTorneos.php") : header("Location: frmTorneos.php");
    }

    /**
     * Lee todos los torneos registrados.
     * 
     * @return array|false Lista de torneos si existen, false en caso contrario.
     */
    public function readTorneos() {
        return ($this->model->read()) ? $this->model->read() : false;
    }

     /**
     * Lee los datos de un torneo específico.
     * 
     * @param int $id Identificador único del torneo.
     * @return array|false Datos del torneo si existe, redirige en caso contrario.
     */
    public function readOneTorneos($id) {
        return ($this->model->readOne($id) != false) ? $this->model->readOne($id) : header("Location: admin.php");
    }

    public function readTorneosByOrganizer($id) {
        return ($this->model->readByOrganizer($id) != false) 
           ? $this->model->readByOrganizer($id) 
            : false;
    }

    /**
     * Actualiza los datos de un torneo existente.
     * 
     * @param int $id Identificador único del torneo.
     * @param string $nombreTorneo Nombre del torneo.
     * @param string $organizador Nombre del organizador.
     * @param string $patrocinadores Lista de patrocinadores.
     * @param string $sede Ubicación del torneo.
     * @param string $categoria Categoría del torneo.
     * @param string $premio1 Premio para el primer lugar.
     * @param string $premio2 Premio para el segundo lugar.
     * @param string $premio3 Premio para el tercer lugar.
     * @param string $otroPremio Otros premios adicionales.
     * @return void Redirige a la página del torneo o al listado general en caso de error.
     */
    public function updateTorneos($id, $nombreTorneo, $logoTorneo, $patrocinadores, $logoPatrocinadores, $sede, $premio1, 
    $premio2, $premio3, $otroPremio, $idOrganizador) {
        if($this->model->update($id, $nombreTorneo, $logoTorneo, $patrocinadores, $logoPatrocinadores, $sede, $premio1, 
        $premio2, $premio3, $otroPremio, $idOrganizador)){
            header("Location: readOneTorneo.php?id=".$id);
        }else{
            header("Location: readOneTorneo.php?id=". $id);
        }
    }

    /**
     * Elimina un torneo de la base de datos.
     * 
     * @param int $id Identificador único del torneo a eliminar.
     * @return void Redirige al listado general o a la página del torneo en caso de error.
     */
    public function delete($id) {
        return ($this->model->delete($id)) 
            ? header("Location: readAllTorneo.php") 
            : header("Location: readOneTorneo.php?id=" . $id);
    }

    public function deleteLogoPatrocinador($idTorneo, $logoPatrocinador){
        return ($this->model->deleteLogoPatrocinador($idTorneo, $logoPatrocinador)) 
           ? header("Location: updateTorneo.php?id=". $idTorneo) 
            : header("Location: updateTorneo.php?id=". $idTorneo);
    }
}
?>
