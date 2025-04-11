<?php
/**
 * Modelo torneosModel
 * 
 * Gestiona las operaciones de base de datos para la tabla `torneos`.
 * Proporciona métodos para insertar, leer, actualizar y eliminar registros,
 * así como funciones auxiliares relacionadas con cifrado de contraseñas.
 * 
 * @package WebAppBasketBall
 * @subpackage Models
 * @author Saúl Valenzuela Osuna
 * @version 1.0 24-11-2024
 */
require_once("../../config/DataBase.php");

class torneosModel
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
     * Inserta un nuevo torneo en la base de datos.
     * 
     * @param string $nombreTorneo Nombre del torneo.
     * @param string $logoTorneo URL del logo del torneo.
     * @param string $patrocinadores Lista de patrocinadores del torneo.
     * @param string $logoPatrocinadores URL del logo de los patrocinadores.
     * @param string $sede Ubicación del torneo.
     * @param string $premio1 Premio otorgado al primer lugar.
     * @param string $premio2 Premio otorgado al segundo lugar.
     * @param string $premio3 Premio otorgado al tercer lugar.
     * @param string $otroPremio Otros premios adicionales, si los hay.
     * @param int $idOrganizador ID del organizador asociado al torneo.
     * @return int|false Devuelve el ID del torneo insertado o false en caso de error.
     */
    public function insert(
        $nombreTorneo,
        $logoTorneo,
        $patrocinadores,
        $logoPatrocinadores,
        $sede,
        $premio1,
        $premio2,
        $premio3,
        $otroPremio,
        $idOrganizador
    ) {

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("INSERT INTO torneos (nombreTorneo, logoTorneo, patrocinadores, logoPatrocinadores, sede, 
        premio1, premio2, premio3, otroPremio, idOrganizador) VALUES (:nombreTorneo, :logoTorneo, :patrocinadores, 
        :logoPatrocinadores, :sede, :premio1, :premio2, :premio3, :otroPremio, :idOrganizador)");

        $statement->bindParam(":nombreTorneo", $nombreTorneo);
        $statement->bindParam(":logoTorneo", $logoTorneo);
        $statement->bindParam(":patrocinadores", $patrocinadores);
        $statement->bindParam(":logoPatrocinadores", $logoPatrocinadores);
        $statement->bindParam(":sede", $sede);
        $statement->bindParam(":premio1", $premio1);
        $statement->bindParam(":premio2", $premio2);
        $statement->bindParam(":premio3", $premio3);
        $statement->bindParam(":otroPremio", $otroPremio);
        $statement->bindParam(":idOrganizador", $idOrganizador);

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
     * Obtiene todos los registros de torneos.
     * 
     * @return array|false Lista de torneos o false en caso de error.
     */
    public function read()
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT * FROM torneos");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    /**
     * Obtiene un registro específico de la tabla torneos.
     * 
     * @param int $id ID del torneo.
     * @return array|false Datos del torneo o false si no existe.
     */
    public function readOne($id)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT * FROM torneos WHERE id = :id LIMIT 1");
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? $statement->fetch() : false;
    }

    /**
     * Obtiene los torneos organizados por un organizador específico.
     * 
     * @param int $id ID del organizador.
     * @return array|false Lista de torneos o false en caso de error.
     */
    public function readByOrganizer($id)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT * FROM torneos WHERE idOrganizador = :id");
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    /**
     * Actualiza los datos de un torneo existente.
     * 
     * @param int $id ID del torneo.
     * @param string $nombreTorneo Nombre del torneo.
     * @param string $logoTorneo URL del logo del torneo.
     * @param string $patrocinadores Lista de patrocinadores del torneo.
     * @param string $logoPatrocinadores URL del logo de los patrocinadores.
     * @param string $sede Ubicación del torneo.
     * @param string $premio1 Premio otorgado al primer lugar.
     * @param string $premio2 Premio otorgado al segundo lugar.
     * @param string $premio3 Premio otorgado al tercer lugar.
     * @param string $otroPremio Otros premios adicionales, si los hay.
     * @param int $idOrganizador ID del organizador asociado al torneo.
     * @return bool True si el torneo fue actualizado, false en caso de error.
     */
    public function update(
        $id,
        $nombreTorneo,
        $logoTorneo,
        $patrocinadores,
        $logoPatrocinadores,
        $sede,
        $premio1,
        $premio2,
        $premio3,
        $otroPremio,
        $idOrganizador
    ) {

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("UPDATE torneos 
            SET nombreTorneo = :nombreTorneo, 
                logoTorneo = :logoTorneo, 
                patrocinadores = :patrocinadores, 
                logoPatrocinadores = :logoPatrocinadores, 
                sede = :sede, 
                premio1 = :premio1, 
                premio2 = :premio2, 
                premio3 = :premio3, 
                otroPremio = :otroPremio, 
                idOrganizador = :idOrganizador 
            WHERE id = :id");

        $statement->bindParam(":id", $id);
        $statement->bindParam(":nombreTorneo", $nombreTorneo);
        $statement->bindParam(":logoTorneo", $logoTorneo);
        $statement->bindParam(":patrocinadores", $patrocinadores);
        $statement->bindParam(":logoPatrocinadores", $logoPatrocinadores);
        $statement->bindParam(":sede", $sede);
        $statement->bindParam(":premio1", $premio1);
        $statement->bindParam(":premio2", $premio2);
        $statement->bindParam(":premio3", $premio3);
        $statement->bindParam(":otroPremio", $otroPremio);
        $statement->bindParam(":idOrganizador", $idOrganizador);

        return $statement->execute();
    }

    /**
     * Elimina un torneo de la base de datos.
     * 
     * @param int $id ID del torneo.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function delete($id)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("DELETE FROM torneos WHERE id = :id");
        $statement->bindParam(":id", $id);
        return ($statement->execute());
    }

    public function deleteLogoPatrocinador($idTorneo, $logoPatrocinadorEliminar){
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT logoPatrocinadores FROM torneos WHERE id = :idTorneo");
        $statement->bindParam(":idTorneo", $idTorneo);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            /**
             * @var string variable que guarda todas las rutas de los logos de los patrocinadores
             */
            $logosPatrocinadores = $result['logoPatrocinadores'];
    
            $logosPatrocinadores = str_replace($logoPatrocinadorEliminar, '', $logosPatrocinadores);
    
            /**
             * @var bool|PDOStatement Variable que prepara la sentencia a ejecutar
             */
            $statement = $this->PDO->prepare("UPDATE torneos SET logoPatrocinadores = :logoPatrocinadores WHERE id = :idTorneo");
            $statement->bindParam(":logoPatrocinadores", $logosPatrocinadores);
            $statement->bindParam(":idTorneo", $idTorneo);
    
            return $statement->execute();
        }
        return false;
    }
    
}
?>
