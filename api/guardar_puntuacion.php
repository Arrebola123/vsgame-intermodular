<?php
require_once __DIR__ . '/../admin/controllers/PartidaController.php';

$controlador = new PartidaController();
$datos = json_decode(file_get_contents("php://input"), true);

if (!empty($datos['usuario_id']) && isset($datos['wins']) && isset($datos['loses'])) {
    $usuario_id = $datos['usuario_id'];
    $wins = $datos['wins'];
    $loses = $datos['loses'];

    $resultado = $controlador->guardarPuntuacion($usuario_id, $wins, $loses);

    if (isset($resultado['error']) && $resultado['error']) {
        http_response_code(500);
        echo json_encode($resultado);
    } else {
        http_response_code(200);
        echo json_encode($resultado);
    }
} else {
    http_response_code(400);
    echo json_encode(["mensaje" => "Datos incompletos. Se requiere usuario_id, wins y loses."]);
}
?>