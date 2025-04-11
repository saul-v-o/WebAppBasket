<?php
/**
 * Modelo teamsModel
 * 
 * Gestiona las operaciones de base de datos para la tabla `equipos`.
 * Proporciona métodos para insertar, leer, actualizar y eliminar registros.
 * 
 * @package WebAppBasketBall
 * @subpackage Models
 * @author Saúl Valenzuela Osuna
 * @since 2024-12-26
 * @version 1.0
 */

require_once("../../config/DataBase.php");

class teamsModel
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
     * Inserta un nuevo equipo en la base de datos.
     * 
     * @param string $nombreEquipo Nombre del equipo.
     * @param string $capitan Capitán del equipo.
     * @param string $correo Correo del capitán del equipo.
     * @param string $celular Celular del capitán del equipo.
     * @param int $idTorneo ID del torneo al que pertenece el equipo.
     * @param string $logo Logo del equipo.
     * @param string $grupo ID del grupo
     * @return int|false ID del equipo insertado o false en caso de error.
     */
    public function insert($nombreEquipo, $capitan, $correo, $celular, $idTorneo, $logo, $grupo)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare(
            "INSERT INTO equipos (nombreEquipo, capitan, correo, celular, idTorneo, logo, juegosGanados, juegosPerdidos, puntosAFavor, puntosEnContra, puntaje, grupo) 
            VALUES (:nombreEquipo, :capitan, :correo, :celular, :idTorneo, :logo, 0, 0, 0, 0, 0, :grupo)"
        );
        $statement->bindParam(":nombreEquipo", $nombreEquipo);
        $statement->bindParam(":capitan", $capitan);
        $statement->bindParam(":correo", $correo);
        $statement->bindParam(":celular", $celular);
        $statement->bindParam(":idTorneo", $idTorneo);
        $statement->bindParam(":logo", $logo);
        $statement->bindParam(":grupo", $grupo);

        return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
    }

    /**
     * Obtiene todos los equipos de un torneo específico.
     * 
     * @param int $idTorneo ID del torneo.
     * @return array|false Lista de equipos o false en caso de error.
     */
    public function getEquiposPorTorneo($idTorneo)
    {
        /**
         * @var string Variable que contiene la sentencia SQL 
         */
        $query = "
            SELECT 
                equipos.*, 
                equipos.nombreEquipo, 
                (equipos.juegosGanados + equipos.juegosPerdidos) AS jugados
            FROM 
                equipos
            WHERE 
                equipos.idTorneo = :idTorneo
            ORDER BY 
                jugados DESC";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare($query);
        $statement->bindParam(":idTorneo", $idTorneo);

        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    /**
     * Obtiene un equipo específico por su ID.
     * 
     * @param int $id ID del equipo.
     * @return array|false Datos del equipo o false si no existe.
     */
    public function readOne($id)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT * FROM equipos WHERE id = :id LIMIT 1");
        $statement->bindParam(":id", $id);

        return ($statement->execute()) ? $statement->fetch() : false;
    }

    /**
     * Actualiza los datos de un equipo existente.
     * 
     * @param int $id ID del equipo a modificar.
     * @param string $nombreEquipo Nuevo nombre del equipo.
     * @param string $categoria Nueva categoría del equipo.
     * @return int|false ID del equipo actualizado o false en caso de error.
     */
    public function update($id, $nombreEquipo, $categoria)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("UPDATE equipos SET nombreEquipo = :nombreEquipo, categoria = :categoria WHERE id = :id");
        $statement->bindParam(":nombreEquipo", $nombreEquipo);
        $statement->bindParam(":categoria", $categoria);
        $statement->bindParam(":id", $id);

        return ($statement->execute()) ? $id : false;
    }

    /**
     * Elimina un equipo de la base de datos.
     * 
     * @param int $id ID del equipo.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function delete($id)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("DELETE FROM equipos WHERE id = :id");
        $statement->bindParam(":id", $id);

        return ($statement->execute()) ? true : false;
    }

    /**
     * Obtiene todos los equipos registrados.
     * 
     * @return array|false Lista de equipos o false en caso de error.
     */
    public function read()
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT * FROM equipos");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    /**
     * Actualiza los resultados de un equipo tras un partido.
     * 
     * @param int $idEquipoLocal ID del equipo local.
     * @param int $marcadorLocal Puntos del equipo local.
     * @param int $marcadorVisitante Puntos del equipo visitante.
     * @param string $default Si el partido fue default ("si" o "no").
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function updateTeamResults($idEquipoLocal, $marcadorLocal, $marcadorVisitante, $default)
    {
        /**
         * @var string $query Consulta SQL para obtener estadísticas del equipo.
         */
        $query = "SELECT juegosGanados, juegosPerdidos, puntosAFavor, puntosEnContra, puntaje FROM equipos WHERE id = :idEquipo";

        /**
         * @var PDOStatement $stmt Sentencia preparada para la consulta.
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':idEquipo', $idEquipoLocal, PDO::PARAM_INT);
        $stmt->execute();
        
        /**
         * @var array $estadisticasEquipo Estadísticas actuales del equipo.
         */
        $estadisticasEquipo = $stmt->fetch(PDO::FETCH_ASSOC);

        /**
         * @var int $juegosGanados Número de juegos ganados por el equipo.
         * @var int $juegosPerdidos Número de juegos perdidos por el equipo.
         * @var int $puntosAFavor Puntos a favor del equipo.
         * @var int $puntosEnContra Puntos en contra del equipo.
         * @var int $puntaje Puntaje acumulado del equipo.
         */
        $juegosGanados = $estadisticasEquipo['juegosGanados'];
        $juegosPerdidos = $estadisticasEquipo['juegosPerdidos'];
        $puntosAFavor = $estadisticasEquipo['puntosAFavor'];
        $puntosEnContra = $estadisticasEquipo['puntosEnContra'];
        $puntaje = $estadisticasEquipo['puntaje'];

        if ($marcadorLocal > $marcadorVisitante) {
            $puntaje += ($default === "si") ? 1 : 2;
            $juegosGanados++;
        } else {
            if ($default === "no") {
                $puntaje++;
            }
            $juegosPerdidos++;
        }

        $puntosAFavor += $marcadorLocal;
        $puntosEnContra += $marcadorVisitante;

        /**
         * @var string $query Actualización de estadísticas del equipo.
         */
        $query = "UPDATE equipos SET 
                    juegosGanados = :juegosGanados, 
                    juegosPerdidos = :juegosPerdidos, 
                    puntosAFavor = :puntosAFavor, 
                    puntosEnContra = :puntosEnContra,
                    puntaje = :puntaje
                WHERE id = :idEquipo";

        /**
         * @var PDOStatement $stmt Sentencia preparada para la actualización.
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':juegosGanados', $juegosGanados, PDO::PARAM_INT);
        $stmt->bindParam(':juegosPerdidos', $juegosPerdidos, PDO::PARAM_INT);
        $stmt->bindParam(':puntosAFavor', $puntosAFavor, PDO::PARAM_INT);
        $stmt->bindParam(':puntosEnContra', $puntosEnContra, PDO::PARAM_INT);
        $stmt->bindParam(':idEquipo', $idEquipoLocal, PDO::PARAM_INT);
        $stmt->bindParam(':puntaje', $puntaje, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Función para obtener los grupos y torneo
     * 
     */
    public function getTeamsByGroupAndTournament($categoria, $tournament){
        $query = "SELECT equipos.*,
                grupos.categoria
                FROM equipos
                JOIN grupos ON equipos.grupo = grupos.id
                WHERE equipos.idTorneo = :tournament
                AND grupos.categoria = :categoria;
                ";
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':tournament', $tournament);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
