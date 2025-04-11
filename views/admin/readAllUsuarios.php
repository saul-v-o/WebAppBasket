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
    require_once("../../controllers/usuariosControllers.php"); 

    $objUsuariosController = new usuariosController(); 
    $rows = $objUsuariosController->readUsuarios();
?>

<div class="mx-auto p-5">
    <div class="card text-center">
        <div class="card-header">
            <span class="fa-solid fa-user"> LISTADO DE USUARIOS </span>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">APELLIDO PATERNO</th>
                        <th scope="col">APELLIDO MATERNO</th>
                        <th scope="col">USUARIO</th>
                        <th scope="col">CORREO</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($rows): ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <th> <?= $row['id_organizador'] ?></th>
                                <th> <?= $row['nombre']; ?></th>
                                <th> <?= $row['apellidoP']; ?></th>
                                <th> <?= $row['apellidoM']; ?></th>
                                <th> <?= $row['usuario']; ?></th>
                                <th> <?= $row['correo']; ?></th>
                                <th>
                                    <a href="readOneTorneo.php?id=<?= $row['id_organizador'] ?>" class="btn btn-primary fa-solid fa-list-check"></a>
                                    
                                    <a href="updateTorneo.php?id=<?= $row['id_organizador'] ?>" class="btn btn-success fa-solid fa-pen-to-square"></a>

                                    <button type="button" class="btn btn-danger fa-solid fa-trash" data-bs-toggle="modal" data-bs-target="#idModal<?= $row['id_organizador'] ?>"></button>

                                    <div class="modal fade" id="idModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modal<?= $row['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modal<?= $row['id'] ?>">¿Deseas eliminar el torneo?</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    La acción no se puede deshacer.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <a href="deleteTorneo.php?id=<?= $row['id'] ?>" class="btn btn-danger">Eliminar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">
                                No hay torneos aún.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mx-auto p-2">
        <a href="admin.php" class="btn btn-primary">REGRESAR</a>
    </div>
</div>

<?php
    require_once("template/footer.php");
?>
