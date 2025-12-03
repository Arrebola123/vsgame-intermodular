<?php
require_once __DIR__ . '/../models/Partida.php';
require_once __DIR__ . '/../models/Carta.php';
require_once __DIR__ . '/../models/Database.php';

class PartidaController
{
    private $db;
    private $partida;
    private $carta;

    public function __construct()
    {
        $baseDeDatos = new BaseDeDatos();
        $this->db = $baseDeDatos->conectar();
        $this->partida = new Partida($this->db);
        $this->carta = new Carta($this->db);
    }

    public function iniciarJuego()
    {
        $stmt = $this->carta->obtenerTodas();
        $cartas = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($fila);
            $item_carta = array(
                "id" => $id,
                "nombre" => $nombre,
                "ataque" => $ataque,
                "defensa" => $defensa,
                "imagen" => $imagen
            );
            array_push($cartas, $item_carta);
        }
        return $cartas;
    }

    public function guardarPuntuacion($usuario_id, $wins, $loses)
    {
        $this->partida->usuario_id = $usuario_id;
        $this->partida->wins = $wins;
        $this->partida->loses = $loses;

        if ($this->partida->guardar()) {
            return ["mensaje" => "Puntuación guardada exitosamente."];
        }
        return ["mensaje" => "No se pudo guardar la puntuación.", "error" => true];
    }

    public function obtenerRanking()
    {
        $stmt = $this->partida->obtenerRanking();
        $puntuaciones = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($puntuaciones, $fila);
        }
        return $puntuaciones;
    }
}
?>