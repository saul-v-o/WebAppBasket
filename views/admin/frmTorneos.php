<?php
/**
 * Página para capturar la información de un torneo.
 * 
 * Este archivo genera un formulario que permite a los usuarios registrar los datos de un torneo, 
 * incluyendo información como nombre, organizador, patrocinadores, premios y usuario. 
 * Los datos ingresados se envían al script `torneoInsert.php` para ser procesados.
 * 
 * @category Views
 * @package  WebAppBasketBall
 * @author   Saúl Valenzuela Osuna
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("template/header.php");
?>
<div class="container py-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa-solid fa-trophy"></i> Capturar la Información del Torneo</h5>
        </div>
        <div class="card-body">
            <form action="torneoInsert.php" method="post" enctype="multipart/form-data">
                <!-- Nombre del Torneo -->
                <div class="mb-3">
                    <label for="nombreTorneo" class="form-label">Nombre del Torneo</label>
                    <input type="text" class="form-control" name="txtNombreTorneo" id="nombreTorneo" placeholder="Ej. Torneo Estatal de Fútbol">
                </div>

                <!-- Logotipo del Torneo -->
                <div class="mb-3">
                    <label for="logoTorneo" class="form-label">Logotipo del Torneo</label>
                    <input type="file" class="form-control" name="fileLogoTorneo" id="logoTorneo" accept="image/*">
                </div>

                <!-- Patrocinadores -->
                <div class="mb-3">
                    <label for="patrocinador" class="form-label">Patrocinador(es)</label>
                    <textarea name="txtPatrocinador" id="patrocinador" rows="2" class="form-control"
                        placeholder="Ej. Coca-Cola, Nike"></textarea>
                    <small class="form-text text-muted">Separa los nombres con una coma si hay más de un patrocinador.</small>
                </div>

                <!-- Logos de Patrocinadores -->
                <div class="mb-3">
                    <label for="logosPatrocinadores" class="form-label">Logos de Patrocinadores</label>
                    <input type="file" class="form-control" name="fileLogosPatrocinadores[]" id="logosPatrocinadores" accept="image/*" multiple>
                </div>

                <!-- Organizador -->
                <div class="mb-3">
                    <label for="organizador" class="form-label">Organizador</label>
                    <input type="text" class="form-control" name="txtOrganizador" id="organizador" placeholder="Nombre completo del organizador">
                </div>

                <!-- Sede -->
                <div class="mb-3">
                    <label for="sede" class="form-label">Sede (lugar donde se realizará el torneo)</label>
                    <input type="text" class="form-control" name="txtSede" id="sede" placeholder="Ej. Estadio Nacional">
                </div>

                <!-- Premios -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="premio1" class="form-label">Premio 1er Lugar</label>
                        <input type="text" class="form-control" name="txtPremio1" id="premio1" placeholder="Ej. Trofeo + $5000">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="premio2" class="form-label">Premio 2do Lugar</label>
                        <input type="text" class="form-control" name="txtPremio2" id="premio2" placeholder="Ej. Medalla + $3000">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="premio3" class="form-label">Premio 3er Lugar</label>
                        <input type="text" class="form-control" name="txtPremio3" id="premio3" placeholder="Ej. Medalla + $1000">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="otroPremio" class="form-label">Otro Premio</label>
                        <input type="text" class="form-control" name="txtOtroPremio" id="otroPremio" placeholder="Ej. Campeón Anotador">
                    </div>
                </div>

                <!-- Usuario y Contraseña -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="usuario" class="form-label">Usuario Organizador</label>
                        <input type="text" class="form-control" name="txtUsuarioOrganizador" id="usuario" placeholder="Ej. usuario123">
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Guardar</button>
                    <a href="chooseOrganizer.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
        <div class="card-footer text-muted text-center">
            <small>Formulario para registrar torneo</small>
        </div>
    </div>
</div>



<?php
require_once("/template/footer.php");
?>