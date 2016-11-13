<?php
/**
 * Nombre de la Clase:	cls_DBActivoFijoDepreciacionComprobante
 * Propósito:			Permite generar los asientos contables para el 
 * 						registro de las actualizaciones, depreciaciones de 
 * 						los activos fijos
 * Autor:				Daniel Sanchez Torrico
 * Fecha creación:		13/12/2012
 *
 */
class cls_DBActivoFijoDepreciacionComprobante
{
	//Variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;

	//Variable que contendrá la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecución de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la función a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBReporteActivoFijoResponsableCustodio.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
			
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}


	/**
	 * Nombre de la función:	RegistrarActivosFijosDepreciacionComprobantes
	 * Propósito:				Permite realizar el registro de los comprobantes contables
	 * 							para la depreciacion de los activos fijos
	 * Autor:					Daniel Sanchez Torrico
	 * Fecha de creación:		13-12-2012
	 *
	 * @param integer_type $cant
	 * @param integer_type $puntero
	 * @param string_type  $sortcol
	 * @param string_type  $sortdir
	 * @param string_type  $criterio_filtro
	
	 */
	
	function RegistrarActivosFijosDepreciacionComprobantes($cant, $puntero, $sortdir, $sortcol, $criterio_filtro,$id_grupo_dep,$fecha_hasta,$cod_regional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_depreciacion_comprobante_iud'; 
		//$this->codigo_procedimiento = "'AF_DEPREC_COMPR'";
		//añadido 11/04/2015 cbtes TDD
		if($cod_regional == 'TDD') $this->codigo_procedimiento="'AF_DEPREC_COMPR_TDD'";
		elseif($cod_regional == 'TRA')
		{
			$this->codigo_procedimiento="'AF_DEPREC_CBTE_TRANSMISION'";
			$cod_regional = '%';
		}
		elseif ($cod_regional== 'CBJ')
		{
			$this->codigo_procedimiento="'AF_DEPREC_COMPR_CBJ'"; //echo $id_grupo_dep.'<br>'.$fecha_hasta.'<br>'.$cod_regional;exit;
		}
		elseif ($cod_regional == 'OFID')
		{
			$this->codigo_procedimiento = "'AF_DEP_OFID'";
			if($cod_regional == 'OFID') $cod_regional = 'CTD';
		}
		else $this->codigo_procedimiento = "'AF_DEPREC_COMPR'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_param($id_grupo_dep);
		$this->var->add_param("'$fecha_hasta'");
		$this->var->add_param("'$cod_regional'");
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	
	
	}

	/**
	 * Nombre de la función:	ListarRegionalesActivoFijoDepreciacion
	 * Propósito:				Permite recuperar la informacion de las 
	 * 							regionales cuyos activos fijo se hayan depreciado esta gestion
	 * Autor:					Daniel Sanchez Torrico
	 * Fecha de creación:		09/01/2013
	 *
	 * @param integer_type $cant
	 * @param integer_type $puntero
	 * @param string_type  $sortcol
	 * @param string_type  $sortdir
	 * @param string_type  $criterio_filtro
	
	 */
	
	function ListarRegionalesActivoFijoDepreciacion($cant, $puntero, $sortdir, $sortcol, $criterio_filtro) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_depreciacion_comprobante_sel';
		$this->codigo_procedimiento = "'AF_SEL_REGIONALES_DEPR'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		
		
		$parametro = "'{";
			foreach($criterio_filtro as $pm)
				$parametro .= "$pm,";
			
			$parametro = trim($parametro, ',');
			
			$parametro .= "}'";
			
		$this->var->criterio_filtro = "$parametro";
		//echo $parametro;exit;
		$this->var->add_def_cols('codigo_regional', 'varchar');
		$this->var->add_def_cols('id_ep1', 'integer');
		$this->var->add_def_cols('id_ep2', 'integer');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('ids_comprobantes', 'integer');
		$this->var->add_def_cols('id_depreciacion_comprobante', 'integer');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	
	
	}
	
	/**
	 * Nombre de la función:	ReporteActivoFijoDepreciacionNuevo
	 * Propósito:				Desplegar los registros de la depreciacion de los activos fijos
	 * 							segun formato agrupado por tipo de activo
	 * Autor:					Daniel Sanchez Torrico
	 * Fecha de creación:		24-11-2012
	 *
	 * @param integer_type $cant
	 * @param integer_type $puntero
	 * @param string_type  $sortcol
	 * @param string_type  $sortdir
	 * @param string_type  $criterio_filtro
	
	 */
	
	function ReporteActivoFijoDepreciacionNuevo($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_depreciacion_comprobante_sel';
		$this->codigo_procedimiento = "'REP_DEPREC_NUEVO'";
		//$this->codigo_procedimiento = "'AF_DEPRE_NEW'";
		//$this->codigo_procedimiento = "'REP_DEPREC_X_TIPO'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
	
	
		if($criterio_filtro != ""){
			$parametro = "'{";
			foreach($criterio_filtro as $pm)
				$parametro .= "$pm,";
				
			$parametro = trim($parametro, ',');
				
			$parametro .= "}'";
				
			$this->var->criterio_filtro = "$parametro";
				
		}else {
				
			$this->var->criterio_filtro = "'$criterio_filtro'";
		}
	
		//$this->var->add_param("''");
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('descripcion_tipo','varchar');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('cod_activo_fijo','varchar');
		$this->var->add_def_cols('vida_util_actual','integer');
		$this->var->add_def_cols('valor_contable','numeric');
		$this->var->add_def_cols('actualizacion','numeric');
		$this->var->add_def_cols('valor_total','numeric');
		$this->var->add_def_cols('depreciacion_acum_ini','numeric');
		$this->var->add_def_cols('actualizacion_depre','numeric');
		$this->var->add_def_cols('deprec_acum_actualiz','numeric');
		$this->var->add_def_cols('deprec_periodo','numeric');
		$this->var->add_def_cols('deprec_acumulada','numeric');
		$this->var->add_def_cols('valor_neto_real','numeric');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar'); 
		$this->var->add_def_cols('revalorizado','varchar');
		//añadido 13/02/2014
		$this->var->add_def_cols('fecha_ini_dep','date');
		$this->var->add_def_cols('fecha_compra','date');
		$this->var->add_def_cols('nombre_completo','text');
		//añadido 25/02/2014
		$this->var->add_def_cols('descripcion_larga','varchar');
		$this->var->add_def_cols('desc_cta','text');
		$this->var->add_def_cols('desc_cta_depacum','text');
		$this->var->add_def_cols('desc_cta_gasto','text');
		$this->var->add_def_cols('desc_tension_bien','text'); 
		
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		//echo $this->query; exit;
		
		return $res;
	
	
	}
	/**
	 * Nombre de la función:	ReporteActivoFijoDepreciacionNuevo
	 * Propósito:				Desplegar los registros de la depreciacion de los activos fijos
	 * 							segun formato agrupado por tipo de activo
	 * Autor:					Daniel Sanchez Torrico
	 * Fecha de creación:		24-11-2012
	 *
	 * @param integer_type $cant
	 * @param integer_type $puntero
	 * @param string_type  $sortcol
	 * @param string_type  $sortdir
	 * @param string_type  $criterio_filtro
	
	 */
	
	function ReporteActivoFijoDepreciacionNuevoAuditoria($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_depreciacion_comprobante_sel';
		$this->codigo_procedimiento = "'AF_REP_DEPREC_NUEVO_AUDIT'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
	
	
		if($criterio_filtro != ""){
			$parametro = "'{";
			foreach($criterio_filtro as $pm)
				$parametro .= "$pm,";
				
			$parametro = trim($parametro, ',');
				
			$parametro .= "}'";
				
			$this->var->criterio_filtro = "$parametro";
				
		}else {
				
			$this->var->criterio_filtro = "'$criterio_filtro'";
		}
	
		//$this->var->add_param("''");
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('descripcion_tipo','varchar');
		$this->var->add_def_cols('codigo_activo','varchar');
		$this->var->add_def_cols('descripcion_activo','varchar');
		$this->var->add_def_cols('fecha_ini_dep','date');
		$this->var->add_def_cols('monto_compra','numeric');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('cod_activo_fijo','varchar');
		$this->var->add_def_cols('vida_util_actual','integer');
		$this->var->add_def_cols('valor_contable','numeric');
		$this->var->add_def_cols('actualizacion','numeric');
		$this->var->add_def_cols('valor_total','numeric');
		$this->var->add_def_cols('depreciacion_acum_ini','numeric');
		$this->var->add_def_cols('actualizacion_depre','numeric');
		$this->var->add_def_cols('deprec_acum_actualiz','numeric');
		$this->var->add_def_cols('deprec_periodo','numeric');
		$this->var->add_def_cols('deprec_acumulada','numeric');
		$this->var->add_def_cols('valor_neto_real','numeric');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		$this->var->add_def_cols('revalorizado','varchar');
		$this->var->add_def_cols('cuenta_Activo','varchar');
	
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	PDFRespaldoDepreciacion
	 * Propósito:				Desplegar los registros de la depreciacion de los activos fijos
	 * 							segun formato agrupado por tipo de activo
	 * Autor:					Elmer Velasquez
	 * Fecha de creación:		19/03/2014
	 *
	 * @param integer_type $cant
	 * @param integer_type $puntero
	 * @param string_type  $sortcol
	 * @param string_type  $sortdir
	 * @param string_type  $criterio_filtro
	
	 */
	
	function PDFRespaldoDepreciacion($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		
		$this->nombre_funcion = 'f_taf_activo_fijo_depreciacion_cbtereportes_sel';
		
		if($criterio_filtro[1] == 'TRA')
		{
			$criterio_filtro[1] = "%";
			$this->codigo_procedimiento = "'REP_DEPREC_RESP_TRA'";
		}
		else if ($criterio_filtro[1] == 'TDD')
		{
			$this->codigo_procedimiento = "'REP_DEPREC_RESP_TDD'";
		}
		else if($criterio_filtro[1] == 'CBJ')
		{	
			$this->codigo_procedimiento="'REP_DEPREC_RESP_CBJ'";
		}
		else if ($criterio_filtro[1] == 'OFID')
		{
			$this->codigo_procedimiento = "'REP_DEPREC_RESP_OFID'";
		}
		else
			$this->codigo_procedimiento = "'REP_DEPREC_RESP'";
		
		
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
	
		if($criterio_filtro != "")
		{
			$parametro = "'{";
			foreach($criterio_filtro as $pm)
				$parametro .= "$pm,";
	
			$parametro = trim($parametro, ',');
	
			$parametro .= "}'";
	
			$this->var->criterio_filtro = "$parametro";
		}
		else 
		{
			$this->var->criterio_filtro = "'$criterio_filtro'";
		}
			
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('actualizacion','numeric');
		$this->var->add_def_cols('actualizacion_depre','numeric');
		$this->var->add_def_cols('depreciacion_periodo','numeric');
		$this->var->add_def_cols('tension','varchar');
		$this->var->add_def_cols('bienes_produccion','varchar');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('desc_tipo_activo','text');
		$this->var->add_def_cols('desc_regional','text');
		$this->var->add_def_cols('id_plan_ctas','integer');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('desc_cta_activo','text');
		$this->var->add_def_cols('desc_cta_depacum','text');
		$this->var->add_def_cols('desc_cta_gasto','text');

	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ReporteActivoFijoFormulario605($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_depreciacion_comprobante_sel';
		$this->codigo_procedimiento = "'AF_REP_FORM605'";
	
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		if($criterio_filtro != ""){
			$parametro = "'{";
			foreach($criterio_filtro as $pm)
				$parametro .= "$pm,";
	
			$parametro = trim($parametro, ',');
	
			$parametro .= "}'";
	
			$this->var->criterio_filtro = "$parametro";
	
		}else {
	
			$this->var->criterio_filtro = "'$criterio_filtro'";
		}
	
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('cantidad','integer');
		$this->var->add_def_cols('valor_neto','numeric');
		$this->var->add_def_cols('bajas','numeric');
	
	
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
			
		//echo $this->query; exit;
	
		return $res;
	}
	
	//añadido 02/05/2014
	
	function ReporteActivosFijosDepreciacion2($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_depreciacion_comprobante_sel';
		$this->codigo_procedimiento = "'REP_DEPREC_NEW2'";
	
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
	
	
		if($criterio_filtro != ""){
			$parametro = "'{";
			foreach($criterio_filtro as $pm)
				$parametro .= "$pm,";
	
			$parametro = trim($parametro, ',');
	
			$parametro .= "}'";
	
			$this->var->criterio_filtro = "$parametro";
	
		}else {
	
			$this->var->criterio_filtro = "'$criterio_filtro'";
		}
	
		//echo $criterio_filtro[0].'</br>'.$criterio_filtro[1].'</br>'.$criterio_filtro[2];exit;
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('descripcion_tipo','varchar');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('cod_activo_fijo','varchar');
		$this->var->add_def_cols('vida_util_actual','integer');
		$this->var->add_def_cols('valor_contable','numeric');
		$this->var->add_def_cols('actualizacion','numeric');
		$this->var->add_def_cols('valor_total','numeric');
		$this->var->add_def_cols('depreciacion_acum_ini','numeric');
		$this->var->add_def_cols('actualizacion_depre','numeric');
		$this->var->add_def_cols('deprec_acum_actualiz','numeric');
		$this->var->add_def_cols('deprec_periodo','numeric');
		$this->var->add_def_cols('deprec_acumulada','numeric');
		$this->var->add_def_cols('valor_neto_real','numeric');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		$this->var->add_def_cols('revalorizado','varchar');
		//aniadido 08072014
		$this->var->add_def_cols('ubicacion','varchar');
		//añadido 13/02/2014
		$this->var->add_def_cols('fecha_ini_dep','date');
		$this->var->add_def_cols('fecha_compra','date');
		$this->var->add_def_cols('nombre_completo','text');
		//añadido 25/02/2014
		$this->var->add_def_cols('descripcion_larga','varchar');
	
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		//echo $this->query; exit;
	
		return $res;
	}
	// fin 02/05/2014
	function ListarRegionalesDepreciacionNuevo($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_depreciacion_comprobante_sel';
		$this->codigo_procedimiento = "'AF_REG_DEPREC_NEW'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parÃ¡metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
	
		$parametro = "'{";
		foreach($criterio_filtro as $pm)
			$parametro .= "$pm,";
			
		$parametro = trim($parametro, ',');
			
		$parametro .= "}'";
	
		$this->var->criterio_filtro = "$parametro";
		
		$this->var->add_def_cols('id_depreciacion_cbte_regional', 'integer');
		$this->var->add_def_cols('id_grupo_depreciacion', 'integer');
		$this->var->add_def_cols('cod_regional', 'varchar');
		$this->var->add_def_cols('id_depto', 'integer');
		$this->var->add_def_cols('id_depto_aux', 'integer');
		$this->var->add_def_cols('fecha_reg', 'timestamp');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('id_p', 'integer');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('ids_comprobantes', 'integer');
		$this->var->add_def_cols('id_depreciacion_comprobante', 'integer');
	
		$this->var->add_def_cols('desc_depto', 'text');
		$this->var->add_def_cols('id_presupuesto', 'integer');
		$this->var->add_def_cols('desc_presupuesto', 'text');
	
		$this->var->add_def_cols('desc_depto_aux', 'text');
	
		//Ejecuta la funciÃ³n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciÃ³n y retorna el resultado de la ejecuciÃ³n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamÃ³ a la funciÃ³n de postgres
		$this->query = $this->var->query;
		 	//	echo $this->query;exit;
		return $res;
	}
	
	function ModificarDepreciacionCbtesRegional($id_depre_cbte_reg,$id_depto,$regional,$h_id_depto_aux)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_cbte_regional_iud';
		$this->codigo_procedimiento = "'AF_DEPCBTEREG_UPD'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecuciÃ³n de la funciÃ³n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		$this->var->add_param("$id_depre_cbte_reg");//pm_id_depreciacion_cbte_regional
		$this->var->add_param("NULL");//pm_id_grupo_depreciacion
		$this->var->add_param("'$regional'");//pm_cod_regional
		$this->var->add_param("$id_depto");//pm_id_depto
		$this->var->add_param("$h_id_depto_aux");//pm_id_depto_aux
	
	
		//Ejecuta la funciÃ³n de consulta
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la funciÃ³n y retorna el resultado de la ejecuciÃ³n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamÃ³ a la funciÃ³n de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	function CountDepreciacionCbtesRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_cbte_regional_sel';
		$this->codigo_procedimiento = "'AF_DETDEPCBTE_COUNT'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
	
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
	
		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
	
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecuci�n
		return $res;
	}

}?>