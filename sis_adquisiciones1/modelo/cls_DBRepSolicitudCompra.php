<?php
/**
 * Nombre de la clase:	cls_DBRepSolicitudCompra.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_solicitud_compra
 * Autor:				Ana Maria
 * Fecha creación:		27/12/2011
 */

 
class cls_DBRepSolicitudCompra
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
	/**funciones para el reporte lista de compras
	 * Nombre de la función:	ListarProcesoRep
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    avillegas
	 * Fecha de creación:		16/02/2011
	 */
	function ListarSolicitudesCSGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rep_solicitudes';
		$this->codigo_procedimiento = "'AD_SOLCSGES_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("'$id_presupuesto'");//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		 $this->var->add_def_cols('nro_solicitud_cadena','VARCHAR(50)');
		$this->var->add_def_cols('nombre','VARCHAR(150)'); 
        $this->var->add_def_cols('monto_aprobado','NUMERIC(18,2)'); 
        $this->var->add_def_cols('precio_referencial_total_as','NUMERIC(18,2)'); 
        $this->var->add_def_cols('desc_epe','TEXT');
        $this->var->add_def_cols('id_partida_ejecucion_as','INTEGER'); 
        $this->var->add_def_cols('id_presupuesto','INTEGER'); 
        $this->var->add_def_cols('id_partida_ejecucion','INTEGER'); 
        $this->var->add_def_cols('id_ppto_as','INTEGER');
        $this->var->add_def_cols('observaciones','VARCHAR'); 
        $this->var->add_def_cols('gestion','INTEGER'); 
		$this->var->add_def_cols('partida','TEXT');
		$this->var->add_def_cols('estado','VARCHAR(18)'); 
		$this->var->add_def_cols('estado_vigente_solicitud','VARCHAR(30)');
		
	/*	$this->var->add_def_cols('nro_solicitud_cadena','integer');
        $this->var->add_def_cols('nombre','integer');
        $this->var->add_def_cols('observaciones','integer');
        $this->var->add_def_cols('gestion','integer');
        $this->var->add_def_cols('monto_aprobado','integer');
        $this->var->add_def_cols('precio_referencial_total_as','integer');
        $this->var->add_def_cols('estado_vigente_solicitud','integer');
        $this->var->add_def_cols('estado','integer');
        $this->var->add_def_cols('desc_epe','integer');
        $this->var->add_def_cols('partida','integer');
        $this->var->add_def_cols('id_partida_ejecucion_as','integer');
        $this->var->add_def_cols('id_presupuesto','integer');
        $this->var->add_def_cols('id_partida_ejecucion','integer');
        $this->var->add_def_cols('id_ppto_as','integer');
		
		
		*/
       
		
			
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	/**funciones para el reporte lista de compras
	 * Nombre de la función:	ListarProcesoRep
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    avillegas
	 * Fecha de creación:		
	 */
	function ListarDevengadosNoPagados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rep_solicitudes';
		$this->codigo_procedimiento = "'AD_DETDEV_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		//$this->var->add_param("'$id_presupuesto'");//id_actividad
        
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proceso_compra','INTEGER');
        $this->var->add_def_cols('codigo_proceso','VARCHAR');
        $this->var->add_def_cols('desc_proveedor','TEXT');
        $this->var->add_def_cols('nro_contrato','varchar');
        $this->var->add_def_cols('num_orden_compra','INTEGER');
        $this->var->add_def_cols('fecha_devengado','DATE');
		
	
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	
		
}?>
