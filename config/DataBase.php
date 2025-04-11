<?php
/**
 * Clase DataBase
 * 
 * Proporciona una interfaz para establecer una conexión con una base de datos
 * utilizando PDO en PHP.
 * 
 * @package ProyectoWeb
 * @author Saúl Valenzuela Osuna
 * @since 2024-11-24
 */
class DataBase {
    /**
     * @var string Dirección del servidor de la base de datos.
     */
    private $host = "practicas.fimaz.uas.edu.mx";
     /**
     * @var string Nombre de la base de datos.
     */
    private $db = "lisi4104_proyecto";
   /**
     * @var string Usuario para la conexión a la base de datos.
     */
    private $user = "lisi4104";  
     /**
     * @var string Contraseña del usuario para la base de datos.
     */
    private $password = "lisi4104";

    public function __construct() {
        // Constructor vacío.
    }

      /**
     * Establece una conexión a la base de datos.
     *
     * Utiliza PDO para conectarse a la base de datos especificada.
     *
     * @return PDO|string Devuelve una instancia de PDO si la conexión es exitosa, 
     *                    o un mensaje de error en caso de falla.
     * @throws PDOException Si ocurre un error durante la conexión.
     */
    public function connect() {
        try {
            $PDO = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->password);
            return $PDO;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
?>
