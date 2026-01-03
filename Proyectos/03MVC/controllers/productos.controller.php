<?php
/**
 * Controlador de Productos - PDO/SQLite
 * Sistema de Facturación
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/productos.model.php');

$producto = new Producto();
$op = isset($_GET["op"]) ? $_GET["op"] : '';

switch ($op) {
    case 'todos':
        $datos = $producto->todos();
        echo json_encode($datos ?: []);
        break;

    case 'todosSimple':
        $datos = $producto->todosSimple();
        echo json_encode($datos ?: []);
        break;

    case 'uno':
        if (!isset($_POST["idProductos"])) {
            echo json_encode(["error" => "ID de producto no especificado."]);
            exit();
        }
        $idProductos = intval($_POST["idProductos"]);
        $datos = $producto->uno($idProductos);
        echo json_encode($datos ?: null);
        break;

    case 'insertar':
        if (!isset($_POST["Codigo_Barras"]) || !isset($_POST["Nombre_Producto"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $Codigo_Barras = trim($_POST["Codigo_Barras"]);
        $Nombre_Producto = trim($_POST["Nombre_Producto"]);
        $Graba_IVA = isset($_POST["Graba_IVA"]) ? intval($_POST["Graba_IVA"]) : 1;
        $Unidad_Medida_id = isset($_POST["Unidad_Medida_idUnidad_Medida"]) ? intval($_POST["Unidad_Medida_idUnidad_Medida"]) : 1;
        $IVA_id = isset($_POST["IVA_idIVA"]) ? intval($_POST["IVA_idIVA"]) : 1;
        $Cantidad = isset($_POST["Cantidad"]) ? floatval($_POST["Cantidad"]) : 0;
        $Valor_Compra = isset($_POST["Valor_Compra"]) ? floatval($_POST["Valor_Compra"]) : 0;
        $Valor_Venta = isset($_POST["Valor_Venta"]) ? floatval($_POST["Valor_Venta"]) : 0;
        $Proveedor_id = isset($_POST["Proveedores_idProveedores"]) ? intval($_POST["Proveedores_idProveedores"]) : 1;
        
        $datos = $producto->insertar($Codigo_Barras, $Nombre_Producto, $Graba_IVA, $Unidad_Medida_id, $IVA_id, $Cantidad, $Valor_Compra, $Valor_Venta, $Proveedor_id);
        echo json_encode($datos);
        break;

    case 'actualizar':
        if (!isset($_POST["idProductos"]) || !isset($_POST["Codigo_Barras"]) || !isset($_POST["Nombre_Producto"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $idProductos = intval($_POST["idProductos"]);
        $Codigo_Barras = trim($_POST["Codigo_Barras"]);
        $Nombre_Producto = trim($_POST["Nombre_Producto"]);
        $Graba_IVA = isset($_POST["Graba_IVA"]) ? intval($_POST["Graba_IVA"]) : 1;
        
        $datos = $producto->actualizar($idProductos, $Codigo_Barras, $Nombre_Producto, $Graba_IVA);
        echo json_encode($datos);
        break;

    case 'eliminar':
        if (!isset($_POST["idProductos"])) {
            echo json_encode(["error" => "ID de producto no especificado."]);
            exit();
        }
        $idProductos = intval($_POST["idProductos"]);
        $datos = $producto->eliminar($idProductos);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Operación no válida."]);
        break;
}
