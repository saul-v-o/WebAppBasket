<?php
/**
 * Modelo playerModel
 * 
 * Gestiona las operaciones de base de datos para la tabla `jugadores`.
 * Proporciona métodos para insertar, leer, actualizar y eliminar registros.
 * 
 * @package WebAppBasketBall
 * @subpackage Models
 * @author Saúl Valenzuela Osuna
 * @since 2024-12-26
 */

require_once("../../config/DataBase.php");

class playerModel
{
    /**
     * @var PDO Conexión a la base de datos.
     */
    public $PDO;

    /**
     * Constructor de la clase playerModel.
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
     * Inserta un nuevo jugador en la base de datos.
     * 
     * @param int $idEquipo ID del equipo al que pertenece el jugador.
     * @param string $nombre Nombre del jugador.
     * @param string $apellidos Apellidos del jugador.
     * @param string $fechaNacimiento Fecha de nacimiento del jugador.
     * @param string $correo Correo electrónico del jugador.
     * @param string $celular Celular del jugador.
     * @param string $tipoSangre Tipo de sangre del jugador.
     * @param string $contactoEmergencia Contacto de emergencia del jugador.
     * @param string $fotografia Ruta de la fotografía del jugador.
     * @return int|false ID del jugador insertado o false en caso de error.
     */
    public function insert($idEquipo, $nombre, $apellidos, $fechaNacimiento, $correo, $celular, $tipoSangre, $contactoEmergencia, $fotografia)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("INSERT INTO jugadores (idEquipo, nombre, apellidos, fechaNacimiento, correo, celular, tipoSangre, contactoEmergencia, fotografia, puntos, tiros3, faltas) 
                                          VALUES (:idEquipo, :nombre, :apellidos, :fechaNacimiento, :correo, :celular, :tipoSangre, :contactoEmergencia, :fotografia, 0, 0, 0)");
        $statement->bindParam(":idEquipo", $idEquipo);
        $statement->bindParam(":nombre", $nombre);
        $statement->bindParam(":apellidos", $apellidos);
        $statement->bindParam(":fechaNacimiento", $fechaNacimiento);
        $statement->bindParam(":correo", $correo);
        $statement->bindParam(":celular", $celular);
        $statement->bindParam(":tipoSangre", $tipoSangre);
        $statement->bindParam(":contactoEmergencia", $contactoEmergencia);
        $statement->bindParam(":fotografia", $fotografia);

        return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
    }

    /**
     * Obtiene todos los jugadores de un equipo específico.
     * 
     * @param int $idEquipo ID del equipo.
     * @return array|false Lista de jugadores o false en caso de error.
     */
    public function getJugadoresPorEquipo($idEquipo)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("
            SELECT 
                jugadores.*,
                equipos.nombreEquipo
            FROM 
                jugadores
            JOIN 
                equipos ON jugadores.idEquipo = equipos.id
            WHERE 
                jugadores.idEquipo = :idEquipo
            ORDER BY 
                jugadores.puntos DESC");
        $statement->bindParam(":idEquipo", $idEquipo);
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    /**
     * Obtiene un jugador específico por su ID.
     * 
     * @param int $id ID del jugador.
     * @return array|false Datos del jugador o false si no existe.
     */
    public function readOne($id)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT jugadores.*, FROM jugadores WHERE id = :id LIMIT 1");
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? $statement->fetch() : false;
    }

    /**
     * Actualiza los datos de un jugador existente.
     * 
     * @param int $id ID del jugador a modificar.
     * @param string $nombre Nuevo nombre del jugador.
     * @param string $apellidos Nuevos apellidos del jugador.
     * @param string $correo Nuevo correo del jugador.
     * @param string $celular Nuevo celular del jugador.
     * @param string $tipoSangre Nuevo tipo de sangre.
     * @param string $contactoEmergencia Nuevo contacto de emergencia.
     * @param string $fotografia Nueva fotografía del jugador.
     * @return int|false ID del jugador actualizado o false en caso de error.
     */
    public function update($id, $nombre, $apellidos, $correo, $celular, $tipoSangre, $contactoEmergencia, $fotografia)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("UPDATE jugadores SET nombre = :nombre, apellidos = :apellidos, correo = :correo, celular = :celular, 
                                          tipoSangre = :tipoSangre, contactoEmergencia = :contactoEmergencia, fotografia = :fotografia WHERE id = :id");
        $statement->bindParam(":nombre", $nombre);
        $statement->bindParam(":apellidos", $apellidos);
        $statement->bindParam(":correo", $correo);
        $statement->bindParam(":celular", $celular);
        $statement->bindParam(":tipoSangre", $tipoSangre);
        $statement->bindParam(":contactoEmergencia", $contactoEmergencia);
        $statement->bindParam(":fotografia", $fotografia);
        $statement->bindParam(":id", $id);

        return ($statement->execute()) ? $id : false;
    }

    /**
     * Elimina un jugador de la base de datos.
     * 
     * @param int $id ID del jugador.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function delete($id)
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("DELETE FROM jugadores WHERE id = :id");
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? true : false;
    }

    /**
     * Obtiene todos los jugadores registrados.
     * 
     * @return array|false Lista de jugadores o false en caso de error.
     */
    public function read()
    {
        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $statement = $this->PDO->prepare("SELECT * FROM jugadores");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    /**
     * Actualiza las estadísticas de un jugador.
     * 
     * @param int $idJugador ID del jugador.
     * @param int $puntos Puntos anotados.
     * @param int $tiros3 Tiros de 3 puntos anotados.
     * @param int $faltas Faltas cometidas.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public function completePlayer($idJugador, $puntos, $tiros3, $faltas)
    {
        /**
         * @var string Variable que contiene la sentencia SQL
         */
        $query = "UPDATE jugadores SET 
                    puntos = puntos + :puntos,
                    tiros3 = tiros3 + :tiros3,
                    faltas = faltas + :faltas
                  WHERE idJugador = :idJugador";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':idJugador', $idJugador, PDO::PARAM_INT);
        $stmt->bindParam(':puntos', $puntos, PDO::PARAM_INT);
        $stmt->bindParam(':tiros3', $tiros3, PDO::PARAM_INT);
        $stmt->bindParam(':faltas', $faltas, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Obtiene jugadores por torneo.
     * 
     * @param int $idTorneo ID del torneo.
     * @return array Lista de jugadores o un arreglo vacío si hay un error.
     */
    public function readPlayersByTournament($idTorneo)
    {
        /**
         * @var string Variable que contiene la sentencia SQL
         */
        $query = "
            SELECT 
                jugadores.*,
                equipos.nombreEquipo
            FROM 
                jugadores
            JOIN 
                equipos ON jugadores.idEquipo = equipos.id
            WHERE 
                equipos.idTorneo = :idTorneo
            ORDER BY 
                jugadores.puntos DESC";

        /**
         * @var bool|PDOStatement Variable que prepara la consulta mediante PDO
         */
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':idTorneo', $idTorneo, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            error_log("Error al obtener jugadores por torneo: " . implode(", ", $stmt->errorInfo()));
            return [];
        }
    }
}
?>
