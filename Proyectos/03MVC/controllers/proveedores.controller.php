<?php
/**
 * Controlador de Proveedores - PDO/SQLite
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

require_once('../models/proveedores.model.php');

$proveedores = new Proveedores();
$op = isset($_GET["op"]) ? $_GET["op"] : '';

switch ($op) {
    case 'todos':
        $datos = $proveedores->todos();
        echo json_encode($datos ?: []);
        break;

    case 'uno':
        if (!isset($_POST["idProveedores"])) {
            echo json_encode(["error" => "ID de proveedor no especificado."]);
            exit();
        }
        $idProveedores = intval($_POST["idProveedores"]);
        $datos = $proveedores->uno($idProveedores);
        echo json_encode($datos ?: null);
        break;

    case 'insertar':
        if (!isset($_POST["Nombre_Empresa"]) || !isset($_POST["Direccion"]) || !isset($_POST["Telefono"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $Nombre_Empresa = trim($_POST["Nombre_Empresa"]);
        $Direccion = trim($_POST["Direccion"]);
        $Telefono = trim($_POST["Telefono"]);
        $Contacto_Empresa = isset($_POST["Contacto_Empresa"]) ? trim($_POST["Contacto_Empresa"]) : '';
        $Telefono_Contacto = isset($_POST["Telefono_Contacto"]) ? trim($_POST["Telefono_Contacto"]) : (isset($_POST["Teleofno_Contacto"]) ? trim($_POST["Teleofno_Contacto"]) : '');
        $datos = $proveedores->insertar($Nombre_Empresa, $Direccion, $Telefono, $Contacto_Empresa, $Telefono_Contacto);
        echo json_encode($datos);
        break;

    case 'actualizar':
        if (!isset($_POST["idProveedores"]) || !isset($_POST["Nombre_Empresa"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $idProveedores = intval($_POST["idProveedores"]);
        $Nombre_Empresa = trim($_POST["Nombre_Empresa"]);
        $Direccion = isset($_POST["Direccion"]) ? trim($_POST["Direccion"]) : '';
        $Telefono = isset($_POST["Telefono"]) ? trim($_POST["Telefono"]) : '';
        $Contacto_Empresa = isset($_POST["Contacto_Empresa"]) ? trim($_POST["Contacto_Empresa"]) : '';
        $Telefono_Contacto = isset($_POST["Telefono_Contacto"]) ? trim($_POST["Telefono_Contacto"]) : (isset($_POST["Teleofno_Contacto"]) ? trim($_POST["Teleofno_Contacto"]) : '');
        $datos = $proveedores->actualizar($idProveedores, $Nombre_Empresa, $Direccion, $Telefono, $Contacto_Empresa, $Telefono_Contacto);
        echo json_encode($datos);
        break;

    case 'eliminar':
        if (!isset($_POST["idProveedores"])) {
            echo json_encode(["error" => "ID de proveedor no especificado."]);
            exit();
        }
        $idProveedores = intval($_POST["idProveedores"]);
        $datos = $proveedores->eliminar($idProveedores);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Operación no válida."]);
        break;
}
