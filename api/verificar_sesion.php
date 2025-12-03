<?php
require_once __DIR__ . '/../admin/controllers/UsuarioController.php';

$controlador = new UsuarioController();
$resultado = $controlador->verificarSesion();

echo json_encode($resultado);
?>