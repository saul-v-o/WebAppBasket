<?php
/**
 * Página principal del menú de torneos.
 * 
 * Esta página presenta un menú principal con opciones para gestionar torneos de baloncesto,
 * incluyendo la creación de nuevos torneos, visualización de listados, estadísticas y anuncios.
 * 
 * @package WebAppBasketBall
 * @author Saúl Valenzuela Osuna
 * @since 2024-11-24
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("template/header.php");
?>
<div class="container my-5">
    <div class="card text-center shadow-lg rounded">
        <div class="card-header bg-primary text-white">
            <h3>Menú</h3>
        </div>
        <div class="card-body">
            <h5 class="card-title mb-4">Opciones Disponibles</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Crear Torneo
                        </div>
                        <div class="card-body">
                            <a href="chooseOrganizer.php"
                                class="btn d-flex justify-content-center align-items-center">
                                <img src="../img/baske.jpg" alt="Crear un torneo" class="img-fluid"
                                    style="max-width: 150px;">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Listado de Torneos
                        </div>
                        <div class="card-body">
                            <a href="readAllTorneo.php"
                                class="btn d-flex justify-content-center align-items-center">
                                <img src="../img/lista.png" alt="Listar un torneo" class="img-fluid"
                                    style="max-width: 150px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Estadísticas
                        </div>
                        <div class="card-body">
                            <a href="statistics.php"
                                class="btn d-flex justify-content-center align-items-center">
                                <img src="../img/estadisticas.jpg" alt="Ver estadísticas de torneos" class="img-fluid"
                                    style="max-width: 150px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center mt-4">
            <a href="frmAdmin.php" class="btn btn-warning">Agregar Administrador</a>
        </div>
        <div class="card-footer text-body-secondary">
            Configuración de torneos. Web App Basket-Ball.
        </div>
    </div>
</div>

<?php
require_once("template/footer.php");
?>