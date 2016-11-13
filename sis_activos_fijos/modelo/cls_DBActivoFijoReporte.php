<?php
/**
 * Nombre de la Clase:	cls_DBActivoFijo
 * Propï¿½sito:			Permite ejecutar la funcionalidad de la tabla taf_activo_fijo
 * Autor:				Silvia Ximena Ortiz Fernï¿½ndez
 * Fecha creaciï¿½n:		06-01-2011
 *
 */
class cls_DBActivoFijoReporte
{
	var $salida;

	//Variable que contedrï¿½ la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecuciï¿½n de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la funciï¿½n a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBActivoFijoReporte.php";

	//Matriz de parï¿½metros de validaciï¿½n de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarï¿½n o no
	var $decodificar = false;

	function __construct($decodificar)
	{	
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	
	//SOXF: 06/01/2011
	function ListarActivoFijoEmpleadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_rep_sel';
		$this->codigo_procedimiento = "'AF_ACFIEMP_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//$this->var->add_param($func->iif($id_fina_regi_prog_proy_acti == '',"'%'","'$id_fina_regi_prog_proy_acti'"));//id_ep
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_activo_fijo_empleado','integer');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('subtipo','varchar');
		$this->var->add_def_cols('denominacion','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('sw_prestamo','varchar');
		$this->var->add_def_cols('fecha_max_prestamo','date');
		$this->var->add_def_cols('observaciones_asignacion','varchar');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		//echo $this->query; exit;
		return $res;
	}	
	
	//RCM: 29/04/2011
	function ListarActivoFijoEmpleadoDetalle2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_rep_sel';
		$this->codigo_procedimiento = "'AF_ACFIEMP2_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//$this->var->add_param($func->iif($id_fina_regi_prog_proy_acti == '',"'%'","'$id_fina_regi_prog_proy_acti'"));//id_ep
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		//$this->var->add_def_cols('id_activo_fijo_empleado','integer');
		//$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('tipo_af_bien','varchar');
		$this->var->add_def_cols('denominacion','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('ubicacion_fisica','varchar');
		$this->var->add_def_cols('observaciones_asignacion','varchar');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('resp_af','text');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		//echo $this->query;
		//exit;
		return $res;
	}	
	
	/*------------------------------- LISTA REPORTE DETALLE ACTIVO FIJO------------------------------*/
	/*------------------- Adicionado por Marcos A. Flores Valda en fecha : 03-02-11 -----------------*/
	
	function ReporteDetalleAFNom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_detalle_activo_fijo';
		$this->codigo_procedimiento = "'AF_DETALLE_AF_NOM'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
				
		//Carga la definiciï¿½n de columnas con sus tipos de datos	
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');			
		$this->var->add_def_cols('estado','varchar');	
  		$this->var->add_def_cols('estado_funcional','varchar');
  		$this->var->add_def_cols('fecha_compra','text');
  		$this->var->add_def_cols('monto_compra','numeric');  		
  		$this->var->add_def_cols('ubicacion','varchar');
		$this->var->add_def_cols('responsable','text'); 
		$this->var->add_def_cols('unidad_organizacional','varchar');  
		  				
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();		

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		//echo $this->query;exit;
				
		return $res;
	}
	
	function ReporteDetalleAFDesc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_detalle_activo_fijo';
		$this->codigo_procedimiento = "'AF_DETALLE_AF_DESC'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
				
		//Carga la definiciï¿½n de columnas con sus tipos de datos	
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');	
		$this->var->add_def_cols('estado','varchar');
  		$this->var->add_def_cols('estado_funcional','varchar');
  		$this->var->add_def_cols('fecha_compra','text');
  		$this->var->add_def_cols('monto_compra','numeric');  	//	
  		$this->var->add_def_cols('ubicacion','varchar');
		$this->var->add_def_cols('responsable','text'); //
		$this->var->add_def_cols('unidad_organizacional','varchar');  
		  				
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();		

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;	
		
		//echo $this->query;exit;
				
		return $res;		
	}
	
	/*--------------------------------------- FIN REPORTE DETALLE ACTIVO FIJO ------------------------------*/
	/*--------------------------------------- INICIO REPORTE DETALLE ACTIVO FIJO MEJORADO------------------------------*/
	/* Author: Daniel Sanchez Torrico
	 * fecha:  09/04/2013
	*/
	function ReporteDetalleActivoFijoAnalisis($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$criterio_cabeceras)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_detalle_activo_fijo';
		$this->codigo_procedimiento = "'AF_DETALLE_AF_MEJ'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param("'$criterio_cabeceras'");//cabeceras del reporte
		//$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	
	
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$posiciones = $_SESSION['posiciones_cabeceras'];
	
		$tipo_cabeceras = array(
				'varchar',//codigo
				'varchar',//nombre
				'varchar',//descripcion
				'varchar',//tipo_activo
				'varchar',//subtipo_activo
				'varchar',//estado
				'varchar',//estado_funcional
				'text',//fecha_compra
				'text',//fecha_inicio_depreciacion
				'numeric',//monto_compra
				'varchar',//num_factura
				'varchar',//orden_compra
				'numeric',//monto_actual
				'numeric',//monto_actualiz
				'varchar',//ubicacio
				'integer',//vida_util_original
				'integer',//vida_util_restante
				'varchar',//flag_revaloriz
				'varchar',//proyecto
				'varchar',//observaciones
				'varchar',//origen
				'text',//responsable
				'text',//custodio
				'varchar',//unidad_organizacional
				'varchar',//nombre_financiador
				'varchar',//nombre_regional
				'varchar',//nombre_programa
				'varchar',//nombre_proyecto
				'varchar',//nombre_actividad
				'text',//desc_epe
				'varchar'//nombre_depto 
				,'integer'//id_comprobante
				,'date'//fecha_cbte
				,'varchar'//UO ACTIVO FIJO
				
				//añadido 14/07/2015
				,'varchar'//cod_programa
				,'varchar'//tension
		);
	
		$numero_col = 0 ;
		foreach($posiciones as $pos){
			$this->var->add_def_cols('columna'.$numero_col,$tipo_cabeceras[$pos]);
			$numero_col++;
		}
		//añadido 14/07/2015
		$this->var->add_def_cols('tension',$tipo_cabeceras[33]);
		$this->var->add_def_cols('cod_programa',$tipo_cabeceras[34]);
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		return $res;
	}

	//añadido 29/04/2014
	/****Genera el reporte de las bajas de los activos fijos correspondientes a proyectos y n proyectos****/
	function ListarActivoBaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_rep_sel';
		$this->codigo_procedimiento = "'AF_REP_BAJAS'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	
	
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('activo_fijo','text');
		$this->var->add_def_cols('desc_tipo','varchar');
		$this->var->add_def_cols('desc_subtipo','varchar');
		$this->var->add_def_cols('estructura_programatica','text');
		$this->var->add_def_cols('desc_proceso','text');
		$this->var->add_def_cols('fecha_contabilizacion','date');
		$this->var->add_def_cols('ubicacion','text');
		$this->var->add_def_cols('fecha_compra','date'); 
		$this->var->add_def_cols('monto_compra','numeric');
		$this->var->add_def_cols('monto_actualizado','numeric');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		$this->var->add_def_cols('valor_neto','numeric');
		$this->var->add_def_cols('vida_util_restante','integer');
		
		
		
		$this->var->add_def_cols('proyecto','varchar');
		//$this->var->add_def_cols('id_activo_fijo','integer');
		//$this->var->add_def_cols('id_grupo_proceso','integer');
		//$this->var->add_def_cols('id_proceso','integer');
		//$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		//$this->var->add_def_cols('id_tipo_activo','integer');
	
	
	
	
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	
		//echo $this->query;exit;
		return $res;
	}
	// fin añadido 29/04/2014
	
	function ReporteTipoSubtipoActivoFijo($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_rep_sel';
		$this->codigo_procedimiento = "'AF_REP_TIPOSUBTIPO'"; 
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	
	
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('fila','bigint');
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('cod_tipo','varchar');
		$this->var->add_def_cols('desc_tipo','varchar');
		$this->var->add_def_cols('flag_depreciacion','varchar');
		$this->var->add_def_cols('estado_tipo','varchar');
		$this->var->add_def_cols('id_sub_tipo_activo','integer');
		$this->var->add_def_cols('cod_subtipo','varchar');
		$this->var->add_def_cols('desc_subtipo','varchar');
		$this->var->add_def_cols('vida_util','integer');
		$this->var->add_def_cols('estado_subtipo','varchar');
		$this->var->add_def_cols('desc_carac','varchar');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	
}?>