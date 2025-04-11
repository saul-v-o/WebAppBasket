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
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
        <div class="d-flex justify-content-center w-100">
                <h1 class="text-white fw-bold">Aplicación Web para Gestionar Torneos de Basket-Ball</h1>
            </div>
            <div class="d-flex justify-content-center w-100">
                <p class="text-white-50 mb-0">Organiza, gestiona y consulta resultados y torneos fácilmente</p>
            </div>
            <div class="d-flex justify-content-between align-items-center w-100 mt-2">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-circle text-light me-2" style="font-size: 1.5rem;"></i>
                    <h6 class="text-light mb-0"><?= $_SESSION['nombre'] . " " . $_SESSION['apellidoP'] ?> - Administrador</h6>
                </div>
                <a href="logout.php" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </nav>