<?php
    /**
     * API REST para obtener los datos de la tabla "equipos" en formato JSON.
     *
     * Este archivo permite obtener la lista de equipos de un torneo específico en formato JSON.
     * La API responde a solicitudes HTTP POST con el parámetro `idTorneo` en la URL.
     *
     * @package API
     * @author Saúl Valenzuela Osuna
     * @version 1.0  01-05-2025
     */
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

    require_once("../../controllers/torneosControllers.php");
    require_once("../../controllers/teamsController.php");

    try {
        /**
         * @var torneosController Variable-instancia de la clase controladora de los torneos
         */
        $objTorneoController = new torneosController();

        /**
         * @var teamsController Variable-instancia de la clase controladora de los equipos
         */
        $objTeamsController = new teamsController();

        if (isset($_GET['id'])) {
            /**
             * @var string s
             */
            $id = intval($_GET['id']);

            /**
             * @var array  Variable que contiene los datos del toreno
             */
            $row = $objTorneoController->readOneTorneos($id);

            /**
             * @var array Variable que contiene los datos de los equipos
             */
            $equipos = $objTeamsController->readTeamsByTournament($id);

            if ($row || $equipos) {
                /**
                 * @var string Variable de respuesta
                 */
                $response = [
                    'torneo' => $row,
                    'equipos' => $equipos
                ];
                http_response_code(200); 
            } else {
                /**
                 * @var string Variable de respuesta
                 */
                $response = ['message' => 'No se encontraron resultados'];
                http_response_code(404);
            }

            echo json_encode($response);
        } else {
            /**
             * @var string  Variable de respuesta
             */
            $response = ['message' => 'Parámetro `id` es requerido'];
            http_response_code(400); 
            echo json_encode($response);
        }

    } catch (Exception $e) {
        /**
         * @var string Variable de respuesta
         */
        $response = ['message' => 'Error del servidor: ' . $e->getMessage()];
        http_response_code(500);
        echo json_encode($response);
    }
?>