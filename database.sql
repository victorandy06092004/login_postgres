-- Borrar tablas si existen
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS rol;

-- Crear tabla de roles
CREATE TABLE rol (
    id_rol SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Crear tabla de usuarios con FK hacia rol
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    gmail VARCHAR(150) UNIQUE NOT NULL,
    contrasena TEXT NOT NULL,
    estado BOOLEAN DEFAULT TRUE,
    id_rol INT NOT NULL,
    CONSTRAINT fk_rol FOREIGN KEY (id_rol) REFERENCES rol(id_rol)
);

-- Insertar roles
INSERT INTO rol (nombre) VALUES 
('Admin'),
('Supervisor'),
('Operario');

-- Insertar usuarios con relación a rol
INSERT INTO usuarios (nombre, gmail, contrasena, estado, id_rol) VALUES
('Juan Perez', 'juan.perez@empresa.com', 'Juan1234', TRUE, 1), -- Admin
('Maria Lopez', 'maria.lopez@empresa.com', 'Maria456', TRUE, 2), -- Supervisor
('Carlos Diaz', 'carlos.diaz@empresa.com', 'Carlos789', TRUE, 3); -- Operario