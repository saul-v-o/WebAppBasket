<?php
    /**
     * Página para capturar la información de un torneo.
     * 
     * Este archivo genera un formulario que permite a los usuarios registrar los datos de un torneo, 
     * incluyendo información como nombre, organizador, patrocinadores, premios y usuario. 
     * Los datos ingresados se envían al script `torneoInsert.php` para ser procesados.
     * 
     * PHP version 8.1
     * 
     * @category Views
     * @package  WebAppBasketBall
     * @author   Saúl Valenzuela Osuna
     */
    require_once("template/header.php");
?>

<div class="mx-auto p-5" style="max-width: 700px;">
    <div class="card">
        <div class="card-header text-center">
            <span class="fa-solid fa-user-plus"> REGISTRO USUARIO</span>
        </div>
        <div class="card-body">
            <form action="usuarioInsert.php" method="post">
                <div class="row">
                    <div class="mb-2">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="txtNombre" id="nombre">
                    </div>
                    <div class="mb-2">
                        <label for="apellidop" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" name="txtApellidoP" id="apellidop">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="apellidom" class="form-label">Apellido Materno</label>
                    <input type="text" class="form-control" name="txtApellidoM" id="apellidom">
                </div>
                <div class="mb-2">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="txtUsuario" id="usuario" class="form-control">
                </div>
                <div class="mb-2">
                    <label for="correo" class="form-label">Gmail</label>
                    <input type="email" class="form-control" name="txtCorreo" id="correo">
                </div>
                <div class="mb-2">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" name="txtContrasena" id="contrasena" class="form-control">
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary ">Agregar</button>
                    <a href="admin.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
    require_once("template/footer.php");
?>