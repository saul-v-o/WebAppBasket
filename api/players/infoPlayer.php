<?php
    /**
     * API REST para obtener los datos de la tabla "jugadores" en formato JSON.
     *
     * Este archivo permite obtener la lista de jugadores de un equipo específico en formato JSON.
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
    require_once '../../controllers/playerController.php';

    try {
        /**
         * @var playerController  Variable-instancia de la clase controladora de los jugadores
         */
        $objPlayerController = new playerController();

        if (isset($_GET["idEquipo"])) {
            /**
             * @var string  Variable que guarda el id del equipo
             */
            $idEquipo = $_GET['idEquipo'];

            /**
             * @var array  Variable que guarda los datos devueltos
             */
            $player = $objPlayerController->readPlayersByTeam($idEquipo);

            if ($player) {
                http_response_code(200);
                echo json_encode($player);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Jugador no encontrado..."]);
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
