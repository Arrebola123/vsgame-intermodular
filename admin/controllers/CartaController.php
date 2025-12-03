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
    public function editar($id)
    {
        $this->carta->id = $id;
        if ($this->carta->obtenerPorId($id)) {
            return $this->carta;
        }
        return null;
    }

    public function actualizar($datos)
    {
        $this->carta->id = $datos['id'];
        $this->carta->nombre = $datos['nombre'];
        $this->carta->ataque = $datos['ataque'];
        $this->carta->defensa = $datos['defensa'];
        $this->carta->imagen = $datos['imagen'];

        if ($this->carta->actualizar()) {
            return true;
        }
        return false;
    }

    public function eliminar($id)
    {
        $this->carta->id = $id;
        if ($this->carta->eliminar()) {
            return true;
        }
        return false;
    }
}
?>