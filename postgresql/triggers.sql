-- Sincronizar inventario de libros
CREATE OR REPLACE FUNCTION fn_prestamo_book_out() RETURNS trigger AS $$
BEGIN
  UPDATE libros
  SET cantidad   = cantidad - 1,
      disponible = (cantidad - 1) > 0
  WHERE id = NEW.libro_id;
  RETURN NEW;
END $$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_prestamo_book_in() RETURNS trigger AS $$
BEGIN
  UPDATE libros
  SET cantidad   = cantidad + 1,
      disponible = true
  WHERE id = NEW.libro_id;
  RETURN NEW;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER trg_prestamo_after_insert
AFTER INSERT ON prestamo
FOR EACH ROW
EXECUTE FUNCTION fn_prestamo_book_out();

CREATE TRIGGER trg_prestamo_after_return
AFTER UPDATE OF devuelto_en ON prestamo
FOR EACH ROW
WHEN (OLD.devuelto_en IS NULL AND NEW.devuelto_en IS NOT NULL)
EXECUTE FUNCTION fn_prestamo_book_in();

-- Calcular fecha_devolucion
CREATE OR REPLACE FUNCTION fn_prestamo_set_fecha() RETURNS trigger AS $$
BEGIN
  IF NEW.prestado_en IS NULL THEN
    NEW.prestado_en := CURRENT_DATE;
  END IF;
  NEW.fecha_devolucion := NEW.prestado_en + NEW.dias_prestamos;
  RETURN NEW;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER trg_prestamo_set_fecha
BEFORE INSERT OR UPDATE OF prestado_en, dias_prestamos ON prestamo
FOR EACH ROW
EXECUTE FUNCTION fn_prestamo_set_fecha();

-- Calcular edad de usuario
CREATE OR REPLACE FUNCTION fn_usuario_set_edad() RETURNS trigger AS $$
BEGIN
  IF NEW.fecha_nacimiento IS NOT NULL THEN
    NEW.edad := DATE_PART('year', AGE(CURRENT_DATE, NEW.fecha_nacimiento));
  END IF;
  RETURN NEW;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER trg_usuario_set_edad
BEFORE INSERT OR UPDATE OF fecha_nacimiento ON usuarios
FOR EACH ROW
EXECUTE FUNCTION fn_usuario_set_edad();

-- Validar sanciones vigentes y máximo de 5 préstamos activos
CREATE OR REPLACE FUNCTION fn_prestamo_validaciones() RETURNS trigger AS $$
DECLARE
  activos INT;
  sancion BOOLEAN;
BEGIN
  SELECT COUNT(*) INTO activos
  FROM prestamo
  WHERE cliente_id = NEW.cliente_id
    AND devuelto_en IS NULL;

  IF activos >= 5 THEN
    RAISE EXCEPTION 'El cliente % ya tiene 5 préstamos activos', NEW.cliente_id;
  END IF;

  SELECT EXISTS (
    SELECT 1 FROM sanciones
    WHERE cliente_id = NEW.cliente_id
      AND fecha_inicio <= CURRENT_DATE
      AND (fecha_final IS NULL OR fecha_final >= CURRENT_DATE)
  ) INTO sancion;

  IF sancion THEN
    RAISE EXCEPTION 'El cliente % tiene una sanción vigente', NEW.cliente_id;
  END IF;

  RETURN NEW;
END $$ LANGUAGE plpgsql;

CREATE TRIGGER trg_prestamo_validaciones
BEFORE INSERT ON prestamo
FOR EACH ROW
EXECUTE FUNCTION fn_prestamo_validaciones();