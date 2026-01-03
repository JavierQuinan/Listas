<?php
/**
 * Controlador de IVA - PDO/SQLite
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

require_once('../models/iva.model.php');

$iva = new IVA();
$op = isset($_GET["op"]) ? $_GET["op"] : (isset($_GET["OP"]) ? $_GET["OP"] : '');

switch (strtolower($op)) {
    case 'todos':
        $datos = $iva->todos();
        echo json_encode($datos ?: []);
        break;

    case 'todosincluidos':
        $datos = $iva->todosIncluidos();
        echo json_encode($datos ?: []);
        break;

    case 'uno':
        if (!isset($_POST["idIVA"])) {
            echo json_encode(["error" => "ID de IVA no especificado."]);
            exit();
        }
        $idIVA = intval($_POST["idIVA"]);
        $datos = $iva->uno($idIVA);
        echo json_encode($datos ?: null);
        break;

    case 'activo':
        $datos = $iva->activo();
        echo json_encode($datos ?: null);
        break;

    case 'insertar':
        if (!isset($_POST["Detalle"]) || !isset($_POST["Valor"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $Detalle = trim($_POST["Detalle"]);
        $Estado = isset($_POST["Estado"]) ? intval($_POST["Estado"]) : 1;
        $Valor = floatval($_POST["Valor"]);
        
        $datos = $iva->insertar($Detalle, $Estado, $Valor);
        echo json_encode($datos);
        break;

    case 'actualizar':
        if (!isset($_POST["idIVA"]) || !isset($_POST["Detalle"]) || !isset($_POST["Valor"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $idIVA = intval($_POST["idIVA"]);
        $Detalle = trim($_POST["Detalle"]);
        $Estado = isset($_POST["Estado"]) ? intval($_POST["Estado"]) : 1;
        $Valor = floatval($_POST["Valor"]);
        
        $datos = $iva->actualizar($idIVA, $Detalle, $Estado, $Valor);
        echo json_encode($datos);
        break;

    case 'eliminar':
        if (!isset($_POST["idIVA"])) {
            echo json_encode(["error" => "ID de IVA no especificado."]);
            exit();
        }
        $idIVA = intval($_POST["idIVA"]);
        $datos = $iva->eliminar($idIVA);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Operación no válida."]);
        break;
}
