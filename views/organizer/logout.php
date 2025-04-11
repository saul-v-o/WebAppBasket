<?php
    /**
     * Archivo para destruir la sesión
     * 
     * @package WebAppBasketBall
     * @author Saúl Valenzuela Osuna
     * @version 1.0   23-12-2024
     */
    session_start();
    session_unset(); 
    session_destroy();
    header('Location: ../../index.php'); 
    exit();
?>
