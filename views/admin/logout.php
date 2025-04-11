<?php
    /**
     * Archivo para destruir la sesión que exista
     * 
     * @package WebAppBasketBall
     * @author Saúl Valenzuela Osuna
     * @version 1.0   26-12-2024
     */

    session_start();
    session_unset(); 
    session_destroy();
    header('Location: ../../index.php'); 
    exit();
?>
