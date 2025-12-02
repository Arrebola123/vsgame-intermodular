<?php
class Carta
{
    private $conexion;
    private $tabla = "cartas";

    public $id;
    public $nombre;
    public $ataque;
    public $defensa;
    public $imagen;

    public function __construct($db)
    {
        $this->conexion = $db;
    }

    // Obtener todas las cartas (Esto lo mire en chatgpt para facilitar la programación)
    /**
     * @return PDOStatement
     */
    public function obtenerTodas()
    {
        $consulta = "SELECT * FROM " . $this->tabla;
        $stmt = $this->conexion->prepare($consulta);
        $stmt->execute();
        return $stmt;
    }

    // Crear carta
    public function crear()
    {
        $consulta = "INSERT INTO " . $this->tabla . " SET nombre=:nombre, ataque=:ataque, defensa=:defensa, imagen=:imagen";
        $stmt = $this->conexion->prepare($consulta);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->ataque = htmlspecialchars(strip_tags($this->ataque));
        $this->defensa = htmlspecialchars(strip_tags($this->defensa));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":ataque", $this->ataque);
        $stmt->bindParam(":defensa", $this->defensa);
        $stmt->bindParam(":imagen", $this->imagen);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>