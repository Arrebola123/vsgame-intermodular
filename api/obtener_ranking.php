<?php
require_once __DIR__ . '/../admin/controllers/PartidaController.php';

$controlador = new PartidaController();
$puntuaciones = $controlador->obtenerRanking();

echo json_encode($puntuaciones);
?>