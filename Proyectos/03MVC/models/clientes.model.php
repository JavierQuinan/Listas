<?php
/**
 * Modelo de Clientes - PDO/SQLite
 * Sistema de Facturación
 */
include_once(__DIR__ . '/../config/config.php');

class Clientes
{
    private $db;

    public function __construct()
    {
        $conexion = new ClaseConectar();
        $this->db = $conexion->ProcedimientoParaConectar();
    }

    public function buscar($texto)
    {
        $stmt = $this->db->prepare("SELECT * FROM Clientes WHERE Nombres LIKE :texto");
        $stmt->execute([':texto' => "%$texto%"]);
        return $stmt->fetchAll();
    }

    public function todos()
    {
        $stmt = $this->db->query("SELECT * FROM Clientes");
        return $stmt->fetchAll();
    }

    public function uno($idClientes)
    {
        $stmt = $this->db->prepare("SELECT * FROM Clientes WHERE idClientes = :id");
        $stmt->execute([':id' => $idClientes]);
        return $stmt->fetch();
    }

    public function insertar($Nombres, $Direccion, $Telefono, $Cedula, $Correo)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO Clientes (Nombres, Direccion, Telefono, Cedula, Correo) VALUES (:nombres, :direccion, :telefono, :cedula, :correo)");
            $result = $stmt->execute([
                ':nombres' => $Nombres,
                ':direccion' => $Direccion,
                ':telefono' => $Telefono,
                ':cedula' => $Cedula,
                ':correo' => $Correo
            ]);
            return $result ? $this->db->lastInsertId() : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizar($idClientes, $Nombres, $Direccion, $Telefono, $Cedula, $Correo)
    {
        try {
            $stmt = $this->db->prepare("UPDATE Clientes SET Nombres = :nombres, Direccion = :direccion, Telefono = :telefono, Cedula = :cedula, Correo = :correo WHERE idClientes = :id");
            $result = $stmt->execute([
                ':id' => $idClientes,
                ':nombres' => $Nombres,
                ':direccion' => $Direccion,
                ':telefono' => $Telefono,
                ':cedula' => $Cedula,
                ':correo' => $Correo
            ]);
            return $result ? $idClientes : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function eliminar($idClientes)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM Clientes WHERE idClientes = :id");
            return $stmt->execute([':id' => $idClientes]);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
