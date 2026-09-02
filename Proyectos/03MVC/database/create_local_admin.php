<?php
/**
 * Crea o actualiza un usuario administrador local sin versionar contraseñas.
 *
 * Uso:
 *   DEMO_ADMIN_PASSWORD='una-clave-local-segura' php create_local_admin.php
 *
 * Variables opcionales:
 *   DEMO_ADMIN_USERNAME (default: admin)
 */

require_once(__DIR__ . '/../config/config.php');

$password = getenv('DEMO_ADMIN_PASSWORD');
$username = getenv('DEMO_ADMIN_USERNAME');

if ($username === false || trim($username) === '') {
    $username = 'admin';
}

$username = trim($username);

if ($password === false || strlen($password) < 12) {
    fwrite(STDERR, "DEMO_ADMIN_PASSWORD es obligatoria y debe tener al menos 12 caracteres.\n");
    exit(1);
}

if ($username === '') {
    fwrite(STDERR, "DEMO_ADMIN_USERNAME no puede estar vacío.\n");
    exit(1);
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
if ($passwordHash === false) {
    fwrite(STDERR, "No fue posible generar el hash de la contraseña.\n");
    exit(1);
}

$conexion = new ClaseConectar();
$db = $conexion->ProcedimientoParaConectar();

$roleId = $db->query("SELECT idRoles FROM Roles WHERE Detalle = 'Administrador' LIMIT 1")->fetchColumn();
if ($roleId === false) {
    fwrite(STDERR, "No existe el rol Administrador. Ejecute init_db.php primero.\n");
    exit(1);
}

$stmt = $db->prepare("SELECT idUsuarios FROM Usuarios WHERE Nombre_Usuario = :nombre LIMIT 1");
$stmt->execute([':nombre' => $username]);
$existingId = $stmt->fetchColumn();

if ($existingId !== false) {
    $stmt = $db->prepare(
        "UPDATE Usuarios SET Contrasenia = :pass, Estado = 1, Roles_idRoles = :rol WHERE idUsuarios = :id"
    );
    $stmt->execute([
        ':pass' => $passwordHash,
        ':rol' => (int) $roleId,
        ':id' => (int) $existingId,
    ]);
    echo "Usuario administrador local actualizado: {$username}\n";
    exit(0);
}

$stmt = $db->prepare(
    "INSERT INTO Usuarios (Nombre_Usuario, Contrasenia, Estado, Roles_idRoles) VALUES (:nombre, :pass, 1, :rol)"
);
$stmt->execute([
    ':nombre' => $username,
    ':pass' => $passwordHash,
    ':rol' => (int) $roleId,
]);

echo "Usuario administrador local creado: {$username}\n";
