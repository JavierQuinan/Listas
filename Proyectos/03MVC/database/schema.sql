-- Schema SQLite para Sistema de Facturación
-- Compatible con SQLite 3

PRAGMA foreign_keys = ON;

-- Tabla Proveedores
CREATE TABLE IF NOT EXISTS Proveedores (
    idProveedores INTEGER PRIMARY KEY AUTOINCREMENT,
    Nombre_Empresa VARCHAR(45) NOT NULL,
    Direccion TEXT,
    Telefono VARCHAR(17) NOT NULL,
    Contacto_Empresa VARCHAR(45) NOT NULL,
    Telefono_Contacto VARCHAR(17) NOT NULL
);

-- Tabla Productos
CREATE TABLE IF NOT EXISTS Productos (
    idProductos INTEGER PRIMARY KEY AUTOINCREMENT,
    Codigo_Barras TEXT,
    Nombre_Producto TEXT NOT NULL,
    Graba_IVA INTEGER NOT NULL DEFAULT 1
);

-- Tabla Unidad_Medida
CREATE TABLE IF NOT EXISTS Unidad_Medida (
    idUnidad_Medida INTEGER PRIMARY KEY AUTOINCREMENT,
    Detalle TEXT,
    Tipo INTEGER DEFAULT 0
);

-- Tabla IVA
CREATE TABLE IF NOT EXISTS IVA (
    idIVA INTEGER PRIMARY KEY AUTOINCREMENT,
    Detalle VARCHAR(45) NOT NULL,
    Estado INTEGER NOT NULL DEFAULT 1,
    Valor INTEGER
);

-- Tabla Kardex
CREATE TABLE IF NOT EXISTS Kardex (
    idKardex INTEGER PRIMARY KEY AUTOINCREMENT,
    Estado INTEGER NOT NULL DEFAULT 1,
    Fecha_Transaccion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Cantidad VARCHAR(45) NOT NULL,
    Valor_Compra DECIMAL(10,2) NOT NULL,
    Valor_Venta DECIMAL(10,2) NOT NULL,
    Unidad_Medida_idUnidad_Medida INTEGER NOT NULL,
    Unidad_Medida_idUnidad_Medida1 INTEGER NOT NULL,
    Unidad_Medida_idUnidad_Medida2 INTEGER NOT NULL,
    Valor_Ganancia DECIMAL(10,2),
    IVA INTEGER NOT NULL,
    IVA_idIVA INTEGER NOT NULL,
    Proveedores_idProveedores INTEGER NOT NULL,
    Productos_idProductos INTEGER NOT NULL,
    Tipo_Transaccion INTEGER NOT NULL,
    FOREIGN KEY (Unidad_Medida_idUnidad_Medida) REFERENCES Unidad_Medida(idUnidad_Medida),
    FOREIGN KEY (Unidad_Medida_idUnidad_Medida1) REFERENCES Unidad_Medida(idUnidad_Medida),
    FOREIGN KEY (Unidad_Medida_idUnidad_Medida2) REFERENCES Unidad_Medida(idUnidad_Medida),
    FOREIGN KEY (IVA_idIVA) REFERENCES IVA(idIVA),
    FOREIGN KEY (Proveedores_idProveedores) REFERENCES Proveedores(idProveedores),
    FOREIGN KEY (Productos_idProductos) REFERENCES Productos(idProductos)
);

-- Tabla Clientes
CREATE TABLE IF NOT EXISTS Clientes (
    idClientes INTEGER PRIMARY KEY AUTOINCREMENT,
    Nombres TEXT NOT NULL,
    Direccion TEXT NOT NULL,
    Telefono VARCHAR(45) NOT NULL,
    Cedula VARCHAR(13) NOT NULL,
    Correo TEXT NOT NULL
);

-- Tabla Roles
CREATE TABLE IF NOT EXISTS Roles (
    idRoles INTEGER PRIMARY KEY AUTOINCREMENT,
    Detalle VARCHAR(45) NOT NULL
);

-- Tabla Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    idUsuarios INTEGER PRIMARY KEY AUTOINCREMENT,
    Nombre_Usuario VARCHAR(45) NOT NULL,
    Contrasenia VARCHAR(255) NOT NULL,
    Estado INTEGER NOT NULL DEFAULT 1,
    Roles_idRoles INTEGER NOT NULL,
    FOREIGN KEY (Roles_idRoles) REFERENCES Roles(idRoles)
);

-- Tabla Factura
CREATE TABLE IF NOT EXISTS Factura (
    idFactura INTEGER PRIMARY KEY AUTOINCREMENT,
    Fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Sub_total DECIMAL(10,2) NOT NULL,
    Sub_total_iva DECIMAL(10,2) NOT NULL,
    Valor_IVA DECIMAL(10,2) NOT NULL,
    Clientes_idClientes INTEGER NOT NULL,
    Usuarios_idUsuarios INTEGER,
    FOREIGN KEY (Clientes_idClientes) REFERENCES Clientes(idClientes),
    FOREIGN KEY (Usuarios_idUsuarios) REFERENCES Usuarios(idUsuarios)
);

-- Tabla Detalle_Factura
CREATE TABLE IF NOT EXISTS Detalle_Factura (
    idDetalle_Factura INTEGER PRIMARY KEY AUTOINCREMENT,
    Cantidad VARCHAR(45) NOT NULL,
    Factura_idFactura INTEGER NOT NULL,
    Kardex_idKardex INTEGER NOT NULL,
    Precio_Unitario DECIMAL(10,2) NOT NULL,
    Sub_Total_item DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (Factura_idFactura) REFERENCES Factura(idFactura),
    FOREIGN KEY (Kardex_idKardex) REFERENCES Kardex(idKardex)
);

-- Índices para mejorar rendimiento
CREATE INDEX IF NOT EXISTS idx_kardex_producto ON Kardex(Productos_idProductos);
CREATE INDEX IF NOT EXISTS idx_kardex_proveedor ON Kardex(Proveedores_idProveedores);
CREATE INDEX IF NOT EXISTS idx_factura_cliente ON Factura(Clientes_idClientes);
CREATE INDEX IF NOT EXISTS idx_detalle_factura ON Detalle_Factura(Factura_idFactura);
CREATE INDEX IF NOT EXISTS idx_usuarios_rol ON Usuarios(Roles_idRoles);
