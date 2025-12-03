<?php
require_once __DIR__ . '/../config/database.php';

class BaseDeDatos
{
    public $conexion;

    public function conectar()
    {
        $this->conexion = null;
        try {
            $dsn = "mysql:host=" . Database::$host . ";dbname=" . Database::$nombre_bd;
            $this->conexion = new PDO($dsn, Database::$usuario, Database::$password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->exec("set names utf8");

        } catch (PDOException $excepcion) {
            echo "Error de conexión: " . $excepcion->getMessage();
        }
        return $this->conexion;
    }
}
?>