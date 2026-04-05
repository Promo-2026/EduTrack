-- Crear y usar base de datos
CREATE DATABASE IF NOT EXISTS mys;
USE mys;

-- Crear tabla
CREATE TABLE estudiantes (
  dni VARCHAR(20) NOT NULL,
  Nombre VARCHAR(30) NOT NULL,
  Apellido VARCHAR(30) NOT NULL,
  Edad INT NOT NULL,
  Grado VARCHAR(15) NOT NULL,
  calificacion INT NOT NULL DEFAULT 0,
  estado VARCHAR(20) NOT NULL,
  foto VARCHAR(255),
  PRIMARY KEY (dni)
);

-- Insertar datos
INSERT INTO estudiantes (dni, Nombre, Apellido, Edad, Grado, calificacion, estado, foto) VALUES
('23423523456', 'Alan', 'Pérsico', 16, 'Sexto', 10, 'Aprobado', 'img/Alan_P__rsico_12212313.png'),
('33333333', 'juan', 'reichert', 38, 'Séptimo', 1, 'Reprobado', 'img/juan_reichert_33333333.png'),
('3563463', 'Mariliz', 'Almaraz', 18, 'Sexto', 10, 'Aprobado', 'img/Mariliz_Almaraz_871234.png'),
('457473', 'Belén', 'Tamburrino', 17, 'Sexto', 10, 'Aprobado', 'img/Belen_Tamburrino_47950900.png');