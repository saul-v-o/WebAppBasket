<?php
/**
 * playerInsert.php
 * Archivo encargado de procesar y guardar la información de un jugador en la base de datos.
 * 
 * @author Saúl Valenzuela
 * @version 1.0   26-12-2024
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once("../../controllers/playerController.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $id = $_POST['idTorneo'];
    if (
        isset($_POST['idEquipo'], $_POST['nombreJugador'], $_POST['apellidosJugador'], $_POST['fechaNacimiento'], 
        $_POST['correoJugador'], $_POST['celularJugador'], $_POST['tipoSangre'], $_POST['contactoEmergencia'])
        && isset($_FILES['fotografiaJugador'])
    ) {
        // Recuperar los datos del formulario
        $idEquipo = htmlspecialchars($_POST['idEquipo']);
        $nombre = htmlspecialchars($_POST['nombreJugador']);
        $apellidos = htmlspecialchars($_POST['apellidosJugador']);
        $fechaNacimiento = htmlspecialchars($_POST['fechaNacimiento']);
        $correo = htmlspecialchars($_POST['correoJugador']);
        $celular = htmlspecialchars($_POST['celularJugador']);
        $tipoSangre = htmlspecialchars($_POST['tipoSangre']);
        $contactoEmergencia = htmlspecialchars($_POST['contactoEmergencia']);

        // Procesar la subida de la fotografía
        $fotografia = null;
        if ($_FILES['fotografiaJugador']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = "../img/players/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Crear el directorio si no existe
            }
            $fileName = uniqid('jugador_') . "_" . basename($_FILES['fotografiaJugador']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['fotografiaJugador']['tmp_name'], $uploadFile)) {
                $fotografia = $fileName;
            } else {
                die("Error al subir la fotografía.");
            }
        }

        // Guardar los datos en la base de datos
        $objPlayerController = new playerController();
        $objPlayerController->savePlayer(
            $idEquipo, 
            $nombre, 
            $apellidos, 
            $fechaNacimiento, 
            $correo, 
            $celular, 
            $tipoSangre, 
            $contactoEmergencia, 
            $fotografia,
            $id
        );
    } else {
        die("Error: Todos los campos son obligatorios.");
    }
} else {
    die("Método de solicitud no permitido.");
}
?>
