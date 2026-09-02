<?php
require_once(__DIR__ . '/../config/http.php');
applyJsonCors();

include_once('../models/usuarios.model.php');
error_reporting(0);

$usuario = new UsuariosModel();
$op = $_GET["op"] ?? '';

switch ($op) {
    case 'todos':
        $datos = $usuario->todos();
        echo json_encode($datos);
        break;

    case 'uno':
        if (!isset($_POST["idUsuarios"])) {
            echo json_encode(["error" => "Seleccione un usuario"]);
            exit();
        }
        $idUsuarios = intval($_POST["idUsuarios"]);
        $datos = $usuario->uno($idUsuarios);
        echo json_encode($datos);
        break;

    case 'insertar':
        if (!isset($_POST["Nombre_Usuario"], $_POST["Contrasenia"], $_POST["Estado"], $_POST["Roles_idRoles"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $nombreUsuario = trim($_POST["Nombre_Usuario"]);
        $contrasenia = (string) $_POST["Contrasenia"];
        $estado = intval($_POST["Estado"]);
        $rolesIdRoles = intval($_POST["Roles_idRoles"]);

        if ($nombreUsuario === '' || strlen($contrasenia) < 8) {
            echo json_encode(["error" => "Usuario requerido y contraseña mínima de 8 caracteres."]);
            exit();
        }

        $datos = $usuario->insertar($nombreUsuario, $contrasenia, $estado, $rolesIdRoles);
        echo json_encode(["success" => $datos]);
        break;

    case 'actualizar':
        if (!isset($_POST["idUsuarios"], $_POST["Nombre_Usuario"], $_POST["Contrasenia"], $_POST["Estado"], $_POST["Roles_idRoles"])) {
            echo json_encode(["error" => "Faltan parámetros requeridos."]);
            exit();
        }
        $idUsuarios = intval($_POST["idUsuarios"]);
        $nombreUsuario = trim($_POST["Nombre_Usuario"]);
        $contrasenia = (string) $_POST["Contrasenia"];
        $estado = intval($_POST["Estado"]);
        $rolesIdRoles = intval($_POST["Roles_idRoles"]);

        if ($idUsuarios <= 0 || $nombreUsuario === '' || strlen($contrasenia) < 8) {
            echo json_encode(["error" => "Datos de usuario inválidos o contraseña menor a 8 caracteres."]);
            exit();
        }

        $datos = $usuario->actualizar($idUsuarios, $nombreUsuario, $contrasenia, $estado, $rolesIdRoles);
        echo json_encode(["success" => $datos]);
        break;

    case 'eliminar':
        if (!isset($_POST["idUsuarios"])) {
            echo json_encode(["error" => "ID de usuario no especificado."]);
            exit();
        }
        $idUsuarios = intval($_POST["idUsuarios"]);
        $datos = $usuario->eliminar($idUsuarios);
        echo json_encode(["success" => $datos]);
        break;

    case 'login':
        if (!isset($_POST["Nombre_Usuario"], $_POST["Contrasenia"])) {
            echo json_encode(["error" => "Faltan credenciales."]);
            exit();
        }
        $nombreUsuario = trim($_POST["Nombre_Usuario"]);
        $contrasenia = (string) $_POST["Contrasenia"];
        $result = $usuario->login($nombreUsuario, $contrasenia);
        if ($result) {
            echo json_encode($result);
        } else {
            http_response_code(401);
            echo json_encode(["success" => false, "error" => "Credenciales inválidas"]);
        }
        break;

    default:
        echo json_encode(["error" => "Operación no válida"]);
        break;
}
