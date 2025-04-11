<?php
    /**
     * Controlador para los organizadores
     * 
     * @package WebAppBasketBall
     * @subpackage Controllers
     * @author Valenzuela Osuna Saúl
     * @version 1.0    23-12-2024
     */
    require_once("../../models/organizerModel.php");


    class organizerController
    {
        /**
         * @var organizerModel Instancia del modelo para gestionar los organizadores.
         */
        private $model;

        public function __construct()
        {
            $this->model = new organizerModel();
        }

        /**
         * Guarda un nuevo organizador en la base de datos.
         *
         * @param string $usuario Nombre del usuario que registra.
         * @param string $contrasena Contraseña del usuario.
         * @param string $nombre Nombre del organizador.
         * @return int|void Redirige a la página principal o al formulario en caso de error.
         */
        public function saveOrganizer($usuario, $contrasena, $nombre)
        {
            /**
             * @var bool|int Variable que guarda el id del organizador guardado 
             */
            $id = $this->model->insert($usuario, $contrasena, $nombre);
            if ($id != false){
                return $id;
            }
        }

        /**
         * Guarda un nuevo organizador en la base de datos.
         *
         * @param string $id ID a modificar
         * @param string $usuario Nombre del usuario que registra.
         * @param string $nombre Nombre del organizador.
         * @return int|void Redirige a la página principal o al formulario en caso de error.
         */
        public function updateOrganizer($id, $usuario, $nombre)
        {
            /**
             * @var bool|int Variable que guarda el id del organizador actualizado
             */
            $id = $this->model->update($id, $usuario, $nombre);
            if ($id != false){
                return $id;
            }
        }

        /**
         * Lee todos los organizadores registrados.
         * 
         * @return array|false Lista de organizadores si existen, false en caso contrario.
         */
        public function readOrganizers()
        {
            return ($this->model->read()) ? $this->model->read() : false;
        }

        /**
         * Lee los datos de un organizadores específico.
         * 
         * @param int $id Identificador único del organizadores.
         * @return array|false Datos del organizadores si existe, redirige en caso contrario.
         */
        public function readOneOrganizer($id)
        {
            return ($this->model->readOne($id) != false) ? $this->model->readOne($id) : header("Location: admin.php");
        }

        /**
         * Elimina un organizador de la base de datos.
         * 
         * @param int $id Identificador único del organizador a eliminar.
         * @return void Redirige al listado general o a la página del organizador en caso de error.
         */
        public function delete($id)
        {
            return ($this->model->delete($id))
                ? header("Location: readAllOrganizers.php")
                : header("Location: readOneOrganizer.php?id=" . $id);
        }

        /**
         * Verifica si existe el organizador con esos datos
         * 
         * @param string $usuario  Usuario a verificar
         * @param string $contrasena  Contraseña del usuario a verificar
         * @return void
         */
        public function verifyData($usuario, $contrasena)
        {
            /**
             * @var array|bool Variable que contiene los datos del organizador que se logeó
             */
            $organizador = $this->model->login($usuario, $contrasena);

            if ($organizador !== false) {
                session_start();
                $_SESSION['id'] = $organizador['id'];
                $_SESSION['usuario'] = $organizador['usuario'];
                $_SESSION['nombre'] = $organizador['nombre'];
                header("Location: organizer.php");
                exit();
            } else {
                header("Location: login.php?error=1");
                exit();
            }
        }
    }
?>