<?php
/**
 * Modelo de Factura - PDO/SQLite
 * Sistema de Facturación
 */
include_once(__DIR__ . '/../config/config.php');

class Factura
{
    private $db;

    public function __construct()
    {
        $conexion = new ClaseConectar();
        $this->db = $conexion->ProcedimientoParaConectar();
    }

    public function todos()
    {
        $sql = "SELECT f.idFactura, f.Fecha, f.Sub_total, f.Sub_total_iva, f.Valor_IVA,
                       (f.Sub_total + f.Sub_total_iva) as Total,
                       c.Nombres as Cliente, c.Cedula
                FROM Factura f
                INNER JOIN Clientes c ON f.Clientes_idClientes = c.idClientes
                ORDER BY f.idFactura DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function uno($idFactura)
    {
        $stmt = $this->db->prepare("SELECT f.*, c.* FROM Factura f 
                                    INNER JOIN Clientes c ON f.Clientes_idClientes = c.idClientes 
                                    WHERE f.idFactura = :id");
        $stmt->execute([':id' => $idFactura]);
        return $stmt->fetch();
    }

    public function detalleFactura($idFactura)
    {
        $stmt = $this->db->prepare("SELECT df.*, p.Nombre_Producto, p.Codigo_Barras
                                    FROM Detalle_Factura df
                                    INNER JOIN Kardex k ON df.Kardex_idKardex = k.idKardex
                                    INNER JOIN Productos p ON k.Productos_idProductos = p.idProductos
                                    WHERE df.Factura_idFactura = :id");
        $stmt->execute([':id' => $idFactura]);
        return $stmt->fetchAll();
    }

    public function insertar($Fecha, $Sub_total, $Sub_total_iva, $Valor_IVA, $Clientes_idClientes)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO Factura (Fecha, Sub_total, Sub_total_iva, Valor_IVA, Clientes_idClientes) VALUES (:fecha, :subtotal, :subtotal_iva, :valor_iva, :cliente)");
            $result = $stmt->execute([
                ':fecha' => $Fecha,
                ':subtotal' => $Sub_total,
                ':subtotal_iva' => $Sub_total_iva,
                ':valor_iva' => $Valor_IVA,
                ':cliente' => $Clientes_idClientes
            ]);
            return $result ? $this->db->lastInsertId() : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function insertarDetalle($Factura_idFactura, $Kardex_idKardex, $Cantidad, $Precio_Unitario, $Sub_Total_item)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO Detalle_Factura (Cantidad, Factura_idFactura, Kardex_idKardex, Precio_Unitario, Sub_Total_item) VALUES (:cantidad, :factura, :kardex, :precio, :subtotal)");
            return $stmt->execute([
                ':cantidad' => $Cantidad,
                ':factura' => $Factura_idFactura,
                ':kardex' => $Kardex_idKardex,
                ':precio' => $Precio_Unitario,
                ':subtotal' => $Sub_Total_item
            ]);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizar($idFactura, $Fecha, $Sub_total, $Sub_total_iva, $Valor_IVA, $Clientes_idClientes)
    {
        try {
            $stmt = $this->db->prepare("UPDATE Factura SET Fecha = :fecha, Sub_total = :subtotal, Sub_total_iva = :subtotal_iva, Valor_IVA = :valor_iva, Clientes_idClientes = :cliente WHERE idFactura = :id");
            $result = $stmt->execute([
                ':id' => $idFactura,
                ':fecha' => $Fecha,
                ':subtotal' => $Sub_total,
                ':subtotal_iva' => $Sub_total_iva,
                ':valor_iva' => $Valor_IVA,
                ':cliente' => $Clientes_idClientes
            ]);
            return $result ? $idFactura : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function eliminar($idFactura)
    {
        try {
            $this->db->beginTransaction();
            
            // Eliminar detalles
            $stmt = $this->db->prepare("DELETE FROM Detalle_Factura WHERE Factura_idFactura = :id");
            $stmt->execute([':id' => $idFactura]);
            
            // Eliminar factura
            $stmt = $this->db->prepare("DELETE FROM Factura WHERE idFactura = :id");
            $stmt->execute([':id' => $idFactura]);
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ['error' => $e->getMessage()];
        }
    }
}
