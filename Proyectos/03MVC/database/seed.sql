-- Datos iniciales para el Sistema de Facturación

-- Roles de usuario
INSERT INTO Roles (Detalle) VALUES ('Administrador');
INSERT INTO Roles (Detalle) VALUES ('Vendedor');
INSERT INTO Roles (Detalle) VALUES ('Cajero');

-- No se versiona ninguna contraseña conocida.
-- Cree un usuario local con database/create_local_admin.php y una contraseña
-- proporcionada mediante la variable de entorno DEMO_ADMIN_PASSWORD.

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

-- Proveedores de ejemplo (datos sintéticos)
INSERT INTO Proveedores (Nombre_Empresa, Direccion, Telefono, Contacto_Empresa, Telefono_Contacto)
VALUES ('Distribuidora Demo Uno', 'Dirección de prueba 100', '0990000001', 'Contacto Demo', '0980000001');

INSERT INTO Proveedores (Nombre_Empresa, Direccion, Telefono, Contacto_Empresa, Telefono_Contacto)
VALUES ('Mayorista Demo Dos', 'Dirección de prueba 200', '0990000002', 'Contacto Demo', '0980000002');

-- Productos de ejemplo (datos sintéticos)
INSERT INTO Productos (Codigo_Barras, Nombre_Producto, Graba_IVA)
VALUES ('7500000000001', 'Producto Demo A', 1);

INSERT INTO Productos (Codigo_Barras, Nombre_Producto, Graba_IVA)
VALUES ('7500000000002', 'Producto Demo B', 1);

INSERT INTO Productos (Codigo_Barras, Nombre_Producto, Graba_IVA)
VALUES ('7500000000003', 'Producto Demo C', 0);

-- Clientes de ejemplo (datos sintéticos)
INSERT INTO Clientes (Nombres, Direccion, Telefono, Cedula, Correo)
VALUES ('Consumidor Demo', 'N/A', '0000000000', '9999999999', 'demo@example.test');

INSERT INTO Clientes (Nombres, Direccion, Telefono, Cedula, Correo)
VALUES ('Cliente de Prueba', 'Dirección de prueba 300', '0990000003', '0000000001', 'cliente@example.test');
