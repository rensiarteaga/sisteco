<?php
/**
 * Nombre de la clase:	cls_DBPlanilla.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_planilla
 * Autor:				avillegas
 * Fecha creaci�n:		01/09/2010
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
	 * Nombre de la funci�n:	ListarPlanilla la cabecera del reporte
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		01/09/2010
	 */
	function ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLACAB_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
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
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
/**
	 * Nombre de la funci�n:	ListarPlanilla la cabecera del reporte
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		01/09/2010
	 */
	function ListarRepPlanillaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLADET_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado',' INTEGER'); 
  		$this->var->add_def_cols('id_planilla',' INTEGER'); 
  		$this->var->add_def_cols('codigo_empleado',' VARCHAR ');
 		$this->var->add_def_cols('nombre_empleado',' TEXT ');
  		$this->var->add_def_cols('nombre',' VARCHAR'); 
  		$this->var->add_def_cols('valor',' NUMERIC');
  		$this->var->add_def_cols('desc_incr_col',' varchar');
  		$this->var->add_def_cols('total','varchar');
  		$this->var->add_def_cols('fecha_ini','text');
 		$this->var->add_def_cols('fecha_nacimiento','text'); 
 		$this->var->add_def_cols('id_unidad_organizacional','INTEGER');
 		$this->var->add_def_cols('codigo','VARCHAR(15)');
  		$this->var->add_def_cols('nombre_cargo','VARCHAR');
  		$this->var->add_def_cols('nivel','INTEGER');
   		$this->var->add_def_cols('prioridad','VARCHAR');
  		$this->var->add_def_cols('area','varchar');
  	
  		
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ListarPlanilla suma de totales de la planilla
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		08/12/2010
	 */
	function ListarRepPlanillaSum($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLASUM_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre',' VARCHAR'); 
  		$this->var->add_def_cols('sum_valor',' NUMERIC');
  		$this->var->add_def_cols('desc_incr_col',' varchar');
  		$this->var->add_def_cols('total','varchar');
  		$this->var->add_def_cols('columna_reporte','integer');
  		
  		
  		
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}	
	
	/**
	 * Nombre de la funci�n:	ListarPlanilla el detalle de columnas
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		03/09/2010
	 */
	function ListarRepPlanillaCol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_REPPLACOL_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_columna_tipo','INTEGER'); 
  		$this->var->add_def_cols('id_planilla','INTEGER'); 
 		$this->var->add_def_cols('nombre','varchar');
 		$this->var->add_def_cols('desc_incr_col',' varchar');
  		$this->var->add_def_cols('total','varchar');
  		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ListarPlanilla el detalle de columnas
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		28/10/2010
	 */
	function ListaPlanillaSueldoNetoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLASUNE_REP'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		   $this->var->add_def_cols('codigo_empleado',' VARCHAR');  
  		   $this->var->add_def_cols('nombre_completo','TEXT');  
   		   $this->var->add_def_cols('codigo','VARCHAR');  
   		   $this->var->add_def_cols('valor',' NUMERIC(18,2)');  
   		   $this->var->add_def_cols('id_tipo_planilla',' INTEGER');  
   		   $this->var->add_def_cols('id_columna','INTEGER');  
   		   $this->var->add_def_cols('id_columna_tipo','INTEGER');  
   		   $this->var->add_def_cols('id_empleado','INTEGER'); 
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	
	
	/**
	 * Nombre de la funci�n:	ListarPlanilla el detalle de columnas
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		28/10/2010
	 */
	function ListaPapeletaSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_BOLPAG_REP'";

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

		//Carga la definici�n de columnas con sus tipos de datos
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
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ListarPlanilla el detalle de columnas
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		28/10/2010
	 */
	function ListaPlanillaImpositiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLAIMP_REP'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		  $this->var->add_def_cols('codigo_empleado','VARCHAR(20)'); 
  		  $this->var->add_def_cols('nombre_completo','TEXT'); 
  		  $this->var->add_def_cols('codigo','VARCHAR(30)');
  		  $this->var->add_def_cols('valor','NUMERIC(18,2)'); 
  		  $this->var->add_def_cols('id_lugar_trabajo','INTEGER'); 
  		  $this->var->add_def_cols('nombre','varchar');
  		  $this->var->add_def_cols('id_actividad','INTEGER'); 
  		 
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	
}?>