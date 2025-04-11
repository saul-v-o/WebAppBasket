<?php
/**
 * Modelo adminModel
 * 
 * Gestiona las operaciones de base de datos para la tabla `admin`.
 * Proporciona métodos para insertar, leer, actualizar y eliminar registros.
 * También incluye funciones para el cifrado de contraseñas y autenticación de usuarios.
 * 
 * @package WebAppBasketBall
 * @subpackage Models
 * @author Valenzuela Osuna Saúl
 * @version 1.0  12-28-2024
 */

require_once("../../config/DataBase.php");

class adminModel
{
    /**
     * @var PDO Conexión a la base de datos.
     */
    public $PDO;

    /**
     * Constructor de la clase.
     * 
     * Inicializa la conexión a la base de datos.
     */
    public function __construct()
    {
        /**
         * @var DataBase Variable-instancia de la clase para la conexión a la base de datos
         */
        $conexion = new DataBase();
        $this->PDO = $conexion->connect();
    }

    /**
     * Inserta un nuevo administrador en la base de datos.
     * 
     * @param string $usuario Nombre del usuario.
     * @param string $contrasena Contraseña del administrador.
     * @param string $nombre Nombre del administrador.
     * @param string $apellidoP Apellido paterno.
     * @param string $apellidoM Apellido materno.
     * @param string $correo Correo del administrador.
     * @return int|false ID del administrador insertado o false en caso de error.
     */
    public function insert($usuario, $contrasena, $nombre, $apellidoP, $apellidoM, $correo)
    {
        /**
         * @var string Variable que contiene la contraseña ya encriptada
         */
        $contrasena = $this->passwordEncrypt($contrasena);

        /**
         * @var bool|PDOStatement Variable que contiene la sentencia a ejecutar con PDO
         */
        $statement = $this->PDO->prepare("INSERT INTO administrador VALUES (null, :nombre, :apellidoP, :apellidoM, :usuario, :contrasena, :correo)");
        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":contrasena", $contrasena);
        $statement->bindParam(":nombre", $nombre);
        $statement->bindParam(":apellidoP", $apellidoP);
        $statement->bindParam(":apellidoM", $apellidoM);
        $statement->bindParam(":correo", $correo);

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
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verifica una contraseña cifrada con su versión en texto plano.
     * 
     * @param string $passwordEncrypted Contraseña cifrada almacenada.
     * @param string $passwordCandidate Contraseña ingresada por el usuario.
     * @return bool True si coinciden, false en caso contrario.
     */
    public function passwordDecrypted($passwordEncrypted, $passwordCandidate)
    {
        return password_verify($passwordCandidate, $passwordEncrypted);
    }

    /**
     * Obtiene todos los registros de administradores.
     * 
     * @return array|false Lista de administradores o false en caso de error.
     */
    public function read()
    {
        /**
         * @var bool|PDOStatement Variaable que contiene la sentencia a ejecutar
         */
        $statement = $this->PDO->prepare("SELECT * FROM admin");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    /**
     * Obtiene un registro específico de la tabla admin.
     * 
     * @param int $id ID del administrador.
     * @return array|false Datos del administrador o false si no existe.
     */
    public function readOne($id)
    {
        /**
         * @var bool|PDOStatement Variaable que contiene la sentencia a ejecutar
         */
        $statement = $this->PDO->prepare("SELECT * FROM admin WHERE id_administrador = :id LIMIT 1");
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? $statement->fetch() : false;
    }

    /**
     * Actualiza los datos de un administrador existente.
     * 
     * @param int $id ID a modificar.
     * @param string $usuario Usuario nuevo.
     * @param string $contrasena Contraseña nueva.
     * @return int|false ID del administrador actualizado o false en caso de error.
     */
    public function update($id, $usuario, $contrasena)
    {
        /**
         * @var bool|PDOStatement Variaable que contiene la sentencia a ejecutar
         */
        $statement = $this->PDO->prepare("UPDATE admin SET usuario = :usuario, contrasena = :contrasena 
        WHERE id = :id");

        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":contrasena", $contrasena);
        $statement->bindParam(":id", $id);

        return ($statement->execute()) ? $id : false;
    }

    /**
     * Elimina un administrador de la base de datos.
     * 
     * @param int $id ID del administrador.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function delete($id)
    {
        /**
         * @var bool|PDOStatement Variaable que contiene la sentencia a ejecutar
         */
        $statement = $this->PDO->prepare("DELETE FROM admin WHERE id = :id");
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? true : false;
    }

    /**
     * Verifica las credenciales del administrador (login).
     * 
     * @param string $usuario Nombre del usuario.
     * @param string $contrasena Contraseña ingresada por el usuario.
     * @return array|false Datos del administrador si las credenciales son correctas, false si son incorrectas.
     */
    public function login($usuario, $contrasena)
    {
        /**
         * @var bool|PDOStatement Variaable que contiene la sentencia a ejecutar
         */
        $statement = $this->PDO->prepare("SELECT * FROM administrador WHERE usuario = :usuario LIMIT 1");
        $statement->bindParam(":usuario", $usuario);

        if ($statement->execute()) {
            $admin = $statement->fetch();
            if ($admin) {
                if ($this->passwordDecrypted($admin['contrasena'], $contrasena)) {
                    return $admin;
                }
            }
        }
        return false;
    }
}
?>
