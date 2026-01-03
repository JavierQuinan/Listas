<?php
/**
 * Modelo de Productos - PDO/SQLite
 * Sistema de Facturación
 */
include_once(__DIR__ . '/../config/config.php');

class Producto
{
    private $db;

    public function __construct()
    {
        $conexion = new ClaseConectar();
        $this->db = $conexion->ProcedimientoParaConectar();
    }

    public function todos()
    {
        $sql = "SELECT p.idProductos, p.Codigo_Barras, p.Nombre_Producto, p.Graba_IVA,
                       k.idKardex, k.Cantidad, k.Valor_Compra, k.Valor_Venta, k.Fecha_Transaccion,
                       u.Detalle as Unidad_Medida, i.Detalle as IVA_Detalle, i.Valor as IVA_Valor,
                       pr.Nombre_Empresa as Proveedor
                FROM Productos p
                LEFT JOIN Kardex k ON p.idProductos = k.Productos_idProductos AND k.Estado = 1
                LEFT JOIN Unidad_Medida u ON k.Unidad_Medida_idUnidad_Medida = u.idUnidad_Medida
                LEFT JOIN IVA i ON k.IVA_idIVA = i.idIVA
                LEFT JOIN Proveedores pr ON k.Proveedores_idProveedores = pr.idProveedores
                ORDER BY p.idProductos DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function todosSimple()
    {
        $stmt = $this->db->query("SELECT * FROM Productos");
        return $stmt->fetchAll();
    }

    public function uno($idProductos)
    {
        $stmt = $this->db->prepare("SELECT p.*, k.*, u.Detalle as Unidad_Medida, i.Detalle as IVA_Detalle
                                    FROM Productos p
                                    LEFT JOIN Kardex k ON p.idProductos = k.Productos_idProductos
                                    LEFT JOIN Unidad_Medida u ON k.Unidad_Medida_idUnidad_Medida = u.idUnidad_Medida
                                    LEFT JOIN IVA i ON k.IVA_idIVA = i.idIVA
                                    WHERE p.idProductos = :id");
        $stmt->execute([':id' => $idProductos]);
        return $stmt->fetch();
    }

    public function insertar($Codigo_Barras, $Nombre_Producto, $Graba_IVA, $Unidad_Medida_id, $IVA_id, $Cantidad, $Valor_Compra, $Valor_Venta, $Proveedor_id)
    {
        try {
            $this->db->beginTransaction();
            
            // Insertar producto
            $stmt = $this->db->prepare("INSERT INTO Productos (Codigo_Barras, Nombre_Producto, Graba_IVA) VALUES (:codigo, :nombre, :iva)");
            $stmt->execute([
                ':codigo' => $Codigo_Barras,
                ':nombre' => $Nombre_Producto,
                ':iva' => $Graba_IVA
            ]);
            $productoId = $this->db->lastInsertId();
            
            // Insertar Kardex
            $stmt = $this->db->prepare("INSERT INTO Kardex (Estado, Fecha_Transaccion, Cantidad, Valor_Compra, Valor_Venta, Unidad_Medida_idUnidad_Medida, Unidad_Medida_idUnidad_Medida1, Unidad_Medida_idUnidad_Medida2, IVA, IVA_idIVA, Proveedores_idProveedores, Productos_idProductos, Tipo_Transaccion) VALUES (1, datetime('now'), :cantidad, :compra, :venta, :um, :um, :um, :iva_val, :iva_id, :prov, :prod, 1)");
            $stmt->execute([
                ':cantidad' => $Cantidad,
                ':compra' => $Valor_Compra,
                ':venta' => $Valor_Venta,
                ':um' => $Unidad_Medida_id,
                ':iva_val' => $IVA_id,
                ':iva_id' => $IVA_id,
                ':prov' => $Proveedor_id,
                ':prod' => $productoId
            ]);
            
            $this->db->commit();
            return $productoId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    public function actualizar($idProductos, $Codigo_Barras, $Nombre_Producto, $Graba_IVA)
    {
        try {
            $stmt = $this->db->prepare("UPDATE Productos SET Codigo_Barras = :codigo, Nombre_Producto = :nombre, Graba_IVA = :iva WHERE idProductos = :id");
            $result = $stmt->execute([
                ':id' => $idProductos,
                ':codigo' => $Codigo_Barras,
                ':nombre' => $Nombre_Producto,
                ':iva' => $Graba_IVA
            ]);
            return $result ? $idProductos : false;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function eliminar($idProductos)
    {
        try {
            $this->db->beginTransaction();
            
            // Eliminar kardex asociado
            $stmt = $this->db->prepare("DELETE FROM Kardex WHERE Productos_idProductos = :id");
            $stmt->execute([':id' => $idProductos]);
            
            // Eliminar producto
            $stmt = $this->db->prepare("DELETE FROM Productos WHERE idProductos = :id");
            $stmt->execute([':id' => $idProductos]);
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ['error' => $e->getMessage()];
        }
    }
}
