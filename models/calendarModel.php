<?php
/**
 * Modelo para gestionar el calendario de juegos.
 * 
 * Este modelo permite realizar operaciones CRUD sobre los juegos de un torneo.
 * 
 * @package WebAppBasketBall
 * @subpackage Models
 * @author Saúl Valenzuela Osuna
 * @version 1.1 02-01-2025
 */
ini_set('display_errors', 1);
    error_reporting(E_ALL);
require_once("../../config/DataBase.php");

class calendarModel
{
    /**
     * @var PDO Instancia de la conexión a la base de datos.
     */
    private $PDO;

    /**
     * Constructor de la clase.
     * 
     * Establece la conexión con la base de datos utilizando la clase DataBase.
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
     * Inserta un nuevo juego en la base de datos.
     * 
     * @param int $idTorneo ID del torneo.
     * @param int $equipoLocal ID del equipo local.
     * @param int $equipoVisitante ID del equipo visitante.
     * @param string $fecha Fecha del juego en formato YYYY-MM-DD.
     * @param string $hora Hora del juego en formato HH:MM:SS.
     * @param string $categoria Categoría del juego.
     * @param string $rol Tipo de juego (Regular, Exhibición, Play-off, etc.).
     * @param string $sede Sede donde se jugará el juego.
     * @return int|false Retorna el ID del juego insertado o false en caso de error.
     */
    public function insert($idTorneo, $equipoLocal, $equipoVisitante, $fecha, $hora, $categoria, $rol, $sede)
    {
        /**
         * @var string Variable que contiene la sentencia a ejecutar
         */
        $query = "INSERT INTO juegos (idTorneo, equipoLocal, equipoVisitante, fecha, hora, categoria, rol, sede, marcadorLocal, marcadorVisitante, estatus) 
                  VALUES (:idTorneo, :equipoLocal, :equipoVisitante, :fecha, :hora, :categoria, :rol, :sede, 0, 0, 'pendiente')";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':idTorneo', $idTorneo);
        $stmt->bindParam(':equipoLocal', $equipoLocal);
        $stmt->bindParam(':equipoVisitante', $equipoVisitante);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':sede', $sede);

        try {
            if ($stmt->execute()) {
                return $this->PDO->lastInsertId();
            }
        } catch (PDOException $e) {
            error_log("Error al insertar juego: " . $e->getMessage());
        }

        return false;
    }

    /**
     * Obtiene todos los juegos de un torneo específico.
     * 
     * @param int $idTorneo ID del torneo.
     * @return array|false Retorna un array con los juegos o false si no se encontraron resultados.
     */
    public function getGamesByTournament($idTorneo)
    {
        /**
         * @var string Variable que contiene la consulta SQL a ejecutar
         */
        $query = "SELECT * FROM juegos WHERE idTorneo = :idTorneo ORDER BY fecha ASC, hora ASC";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':idTorneo', $idTorneo);

        try {
            $stmt->execute();
            return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : false;
        } catch (PDOException $e) {
            error_log("Error al obtener juegos por torneo: " . $e->getMessage());
        }

        return false;
    }

    /**
     * Obtiene un juego específico por su ID.
     * 
     * @param int $id ID del juego.
     * @return array|false Retorna los datos del juego o false si no se encuentra.
     */
    public function getGameById($id)
    {
        /**
         * @var string Variable que contiene la sentencia a ejecutar
         */
        $query = "SELECT * FROM juegos WHERE idJuego = :id";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            return ($stmt->rowCount() > 0) ? $stmt->fetch() : false;
        } catch (PDOException $e) {
            error_log("Error al obtener juego por ID: " . $e->getMessage());
        }

        return false;
    }

    /**
     * Actualiza un juego existente en la base de datos.
     * 
     * @param int $id ID del juego.
     * @param int $equipoLocal ID del equipo local.
     * @param int $equipoVisitante ID del equipo visitante.
     * @param string $fecha Fecha del juego en formato YYYY-MM-DD.
     * @param string $hora Hora del juego en formato HH:MM:SS.
     * @param string $rol Tipo de juego.
     * @param string $sede Sede del juego.
     * @return bool Retorna true si se actualizó correctamente, false en caso contrario.
     */
    public function update($id, $equipoLocal, $equipoVisitante, $fecha, $hora, $rol, $sede)
    {
        /**
         * @var string Variable que contiene la sentencia a ejecutar
         */
        $query = "UPDATE juegos 
                  SET equipoLocal = :equipoLocal, equipoVisitante = :equipoVisitante, fecha = :fecha, 
                      hora = :hora, rol = :rol, sede = :sede
                  WHERE idJuego = :id";

    /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':equipoLocal', $equipoLocal);
        $stmt->bindParam(':equipoVisitante', $equipoVisitante);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':sede', $sede);
        $stmt->bindParam(':id', $id);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar juego: " . $e->getMessage());
        }

        return false;
    }

    /**
     * Elimina un juego de la base de datos.
     * 
     * @param int $id ID del juego.
     * @return bool Retorna true si se eliminó correctamente, false en caso contrario.
     */
    public function delete($id)
    {
        /**
         * @var string Variable que contiene la sentencia SQL a ejecutar
         */
        $query = "DELETE FROM juegos WHERE idJuego = :id";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':id', $id);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar juego: " . $e->getMessage());
        }

        return false;
    }
}
?>
