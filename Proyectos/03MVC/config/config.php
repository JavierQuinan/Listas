<?php
/**
 * Clase de conexión a base de datos SQLite
 * Sistema de Facturación
 */

class ClaseConectar
{
    private $dbPath;
    protected $conexion;

    public function __construct()
    {
        $this->dbPath = __DIR__ . '/../database/facturacion.db';
    }

    /**
     * Establece la conexión con la base de datos SQLite
     * @return PDO Conexión PDO a SQLite
     */
    public function ProcedimientoParaConectar()
    {
        try {
            // Verificar si el archivo de base de datos existe
            if (!file_exists($this->dbPath)) {
                throw new Exception("Base de datos no encontrada. Ejecute init_db.php primero.");
            }

            // Crear conexión PDO con SQLite
            $this->conexion = new PDO('sqlite:' . $this->dbPath);
            
            // Configurar opciones de PDO
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Habilitar foreign keys en SQLite
            $this->conexion->exec('PRAGMA foreign_keys = ON');

            return $this->conexion;

        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    /**
     * Cierra la conexión a la base de datos
     */
    public function cerrarConexion()
    {
        $this->conexion = null;
    }

    /**
     * Obtiene la ruta de la base de datos
     * @return string Ruta del archivo SQLite
     */
    public function getDbPath()
    {
        return $this->dbPath;
    }
}
