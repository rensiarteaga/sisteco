--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_movimiento_proyecto_sel (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  pm_cant integer,
  pm_puntero integer,
  pm_sortcol varchar,
  pm_sortdir varchar,
  pm_criterio_filtro varchar,
  pm_id_financiador varchar,
  pm_id_regional varchar,
  pm_id_programa varchar,
  pm_id_proyecto varchar,
  pm_id_actividad varchar
)
RETURNS SETOF record AS
$body$
/************************************************************************** SISTEMA ENDESIS - SISTEMA DE ALMACEN***************************************************************************
 SCRIPT:          alma.f_tai_movimiento_proyecto_sel
 DESCRIPCION:     Devuelve las consultas a la tabla alma.tai_movimiento_proyecto
 AUTOR:           UNKNOW
 FECHA:           23-10-2014
 COMENTARIOS:    

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCION --
--------------------------

-- PARAMETROS FIJOS
/*
pm_id_usuario                               integer (si))
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
pm_cant
pm_puntero
pm_sortcol
pm_sortdir
pm_criterio_filtro
pm_id_financiador
pm_id_regional
pm_id_programa
pm_id_proyecto
pm_id_actividad

*/

-- DECLARACION DE VARIABLES PARTICULARES


-- DECLARACION DE VARIABLES DE LA FUNCION (LOCALES)

DECLARE

    --PAR√ÅMETROS FIJOS
    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NMERO DE ERROR
    g_mensaje_error            varchar; -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento boolean; -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
    g_descripcion_log_error    text;    -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento               boolean;
    g_reg_error                boolean;
    g_registros                record;  -- PARA ALMACENAR EL CONJUNTO DE DATOS RESULTADO DEL SELECT
    g_respuesta                varchar; -- VARIABLE QUE CONTENDR√Å LOS MENSAJES DE ERROR
    g_consulta                 text;    -- VARIABLE QUE CONTENDR√Å LA CONSULTA DIN√ÅMICA PARA EL FILTRO
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR L√?GICO (CR√çTICO) = 2
                                        --      ERROR L√?GICO (INTERMEDIO) = 3
                                        --      ERROR L√?GICO (ADVERTENCIA) = 4
    g_nombre_funcion           varchar; --NOMBRE F√çSICO DE LA FUNC
    g_separador                varchar(10); --Caracteres que servipara separar el mensaje, nivel y origen del error
    g_rol_adm		           boolean;	-- Identifica si el usuario tiene rol administrador
	 

BEGIN

    ---*** INICIACI√?N DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funci√≥n
    g_nombre_funcion := 'f_tai_movimiento_proyecto_sel';
    
    ---*** VERIFICACI√?N ROL ADMINISTRADOR
    IF EXISTS(SELECT 1 FROM sss.tsg_usuario_rol usrol WHERE usrol.id_usuario = pm_id_usuario AND usrol.id_rol=1) THEN
        g_rol_adm := true;
    END IF;
    
    ---*** OBTENCI√?N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;

    ---*** OBTENCI√?N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT sss.tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  sss.tsg_usuario_lugar.id_usuario = pm_id_usuario;


    ---***E LLAMADA POR USUARIO O FUNCI√?N
    IF pm_proc_almacenado IS NOT NULL THEN
        IF NOT EXISTS(SELECT 1 FROM pg_proc WHERE proname = pm_proc_almacenado) THEN
            g_descripcion_log_error := 'Procedimiento ejecutor inexistente';
            g_nivel_error := '2';
            g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            
            --REGISTRA EL LOG
            g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                pm_codigo_procedimiento   ,pm_proc_almacenado);
            --DEVUELVE MENSAJE DE ERROR
            RAISE EXCEPTION '%', g_respuesta;
        ELSE
           g_privilegio_procedimiento := TRUE;
        END IF;
    END IF;

    ---***
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

    ---*** SI NO SE TIENE PERMISOS DE EJECUCI√?N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecuci√≥n del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%',g_descripcion_log_error;
    END IF; 

    IF pm_codigo_procedimiento  = 'AL_MOVPROY_SEL' THEN
        BEGIN
           g_consulta := ' SELECT  movpr.id_movimiento_proyecto,alm.id_almacen,alm.codigo||''-''||alm.nombre as desc_almacen,
                                  timov.id_tipo_movimiento,timov.tipo,timov.id_documento
                              	 ,movpr.id_contratista
                                 ,(SELECT  CASE	WHEN movpr.id_contratista IS NOT NULL THEN cont.codigo||'' - ''||(select ins2.nombre from param.tpm_institucion ins2 where ins2.id_institucion=cont.id_institucion) END) AS desc_contratista
                                 ,movpr.id_proveedor
                                 ,(SELECT CASE WHEN movpr.id_proveedor IS NOT NULL THEN prov.codigo||'' - ''||(select ins3.nombre from param.tpm_institucion ins3 where ins3.id_institucion=prov.id_institucion)END)AS desc_proveedor
                                 ,movpr.id_institucion
                                 ,(SELECT CASE WHEN movpr.id_institucion IS NOT NULL THEN (select inst.nombre from param.tpm_institucion inst where inst.id_institucion=ins.id_institucion)END)AS desc_institucion
                                 ,movpr.id_empleado
                                 ,(SELECT CASE WHEN movpr.id_empleado IS NOT NULL THEN(select COALESCE(per.apellido_paterno,'' '')||'' ''||COALESCE(per.apellido_materno,'' '')||'' ''||COALESCE(per.nombre,'' '') from sss.tsg_persona per where per.id_persona=emp.id_persona)END) AS desc_empleado
                                 ,COALESCE(to_char(movpr.fecha_ingreso,''dd-mm-yyyy''),''0'') AS fecha_ingreso 
                                 ,movpr.origen_ingreso,movpr.concepto_ingreso,movpr.observaciones,movpr.estado
                                 ,movpr.usuario_reg,COALESCE(to_char(movpr.fecha_reg,''dd-mm-yyyy''),''0'') AS fecha_reg 
                                 --aÒadido 06-01-2015
                                 ,movpr.nro_contrato,movpr.nota_remision,movpr.entregado_por
                                  --aÒadido 12-05-2015
                                 ,movpr.peso_neto
                                 ,movpr.codigo
                                 
                          FROM alma.tai_movimiento_proyecto movpr
                          INNER JOIN alma.tai_almacen alm ON alm.id_almacen=movpr.id_almacen AND alm.estado=''activo''
                          INNER JOIN alma.tai_tipo_movimiento timov ON timov.id_tipo_movimiento=movpr.id_tipo_movimiento 
                          LEFT JOIN param.tpm_contratista cont ON cont.id_contratista=movpr.id_contratista AND cont.estado_registro=''activo''
                          LEFT JOIN compro.tad_proveedor prov ON prov.id_proveedor=movpr.id_proveedor
                          LEFT JOIN param.tpm_institucion ins ON ins.id_institucion=movpr.id_institucion AND ins.estado_institucion=''activo'' 
                          LEFT JOIN kard.tkp_empleado emp ON emp.id_empleado=movpr.id_empleado AND emp.estado_reg=''activo''  
                          WHERE  ';
            g_consulta := g_consulta || pm_criterio_filtro;
			-- SE AUMENTA EL ORDEN Y LOS PAR√ÅMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol||' '||pm_sortdir;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
           FOR g_registros in      EXECUTE (g_consulta)
           LOOP
              RETURN NEXT g_registros;
           END LOOP;

      -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
      g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
        
  
    ELSIF pm_codigo_procedimiento  = 'AL_MOVPROY_COUNT' THEN
	BEGIN        
        --Cuenta todos los registros
            g_consulta := 	' SELECT 	count(movpr.id_movimiento_proyecto) as total
            				  FROM alma.tai_movimiento_proyecto movpr
                              INNER JOIN alma.tai_almacen alm ON alm.id_almacen=movpr.id_almacen AND alm.estado=''activo''
                              INNER JOIN alma.tai_tipo_movimiento timov ON timov.id_tipo_movimiento=movpr.id_tipo_movimiento 
                              LEFT JOIN param.tpm_contratista cont ON cont.id_contratista=movpr.id_contratista AND cont.estado_registro=''activo''
                              LEFT JOIN compro.tad_proveedor prov ON prov.id_proveedor=movpr.id_proveedor
                              LEFT JOIN param.tpm_institucion ins ON ins.id_institucion=movpr.id_institucion AND ins.estado_institucion=''activo'' 
                              LEFT JOIN kard.tkp_empleado emp ON emp.id_empleado=movpr.id_empleado AND emp.estado_reg=''activo'' 
                              WHERE  ';				

            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

           
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;  
ELSE
        --Procedimiento inexistente
        g_nivel_error := '2';
        g_descripcion_log_error := 'Procedimiento inexistente';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                            pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                            pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%', g_respuesta;
    END IF;


   
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);


    ---*** SE DEVUELVE EL CONJUNTO DE DATOS
    RETURN;


EXCEPTION

    WHEN others THEN BEGIN
    
        --SE OBTIENE EL MENSAJE Y EL N√MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
        g_mensaje_error:=SQLERRM;
        g_numero_error:=SQLSTATE;
        g_reg_error:= sss.f_tsg_registro_evento (pm_id_usuario            ,g_id_subsistema          ,g_id_lugar         ,g_mensaje_error,
                                             pm_ip_origen             ,pm_mac_maquina           ,'error'            ,g_numero_error,
                                             pm_codigo_procedimiento  ,pm_proc_almacenado);

        --SE DEVUELVE EL MENSAJE DE ERROR
        g_nivel_error := '1';
        g_descripcion_log_error := g_numero_error || ' - ' || g_mensaje_error;
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        RAISE EXCEPTION '%', 'f' || g_separador || g_respuesta;

    END;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;