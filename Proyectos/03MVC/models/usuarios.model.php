<?php
include_once(__DIR__ . '/../config/config.php');

class UsuariosModel
{
    private $db;

    public function __construct()
    {
        $conexion = new ClaseConectar();
        $this->db = $conexion->ProcedimientoParaConectar();
    }

    public function todos()
    {
        $stmt = $this->db->query("SELECT * FROM Usuarios");
        return $stmt->fetchAll();
    }

    public function uno($idUsuarios)
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuarios WHERE idUsuarios = :id");
        $stmt->execute([':id' => $idUsuarios]);
        return $stmt->fetch();
    }

    public function insertar($Nombre_Usuario, $Contrasenia, $Estado, $Roles_idRoles)
    {
        $stmt = $this->db->prepare("INSERT INTO Usuarios (Nombre_Usuario, Contrasenia, Estado, Roles_idRoles) VALUES (:nombre, :pass, :estado, :rol)");
        return $stmt->execute([
            ':nombre' => $Nombre_Usuario,
            ':pass' => $Contrasenia,
            ':estado' => $Estado,
            ':rol' => $Roles_idRoles
        ]);
    }

    public function actualizar($idUsuarios, $Nombre_Usuario, $Contrasenia, $Estado, $Roles_idRoles)
    {
        $stmt = $this->db->prepare("UPDATE Usuarios SET Nombre_Usuario = :nombre, Contrasenia = :pass, Estado = :estado, Roles_idRoles = :rol WHERE idUsuarios = :id");
        return $stmt->execute([
            ':id' => $idUsuarios,
            ':nombre' => $Nombre_Usuario,
            ':pass' => $Contrasenia,
            ':estado' => $Estado,
            ':rol' => $Roles_idRoles
        ]);
    }

    public function eliminar($idUsuarios)
    {
        $stmt = $this->db->prepare("DELETE FROM Usuarios WHERE idUsuarios = :id");
        return $stmt->execute([':id' => $idUsuarios]);
    }

    public function login($Nombre_Usuario, $Contrasenia)
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuarios WHERE Nombre_Usuario = :nombre AND Estado = 1");
        $stmt->execute([':nombre' => $Nombre_Usuario]);
        $usuario = $stmt->fetch();
        
        if ($usuario && $Contrasenia === $usuario['Contrasenia']) {
            return $usuario;
        }
        return false;
    }
}
