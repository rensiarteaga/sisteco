<?php
/**
 * Nombre de la clase:	cls_DBPlanilla.php
 * Propￜsito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_planilla
 * Autor:				avillegas
 * Fecha creaciￜn:		01/09/2010
 */

 
class cls_DBRepPlanilla
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
	
	/**
	 * Nombre de la funciￜn:	ListarPlanilla la cabecera del reporte
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		01/09/2010
	 */ 
	function ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLACAB_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('descripcion',' VARCHAR'); 
 		$this->var->add_def_cols('nombre_depto',' VARCHAR'); 
  		$this->var->add_def_cols('nombre_tipo_planilla',' VARCHAR'); 
 		$this->var->add_def_cols('fecha_planilla',' DATE');
 		$this->var->add_def_cols('numero','VARCHAR'); 
 		$this->var->add_def_cols('nombre_moneda','VARCHAR');
  		$this->var->add_def_cols('id_tipo_planilla',' INTEGER'); 
 		$this->var->add_def_cols('id_depto',' INTEGER');
  		$this->var->add_def_cols('id_planilla','INTEGER'); 
  		$this->var->add_def_cols('id_moneda',' INTEGER');
  		$this->var->add_def_cols('gestion','numeric');
  		$this->var->add_def_cols('periodo','varchar');
  		
  		$this->var->add_def_cols('periodo_anterior','varchar');
  		$this->var->add_def_cols('grupo_periodo','text');
  		
  		$this->var->add_def_cols('num_periodo','numeric');
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;

		/*echo $this->query;
		exit;*/
		return $res;
	}/**
	 * Nombre de la funciￜn:	ListarPlanilla la cabecera del reporte
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		01/09/2010
	 */
	function ListarRepPlanillaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLADET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado',' INTEGER'); 
  	//	$this->var->add_def_cols('id_planilla',' INTEGER'); 
  		//$this->var->add_def_cols('codigo_empleado',' VARCHAR ');
 		//$this->var->add_def_cols('nombre_empleado',' TEXT ');
  		$this->var->add_def_cols('nombre',' VARCHAR'); 
  		$this->var->add_def_cols('valor',' NUMERIC');
  		$this->var->add_def_cols('desc_incr_col',' varchar');
  		$this->var->add_def_cols('total','varchar');
  		/*$this->var->add_def_cols('fecha_ini','text');
 		$this->var->add_def_cols('fecha_nacimiento','text'); 
 		$this->var->add_def_cols('id_unidad_organizacional','INTEGER');
 		$this->var->add_def_cols('codigo','VARCHAR(15)');
  		$this->var->add_def_cols('nombre_cargo','VARCHAR');
  		$this->var->add_def_cols('nivel','INTEGER');
   		$this->var->add_def_cols('prioridad','VARCHAR');
  		$this->var->add_def_cols('area','varchar');
  		*/
  		
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
	  /* if($_SESSION["ss_id_usuario"]==120){
	    echo $this->query;
	exit;
			
	    }*/
		return $res;
	}
	/**
	 * Nombre de la funciￜn:	ListarPlanilla suma de totales de la planilla
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		08/12/2010
	 */
	function ListarRepPlanillaSum($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLASUM_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
			$this->var->add_def_cols('nombre',' VARCHAR'); 
  		$this->var->add_def_cols('sum_valor',' NUMERIC');
  		$this->var->add_def_cols('desc_incr_col',' varchar');
  		$this->var->add_def_cols('total','varchar');
  		$this->var->add_def_cols('columna_reporte','integer');
  		
  		
	/*	$this->var->add_def_cols('id',' VARCHAR'); 
		$this->var->add_def_cols('nombre',' VARCHAR'); 
  		$this->var->add_def_cols('sum_valor',' NUMERIC');
  		$this->var->add_def_cols('desc_incr_col',' varchar');
  		$this->var->add_def_cols('total','varchar');
  		$this->var->add_def_cols('columna_reporte','integer');*/
  		
  		
  		 
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
		/**
	 * Nombre de la funciￜn:	ListarPlanilla el detalle de columnas
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		03/09/2010
	 */
	function ListarRepPlanillaCol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLACOL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('id_columna_tipo','INTEGER'); 
  		$this->var->add_def_cols('id_planilla','INTEGER'); 
 		$this->var->add_def_cols('nombre','varchar');
 		$this->var->add_def_cols('desc_incr_col',' varchar');
  		$this->var->add_def_cols('total','varchar');
  		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funciￜn:	ListarPlanilla el detalle de columnas
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		28/10/2010
	 */
	function ListaPlanillaSueldoNetoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLASUNE_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		   $this->var->add_def_cols('codigo_empleado',' VARCHAR');  
  		   $this->var->add_def_cols('nombre_completo','TEXT');  
   		   $this->var->add_def_cols('codigo','VARCHAR');  
   		   $this->var->add_def_cols('valor',' NUMERIC(18,2)');  
   		   $this->var->add_def_cols('id_tipo_planilla',' INTEGER');  
   		   $this->var->add_def_cols('id_columna','INTEGER');  
   		   $this->var->add_def_cols('id_columna_tipo','INTEGER');  
   		   $this->var->add_def_cols('id_empleado','INTEGER'); 
		 
		   $this->var->add_def_cols('prioridad','varchar'); 
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit;*/
		return $res;
	}
	
	
	/**
	 * Nombre de la funciￜn:	ListarPlanilla el detalle de columnas
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		28/10/2010
	 */
	function ListaPapeletaSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_BOLPAG_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		  $this->var->add_def_cols('codigo_empleado','VARCHAR(20)'); 
  		  $this->var->add_def_cols('nombre_completo','TEXT'); 
  		  $this->var->add_def_cols('nombre_cargo','VARCHAR(50)'); 
  		  $this->var->add_def_cols('codigo','VARCHAR(30)');
  		  $this->var->add_def_cols('valor','NUMERIC(18,2)'); 
  		  $this->var->add_def_cols('id_tipo_planilla','INTEGER'); 
  		  $this->var->add_def_cols('id_columna','INTEGER');
  		  $this->var->add_def_cols('id_columna_tipo','INTEGER'); 
  		  $this->var->add_def_cols('id_empleado','INTEGER'); 
  		  $this->var->add_def_cols('nivel',' INTEGER');
   		  $this->var->add_def_cols('liq_pag_literal','varchar');
		  $this->var->add_def_cols('saldo_rc_iva',' numeric');
		    $this->var->add_def_cols('prioridad',' varchar');
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		
		/*if($_SESSION['ss_id_usuario']==131){
		echo $this->query;
		exit;
			
		}*/
		return $res;
	}
	
	/**
	 * Nombre de la funciￜn:	ListarPlanillaAguinaldo el detalle de columnas
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		16/01/2012
	 */
	function ListaPapeletaAguinaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_BOLAGUI_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		  $this->var->add_def_cols('codigo_empleado','VARCHAR(20)'); 
  		  $this->var->add_def_cols('nombre_completo','TEXT'); 
  		  $this->var->add_def_cols('nombre_cargo','VARCHAR(50)'); 
  		  $this->var->add_def_cols('codigo','VARCHAR(30)');
  		  $this->var->add_def_cols('valor','NUMERIC(18,2)'); 
  		  $this->var->add_def_cols('id_tipo_planilla','INTEGER'); 
  		  $this->var->add_def_cols('id_columna','INTEGER');
  		  $this->var->add_def_cols('id_columna_tipo','INTEGER'); 
  		  $this->var->add_def_cols('id_empleado','INTEGER'); 
  		  $this->var->add_def_cols('nivel',' INTEGER');
   		  $this->var->add_def_cols('liq_pag_literal','varchar');
		  $this->var->add_def_cols('saldo_rc_iva',' numeric');
		  $this->var->add_def_cols('prioridad',' varchar');
		  $this->var->add_def_cols('tot_dias','integer');
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		
	/*	if($_SESSION['ss_id_usuario']==120){
		*/
		
		/*echo $this->query;
		exit;*/
			/*
		}*/
		return $res;
	}
/**
	 * Nombre de la funciￜn:	ListarPapeletaPrima el detalle de columnas
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		07/05/2013
	 */
	function ListaPapeletaPrima($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_BOLPRIM_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		  $this->var->add_def_cols('codigo_empleado','VARCHAR(20)'); 
  		  $this->var->add_def_cols('nombre_completo','TEXT'); 
  		  $this->var->add_def_cols('nombre_cargo','VARCHAR(50)'); 
  		  $this->var->add_def_cols('codigo','VARCHAR(30)');
  		  $this->var->add_def_cols('valor','NUMERIC(18,2)'); 
  		  $this->var->add_def_cols('id_tipo_planilla','INTEGER'); 
  		  $this->var->add_def_cols('id_columna','INTEGER');
  		  $this->var->add_def_cols('id_columna_tipo','INTEGER'); 
  		  $this->var->add_def_cols('id_empleado','INTEGER'); 
  		  $this->var->add_def_cols('nivel',' INTEGER');
   		  $this->var->add_def_cols('liq_pag_literal','varchar');
		  $this->var->add_def_cols('saldo_rc_iva',' numeric');
		    $this->var->add_def_cols('prioridad',' varchar');
			   $this->var->add_def_cols('tot_dias','integer');
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		
	/*	if($_SESSION['ss_id_usuario']==120){
		*/
		
		/*echo $this->query;
		exit;*/
			/*
		}*/
		return $res;
	}
	
	
	
	/**
	 * Nombre de la funciￜn:	ListarPlanilla el detalle de columnas
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		28/10/2010
	 */
	function ListaPlanillaImpositiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLAIMP_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		  $this->var->add_def_cols('codigo_empleado','VARCHAR(20)'); 
  		  $this->var->add_def_cols('nombre_completo','TEXT'); 
  		  $this->var->add_def_cols('codigo','VARCHAR(30)');
  		  $this->var->add_def_cols('valor','NUMERIC(18,2)'); 
  		  $this->var->add_def_cols('id_lugar_trabajo','INTEGER'); 
  		  $this->var->add_def_cols('nombre','varchar');
  		  $this->var->add_def_cols('id_actividad','INTEGER'); 
  		 
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	/**
	 * Nombre de la funciￜn:	ListarSumPlanillaDet  detalle
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		21/01/2011
	 */
	function ListarSumRepPlanillaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_RESUMPLA_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('id_uo',' INTEGER'); 
  		$this->var->add_def_cols('desc_uo','varchar'); 
  		$this->var->add_def_cols('desc_lugar','text ');
 		$this->var->add_def_cols('nombre_tipo_col',' varchar ');
  		$this->var->add_def_cols('valor',' numeric'); 
  		$this->var->add_def_cols('desc_incr_col',' varchar');
  		$this->var->add_def_cols('total','varchar');
  	//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
	   /* if($_SESSION["ss_id_usuario"]==131){
	    echo $this->query;
	    exit;
		     	
	    } */  
		return $res;
	}
/**
	 * Nombre de la funciￜn:	ListarPlanillaImpositiva el detalle de columnas
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		01/02/2011
	 */
	function ListaPlanillaImpositivaAreas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLAIMPAR_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		
		/*hisasi.id_unidad_organizacional,
                              uniorg.prioridad,
                              uniorg.area,
                              uniorg.nombre_unidad,
                              emp.codigo_empleado,
                              emp.nombre_completo,
                              col.codigo,
                              colval.valor*/
		
		  $this->var->add_def_cols('id_unidad_organizacional','integer'); 
		  $this->var->add_def_cols('prioridad','VARCHAR');
		  $this->var->add_def_cols('area','VARCHAR');
		  $this->var->add_def_cols('desc_uo','VARCHAR'); 
		  $this->var->add_def_cols('codigo_empleado','VARCHAR'); 
  		  $this->var->add_def_cols('nombre_completo','text'); 
  		  $this->var->add_def_cols('codigo','VARCHAR');
  		  $this->var->add_def_cols('valor','NUMERIC'); 
  		  
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	
	function ListarEmpleadoCuentasBancRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_EMPCUE_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo_empleado',' VARCHAR'); 
        $this->var->add_def_cols('nombre_completo',' text'); 
        $this->var->add_def_cols('nro_cuenta',' VARCHAR'); 
        $this->var->add_def_cols('valor','numeric'); 
        $this->var->add_def_cols('nombre_banco',' VARCHAR'); 
  		$this->var->add_def_cols('estado',' VARCHAR'); 
  		
  		$this->var->add_def_cols('id_lugar',' integer');
  		$this->var->add_def_cols('nombre_lugar','text');
  		$this->var->add_def_cols('prioridad_org',' varchar');
		$this->var->add_def_cols('prioridad_kard',' varchar');
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
	/* if($_SESSION["ss_id_usuario"]==131){
	      echo $this->query;
	    exit;
		     	
	    }*/  
	    return $res;
	}
	
	/**Autor: Ana Maria Villegas Quispe
	 * Descripci�n:  Empleado con Bonos de TE,transporte y ropa y anticipo.
	 * Fecha 06/03/2011
	*/
	function ListarEmpleadoBonos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_EMPBONO_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		     $this->var->add_def_cols('codigo_empleado',' VARCHAR'); 
           $this->var->add_def_cols('nombre_completo',' text'); 
          // $this->var->add_def_cols('nro_cuenta',' VARCHAR'); 
            $this->var->add_def_cols('valor','numeric'); 
            $this->var->add_def_cols('nro_cuenta',' VARCHAR');
            $this->var->add_def_cols('nombre_lugar','text'); 
			$this->var->add_def_cols('prioridad','varchar'); 
         	
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;
		return $res;
	}
	/**Autor: Ana Maria Villegas Quispe
	 * Descripci�n:  Sumas totales de Empleado con Bonos de TE,transporte y ropa y anticipo.
	 * Fecha 16/05/2011
	*/
	function ListarSumEmpleadoBonos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_EMPBONOSUM_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_lugar','text'); 
		  /*   $this->var->add_def_cols('codigo_empleado',' VARCHAR'); 
           $this->var->add_def_cols('nombre_completo',' text'); 
          */// $this->var->add_def_cols('nro_cuenta',' VARCHAR'); 
            $this->var->add_def_cols('valor','numeric'); 
         //  $this->var->add_def_cols('nro_cuenta',' VARCHAR');
            
          
  		
  		
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
	/*if($_SESSION["ss_id_usuario"]==120){
	    echo $this->query;
	exit;
		   	
	    }*/
		return $res;
	}
	
	/**
	 * Nombre de la funciￜn:	SumEmpleadoDistrito
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		25/03/2011
	 */
	function SumEmpleadoDistrito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_RESUMDIS_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		 $this->var->add_def_cols('id_lugar_trabajo','INTEGER'); 
		  $this->var->add_def_cols('nombre_trabajo','varchar'); 
		 $this->var->add_def_cols('nombre',' VARCHAR'); 
         $this->var->add_def_cols('sum_valor',' NUMERIC'); 
         $this->var->add_def_cols('desc_incr_col',' VARCHAR'); 
         $this->var->add_def_cols('total',' VARCHAR'); 
         $this->var->add_def_cols('columna_orden_reporte',' integer'); 
         $this->var->add_def_cols('total_emp_x_dist','bigint'); 
         $this->var->add_def_cols('prioridad_kard','varchar');
         
	
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
	/* echo $this->query;
		exit;*/
		return $res;
	}
	/**
	 * Nombre de la funciￜn:	ListarPlanillaDatosEmpleado el detalle de columnas
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		21/03/2011
	 */
	
	function ListaPlanillaDatosEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLADAEM_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $id_actividad;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado',' INTEGER'); 
  		$this->var->add_def_cols('id_planilla',' INTEGER'); 
  		$this->var->add_def_cols('codigo_empleado',' VARCHAR ');
 		$this->var->add_def_cols('nombre_empleado',' TEXT ');
  	
  		$this->var->add_def_cols('fecha_ini','text');
 		$this->var->add_def_cols('fecha_nacimiento','text'); 
 		$this->var->add_def_cols('id_unidad_organizacional','INTEGER');
 		$this->var->add_def_cols('codigo','VARCHAR(15)');
  		$this->var->add_def_cols('nombre_cargo','VARCHAR');
  		$this->var->add_def_cols('nivel','INTEGER');
   		$this->var->add_def_cols('prioridad','VARCHAR');
  		$this->var->add_def_cols('area','varchar');
  		$this->var->add_def_cols('id_lugar_trabajo','INTEGER'); 
  		$this->var->add_def_cols('nombre_lugar_trabajo','TEXT');  
  		
  		
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
	  
		return $res;
	}
	/**
	 * Nombre de la funciￜn:	Asignaciones de empleados
	 * Propￜsito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaciￜn:		10/04/2011
	 */
	
	function ListaHistoricosAsignacionesEmpleados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_historicos';
		$this->codigo_procedimiento = "'KP_HISASIG_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciￜn de columnas con sus tipos de datos
		
		$this->var->add_def_cols('nombre_unidad',' VARCHAR ');
        $this->var->add_def_cols('nombre_cargo',' VARCHAR ');
        $this->var->add_def_cols('prioridad',' VARCHAR ');
         $this->var->add_def_cols('area',' VARCHAR ');
         $this->var->add_def_cols('fecha_asignacion','text');
          $this->var->add_def_cols('fecha_finalizacion','text ');
          $this->var->add_def_cols('desc_persona','text');
          $this->var->add_def_cols('estado',' VARCHAR ');
		
		
		
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
	exit;*/
		return $res;
	}
	
	
	
	
	//ENDE-001:MZM - 19dic12: Para reporte de planilla de aguinaldo con formato para presentacion a Jef. de trabajo
	
	/**
	 * Nombre de la funci�n:	ListarEmpleadoPlanilla
	 * Prop�sito:				Desplegar los registros de tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:48
	 */
	function ListarRepPlanillaAguinaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_planilla)
	{
		
				
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_dinamica_sel';
		$this->codigo_procedimiento = "'KP_PLAGUIN_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
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
		$this->var->add_param($id_planilla);//id_actividad
		$this->var->add_param($id_planilla);//id_actividad
		
	
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('apellido_paterno','varchar');
		$this->var->add_def_cols('apellido_materno','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('cargo','varchar');
		$this->var->add_def_cols('dias','numeric');
		$this->var->add_def_cols('sueldo1','numeric');
		$this->var->add_def_cols('sueldo2','numeric');
		$this->var->add_def_cols('sueldo3','numeric');
		$this->var->add_def_cols('total','numeric');
		$this->var->add_def_cols('id_empleado_planilla','int4');
		$this->var->add_def_cols('gestion','numeric');
		
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//if($_SESSION["ss_id_usuario"]==120){echo $this->query; exit;}
		
		
		return $res;
	}
	
	
	
	/**
	 * Nombre de la funci�n:	ContarEmpleadoPlanilla
	 * Prop�sito:				Contar los registros de tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:48
	 */
	function ContarRepPlanillaAguinaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_planilla,$id_tipo_planilla,$cc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_dinamica_sel';
		$this->codigo_procedimiento = "'KP_PLAGUIN_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
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
		
		
		$this->var->add_param($id_planilla);//id_actividad
		$this->var->add_param($id_tipo_planilla);//id_actividad

		
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
	
	
	/**
	 * Nombre de la funci�n:	ListarRepPlanillaPrimas
	 * Prop�sito:				Contar los registros de tkp_empleado_planilla
	 * Autor:				    AVQ
	 * Fecha de creaci�n:		2013-05-07
	 */
	function ListarRepPlanillaPrimas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_planilla,$id_tipo_planilla,$cc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_dinamica_sel';
		$this->codigo_procedimiento = "'KP_PLAPRIM_SEL'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
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
		
		
		$this->var->add_param($id_planilla);//id_actividad
		$this->var->add_param($id_tipo_planilla);//id_actividad

		
		//Carga la definici�n de columnas con sus tipos de datos
		
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('apellido_paterno','varchar');
		$this->var->add_def_cols('apellido_materno','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('cargo','varchar');
		$this->var->add_def_cols('dias','numeric');
		$this->var->add_def_cols('sueldo1','numeric');
		$this->var->add_def_cols('sueldo2','numeric');
		$this->var->add_def_cols('sueldo3','numeric');
		$this->var->add_def_cols('total','numeric');
		$this->var->add_def_cols('id_empleado_planilla','int4');
		$this->var->add_def_cols('gestion','numeric');
		
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
	//ago2016
	function ListaPlanillaDatosEmpleadoCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLADAEMCPS_REP'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $id_actividad;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	
		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado',' INTEGER');
		$this->var->add_def_cols('id_planilla',' INTEGER');
		$this->var->add_def_cols('codigo_empleado',' VARCHAR ');
		$this->var->add_def_cols('nombre_empleado',' TEXT ');
			
		$this->var->add_def_cols('fecha_ini','text');
		$this->var->add_def_cols('fecha_nacimiento','text');
		$this->var->add_def_cols('id_unidad_organizacional','INTEGER');
		$this->var->add_def_cols('codigo','VARCHAR(15)');
		$this->var->add_def_cols('nombre_cargo','VARCHAR');
		$this->var->add_def_cols('nivel','INTEGER');
		$this->var->add_def_cols('prioridad','VARCHAR');
		$this->var->add_def_cols('area','varchar');
		$this->var->add_def_cols('id_lugar_trabajo','INTEGER');
		$this->var->add_def_cols('nombre_lugar_trabajo','TEXT');
	
		$this->var->add_def_cols('codigo_cps','varchar');
	
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
			
		return $res;
	}
	
	function SumEmpleadoDistritoCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_RESUMDISCPS_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	
		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('id_lugar_trabajo','INTEGER');
		$this->var->add_def_cols('nombre_trabajo','varchar');
		$this->var->add_def_cols('nombre',' VARCHAR');
		$this->var->add_def_cols('sum_valor',' NUMERIC');
		$this->var->add_def_cols('desc_incr_col',' VARCHAR');
		$this->var->add_def_cols('total',' VARCHAR');
		$this->var->add_def_cols('columna_orden_reporte',' integer');
		$this->var->add_def_cols('total_emp_x_dist','bigint');
		$this->var->add_def_cols('prioridad_kard','varchar');
		$this->var->add_def_cols('codigo','varchar');
	
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		/* echo $this->query;
		 exit;*/
		return $res;
	}
	
	
	function ListarRepPlanillaDetCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLADETCPS_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	
		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado',' INTEGER');
	
		$this->var->add_def_cols('nombre',' VARCHAR');
		$this->var->add_def_cols('valor',' NUMERIC');
		$this->var->add_def_cols('desc_incr_col',' varchar');
		$this->var->add_def_cols('total','varchar');
		$this->var->add_def_cols('codigo','varchar');
	
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
		//echo '---->'.$this->query; exit;
		return $res;
	}
	
	
	
	function ListarRepPlanillaSumCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLASUMCPS_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecuciￜn de la funciￜn de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parￜmetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		//Carga los parￜmetros especￜficos de la estructura programￜtica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	
		//Carga la definiciￜn de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre',' VARCHAR');
		$this->var->add_def_cols('sum_valor',' NUMERIC');
		$this->var->add_def_cols('desc_incr_col',' varchar');
		$this->var->add_def_cols('total','varchar');
		$this->var->add_def_cols('columna_reporte','integer');
		$this->var->add_def_cols('codigo','varchar');
	
	
		//Ejecuta la funciￜn de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciￜn y retorna el resultado de la ejecuciￜn
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamￜ a la funciￜn de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
}?>