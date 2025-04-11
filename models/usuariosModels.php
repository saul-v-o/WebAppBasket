<?php
    require_once(__DIR__ . '/../config/DataBase.php');

        class usuariosModel{
            public $PDO;

            public function __construct()
            {
                $conexion = new DataBase();
                $this->PDO = $conexion->connect();
            }

        public function insert($nombre, $apellidoP, $apellidoM, $usuario, $correo, $contrasena)
        {
            $contrasena = $this->passwordEncrypt($contrasena);

            $statement = $this->PDO->prepare("INSERT INTO organizador VALUES (null, :nombre, :apellidoP, 
            :apellidoM, :usuario, :correo, :contrasena)");
            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":apellidoP", $apellidoP);
            $statement->bindParam(":apellidoM", $apellidoM);
            $statement->bindParam(":usuario", $usuario);
            $statement->bindParam(":correo", $correo);
            $statement->bindParam(":contrasena", $contrasena);

            return($statement->execute()) ? $this->PDO->lastInsertId() : false;
        }

        public function passwordEncrypt($password) {
            $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);
            return $passwordEncrypted;
        }

        public function passwordDencryted($passwordEncrypted, $passwordCandidate)
        {
            return(password_verify($passwordCandidate, $passwordEncrypted)) ? true : false;
        }

        public function read() {
            $statement = $this->PDO->prepare("SELECT * FROM organizador");
            return ($statement->execute()) ? $statement->fetchAll() : false;
        }
        public function readOne($id_organizador) {
            $statement = $this->PDO->prepare("SELECT * FROM organizador WHERE id_organizador = :id_organizador LIMIT 1");
            $statement->bindParam(":id_organizador", $id_organizador);
            return ($statement->execute()) ? $statement->fetch() : false;
        }
        public function delete($id) {
            $statement = $this->PDO->prepare("DELETE FROM organizador WHERE id_organizador = :id_organizador");
            $statement->bindParam(":id_organizador", $id_organizador);
            return ($statement->execute()) ? true : false;
        }
    }
?>