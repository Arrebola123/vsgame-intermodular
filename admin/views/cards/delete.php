<?php
require_once __DIR__ . '/../../controllers/CartaController.php';

if (isset($_GET['id'])) {
    $controller = new CartaController();
    if ($controller->eliminar($_GET['id'])) {
        header("Location: list.php");
    } else {
        echo "Error al eliminar la carta.";
    }
} else {
    header("Location: list.php");
}
?>