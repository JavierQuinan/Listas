<?php
/**
 * Controlador de IVA - PDO/SQLite
 * Sistema de Facturación
 */
require_once(__DIR__ . '/../config/http.php');
applyJsonCors();

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
