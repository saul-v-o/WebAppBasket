<?php
/**
 * Página que muestra el login para inicar sesión como administrador
 * 
 * @package WebAppBasketBall
 * @author Saúl Valenzuela Osuna
 * @version 1.0   26-12-2024
 */

if (isset($_GET['error']) && $_GET['error'] == 1){
    echo '<p style="color: red;">Datos incorrectos. Intenta nuevamente.</p>';
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=}, initial-scale=1.0">
    <title>Web App Basket-Ball</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        <div class="card mx-auto shadow-lg rounded" style="max-width: 400px;">
            <div class="card-header text-center bg-primary text-white">
                <h4>Inicio de Sesión Administrador</h4>
            </div>
            <div class="card-body text-center">
                <form action="verifyAdmin.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" class="form-control text-center" id="username" name="txtUsuario" placeholder="Ingresa tu usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control text-center" id="password" name="txtContrasena" placeholder="Ingresa tu contraseña"
                            required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    </div>
                </form>
            </div>
        </div>
        <a href="../../index.php" class="btn btn-danger mb-4">Regresar</a>
    </div>

<?php
require_once("template/footer.php");
?>