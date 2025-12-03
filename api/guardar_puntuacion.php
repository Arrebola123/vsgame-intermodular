<?php
require_once __DIR__ . '/../admin/controllers/PartidaController.php';
require_once __DIR__ . '/../admin/controllers/UsuarioController.php';

$usuarioController = new UsuarioController();
$estadoLogin = $usuarioController->verificarSesion();

$controlador = new PartidaController();
$datos = json_decode(file_get_contents("php://input"), true);

if (!empty($datos['puntuacion'])) {
    $usuario_id = $datos['usuario_id'] ?? null;

    if ($usuario_id) {
        $resultado = $controlador->guardarPuntuacion($usuario_id, $datos['puntuacion']);
        if (isset($resultado['error'])) {
            http_response_code(500);
        } else {
            http_response_code(200);
        }
        echo json_encode($resultado);
    } else {
        http_response_code(400);
        echo json_encode(array("mensaje" => "usuario_id es requerido."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("mensaje" => "Datos incompletos."));
}
?>