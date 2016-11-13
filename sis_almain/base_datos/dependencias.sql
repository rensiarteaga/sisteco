



CREATE TRIGGER update_unidad_constructiva
  AFTER INSERT OR UPDATE OR DELETE 
  ON alma.tai_unidad_constructiva FOR EACH STATEMENT 
  EXECUTE PROCEDURE alma.trig_upd_unidad_constructiva();
  
  
  
  
  
  