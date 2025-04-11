<?php
    /**
     * API REST para obtener los datos de la tabla "juegos" en formato JSON.
     *
     * Este archivo permite obtener la lista de juegos de un torneo específico en formato JSON. 
     * La API responde a solicitudes HTTP POST con el parámetro `idTorneo` en la URL.
     *
     * @package API
     * @author Saúl Valenzuela Osuna
     * @version 1.0     01-05-2025
     */

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once '../../controllers/gamesController.php';

    try {
        /**
         * @var gamesController  Variable-instancia de la clase controladora de juegos
         */
        $objGamesController = new gamesController();

        if (isset($_GET["idTorneo"])) {
            $idTorneo = $_GET['idTorneo'];
            $idGrupo = isset($_GET['idGrupo']) ? $_GET['idGrupo'] : null;
        
            if ($idGrupo) {
                $games = $objGamesController->getGamesByGroupAndTournament($idTorneo, $idGrupo);
            } else {
                $games = $objGamesController->getGamesByTournament($idTorneo);
            }
        
            if ($games) {
                http_response_code(200);
                echo json_encode($games);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Juegos no encontrados..."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Falta el parámetro idTorneo"]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            'message' => 'Error ' . $e->getMessage()
        ]);
    }
?>
