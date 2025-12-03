<?php

require_once __DIR__ . '/../admin/controllers/UsuarioController.php';

$controlador = new UsuarioController();
$resultado = $controlador->logout();

http_response_code(200);
echo json_encode(["status" => "success", "mensaje" => $resultado['mensaje']]);
?>