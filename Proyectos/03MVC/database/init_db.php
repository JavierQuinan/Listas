<?php
/**
 * Script de inicialización de la base de datos SQLite
 * Ejecutar: php init_db.php
 */

$dbPath = __DIR__ . '/facturacion.db';
$schemaPath = __DIR__ . '/schema.sql';
$seedPath = __DIR__ . '/seed.sql';

echo "=== Inicializando Base de Datos SQLite ===\n\n";

// Verificar si ya existe la base de datos
$dbExists = file_exists($dbPath);

if ($dbExists) {
    echo "Advertencia: La base de datos ya existe.\n";
    echo "¿Desea reinicializarla? (s/n): ";
    
    // Si se ejecuta desde línea de comandos, leer entrada
    if (php_sapi_name() === 'cli') {
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        if (trim($line) !== 's' && trim($line) !== 'S') {
            echo "Operación cancelada.\n";
            exit(0);
        }
        fclose($handle);
        unlink($dbPath);
    } else {
        // Si se ejecuta desde web, reinicializar directamente
        unlink($dbPath);
    }
}

try {
    // Crear conexión SQLite
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "1. Conexión establecida correctamente.\n";
    
    // Habilitar foreign keys
    $db->exec('PRAGMA foreign_keys = ON');
    
    // Ejecutar schema
    if (file_exists($schemaPath)) {
        $schema = file_get_contents($schemaPath);
        $db->exec($schema);
        echo "2. Schema creado correctamente.\n";
    } else {
        throw new Exception("Archivo schema.sql no encontrado.");
    }
    
    // Ejecutar seed
    if (file_exists($seedPath)) {
        $seed = file_get_contents($seedPath);
        $db->exec($seed);
        echo "3. Datos iniciales insertados correctamente.\n";
    } else {
        echo "3. Archivo seed.sql no encontrado (opcional).\n";
    }
    
    // Verificar tablas creadas
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);
    
    echo "\n=== Tablas creadas ===\n";
    foreach ($tables as $table) {
        if ($table !== 'sqlite_sequence') {
            $count = $db->query("SELECT COUNT(*) FROM $table")->fetchColumn();
            echo "- $table ($count registros)\n";
        }
    }
    
    echo "\n=== Base de datos inicializada exitosamente ===\n";
    echo "Ubicación: $dbPath\n";
    
} catch (PDOException $e) {
    echo "Error de base de datos: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
