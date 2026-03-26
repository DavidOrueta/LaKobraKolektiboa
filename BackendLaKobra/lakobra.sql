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