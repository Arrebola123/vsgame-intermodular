<?php
require_once __DIR__ . '/../admin/controllers/PartidaController.php';

$controlador = new PartidaController();
$datos = json_decode(file_get_contents("php://input"), true);

if (!empty($datos['usuario_id'])) {

    $usuario_id = $datos['usuario_id'];
    $resultado = $controlador->obtenerHistorial($usuario_id);

    http_response_code(200);
    echo json_encode($resultado);

} else {
    http_response_code(400);
    echo json_encode(["mensaje" => "Datos incompletos. Se requiere usuario_id."]);
}
?>