<?php
/**
 * Modelo organizerModel
 * 
 * Gestiona las operaciones de base de datos para la tabla `torneos`.
 * Proporciona métodos para insertar, leer, actualizar y eliminar registros.
 * También incluye funciones para el cifrado de contraseñas.
 * 
 * @package WebAppBasketBall
 * @subpackage Models
 * @author Saúl Valenzuela Osuna
 * @since 2024-11-24
 */
require_once("../../config/DataBase.php");

class organizerModel
{
    /**
     * @var PDO Conexión a la base de datos.
     */
    public $PDO;

    public function __construct()
    {
        /**
         * @var DataBase Variable-instancia de la clase para la conexión a la base de datos
         */
        $conexion = new DataBase();
        $this->PDO = $conexion->connect();
    }

    /**
     * Inserta un nuevo organizador en la base de datos.
     * 
     * @param string $usuario Nombre del usuario que registra.
     * @param string $contrasena Contraseña del usuario.
     * @param string $nombre Nombre del organizador.
     * @return int|false ID del organizador insertado o false en caso de error.
     */
    public function insert($usuario, $contrasena, $nombre)
    {
        /**
         * @var string Variable que contiene la contraseña ya encriptada
         */
        $contrasena = $this->passwordEncrypt($contrasena);

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("INSERT INTO organizadores (nombre, usuario, contrasena) VALUES (:nombre, :usuario, :contrasena)");
        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":contrasena", $contrasena);
        $statement->bindParam(":nombre", $nombre);

        return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
    }

    /**
     * Cifra una contraseña utilizando un algoritmo de hashing seguro.
     * 
     * @param string $password Contraseña en texto plano.
     * @return string Contraseña cifrada.
     */
    public function passwordEncrypt($password)
    {
        /**
         * @var string Variable que guarda la contraseña encriptada
         */
        $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);
        return $passwordEncrypted;
    }

    /**
     * Verifica una contraseña cifrada con su versión en texto plano.
     * 
     * @param string $passwordEncrypted Contraseña cifrada almacenada.
     * @param string $passwordCandidate Contraseña ingresada por el usuario.
     * @return bool True si coinciden, false en caso contrario.
     */
    public function passwordDencryted($passwordEncrypted, $passwordCandidate)
    {
        return (password_verify($passwordCandidate, $passwordEncrypted)) ? true : false;
    }

    /**
     * Obtiene todos los registros de organizadores.
     * 
     * @return array|false Lista de organizadores o false en caso de error.
     */
    public function read()
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT * FROM organizadores");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    /**
     * Obtiene un registro específico de la tabla organizador.
     * 
     * @param int $id ID del organizador.
     * @return array|false Datos del organizador o false si no existe.
     */
    public function readOne($id)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT * FROM organizadores WHERE id = :id LIMIT 1");
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? $statement->fetch() : false;
    }

    /**
     * Actualiza los datos de un organizador existente.
     * 
     * @param int $id id a modificar.
     * @param int $usuario Usuario nuevo.
     * @return int|false ID del organizador actualizado o false en caso de error.
     */
    public function update($id, $usuario, $nombre)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("UPDATE organizadores 
        SET nombre = :nombre, 
            usuario = :usuario 
        WHERE id = :id");

        $statement->bindParam(":id", $id);
        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":nombre", $nombre);

        return ($statement->execute()) ? $id : false;
    }


    /**
     * Elimina un organizador de la base de datos.
     * 
     * @param int $id ID del organizador.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function delete($id)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("DELETE FROM organizadores WHERE id = :id");
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? true : false;
    }

    /**
     * Verifica las credenciales del organizador (login).
     * 
     * @param string $usuario Nombre del usuario.
     * @param string $contrasena Contraseña ingresada por el usuario.
     * @return array|false Datos del organizador si las credenciales son correctas, false si son incorrectas.
     */
    public function login($usuario, $contrasena)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT * FROM organizadores WHERE usuario = :usuario LIMIT 1");
        $statement->bindParam(":usuario", $usuario);

        if ($statement->execute()) {
            $organizador = $statement->fetch();

            if ($organizador) {
                if ($this->passwordDencryted($organizador['contrasena'], $contrasena)) {

                    return $organizador;
                }
            }

        }
        return false;
    }

}
?>