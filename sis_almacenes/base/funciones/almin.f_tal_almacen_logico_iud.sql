--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_almacen_logico_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_almacen_logico integer,
  al_codigo varchar,
  al_bloqueado varchar,
  al_nombre varchar,
  al_descripcion varchar,
  al_fecha_reg date,
  al_obsevaciones varchar,
  al_id_almacen_ep integer,
  al_id_tipo_almacen integer,
  al_cerrado varchar,
  al_id_unidad_organizacional integer,
  al_costeo_obligatorio varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT:         almin.f_tal_almacen_logico_iud
 DESCRIPCIÓN:     Permite registrar en la tabla almin.tal_almacen_logico
 AUTOR:         (generado automaticamente)
 FECHA:            2007-10-25 18:52:59
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION:cascada    
 AUTOR:    susana castro        
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
    g_reg_error                      varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÓN
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÓGICO (CRÍTICO) = 2
                                               --      ERROR LÓGICO (INTERMEDIO) = 3
                                               --      ERROR LÓGICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_fina_regi_prog_proy_acti integer;     -- VARIABLE DE LA ESTRUCTURA PROGRAMÁTICA
    g_cod_almacen_logico   			varchar;  
    g_cerrado_almacen_ep 			varchar; 
    g_bloqueado_almacen_ep 			varchar;
    g_id_almacen_logico				integer;
    g_id_parametro_almacen			integer;
    
BEGIN


---*** INICIACIÓN DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_almacen_logico_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÓN DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÓN DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT sss.tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  sss.tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACIÓN DE LLAMADA POR USUARIO O FUNCIÓN
    IF pm_proc_almacenado IS NOT NULL THEN
        IF NOT EXISTS(SELECT 1 FROM pg_proc WHERE proname = pm_proc_almacenado) THEN
            g_descripcion_log_error := 'Procedimiento ejecutor inexistente';
            g_nivel_error := '2';
            g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            
            --REGISTRA EL LOG
            g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                 pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                 pm_codigo_procedimiento   ,pm_proc_almacenado);
            --DEVUELVE MENSAJE DE ERROR
            RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
        ELSE
            g_privilegio_procedimiento := TRUE;
        END IF;
    END IF;


    ---*** VERIFICACIÓN DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCIÓN SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecución del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    
      --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    IF pm_codigo_procedimiento = 'AL_ALMLOG_INS' THEN

        BEGIN
        /*IF EXISTS(SELECT 1
                      FROM almin.tal_almacen_logico
                      WHERE codigo = al_codigo 
                      ) THEN
                   
                g_descripcion_log_error := 'Inserción no realizada: El Codigo ya Existe ';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                
            END IF;*/   
            
              
           -- OBTIENE EL SIGUIENTE ID DE LA SECUENCIA DE INGRESOS
           SELECT NEXTVAL('almin.tal_almacen_logico_id_almacen_logico_seq') INTO g_id_almacen_logico;          
            
           INSERT INTO almin.tal_almacen_logico(
                id_almacen_logico,
                codigo,
                bloqueado,
                nombre,
                descripcion,
                fecha_reg,
                obsevaciones,
                id_almacen_ep,
                id_tipo_almacen,
                cerrado,
                id_unidad_organizacional,
                costeo_obligatorio
                        ) VALUES (
                 g_id_almacen_logico,
                 al_codigo,
                 al_bloqueado,
                 al_nombre,
                 al_descripcion,
                 now(),
                 al_obsevaciones,
                 al_id_almacen_ep,
                 al_id_tipo_almacen,
                 al_cerrado,
                 al_id_unidad_organizacional,
                 al_costeo_obligatorio
            );   
           
           
           --RAC 03/12/2016
           -- recupera parametro gestion vigente
            SELECT id_parametro_almacen
            INTO g_id_parametro_almacen
            FROM almin.tal_parametro_almacen
            WHERE cierre = 'no';
            
            -- crea parametro almacen logico
            INSERT INTO almin.tal_parametro_almacen_logico(
                id_almacen_logico,
                id_parametro_almacen,
                estado
                        ) VALUES (
                 g_id_almacen_logico,
                 g_id_parametro_almacen,
                 'abierto'
            );
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en almin.tal_almacen_logico';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
   
        END;
        
  --procedimiento de modificacion 
  --------------------------------------------------------------------------------
  ELSIF pm_codigo_procedimiento = 'AL_ALMLOG_UPD' THEN

        BEGIN
    
            --VERIFICA EXISTENCIA DEL REGISTRO
                                      
            IF NOT EXISTS(SELECT 1 FROM almin.tal_almacen_logico
                          WHERE id_almacen_logico = al_id_almacen_logico) THEN
                              
                g_descripcion_log_error := 'Modificación no realizada: almacen_logico no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF; 
            -----recuperamos datos de almacen ep cerrado bloqueado
            /*g_cerrado_almacen_ep:=cerrado FROM almin.tal_almacen_ep WHERE almin.tal_almacen_ep.id_almacen_ep=almin.tal_almacen_logico.id_almacen_ep;
            g_bloqueado_almacen_ep:=bloqueado FROM almin.tal_almacen_ep WHERE almin.tal_almacen_ep.id_almacen_ep=almin.tal_almacen_logico.id_almacen_ep;
            
             IF g_cerrado_almacen_ep='si' OR g_bloqueado_almacen_ep='si' THEN
                  g_descripcion_log_error := 'No se puede relizar ninguna modificacion ya que el ALMACEN EP ESTA CERRADO';
                  g_respuesta := 't'||g_separador||g_descripcion_log_error; 
             ELSE*/  
                    
             g_cod_almacen_logico:=codigo from almin.tal_almacen_logico where almin.tal_almacen_logico.id_almacen_logico=al_id_almacen_logico;          
             IF upper(g_cod_almacen_logico) = upper(al_codigo) THEN 
               
               UPDATE almin.tal_almacen_logico SET
                            codigo          =upper(al_codigo),
                             bloqueado       =al_bloqueado,
                             nombre          =al_nombre,
                             descripcion     =al_descripcion,
                            fecha_reg       =al_fecha_reg,
                            obsevaciones    =al_obsevaciones,
                            id_almacen_ep   =al_id_almacen_ep,
                            id_tipo_almacen =al_id_tipo_almacen,
                            cerrado         =al_cerrado,
                            id_unidad_organizacional = al_id_unidad_organizacional,
                            costeo_obligatorio = al_costeo_obligatorio

               WHERE almin.tal_almacen_logico.id_almacen_logico = al_id_almacen_logico;
                g_descripcion_log_error := 'Modificacion exitosa de almacen_logico';
                g_respuesta := 't'||g_separador||g_descripcion_log_error;
                
              ELSE
              
                  IF EXISTS(SELECT 1 FROM almin.tal_almacen_logico
                     INNER JOIN almin.tal_kardex_logico ON almin.tal_almacen_logico.id_almacen_logico = almin.tal_kardex_logico.id_almacen_logico
                     inner join almin.tal_parametro_almacen paralm on paralm.id_parametro_almacen= almin.tal_kardex_logico.id_parametro_almacen and paralm.cierre='no'
                     WHERE almin.tal_almacen_logico.id_almacen_logico = al_id_almacen_logico) THEN
                     g_nivel_error := '4';
                     g_descripcion_log_error := 'Actualizacion no realizada: El almacen_logico tiene grupos asociados';
                     g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                     RETURN 'f'||g_separador||g_respuesta;
                  ELSE
                      IF EXISTS(SELECT 1 FROM almin.tal_almacen_logico
                         WHERE codigo = upper(al_codigo)) THEN
                         g_descripcion_log_error := 'Modificacion no realizada: Código Duplicado';
                         g_nivel_error := '4';
                         g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                         RETURN 'f'||g_separador||g_respuesta;
                      ELSE
                         UPDATE almin.tal_almacen_logico SET
                            codigo          =upper(al_codigo),
                             bloqueado       =al_bloqueado,
                             nombre          =al_nombre,
                             descripcion     =al_descripcion,
                            fecha_reg       =al_fecha_reg,
                            obsevaciones    =al_obsevaciones,
                            id_almacen_ep   =al_id_almacen_ep,
                            id_tipo_almacen =al_id_tipo_almacen,
                            cerrado         =al_cerrado,
                            id_unidad_organizacional = al_id_unidad_organizacional,
                            costeo_obligatorio   =  al_costeo_obligatorio
                         WHERE almin.tal_almacen_logico.id_almacen_logico = al_id_almacen_logico;
                         g_descripcion_log_error := 'Modificación exitosa de almacen_logico';
                         g_respuesta := 't'||g_separador||g_descripcion_log_error;
                      END IF;     
                  END IF; 
              END IF; 
          -- END IF;-----
       END;
     
        
   --------------------------------------------------------------------------------       
        ELSIF pm_codigo_procedimiento = 'AL_ALMLOG_DEL' THEN
        
    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_almacen_logico
                          WHERE almin.tal_almacen_logico.id_almacen_logico=al_id_almacen_logico) THEN
                              
                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en almin.tal_almacen_logico inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

         
         
         -- BORRADO DE DATO
            DELETE FROM almin.tal_almacen_logico WHERE almin.tal_almacen_logico.id_almacen_logico = al_id_almacen_logico;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en almin.tal_almacen_logico';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    ELSE
        --PROCEDIMIENTO INEXISTENTE
        g_nivel_error := '2';
        g_descripcion_log_error := 'Procedimiento inexistente';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
        
        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                            pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                            pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
        
    END IF;

    ---*** REGISTRO EN EL LOG EL ÉXITO DE LA EJECUIÓN DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÚMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
        g_mensaje_error := SQLERRM ;
        g_numero_error := SQLSTATE;
    
        -- SE REGISTRA EL ERROR OCURRIDO
        g_reg_error:= sss.f_tsg_registro_evento (pm_id_usuario            ,g_id_subsistema          ,g_id_lugar         ,g_mensaje_error,
                                             pm_ip_origen             ,pm_mac_maquina           ,'error'            ,g_numero_error,
                                             pm_codigo_procedimiento  ,pm_proc_almacenado);
                                             
        --SE DEVUELVE EL MENSAJE DE ERROR
        g_nivel_error := '1';
        g_descripcion_log_error := g_numero_error || ' - ' || g_mensaje_error;
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_error;         
    END;
    
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;