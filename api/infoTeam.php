<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once '../config/DataBase.php';
require_once '../controllers/teamsController.php';

/**
 * Archivo que hace una API REST para obtener los datos de la tabla "equipos" en formato JSON.
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0     06-01-2024
 */

try {
    // Instancia del controlador de equipos
    $objTeamsController = new teamsController();

    // Verifica si el parámetro idEquipo está presente en la solicitud
    if (isset($_GET["idEquipo"])) {
        $idEquipo = $_GET['idEquipo'];

        // Obtiene los datos del equipo
        $team = $objTeamsController->readOneTeam($idEquipo);

        // Verifica si se encontró el equipo
        if ($team) {
            http_response_code(200);
            echo json_encode($team);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Equipo no encontrado..."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Parámetro idEquipo requerido."]);
    }

} catch (PDOException $e) {
    echo json_encode([
        'message' => 'Error ' . $e->getMessage()
    ]);
}
?>
