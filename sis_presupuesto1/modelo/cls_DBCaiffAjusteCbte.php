<?php
/**
 * Nombre de la clase:	cls_DBCaiffAjusteCbte.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_usuario_autorizado
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2008-08-18 17:10:52
 */

 
class cls_DBCaiffAjusteCbte
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
	 * Nombre de la funci�n:	ListarCaiffAjusteCbte
	 * Prop�sito:				Desplegar los registros de tpr_usuario_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		
	 */
	function ListarCaiffAjusteCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_caiff_ajuste_cbte_sel';
		$this->codigo_procedimiento = "'PR_CAAJCBTE_SEL'";

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
		
	    $this->var->add_def_cols('id_comprobante','integer');
	    $this->var->add_def_cols('id_parametro','integer');
	    $this->var->add_def_cols('desc_parametro','numeric');
	    $this->var->add_def_cols('id_periodo_subsistema','integer');
	    $this->var->add_def_cols('desc_periodo_lite','varchar');
	    $this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('nro_cbte','integer');
        $this->var->add_def_cols('acreedor','varchar');
        $this->var->add_def_cols('aprobacion','varchar');
        $this->var->add_def_cols('concepto_cbte','varchar');
        $this->var->add_def_cols('sw_caif_rep','varchar');
        $this->var->add_def_cols('sw_actualizacion','varchar');
     	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarCaiff
	 * Prop�sito:				Contar los registros de tpr_usuario_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		
	 */
	function ContarCaiffAjusteCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_caiff_ajuste_cbte_sel';
		$this->codigo_procedimiento = "'PR_CAAJCBTE_COUNT'";
		
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
	 * Nombre de la funci�n:	ListarCaiffAjusteCbte
	 * Prop�sito:				Desplegar los registros de tpr_usuario_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:
	 */
	function ListarCaiffAjusteTra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_caiff_ajuste_cbte_sel';
		$this->codigo_procedimiento = "'PR_CAAJTRA_SEL'";
	
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
		
		$this->var->add_def_cols('id_transaccion','integer');
		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('desc_cuenta_aux','text');
    	$this->var->add_def_cols('id_auxiliar','integer');
    	$this->var->add_def_cols('id_partida','integer');
    	$this->var->add_def_cols('desc_partida','text');
    	$this->var->add_def_cols('importe_debe','numeric');
    	$this->var->add_def_cols('importe_haber','numeric');
    	$this->var->add_def_cols('importe_gasto','numeric');
    	$this->var->add_def_cols('importe_recurso','numeric');
    	$this->var->add_def_cols('importe_gasto_flujo','numeric');
    	$this->var->add_def_cols('importe_recurso_flujo','numeric');
    	
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	* Nombre de la funci�n:	ContarCaiff
	* Prop�sito:				Contar los registros de tpr_usuario_autorizado
	* Autor:				    (autogenerado)
	* Fecha de creaci�n:
	*/
		function ContarCaiffAjusteTra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
		{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_caiff_ajuste_cbte_sel';
		$this->codigo_procedimiento = "'PR_CAAJTRA_COUNT'";
	
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