<?php
/**
 * Archivo para ver todos los submódulos que existen para determinado torneo
 * 
 * @author Saúl Valenzuela Osuna
 * @version 1.0   26-12-2024
 */
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
require_once("template/header.php");
require_once("../../controllers/torneosControllers.php");

$objTorneoController = new torneosController();
$id = $_POST['id'];
$row = $objTorneoController->readOneTorneos($id);

$cantidad = $_POST['txtGroups'];
?>

<div class="container mt-5">
    <div class="card text-center shadow-lg rounded">
        <div class="card-header bg-primary text-white">
            <h3><i class="fa-solid fa-trophy"></i> <?= $cantidad ?> grupos para el torneo: <?= $row['nombreTorneo'] ?>
                <i class="fa-solid fa-trophy"></i>
            </h3>
        </div>
        <div class="card-body">
            <form action="saveGroups.php" method="POST">
                <input type="hidden" name="idTorneo" value="<?= $row['id'] ?>">
                <?php for ($i = 1; $i <= $cantidad; $i++): ?>
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5>Grupo <?= $i ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="txtNombreGrupo<?= $i ?>" class="form-label">Nombre del Grupo</label>
                                <input type="text" name="txtNombreGrupo<?= $i ?>" id="txtNombreGrupo<?= $i ?>"
                                    class="form-control" placeholder="Escribe el nombre del grupo" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoriaGrupo<?= $i ?>" class="form-label">Categoría del Grupo</label>
                                <select name="categoriaGrupo<?= $i ?>" id="categoriaGrupo<?= $i ?>" class="form-select"
                                    required>
                                    <option value="" disabled selected>Selecciona una categoría</option>
                                    <option value="1era Fuerza">1era Fuerza</option>
                                    <option value="2da Fuerza">2da Fuerza</option>
                                    <option value="Libre">Libre</option>
                                    <option value="Veteranos">Veteranos</option>
                                    <option value="Empresarial">Empresarial</option>
                                    <option value="Infantil">Infantil</option>
                                    <option value="Juvenil">Juvenil</option>
                                    <option value="MiniBasket">MiniBasket</option>
                                    <option value="Femenil">Femenil</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
                <button type="submit" class="btn btn-primary">Guardar Grupos</button>
            </form>

        </div>
        <div class="card-footer text-muted">
            Configuración de torneos. Web App Basket-Ball.
        </div>
    </div>
    <a href="submodulesTorneo.php?id=<?= $row['id'] ?>" class="btn btn-danger mt-3"><i
            class="fa-solid fa-arrow-left"></i> Regresar</a>
</div>

<?php
require_once("template/footer.php");
?>