<?php
/**
 * Controlador de Facturas - PDO/SQLite
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

require_once('../models/factura.model.php');

$factura = new Factura();
$op = isset($_GET["op"]) ? $_GET["op"] : '';

switch ($op) {
    case 'todos':
        $datos = $factura->todos();
        echo json_encode($datos ?: []);
        break;

    case 'uno':
        if (!isset($_POST["idFactura"])) {
            echo json_encode(["error" => "ID de factura no especificado."]);
            exit();
        }
        $idFactura = intval($_POST["idFactura"]);
        $datos = $factura->uno($idFactura);
        echo json_encode($datos ?: null);
        break;

    case 'detalle':
        if (!isset($_POST["idFactura"])) {
            echo json_encode(["error" => "ID de factura no especificado."]);
            exit();
        }
        $idFactura = intval($_POST["idFactura"]);
        $datos = $factura->detalleFactura($idFactura);
        echo json_encode($datos ?: []);
        break;

    case 'insertar':
        if (!isset($_POST["Fecha"]) || !isset($_POST["Sub_total"]) || !isset($_POST["Clientes_idClientes"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $Fecha = trim($_POST["Fecha"]);
        $Sub_total = floatval($_POST["Sub_total"]);
        $Sub_total_iva = isset($_POST["Sub_total_iva"]) ? floatval($_POST["Sub_total_iva"]) : 0;
        $Valor_IVA = isset($_POST["Valor_IVA"]) ? floatval($_POST["Valor_IVA"]) : 0;
        $Clientes_idClientes = intval($_POST["Clientes_idClientes"]);
        
        $datos = $factura->insertar($Fecha, $Sub_total, $Sub_total_iva, $Valor_IVA, $Clientes_idClientes);
        echo json_encode($datos);
        break;

    case 'insertarDetalle':
        if (!isset($_POST["Factura_idFactura"]) || !isset($_POST["Kardex_idKardex"]) || !isset($_POST["Cantidad"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $Factura_idFactura = intval($_POST["Factura_idFactura"]);
        $Kardex_idKardex = intval($_POST["Kardex_idKardex"]);
        $Cantidad = floatval($_POST["Cantidad"]);
        $Precio_Unitario = isset($_POST["Precio_Unitario"]) ? floatval($_POST["Precio_Unitario"]) : 0;
        $Sub_Total_item = isset($_POST["Sub_Total_item"]) ? floatval($_POST["Sub_Total_item"]) : ($Cantidad * $Precio_Unitario);
        
        $datos = $factura->insertarDetalle($Factura_idFactura, $Kardex_idKardex, $Cantidad, $Precio_Unitario, $Sub_Total_item);
        echo json_encode($datos);
        break;

    case 'actualizar':
        if (!isset($_POST["idFactura"]) || !isset($_POST["Fecha"]) || !isset($_POST["Sub_total"]) || !isset($_POST["Clientes_idClientes"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $idFactura = intval($_POST["idFactura"]);
        $Fecha = trim($_POST["Fecha"]);
        $Sub_total = floatval($_POST["Sub_total"]);
        $Sub_total_iva = isset($_POST["Sub_total_iva"]) ? floatval($_POST["Sub_total_iva"]) : 0;
        $Valor_IVA = isset($_POST["Valor_IVA"]) ? floatval($_POST["Valor_IVA"]) : 0;
        $Clientes_idClientes = intval($_POST["Clientes_idClientes"]);
        
        $datos = $factura->actualizar($idFactura, $Fecha, $Sub_total, $Sub_total_iva, $Valor_IVA, $Clientes_idClientes);
        echo json_encode($datos);
        break;

    case 'eliminar':
        if (!isset($_POST["idFactura"])) {
            echo json_encode(["error" => "ID de factura no especificado."]);
            exit();
        }
        $idFactura = intval($_POST["idFactura"]);
        $datos = $factura->eliminar($idFactura);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Operación no válida."]);
        break;
}
