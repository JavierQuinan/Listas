<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json; charset=utf-8");

$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

include_once('../models/usuarios.model.php');
error_reporting(0);

$usuario = new UsuariosModel();

switch ($_GET["op"]) {
    case 'todos':
        $datos = $usuario->todos();
        echo json_encode($datos);
        break;

    case 'uno':
        if (!isset($_POST["idUsuarios"])) {
            echo json_encode(["error" => "Seleccione un usuario"]);
            exit();
        }
        $idUsuarios = $_POST["idUsuarios"];
        $datos = $usuario->uno($idUsuarios);
        echo json_encode($datos);
        break;

    case 'insertar':
        if (!isset($_POST["Nombre_Usuario"]) || !isset($_POST["Contrasenia"]) || !isset($_POST["Estado"]) || !isset($_POST["Roles_idRoles"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $nombreUsuario = $_POST["Nombre_Usuario"];
        $contrasenia = $_POST["Contrasenia"];
        $estado = intval($_POST["Estado"]);
        $rolesIdRoles = intval($_POST["Roles_idRoles"]);
        $datos = $usuario->insertar($nombreUsuario, $contrasenia, $estado, $rolesIdRoles);
        echo json_encode(["success" => $datos]);
        break;

    case 'actualizar':
        if (!isset($_POST["idUsuarios"]) || !isset($_POST["Nombre_Usuario"]) || !isset($_POST["Contrasenia"]) || !isset($_POST["Estado"]) || !isset($_POST["Roles_idRoles"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $idUsuarios = intval($_POST["idUsuarios"]);
        $nombreUsuario = $_POST["Nombre_Usuario"];
        $contrasenia = $_POST["Contrasenia"];
        $estado = intval($_POST["Estado"]);
        $rolesIdRoles = intval($_POST["Roles_idRoles"]);
        $datos = $usuario->actualizar($idUsuarios, $nombreUsuario, $contrasenia, $estado, $rolesIdRoles);
        echo json_encode(["success" => $datos]);
        break;

    case 'eliminar':
        if (!isset($_POST["idUsuarios"])) {
            echo json_encode(["error" => "User ID not specified."]);
            exit();
        }
        $idUsuarios = intval($_POST["idUsuarios"]);
        $datos = $usuario->eliminar($idUsuarios);
        echo json_encode(["success" => $datos]);
        break;

    case 'login':
        if (!isset($_POST["Nombre_Usuario"]) || !isset($_POST["Contrasenia"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $nombreUsuario = $_POST["Nombre_Usuario"];
        $contrasenia = $_POST["Contrasenia"];
        $result = $usuario->login($nombreUsuario, $contrasenia);
        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(["success" => false, "error" => "Credenciales inválidas"]);
        }
        break;

    default:
        echo json_encode(["error" => "Operación no válida"]);
        break;
}
