<?php
/**
 * Nombre de la clase:	cls_DBRepObligacion.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_planilla
 * Autor:				avillegas
 * Fecha creaci�n:		17/01/2011
 */

 
class cls_DBRepObligacion
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
	 * Nombre de la funci�n:	ListarObligacionPlanilla la cabecera del reporte
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		17/01/2011
	 */
	function ListarObligacionPlanillaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		
		/*if($_SESSION["ss_id_usuario"]==120){
				$this->nombre_funcion = 'f_tkp_rep_obligacion_sel_new';
		}else{*/
		
		$this->nombre_funcion = 'f_tkp_rep_obligacion_sel';
		//}
		$this->codigo_procedimiento = "'KP_OBLPLA_REP'";

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
	     // $this->var->add_def_cols('id_tipo_obligacion','VARCHAR(20)'); 
		 $this->var->add_def_cols('concepto',' VARCHAR');
         $this->var->add_def_cols(' monto_parcial',' NUMERIC(18,2)');
         $this->var->add_def_cols(' monto_cambio_parcial',' NUMERIC(18,2)');
         $this->var->add_def_cols(' centro',' VARCHAR');
         $this->var->add_def_cols(' cuenta',' VARCHAR');
         $this->var->add_def_cols(' auxiliar',' VARCHAR');
         $this->var->add_def_cols(' monto_total',' NUMERIC(18,2)');
         $this->var->add_def_cols(' monto_cambio_total ','NUMERIC(18,2)');
         $this->var->add_def_cols('tipo_pago ','varchar');
	     
	    
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		
		$this->query = $this->var->query;
		
		/*echo $this->query;  
		exit;
	*/
	
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ListarPlanilla la cabecera del reporte
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		02/002/2011
	 */
	function ListarObligacionPlanillaCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
//		if($_SESSION["ss_id_usuario"]==120){
//				$this->nombre_funcion = 'f_tkp_rep_obligacion_sel_new';
//		}else{
//		
		$this->nombre_funcion = 'f_tkp_rep_obligacion_sel';
		//}
		$this->codigo_procedimiento = "'KP_OBLPLACA_REP'";

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
  		$this->var->add_def_cols('t_c','numeric(18,2)');
		
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
	 * Nombre de la funci�n:	SolPagoObligacionCab la cabecera del reporte
	 * Prop�sito:				Desplegar los registros de tkp_obligacion
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		22/06/2011
	 */
	function SolPagoObligacionCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_obligacion_sel';
		$this->codigo_procedimiento = "'KP_SOPAOBCAB_REP'";

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
	     // $this->var->add_def_cols('id_tipo_obligacion','VARCHAR(20)'); 
	     
	      $this->var->add_def_cols('id_obligacion','INTEGER'); 
 		 $this->var->add_def_cols('observaciones','TEXT'); 
 		 $this->var->add_def_cols('obs_planilla','TEXT'); 
 		 $this->var->add_def_cols('fecha_pago','DATE'); 
 		 $this->var->add_def_cols('tipo_pago','VARCHAR'); 
		  $this->var->add_def_cols('obs_pago','TEXT'); 
 		 $this->var->add_def_cols('monto','NUMERIC'); 
 		 $this->var->add_def_cols('periodo','NUMERIC');
 		 $this->var->add_def_cols('gestion','NUMERIC');
  	 $this->var->add_def_cols('moneda','varchar');
	 $this->var->add_def_cols('acreedor','varchar');
	     
	    
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
	 * Nombre de la funci�n:	SolPagoObligacionEPDet el detalle de las ep's
	 * Prop�sito:				Desplegar los registros de tkp_obligacion
	 * Autor:				    avillegas
	 * Fecha de creaci�n:		04/07/2011
	 */
	function SolPagoObligacionEPDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_obligacion_sel';
		$this->codigo_procedimiento = "'KP_SOPAOBEPDE_REP'";

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
	     // $this->var->add_def_cols('id_tipo_obligacion','VARCHAR(20)'); 
	       $this->var->add_def_cols('nombre_unidad','VARCHAR');
           $this->var->add_def_cols('nombre_programa','VARCHAR');
           $this->var->add_def_cols('nombre_regional','VARCHAR');
           $this->var->add_def_cols('nombre_financiador','VARCHAR');
           $this->var->add_def_cols('nombre_proyecto','VARCHAR');
           $this->var->add_def_cols('nombre_fuente_financiamiento','VARCHAR');
           $this->var->add_def_cols('nombre_actividad','VARCHAR');
           $this->var->add_def_cols('id_planilla','INTEGER');
           
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
}?>