<?php
    require_once("/xampp/htdocs/WEBAPPBASKET/models/usuariosModels.php");

    class usuariosController
    {
        private $model;

        public function __construct()
        {
            $this->model = new usuariosModel();
        }

        public function saveUsuario($nombre, $apellidoP, $apellidoM, $usuario, $correo, $contrasena)
        {
            $id_usuario = $this->model->insert($nombre, $apellidoP, $apellidoM, $usuario, $correo, $contrasena);
            return ($id_usuario != false) ? header("Location: frmUsuarios.php") : header("Location : frmUsuarios.php");
        }

        public function readUsuarios() {
            return ($this->model->read()) ? $this->model->read() : false;
        }

        public function delete($id_organizador) {
            return ($this->model->delete($id_organizador)) 
                ? header("Location: readAllUsuarios.php") 
                : header("Location: readOneUsuarios.php?id=" . $id_organizador);
        }

    }
?>