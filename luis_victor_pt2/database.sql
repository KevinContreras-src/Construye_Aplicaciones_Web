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
  descripcion VARCHAR(200) NOT NULL,
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

-- 50 productos: 10 por cada categoría
INSERT INTO productos (categoria, marca, nombre, descripcion, precio) VALUES
('Bolsos y Accesorios', 'Luis Victor', 'Bolso Monograma', 'Bolso clásico de lona con monograma dorado y asas de piel.', 15000.00),
('Bolsos y Accesorios', 'Luis Victor', 'Cartera Monograma', 'Cartera compacta con espacio para tarjetas y billetes.', 6800.00),
('Bolsos y Accesorios', 'Luis Victor', 'Cinturón Dorado', 'Cinturón de piel negra con hebilla dorada grande.', 6500.00),
('Bolsos y Accesorios', 'Luis Victor', 'Lentes de Sol Victor', 'Lentes oscuros de montura gruesa con logo en el costado.', 8200.00),
('Bolsos y Accesorios', 'Luis Victor', 'Maleta de Viaje Clásica', 'Maleta rígida con ruedas, perfecta para viajes de lujo.', 38000.00),
('Bolsos y Accesorios', 'Luis Victor', 'Mochila Urbana Victor', 'Mochila de lona monograma para la ciudad.', 29000.00),
('Bolsos y Accesorios', 'Luis Victor', 'Llavero Monograma', 'Llavero dorado con dije del monograma.', 3200.00),
('Bolsos y Accesorios', 'Luis Victor', 'Portatarjetas de Piel', 'Portatarjetas delgado de piel con cierre dorado.', 4500.00),
('Bolsos y Accesorios', 'Luis Victor', 'Bolso Bandolera Negro', 'Bolso de hombro negro con correa ajustable.', 18500.00),
('Bolsos y Accesorios', 'Luis Victor', 'Pulsera de Cadena Dorada', 'Pulsera de eslabones dorados con dije de la marca.', 4900.00),
('Ropa', 'Luis Victor', 'Camisa de Seda Monograma', 'Camisa de seda con estampado de monograma en todo el frente.', 9800.00),
('Ropa', 'Luis Victor', 'Chamarra Monograma', 'Chamarra ligera con monograma bordado y forro suave.', 24000.00),
('Ropa', 'Luis Victor', 'Pañuelo de Seda', 'Pañuelo de seda estampado, ideal para cuello o bolso.', 5200.00),
('Ropa', 'Luis Victor', 'Bufanda de Lana', 'Bufanda gruesa de lana para los días de frío.', 7400.00),
('Ropa', 'Luis Victor', 'Vestido Negro de Gala', 'Vestido largo negro para eventos elegantes.', 32000.00),
('Ropa', 'Luis Victor', 'Pantalón de Vestir Victor', 'Pantalón de corte recto en tela fina.', 11500.00),
('Ropa', 'Luis Victor', 'Suéter de Cachemira', 'Suéter suave de cachemira en color crema.', 16800.00),
('Ropa', 'Luis Victor', 'Gabardina Beige Clásica', 'Gabardina larga con cinturón y botones dorados.', 38500.00),
('Ropa', 'Luis Victor', 'Playera Logo Dorado', 'Playera de algodón con el logo Luis Victor en dorado.', 5400.00),
('Ropa', 'Luis Victor', 'Gorra Monograma', 'Gorra ajustable con monograma bordado.', 4200.00),
('Calzado', 'Luis Victor', 'Tenis Trainer Monograma', 'Tenis de piel con suela gruesa y monograma en el lateral.', 21000.00),
('Calzado', 'Luis Victor', 'Mocasines de Piel', 'Mocasines cómodos de piel suave para diario.', 17500.00),
('Calzado', 'Luis Victor', 'Botines Dorados', 'Botines con detalles dorados y tacón bajo.', 19800.00),
('Calzado', 'Luis Victor', 'Sandalias de Verano Victor', 'Sandalias ligeras con correa y logo dorado.', 12500.00),
('Calzado', 'Luis Victor', 'Zapatillas de Tacón Negras', 'Zapatillas elegantes de tacón alto en negro.', 18900.00),
('Calzado', 'Luis Victor', 'Botas de Piel Marrón', 'Botas resistentes de piel marrón.', 26500.00),
('Calzado', 'Luis Victor', 'Zapatos Oxford de Gala', 'Zapatos de vestir con acabado brillante.', 22800.00),
('Calzado', 'Luis Victor', 'Tenis Blancos Clásicos', 'Tenis blancos minimalistas con detalle dorado.', 15900.00),
('Calzado', 'Luis Victor', 'Pantuflas Monograma', 'Pantuflas suaves con monograma para estar en casa.', 8900.00),
('Calzado', 'Luis Victor', 'Botas de Lluvia Victor', 'Botas de hule con estampado de monograma.', 9800.00),
('Cosméticos', 'Luis Victor', 'Perfume Elegante Victor', 'Perfume con notas florales y toque de madera.', 4800.00),
('Cosméticos', 'Luis Victor', 'Labial Rojo Dorado', 'Labial rojo intenso con estuche dorado.', 1200.00),
('Cosméticos', 'Luis Victor', 'Crema Facial de Lujo', 'Crema hidratante para rostro de uso diario.', 3500.00),
('Cosméticos', 'Luis Victor', 'Set de Maquillaje', 'Estuche con sombras, labial y base para un look completo.', 6900.00),
('Cosméticos', 'Luis Victor', 'Base de Maquillaje Satinada', 'Base de cobertura media con acabado satinado.', 1800.00),
('Cosméticos', 'Luis Victor', 'Rímel Volumen Dorado', 'Rímel para pestañas largas y con volumen.', 950.00),
('Cosméticos', 'Luis Victor', 'Paleta de Sombras Oro', 'Paleta de doce sombras en tonos dorados y tierra.', 2400.00),
('Cosméticos', 'Luis Victor', 'Perfume Noche Victor', 'Perfume intenso pensado para la noche.', 5200.00),
('Cosméticos', 'Luis Victor', 'Crema de Manos Monograma', 'Crema suave para manos en tubo con monograma.', 1100.00),
('Cosméticos', 'Luis Victor', 'Aceite Corporal Brillante', 'Aceite con destellos dorados para el cuerpo.', 2100.00),
('Celulares', 'Luis Victor', 'Funda Monograma para Celular', 'Funda con monograma dorado que protege tu celular.', 3800.00),
('Celulares', 'Luis Victor', 'Audífonos Monograma', 'Audífonos inalámbricos con estuche de carga monograma.', 9500.00),
('Celulares', 'Luis Victor', 'Celular Luis Victor Edición Dorada', 'Celular exclusivo con carcasa dorada (edición parodia).', 45000.00),
('Celulares', 'Luis Victor', 'Smartwatch Tambour Victor', 'Reloj inteligente con pantalla redonda y correa de piel.', 38000.00),
('Celulares', 'Luis Victor', 'Cargador Inalámbrico Monograma', 'Base de carga inalámbrica con acabado monograma.', 4200.00),
('Celulares', 'Luis Victor', 'Funda Cartera para Celular', 'Funda con espacio para tarjetas y tapa de piel.', 4600.00),
('Celulares', 'Luis Victor', 'Bocina Portátil Horizon Victor', 'Bocina bluetooth con luces y diseño monograma.', 12500.00),
('Celulares', 'Luis Victor', 'Cable de Carga Trenzado Dorado', 'Cable de carga resistente trenzado en dorado.', 1500.00),
('Celulares', 'Luis Victor', 'Estuche para Audífonos de Piel', 'Estuche de piel para guardar tus audífonos.', 2900.00),
('Celulares', 'Luis Victor', 'Correa Monograma para Smartwatch', 'Correa intercambiable con estampado monograma.', 3600.00);
