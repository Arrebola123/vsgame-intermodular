<?php
require_once __DIR__ . '/../admin/controllers/UsuarioController.php';

$controlador = new UsuarioController();

$datos = json_decode(file_get_contents("php://input"), true);

if (
    !empty($datos['usuario']) &&
    !empty($datos['email']) &&
    !empty($datos['password'])
) {
    $resultado = $controlador->registrar($datos);
    if (isset($resultado['error'])) {
        http_response_code(400);
    } else {
        http_response_code(201);
    }
    echo json_encode($resultado);
} else {
    http_response_code(400);
    echo json_encode(array("mensaje" => "Datos incompletos."));
}
?>