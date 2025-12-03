<?php
require_once __DIR__ . '/../admin/controllers/PartidaController.php';

$controlador = new PartidaController();
$cartas = $controlador->iniciarJuego();

echo json_encode($cartas);
?>