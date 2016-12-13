--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_obtener_correlativo (
  al_codigo varchar,
  al_mes varchar,
  al_id_almacen_logico integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS
***************************************************************************
 SCRITP: 		almin.f_al_obtener_correlativo
 DESCRIPCION: 	Función que devuelve el correlativo actual
 AUTOR: 		Rodrigo Chumacero Moscoso
 FECHA:			22-10-2007
 COMENTARIOS:	
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION:    
 AUTOR:            
 FECHA:            

***************************************************************************/

-----------------------------------------
-- CUERPO DE LA FUNCIÓN --
-----------------------------------------

DECLARE

    g_correlativo          varchar;
    g_id_parametro_almacen integer;
    g_numero_error                varchar;     -- ALMACENA EL NÚMERO DE ERROR
    g_mensaje_error               varchar;
    g_desc_error                  varchar;
    
BEGIN

    -- OBTIENE LA GESTIÓN VIGENTE
    SELECT 
        id_parametro_almacen
    INTO 
        g_id_parametro_almacen
    FROM almin.tal_parametro_almacen_logico al
    WHERE al.estado = 'abierto' and al.id_almacen_logico = al_id_almacen_logico;

    IF g_id_parametro_almacen IS NULL THEN
        RAISE EXCEPTION 'No existe Gestión Abierta de Almacen Lógico';
    END IF;
    
    --OBTIENE EL CORRELATIVO ACTUAL
    SELECT
    CORREL.valor_siguiente
    INTO g_correlativo
    FROM almin.tal_correlativo CORREL
    WHERE CORREL.codigo = al_codigo
    AND CORREL.mes = al_mes
    AND CORREL.id_parametro_almacen = g_id_parametro_almacen
    AND CORREL.id_almacen_logico = al_id_almacen_logico;
    
    --SI NO HAY EL CORRELATIVO, SE LOS CREA
    IF g_correlativo IS NULL THEN
    	INSERT INTO almin.tal_correlativo(
        codigo 		,prefijo 				,sufijo ,valor_actual 		,valor_siguiente,
        incremento 	,id_parametro_almacen 	,mes 	,id_almacen_logico
        ) VALUES(
        al_codigo	,NULL					,NULL	,0					,1,
        1			,g_id_parametro_almacen	,al_mes	,al_id_almacen_logico
        );
        
        --OBTIENE EL CORRELATIVO ACTUAL
    	SELECT
    	CORREL.valor_siguiente
    	INTO g_correlativo
    	FROM almin.tal_correlativo CORREL
    	WHERE CORREL.codigo = al_codigo
    	AND CORREL.mes = al_mes
    	AND CORREL.id_parametro_almacen = g_id_parametro_almacen
    	AND CORREL.id_almacen_logico = al_id_almacen_logico;
    END IF;
    
    -- DEVUELVE CORRELATIVO CON 3 DIGITOS    
    WHILE length(g_correlativo) < 3 LOOP
        IF length(g_correlativo) <3 THEN
            g_correlativo = '0' || g_correlativo;
        END IF;
    END LOOP;
    
    g_correlativo = al_mes || g_correlativo;
    
    --DEVUELVE EL CORRELATIVO
    RETURN g_correlativo;

EXCEPTION

    WHEN others THEN BEGIN   
    
        /*g_mensaje_error := SQLERRM ;
        g_numero_error := SQLSTATE;

        --SE DEVUELVE EL MENSAJE DE ERROR
        g_desc_error := g_numero_error || ' - ' || g_mensaje_error;
        RETURN g_desc_error; */
        RETURN -1;

    END;
    
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;