-- 1. Usuarios
CREATE DATABASE IF NOT EXISTS lakobra;
use lakobra;
CREATE TABLE usuarios (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100) NOT NULL,
dni VARCHAR(20) UNIQUE NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
qr_token VARCHAR(100) UNIQUE NOT NULL,
direccion VARCHAR(255),
rol ENUM('admin','txandalari','socio') DEFAULT 'socio',
solicitud_txandalari TINYINT(1) DEFAULT 0
) ENGINE=InnoDB;
-- 2. Eventos


CREATE TABLE eventos (
id INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(150) NOT NULL,
fecha_evento DATE NOT NULL,
hora_inicio TIME,
aforo_max INT DEFAULT 120,
estado ENUM('pendiente','confirmado','cancelado') DEFAULT 'pendiente',
visible_publico TINYINT(1) DEFAULT 0
) ENGINE=InnoDB;
-- 3. Asistencias
CREATE TABLE asistencias (
id INT AUTO_INCREMENT PRIMARY KEY,
id_evento INT NOT NULL,
id_usuario INT NOT NULL,
fecha_hora_entrada DATETIME DEFAULT CURRENT_TIMESTAMP,
UNIQUE (id_evento, id_usuario),
FOREIGN KEY (id_evento) REFERENCES eventos(id) ON DELETE CASCADE,
FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;
-- 4. Solicitudes Artistas
CREATE TABLE solicitudes_artistas (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre_artista VARCHAR(150) NOT NULL,
email_contacto VARCHAR(100) NOT NULL,
descripcion TEXT,
fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,
estado ENUM('pendiente','aceptada','rechazada') DEFAULT 'pendiente'
) ENGINE=InnoDB;
-- 5. Turnos
CREATE TABLE turnos (
id INT AUTO_INCREMENT PRIMARY KEY,
id_evento INT NOT NULL,
id_usuario INT NOT NULL,
puesto ENUM('barra','puerta','limpieza','otros') NOT NULL,
UNIQUE (id_evento, id_usuario, puesto),
FOREIGN KEY (id_evento) REFERENCES eventos(id) ON DELETE CASCADE,
FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;


INSERT INTO usuarios (nombre, dni, email, password, qr_token, direccion, rol, solicitud_txandalari) VALUES
('Iker Martinez', '12345678A', 'iker@email.com', '$2y$10$wH8K7j9XQ9k3kVnYl8QyOeWv8zKzQjvXy5Q7cZz3U9fT2YwQ7gK2K', 'QR001', 'Bilbao', 'admin', 0),
('Ane Lopez', '23456789B', 'ane@email.com', '$2y$10$kL9QvH3tR7Pz1YxM4fN5UeVb8sT6rWq2dF9gJ1hL0mN8pQ3sR2tUe', 'QR002', 'Barakaldo', 'socio', 1),
('Jon Garcia', '34567890C', 'jon@email.com', '$2y$10$Zx8Vb3nM5kL2pQ1wE9rT6yU7iO8aS4dF0gHjK2lP9oI7uY6tR5eWq', 'QR003', 'Getxo', 'txandalari', 0),
('Maite Etxeberria', '45678901D', 'maite@email.com', '$2y$10$Qw3E4rT5yU6iO7pA8sD9fG0hJ1kL2zXcVbN5mK8jH7gF6dS4aP0o', 'QR004', 'Santurtzi', 'socio', 0);

INSERT INTO eventos (titulo, fecha_evento, hora_inicio, aforo_max, estado, visible_publico) VALUES
('Concierto Rock', '2026-05-10', '20:00:00', 150, 'confirmado', 1),
('Festival Indie', '2026-06-15', '18:00:00', 200, 'pendiente', 1),
('Fiesta DJ', '2026-04-20', '23:00:00', 100, 'confirmado', 0);


INSERT INTO asistencias (id_evento, id_usuario, fecha_hora_entrada) VALUES
(1, 2, '2026-05-10 19:50:00'),
(1, 3, '2026-05-10 19:55:00'),
(2, 4, '2026-06-15 17:45:00');


INSERT INTO solicitudes_artistas (nombre_artista, email_contacto, descripcion, estado) VALUES
('DJ Basque', 'djbasque@email.com', 'Sesión de música electrónica', 'pendiente'),
('Rock Band X', 'rockx@email.com', 'Grupo de rock alternativo', 'aceptada'),
('Indie Waves', 'indie@email.com', 'Banda indie emergente', 'rechazada');


INSERT INTO turnos (id_evento, id_usuario, puesto) VALUES
(1, 3, 'barra'),
(1, 2, 'puerta'),
(2, 3, 'limpieza'),
(3, 4, 'otros');