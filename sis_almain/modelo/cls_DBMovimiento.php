<?php
/**
 * Nombre de la Clase:	cls_DBMovimiento
 * Prop�sito:			Permite ejecutar la funcionalidad de la tabla tal_almacen
 * Autor:				Ruddy Lujan Bravo
 * Fecha creaci�n:		06-09-2013
 *
 */
class cls_DBMovimiento {
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
	var $nombre_archivo = "cls_DBMovimiento.php";
	
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
	 * Nombre de la funci�n:	ListarMovimiento
	 * Prop�sito:				Desplegar los registros de tal_movimiento en funci�n de los par�metros del filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaci�n:		09-09-2013
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
	function ListarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_sel';
		$this->codigo_procedimiento = "'AL_MOVI_SEL'";
		
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
		$this->var->add_def_cols('id_movimiento', 'integer');
		$this->var->add_def_cols('id_tipo_movimiento', 'integer');
		$this->var->add_def_cols('id_almacen', 'integer');
		$this->var->add_def_cols('id_solicitud_salida', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('fecha_movimiento', 'text');
		$this->var->add_def_cols('fecha_finalizacion', 'text');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('observaciones', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('nombre_tipo', 'varchar');
		$this->var->add_def_cols('requiere_aprobacion', 'varchar');
		$this->var->add_def_cols('descripcion_tipo', 'varchar');
		$this->var->add_def_cols('id_almacen_trans', 'integer');
		$this->var->add_def_cols('desc_almacen', 'varchar');
		$this->var->add_def_cols('id_movimiento_fk', 'integer');
		$this->var->add_def_cols('almacen_destino', 'varchar');
		
		$this->var->add_def_cols('nro_compra', 'varchar');
		
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query; 
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ContarMovimiento
	 * Prop�sito:				Contar el total de registros desplegados en funci�n de los par�metros de filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaci�n:		06-09-2013
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
	function ContarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_sel';
		$this->codigo_procedimiento = "'AL_MOVI_COUNT'";
		
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
	/**
	 * Nombre de la funci�n:	EliminarMovimiento
	 * Prop�sito:				Eliminar registros de la tabla tal_movimiento mediante filtros
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaci�n:		06-09-2013
	 */
	function EliminarMovimiento($id_movimiento) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_iud';
		$this->codigo_procedimiento = "'AL_MOVI_DEL'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		$this->var->add_param("$id_movimiento"); // id de movimiento
		$this->var->add_param("NULL"); // id de tipo_movimiento
		$this->var->add_param("NULL"); // id de almacen
		$this->var->add_param("NULL"); // id de solicitud_salida
		$this->var->add_param("NULL"); // codigo
		$this->var->add_param("NULL"); // fecha_movimiento
		$this->var->add_param("NULL"); // descripcion
		$this->var->add_param("NULL"); // observaciones
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//al_nro_compra
		                               
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function InsertarMovimiento($id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones,$almacen_destino,$movimiento_origen,$nro_compra) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_iud';
		$this->codigo_procedimiento = "'AL_MOVI_INS'";
		
		$time = $fecha_movimiento." ".date("H:i:s"); 
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_movimiento);
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_solicitud_salida);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$time'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		//TRANSPASOS
		$this->var->add_param($almacen_destino);
		$this->var->add_param($movimiento_origen);
		
		//a�adido 24/07/2015
		$this->var->add_param("'$nro_compra'");
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ModificarMovimiento($id_movimiento, $id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones,$almacen_destino,$movimiento_origen,$nro_compra) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_iud';
		$this->codigo_procedimiento = "'AL_MOVI_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_movimiento);
		$this->var->add_param($id_tipo_movimiento);
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_solicitud_salida);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$fecha_movimiento'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($almacen_destino);
		$this->var->add_param($movimiento_origen);
		
		//a�adido 24/07/2015
		$this->var->add_param("'$nro_compra'");
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function FinalizarMovimiento($id_movimiento) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_iud';
		$this->codigo_procedimiento = "'AL_ALACTIV_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_movimiento);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ContarFinalizarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_sel';
		$this->codigo_procedimiento = "'AL_MOVI_COUNT'";
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
	function RechazarMovimiento($id_movimiento) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_iud';
		$this->codigo_procedimiento = "'AL_ALACTIV1_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_movimiento);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ContarRechazarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_sel';
		$this->codigo_procedimiento = "'AL_MOVI_COUNT'";
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
	function FinalizarEnviarMovimiento($id_movimiento) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_iud';
		$this->codigo_procedimiento = "'AL_ALACTIVE2_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_movimiento);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function AccionesMovimiento($id_movimiento,$tipo_movmiento,$aprobacion,$accion_movimiento)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_iud';
		//control del flujo del movimiento
		switch ($accion_movimiento) 
		{
			case "finalizar_borrador":
				if($tipo_movmiento  == 'ingreso' && $aprobacion == 'no')
					$this->codigo_procedimiento = "'AL_MOVINGNO_UPD'";
				else if ($tipo_movmiento  == 'ingreso' && $aprobacion == 'si')
					$this->codigo_procedimiento = "'AL_MOVAPRO_UPD'";
				else if ($tipo_movmiento  == 'salida' && $aprobacion == 'si')
					$this->codigo_procedimiento = "'AL_MOVAPRO_UPD'";
				else if ($tipo_movmiento  == 'salida' && $aprobacion == 'no')
					$this->codigo_procedimiento = "'AL_MOVSALNO_UPD'";
				//transpasos
				else if ($tipo_movmiento == 'transpaso_salida') {
					$this->codigo_procedimiento = "'AL_TRANSMOV_UPD'";
				}
				else if ($tipo_movmiento == 'transpaso_ingreso') {//se sigue en mismo procedimiento q un movimiento con aprobacion
					$this->codigo_procedimiento = "'AL_MOVAPRO_UPD'";
				}
				//a�adido 19082015
				//otro tipo de movimientos en estado borrador
				else
					$this->codigo_procedimiento = "'AL_FLUJO_MOVS'";
				break;
			case "corregir_pendiente":
				$this->codigo_procedimiento = "'AL_MOVREV_UPD'";
				break;
				
			case "finalizar_pendiente":
					if ($tipo_movmiento  == 'ingreso' && $aprobacion == 'si')
						$this->codigo_procedimiento = "'AL_MOVFINING_UPD'";
					else if ($tipo_movmiento  == 'salida' && $aprobacion == 'si')
						$this->codigo_procedimiento = "'AL_MOVFINSAL_UPD'";
					//finalizar un transpaso de items	
					else if ($tipo_movmiento  == 'transpaso_salida' )
						$this->codigo_procedimiento = "'AL_TRANSMOVFIN_UPD'";
					else if ($tipo_movmiento  == 'transpaso_ingreso' )//se selecciono un otro procedimiento existente (ingreso con aprobacion)
						$this->codigo_procedimiento = "'AL_MOVFINING_UPD'";
					//a�adido 19082015
					else
						$this->codigo_procedimiento = "'AL_FLUJO_MOVS'";
					
				break;
			case "finalizar_entrega":
						$this->codigo_procedimiento = "'AL_FINSOLIC_UPD'";
				break;
			case "valorizar_movimiento":
					$this->codigo_procedimiento = "'AL_VALOR_UPD'";
			break;
			case "corregir_movimiento":
				$this->codigo_procedimiento = "'AL_CORREGMOV_UPD'";
				break;
			
			default:
					echo "No se eligio ninguna accion"	;
					exit();
					break;
		}
		//echo $this->codigo_procedimiento;exit;	 
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_movimiento);//6
		$this->var->add_param('NULL');//7
		$this->var->add_param('NULL');//8
		$this->var->add_param('NULL');//9
		$this->var->add_param('NULL');//10
		$this->var->add_param('NULL');//11
		$this->var->add_param('NULL');//12
		$this->var->add_param('NULL');//13
		
		$this->var->add_param('NULL');//14
		$this->var->add_param('NULL');//15
		
		$this->var->add_param('NULL');//16
		
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
	
	function ValidarMovimiento($operacion_sql, $id_movimiento, $id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones) {
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		// Ejecuta la validaci�n por el tipo de operaci�n
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_movimiento");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_movimiento", $id_movimiento)) {
					$this->salida = $valid->salida;
					return false;
				}
			}
			// Validar id_tipo_movimiento - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_movimiento");
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_movimiento", $id_tipo_movimiento)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar id_almacen - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "id_almacen", $id_almacen)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar id_almacen - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_solicitud_salida");
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "id_solicitud_salida", $id_solicitud_salida)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar codigo - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo)) {
				$this->salida = $valid->salida;
				return false;
			}*/
			// Validar fecha_movimiento - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_movimiento");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "fecha_movimiento", $fecha_movimiento)) {
				$this->salida = $valid->salida;
				return false;
			}*/
			// Validar descripcion - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion)) {
				$this->salida = $valid->salida;
				return false;
			}*/
			// Validar observaciones - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones)) {
				$this->salida = $valid->salida;
				return false;
			}*/
			return true;
		} elseif ($operacion_sql == 'delete') {
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_movimiento");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_movimiento", $id_movimiento)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}
}
?>
