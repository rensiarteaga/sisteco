CREATE OR REPLACE FUNCTION sci.f_ct_control_nro_cbte (
)
RETURNS trigger AS
$body$
DECLARE
v_cbte_similares record;
g_id_documento INTEGER;
g_periodo integer;
g_fecha_inicio date;
g_fecha_final date;
BEGIN

select id_documento
into g_id_documento
from sci.tct_cbte_clase
where id_clase_cbte=NEW.id_clase_cbte;
--recupera el periodo del comprobante
select per.periodo, fecha_inicio , fecha_final
into g_periodo, g_fecha_inicio, g_fecha_final
from param.tpm_periodo_subsistema  persis
    inner join  param.tpm_periodo  per on persis.id_periodo=per.id_periodo
    where persis.id_periodo_subsistema=NEW.id_periodo_subsis;


IF TG_OP = 'INSERT' THEN
          FOR v_cbte_similares in select *
                                  from sci.tct_comprobante cbte
                                       INNER join sci.tct_cbte_clase clacbte on cbte.id_clase_cbte=clacbte.id_clase_cbte
                                  WHERE cbte.nro_cbte= NEW.nro_cbte and cbte.id_depto=NEW.id_depto and clacbte.id_documento=g_id_documento and cbte.id_parametro=NEW.id_parametro   Loop
                                  raise exception '(INSERT) No puede duplicar el numero de comprobante: %', NEW.nro_cbte ;
          END Loop;      
            --validacion de la fecha y  el periodo  del comprobante                     
          if (  select NEW.fecha_cbte BETWEEN g_fecha_inicio and  g_fecha_final =FALSE )THEN
                             raise exception '(INSERT)La fecha del comprobante % no corresponde al periodo (%) del comprobante',NEW.fecha_cbte, g_periodo ;          
          END IF;
                            
END IF;
IF TG_OP = 'UPDATE'  THEN
          FOR v_cbte_similares in select *
                                  from sci.tct_comprobante cbte
                                       INNER join sci.tct_cbte_clase clacbte on cbte.id_clase_cbte=clacbte.id_clase_cbte
                                  WHERE cbte.nro_cbte= NEW.nro_cbte and cbte.id_depto=NEW.id_depto and clacbte.id_documento=g_id_documento and cbte.id_parametro=NEW.id_parametro and NEW.nro_cbte!=OLD.nro_cbte Loop
                                  raise exception '(UPDATE) No puede duplicar el numero de comprobante: %; %', NEW.nro_cbte,OLD.nro_cbte;
          END Loop;  
                      --validacion de la fecha y  el periodo  del comprobante                     
         if (  select NEW.fecha_cbte BETWEEN g_fecha_inicio and  g_fecha_final =FALSE )THEN
                            raise exception '(UPDATE)La fecha del comprobante(%) % no corresponde al periodo (%) del comprobante',NEW.id_comprobante,NEW.fecha_cbte, g_periodo ;          
          END IF;
          
          
          
END IF; 

RETURN NEW;


END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;