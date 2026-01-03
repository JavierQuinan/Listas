<?php
/**
 * Modelo de Proveedores - PDO/SQLite
 * Sistema de Facturación
 */
include_once(__DIR__ . '/../config/config.php');

class Proveedores
{
    private $db;

    public function __construct()
    {
        $conexion = new ClaseConectar();
        $this->db = $conexion->ProcedimientoParaConectar();
    }

    public function todos()
    {
        $stmt = $this->db->query("SELECT * FROM Proveedores");
        return $stmt->fetchAll();
    }

    public function uno($idProveedores)
    {
        $stmt = $this->db->prepare("SELECT * FROM Proveedores WHERE idProveedores = :id");
        $stmt->execute([':id' => $idProveedores]);
        return $stmt->fetch();
    }

    public function insertar($Nombre_Empresa, $Direccion, $Telefono, $Contacto_Empresa, $Telefono_Contacto)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO Proveedores (Nombre_Empresa, Direccion, Telefono, Contacto_Empresa, Telefono_Contacto) VALUES (:empresa, :direccion, :telefono, :contacto, :tel_contacto)");
            $result = $stmt->execute([
                ':empresa' => $Nombre_Empresa,
                ':direccion' => $Direccion,
                ':telefono' => $Telefono,
                ':contacto' => $Contacto_Empresa,
                ':tel_contacto' => $Telefono_Contacto
            ]);
            return $result ? $this->db->lastInsertId() : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizar($idProveedores, $Nombre_Empresa, $Direccion, $Telefono, $Contacto_Empresa, $Telefono_Contacto)
    {
        try {
            $stmt = $this->db->prepare("UPDATE Proveedores SET Nombre_Empresa = :empresa, Direccion = :direccion, Telefono = :telefono, Contacto_Empresa = :contacto, Telefono_Contacto = :tel_contacto WHERE idProveedores = :id");
            $result = $stmt->execute([
                ':id' => $idProveedores,
                ':empresa' => $Nombre_Empresa,
                ':direccion' => $Direccion,
                ':telefono' => $Telefono,
                ':contacto' => $Contacto_Empresa,
                ':tel_contacto' => $Telefono_Contacto
            ]);
            return $result ? $idProveedores : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function eliminar($idProveedores)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM Proveedores WHERE idProveedores = :id");
            return $stmt->execute([':id' => $idProveedores]);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
