<?php
require_once __DIR__ . '/../admin/controllers/UsuarioController.php';

$controlador = new UsuarioController();

$datos = json_decode(file_get_contents("php://input"), true);

if (!empty($datos['email']) && !empty($datos['password'])) {
    $resultado = $controlador->login($datos['email'], $datos['password']);

    if (isset($resultado['error']) && $resultado['error']) {
        http_response_code(401);
        echo json_encode($resultado);
    } else {
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "mensaje" => $resultado['mensaje'],
            "usuario_id" => $resultado['usuario_id'],
            "nombre" => $resultado['nombre_usuario']
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode(array("status" => "error", "mensaje" => "Datos incompletos."));
}
?>