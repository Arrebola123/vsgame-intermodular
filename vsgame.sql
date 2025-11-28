-- Crear base de datos
CREATE DATABASE IF NOT EXISTS vsgame;
USE vsgame;

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Cartas
CREATE TABLE IF NOT EXISTS cartas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    ataque INT NOT NULL,
    defensa INT NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Partidas (Resultados)
CREATE TABLE IF NOT EXISTS partidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    puntuacion INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de Configuración
CREATE TABLE IF NOT EXISTS configuracion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(50) NOT NULL UNIQUE,
    valor TEXT,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insertar cartas desde cards.zip
INSERT INTO cartas (nombre, ataque, defensa, imagen) VALUES
('Carta 1', 50, 40, '1_card.jpg'),
('Carta 2', 55, 42, '2_card.jpg'),
('Carta 3', 60, 45, '3_card.jpg'),
('Carta 4', 52, 38, '4_card.jpg'),
('Carta 5', 58, 44, '5_card.jpg'),
('Carta 6', 62, 48, '6_card.jpg'),
('Carta 7', 65, 50, '7_card.jpg'),
('Carta 8', 70, 52, '8_card.jpg'),
('Carta 9', 72, 54, '9_card.jpg'),
('Carta 10', 75, 55, '10_card.jpg'),
('Carta 11', 78, 60, '11_card.jpg'),
('Carta 12', 80, 62, '12_card.jpg'),
('Carta 13', 82, 64, '13_card.jpg'),
('Carta 14', 85, 66, '14_card.jpg'),
('Carta 15', 88, 70, '15_card.jpg'),
('Carta 16', 90, 72, '16_card.jpg'),
('Carta 17', 92, 74, '17_card.jpg'),
('Carta 18', 94, 76, '18_card.jpg'),
('Carta 19', 96, 78, '19_card.jpg'),
('Carta 20', 98, 80, '20_card.jpg'),
('Carta 21', 100, 82, '21_card.jpg'),
('Carta 22', 102, 84, '22_card.jpg'),
('Carta 23', 104, 86, '23_card.jpg'),
('Carta 24', 106, 88, '24_card.jpg'),
('Carta 25', 108, 90, '25_card.jpg'),
('Carta 26', 110, 92, '26_card.jpg'),
('Carta 27', 112, 94, '27_card.jpg'),
('Carta 28', 114, 96, '28_card.jpg'),
('Carta 29', 116, 98, '29_card.jpg'),
('Carta 30', 118, 100, '30_card.jpg');