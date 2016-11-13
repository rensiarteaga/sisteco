<?php
/**
 * Nombre de la Clase:	cls_DBReportes
 * Prop�sito:			Llamadas a las funciones para los reportes del sistema
 * Autor:				unknow
 * Fecha creaci�n:		08072014
 *
 */
class cls_DBReportes {
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
	var $nombre_archivo = "cls_DBReportes.php";
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
	 * Nombre de la funci�n:	ListarItem
	 * Prop�sito:				Desplegar los registros de tal_item en funci�n de los par�metros del filtro
	 * Autor:					
	 * Fecha de creaci�n:		
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
	function ListarItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_sel';
		$this->codigo_procedimiento = "'AL_ITEM_SEL'";
		
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
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('id_clasificacion', 'integer');
		$this->var->add_def_cols('id_unidad_medida', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('codigo_fabrica', 'varchar');
		$this->var->add_def_cols('num_por_clasificacion', 'integer');
		$this->var->add_def_cols('bajo_responsabilidad', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('metodo_valoracion', 'varchar');
		$this->var->add_def_cols('nombre_clasificacion', 'varchar');
		$this->var->add_def_cols('nombre_medida', 'varchar');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ListarMovimientoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_MOV'";
		
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
		$this->var->add_def_cols('desc_documento', 'varchar');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('almacen', 'text');
		$this->var->add_def_cols('dia_fin', 'varchar');
		$this->var->add_def_cols('mes_fin', 'varchar');
		$this->var->add_def_cols('anio_fin', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('nro_fila', 'bigint');
		$this->var->add_def_cols('det_tem', 'text');
		$this->var->add_def_cols('unidad_medida', 'varchar');
		$this->var->add_def_cols('cantidad', 'numeric');
		
		$this->var->add_def_cols('precio_unitario', 'numeric');
		$this->var->add_def_cols('precio_total', 'numeric');
		
		$this->var->add_def_cols('observaciones', 'varchar');
		
		$this->var->add_def_cols('nro_compra', 'varchar');
		$this->var->add_def_cols('precio_promedio', 'numeric');
		
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function ListarMovimientoReporteSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_MOVSOL'";
	
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
		$this->var->add_def_cols('tipo', 'varchar');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('almacen', 'text');
		$this->var->add_def_cols('dia_fin', 'varchar');
		$this->var->add_def_cols('mes_fin', 'varchar');
		$this->var->add_def_cols('anio_fin', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('det_tem', 'text');
		$this->var->add_def_cols('unidad_medida', 'varchar');
		$this->var->add_def_cols('cantidad_solicitada', 'numeric');
		$this->var->add_def_cols('cant_entregada', 'numeric');
		$this->var->add_def_cols('tipo_saldo', 'varchar');
		$this->var->add_def_cols('observaciones', 'varchar');
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function ListarPieMovimientoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_PIEMOVSOL'";
		
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
		$this->var->add_def_cols('desc_persona', 'text');
		$this->var->add_def_cols('cargo_empleado', 'varchar');
		$this->var->add_def_cols('desc_jefe', 'text');
		$this->var->add_def_cols('cargo_aprobador', 'varchar');
	
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ListarReporteSolicitudSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_SOL'";
		
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
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('dia', 'varchar');
		$this->var->add_def_cols('mes', 'varchar');
		$this->var->add_def_cols('anio', 'varchar');
		$this->var->add_def_cols('desc_persona', 'text');
		$this->var->add_def_cols('cargo_empleado', 'varchar');
		$this->var->add_def_cols('desc_unidad_org', 'text');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('desc_item', 'text');
		$this->var->add_def_cols('unidad_medida', 'varchar');
		$this->var->add_def_cols('cantidad_solicitada', 'numeric');
		
		$this->var->add_def_cols('desc_jefe', 'text');
		$this->var->add_def_cols('cargo_aprobador', 'varchar');
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function ReporteClasificacionItems($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_CLASIF_ITEM'";
		
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
		$this->var->add_def_cols('id_clasificacion', 'integer');
		$this->var->add_def_cols('id_clasificacion_fk', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('codigo_largo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('orden', 'integer');
		$this->var->add_def_cols('nivel', 'integer');
		$this->var->add_def_cols('desc_clasif', 'text');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ReporteTipoMovimientos($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_TIP_MOVS'";
		
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
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('cod_movimiento', 'varchar'); 
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('fecha_movimiento', 'text');
		$this->var->add_def_cols('cantidad', 'numeric');
		$this->var->add_def_cols('precio_unitario', 'numeric');
		$this->var->add_def_cols('precio_total', 'numeric');
		$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('tipo_movimiento', 'text');
		
				
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function ReporteTipoMovimientosSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_TIPMOV_SOL'";
		
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
		$this->var->add_def_cols('fila', 'bigint');
		$this->var->add_def_cols('nombre_unidad', 'varchar');
		$this->var->add_def_cols('nombre_cargo', 'varchar');
		$this->var->add_def_cols('desc_persona', 'text');
		$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('desc_item', 'text');
		$this->var->add_def_cols('unidad_medida', 'varchar');
		$this->var->add_def_cols('fecha_solicitud', 'date');
		$this->var->add_def_cols('cantidad_solicitada', 'numeric');
		$this->var->add_def_cols('cantidad_entregada', 'numeric');
		$this->var->add_def_cols('costo_unitario_act', 'numeric');
		$this->var->add_def_cols('costo_total', 'numeric');
		
		$this->var->add_def_cols('id_solicitud', 'integer');
		$this->var->add_def_cols('codigo_solicitud', 'varchar');
				
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function ReporteSalidasGeneral( $cant, $puntero, $sortcol, $sortdir, $criterio_filtro )
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_SAL_GRAL'";
		
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
		
		$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('desc_item', 'text');
		$this->var->add_def_cols('unidad_medida', 'varchar');
		$this->var->add_def_cols('fecha_movimiento', 'date');
		$this->var->add_def_cols('cantidad', 'numeric');
		$this->var->add_def_cols('precio_promedio', 'numeric');
		$this->var->add_def_cols('precio_total', 'numeric');
		$this->var->add_def_cols('tipo', 'varchar');
		$this->var->add_def_cols('desc_tipo_mov', 'text');
		$this->var->add_def_cols('tipo_movimiento','text');
		$this->var->add_def_cols('id_movimiento', 'integer');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ReporteKardexItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_KARDIT'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
			
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
	
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		
		if($criterio_filtro != "")
		{
			$parametro = "'{";
			foreach ($criterio_filtro as $pm)
				$parametro .="$pm,";
			
			$parametro = trim($parametro,',');
			
			$parametro .= "}'";
			
			$this->var->criterio_filtro ="$parametro";
		}
		else
			$this->var->criterio_filtro = "'$criterio_filtro'";

		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definici�n de columnas con sus tipos de datos
		
		$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('desc_tipo_movimiento', 'text');
		
		$this->var->add_def_cols('fecha_finalizacion', 'date');
		$this->var->add_def_cols('cantidad', 'numeric');
		$this->var->add_def_cols('cant_ingreso', 'numeric');
		$this->var->add_def_cols('cant_salida', 'numeric');
		$this->var->add_def_cols('cant_saldo', 'numeric');
		$this->var->add_def_cols('costo_unitario', 'numeric');
		$this->var->add_def_cols('precio_prom_ponderado', 'numeric');
		$this->var->add_def_cols('precio_ingreso', 'numeric');
		$this->var->add_def_cols('precio_salida', 'numeric');
						
		$this->var->add_def_cols('tipo', 'varchar');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre_item', 'varchar');
		$this->var->add_def_cols('unidad_medida', 'varchar');
		$this->var->add_def_cols('cod_movimiento', 'varchar');
		$this->var->add_def_cols('saldo_item', 'numeric');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	function ReporteExistenciasAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_EXISTENCIAS'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
			
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		
		if($criterio_filtro != "")
		{
			$parametro = "'{";
			foreach ($criterio_filtro as $pm)
				$parametro .="$pm,";
			
			$parametro = trim($parametro,',');
			
			$parametro .= "}'";
			
			$this->var->criterio_filtro ="$parametro";
		}
		else
			$this->var->criterio_filtro = "'$criterio_filtro'";
		
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definici�n de columnas con sus tipos de datos
		
		//$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('existencias', 'numeric');
		$this->var->add_def_cols('unidad_medida', 'varchar');
		$this->var->add_def_cols('precio_unitario', 'numeric');
		$this->var->add_def_cols('precio_total', 'numeric');

		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query(); 
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	
	function ListarDatosEncargadoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_DATOS_ALMACENERO'";
		
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
		
		//$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('desc_usuario', 'text');
		$this->var->add_def_cols('id_persona', 'integer');
		$this->var->add_def_cols('id_usuario', 'integer');
			
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ReporteControlExistenciasAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_reportes';
		$this->codigo_procedimiento = "'AL_REP_CONEXIS'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
			
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		
		if($criterio_filtro != "")
		{
			$parametro = "'{";
			foreach ($criterio_filtro as $pm)
				$parametro .="$pm,";
			
			$parametro = trim($parametro,',');
			
			$parametro .= "}'";
			
			$this->var->criterio_filtro ="$parametro";
		}
		else
			$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definici�n de columnas con sus tipos de datos
		
		//$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('existencias', 'numeric');
		$this->var->add_def_cols('unidad_medida', 'varchar');
		$this->var->add_def_cols('precio_unitario', 'numeric');
		$this->var->add_def_cols('precio_total', 'numeric');

		
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
