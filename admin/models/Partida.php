<?php
class Partida
{
    private $conexion;
    private $tabla = "partidas";

    public $id;
    public $usuario_id;
    public $wins;
    public $loses;
    public $fecha;

    public function __construct($db)
    {
        $this->conexion = $db;
    }

    //Guardar la puntuación de la partida.
    public function guardar()
    {
        $consulta = "INSERT INTO " . $this->tabla . " SET usuario_id=:usuario_id, wins=:wins, loses=:loses";
        $stmt = $this->conexion->prepare($consulta);

        $this->usuario_id = htmlspecialchars(strip_tags($this->usuario_id));
        $this->wins = htmlspecialchars(strip_tags($this->wins));
        $this->loses = htmlspecialchars(strip_tags($this->loses));

        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":wins", $this->wins);
        $stmt->bindParam(":loses", $this->loses);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Obtener historial del jugador
    public function obtenerHistorial($usuario_id)
    {
    $consulta = "SELECT 
                    u.usuario,
                    p.wins,
                    p.loses,
                    p.fecha
                 FROM " . $this->tabla . " p
                 JOIN usuarios u ON p.usuario_id = u.id
                 WHERE p.usuario_id = :usuario_id
                 ORDER BY p.fecha DESC
                 LIMIT 10"; //Esta consulta nos da las últimas 10 partidas del usuario (No recordaba como hacerlo así que consulté a ChatGPT)

    $stmt = $this->conexion->prepare($consulta);
    $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>