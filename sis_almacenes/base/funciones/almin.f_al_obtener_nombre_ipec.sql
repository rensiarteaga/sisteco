--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_obtener_nombre_ipec (
  al_id_consulta integer,
  al_tipo varchar
)
RETURNS varchar AS
$body$
/* dado el id_item devolvera una cadena  consus respectivas caracteristicas */

DECLARE
g_nombre                     text;
g_registro                   record;
contador                     integer;

BEGIN

g_nombre:='';
IF al_tipo='INGRESO' THEN
   BEGIN
             FOR g_registro IN (SELECT INGDET.id_ingreso_detalle,
                                CASE COALESCE(INGRES.id_institucion,0)
                                WHEN 0 THEN
                                    CASE COALESCE(INGRES.id_proveedor,0)
                                        WHEN 0 THEN
                                            CASE COALESCE(INGRES.id_contratista,0)
                                                WHEN 0 THEN
                                                    (SELECT COALESCE(apellido_paterno,'')||'  '||COALESCE(apellido_materno,'')||'  '||COALESCE(nombre,'') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
                                                ELSE
                                                    (SELECT nombre FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
                                            END   
                                        ELSE
                                            (SELECT nombre FROM param.tpm_institucion WHERE id_institucion = PROVEE.id_institucion)
                                    END
                                ELSE
                                    (SELECT nombre FROM param.tpm_institucion WHERE id_institucion = INGRES.id_institucion)
                            END || ' Remisión: ' || COALESCE (INGRES.num_factura,'s/n')||' '||INGRES.descripcion as glosa
							FROM almin.tal_ingreso_detalle INGDET
							 INNER JOIN almin.tal_ingreso INGRES  ON INGRES.id_ingreso = INGDET.id_ingreso
							 LEFT JOIN param.tpm_institucion INSTIT   ON INSTIT.id_institucion = INGRES.id_institucion
							 LEFT JOIN param.tpm_contratista CONTRA   ON CONTRA.id_contratista = INGRES.id_contratista
							 LEFT JOIN kard.tkp_empleado EMPLEA       ON EMPLEA.id_empleado = INGRES.id_empleado
							 LEFT JOIN compro.tad_proveedor PROVEE    ON PROVEE.id_proveedor = INGRES.id_proveedor
							WHERE INGDET.id_ingreso_detalle=al_id_consulta)
    Loop
        g_nombre:=g_registro.glosa;
    END LOOP;
   END;
ELSIF al_tipo='SALIDA' THEN
   BEGIN
           FOR g_registro IN (SELECT                         
                                  CASE COALESCE(SALIDA.id_institucion,0)
                                   WHEN 0 THEN CASE COALESCE(SALIDA.id_contratista,0)
                                   WHEN 0 THEN (SELECT COALESCE(apellido_paterno,'')||' '||COALESCE(apellido_materno,'')||' '||COALESCE(nombre,'') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
                                ELSE (SELECT COALESCE(nombre,'') FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
                                END
                            ELSE INSTIT.nombre
                            END ||' '||SALIDA.descripcion as glosa
 							FROM almin.tal_salida_detalle SALDET
							INNER JOIN almin.tal_salida SALIDA   ON SALIDA.id_salida = SALDET.id_salida
							LEFT JOIN param.tpm_contratista CONTRA  ON CONTRA.id_contratista = SALIDA.id_contratista
							LEFT JOIN param.tpm_institucion INSTIT  ON INSTIT.id_institucion = SALIDA.id_institucion
							LEFT JOIN kard.tkp_empleado EMPLEA  ON EMPLEA.id_empleado = SALIDA.id_empleado
							WHERE SALDET.id_salida_detalle= al_id_consulta)
    Loop
        g_nombre:=g_registro.glosa;
    END LOOP;

   END;
   END IF;   
   
 return  g_nombre;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;