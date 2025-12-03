<?php
require_once __DIR__ . '/../../controllers/CartaController.php';
$controller = new CartaController();
$cartas = $controller->index();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Lista de Cartas</title>
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Lista de Cartas</h2>
            <a href="create.php" class="btn btn-primary"><i>Añadir una nueva carta</i></a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ataque</th>
                    <th>Defensa</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartas as $carta): ?>
                    <tr>
                        <td><b><?php echo $carta['id']; ?></b></td>
                        <td><i><?php echo $carta['nombre']; ?></i></td>
                        <td><?php echo $carta['ataque']; ?></td>
                        <td><?php echo $carta['defensa']; ?></td>
                        <td><img src="../../../img/cards/<?php echo $carta['imagen']; ?>" alt="<?php echo $carta['nombre']; ?>"
                                style="height: 125px;"></td>
                        <td>
                            <a href="edit.php?id=<?php echo $carta['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="delete.php?id=<?php echo $carta['id']; ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Estás seguro?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>