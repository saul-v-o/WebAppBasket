<?php
    /**
     * Controlador para los administradores
     * 
     * @package WebAppBasketBall
     * @subpackage Controllers
     * @author Saúl Valenzuela Osuna
     * @version 1.0    28-12-2024
     */
    require_once("../../models/adminModel.php");

    class adminController
    {
        /**
         * @var adminModel Instancia del modelo para gestionar los administradores.
         */
        private $model;

        public function __construct()
        {
            $this->model = new adminModel();
        }

        /**
         * Guarda un nuevo administrador en la base de datos.
         *
         * @param string $usuario Nombre del usuario que registra.
         * @param string $contrasena Contraseña del usuario.
         * @param string $nombre Nombre del administrador.
         * @param string $apellidoP Apellido paterno.
         * @param string $apellidoM Apellido materno.
         * @param string $correo Correo del administrador.
         * @return void Redirige a la página principal o al formulario en caso de error.
         */
        public function saveAdmin($usuario, $contrasena, $nombre, $apellidoP, $apellidoM, $correo)
        {
            $id = $this->model->insert($usuario, $contrasena, $nombre, $apellidoP, $apellidoM, $correo);
            return ($id != false) ? header("Location: admin.php") : header("Location: admin.php");
        }

        /**
         * Lee todos los administradores registrados.
         * 
         * @return array|false Lista de administradores si existen, false en caso contrario.
         */
        public function readAdmins()
        {
            return ($this->model->read()) ? $this->model->read() : false;
        }

        /**
         * Lee los datos de un administrador específico.
         * 
         * @param int $id Identificador único del administrador.
         * @return array|false Datos del administrador si existe, redirige en caso contrario.
         */
        public function readOneAdmin($id)
        {
            return ($this->model->readOne($id) != false) ? $this->model->readOne($id) : header("Location: admin.php");
        }

        /**
         * Elimina un administrador de la base de datos.
         * 
         * @param int $id Identificador único del administrador a eliminar.
         * @return void Redirige al listado general o a la página del administrador en caso de error.
         */
        public function delete($id)
        {
            return ($this->model->delete($id))
                ? header("Location: readAllAdmins.php")
                : header("Location: readOneAdmin.php?id=" . $id);
        }

        /**
         * Verifica si existe el administrador con esos datos.
         * 
         * @param string $usuario  Usuario a verificar.
         * @param string $contrasena  Contraseña del usuario a verificar.
         * @return void
         */
        public function verifyData($usuario, $contrasena)
        {
            $admin = $this->model->login($usuario, $contrasena);

            if ($admin !== false) {
                session_start();
                $_SESSION['id'] = $admin['id_administrador'];
                $_SESSION['usuario'] = $admin['usuario'];
                $_SESSION['nombre'] = $admin['nombre'];
                $_SESSION['apellidoP'] = $admin['apellidoP'];
                header("Location: admin.php");
                exit();
            } else {
                header("Location: login.php?error=1");
                exit();
            }
        }
    }
?>
