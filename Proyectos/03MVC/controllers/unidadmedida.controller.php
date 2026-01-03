<?php
/**
 * Controlador de Unidad de Medida - PDO/SQLite
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

require_once('../models/unidadmedida.model.php');

$unidad = new UnidadMedida();
$op = isset($_GET["op"]) ? $_GET["op"] : '';

switch ($op) {
    case 'todos':
        $datos = $unidad->todos();
        echo json_encode($datos ?: []);
        break;

    case 'uno':
        if (!isset($_POST["idUnidad"]) && !isset($_POST["idUnidad_Medida"])) {
            echo json_encode(["error" => "ID de unidad de medida no especificado."]);
            exit();
        }
        $idUnidad = isset($_POST["idUnidad"]) ? intval($_POST["idUnidad"]) : intval($_POST["idUnidad_Medida"]);
        $datos = $unidad->uno($idUnidad);
        echo json_encode($datos ?: null);
        break;

    case 'insertar':
        if (!isset($_POST["Detalle"]) && !isset($_POST["Descripcion"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $Detalle = isset($_POST["Detalle"]) ? trim($_POST["Detalle"]) : trim($_POST["Descripcion"]);
        $Tipo = isset($_POST["Tipo"]) ? trim($_POST["Tipo"]) : '';
        
        $datos = $unidad->insertar($Detalle, $Tipo);
        echo json_encode($datos);
        break;

    case 'actualizar':
        if (!isset($_POST["idUnidad"]) && !isset($_POST["idUnidad_Medida"])) {
            echo json_encode(["error" => "ID de unidad de medida no especificado."]);
            exit();
        }
        if (!isset($_POST["Detalle"]) && !isset($_POST["Descripcion"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $idUnidad = isset($_POST["idUnidad"]) ? intval($_POST["idUnidad"]) : intval($_POST["idUnidad_Medida"]);
        $Detalle = isset($_POST["Detalle"]) ? trim($_POST["Detalle"]) : trim($_POST["Descripcion"]);
        $Tipo = isset($_POST["Tipo"]) ? trim($_POST["Tipo"]) : '';
        
        $datos = $unidad->actualizar($idUnidad, $Detalle, $Tipo);
        echo json_encode($datos);
        break;

    case 'eliminar':
        if (!isset($_POST["idUnidad"]) && !isset($_POST["idUnidad_Medida"])) {
            echo json_encode(["error" => "ID de unidad de medida no especificado."]);
            exit();
        }
        $idUnidad = isset($_POST["idUnidad"]) ? intval($_POST["idUnidad"]) : intval($_POST["idUnidad_Medida"]);
        $datos = $unidad->eliminar($idUnidad);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Operación no válida."]);
        break;
}
