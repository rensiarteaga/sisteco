<?php
/**
 * Nombre de la Clase:	cls_DBReporteActivoFijoResponsableCustodio
 * Propósito:			Permite Generar Nuevos Reportes
 * Autor:				Daniel Sanchez Torrico
 * Fecha creación:		18/10/2012
 *
 */
class cls_DBReporteActivoFijoResponsableCustodio
{
	//Variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;

	//Variable que contedrá la cadena de llamada a las funciones postgres
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
	 * Nombre de la función:	ReporteActivoFijoResponsableCustodio
	 * Propósito:				Desplegar los registros de taf_activo_fijo, taf_activo_fijo_empleado, tkp_empleado, tsg_persona 
	 * Autor:					Daniel Sanchez Torrico
	 * Fecha de creación:		18-10-2012
	 *
	 * @param integer_type $cant
	 * @param integer_type $puntero
	 * @param string_type  $sortcol
	 * @param string_type  $sortdir
	 * @param string_type  $criterio_filtro

	 */
	function ReporteActivoFijoResponsableCustodio($cant,$puntero,$sortcol,$sortdir,$codigo_procedimiento,$criterio_filtro,$criterio_filtro_2 = '')
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_rep_activo_fijo_responsable_custodio';
		$this->codigo_procedimiento = "'$codigo_procedimiento'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_param("'$criterio_filtro_2'");

	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('cod_activo_fijo','varchar');
		$this->var->add_def_cols('desc_activo_fijo','varchar');
		$this->var->add_def_cols('desc_larg_activo_fijo','varchar');
		//$this->var->add_def_cols('monto_compra','numeric');//estose anadio
		$this->var->add_def_cols('nomb_responsable','text');
		$this->var->add_def_cols('nomb_custodio','varchar');
		$this->var->add_def_cols('ubi_fis_activo','varchar');
		$this->var->add_def_cols('obs_activo_fijo','varchar');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res;
		
		
	}
	
	function ReporteActivoFijoResponsableCustodioGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_rep_activo_fijo_responsable_custodio';
		$this->codigo_procedimiento = "'ACT_FIJ_RESP_SEL_GEN'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('cod_activo_fijo','varchar');
		$this->var->add_def_cols('desc_activo_fijo','varchar');
		$this->var->add_def_cols('desc_larg_activo_fijo','varchar');
		$this->var->add_def_cols('vida_util_original','integer');
		$this->var->add_def_cols('vida_util_restante','integer');
		$this->var->add_def_cols('tasa_depreciacion','numeric');
		$this->var->add_def_cols('fecha_ultima_depreciacion','date');
		$this->var->add_def_cols('depreciacion_acumulada_ant','numeric');
		$this->var->add_def_cols('depreciacion_acumulada','numeric');
		$this->var->add_def_cols('depreciacion_periodo','numeric');
		$this->var->add_def_cols('flag_revalorizacion','varchar');
		$this->var->add_def_cols('valor_rescate','numeric');
		$this->var->add_def_cols('fecha_compra','date');
		$this->var->add_def_cols('monto_compra_mon_orig','numeric');
		$this->var->add_def_cols('monto_compra','numeric');
		$this->var->add_def_cols('monto_actual','numeric');
		$this->var->add_def_cols('con_garantia','varchar');
		$this->var->add_def_cols('num_poliza_garantia','varchar');
		$this->var->add_def_cols('fecha_fin_garantia','date');
		$this->var->add_def_cols('fecha_registro','timestamp');
		$this->var->add_def_cols('num_factura','varchar');
		$this->var->add_def_cols('tipo_cambio','numeric');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('fecha_ini_dep','date');
		$this->var->add_def_cols('ubicacion_fisica','varchar');
		$this->var->add_def_cols('orden_compra','varchar');
		$this->var->add_def_cols('monto_actualizado','numeric');
		$this->var->add_def_cols('origen','varchar');
		$this->var->add_def_cols('estado_anterior','varchar');
		$this->var->add_def_cols('clonacion' ,'varchar');
		$this->var->add_def_cols('proyecto' ,'varchar');
		$this->var->add_def_cols('tipo_af_bien' ,'varchar');
		$this->var->add_def_cols('codigo_anterior' ,'varchar');
		$this->var->add_def_cols('observaciones_activo' ,'varchar');
		
		$this->var->add_def_cols('estado_asignacion' ,'varchar');
		$this->var->add_def_cols('fecha_asignacion' ,'date');
		$this->var->add_def_cols('fecha_fin_asignacion' ,'date');
		$this->var->add_def_cols('fecha_max_prestamo' ,'date');
		$this->var->add_def_cols('sw_prestamo' ,'varchar');
		$this->var->add_def_cols('tipo' ,'varchar');
		$this->var->add_def_cols('observacion_asignacion' ,'varchar');
		
		$this->var->add_def_cols('codigo_empleado' ,'varchar');
		$this->var->add_def_cols('nombre_empleado' ,'text');
		$this->var->add_def_cols('fecha_nacimiento_emp' ,'date');
		$this->var->add_def_cols('doc_id_emp' ,'varchar');
		$this->var->add_def_cols('genero_emp' ,'varchar');
		$this->var->add_def_cols('casilla_emp' ,'varchar');
		$this->var->add_def_cols('telefono1_emp' ,'varchar');
		$this->var->add_def_cols('telefono2_emp' ,'varchar');
		$this->var->add_def_cols('celular1_emp' ,'varchar');
		$this->var->add_def_cols('celular2_emp' ,'varchar');
		$this->var->add_def_cols('email1_emp' ,'varchar');
		$this->var->add_def_cols('email2_emp' ,'varchar');
		$this->var->add_def_cols('email3_emp' ,'varchar');
		$this->var->add_def_cols('observaciones_empleado' ,'text');

		$this->var->add_def_cols('nombre_custodio' ,'varchar');
		$this->var->add_def_cols('fecha_nacimiento_cus' ,'date');
		$this->var->add_def_cols('doc_iden_cust' ,'varchar');
		$this->var->add_def_cols('genero_cus' ,'varchar');
		$this->var->add_def_cols('casilla_cus' ,'varchar');
		$this->var->add_def_cols('telefono1_cus' ,'varchar');
		$this->var->add_def_cols('telefono2_cus' ,'varchar');
		$this->var->add_def_cols('celular1_cus' ,'varchar');
		$this->var->add_def_cols('celular2_cus' ,'varchar');
		$this->var->add_def_cols('email1_cus' ,'varchar');
		$this->var->add_def_cols('email2_cus' ,'varchar');
		$this->var->add_def_cols('email3_cus' ,'varchar');
		$this->var->add_def_cols('direccion' ,'varchar');
		$this->var->add_def_cols('nro_registro' ,'varchar');
		$this->var->add_def_cols('extension' ,'varchar');
		$this->var->add_def_cols('numero' ,'bigint');
		$this->var->add_def_cols('expedicion' ,'varchar');
		$this->var->add_def_cols('observaciones_custodio' ,'text');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
		
		
	}

	/**
	 * Nombre de la función:	ReporteDescripcionActivoFijo
	 * Propósito:				Desplegar los registros de taf_activo_fijo, para un reporte personalizado
	 * Autor:					Daniel Sanchez Torrico
	 * Fecha de creación:		18-10-2012
	 *
	 * @param integer_type $cant
	 * @param integer_type $puntero
	 * @param string_type  $sortcol
	 * @param string_type  $sortdir
	 * @param string_type  $criterio_filtro
	
	 */
	function ReporteDescripcionActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_rep_activo_fijo_responsable_custodio';
		$this->codigo_procedimiento = "'AF_ACTIVO_EX_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_param("''");
	
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('cod_activo_fijo','varchar');
		//$this->var->add_def_cols('desc_activo_fijo','varchar');
		$this->var->add_def_cols('desc_larg_activo_fijo','varchar');
		$this->var->add_def_cols('monto_compra','numeric');
		//$this->var->add_def_cols('proyecto','varchar');
	
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	
	
	}
	


}?>