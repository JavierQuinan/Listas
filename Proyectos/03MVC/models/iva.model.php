<?php
/**
 * Modelo de IVA - PDO/SQLite
 * Sistema de Facturación
 */
include_once(__DIR__ . '/../config/config.php');

class IVA
{
    private $db;

    public function __construct()
    {
        $conexion = new ClaseConectar();
        $this->db = $conexion->ProcedimientoParaConectar();
    }

    public function todos()
    {
        $stmt = $this->db->query("SELECT * FROM IVA WHERE Estado = 1");
        return $stmt->fetchAll();
    }

    public function todosIncluidos()
    {
        $stmt = $this->db->query("SELECT * FROM IVA");
        return $stmt->fetchAll();
    }

    public function uno($idIVA)
    {
        $stmt = $this->db->prepare("SELECT * FROM IVA WHERE idIVA = :id");
        $stmt->execute([':id' => $idIVA]);
        return $stmt->fetch();
    }

    public function activo()
    {
        $stmt = $this->db->query("SELECT * FROM IVA WHERE Estado = 1 ORDER BY idIVA DESC LIMIT 1");
        return $stmt->fetch();
    }

    public function insertar($Detalle, $Estado, $Valor)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO IVA (Detalle, Estado, Valor) VALUES (:detalle, :estado, :valor)");
            $result = $stmt->execute([
                ':detalle' => $Detalle,
                ':estado' => $Estado,
                ':valor' => $Valor
            ]);
            return $result ? $this->db->lastInsertId() : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizar($idIVA, $Detalle, $Estado, $Valor)
    {
        try {
            $stmt = $this->db->prepare("UPDATE IVA SET Detalle = :detalle, Estado = :estado, Valor = :valor WHERE idIVA = :id");
            $result = $stmt->execute([
                ':id' => $idIVA,
                ':detalle' => $Detalle,
                ':estado' => $Estado,
                ':valor' => $Valor
            ]);
            return $result ? $idIVA : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function eliminar($idIVA)
    {
        try {
            $stmt = $this->db->prepare("UPDATE IVA SET Estado = 0 WHERE idIVA = :id");
            return $stmt->execute([':id' => $idIVA]);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
