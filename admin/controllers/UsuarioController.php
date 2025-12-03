<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Database.php';

class UsuarioController
{
    private $db;
    private $usuario;

    public function __construct()
    {
        $baseDeDatos = new BaseDeDatos();
        $this->db = $baseDeDatos->conectar();
        $this->usuario = new Usuario($this->db);
    }

    public function registrar($datos)
    {
        $this->usuario->usuario = $datos['usuario'];
        $this->usuario->email = $datos['email'];
        $this->usuario->password = password_hash($datos['password'], PASSWORD_BCRYPT);

        if ($this->usuario->crear()) {
            return ["mensaje" => "Usuario creado exitosamente."];
        } else {
            return ["mensaje" => "No se pudo crear el usuario.", "error" => true];
        }
    }

    public function login($email, $password)
    {
        if ($this->usuario->obtenerPorEmail($email)) {
            if (password_verify($password, $this->usuario->password)) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['usuario_id'] = $this->usuario->id;
                $_SESSION['nombre_usuario'] = $this->usuario->usuario;

                return [
                    "mensaje" => "Login exitoso.",
                    "usuario_id" => $this->usuario->id,
                    "nombre_usuario" => $this->usuario->usuario
                ];
            }
        }
        return ["mensaje" => "Credenciales inválidas.", "error" => true];
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        return ["mensaje" => "Sesión cerrada exitosamente."];
    }

    public function verificarSesion()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['usuario_id'])) {
            return [
                "logueado" => true,
                "usuario_id" => $_SESSION['usuario_id'],
                "nombre_usuario" => $_SESSION['nombre_usuario']
            ];
        }
        return ["logueado" => false];
    }

    public function index()
    {
        $stmt = $this->usuario->obtenerTodos();
        $usuarios = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($usuarios, $fila);
        }
        return $usuarios;
    }
}
?>