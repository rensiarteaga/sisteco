--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_tipo_unidad_constructiva_arb_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id integer,
  al_id_padre integer,
  al_tipo varchar,
  al_codigo varchar,
  al_nombre varchar,
  al_descripcion varchar,
  al_observaciones varchar,
  al_cantidad numeric,
  al_opcional varchar,
  al_considerar_repeticion varchar,
  al_id_padre_nuevo integer,
  al_estado varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		almin.f_tal_tipo_unidad_constructiva_arb_iud
 DESCRIPCIÓN: 	Permite guardar, modificar, eliminar tipos de unidad constructiva, y sus composiciones
 AUTOR: 		Rodrigo Chumacero Moscoso
 FECHA:			2007-12-12 11:30
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
    g_id_fina_regi_prog_proy_acti integer;     -- VARIABLE DE LA ESTRUCTURA PROGRAMÁTICA
    g_id                          integer;
    g_id_padre                    integer;
    g_opcional                    varchar;
    g_cantidad                    numeric;
    g_considerar_repeticion       varchar;
    g_descripcion                 varchar;
    g_id_tipo_unidad_constructiva integer;
    g_tipo_agrup                  varchar;
    g_terminado                   varchar;
    g_id_comp                     integer;
    al_id_salida		integer;

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_tipo_unidad_constructiva_arb_iud';
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
      IF pm_codigo_procedimiento = 'AL_TUCAGR_INS' THEN --TUCAGR :Tipo Unidad Constructiva Agrupador

        BEGIN

            SELECT NEXTVAL('almin.tal_tipo_unidad_constructiva_id_tipo_unidad_constructiva_seq') INTO g_id;
        	
            INSERT INTO almin.tal_tipo_unidad_constructiva(
		    id_tipo_unidad_constructiva  ,codigo            ,nombre      ,tipo,
            descripcion                  ,observaciones     ,fecha_reg
		    ) VALUES (
		    g_id                         ,al_codigo         ,al_nombre   ,'Agrupador',
            al_descripcion               ,al_observaciones  ,now()
            );
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso del agrupador';
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_id;

        END;
    ELSIF pm_codigo_procedimiento = 'AL_TIPOUC_INS' THEN --TIPOUC :Tipo Unidad Constructiva

        BEGIN

            SELECT NEXTVAL('almin.tal_tipo_unidad_constructiva_id_tipo_unidad_constructiva_seq') INTO g_id;
        	
            --INSERTA EL TIPO DE UNIDAD CONSTRUCTIVA
            INSERT INTO almin.tal_tipo_unidad_constructiva(
		    id_tipo_unidad_constructiva  ,codigo            ,nombre      ,tipo,
            descripcion                  ,observaciones     ,fecha_reg
		    ) VALUES (
		    g_id                         ,al_codigo         ,al_nombre   ,al_tipo,
            al_descripcion               ,al_observaciones  ,now()
            );

--raise exception 'padreeee: %',al_id_padre;
            --CREA LA COMPOSICIÓN CON SU AGRUPADOR
            INSERT INTO almin.tal_composicion_tuc(
            cantidad    ,opcional    ,id_tuc_hijo   ,id_tipo_unidad_constructiva
            ) VALUES(
            1           ,'si'        ,g_id          ,al_id_padre
            );


            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en almin.tal_tipo_unidad_constructiva';
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_id;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_TIPOUC_UPD' THEN  --TIPOUC: Tipo Unidad Constructiva

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva=al_id) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_tipo_unidad_constructiva no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            UPDATE almin.tal_tipo_unidad_constructiva SET
		    codigo        = al_codigo,
		    nombre        = al_nombre,
		    descripcion   = al_descripcion,
		    observaciones = al_observaciones
			WHERE id_tipo_unidad_constructiva = al_id;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_tipo_unidad_constructiva';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_TIPOUC_DEL' THEN --TIPOUC: Tipo Unidad Constructiva
        --Elimina el registro del Tipo de Unidad Constructiva
        BEGIN

            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: Tipo de Unidad Constructiva inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF al_id_padre IS NOT NULL THEN
                IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                              WHERE id_tipo_unidad_constructiva = al_id_padre) THEN

                    g_nivel_error := '4';
                    g_descripcion_log_error := 'Eliminación no realizada: Padre del Tipo de Unidad Constructiva inexistente';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;

                END IF;
            END IF;

            --SI ES UN AGRUPADOR Y ESTÁ VACÍO LO ELIMINA
            IF EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                      WHERE id_tipo_unidad_constructiva = al_id
                      AND tipo = 'Agrupador') THEN

                IF NOT EXISTS(SELECT 1 FROM almin.tal_composicion_tuc
                          WHERE id_tipo_unidad_constructiva = al_id) THEN

                    --NO TIENE NINGUNA COMPOSICIÓN, POR TANTO SE ELIMINA EL TUC AGRUPADOR
                    DELETE FROM almin.tal_tipo_unidad_constructiva
                    WHERE id_tipo_unidad_constructiva = al_id;

                ELSE
                    g_nivel_error := '4';
                    g_descripcion_log_error := 'Eliminación no realizada: El agrupador contiene Tipos de Unidades Constructivas';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                END IF;

            END IF;

            --SE VERIFICA SI EL PADRE ESTÁ TERMINADO (SI ES QUE EL PADRE NO ES UN AGRUPADOR), DE SER ASÍ NO HACE NADA
            SELECT tipo
            INTO g_tipo_agrup
            FROM almin.tal_tipo_unidad_constructiva
            WHERE id_tipo_unidad_constructiva = al_id_padre;

            IF g_tipo_agrup <> 'Basurero' OR g_tipo_agrup <> 'Obsoletos' THEN

                IF EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id_padre
                         AND estado = 'Terminado') THEN

                    g_nivel_error := '4';
                    g_descripcion_log_error := 'Eliminación no realizada: El Tipo de Unidad Constructiva padre está Bloqueado y no puede hacerse ningún cambio';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;

                END IF;

            END IF;


            -- SE VERIFICA SI EL TUC ESTÁ TERMINADO O NO
            SELECT estado
            INTO g_terminado
            FROM almin.tal_tipo_unidad_constructiva
            WHERE id_tipo_unidad_constructiva = al_id;

            -- SE DEFINE SI VA A OBSOLETOS O BASURERO
            IF g_terminado = 'Terminado' THEN
                g_tipo_agrup = 'Obsoletos';
            ELSE
                g_tipo_agrup = 'Basurero';
            END IF;

            --VERIFICA SI TIENE COMPOSICIÓN
            IF EXISTS(SELECT 1
                      FROM almin.tal_composicion_tuc
                      WHERE id_tipo_unidad_constructiva = al_id) THEN

                --SE VERIFICA SI EL TUC FORMA PARTE DE OTRAS COMPOSICIONES A PARTE DE LA INICIAL
                IF EXISTS(SELECT 1
                          FROM almin.tal_composicion_tuc
                          WHERE id_tuc_hijo = al_id
                          AND id_tipo_unidad_constructiva <> al_id_padre) THEN

                    -- FORMA PARTE DE OTRAS COMPOSICIONES, ENTONCES SOLO SE BORRA LA COMPOSICIÓN DE LA COMPOSICIÓN INICIAL
                    DELETE FROM almin.tal_composicion_tuc
                    WHERE id_tuc_hijo = al_id
                    AND id_tipo_unidad_constructiva = al_id_padre;

                ELSE

                    -- NO FORMA PARTE DE OTRA COMPOSICIÓN, POR LO QUE SE BORRA LA COMPOSICIÓN INICIAL Y SE LO MANDA A BASURERO U OBSOLETOS
                    DELETE FROM almin.tal_composicion_tuc
                    WHERE id_tuc_hijo = al_id
                    AND id_tipo_unidad_constructiva = al_id_padre;

                    --OBTIENE EL ID DEL AGRUPADOR
                    SELECT id_tipo_unidad_constructiva
                    INTO g_id_tipo_unidad_constructiva
                    FROM almin.tal_tipo_unidad_constructiva
                    WHERE codigo = g_tipo_agrup;

                    --LLEVA EL TUC AL AGRUPADOR
                    INSERT INTO almin.tal_composicion_tuc(
                    cantidad  ,opcional  ,id_tuc_hijo  ,id_tipo_unidad_constructiva
                    ) VALUES(
                    1         ,'no'      ,al_id        ,g_id_tipo_unidad_constructiva
                    );

                END IF;

            ELSE
            --EL TUC NO TIENE NINGUNA COMPOSICIÓN, SE VERIFICA FORMA PARTE DE OTRA COMPOSICIÓN
                IF EXISTS(SELECT 1
                          FROM almin.tal_composicion_tuc
                          WHERE id_tuc_hijo = al_id
                          AND id_tipo_unidad_constructiva <> al_id_padre) THEN

                    --PERTENECE A OTRA COMPOSICIÓN POR LO QUE SOLO SE BORRA LA COMPOSICIÓN INICIAL
                    DELETE FROM almin.tal_composicion_tuc
                    WHERE id_tuc_hijo = al_id
                    AND id_tipo_unidad_constructiva = al_id_padre;

                ELSE
                    --NO PERTENCE A OTRA COMPOSICIÓN, VERIFICA SI TIENE COMPONENTES
                    IF EXISTS(SELECT 1 FROM almin.tal_componente
                          WHERE id_tipo_unidad_constructiva = al_id) THEN
                        --TIENE COMPONENTES. SE MANDA EL TUC A LA PAPELERA

                        --ELIMINACIÓN DE LA COMPOSICIÓN ANTERIOR
                        DELETE FROM almin.tal_composicion_tuc WHERE id_tuc_hijo = al_id AND id_tipo_unidad_constructiva = al_id_padre;

                        --SE OBTIENE EL ID DEL AGRUPADOR BASURERO PARA MANDAR EL TUC AL BASURERO
                        SELECT id_tipo_unidad_constructiva
                        INTO g_id_tipo_unidad_constructiva
                        FROM almin.tal_tipo_unidad_constructiva
                        WHERE codigo = g_tipo_agrup;

                        INSERT INTO almin.tal_composicion_tuc(
                        cantidad  ,opcional  ,id_tuc_hijo  ,id_tipo_unidad_constructiva
                        ) VALUES(
                        1         ,'no'      ,al_id        ,g_id_tipo_unidad_constructiva
                        );

                    ELSE

                        --NO TIENE COMPONENTES. SE ELIMINA EL TUC FÍSICAMENTE
                        DELETE FROM almin.tal_composicion_tuc WHERE id_tuc_hijo = al_id AND id_tipo_unidad_constructiva = al_id_padre;
                        DELETE FROM almin.tal_tipo_unidad_constructiva WHERE id_tipo_unidad_constructiva = al_id;

                    END IF;

                END IF;




            END IF;

            -- BORRADO DEL REGISTRO
            --DELETE FROM almin.tal_tipo_unidad_constructiva WHERE id_tipo_unidad_constructiva = al_id;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa de la composición';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    ELSIF pm_codigo_procedimiento = 'AL_TUCAGR_DEL' THEN --TUCAGR: Tipo Unidad Constructiva Agrupador
        --Elimina el registro del Tipo de Unidad Constructiva
        BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: Agrupador inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            IF EXISTS(SELECT 1
                      FROM almin.tal_composicion_tuc
                      WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: El Grupo contiene Tipos de Unidades Constructivas';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            -- BORRADO DEL REGISTRO
            DELETE FROM almin.tal_tipo_unidad_constructiva WHERE id_tipo_unidad_constructiva = al_id;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa de la composición';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    ELSIF pm_codigo_procedimiento = 'AL_TIPOUC_BAS' THEN --TIPOUC_BAS: Tipo Unidad Constructiva _ Basurero
        --Manda al tipo de unidad constructiva al Basurero
        BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: composición inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            IF EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                      WHERE id_tipo_unidad_constructiva = al_id
                      AND tipo = 'Agrupador') THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: no se puede eliminar un Agrupador';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            -- SI EL TUC ESTÁ TERMINADO, SE LO MANDA A OBSOLETOS; CASO CONTRARIO A LA PAPELERA
            IF EXISTS(SELECT 1
                      FROM almin.tal_tipo_unidad_constructiva
                      WHERE id_tipo_unidad_constructiva = al_id
                      AND estado = 'Terminado') THEN

                --OBTIENE EL ID DEL AGRUPADOR OBSOLETOS
                SELECT id_tipo_unidad_constructiva
                INTO g_id_tipo_unidad_constructiva
                FROM almin.tal_tipo_unidad_constructiva
                WHERE codigo = 'Obsoletos';

                INSERT INTO almin.tal_composicion_tuc(
                cantidad    ,opcional    ,id_tuc_hijo  ,id_tipo_unidad_constructiva
                ) VALUES(
                1           ,'si'        ,al_id        ,g_id_tipo_unidad_constructiva
                );

            ELSE
                --OBTIENE EL ID DE LA PAPELERA DE RECICLAJE
                SELECT id_tipo_unidad_constructiva
                INTO g_id_tipo_unidad_constructiva
                FROM almin.tal_tipo_unidad_constructiva
                WHERE codigo = 'Basurero';

                -- CREA LA COMPOSICIÓN DEL TUC A BORRAR ENLA PAPELERA DE RECICLAJE
                INSERT INTO almin.tal_composicion_tuc(
                cantidad    ,opcional    ,id_tuc_hijo  ,id_tipo_unidad_constructiva
                ) VALUES(
                1           ,'si'        ,al_id        ,g_id_tipo_unidad_constructiva
                );

                --ACTUALIZA EL TIPO DE LA TUC A RAMA
                /*UPDATE almin.tal_tipo_unidad_constructiva SET
                tipo = 'Rama'
                WHERE id_tipo_unidad_constructiva = al_id;*/
            END IF;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa de la composición';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_COMTUC_INS' THEN --COMTUC: Composición Tipo Unidad Constructiva
    -- INSERTA UNA NUEVA COMPOSICIÓN
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_descripcion_log_error := 'Composición no realizada: No existe el Tipo de Unidad Constructiva Hijo';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id_padre) THEN

                g_descripcion_log_error := 'Composición no realizada: No existe el Tipo de Unidad Constructiva Padre';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            INSERT INTO almin.tal_composicion_tuc(
            cantidad    ,opcional    ,id_tuc_hijo  ,id_tipo_unidad_constructiva
            ) VALUES(
            al_cantidad ,al_opcional ,al_id        ,al_id_padre
            );

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Composición creada con éxito';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_COMTUC_UPD' THEN --COMTUC: Composición Tipo Unidad Constructiva
    --MODIFICA UNA COMPOSICIÓN EXISTENTE
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_composicion_tuc
                          WHERE id_tuc_hijo = al_id
                          AND id_tipo_unidad_constructiva = al_id_padre) THEN

                g_descripcion_log_error := 'Modificación no realizada: Composición inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --MODIFICACIÓN DEL TIPO DE UNIDAD CONSTRUCTIVA
            UPDATE almin.tal_tipo_unidad_constructiva SET
		    codigo        = al_codigo,
		    nombre        = al_nombre,
		    tipo          = al_tipo,
		    descripcion   = al_descripcion,
		    observaciones = al_observaciones
			WHERE id_tipo_unidad_constructiva = al_id;

            --MODIFICACIÓN DE LA COMPOSICIÓN
            UPDATE almin.tal_composicion_tuc SET
		    cantidad = al_cantidad,
		    opcional = al_opcional
			WHERE id_tuc_hijo = al_id
            AND id_tipo_unidad_constructiva = al_id_padre;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_tipo_unidad_constructiva';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_COMTUC_DEL' THEN --COMTUC: Composición Tipo Unidad Constructiva
        --Elimina el registro de la composición
        BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_composicion_tuc
                          WHERE id_tuc_hijo = al_id
                          AND id_tipo_unidad_constructiva = al_id_padre) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: composición inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            -- BORRADO DEL REGISTRO
            DELETE
            FROM almin.tal_composicion_tuc
            WHERE id_tuc_hijo = al_id
            AND id_tipo_unidad_constructiva = al_id_padre;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa de la composición';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    ELSIF pm_codigo_procedimiento = 'AL_TUCCOM_INS' THEN --TUCCOM: Tipo Unidad Constrctiva y Composición Tipo Unidad Constructiva
    -- HACE UNA INSERCIÓN DE UN TIPO DE UNIDAD CONSTRUCTIVA Y REALIZA UNA COMPOSICIÓN
        BEGIN

            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id_padre) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Inserción no realizada: Tipo de Unidad Constructiva Padre no existente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            SELECT NEXTVAL('almin.tal_tipo_unidad_constructiva_id_tipo_unidad_constructiva_seq') INTO g_id;

            -- INSERTA EL TIPO DE UNIDAD CONSTRUCTIVA	
            INSERT INTO almin.tal_tipo_unidad_constructiva(
		    id_tipo_unidad_constructiva    ,codigo            ,nombre      ,tipo,
            descripcion                    ,observaciones     ,fecha_reg
		    ) VALUES (
		    g_id                           ,al_codigo         ,al_nombre   ,al_tipo,
            al_descripcion                 ,al_observaciones  ,now()
            );

            SELECT NEXTVAL('almin.tal_composicion_tuc_id_composicion_tuc_seq') INTO g_id_comp;
            -- CREA LA COMPOSICIÓN
            INSERT INTO almin.tal_composicion_tuc(
            id_composicion_tuc  ,cantidad    ,opcional    ,id_tuc_hijo  ,id_tipo_unidad_constructiva
            ) VALUES(
            g_id_comp           ,al_cantidad ,al_opcional ,g_id         ,al_id_padre
            );

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en almin.tal_tipo_unidad_constructiva';
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_id||g_separador||g_id_comp;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_TUCCOM_UPD' THEN --TUCCOM: Tipo Unidad Constructiva y Composición Tipo Unidad Constructiva
    -- HACE UNA MODIFICACIÓN DE UN TIPO DE UNIDAD CONSTRUCTIVA Y DE UNA COMPOSICIÓN
        BEGIN

            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id_padre) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Inserción no realizada: Tipo de Unidad Constructiva Padre no existente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            -- MODIFICA EL TIPO DE UNIDAD CONSTRUCTIVA	
            UPDATE almin.tal_tipo_unidad_constructiva SET
		    codigo        = al_codigo,
		    nombre        = al_nombre,
		    tipo          = al_tipo,
		    descripcion   = al_descripcion,
		    observaciones = al_observaciones
			WHERE id_tipo_unidad_constructiva = al_id_padre;

            --MODIFICACIÓN DE LA COMPOSICIÓN
            UPDATE almin.tal_composicion_tuc SET
		    cantidad = al_cantidad,
		    opcional = al_opcional
			WHERE id_tuc_hijo = al_id
            AND id_tipo_unidad_constructiva = al_id_padre;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en almin.tal_tipo_unidad_constructiva';
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_id;

            -------------------------------------------

            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva=al_id) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_tipo_unidad_constructiva no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            IF NOT EXISTS(SELECT 1 FROM almin.tal_composicion_tuc
                          WHERE id_tuc_hijo = al_id
                          AND id_tipo_unidad_constructiva = al_id_padre) THEN

                g_descripcion_log_error := 'Modificación no realizada: Composición inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            UPDATE almin.tal_composicion_tuc SET
		    cantidad = al_cantidad,
		    opcional = al_opcional
			WHERE id_tuc_hijo = al_id
            AND id_tipo_unidad_constructiva = al_id_padre;

            UPDATE almin.tal_tipo_unidad_constructiva SET
		    codigo        = al_codigo,
		    nombre        = al_nombre,
		    tipo          = al_tipo,
		    descripcion   = al_descripcion,
		    observaciones = al_observaciones
			WHERE id_tipo_unidad_constructiva = al_id;
			
			-- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación realizada';
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_id;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_COMPON_INS' THEN --COMPON: Componente (Item de un Tipo de Unidad Constructiva)
    -- HACE UNA INSERCIÓN UN COMPONENTE DE UN TIPO DE UNIDAD CONSTRUCTIVA (ITEM)
        BEGIN

            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_item
                          WHERE id_item = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Inserción no realizada: Item no existente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id_padre) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Inserción no realizada: Tipo de Unidad Constructiva Padre no existente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            -- INSERTA EL COMPONENTE
            INSERT INTO almin.tal_componente(
		    cantidad      ,estado_registro              ,cosiderar_repeticion     ,descripcion,
		    id_item       ,id_tipo_unidad_constructiva
		    ) VALUES (
		    al_cantidad   ,'activo'                     ,al_considerar_repeticion ,al_descripcion,
		    al_id         ,al_id_padre
            );

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso del Componente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_COMPON_UPD' THEN --COMPON: Componente (Item de un Tipo de Unidad Constructiva)
    -- HACE UNA INSERCIÓN UN COMPONENTE DE UN TIPO DE UNIDAD CONSTRUCTIVA (ITEM)
        BEGIN

            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_componente
                          WHERE id_item = al_id
                          AND id_tipo_unidad_constructiva = al_id_padre) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Modificación no realizada: Componente inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
--raise exception 'considera repetición: %', al_considerar_repeticion;
--raise exception 'id_item : % -- id_tipo_uniad: %',al_id, al_id_padre;
            -- INSERTA EL COMPONENTE
            UPDATE almin.tal_componente SET
            cantidad             = al_cantidad,
            cosiderar_repeticion = al_considerar_repeticion,
            descripcion          = al_descripcion
            WHERE id_item = al_id
            AND id_tipo_unidad_constructiva = al_id_padre;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso del Componente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_COMPON_DEL' THEN --COMPON: Componente (Item de un Tipo de Unidad Constructiva)
    -- HACE UNA INSERCIÓN UN COMPONENTE DE UN TIPO DE UNIDAD CONSTRUCTIVA (ITEM)
        BEGIN

            --VERIFICA SI EXISTE EL REGISTRO
            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_componente
                          WHERE id_item = al_id
                          AND id_tipo_unidad_constructiva = al_id_padre) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: Componente inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL TUC PADRE NO ESTÁ TERMINADO
            IF EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                      WHERE id_tipo_unidad_constructiva = al_id_padre
                      AND estado = 'Terminado') THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: El Tipo de Unidad Constructiva está Bloqueado y no puede hacerse ninguna modificación';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            -- ELIMINA EL COMPONENTE
            DELETE FROM almin.tal_componente WHERE id_item = al_id AND id_tipo_unidad_constructiva = al_id_padre;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del Componente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_DRADRO_RAI' THEN --DRADRO: Drag And Drop Raíz
    --DRAG AND DROP DE UNA RAÍZ (TIPO DE UNIDAD CONSTRUCTIVA)
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_descripcion_log_error := 'Drag and drop no realizado: no existe el tipo de unidad constructiva';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id_padre_nuevo) THEN

                g_descripcion_log_error := 'Drag and Drop no realizado: Tipo de Unidad Constructiva destino inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI TUC ESTÁ TERMINADO Y SE ESTÁ ARRASTRANDO A LA PAPELERA
            IF EXISTS(SELECT 1
                      FROM almin.tal_tipo_unidad_constructiva
                      WHERE id_tipo_unidad_constructiva = al_id
                      AND estado = 'Terminado') THEN

                --OBTIENE EL ID DE LA PAPELERA
                SELECT id_tipo_unidad_constructiva
                INTO g_id_tipo_unidad_constructiva
                FROM almin.tal_tipo_unidad_constructiva
                WHERE codigo = 'Basurero';

                IF al_id_padre_nuevo = g_id_tipo_unidad_constructiva THEN
                    g_descripcion_log_error := 'Drag and Drop no realizado: El Tipo de Unidad Constructiva está Terminado, por lo cual no puede llevarse a la Papelera';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                END IF;

            END IF;

            --VERIFICA SI TUC NO ESTÁ TERMINADO Y SE ESTÁ ARRASTRANDO A LOS OBSOLETOS
            IF EXISTS(SELECT 1
                      FROM almin.tal_tipo_unidad_constructiva
                      WHERE id_tipo_unidad_constructiva = al_id
                      AND estado = 'Borrador') THEN

                --OBTIENE EL ID DE LA PAPELERA
                SELECT id_tipo_unidad_constructiva
                INTO g_id_tipo_unidad_constructiva
                FROM almin.tal_tipo_unidad_constructiva
                WHERE codigo = 'Obsoletos';

                IF al_id_padre_nuevo = g_id_tipo_unidad_constructiva THEN
                    g_descripcion_log_error := 'Drag and Drop no realizado: El Tipo de Unidad Constructiva está no terminado Terminado, por lo cual no puede llevarse a Obsoletos';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                END IF;

            END IF;

            --VERIFICA QUE LA CANTIDAD NO SEA CERO O NULA
            IF COALESCE(al_cantidad,0) = 0 THEN
                g_cantidad = 1;
            ELSE
                g_cantidad = al_cantidad;
            END IF;

            --CREA LA COMPOSICIÓN CON EL PADRE NUEVO INDICADO
            INSERT INTO almin.tal_composicion_tuc(
            cantidad    ,opcional    ,id_tuc_hijo  ,id_tipo_unidad_constructiva
            ) VALUES(
            g_cantidad  ,'si'        ,al_id        ,al_id_padre_nuevo
            );

            --QUITA LA COMPOSICIÓN DE SU AGRUPADOR ANTERIOR
            DELETE FROM almin.tal_composicion_tuc
            WHERE id_tipo_unidad_constructiva = al_id_padre
            AND id_tuc_hijo = al_id;

            --ACTUALIZA EL TIPO DEL TUC MOVIDO
            UPDATE almin.tal_tipo_unidad_constructiva SET
            tipo = 'Rama'
            WHERE id_tipo_unidad_constructiva = al_id;


            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Drag and Drop Exitoso';

            /*--VERIFICA SI SE ESTÁ HACIENDO UN DRAG A LA PAPELERA DE RECICLAJE, PARA QUITAR LA COMPOSICIÓN CON SU AGRUPADOR
            IF EXISTS(SELECT 1
                      FROM almin.tal_tipo_unidad_constructiva
                      WHERE id_tipo_unidad_constructiva = al_id_padre_nuevo
                      AND codigo IN('Basurero','Obsoletos')) THEN

--                      raise exception 'entra id_padre: %',al_id_padre;
                DELETE
                FROM almin.tal_composicion_tuc
                WHERE id_tipo_unidad_constructiva = al_id_padre
                AND id_tuc_hijo = al_id;

            END IF;*/

            /*IF al_id_padre_nuevo = 1 THEN
                --ACTUALIZA EL TIPO DE LA TUC A RAMA
                UPDATE almin.tal_tipo_unidad_constructiva SET
                tipo = 'Rama'
                WHERE id_tipo_unidad_constructiva = al_id;

                -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
                g_descripcion_log_error := 'Tipo de Unidad Constructiva enviada a la Papelera de Reciclaje';
            END IF;*/

            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_DRADRO_RAM' THEN --DRADRO: Drag And Drop Rama
    --DRAG AND DROP DE UNA RAMA (COMPOSICIÓN)
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_composicion_tuc
                          WHERE id_tuc_hijo = al_id
                          AND id_tipo_unidad_constructiva = al_id_padre) THEN

                g_descripcion_log_error := 'Drag and Drop no realizado: Composición inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id_padre_nuevo) THEN

                g_descripcion_log_error := 'Drag and Drop no realizado: Tipo de Unidad Constructiva destino inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --RECUPERA LOS DATOS DE LA COMPOSICIÓN A MOVER
            SELECT opcional ,cantidad
            INTO g_opcional, g_cantidad
            FROM almin.tal_composicion_tuc
            WHERE id_tuc_hijo = al_id
            AND id_tipo_unidad_constructiva = al_id_padre;

            --ELIMINA LA COMPOSICIÓN
            DELETE FROM almin.tal_composicion_tuc WHERE id_tuc_hijo = al_id AND id_tipo_unidad_constructiva = al_id_padre;

            SELECT NEXTVAL('almin.tal_composicion_tuc_id_composicion_tuc_seq') INTO g_id;

            --CREA LA COMPOSICIÓN CON EL PADRE NUEVO INDICADO
            INSERT INTO almin.tal_composicion_tuc(
            id_composicion_tuc  ,cantidad    ,opcional    ,id_tuc_hijo  ,id_tipo_unidad_constructiva
            ) VALUES(
            g_id                ,g_cantidad  ,g_opcional  ,al_id        ,al_id_padre_nuevo
            );

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Drag and Drop Exitoso';
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_id;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_DRADRO_ITE' THEN --DRADRO: Drag And Drop Item
    --DRAG AND DROP DE UN ITEM (COMPONENTE)
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_componente
                          WHERE id_item = al_id
                          AND id_tipo_unidad_constructiva = al_id_padre) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: Componente inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id_padre_nuevo) THEN

                g_descripcion_log_error := 'Drag and Drop no realizado: Tipo de Unidad Constructiva destino inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --RECUPERA LOS DATOS DEL COMPONENTE A MOVER
            SELECT cantidad ,cosiderar_repeticion   ,descripcion
            INTO g_cantidad ,g_considerar_repeticion ,g_descripcion
            FROM almin.tal_componente
            WHERE id_item = al_id
            AND id_tipo_unidad_constructiva = al_id_padre;

            --ELIMINA EL COMPONENTE
            DELETE FROM almin.tal_componente WHERE id_item = al_id AND id_tipo_unidad_constructiva = al_id_padre;

            --CREA EL COMPONENTE CON EL PADRE NUEVO INDICADO
            INSERT INTO almin.tal_componente(
		    cantidad      ,estado_registro              ,cosiderar_repeticion     ,descripcion,
		    id_item       ,id_tipo_unidad_constructiva
		    ) VALUES (
		    g_cantidad    ,'activo'                     ,g_considerar_repeticion  ,g_descripcion,
		    al_id         ,al_id_padre_nuevo
            );

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Drag and Drop Exitoso';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

     ELSIF pm_codigo_procedimiento = 'AL_TIPOUC_FIN' THEN
     -- FINALIZA LA COMPOSICIÓN DE UN TIPO DE UNIDAD CONSTRUCTIVA
        BEGIN

            --VERIFICA LA EXISTENCIA DEL TIPO DE UNIDAD CONSTRUCTIVA
            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Finalización no realizada: Tipo de Unidad Constructiva no registrada';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA QUE NO SEA UN AGRUPADOR
            IF EXISTS(SELECT 1
                      FROM almin.tal_tipo_unidad_constructiva
                      WHERE id_tipo_unidad_constructiva = al_id
                      AND tipo = 'Agrupador') THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Finalización no realizada: no se puede finalizar un Agrupador';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA QUE NO EL TIPO DE UNIDAD CONSTRUCTIVA NO ESTÉ BLOQUEADO
            IF EXISTS(SELECT 1
                      FROM almin.tal_tipo_unidad_constructiva
                      WHERE id_tipo_unidad_constructiva = al_id
                      AND estado = 'Terminado') THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'El Tipo de Unidad Constructiva ya fue finalizado';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL TIPO DE UNIDAD CONSTRUCTIVA TIENE COMPOSICIÓN O AL MENOS COMPONENTES
            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_composicion_tuc COMTUC, almin.tal_componente COMPON
                          WHERE COMTUC.id_tipo_unidad_constructiva = al_id
                          OR COMPON.id_tipo_unidad_constructiva = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Bloqueo no realizado: El Tipo de Unidad Constructiva está vacío';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            UPDATE almin.tal_tipo_unidad_constructiva SET
            estado = 'Terminado'
            WHERE id_tipo_unidad_constructiva = al_id;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Finalización realizada';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_TIPOUC_DES' THEN --
     -- DESBLOQUEA UN TIPO DE UNIDAD CONSTRUCTIVA, CAMBIA EL ESTADO A BORRADOR DEL TIPO DE UNIDAD CONSTRUCTIVA
        BEGIN

            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Desbloqueo no realizado: Tipo de Unidad Constructiva no registrada';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI ESTÁ EN ESTADO TERMINADO
            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id
                          AND estado = 'Terminado') THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Desbloqueo no realizado: El Tipo de Unidad Constructiva no está Terminada';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI ALGUNO DE SUS PADRES ESTÁ TERMINADO
            IF EXISTS(SELECT 1
                      FROM almin.tal_composicion_tuc COMTUC
                      INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUC
                      ON TIPOUC.id_tipo_unidad_constructiva = COMTUC.id_tipo_unidad_constructiva
                      AND TIPOUC.estado = 'Terminado'
                      WHERE COMTUC.id_tuc_hijo = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Desbloqueo no realizado: El Tipo de Unidad Constructiva tiene padres Bloqueados';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

             --VERIFICA SI FUE UTILIZADO EN ALGÚN PEDIDO
             al_id_salida = NULL;
             
               SELECT
                    osd.id_salida 
                 into 
                  al_id_salida
              FROM almin.tal_orden_salida_uc_detalle osd
              inner join almin.tal_salida sal on sal.id_salida = osd.id_salida
              WHERE id_tipo_unidad_constructiva = al_id ;
             
            IF  al_id_salida is not null THEN

                g_nivel_error := '4';
             --   g_descripcion_log_error := 'Desbloqueo no realizado: El Tipo de Unidad Constructiva fue solicitado en algún Pedido';
               g_descripcion_log_error := 'Desbloqueo no realizado: El Tipo de Unidad Constructiva fue solicitado en algún Pedido ID='|| COALESCE(al_id_salida,0);
                
              g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

             --VERIFICA SI FUE UTILIZADO COMO REEMPLAZO DE ALGÚN TUC
            IF EXISTS(SELECT 1
                      FROM almin.tal_detalle_salida_uc
                      WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Desbloqueo no realizado: El Tipo de Unidad Constructiva tiene padres Bloqueados';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            UPDATE almin.tal_tipo_unidad_constructiva SET
            estado = 'Borrador'
            WHERE id_tipo_unidad_constructiva = al_id;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Desbloqueo realizado con éxito';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_COMTUC_COP' THEN --COMTUC: Composición de Tipo de Unidad Constructiva
    -- COPIA UN TUC EN OTRO TUC (HACE UNA COMPOSICIÓN EN OTRO TUC)
        BEGIN

            --VERIFICA QUE EXISTA EL TUC EN LA COMPOSICIÓN
            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_composicion_tuc
                          WHERE id_tuc_hijo = al_id
                          AND id_tipo_unidad_constructiva = al_id_padre) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'No se pudo pegar el Tipo de Unidad Constructiva: Composición del Tipo de Unidad Constructiva inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA QUE EXISTA EL TIPO DE UNIDAD CONSTRUCTIVA
            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'No se pudo pegar el Tipo de Unidad Constructiva: Tipo de Unidad Constructiva inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

             --VERIFICA QUE EL TUC NO SEA UN AGRUPADOR
            IF EXISTS(SELECT 1
                          FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id
                          AND tipo = 'Agrupador') THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'No se pudo pegar el Tipo de Unidad Constructiva: Tipo de Unidad Constructiva es un Agrupador';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA QUE EXISTA EL TUC PADRE NUEVO
            IF NOT EXISTS(SELECT 1
                          FROM almin.tal_tipo_unidad_constructiva
                          WHERE id_tipo_unidad_constructiva = al_id_padre_nuevo) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'No se pudo pegar el Tipo de Unidad Constructiva: Tipo de Unidad Constructiva inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA QUE NO SE COPIE AL BASURERO; SE OBTIENE EL ID DEL AGRUPADOR BASURERO
            SELECT id_tipo_unidad_constructiva
            INTO g_id_tipo_unidad_constructiva
            FROM almin.tal_tipo_unidad_constructiva
            WHERE codigo = 'Basurero';

            IF al_id_padre_nuevo = g_id_tipo_unidad_constructiva THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Copia no realizada: No se puede pegar un Tipo de Unidad Constructiva en la Papelera';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA QUE NO SE COPIE A OBSOLETOS; SE OBTIENE EL ID DEL AGRUPADOR OBSOLETOS
            SELECT id_tipo_unidad_constructiva
            INTO g_id_tipo_unidad_constructiva
            FROM almin.tal_tipo_unidad_constructiva
            WHERE codigo = 'Obsoletos';

            IF al_id_padre_nuevo = g_id_tipo_unidad_constructiva THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Copia no realizada: No se puede pegar un Tipo de Unidad Constructiva en Obsoletos';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            -- TODO OK, ENTONCES SE COPIA EL TUC
            INSERT INTO almin.tal_composicion_tuc(
            cantidad     ,opcional     ,id_tuc_hijo  ,id_tipo_unidad_constructiva
            ) VALUES(
            al_cantidad  ,al_opcional  ,al_id        ,al_id_padre_nuevo
            );

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso del Componente';
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