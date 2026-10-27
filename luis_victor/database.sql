CREATE DATABASE IF NOT EXISTS luis_victor CHARACTER SET utf8mb4;
USE luis_victor;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Se borran para poder volver a importar este archivo sin problema
-- (los usuarios NO se borran)
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS productos;

CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  categoria VARCHAR(50) NOT NULL,
  marca VARCHAR(50) NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  precio DECIMAL(10,2) NOT NULL
);

CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  producto_id INT NOT NULL,
  cantidad INT NOT NULL,
  direccion TEXT NOT NULL,
  comentarios TEXT,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  FOREIGN KEY (producto_id) REFERENCES productos(id)
);

INSERT INTO productos (categoria, marca, nombre, precio) VALUES
('Bolsos y Accesorios', 'Luis Victor', 'Bolso Monograma', 15000.00),
('Bolsos y Accesorios', 'Luis Victor', 'Cartera Monograma', 6800.00),
('Bolsos y Accesorios', 'Luis Victor', 'Cinturón Dorado', 6500.00),
('Bolsos y Accesorios', 'Luis Victor', 'Lentes de Sol Victor', 8200.00),
('Bolsos y Accesorios', 'Luis Victor', 'Maleta de Viaje Clásica', 38000.00),
('Ropa', 'Luis Victor', 'Camisa de Seda Monograma', 9800.00),
('Ropa', 'Luis Victor', 'Chamarra Monograma', 24000.00),
('Ropa', 'Luis Victor', 'Pañuelo de Seda', 5200.00),
('Ropa', 'Luis Victor', 'Bufanda de Lana', 7400.00),
('Calzado', 'Luis Victor', 'Tenis Trainer Monograma', 21000.00),
('Calzado', 'Luis Victor', 'Mocasines de Piel', 17500.00),
('Calzado', 'Luis Victor', 'Botines Dorados', 19800.00),
('Cosméticos', 'Luis Victor', 'Perfume Elegante Victor', 4800.00),
('Cosméticos', 'Luis Victor', 'Labial Rojo Dorado', 1200.00),
('Cosméticos', 'Luis Victor', 'Crema Facial de Lujo', 3500.00),
('Cosméticos', 'Luis Victor', 'Set de Maquillaje', 6900.00),
('Celulares', 'Luis Victor', 'Funda Monograma para Celular', 3800.00),
('Celulares', 'Luis Victor', 'Audífonos Monograma', 9500.00),
('Celulares', 'Luis Victor', 'Celular Luis Victor Edición Dorada', 45000.00);
