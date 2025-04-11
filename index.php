<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow-lg w-100" style="max-width: 400px;">
        <div class="card-header text-center bg-primary text-white">
            <i class="fas fa-user-circle"></i> WebApp Basket-Ball
        </div>
        <div class="card-body">
            <p class="text-center mb-4">Selecciona tu tipo de usuario</p>
            <div class="d-grid gap-3">
                <a href="views/admin/login.php" class="btn btn-primary">
                    <i class="fas fa-cogs"></i> Administrador
                </a>
                <a href="views/organizer/login.php" class="btn btn-success">
                    <i class="fas fa-users"></i> Organizador
                </a>
                <a href="views/user/user.php" class="btn btn-warning">
                    <i class="fas fa-basketball-ball"></i> Jugador
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
