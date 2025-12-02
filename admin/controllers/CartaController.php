<?php
require_once __DIR__ . '/../models/Carta.php';
require_once __DIR__ . '/../models/Database.php';

class CartaController
{
    private $db;
    private $carta;

    public function __construct()
    {
        $baseDeDatos = new BaseDeDatos();
        $this->db = $baseDeDatos->conectar();
        $this->carta = new Carta($this->db);
    }

    public function index()
    {
        $stmt = $this->carta->obtenerTodas();
        $cartas = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($cartas, $fila);
        }
        return $cartas;
    }

    public function crear($datos)
    {
        $this->carta->nombre = $datos['nombre'];
        $this->carta->ataque = $datos['ataque'];
        $this->carta->defensa = $datos['defensa'];
        $this->carta->imagen = $datos['imagen'];

        if ($this->carta->crear()) {
            return true;
        }
        return false;
    }
}
?>