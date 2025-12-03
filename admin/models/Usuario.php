<?php
class Usuario
{
    private $conexion;
    private $tabla = "usuarios";

    public $id;
    public $usuario;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->conexion = $db;
    }

    // Crear nuevo usuario
    public function crear()
    {
        $consulta = "INSERT INTO " . $this->tabla . " SET usuario=:usuario, email=:email, password=:password";
        $stmt = $this->conexion->prepare($consulta);

        // Limpiar datos
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Vincular valores
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function obtenerPorEmail($email)
    {
        $consulta = "SELECT id, usuario, email, password FROM " . $this->tabla . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conexion->prepare($consulta);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $this->id = $fila['id'];
            $this->usuario = $fila['usuario'];
            $this->email = $fila['email'];
            $this->password = $fila['password'];
            return true;
        }
        return false;
    }
    public function obtenerTodos()
    {
        $consulta = "SELECT * FROM " . $this->tabla;
        $stmt = $this->conexion->prepare($consulta);
        $stmt->execute();
        return $stmt;
    }
}
?>