<?php
/**
 * Modelo para gestionar los juegos de un torneo.
 * 
 * Este modelo se encarga de realizar operaciones CRUD relacionadas con los juegos
 * dentro de un torneo, como la inserción, actualización, obtención y eliminación
 * de registros en la base de datos.
 * 
 * @package WebAppBasketBall
 * @subpackage Models
 * @author Saúl Valenzuela Osuna
 * @version 1.0    26-12-2024
 */

require_once("../../config/DataBase.php");

class GamesModel
{
    private $PDO;

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
     * @param string $rol Tipo de juego (Regular, Exhibición, Playoff, Semifinal, Final).
     * @param string $sede Sede donde se jugará el juego.
     * @return int|false ID del juego insertado o false en caso de error.
     */
    public function insert($idTorneo, $equipoLocal, $equipoVisitante, $fecha, $hora, $rol, $sede)
    {
        /**
         * @var string Variable que contiene la sentencia a ejecutar
         */
        $query = "INSERT INTO juegos (idTorneo, equipoLocal, equipoVisitante, fecha, hora, rol, sede) 
                  VALUES (:idTorneo, :equipoLocal, :equipoVisitante, :fecha, :hora, :rol, :sede)";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':idTorneo', $idTorneo);
        $stmt->bindParam(':equipoLocal', $equipoLocal);
        $stmt->bindParam(':equipoVisitante', $equipoVisitante);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':sede', $sede);

        if ($stmt->execute()) {
            return $this->PDO->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Obtiene todos los juegos de un torneo específico.
     * 
     * @param int $idTorneo ID del torneo.
     * @return array|false Lista de juegos o false en caso de error.
     */
    public function getGamesByTournament($idTorneo)
    {
        /**
         * @var string Variable que contiene la sentencia a ejecutar
         */
        $query = "
            SELECT 
            juegos.id AS idPartido,
            el.id AS idEquipoLocal,     
            ev.id AS idEquipoVisitante,   
            el.nombreEquipo AS equipoLocal,
            el.logo AS logoEquipoLocal,
            ev.nombreEquipo AS equipoVisitante,
            ev.logo AS logoEquipoVisitante,
            juegos.fecha,
            juegos.estatus,
            juegos.rol,
            juegos.sede,
            juegos.marcadorLocal,
            juegos.marcadorVisitante,
            juegos.categoria,
            juegos.hora
        FROM 
            juegos
        JOIN 
            equipos el ON juegos.equipoLocal = el.id
        JOIN 
            equipos ev ON juegos.equipoVisitante = ev.id
        WHERE 
            juegos.idTorneo = :idTorneo
        ORDER BY 
            juegos.fecha ASC, 
            juegos.hora ASC;
        ";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':idTorneo', $idTorneo);
        $stmt->execute();

        return ($stmt->rowCount() > 0) ? $stmt->fetchAll() : false;
    }

    /**
     * Obtiene un juego específico por su ID.
     * 
     * @param int $id ID del juego.
     * @return array|false Datos del juego o false en caso de error.
     */
    public function getGameById($id)
    {
        /**
         * @var string Variable que contiene la sentencia a ejecutar
         */
        $query = "SELECT * FROM juegos WHERE id = :id";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return ($stmt->rowCount() > 0) ? $stmt->fetch() : false;
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
                  WHERE id = :id";

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

        return $stmt->execute();
    }

    /**
     * Actualiza el resultado de un juego.
     * 
     * @param int $idPartido ID del partido.
     * @param int $marcadorLocal Marcador del equipo local.
     * @param int $marcadorVisitante Marcador del equipo visitante.
     * @param int $idEquipoLocal ID del equipo local.
     * @param int $idEquipoVisitante ID del equipo visitante.
     * @param string $ganadorDefault Indica si hubo un ganador por default ('si' o 'no').
     * @return bool Retorna true si se actualizó correctamente, false en caso contrario.
     * @throws PDOException Si ocurre un error durante la ejecución de la consulta.
     */
    public function updateGameResult($idPartido, $marcadorLocal, $marcadorVisitante, $idEquipoLocal, $idEquipoVisitante, $ganadorDefault)
    {
        if ($ganadorDefault === 'si') {
            if ($marcadorLocal > $marcadorVisitante) {
                $marcadorVisitante = 0;
            } else {
                $marcadorLocal = 0;
            }
        }

        /**
         * @var string Variable que contiene la sentencia a ejecutar
         */
        $query = "UPDATE juegos SET marcadorLocal = :marcadorLocal, marcadorVisitante = :marcadorVisitante, estatus = 'capturado' WHERE id = :idPartido";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':marcadorLocal', $marcadorLocal, PDO::PARAM_INT);
        $stmt->bindParam(':marcadorVisitante', $marcadorVisitante, PDO::PARAM_INT);
        $stmt->bindParam(':idPartido', $idPartido, PDO::PARAM_INT);

        return $stmt->execute();
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
         * @var string Variable que contiene la sentencia a ejecutar
         */
        $query = "DELETE FROM juegos WHERE id = :id";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Función para obtener los juegos por el torneo y grupo
     * 
     * @param string $idTorneo
     * @param string $idGrupo
     * @return array
     */
    public function getGamesByTournamentAndGroup($idTorneo, $idGrupo)
    {
        $query = "SELECT juegos.*,
                    equipoLocal.logo AS logoEquipoLocal,
                    equipoLocal.nombreEquipo AS nombreEquipoLocal,
                    equipoVisitante.logo AS logoEquipoVisitante,
                    equipoVisitante.nombreEquipo AS nombreEquipoVisitante
                    FROM juegos
                    JOIN equipos AS equipoLocal ON juegos.equipoLocal = equipoLocal.id
                    JOIN equipos AS equipoVisitante ON juegos.equipoVisitante = equipoVisitante.id
                    WHERE juegos.idTorneo = :idTorneo
                    AND equipoLocal.grupo = :idGrupo
                    AND equipoVisitante.grupo = :idGrupo;
                    ";

        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':idTorneo', $idTorneo);
        $stmt->bindParam(':idGrupo', $idGrupo);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
