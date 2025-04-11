<?php
    /**
     * API REST para obtener los datos de la tabla "equipos" en formato JSON.
     *
     * Este archivo permite obtener la lista de equipos de un torneo específico en formato JSON.
     * La API responde a solicitudes HTTP POST con el parámetro `idEquipo` en la URL.
     *
     * @package API
     * @author Saúl Valenzuela Osuna
     * @version 1.0  01-05-2025
     */
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once '../../controllers/teamsController.php';

    try {
        /**
         * @var teamsController  Variable-instancia de la clase controladora de los equipos
         */
        $objTeamsController = new teamsController();

        if (isset($_GET["idEquipo"])) {
            /**
             * @var string  Variable que guarda el id del equipo a buscar
             */
            $idEquipo = $_GET['idEquipo'];

            /**
             * @var array Variable que contiene los datos del equipo
             */
            $team = $objTeamsController->readOneTeam($idEquipo);

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
