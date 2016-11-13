<?php
/**
 * Nombre de la clase:	cls_DBUsuario.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_usuario
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-26 17:44:00
 */

class cls_DBUsuario
{ 
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	
	function __construct()
	{
		$this->decodificar=$decodificar; 
	}
	/*
	Funcion agregada de la anterior version, temporalmente
	*/
	/**
	 * Funcion que verifica el usuario y contraseña (agregada de la anterior version por Enzo)
	 *
	 * @param unknown_type $usuario
	 * @param unknown_type $contrasenia
	 * @param unknown_type $ip_origen
	 * @param unknown_type $mac_maquina
	 * @return unknown
	 */
	function VerificaUsuario($usuario,$contrasenia,$ip_origen,$mac_maquina)
	{
		
		$this->salida ="";
		$this->nombre_funcion = 'f_sg_validacion_login';
		$this->codigo_procedimiento = "'SG_USR_SEL'";

		$func = new cls_funciones();
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros específos
        $this->var->add_param($func->iif($usuario == '','NULL',"'$usuario'"));//$usuario
        $this->var->add_param($func->iif($contrasenia == '','NULL',"'$contrasenia'"));//$contrasenia
        $this->var->add_param($func->iif($ip_origen == '','NULL',"'$ip_origen'"));//$ip_origen
		$this->var->add_param($func->iif($mac_maquina == '','NULL',"'$mac_maquina'"));//$mac_maquina
		//$this->var->add_param($func->iif($autentificacion == '','NULL',"'$autentificacion'"));//$mac_maquina
		
		
		
    	
		//Ejecuta la función
		$res = $this->var->exec_non_query_sss();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;				
		//echo $this->query;exit;
		return $res;
	}
	/**
	 * Nombre de la función:	ListarUsuario
	 * Propósito:				Desplegar los registros de tsg_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:44:00
	 */
	function ListarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_sel';
		$this->codigo_procedimiento = "'SG_USUARI_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('login','varchar');
		$this->var->add_def_cols('contrasenia','varchar');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');
		$this->var->add_def_cols('estado_usuario','varchar');
		$this->var->add_def_cols('estilo_usuario','varchar');
		$this->var->add_def_cols('filtro_avanzado','varchar');
		$this->var->add_def_cols('fecha_expiracion','date');
		$this->var->add_def_cols('autentificacion','varchar');
		
		$this->var->add_def_cols('id_nivel_seguridad','integer');
		$this->var->add_def_cols('nombre_nivel','varchar');
		$this->var->add_def_cols('prioridad','integer');
		$this->var->add_def_cols('fecha_inactivacion','date');
//		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
		exit();*/
		return $res;
	}
	/**
	 * Nombre de la función:	ListarUsuario
	 * Propósito:				Desplegar los registros de tsg_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:44:00
	 */
	function ListarUsuarioEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_sel';
		$this->codigo_procedimiento = "'SG_USUEMP_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('login','varchar');
		$this->var->add_def_cols('contrasenia','varchar');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');
		$this->var->add_def_cols('estado_usuario','varchar');
		$this->var->add_def_cols('estilo_usuario','varchar');
		$this->var->add_def_cols('filtro_avanzado','varchar');
		$this->var->add_def_cols('fecha_expiracion','date');
		$this->var->add_def_cols('cargo','varchar');
//		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
/*echo $this->query;
		exit();*/
		return $res;
	}
	/**
	 * Nombre de la función:	ContarUsuario
	 * Propósito:				Contar los registros de tsg_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:44:00
	 */
	function ContarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_sel';
		$this->codigo_procedimiento = "'SG_USUARI_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}
	function ContarUsuarioEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_sel';
		$this->codigo_procedimiento = "'SG_USUEMP_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarUsuario
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:44:00
	 */
	function InsertarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$fecha_expiracion,$autentificacion,$id_nivel_seguridad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_iud';
		$this->codigo_procedimiento = "'SG_USUARI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_persona);
		$this->var->add_param("'$login'");
		$this->var->add_param("'".md5($contrasenia)."'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$estado_usuario'");
		$this->var->add_param("'$estilo_usuario'");
		$this->var->add_param("'$filtro_avanzado'");
		$this->var->add_param("'$fecha_expiracion'");
		$this->var->add_param("'$autentificacion'");
		$this->var->add_param("$id_nivel_seguridad");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo $this->query; exit();
		return $res;
	}
	
		/**
	 * Nombre de la función:	InsertarUsuario
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_usuario
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		31-10-2008
	 */
	function SincronizarEPUsuarioEmpleado($id_usuario){
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_iud';
		$this->codigo_procedimiento = "'SG_SINCUSUEMP'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Ejecuta la función
		$this->var->add_param($id_usuario);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarUsuario
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:44:00
	 */
	function ModificarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$fecha_expiracion,$autentificacion,$id_nivel_seguridad)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_iud';
		$this->codigo_procedimiento = "'SG_USUARI_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_usuario);
		$this->var->add_param($id_persona);
		$this->var->add_param("'$login'");
		$this->var->add_param("'".md5($contrasenia)."'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$estado_usuario'");
		$this->var->add_param("'$estilo_usuario'");
		$this->var->add_param("'$filtro_avanzado'");
		$this->var->add_param("'$fecha_expiracion'");
		$this->var->add_param("'$autentificacion'");
		$this->var->add_param("$id_nivel_seguridad");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarUsuario
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:44:00
	 */
	function EliminarUsuario($id_usuario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_iud';
		$this->codigo_procedimiento = "'SG_USUARI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_usuario);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ModificarUsuarioPref($id_usuario,$contrasenia,$contrasenia_nueva,$contrasenia_nueva_rep,$estilo_usuario)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_iud';
		$this->codigo_procedimiento = "'SG_USUPRE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_usuario);
		$this->var->add_param("null");//id_persona
		$this->var->add_param("'".md5($contrasenia_nueva)."'");//login
		$this->var->add_param("'".$contrasenia."'");//contrasenia
		$this->var->add_param("null");//fecha_registro
		$this->var->add_param("null");//hora_registro
		$this->var->add_param("null");//fecha_ultima_modificacion
		$this->var->add_param("null");//hora_ultima_modificacion
		$this->var->add_param("'".md5($contrasenia_nueva_rep)."'");//estado_usuario
		$this->var->add_param("'$estilo_usuario'");//estilo_usuario
		$this->var->add_param("null");//filtro_avanzado

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
echo $this->query;
exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarUsuarioVista
	 * Propósito:				Desplegar los registros de tsg_usuario
	 * Autor:				    RCM
	 * Fecha de creación:		22/04/2010
	 */
	function ListarUsuarioVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_sel';
		$this->codigo_procedimiento = "'SG_USRVIS_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('login','varchar');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('observaciones','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
		exit();*/
		return $res;
	}
	
	function ContarUsuarioVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_sel';
		$this->codigo_procedimiento = "'SG_USRVIS_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ValidarUsuario
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:44:00
	 */
	function ValidarUsuario($operacion_sql,$id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$autentificacion)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_usuario - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_usuario");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario", $id_usuario))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_persona - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_persona");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_persona", $id_persona))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar login - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("login");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "login", $login))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar contrasenia - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("contrasenia");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "contrasenia", $contrasenia))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_registro", $fecha_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_registro - tipo time
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_registro");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_registro", $hora_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar fecha_ultima_modificacion - tipo date
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ultima_modificacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ultima_modificacion", $fecha_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			/*//Validar hora_ultima_modificacion - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_ultima_modificacion");
			$tipo_dato->set_MaxLength(8);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_ultima_modificacion", $hora_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar estado_usuario - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_usuario");
			$tipo_dato->set_MaxLength(12);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_usuario", $estado_usuario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estilo_usuario - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estilo_usuario");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estilo_usuario", $estilo_usuario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar filtro_avanzado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("filtro_avanzado");
			$tipo_dato->set_MaxLength(6);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "filtro_avanzado", $filtro_avanzado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar autentificacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("autentificacion");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "autentificacion", $autentificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación de reglas de datos

			//Validar filtro_avanzado
			$check = array ("si","no");
			if(!in_array($filtro_avanzado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'filtro_avanzado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarUsuario";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_usuario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario", $id_usuario))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validación exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	/*-------------------------- MODIFICAR CLAVE ----------------------------*/
	/*------------------------ Marcos Flores Valda --------------------------*/
	/*-------------------------- MOD: 25-01-2011 ----------------------------*/
	
	function ValidarClave($id_usuario,$contrasenia_ant,$contrasenia_nueva,$confirmacion,$estilo,$filtro_avanzado,$mod_contrasenia,$autentificacion)
	{			
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_mod_clave';
		$this->codigo_procedimiento = "'SG_USUARI_SEL_CLAVE'";
				
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_usuario);
		$this->var->add_param("'$contrasenia_ant'");
		$this->var->add_param("'$contrasenia_nueva'");
		$this->var->add_param("'$confirmacion'");
		$this->var->add_param("'$estilo'");
		$this->var->add_param("'$filtro_avanzado'");
		$this->var->add_param("'$mod_contrasenia'");		
		$this->var->add_param("'$autentificacion'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();		
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;		
	}
	//26-11-2013
	function InactivarUsuario($id_usuario,$fecha_inactivacion)
	{
	
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_iud';
		$this->codigo_procedimiento = "'SG_INAUSR_UPD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_usuario);
		$this->var->add_param(null);
		$this->var->add_param(null);
		$this->var->add_param(null);
		$this->var->add_param("'$fecha_inactivacion'");
		$this->var->add_param(null);
		$this->var->add_param(null);
		$this->var->add_param(null);
		$this->var->add_param(null);
		$this->var->add_param(null);
		$this->var->add_param(null);
		$this->var->add_param(null);
		$this->var->add_param(null);
		$this->var->add_param(null);
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
	
		return $res;
	}
	
	
	/*****************/
	function ListarUsuarioRest($login)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_usuario_rest_iud';
		$this->codigo_procedimiento = "'SG_USUREST_SEL'";
	
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$login'");
		//		//Ejecuta la función de consulta
		$res = $this->var->exec_non_query_sss();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res;
	}
	
}?>