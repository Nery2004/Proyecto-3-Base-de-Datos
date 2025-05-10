CREATE TABLE usuarios (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR NOT NULL,
  apellido VARCHAR NOT NULL,
  fecha_nacimiento DATE,
  edad INT
);

CREATE TABLE clientes (
  id SERIAL PRIMARY KEY,
  usuario_id INT REFERENCES usuarios(id)
);

CREATE TABLE autores (
  id SERIAL PRIMARY KEY,
  usuario_id INT REFERENCES usuarios(id)
);

CREATE TABLE editoriales (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR NOT NULL,
  correo VARCHAR NOT NULL UNIQUE
);

CREATE TABLE libros (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR NOT NULL,
  autor_id INT REFERENCES autores(id),
  editorial_id INT REFERENCES editoriales(id),
  cantidad INT NOT NULL CHECK (cantidad >= 0),
  disponible BOOLEAN DEFAULT TRUE
);

CREATE TABLE autor_libro (
  autor_id INT REFERENCES autores(id),
  libro_id INT REFERENCES libros(id),
  PRIMARY KEY (autor_id, libro_id)
);

CREATE TABLE categorias (
  id SERIAL PRIMARY KEY,
  categoria VARCHAR(100),
  descripcion TEXT
);

CREATE TABLE libro_categorias (
  libro_id INT REFERENCES libros(id),
  categoria_id INT REFERENCES categorias(id),
  PRIMARY KEY (libro_id, categoria_id)
);

CREATE TABLE bibliotecarios (
  id SERIAL PRIMARY KEY,
  usuario_id INT REFERENCES usuarios(id)
);

CREATE TABLE prestamo (
  id SERIAL PRIMARY KEY,
  cliente_id INT NOT NULL REFERENCES clientes(id),
  bibliotecario_id INT NOT NULL REFERENCES bibliotecarios(id),
  libro_id INT NOT NULL REFERENCES libros(id),
  dias_prestamos INT NOT NULL CHECK (dias_prestamos <= 30 AND dias_prestamos > 0),
  fecha_devolucion DATE NOT NULL,
  prestado_en DATE NOT NULL DEFAULT CURRENT_DATE,
  devuelto_en DATE DEFAULT NULL
);

CREATE TABLE sanciones (
  id SERIAL PRIMARY KEY,
  cliente_id INT REFERENCES clientes(id),
  motivo TEXT,
  fecha_inicio DATE NOT NULL DEFAULT CURRENT_DATE,
  fecha_final DATE NULL
);

CREATE TABLE usuario_correos (
  id SERIAL PRIMARY KEY,
  usuario_id INT REFERENCES usuarios(id),
  correo VARCHAR UNIQUE
);

CREATE TABLE usuario_telefonos (
  id SERIAL PRIMARY KEY,
  usuario_id INT REFERENCES usuarios(id),
  telefono VARCHAR UNIQUE
);
