-- Datos iniciales para el Sistema de Facturación

-- Roles de usuario
INSERT INTO Roles (Detalle) VALUES ('Administrador');
INSERT INTO Roles (Detalle) VALUES ('Vendedor');
INSERT INTO Roles (Detalle) VALUES ('Cajero');

-- Usuario administrador por defecto (password: admin123)
INSERT INTO Usuarios (Nombre_Usuario, Contrasenia, Estado, Roles_idRoles) 
VALUES ('admin', 'admin123', 1, 1);

-- Configuración de IVA
INSERT INTO IVA (Detalle, Estado, Valor) VALUES ('0%', 1, 0);
INSERT INTO IVA (Detalle, Estado, Valor) VALUES ('12%', 1, 12);
INSERT INTO IVA (Detalle, Estado, Valor) VALUES ('15%', 1, 15);

-- Unidades de Medida
INSERT INTO Unidad_Medida (Detalle, Tipo) VALUES ('Unidad', 0);
INSERT INTO Unidad_Medida (Detalle, Tipo) VALUES ('Docena', 0);
INSERT INTO Unidad_Medida (Detalle, Tipo) VALUES ('Caja', 0);
INSERT INTO Unidad_Medida (Detalle, Tipo) VALUES ('Kilogramo', 1);
INSERT INTO Unidad_Medida (Detalle, Tipo) VALUES ('Gramo', 1);
INSERT INTO Unidad_Medida (Detalle, Tipo) VALUES ('Litro', 1);
INSERT INTO Unidad_Medida (Detalle, Tipo) VALUES ('Mililitro', 1);

-- Proveedores de ejemplo
INSERT INTO Proveedores (Nombre_Empresa, Direccion, Telefono, Contacto_Empresa, Telefono_Contacto) 
VALUES ('Distribuidora ABC', 'Av. Principal 123', '0991234567', 'Juan Pérez', '0987654321');

INSERT INTO Proveedores (Nombre_Empresa, Direccion, Telefono, Contacto_Empresa, Telefono_Contacto) 
VALUES ('Mayorista XYZ', 'Calle Comercio 456', '0992345678', 'María García', '0998765432');

-- Productos de ejemplo
INSERT INTO Productos (Codigo_Barras, Nombre_Producto, Graba_IVA) 
VALUES ('7501234567890', 'Arroz Premium 1kg', 1);

INSERT INTO Productos (Codigo_Barras, Nombre_Producto, Graba_IVA) 
VALUES ('7501234567891', 'Aceite Vegetal 1L', 1);

INSERT INTO Productos (Codigo_Barras, Nombre_Producto, Graba_IVA) 
VALUES ('7501234567892', 'Azúcar Refinada 1kg', 0);

-- Clientes de ejemplo
INSERT INTO Clientes (Nombres, Direccion, Telefono, Cedula, Correo) 
VALUES ('Consumidor Final', 'N/A', '0000000000', '9999999999', 'consumidor@final.com');

INSERT INTO Clientes (Nombres, Direccion, Telefono, Cedula, Correo) 
VALUES ('Carlos Rodríguez', 'Av. Los Álamos 789', '0993456789', '1234567890', 'carlos@email.com');
