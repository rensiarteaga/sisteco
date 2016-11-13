<?php
/**
 * Nombre de la Clase:	cls_DBSolicitudSalida
 * Prop�sito:			Permite ejecutar la funcionalidad de la tabla tal_solicitud_salida
 * Autor:				Ariel Ayaviri Omonte
 * Fecha creaci�n:		12-09-2013
 *
 */
class cls_DBSolicitudSalida {
	// Variable que contiene la salida de la ejecuci�n de la funci�n
	// si la funci�n tuvo error (false), salida contendr� el mensaje de error
	// si la funci�n no tuvo error (true), salida contendr� el resultado, ya sea un conjunto de datos o un mensaje de confirmaci�n
	var $salida;
	
	// Variable que contedr� la cadena de llamada a las funciones postgres
	var $query;
	
	// Variables para la ejecuci�n de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la funci�n a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBSolicitudSalida.php";
	// Matriz de par�metros de validaci�n de todas las columnas
	var $matriz_validacion = array ();
	// Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;
	function __construct() {
		// Carga los par�metro de validaci�n de todas las columnas
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	
	/**
	 * Nombre de la funci�n:	ListarSolicitudSalida
	 * Prop�sito:				Desplegar los registros de tal_solicitud_salida en funci�n de los par�metros del filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaci�n:		27-08-2013
	 *
	 * @param unknown_type $cant        	
	 * @param unknown_type $puntero        	
	 * @param unknown_type $sortcol        	
	 * @param unknown_type $sortdir        	
	 * @param unknown_type $criterio_filtro        	
	 * @param unknown_type $id_financiador        	
	 * @param unknown_type $id_regional        	
	 * @param unknown_type $id_programa        	
	 * @param unknown_type $id_proyecto        	
	 * @param unknown_type $id_actividad        	
	 * @return unknown
	 */
	function ListarSolicitudSalida($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_sel';
		$this->codigo_procedimiento = "'AL_SOLSAL_SEL'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('id_solicitud_salida', 'integer');
		$this->var->add_def_cols('id_almacen', 'integer');
		$this->var->add_def_cols('id_unidad_organizacional', 'integer');
		$this->var->add_def_cols('uo_empleado', 'varchar');
		$this->var->add_def_cols('id_empleado', 'integer');
		$this->var->add_def_cols('nombre_empleado', 'text');
		$this->var->add_def_cols('cargo_empleado', 'varchar');
		$this->var->add_def_cols('id_aprobador', 'integer');
		$this->var->add_def_cols('uo_aprobador', 'varchar');
		$this->var->add_def_cols('nombre_aprobador', 'text');
		$this->var->add_def_cols('fecha_solicitud', 'text');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('codigo', 'varchar');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ContarSolicitudSalida
	 * Prop�sito:				Contar el total de registros desplegados en funci�n de los par�metros de filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaci�n:		25-07-2013
	 *
	 * @param unknown_type $cant        	
	 * @param unknown_type $puntero        	
	 * @param unknown_type $sortcol        	
	 * @param unknown_type $sortdir        	
	 * @param unknown_type $criterio_filtro        	
	 * @param unknown_type $id_financiador        	
	 * @param unknown_type $id_regional        	
	 * @param unknown_type $id_programa        	
	 * @param unknown_type $id_proyecto        	
	 * @param unknown_type $id_actividad        	
	 * @return unknown
	 */
	function ContarSolicitudSalida($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_sel';
		$this->codigo_procedimiento = "'AL_SOLSAL_COUNT'";
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		// Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		// Retorna el resultado de la ejecuci�n
		return $res;
	}
	function InsertarSolicitudSalida($id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_iud';
		$this->codigo_procedimiento = "'AL_SOLSAL_INS'";
				
		/*Datos CTTES*/
		//$id_unidad_organizacional=742;$id_empleado=460;$id_aprobador=25;
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_aprobador);
		$this->var->add_param("'$fecha_solicitud'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("NULL");//al_codigo
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ModificarSolicitudSalida($id_solicitud_salida, $id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_iud';
		$this->codigo_procedimiento = "'AL_SOLSAL_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_solicitud_salida);
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_aprobador);
		$this->var->add_param("'$fecha_solicitud'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("NULL");//al_codigo
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function EliminarSolicitudSalida($id_solicitud_salida) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_iud';
		$this->codigo_procedimiento = "'AL_SOLSAL_DEL'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		// Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		$this->var->add_param($id_solicitud_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//al_codigo
		                               
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function AccionesSolicitud($id_solicitud_salida,$accion_solicitud)
	{
		//echo $accion_solicitud;exit; 
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_iud';
		
		//control del flujo solicitud
		switch ($accion_solicitud)
		{
			case "finalizar_borrador":
				$this->codigo_procedimiento = "'AL_SOLBORFIN_UPD'";
				break;
			case "corregir_pendiente":
				$this->codigo_procedimiento = "'AL_SOLPENREV_UPD'";
				break;
			case "finalizar_pendiente":
				$this->codigo_procedimiento = "'AL_SOLPENFIN_UPD'";
				break;
			case "procesar_solicitud":
				$this->codigo_procedimiento = "'AL_SOLPROC_UPD'";
				break;
			default:
				echo "No selecciono ninguna accion"	;
				exit();
				break;
		}
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_solicitud_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//al_codigo
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	
	function EnviarSolicitud($id_solicitud_salida) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_iud';
		$this->codigo_procedimiento = "'AL_ALACTIVE_UPD'";
	
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_solicitud_salida);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param("NULL");//al_codigo
	
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
	
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
	
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		echo $this->query;
		return $res;
	}
	function AprobarSolicitud($id_solicitud_salida) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_iud';
		$this->codigo_procedimiento = "'AL_ALACTIV_UPD'";
	
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_solicitud_salida);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param("NULL");//al_codigo
	
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
	
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
	
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ContarAprobarSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_sel';
		$this->codigo_procedimiento = "'AL_SOLSAL_COUNT'";
		$func = new cls_funciones(); // Instancia de las funciones generales
		 
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
	
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
	
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		// Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		// Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	function RechazarSolicitud($id_solicitud_salida) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_iud';
		$this->codigo_procedimiento = "'AL_ALACTIV1_UPD'";
	
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_solicitud_salida);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param("NULL");//al_codigo
	
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
	
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
	
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ProcesarSolicitud($id_solicitud_salida) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_iud';
		$this->codigo_procedimiento = "'AL_PROCSOL_UPD'";
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_solicitud_salida);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param("NULL");//al_codigo
	
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
	
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
	
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ContarRechazarSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_sel';
		$this->codigo_procedimiento = "'AL_SOLSAL_COUNT'";
		$func = new cls_funciones(); // Instancia de las funciones generales
			
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
	
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
	
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		// Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		// Retorna el resultado de la ejecuci�n
		return $res;
	}
	function ValidarSolicitudSalida($operacion_sql, $id_solicitud_salida, $id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion) {
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		// Ejecuta la validaci�n por el tipo de operaci�n
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				// Validar id_persona - tipo int8
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_solicitud_salida");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_solicitud_salida", $id_solicitud_salida)) {
					$this->salida = $valid->salida;
					return false;
				}
			}

			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_aprobador");
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_aprobador", $id_aprobador)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_AllowBlank(true);
			$tipo_dato->set_MaxLength(1000);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion)) {
				$this->salida = $valid->salida;
				return false;
			}
			return true;
		} elseif ($operacion_sql == 'delete') {
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_solicitud_salida");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_solicitud_salida", $id_solicitud_salida)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}
	
	function ObtenerFechaUltimaSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_solicitud_salida_sel';
		$this->codigo_procedimiento = "'AL_LASTSOL_SEL'";
		$func = new cls_funciones(); // Instancia de las funciones generales
		 
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_ultima_solicitud', 'date');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
}
?>
