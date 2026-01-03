<?php
/**
 * Modelo de Unidad de Medida - PDO/SQLite
 * Sistema de Facturación
 */
include_once(__DIR__ . '/../config/config.php');

class UnidadMedida
{
    private $db;

    public function __construct()
    {
        $conexion = new ClaseConectar();
        $this->db = $conexion->ProcedimientoParaConectar();
    }

    public function todos()
    {
        $stmt = $this->db->query("SELECT * FROM Unidad_Medida");
        return $stmt->fetchAll();
    }

    public function uno($idUnidad)
    {
        $stmt = $this->db->prepare("SELECT * FROM Unidad_Medida WHERE idUnidad_Medida = :id");
        $stmt->execute([':id' => $idUnidad]);
        return $stmt->fetch();
    }

    public function insertar($Detalle, $Tipo)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO Unidad_Medida (Detalle, Tipo) VALUES (:detalle, :tipo)");
            $result = $stmt->execute([
                ':detalle' => $Detalle,
                ':tipo' => $Tipo
            ]);
            return $result ? $this->db->lastInsertId() : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizar($idUnidad, $Detalle, $Tipo)
    {
        try {
            $stmt = $this->db->prepare("UPDATE Unidad_Medida SET Detalle = :detalle, Tipo = :tipo WHERE idUnidad_Medida = :id");
            $result = $stmt->execute([
                ':id' => $idUnidad,
                ':detalle' => $Detalle,
                ':tipo' => $Tipo
            ]);
            return $result ? $idUnidad : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function eliminar($idUnidad)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM Unidad_Medida WHERE idUnidad_Medida = :id");
            return $stmt->execute([':id' => $idUnidad]);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
