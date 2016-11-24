--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_cierre_almacen_logico (
  pm_id_usuario integer,
  al_id_almacen_logico integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES
***************************************************************************
 SCRIPT:         almin.f_tal_cierre_almacen_logico
 DESCRIPCIÓN:    Reazlia el cierre del almacen lógico y crea la nueva gestion con los saldos
 AUTOR:          Rensi Arteaga Copari 
 FECHA:          05/12/2016
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:
 AUTOR:
 FECHA:

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCIÓN --
--------------------------


-- DECLARACIÓN DE VARIABLES DE LA FUNCIÓN (LOCALES)

DECLARE

   g_registros 			record;
   g_costo_unitario		numeric; 
   g_id_parametro_almacen				integer;
   g_id_parametro_almacen_logico		integer;
   v_registros_ingreso					record;
   v_registros_salida					record;
   v_numeros							varchar;
   g_id_parametro_almacen_sg			integer;
   g_gestion_act						varchar;
   g_id_parametro_almacen_logico_sg		integer;
   v_id_motivo_ingreso					integer;
   g_id_fina_regi_prog_proy_acti		integer;
   v_id_motivo_ingreso_cuenta			integer;
   g_id_firma_autorizada				integer;
   g_id_ingreso							integer;
   v_id_almacen							integer;
   g_id_responsable_almacen				integer;
   v_reg_kardex							record;
   v_costo_total_ingreso				numeric;
   g_correl                      		varchar;
   v_date_fin							date;
   g_contabilizar						varchar;
   v_id_empleado						integer;

BEGIN
      
      -- recuperar la gestion vigente del almacen logico
      select 
          pl.id_parametro_almacen,
          pl.id_parametro_almacen_logico,
          pa.gestion,
          ale.id_fina_regi_prog_proy_acti,
          ale.id_almacen
      into
          g_id_parametro_almacen,
          g_id_parametro_almacen_logico,
          g_gestion_act,
          g_id_fina_regi_prog_proy_acti,
          v_id_almacen
                    
      from almin.tal_parametro_almacen_logico pl
           inner join almin.tal_almacen_logico al on al.id_almacen_logico = pl.id_almacen_logico
           inner join almin.tal_almacen_ep ale on ale.id_almacen_ep =  al.id_almacen_ep
           inner join almin.tal_parametro_almacen pa on pa.id_parametro_almacen = pl.id_parametro_almacen
      where pl.estado = 'abierto'
            and pl.id_almacen_logico = al_id_almacen_logico;
      
      -- TODO verificar que no queden prestamos pendientes
      
      -- verificar que no existan ingresos sin valoracion (tolos lso detalle denbe tener un costo)
      -- y  que no existan ingresos sin finalizat
      v_numeros = '';
      
      FOR v_registros_ingreso in (
      								select DISTINCT
                                          ing.correlativo_ing,
                                          ing.fecha_finalizado_cancelado,
                                          ing.estado_ingreso
                                    from almin.tal_ingreso ing
                                    inner join almin.tal_ingreso_detalle id on id.id_ingreso = ing.id_ingreso
                                    where ing.id_parametro_almacen_logico = g_id_parametro_almacen_logico
                                           and  (id.costo_unitario = 0 or  id.costo_unitario is null  or ing.estado_ingreso != 'Finalizado' ) ) LOOP
               v_numeros =  v_numeros||'( I-'||v_registros_ingreso.correlativo_ing::varchar||', '||v_registros_ingreso.fecha_finalizado_cancelado::varchar||')';
                
      
      END LOOP;
      
      
      
      if v_numeros != ''  THEN   
         raise exception 'Existen ingesos  sin costos unitarios o son finalizar :  %', v_numeros;
      end if;
      
      
      -- verificar que todas las salidas esten valoradas y no finalizadas
      v_numeros = '';
      
      FOR v_registros_salida in (
       								select 
                                          DISTINCT
                                          sal.correlativo_sal,
                                          sal.fecha_finalizado_cancelado,
                                          sal.estado_salida
                                    from almin.tal_salida sal
                                    inner join almin.tal_salida_detalle sd on sd.id_salida  = sal.id_salida
                                    where sal.id_parametro_almacen_logico = g_id_parametro_almacen_logico
                                           and  (sd.costo_unitario = 0 or  sd.costo_unitario is null or  sal.estado_salida != 'Finalizado')) LOOP
      
                v_numeros =  v_numeros||'( S-'||v_registros_salida.correlativo_sal::varchar||', '||v_registros_salida.fecha_finalizado_cancelado::varchar||')';
                
      
      END LOOP;
      
      if  v_numeros != ''  THEN   
         raise exception 'Existen salidas sin costos unitarios o sin finalizar: %', v_numeros;
      end if;
      
      
      -- cerrar gestion actual 
      update almin.tal_parametro_almacen_logico set
         estado = 'cerrado'
      where id_parametro_almacen_logico = g_id_parametro_almacen_logico;
      
      -- verificar si exite la siguiente gestion  y recuperarla
      
      select 
         pa.id_parametro_almacen
      into
         g_id_parametro_almacen_sg
      from almin.tal_parametro_almacen pa
      where pa.gestion::integer = g_gestion_act::integer + 1;
      
      if g_id_parametro_almacen_sg is null then
         raise exception 'no existe parametro  almacen para la gestion %', g_gestion_act::integer+1;
      end if;
      
      --recuperar el responsable de almacen
      select
         ra.id_responsable_almacen
      into 
         g_id_responsable_almacen
      from almin.tal_responsable_almacen ra
      where ra.id_almacen = v_id_almacen and
       		ra.cargo = 'Jefe de Almacen';
      IF g_id_responsable_almacen is null THEN
         raise exception 'Nos e encontre un Feje de Almacen';
      END IF;
  
      
      -- crear nueva gestion para el almcen logico en estado abierto
      SELECT NEXTVAL('almin.tal_parametro_almacen_logico_id_parametro_almacen_logico_seq') INTO g_id_parametro_almacen_logico_sg;
      INSERT INTO  almin.tal_parametro_almacen_logico
                  (  id_parametro_almacen_logico,
                     id_parametro_almacen,
                     id_almacen_logico,
                     estado
                  )
                  VALUES (
                     g_id_parametro_almacen_logico_sg,
                     g_id_parametro_almacen_sg,
                     al_id_almacen_logico,
                     'abierto'
                  );
       ---------------------------------------------           
       --recuperar datos basico para el ingreso ....
       ----------------------------------------------------
        -- VERIFICA SI DEBE CONTABILIZARSE 
                                    
         SELECT
           TIPALM.contabilizar
         INTO 
             g_contabilizar
         FROM almin.tal_almacen_logico ALMLOG
         INNER JOIN almin.tal_tipo_almacen TIPALM
         ON TIPALM.id_tipo_almacen = ALMLOG.id_tipo_almacen
         WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico;
         
         --identificar el motivo de ingreso para saldos iniciales
         
         select 
            mi.id_motivo_ingreso
         into
            v_id_motivo_ingreso
         from almin.tal_motivo_ingreso mi
         where mi.codigo = 'INI';
         
         IF v_id_motivo_ingreso is null THEN
           raise exception 'No se encontro el motivo de ingreso para saldo inicial con código INI';
         END IF;
         
         --identificar el motivo ingreso cuenta
         select
            mic.id_motivo_ingreso_cuenta
         into
            v_id_motivo_ingreso_cuenta
         from almin.tal_motivo_ingreso_cuenta mic
         where     mic.id_fina_regi_prog_proy_acti = g_id_fina_regi_prog_proy_acti
               and  mic.id_motivo_ingreso = v_id_motivo_ingreso ;
        
        IF v_id_motivo_ingreso_cuenta is null THEN
            raise exception 'No se encontro  cuenta para el motivo de ingreso INI (ingerso inicial)';
        END IF;
       
         -- SE OBTIENE LA FIRMA AUTORIZADA CORRESPONDIENTE para el ingreso por transferencia
         SELECT
            FIRAUT.id_firma_autorizada,
            emp.id_empleado
         INTO 
             g_id_firma_autorizada,
             v_id_empleado
         FROM almin.tal_firma_autorizada FIRAUT
         INNER JOIN kard.tkp_empleado_tpm_frppa emp ON emp.id_empleado_frppa = FIRAUT.id_empleado_frppa
         INNER JOIN almin.tal_almacen_logico ALMLOG  ON ALMLOG.id_almacen_ep = FIRAUT.id_almacen_ep
         INNER JOIN almin.tal_motivo_ingreso MOTING ON MOTING.id_motivo_ingreso = FIRAUT.id_motivo_ingreso AND MOTING.estado_registro='activo'
         INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU  ON MOINCU.id_motivo_ingreso = MOTING.id_motivo_ingreso
         WHERE		 ALMLOG.id_almacen_logico = al_id_almacen_logico
             	AND MOINCU.id_motivo_ingreso_cuenta = v_id_motivo_ingreso_cuenta
            	AND FIRAUT.estado_reg = 'activo'
         ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
         LIMIT 1;
         
         IF g_id_firma_autorizada is null THEN
            raise exception 'No se encontro una firma autorizada para el motivo ingreso cuenta INI';
         END IF;
       
       ---------------------------------------------------------------
       -- cear un ingreso por saldo inicial  (similar a transferenias)
       ---------------------------------------------------------------
      
       --OBTIENE EL ÚLTIMO VALOR DE LA SECUENCIA PARA INSERTAR EL INGRESO
       SELECT NEXTVAL('almin.tal_ingreso_id_ingreso_seq') INTO g_id_ingreso;
       
       v_date_fin = ('01/01/'||(g_gestion_act::integer + 1)::varchar)::date;
      
       -- Obtiene el correlativo del Ingreso
       g_correl = almin.f_al_obtener_correlativo('INGRES','01',al_id_almacen_logico);
            
       --CREACIÓN DE INGRESO
       INSERT INTO almin.tal_ingreso(id_ingreso,
         descripcion,
         costo_total               ,contabilizar               ,estado_ingreso                         ,estado_registro,
         fecha_borrador            ,fecha_pendiente            ,fecha_aprobado_rechazado               ,id_responsable_almacen,
         id_proveedor              ,id_contratista             ,id_empleado                            ,id_almacen_logico,    
         id_firma_autorizada       ,id_institucion             ,id_motivo_ingreso_cuenta,
         fecha_ing_fisico          ,fecha_ing_valorado         ,fecha_finalizado_cancelado,
         orden_compra              ,observaciones              ,id_usuario                             ,id_parametro_almacen,
         circuito,					fecha_finalizado_exacta,	
         id_parametro_almacen_logico, correlativo_ing
       ) VALUES ( g_id_ingreso,
         'saldo inicial',
         0             ,g_contabilizar                          ,'Finalizado'                           ,'activo',
         now()                     ,now()                      ,now()                                  ,g_id_responsable_almacen,
         NULL                      ,NULL                       ,v_id_empleado					       ,al_id_almacen_logico,
         g_id_firma_autorizada     ,NULL                       ,v_id_motivo_ingreso_cuenta,
         NULL                      ,NULL                       ,v_date_fin,
         NULL                      ,'saldo inicial'            ,pm_id_usuario                          ,g_id_parametro_almacen_sg,
         'Simplificado'				,now()
         ,g_id_parametro_almacen_logico_sg,      g_correl
       );
      
      -- FOR ... listar los item del kardex logico para saber el saldo actual
      v_costo_total_ingreso = 0;
      FOR v_reg_kardex in (
                            select 
                                 kl.id_item,
                                 kl.cantidad,
                                 kl.costo_unitario,
                                 kl.costo_total,
                                 kl.estado_item,
                                 kl.reservado
                            from almin.tal_kardex_logico kl
                            where kl.id_almacen_logico = al_id_almacen_logico
                                  and kl.id_parametro_almacen = g_id_parametro_almacen
                  ) LOOP
      
           -- insertar el detalle en el ingreso por saldo inicial
           
           INSERT INTO almin.tal_ingreso_detalle(
                                                 costo,
                                                 costo_unitario,
                                                 precio_venta,
                                                 cantidad,
                                                 id_item,
                                                 id_ingreso,
                                                 estado_item
                                              ) 
                                        values(
                                                  v_reg_kardex.costo_total,
                                                  v_reg_kardex.costo_unitario,
                                                  0,
                                                  v_reg_kardex.cantidad,
                                                  v_reg_kardex.id_item,
                                                  g_id_ingreso,
                                                  v_reg_kardex.estado_item
                                              );
           
           
         
           -- crear nuevo kardex logico para la siguiente gestion
           
            INSERT INTO almin.tal_kardex_logico(
                 estado_item             ,
                 stock_minimo           ,
                 cantidad             ,
                 costo_unitario,
                 costo_total             ,
                 reservado              ,
                 id_item,
                 id_almacen_logico       ,
                 id_parametro_almacen
             ) VALUES(
                 v_reg_kardex.estado_item ,
                 10                     ,
                 v_reg_kardex.cantidad ,
                 COALESCE(v_reg_kardex.costo_unitario,0),
                 v_reg_kardex.costo_total        ,
                 0                   ,
                 v_reg_kardex.id_item,
                 al_id_almacen_logico     ,
                 g_id_parametro_almacen_sg
             );
           
           --totalizar
           v_costo_total_ingreso =  v_costo_total_ingreso + v_reg_kardex.costo_total;
      END LOOP;
      
      --actulizar costo total del ingreso 
      update almin.tal_ingreso set
         costo_total =  v_costo_total_ingreso
      where id_ingreso = g_id_ingreso;
      
      
      
      RETURN 'Actualización realizada';
    

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;