<?php
function crearArchivo_BDIud($direccion,$table,$prefijo,$codigo,$meta){



	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$fecha=date("Y-m-d H:i:s");

	$table = "t".strtolower($prefijo)."_".$table;
	$fp_handler=fopen("$direccion/f_".$table."_iud.sql","w+");
	

	$sql = "
	CREATE OR REPLACE FUNCTION \"public\".\"f_".$table."_iud\" (
		pm_id_usuario integer,
		pm_ip_origen varchar,
		pm_mac_maquina macaddr,
		pm_codigo_procedimiento varchar,
		pm_proc_almacenado varchar,\n";

	for($i=0;$i<=$num_campos -2; $i ++){
		$sql.= "\t\t".strtolower($prefijo)."_".$meta[$i]["campo"]."  ".$meta[$i]["type"].",\n";
	}
	$sql.= "\t\t".strtolower($prefijo)."_".$meta[$i]["campo"]."  ".$meta[$i]["type"]."\n";

	$sql.= ")
		RETURNS varchar AS
\$body\$



/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		f_".$table."_iud
 DESCRIPCIÓN: 	Permite registrar en la tabla ".$table."
 AUTOR: 		(generado automaticamente)
 FECHA:			".$fecha."
 COMENTARIOS:	
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

    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NÚMERO DE ERROR
    g_mensaje_error            varchar; -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento boolean; -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÓN
    g_descripcion_log_error    text;    -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento               varchar; --boolean;
    g_reg_error                varchar; --boolean;
    g_respuesta                varchar; -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÓN
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR LÓGICO (CRÍTICO) = 2
                                        --      ERROR LÓGICO (INTERMEDIO) = 3
                                        --      ERROR LÓGICO (ADVERTENCIA) = 4
    
    g_nombre_funcion           varchar; --NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                varchar(10); --Caracteres que servirán para separar el mensaje, nivel y origen del error
    
BEGIN


---*** INICIACIÓN DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'f_".$table."_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÓN DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM tsg_metaproceso
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÓN DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACIÓN DE LLAMADA POR USUARIO O FUNCIÓN
    IF pm_proc_almacenado IS NOT NULL THEN
        IF NOT EXISTS(SELECT 1 FROM pg_proc WHERE proname = pm_proc_almacenado) THEN
            g_descripcion_log_error := 'Procedimiento ejecutor inexistente';
            g_nivel_error := '2';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            
            --REGISTRA EL LOG
            g_reg_evento:= f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
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
       g_privilegio_procedimiento := f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;


    ---*** SI NO SE TIENE PERMISOS DE EJECUCIÓN SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecución del procedimiento';
        g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    
      --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    IF pm_codigo_procedimiento = '".strtoupper($prefijo)."_".$codigo."_INS' THEN

        BEGIN
        	
            INSERT INTO ".$table."(\n";


	for($i=1;$i<=$num_campos -2; $i ++){
		$sql.= "\t\t".$meta[$i]["campo"].",\n";
	}
	$sql.= "\t\t".$meta[$i]["campo"]."
		        ) VALUES (\n";

	for($i=1;$i<=$num_campos -2; $i ++){
		if($meta[$i]["campo"] !="fecha_reg"){
			$sql.= "\t\t ".strtolower($prefijo)."_".$meta[$i]["campo"].",\n";
		}
		else{
			$sql.= "\t\t now(),\n";
		}
	}

	if($meta[$i]["campo"] !="fecha_reg"){
		$sql.= "\t\t".strtolower($prefijo)."_".$meta[$i]["campo"]."\n";
	}
	else{
		$sql.= "\t\t now()\n";
	}

	$sql.= "
            );   
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en ".$table."';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
   
        END;
        
  --procedimiento de modificacion      
        
   ELSIF pm_codigo_procedimiento = '".strtoupper($prefijo)."_".$codigo."_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM ".$table."
                          WHERE ".$table.".".$meta[0]["campo"]."=".strtolower($prefijo)."_".$meta[0]["campo"].") THEN
                              
                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de ".$table."no existente';
                g_nivel_error := '4';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

            UPDATE ".$table." SET \n";
	
	for($i=1;$i<=$num_campos -2; $i ++){
		$sql.= "\t\t".$meta[$i]["campo"]."=".strtolower($prefijo)."_".$meta[$i]["campo"].",\n";
	}
	$sql.= "\t\t".$meta[$i]["campo"]."=".strtolower($prefijo)."_".$meta[$i]["campo"]."\n";
	
	$sql.="
				WHERE ".$table.".".$meta[0]["campo"]."= ".strtolower($prefijo)."_".$meta[0]["campo"].";

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en ".$table."';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = '".strtoupper($prefijo)."_".$codigo."_DEL' THEN
        
    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM ".$table."
                          WHERE ".$table.".".$meta[0]["campo"]."=".strtolower($prefijo)."_".$meta[0]["campo"].") THEN
                              
                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en ".$table." inexistente';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

 			-- VERIFICACIÓN DE EXISTENCIA DE HIJOS
         --   IF EXISTS(SELECT 1 FROM ".$table."
         --            INNER JOIN tal_id1 ON ".$table.".id_subgrupo = tal_id1.id_subgrupo
         --            WHERE ".$table.".".$meta[0]["campo"]." = ".strtolower($prefijo)."_".$meta[0]["campo"].") THEN
         --            
         --       g_nivel_error := '4';
         --       g_descripcion_log_error := 'Eliminación no realizada: El registro en ".$table." tiene regitros asociados en XXX';
         --       g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
         --      RETURN 'f'||g_separador||g_respuesta;
                
         --   END IF;   
         
         -- BORRADO DE DATO
            DELETE FROM ".$table." WHERE ".$table.".".$meta[0]["campo"]." = ".strtolower($prefijo)."_".$meta[0]["campo"].";

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en ".$table."';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    ELSE
        --PROCEDIMIENTO INEXISTENTE
        g_nivel_error := '2';
        g_descripcion_log_error := 'Procedimiento inexistente';
        g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
        
        --REGISTRA EL LOG
        g_reg_evento:= f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                            pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                            pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
        
    END IF;

    ---*** REGISTRO EN EL LOG EL ÉXITO DE LA EJECUIÓN DEL PROCEDIMIENTO
    g_reg_evento:= f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
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
        g_reg_error:= f_tsg_registro_evento (pm_id_usuario            ,g_id_subsistema          ,g_id_lugar         ,g_mensaje_error,
                                             pm_ip_origen             ,pm_mac_maquina           ,'error'            ,g_numero_error,
                                             pm_codigo_procedimiento  ,pm_proc_almacenado);
                                             
        --SE DEVUELVE EL MENSAJE DE ERROR
        g_nivel_error := '1';
        g_descripcion_log_error := g_numero_error || ' - ' || g_mensaje_error;
        g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_error;         
    END;
    
END;
\$body$
LANGUAGE 'plpgsql' VOLATILE CALLED ON NULL INPUT SECURITY INVOKER;";

	fwrite($fp_handler,$sql);
	fclose($fp_handler);
}
?>