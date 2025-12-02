<?php
class Partida
{
    private $conexion;
    private $tabla = "partidas";

    public $id;
    public $usuario_id;
    public $puntuacion;
    public $fecha;

    public function __construct($db)
    {
        $this->conexion = $db;
    }

    // Guardar puntuación
    public function guardar()
    {
        $consulta = "INSERT INTO " . $this->tabla . " SET usuario_id=:usuario_id, puntuacion=:puntuacion";
        $stmt = $this->conexion->prepare($consulta);

        $this->usuario_id = htmlspecialchars(strip_tags($this->usuario_id));
        $this->puntuacion = htmlspecialchars(strip_tags($this->puntuacion));

        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":puntuacion", $this->puntuacion);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Obtener ranking (top 10)
    public function obtenerRanking($limite = 10)
    {
        $consulta = "SELECT u.usuario, p.puntuacion, p.fecha 
                  FROM " . $this->tabla . " p
                  JOIN usuarios u ON p.usuario_id = u.id
                  ORDER BY p.puntuacion DESC
                  LIMIT " . $limite;
        $stmt = $this->conexion->prepare($consulta);
        $stmt->execute();
        return $stmt;
    }
}
?>