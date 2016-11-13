CREATE OR REPLACE FUNCTION sci.f_ct_comprobante_apertura (
  pm_id_usuario integer,
  v_id_gestion integer,
  v_id_depto_con integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE CONTABILIDAD (CONIN)
***************************************************************************
 SCRIPT: 		sci.f_ct_comprobante_apertura
 DESCRIPCIÓN: 	Permite contabilizar las solicitudes, ampliaciones y rendiciones 
 AUTOR: 		Rensi Arteaga Copari
 FECHA:			07-05-2012
 COMENTARIOS:	genera comprobante de apertura con el primer numero disponible
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:			
 	
***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCIÓN --
--------------------------

-- PARÁMETROS FIJOS
/*
pm_id_usuario                               integer (si)
pm_ip_origen                                varchar(40) (si)
pm_mac_maquina                              macaddr (si)
pm_log_error                                varchar -- log -- error //variable interna (si)
pm_codigo_procedimiento                     varchar  // valor que identifica el tipo
                                                        de operacion a realizar
                                                        insert  (insertar)
                                                        delete  (eliminar)
                                                        update  (actualizar)
                                                        select  (visualizar)
pm_proc_almacenado                          varchar  // para colocar el nombre del procedimiento en caso de ser llamado
                                                        por otro procedimiento

*/

-- DECLARACIÓN DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÓN (LOCALES) ****---


DECLARE

    --PARÁMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÚMERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÓN
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÓN
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÓGICO (CRÍTICO) = 2
                                               --      ERROR LÓGICO (INTERMEDIO) = 3
                                               --      ERROR LÓGICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    
    g_registros record;
    
    /************* Variables para validar y contabilizar ******************/   
    g_id_tipo_planilla INTEGER;
    g_nro_solicitud varchar;
    g_mensage text;
    g_consulta text;
    a_transaccion_proveedor INTEGER[1]='{}';--acumula lsa transaciones de la central 
    v_depto_gastos record;
    v_transaccion record;
    g_fecha_final date;
    v_anticipo_banco record;
    g_importe_transaccion NUMERIC;
    /************* Variables para contabilizar el comprobante**********************/
    g_id_comprobante integer  ;
    g_id_parametro  integer  ;
    g_nro_cbte  integer  ;
    g_momento_cbte  numeric  ;
    g_fecha_cbte  date  ;
    g_concepto_cbte  varchar  ;
    g_glosa_cbte  varchar  ;
    g_acreedor  varchar  ;
    g_aprobacion  varchar  ;
    g_conformidad  varchar  ;
    g_pedido  varchar  ;
    g_id_periodo_subsis  integer  ;
    g_id_usuario  integer  ;
    g_id_subsistema_cbte  integer  ;
    g_id_clase_cbte  integer  ;
    g_fk_comprobante  integer  ;
    g_origen  varchar  ;
    g_id_depto  integer  ;
    g_id_moneda  integer  ;
    
    g_id_gestion INTEGER;
    g_id_periodo INTEGER;
  	 /************* Variables para contabilizar las transaciones **********************/
    g_id_transaccion   integer;   
  --g_id_comprobante   integer;   
    g_id_fuente_financiamiento   integer;   
    g_id_fina_regi_prog_proy_acti   integer;   
    g_id_unidad_organizacional   integer;   
    g_id_cuenta   integer;   
    g_id_partida   integer;   
    g_id_auxiliar   integer;   
    g_id_orden_trabajo   integer;   
    g_id_oec   integer;   
    g_concepto_tran   varchar;   
  --g_id_moneda   integer;   
    g_fecha_trans   date;   
    g_fk_transaccion   integer;   
    g_id_partida_ejecucion   integer;   
    g_id_presupuesto   integer;   
   /*importe de la transaccion*/ 
	g_importe  NUMERIC;   
    g_monedas record; --para insertar en toda la monedas
    /*variables para mensajes */
    g_id_empleado INTEGER;   
    g_monbre_completo text;  
    g_tipo_pago_fin VARCHAR;
    g_prioridad NUMERIC;
    g_tipo_cambio NUMERIC;
    -------------VARIABLE PARA COMPROBANTE----------
    
    g_importe_haber numeric;
    g_importe_debe  numeric;
    g_saldo numeric=0;
    v_x numeric;
    v_y numeric;
  
    
    
    
    
    
 
BEGIN

           /*
    
              Nombre: CT_COMINICIO_INS
              Descripción: comprobante de apertura
              Autor: RAC
              
            Fecha: 07052012
            Historial de modIFicaciones
            -----  
            ModIFicado:
            Fecha: 
            descripcion:
            -----
            Revisor:  
            Fecha Rev:
            descripcion:
            
            
            -- 0) crear cabecera de comprobante en la gestion   en apertura
            
            --1) obtener el saldo inicial para todas las cuentas en la gestion de cierre 
            
            
            --FOR   suma agrupando por cuenta,id_auxiliar,id_ot,id_partida,id_presupuesto  por depto de conta
               entre  el 1/1/2011  hasta el 31/12/2011  para todas la monedas
               
               --  recupera los valores equivalentes para la gestion siguiente
               
                  -- presupuesto
                  -- cuenta 
                  -- partida
                  
                  
                 
                  
                  --if si tiene valores equivalentes para gestion siguiente
                  
                  
                   
                      -- llena glosa correcta
                         
                      
                      
                      
                    else
                    --cambia glosa transaccion ERROR
                    
                    -- configura presupuesto de la anterior gestion
                    
                    --end if
                    
                    --calcula saldo debe o haber  
                    
                    --  inserta transaccion 
                    
                    
                    --  inserta trasac valor
                   
           
            
           -- END LOOP suma
               
          
            
            -----
            
            ----------------
             1) Validacion de los datos de entrada
             2) Recuperar los datos del comprobante
             3) insertar el comprobantes segun obligacion (cuentas bancarias)
             4) insertar las transacciones al debe y luego al haber
            */ 
            
            
             
            
            /************************************************************
            -- 0) crear cabecera de comprobante en la gestion   en apertura
            ***************************************************************/
            
             --recupera id_parametro
              select id_parametro  
              into g_id_parametro   
              from sci.tct_parametro 
              where id_gestion =v_id_gestion;
            
           
            --g_fecha_cbte  date  ;
             g_fecha_cbte='01-01-2012';
             
             --g_nro_cbte  integer  ;
             g_nro_cbte =null;
             
             
      --OJO   --g_momento_cbte  numeric  ;
              g_momento_cbte=0.00;--contable sis fecto presupuestario
       --OJO   ACREEDOR
       
	          g_acreedor = NULL ;      
              
              g_glosa_cbte='Combrobante de apertura';
              g_id_moneda=1;
              g_nro_solicitud='';
         
            --odtiene datos del depto
            g_id_depto=v_id_depto_con;
            
            select nombre_depto as aprobacion
            into g_aprobacion
            from param.tpm_depto
            where id_depto=g_id_depto;
            
            
            --
            
            
            --g_concepto_cbte,g_pedido
             g_concepto_cbte= 'Comprobante de apertura '||g_aprobacion;
             g_pedido =g_nro_solicitud;       
            --g_id_subsistema  integer  ; 
              g_id_subsistema_cbte =9;   --SCI
            --g_id_periodo_subsis  integer  ;
            
            
            
            --OJO g_id_gestion, debe ser eriodo de enero
            SELECT id_periodo_subsistema   
            INTO  g_id_periodo_subsis
            FROM param.tpm_periodo_subsistema ps
            inner join param.tpm_periodo p 
              on p.id_periodo  = ps.id_periodo and p.periodo = 1
            WHERE p.id_gestion=v_id_gestion
            and id_subsistema=g_id_subsistema_cbte;
             
             
             
             --g_id_usuario  integer  ; 
              g_id_usuario =pm_id_usuario ;
             --    g_id_clase_cbte  integer  ;
             
             
              g_id_clase_cbte=1;  --  OJO tabla sci.tct_cbte_clase
         
              --g_fk_comprobante  integer  ;
              g_fk_comprobante =NULL;
            
              --g_origen  varchar  ;
               g_origen='comprobante_apertura';   
            
           
             
           --recuperacion del tipo de cambio
            select prioridad 
            into g_prioridad
            from param.tpm_moneda
            where id_moneda=g_id_moneda;
            
            if g_prioridad=1 THEN
                g_tipo_cambio=1;    
            END IF;
             
            if g_prioridad!=1 THEN
                select oficial 
                into g_tipo_cambio      
                from param.tpm_tipo_cambio
                where  id_moneda=g_id_moneda and fecha=g_fecha_cbte;
            END IF;  
            
            
            --recupuera el presupuesto
            select id_presupuesto 
            into g_id_presupuesto
            from param.tpm_depto_conta
            where id_depto=g_id_depto;  
            
            
            --recupera la compocision del presupuesto
            select id_fina_regi_prog_proy_acti,
                   id_unidad_organizacional,
                   id_fuente_financiamiento
            into 
                   g_id_fina_regi_prog_proy_acti,
                   g_id_unidad_organizacional,
                   g_id_fuente_financiamiento
             from presto.tpr_presupuesto 
             where id_presupuesto=g_id_presupuesto;
              
             
              g_id_comprobante=nextval('sci.tct_comprobante_id_comprobante_seq'::regclass);       
              -- insertar el comprobante     
                                    
             
                                    
                                    
            INSERT INTO sci.tct_comprobante (
                    id_comprobante,  
                    id_parametro,  
                    nro_cbte,  
                    momento_cbte,  
                    fecha_cbte,  
                    concepto_cbte,  
                    glosa_cbte,  
                    acreedor,  
                    aprobacion,  
                    conformidad,  
                    pedido,  
                    id_periodo_subsis,  
                    id_usuario,  
                    id_subsistema,  
                    id_clase_cbte,  
                    fk_comprobante,  
                    origen,  
                    id_depto,  
                    id_moneda,
                    tipo_cambio,
                    sw_comprobante_apertura) 
                VALUES(
                g_id_comprobante,  
                g_id_parametro,  
                g_nro_cbte,  
                g_momento_cbte,  
                g_fecha_cbte,  
                g_concepto_cbte||coalesce(' (COMPROBANTE DE INICIO)',''), 
                g_glosa_cbte,  
                 g_acreedor, -- 
                 g_aprobacion,  --ok
                 NULL,-- g_conformidad,  
                 g_pedido,--g_nro_solicitud  
                 g_id_periodo_subsis, --ok 
                 pm_id_usuario,  
                 g_id_subsistema_cbte,  
                 g_id_clase_cbte,  
                 g_fk_comprobante, --ok null
                 g_origen,  
                 g_id_depto,  
                 g_id_moneda, 
                 g_tipo_cambio,
                 'si');
                   
             
             INSERT INTO sci.tct_cbte_estado(id_comprobante,id_usuario,estado_cbte,fecha_estado,sw_estado) 
             VALUES( g_id_comprobante,pm_id_usuario,2.00,CURRENT_DATE,1.00 );  
             
            
            
            ----------------------------------------------------------------------------
            --1) obtener el saldo inicial para todas las cuentas en la gestion de cierre
            ---------------------------------------------------------------------------- 
            
            
            --FOR   suma agrupando por cuenta,id_auxiliar,id_ot,id_partida,id_presupuesto  por depto de conta
            --   entre  el 1/1/2011  hasta el 31/12/2011  para todas la monedas
            
            for g_registros in  (select 
                     -- t.id_presupuesto,
                      --t.id_partida,
                     -- NULL as id_presupuesto,
                      t.id_cuenta,
                      t.id_auxiliar,
                      t.id_orden_trabajo,
                      c.tipo_cuenta,
                      sum(tv.importe_debe) as debe,
                      sum(tv.importe_haber) as haber
                      from 
                      sci.tct_transaccion t
                      join sci.tct_cuenta c on c.id_cuenta = t.id_cuenta 
                      join sci.tct_transac_valor tv on t.id_transaccion = tv.id_transaccion
                      inner join sci.tct_comprobante f on f.id_comprobante = t.id_comprobante
                      inner join sci.tct_cbte_estado ce 
                        on ce.id_comprobante = f.id_comprobante 
                           and  ce.estado_cbte = 1 and ce.sw_estado = 1
                      
                      where f.fecha_cbte between '01-01-2011'  and '12-31-2011' --volver parametro
                      and f.nro_cbte is not null
                      and tv.id_moneda = 1 -- baranibar indica que se calcule solo en Bs. la expresión en USD será a la fecha 01/01/2012
                      and c.tipo_cuenta in (1,2,3) --1: activo, 2: pasivo, 3:patrimonio
                      and f.id_depto = v_id_depto_con
                      and (sw_actualizacion ='si' or sw_actualizacion ='si-no')
                      group by
                      --t.id_presupuesto,
                      --t.id_partida,
                      t.id_cuenta,
                      t.id_auxiliar,
                      t.id_orden_trabajo,
                      c.tipo_cuenta
                      order by t.id_cuenta--,t.id_presupuesto
                      )loop
               
               --  recupera los valores equivalentes para la gestion siguiente
               -- presupuesto
               
               g_concepto_tran ='';
              /*
                   select pi.id_presupuesto_dos
                   into g_id_presupuesto
                   from presto.tpr_presupuesto_ids pi
                   where pi.id_presupuesto_uno = g_registros.id_presupuesto;
                                                 
                   
                   if g_id_presupuesto is null then 
                    g_concepto_tran = g_concepto_tran||',ERROR: PRESUPUESTO,';
                    g_id_presupuesto=g_registros.id_presupuesto;
                   end if;*/
                  
                   

                  -- cuenta 
                  
                   select ci.id_cuenta_dos
                   into g_id_cuenta
                   from sci.tct_cuenta_ids ci
                   where ci.id_cuenta_uno = g_registros.id_cuenta;
--                   limit 1 offset 0;
                   
                   if g_id_cuenta is null then 
                    g_concepto_tran = g_concepto_tran||'ERROR: CUENTA';
                    g_id_cuenta=g_registros.id_cuenta;
                   end if;
                   
                   raise notice 'CUENTA %',g_registros.id_cuenta;

                   raise notice 'CUENTA %',g_id_cuenta;


                  
                  -- partida
                  
                  /* select pai.id_partida_dos
                   into g_id_partida
                   from presto.tpr_partida_ids pai
                   where pai.id_partida_uno = g_registros.id_partida;
                   
                   if g_id_partida is null then 
                    g_concepto_tran = g_concepto_tran||',ERROR: PARTIDA';
                    g_id_partida=g_registros.id_partida;
                   end if;*/
                  
                   --calcula saldo debe o haber 
                   
                   g_saldo = g_registros.debe - g_registros.haber;
                   
                   IF g_saldo < 0 THEN
                      g_importe_haber = g_saldo * (-1);
                      g_importe_debe=0;
                   ELSEIF g_saldo > 0 THEN
                      g_importe_haber = 0;
                      g_importe_debe=g_saldo;
                   ELSE
                      g_importe_haber = 0;
                      g_importe_debe = 0;
                   END IF;
                   
                    
                    g_id_presupuesto= 548;-- ENDE CORPORACION
                    
                    
                    --  inserta transaccion si los momento debe o haber son mayor a cero
                    
                   if(g_importe_haber > 0 or g_importe_debe >0) THEN
                    
                            g_id_transaccion=nextval('sci.tct_transaccion_id_transaccion_seq'::regclass);       
                                   
                            insert into sci.tct_transaccion (
                               id_transaccion,   
                               id_comprobante,     
                               id_fina_regi_prog_proy_acti,  
                               id_unidad_organizacional, 				 
                               id_cuenta,     
                               id_auxiliar,   
                               concepto_tran,  	
                               id_moneda,  
                               fecha_trans,
                               id_orden_trabajo,
                               id_presupuesto
                                )
                            values    
                              (
                               g_id_transaccion, 
                               g_id_comprobante ,      
                               g_id_fina_regi_prog_proy_acti ,  
                               g_id_unidad_organizacional ,     
                               g_id_cuenta ,  
                               g_registros.id_auxiliar ,  
                               g_concepto_tran ,   
                               g_id_moneda ,     
                               CURRENT_DATE,
                               g_registros.id_orden_trabajo,
                               g_id_presupuesto
                              ); 

                             
                            --  inserta trasac valor
                            FOR g_monedas in EXECUTE('select id_moneda from param.tpm_moneda where estado =''activo''') LOOP
                                    
                                   v_x:= round(param.f_pm_conversion_monedas( '01-01-2012',g_importe_debe, g_id_moneda, g_monedas.id_moneda, 'O'),2); 
                                   v_y:= round(param.f_pm_conversion_monedas( '01-01-2012',g_importe_haber, g_id_moneda, g_monedas.id_moneda, 'O'),2);
                                         
                                    
                                    if(v_y > 0 or v_x>0)THEN
                                    
                                          INSERT INTO "sci"."tct_transac_valor"(
                                               id_transaccion, 
                                               id_moneda, 
                                               importe_debe, 
                                               importe_haber     ,
                                               importe_recurso,
                                               importe_gasto
                                          )VALUES (
                                               g_id_transaccion ,      
                                               g_monedas.id_moneda,  --OJO FECHAS DE CONVERSION
                                               round(param.f_pm_conversion_monedas( '01-01-2012',g_importe_debe, g_id_moneda, g_monedas.id_moneda, 'O'),2), 
                                               round(param.f_pm_conversion_monedas( '01-01-2012',g_importe_haber, g_id_moneda, g_monedas.id_moneda, 'O'),2), 
                                               0.00, --recurso
                                               0.00  -- gasto
                                          );   
                                    END IF;
                            END LOOP;  
                                        
                       END IF;--g_saldo mayor a cero     
              
           -- END LOOP suma
           end loop;
      -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Creacion exitosa de comprobante de apertura '||g_id_comprobante||' en sci.tct_documento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;  
      -- SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;
   
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;