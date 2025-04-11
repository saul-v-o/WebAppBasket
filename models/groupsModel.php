<?php
/**
 * Modelo groupsModel
 * 
 * Gestiona las operaciones de base de datos para la tabla `grupos`.
 * Proporciona métodos para insertar, leer, actualizar y eliminar registros.
 * 
 * @package WebAppBasketBall
 * @subpackage Models
 * @author Saúl Valenzuela Osuna
 * @version 1.0
 */

require_once("../../config/DataBase.php");

class groupsModel
{
    /**
     * @var PDO Conexión a la base de datos.
     */
    public $PDO;

    public function __construct()
    {
        /**
         * @var DataBase Variable-instancia de la clase para la conexión a la base de datos.
         */
        $conexion = new DataBase();
        $this->PDO = $conexion->connect();
    }

    /**
     * Inserta un nuevo grupo en la base de datos.
     * 
     * @param int $idTorneo ID del torneo al que pertenece el grupo.
     * @param string $categoria Categoría del grupo.
     * @param string $nombre Nombre del grupo.
     * @return int|false ID del grupo insertado o false en caso de error.
     */
    public function insert($idTorneo, $categoria, $nombre)
    {
        $statement = $this->PDO->prepare(
            "INSERT INTO grupos (id_torneo, categoria, nombre) 
            VALUES (:id_torneo, :categoria, :nombre)"
        );
        $statement->bindParam(":id_torneo", $idTorneo);
        $statement->bindParam(":categoria", $categoria);
        $statement->bindParam(":nombre", $nombre);

        return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
    }

    /**
     * Obtiene todos los grupos de un torneo específico.
     * 
     * @param int $idTorneo ID del torneo.
     * @return array|false Lista de grupos o false en caso de error.
     */
    public function getGruposPorTorneo($idTorneo)
    {
        $query = "SELECT * FROM grupos WHERE id_torneo = :id_torneo";
        $statement = $this->PDO->prepare($query);
        $statement->bindParam(":id_torneo", $idTorneo);

        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    /**
     * Obtiene un grupo específico por su ID.
     * 
     * @param int $id ID del grupo.
     * @return array|false Datos del grupo o false si no existe.
     */
    public function readOne($id)
    {
        $statement = $this->PDO->prepare("SELECT * FROM grupos WHERE id = :id LIMIT 1");
        $statement->bindParam(":id", $id);

        return ($statement->execute()) ? $statement->fetch() : false;
    }

    /**
     * Actualiza los datos de un grupo existente.
     * 
     * @param int $id ID del grupo a modificar.
     * @param string $categoria Nueva categoría del grupo.
     * @param string $nombre Nuevo nombre del grupo.
     * @return int|false ID del grupo actualizado o false en caso de error.
     */
    public function update($id, $categoria, $nombre)
    {
        $statement = $this->PDO->prepare("UPDATE grupos SET categoria = :categoria, nombre = :nombre WHERE id = :id");
        $statement->bindParam(":categoria", $categoria);
        $statement->bindParam(":nombre", $nombre);
        $statement->bindParam(":id", $id);

        return ($statement->execute()) ? $id : false;
    }

    /**
     * Elimina un grupo de la base de datos.
     * 
     * @param int $id ID del grupo.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function delete($id)
    {
        $statement = $this->PDO->prepare("DELETE FROM grupos WHERE id = :id");
        $statement->bindParam(":id", $id);

        return ($statement->execute()) ? true : false;
    }

    /**
     * Obtiene todos los grupos registrados.
     * 
     * @return array|false Lista de grupos o false en caso de error.
     */
    public function read()
    {
        $statement = $this->PDO->prepare("SELECT * FROM grupos");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    public function readCategoriesByTournament($idTorneo){
        $query = "SELECT MIN(id) as id, categoria
                FROM grupos
                WHERE id_torneo = :idTorneo
                GROUP BY categoria;
                ";
        $statement = $this->PDO->prepare($query);
        $statement->bindParam(":idTorneo", $idTorneo);

        $result = $statement->execute();
        if ($result) {
            return $statement->fetchAll(PDO::FETCH_ASSOC); 
        } else {
            return false;
        }
    }
}
?>
