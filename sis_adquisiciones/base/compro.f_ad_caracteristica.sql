CREATE OR REPLACE FUNCTION compro.f_ad_caracteristica (
  ad_id_consulta integer,
  ad_tipo varchar
)
RETURNS varchar AS
$body$
/* dado el id_item devolvera una cadena  consus respectivas caracteristicas */

DECLARE
g_id_item                    integer;
g_caracteristica             text;
s_caracteristicas_item       integer;
g_caracteristica_total       text;
g_registro                   record;
contador                     integer;
g_id_gestion                 integer;
g_id_unidad_organizacional    integer;
g_id_solicitud_compra        integer;

BEGIN

g_caracteristica_total:='';
IF ad_tipo='ITEM' THEN
   BEGIN
             FOR g_registro IN (SELECT ('-  '||CARACT.nombre ||': '||CARITE.valor||'\n')as nombre
                                       FROM almin.tal_caracteristica_item CARITE
                                       LEFT JOIN almin.tal_caracteristica CARACT ON (CARACT.id_caracteristica=CARITE.id_caracteristica)
                                       WHERE CARITE.id_item=ad_id_consulta
                                       ORDER BY CARITE.id_caracteristica_item)
    Loop
        g_caracteristica_total:=g_caracteristica_total||' '||g_registro.nombre;
    END LOOP;
   END;
ELSIF ad_tipo='ADQUISICION' THEN
   BEGIN
           FOR g_registro IN (SELECT ('-  '||COALESCE(CARACT.caracteristica,'')||': '||COALESCE(CARACT.descripcion,'')||'\n') AS descripcion
                          FROM compro.tad_caracteristica CARACT
                          WHERE CARACT.id_solicitud_compra_det=ad_id_consulta)
    Loop
        g_caracteristica_total:=g_caracteristica_total||' '||g_registro.descripcion;
    END LOOP;
     IF (g_caracteristica_total!='') THEN
        BEGIN
              g_caracteristica_total:='\n Caracteristicas Solicitud:' || g_caracteristica_total;
        END;

     END IF;


   END;
-- obtiene las caracteristicas de la solicitud dado el id_proces_compra_det
-- y funciona para cuando dos solicitudes tienen diferentes caracteristicas pero son unidas :)
-- y se utiliza para el reporte de cotizacion
ELSIF ad_tipo='ADQ_PROC' THEN
   BEGIN
           FOR g_registro IN (SELECT '-'||(COALESCE(CARACT.caracteristica,'')||': '||COALESCE(CARACT.descripcion,'')||'\n') AS descripcion
                          FROM compro.tad_caracteristica CARACT
                          INNER JOIN  compro.tad_grupo_sp_det GRUDET on (GRUDET.id_solicitud_compra_det=CARACT.id_solicitud_compra_det)
                          WHERE GRUDET.id_proceso_compra_det=ad_id_consulta)
    Loop
        g_caracteristica_total:=g_caracteristica_total||' '||g_registro.descripcion;
    END LOOP;
     IF (g_caracteristica_total!='') THEN
        BEGIN
              g_caracteristica_total:='\n Caracteristicas Solicitud: \n' || g_caracteristica_total;
        END;

     END IF;
   END;
   -- obtiene las especificaciones tecnicas dado el id de solicitud
   ELSIF ad_tipo='ESP_SOL' THEN
   BEGIN
           FOR g_registro IN (SELECT '-'||COALESCE(SOLDET.especificaciones_tecnicas,'')||'\n' AS descripcion
                          FROM compro.tad_solicitud_compra_det SOLDET
                          WHERE SOlDET.id_solicitud_compra_det=ad_id_consulta and soldet.especificaciones_tecnicas is not null)
    Loop
        g_caracteristica_total:=g_caracteristica_total||' '||g_registro.descripcion;
    END LOOP;
     IF (g_caracteristica_total!='') THEN
        BEGIN
              g_caracteristica_total:='\n Especificaciones Adicionales: \n' || g_caracteristica_total;
        END;

     END IF;
   END;
   
-- Obtiene las especificaciones
ELSIF ad_tipo='ESP_PROC' THEN
   BEGIN
           FOR g_registro IN (SELECT '-'||COALESCE(SOLDET.especificaciones_tecnicas,'')||'\n' AS descripcion
                          FROM compro.tad_solicitud_compra_det SOLDET
                          INNER JOIN  compro.tad_grupo_sp_det GRUDET on (GRUDET.id_solicitud_compra_det=SOLDET.id_solicitud_compra_det)
                          WHERE GRUDET.id_proceso_compra_det=ad_id_consulta and soldet.especificaciones_tecnicas is not null)
    Loop
        g_caracteristica_total:=g_caracteristica_total||' '||g_registro.descripcion;
    END LOOP;
     IF (g_caracteristica_total!='') THEN
        BEGIN
              g_caracteristica_total:='\n Especificaciones Adicionales: \n' || g_caracteristica_total;
        END;

     END IF;
   END;

   ELSIF ad_tipo='ADJUDICACION' THEN
   BEGIN
           FOR g_registro IN (SELECT '-'||(COALESCE(CARACT.caracteristica,'')||': '||COALESCE(CARACT.descripcion,'')||'\n') AS descripcion
                          FROM compro.tad_caracteristica CARACT
                          INNER JOIN  compro.tad_grupo_sp_det GRUDET on (GRUDET.id_solicitud_compra_det=CARACT.id_solicitud_compra_det)
                          WHERE GRUDET.id_grupo_sp_det=ad_id_consulta)

    Loop
    

        g_caracteristica_total:=g_caracteristica_total||' '||g_registro.descripcion;
        
      
    END LOOP;
     IF (g_caracteristica_total!='') THEN
        BEGIN
              g_caracteristica_total:='\n Caracteristicas Solicitud: \n' || g_caracteristica_total;
        END;

     END IF;
   END;

   ELSIF ad_tipo='ESP_ORD' THEN
   BEGIN
           FOR g_registro IN (SELECT '-'||(COALESCE(SOLDET.especificaciones_tecnicas,'')||'\n') AS descripcion
                          FROM compro.tad_solicitud_compra_det SOLDET
                          INNER JOIN  compro.tad_grupo_sp_det GRUDET on (GRUDET.id_solicitud_compra_det=SOLDET.id_solicitud_compra_det)
                          WHERE GRUDET.id_grupo_sp_det=ad_id_consulta
                          and soldet.especificaciones_tecnicas is not null )
   Loop
            
        g_caracteristica_total:=g_caracteristica_total||' '||g_registro.descripcion;
         
    END LOOP;
    
     IF (g_caracteristica_total!='') THEN
        BEGIN
              g_caracteristica_total:='\n Especificaciones Adicionales: \n' || g_caracteristica_total;
        END;

     END IF;
   END;

    ELSIF ad_tipo='COTSER' THEN
   BEGIN
           FOR g_registro IN (select   distinct
                              (COALESCE(SERVIC.descripcion,'')||' '||(case when SOLDET.especificaciones_tecnicas is not null then
                                     (select '\n Especificaciones Adicionales \n - '||SOLDET.especificaciones_tecnicas
                                      from compro.tad_solicitud_compra_det SOLDET1
                                      where SOLDET1.id_solicitud_compra_det=SOLDET.id_solicitud_compra_det)
                                      else ''
						         end)||' '|| compro.f_ad_caracteristica(grudet.id_proceso_compra_det,'ADQ_PROC'))as descripcion
              from compro.tad_grupo_sp_det GRUDET
              INNER JOIN compro.tad_solicitud_compra_det SOLDET ON(GRUDET.id_solicitud_compra_det=SOLDET.id_solicitud_compra_det)
              INNER JOIN compro.tad_servicio SERVIC on (SERVIC.id_servicio=SOLDET.id_servicio)
              WHERE GRUDET.id_proceso_compra_det=ad_id_consulta)
    Loop
        g_caracteristica_total:=g_registro.descripcion;
    END LOOP;
    /*IF (g_caracteristica_total!='') THEN
        BEGIN
              g_caracteristica_total:='\n Caracteristicas Solicitud: \n' || g_caracteristica_total;
        END;

       END IF;*/
   END;
   ELSIF ad_tipo='CUENTA_PARTIDA' THEN
      BEGIN
      --ad_id_consulta recibe en este procedimiento el id_cotizacion

      select id_solicitud_compra into g_id_solicitud_compra from compro.tad_solicitud_proceso_compra where id_proceso_compra=(select id_proceso_compra from compro.tad_cotizacion where id_cotizacion=ad_id_consulta);
      select gesub.id_gestion, solcom.id_unidad_organizacional into g_id_gestion,g_id_unidad_organizacional from compro.tad_solicitud_compra  solcom inner join compro.tad_parametro_adquisicion paradq on paradq.id_parametro_adquisicion=solcom.id_parametro_adquisicion
                                       inner join param.tpm_gestion_subsistema gesub on gesub.id_gestion_subsistema=paradq.id_gestion_subsistema and gesub.id_subsistema=(select id_subsistema from sss.tsg_subsistema where lower(nombre_corto)='compro')
                                       where solcom.id_solicitud_compra=g_id_solicitud_compra;
              FOR g_registro IN (SELECT (CASE WHEN (ADJUDI.id_item is not null)
        	       THEN compro.f_ad_obtener_item_cuenta_partida(ADJUDI.id_item,6,1,g_id_gestion,g_id_unidad_organizacional)||'\n'
              ELSE (SELECT (CUENTA.nombre_cuenta ||'\n') as imputacion_contable
                    FROM compro.tad_servicio SERVIC
--                    INNER JOIN compro.tad_tipo_servicio TIPSER ON (TIPSER.id_tipo_servicio=SERVIC.id_tipo_servicio)
                    INNER JOIN compro.tad_tipo_servicio_cuenta_partida SECUPA on (SECUPA.id_servicio=SERVIC.id_servicio)
                    INNER JOIN sci.tct_cuenta CUENTA ON (CUENTA.id_cuenta=SECUPA.id_cuenta)
                    INNER JOIN presto.tpr_partida PARTID ON (PARTID.id_partida=SECUPA.id_partida)
                    WHERE SERVIC.id_servicio=ADJUDI.id_servicio AND SECUPA.id_gestion=g_id_gestion AND SECUPA.id_unidad_organizacional=g_id_unidad_organizacional
                    )
                   END)as descripcion
                   FROM compro.tad_adjudicacion ADJUDI
                   INNER JOIN compro.tad_cotizacion_det COTDET ON (COTDET.id_cotizacion_det=ADJUDI.id_cotizacion_det)
                   INNER JOIN compro.tad_cotizacion COTIZA ON (COTDET.id_cotizacion=COTIZA.id_cotizacion)
                   WHERE COTIZA.id_cotizacion=ad_id_consulta)

    Loop
        g_caracteristica_total:=g_caracteristica_total||' '||g_registro.descripcion;
    END LOOP;
   END;
   ELSIF ad_tipo='SOL_NOMBRE' THEN
      BEGIN
      --ad_id_consulta recibe en este procedimiento el id_cotizacion

    --  g_consulta:= ''
    /*    FOR g_registro in (SELECT (  case when (POSITION(' ' IN PERSON.nombre)>0)
                              then (SUBSTRING(PERSON.nombre,0,POSITION(' ' IN PERSON.nombre))||' '||
                                    SUBSTRING(PERSON.nombre,POSITION(' 'IN PERSON.nombre)+1,1)||'. '||
                                    COALESCE(PERSON.apellido_paterno,'')||' '||
                                    COALESCE(PERSON.apellido_materno,''))
                              else
                                    (COALESCE(PERSON.nombre,'')||' '||
                                    COALESCE(PERSON.apellido_paterno,'')||' '||
                                    COALESCE(PERSON.apellido_materno,''))

                         end)as nombre_persona
                     FROM  kard.tkp_empleado EMPLEA 
					 INNER JOIN sss.tsg_persona PERSON ON (PERSON.id_persona=EMPLEA.id_persona)
					 WHERE EMPLEA.id_empleado=ad_id_consulta)*/
                 FOR g_registro in (SELECT 
                                    (COALESCE(PERSON.nombre,'')||' '||
                                    COALESCE(PERSON.apellido_paterno,'')||' '||
                                    COALESCE(PERSON.apellido_materno,''))as nombre_persona
                     FROM  kard.tkp_empleado EMPLEA 
					 INNER JOIN sss.tsg_persona PERSON ON (PERSON.id_persona=EMPLEA.id_persona)
					 WHERE EMPLEA.id_empleado=ad_id_consulta)           
  Loop
        g_caracteristica_total:=g_registro.nombre_persona;
        END LOOP;
    END;
   --obtiene el cargo dado el id_empleado_frppa
   ELSIF ad_tipo='SOL_CARGO' THEN
      BEGIN
      --ad_id_consulta recibe en este procedimiento el id_cotizacion

    --  g_consulta:= ''
        FOR g_registro in (SELECT UNIORG.nombre_cargo
                     FROM  kard.tkp_empleado EMPLEA
                     INNER JOIN kard.tkp_historico_asignacion HISASI ON (HISASI.id_empleado=EMPLEA.id_empleado)
                     INNER JOIN kard.tkp_unidad_organizacional UNIORG ON (UNIORG.id_unidad_organizacional=HISASI.id_unidad_organizacional) and HISASI.estado='activo'
                     WHERE EMPLEA.id_empleado=ad_id_consulta)
        Loop
        g_caracteristica_total:=g_registro.nombre_cargo;
        END LOOP;
    END;

      ELSIF ad_tipo='INGRES' THEN
   BEGIN
           FOR g_registro IN (SELECT distinct (SOLCOM.num_solicitud||'/'||SOLCOM.periodo) as descripcion
                              FROM  almin.tal_ingreso INGRES
                               INNER JOIN almin.tal_ingreso_detalle INGRDE ON (INGRDE.id_ingreso=INGRES.id_ingreso)
                               INNER JOIN compro.tad_adjudicacion ADJUDI ON (ADJUDI.id_adjudicacion=INGRDE.id_adjudicacion)
                               INNER JOIN COMPRO.tad_grupo_sp_det GRUPDE ON (GRUPDE.id_grupo_sp_det=ADJUDI.id_grupo_sp_det)
                               INNER JOIN compro.tad_solicitud_compra_det SOLDET ON (SOLDET.id_solicitud_compra_det=GRUPDE.id_solicitud_compra_det)
                               INNER JOIN compro.tad_solicitud_compra SOLCOM on SOLCOM.id_solicitud_compra=SOLDET.id_solicitud_compra
                              WHERE INGRES.id_ingreso =ad_id_consulta
                              )

    Loop
        g_caracteristica_total:=g_caracteristica_total||''||g_registro.descripcion||',';
    END LOOP;
   END;

ELSIF ad_tipo='CLASIFICACION' THEN
   BEGIN
          g_caracteristica_total= (SELECT ''||SUPGRU.nombre ||'-'||GRUPO.nombre||'-'||SUBGRU.nombre
       ||''|| (case when (ID1.nombre<>ID2.nombre)THEN '-'||ID1.nombre ||' '||
                (case when (ID2.nombre<>ID3.nombre) then '-'||ID2.nombre||' '||
                 (case when (ID3.nombre<>ITEM.nombre)then '-'||ID3.nombre else '' end)
                 else '' end)
                else ''END)||', Item: '||ITEM.nombre||', Desc.: '||COALESCE(ITEM.descripcion,'')
  FROM almin.tal_item ITEM
 INNER JOIN almin.tal_supergrupo SUPGRU ON (SUPGRU.id_supergrupo=ITEM.id_supergrupo)
 INNER JOIN almin.tal_subgrupo SUBGRU ON (SUBGRU.id_subgrupo=ITEM.id_subgrupo)
 INNER JOIN almin.tal_grupo GRUPO ON (GRUPO.id_grupo=ITEM.id_grupo)
 INNER JOIN almin.tal_id1 ID1 ON (ID1.id_id1=ITEM.id_id1)
 INNER JOIN almin.tal_id2 ID2 ON (ID2.id_id2=ITEM.id_id2)
 INNER JOIN almin.tal_id3 ID3 ON (ID3.id_id3=ITEM.id_id3)
 WHERE ITEM.id_item=ad_id_consulta);
 END;
 
ELSIF ad_tipo='ORDET' THEN
  BEGIN
  /*
  Descripcion:Lista el detalle de servicio solicitado para mostrarse en listado de ordenes de servicios
  Autor: Ana Maria Villegas
  Fecha de Creacion: 11-09-2009
  */
   FOR g_registro IN (SELECT servic.nombre AS descripcion
                      FROM compro.tad_cotizacion_det cotdet
                      INNER JOIN compro.tad_servicio servic ON servic.id_servicio=cotdet.id_servicio
                      AND cotdet.id_cotizacion_det IN (select id_cotizacion_det FROM compro.tad_adjudicacion WHERE estado='activo')
                      WHERE cotdet.id_cotizacion=ad_id_consulta
                      )
     Loop
        g_caracteristica_total:=g_caracteristica_total||' '||g_registro.descripcion;
    END LOOP;


  END;
  
  ELSIF ad_tipo='NOMBRE_EMP' THEN
      BEGIN
      --ad_id_consulta recibe en este procedimiento el id_cotizacion

    --  g_consulta:= ''
        FOR g_registro in (SELECT (  case when (POSITION(' ' IN PERSON.nombre)>0)
                              then (SUBSTRING(PERSON.nombre,0,POSITION(' ' IN PERSON.nombre))||' '||
                                    SUBSTRING(PERSON.nombre,POSITION(' 'IN PERSON.nombre)+1,1)||'. '||
                                    COALESCE(PERSON.apellido_paterno,''))
                              else
                                    (COALESCE(PERSON.nombre,'')||' '||
                                    COALESCE(PERSON.apellido_paterno,''))

                         end)as nombre_persona
                     FROM  kard.tkp_empleado EMPLEA
					 INNER JOIN sss.tsg_persona PERSON ON (PERSON.id_persona=EMPLEA.id_persona)
					 WHERE EMPLEA.id_empleado=ad_id_consulta)
  Loop
        g_caracteristica_total:=g_registro.nombre_persona;
        END LOOP;
    END;

ELSE  -- enviando null
      BEGIN
          FOR g_registro IN ( SELECT ('- '||CARACT.nombre ||': '||CARITE.valor||' ' ||(coalesce(unimed.nombre,' ')) ||'\n')as nombre
                                       FROM almin.tal_caracteristica_item CARITE
                                       left JOIN almin.tal_caracteristica CARACT ON (CARACT.id_caracteristica=CARITE.id_caracteristica)
                                       LEFT JOIN param.tpm_tipo_unidad_medida tipuni on tipuni.id_tipo_unidad_medida=CARACT.id_tipo_unidad_medida
                                       left join param.tpm_unidad_medida_base unimed on unimed.id_tipo_unidad_medida=tipuni.id_tipo_unidad_medida
                                       WHERE CARITE.id_item=ad_id_consulta)
          LOOP
               g_caracteristica_total:=g_caracteristica_total||' '||g_registro.nombre;
          END LOOP;
      END;
 END IF;

 return  g_caracteristica_total;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;