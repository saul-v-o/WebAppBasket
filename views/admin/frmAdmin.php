<?php
/**
 * Página para capturar la información de un admin
 * 
 * @category Views
 * @package  WebAppBasketBall
 * @author   Saúl Valenzuela Osuna
 * @version  1.0   23-12-2024
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("template/header.php");
?>

<div class="mx-auto p-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Registro de un Administrador</h4>
                </div>
                <div class="card-body text-center">
                    <form action="adminInsert.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input name="nombre" type="text" class="form-control text-center" id="nombre"
                                placeholder="Ingresa tu nombre">
                        </div>
                        <div class="mb-3">
                            <label for="apellidoP" class="form-label">Apellido Paterno</label>
                            <input name="apellidoP" type="text" class="form-control text-center" id="apellidoP"
                                placeholder="Ingresa el apellido paterno">
                        </div>
                        <div class="mb-3">
                            <label for="apellidoM" class="form-label">Apellido Materno</label>
                            <input name="apellidoM" type="text" class="form-control text-center" id="apellidoM"
                                placeholder="Ingresa el apellido materno">
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input name="correo" type="email" class="form-control text-center" id="correo"
                                placeholder="ejemplo@correo.com">
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input name="usuario" type="text" class="form-control text-center" id="usuario"
                                placeholder="Crea un nombre de usuario">
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input name="contrasena" type="password" class="form-control text-center" id="contraseña"
                                placeholder="Crea una contraseña">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>Todos los campos son obligatorios</small>
                </div>
            </div>
        </div>
    </div>
    <a href="admin.php" class="btn btn-danger mt-4">
        <i class="fa-solid fa-arrow-left"></i> Regresar
    </a>
</div>

<?php
require_once("template/footer.php");
?>