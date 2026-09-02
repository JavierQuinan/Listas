<?php
/**
 * Smoke test reproducible para el flujo de autenticación local.
 * Requiere una base inicializada y un usuario creado con create_local_admin.php.
 */

require_once(__DIR__ . '/../models/usuarios.model.php');
require_once(__DIR__ . '/../config/config.php');

$username = getenv('DEMO_ADMIN_USERNAME');
$password = getenv('DEMO_ADMIN_PASSWORD');

if ($username === false || trim($username) === '') {
    $username = 'admin';
}

if ($password === false || $password === '') {
    fwrite(STDERR, "DEMO_ADMIN_PASSWORD es requerida para ejecutar auth_smoke.php.\n");
    exit(1);
}

function assertTrue($condition, $message)
{
    if (!$condition) {
        fwrite(STDERR, "FAIL: {$message}\n");
        exit(1);
    }

    echo "PASS: {$message}\n";
}

$model = new UsuariosModel();

$validLogin = $model->login($username, $password);
assertTrue(is_array($validLogin), 'credenciales válidas autentican');
assertTrue(!array_key_exists('Contrasenia', $validLogin), 'login no expone hash de contraseña');

$invalidLogin = $model->login($username, $password . '-incorrecta');
assertTrue($invalidLogin === false, 'credenciales inválidas son rechazadas');

$users = $model->todos();
assertTrue(is_array($users), 'listado de usuarios responde una colección');
foreach ($users as $user) {
    assertTrue(!array_key_exists('Contrasenia', $user), 'listado no expone hashes');
}

$user = $model->uno((int) $validLogin['idUsuarios']);
assertTrue(is_array($user), 'detalle de usuario puede recuperarse');
assertTrue(!array_key_exists('Contrasenia', $user), 'detalle no expone hash de contraseña');

$conexion = new ClaseConectar();
$db = $conexion->ProcedimientoParaConectar();
$stmt = $db->prepare("SELECT Contrasenia FROM Usuarios WHERE Nombre_Usuario = :nombre LIMIT 1");
$stmt->execute([':nombre' => $username]);
$storedHash = $stmt->fetchColumn();

assertTrue(is_string($storedHash) && $storedHash !== $password, 'contraseña no se almacena en texto plano');
assertTrue(password_verify($password, $storedHash), 'hash almacenado verifica la contraseña configurada');

echo "\nAuth smoke test: PASS\n";
