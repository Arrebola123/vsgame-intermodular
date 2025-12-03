<?php

require_once __DIR__ . '/../admin/controllers/CartaController.php';

$controlador = new CartaController();
$cartas = $controlador->index();

if (count($cartas) >= 2) {
    $indices = array_rand($cartas, 2);
    $carta1 = $cartas[$indices[0]];
    $carta2 = $cartas[$indices[1]];

    $response = [
        "status" => "success",
        "ataque1" => $carta1['ataque'],
        "defensa1" => $carta1['defensa'],
        "url1" => $carta1['imagen'],
        "ataque2" => $carta2['ataque'],
        "defensa2" => $carta2['defensa'],
        "url2" => $carta2['imagen']
    ];
    http_response_code(200);
} else {
    $response = [
        "status" => "error",
        "mensaje" => "No hay suficientes cartas disponibles"
    ];
    http_response_code(500);
}

echo json_encode($response);
?>