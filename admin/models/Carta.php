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

    //Carta por ID
    public function obtenerPorId($id)
    {
        $consulta = "SELECT * FROM " . $this->tabla . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conexion->prepare($consulta);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $this->id = $fila['id'];
            $this->nombre = $fila['nombre'];
            $this->ataque = $fila['ataque'];
            $this->defensa = $fila['defensa'];
            $this->imagen = $fila['imagen'];
            return true;
        }
        return false;
    }

    //Actualizar una carta
    public function actualizar()
    {
        $consulta = "UPDATE " . $this->tabla . "
                    SET nombre = :nombre,
                        ataque = :ataque,
                        defensa = :defensa,
                        imagen = :imagen
                    WHERE id = :id";

        $stmt = $this->conexion->prepare($consulta);

        //Esto lo hacemos para limpiar los datos que se envían.
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->ataque = htmlspecialchars(strip_tags($this->ataque));
        $this->defensa = htmlspecialchars(strip_tags($this->defensa));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':ataque', $this->ataque);
        $stmt->bindParam(':defensa', $this->defensa);
        $stmt->bindParam(':imagen', $this->imagen);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Eliminar una carta
    public function eliminar()
    {
        $consulta = "DELETE FROM " . $this->tabla . " WHERE id = ?";
        $stmt = $this->conexion->prepare($consulta);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>