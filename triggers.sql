CREATE OR REPLACE FUNCTION verificar_y_actualizar_asiento()
RETURNS TRIGGER AS $$
BEGIN
  IF NOT EXISTS (
    SELECT 1 FROM Asientos WHERE id = NEW.asiento_id AND disponible = true
  ) THEN
    RAISE EXCEPTION 'El asiento % no está disponible.', NEW.asiento_id;
  END IF;

  UPDATE Asientos
  SET disponible = false
  WHERE id = NEW.asiento_id;

  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_verificar_y_actualizar_asiento
BEFORE INSERT ON ReservaDetalle
FOR EACH ROW
EXECUTE FUNCTION verificar_y_actualizar_asiento();