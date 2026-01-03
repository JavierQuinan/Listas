<?php
/**
 * Script de prueba de conexión a la base de datos SQLite
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/config/config.php';

try {
    $conexion = new ClaseConectar();
    $db = $conexion->ProcedimientoParaConectar();
    
    // Obtener información de las tablas
    $tablas = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")
                 ->fetchAll(PDO::FETCH_COLUMN);
    
    $resultado = [
        'status' => 'success',
        'message' => 'Conexión exitosa a SQLite',
        'database' => 'facturacion.db',
        'tablas' => []
    ];
    
    foreach ($tablas as $tabla) {
        $count = $db->query("SELECT COUNT(*) FROM $tabla")->fetchColumn();
        $resultado['tablas'][$tabla] = (int)$count;
    }
    
    // Ejemplo: obtener productos
    $productos = $db->query("SELECT * FROM Productos")->fetchAll();
    $resultado['productos_ejemplo'] = $productos;
    
    echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
