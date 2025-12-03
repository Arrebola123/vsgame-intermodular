<?php
require_once __DIR__ . '/../../controllers/CartaController.php';

$controller = new CartaController();
$carta = null;

if (isset($_GET['id'])) {
    $carta = $controller->editar($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($controller->actualizar($_POST)) {
        header("Location: list.php");
        exit;
    } else {
        $error = "Error al actualizar la carta.";
        $carta = (object) $_POST;
    }
}

if (!$carta) {
    echo "Carta no encontrada.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Editar Carta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="/vsgame-intermodular/admin/views/users/list.php"><b>PANEL DE CONTROL</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/vsgame-intermodular/admin/views/users/list.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/vsgame-intermodular/admin/views/cards/list.php">Cartas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Editar Carta</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="edit.php?id=<?php echo $carta->id; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $carta->id; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $carta->nombre; ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="ataque" class="form-label">Ataque</label>
                <input type="number" class="form-control" id="ataque" name="ataque"
                    value="<?php echo $carta->ataque; ?>" required>
            </div>
            <div class="mb-3">
                <label for="defensa" class="form-label">Defensa</label>
                <input type="number" class="form-control" id="defensa" name="defensa"
                    value="<?php echo $carta->defensa; ?>" required>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">URL Imagen</label>
                <input type="text" class="form-control" id="imagen" name="imagen" value="<?php echo $carta->imagen; ?>"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="list.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>