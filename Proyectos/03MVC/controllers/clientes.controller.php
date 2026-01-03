<?php
/**
 * Controlador de Clientes - PDO/SQLite
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

require_once('../models/clientes.model.php');

$clientes = new Clientes();
$op = isset($_GET["op"]) ? $_GET["op"] : '';

switch ($op) {
    case 'buscar':
        $texto = isset($_POST["texto"]) ? $_POST["texto"] : '';
        $datos = $clientes->buscar($texto);
        echo json_encode($datos ?: []);
        break;

    case 'todos':
        $datos = $clientes->todos();
        echo json_encode($datos ?: []);
        break;

    case 'uno':
        if (!isset($_POST["idClientes"])) {
            echo json_encode(["error" => "ID de cliente no especificado."]);
            exit();
        }
        $idClientes = intval($_POST["idClientes"]);
        $datos = $clientes->uno($idClientes);
        echo json_encode($datos ?: null);
        break;

    case 'insertar':
        if (!isset($_POST["Nombres"]) || !isset($_POST["Direccion"]) || !isset($_POST["Telefono"]) || !isset($_POST["Cedula"]) || !isset($_POST["Correo"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $Nombres = trim($_POST["Nombres"]);
        $Direccion = trim($_POST["Direccion"]);
        $Telefono = trim($_POST["Telefono"]);
        $Cedula = trim($_POST["Cedula"]);
        $Correo = trim($_POST["Correo"]);
        $datos = $clientes->insertar($Nombres, $Direccion, $Telefono, $Cedula, $Correo);
        echo json_encode($datos);
        break;

    case 'actualizar':
        if (!isset($_POST["idClientes"]) || !isset($_POST["Nombres"]) || !isset($_POST["Direccion"]) || !isset($_POST["Telefono"]) || !isset($_POST["Cedula"]) || !isset($_POST["Correo"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $idClientes = intval($_POST["idClientes"]);
        $Nombres = trim($_POST["Nombres"]);
        $Direccion = trim($_POST["Direccion"]);
        $Telefono = trim($_POST["Telefono"]);
        $Cedula = trim($_POST["Cedula"]);
        $Correo = trim($_POST["Correo"]);
        $datos = $clientes->actualizar($idClientes, $Nombres, $Direccion, $Telefono, $Cedula, $Correo);
        echo json_encode($datos);
        break;

    case 'eliminar':
        if (!isset($_POST["idClientes"])) {
            echo json_encode(["error" => "ID de cliente no especificado."]);
            exit();
        }
        $idClientes = intval($_POST["idClientes"]);
        $datos = $clientes->eliminar($idClientes);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Operación no válida."]);
        break;
}
