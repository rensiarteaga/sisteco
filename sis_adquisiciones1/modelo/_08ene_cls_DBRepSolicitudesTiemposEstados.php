<?php
/**
 * Nombre de la clase:	cls_DBRepSolicitudesTiemposEstados.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_solicitud_compra
 * Autor:				Ana Maria
 * Fecha creación:		2009-06-26 12:04:04
 */

 
class cls_DBRepSolicitudesTiemposEstados
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
	 * Nombre de la función:	ListarSolEstadosTiemposDetalle
	 * Propósito:				Desplegar los registros de tad_solicitud_compra
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-26 12:04:04
	 */
	function ListarSolEstadosTiemposDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$fecha_ini,$fecha_fin,$tipo_adq)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rep_solicitudes_tiempos_estados';
		$this->codigo_procedimiento = "'AD_SOTIES_SEL'";

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
		/*$this->var->add_param("'$id_fina_regi_pro_proy_acti'");
		$this->var->add_param("'$id_unidad_organizacional'");
		*/
		$this->var->add_param("'$id_fina_regi_prog_proy_acti'");
		$this->var->add_param("'$id_unidad_organizacional'");
		
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$tipo_adq'");

		//Carga la definición de columnas con sus tipos de datos
		
		 $this->var->add_def_cols('num_solicitud','text');
         $this->var->add_def_cols('fecha_reg',' text');
         $this->var->add_def_cols('desc_bien_servicio','varchar'); 
         $this->var->add_def_cols('desc_ep','text'); 
         $this->var->add_def_cols('desc_uo','text'); 
         $this->var->add_def_cols('estado_solicitud',' TEXT');
         $this->var->add_def_cols('fecha_solicitud','text');
         $this->var->add_def_cols('id_solicitud_compra_det',' INTEGER');
         $this->var->add_def_cols('id_solicitud_compra','INTEGER');
		
		
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/***/
	
	function ListarPrestoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_fina_regi_prog_proy_acti_sel';
		$this->codigo_procedimiento = "'PM_PRESTOEP_SEL'";

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
		/*$this->var->add_param("'$id_fina_regi_pro_proy_acti'");
		$this->var->add_param("'$id_unidad_organizacional'");
		*/
		
		//Carga la definición de columnas con sus tipos de datos
		 $this->var->add_def_cols('id_ep','int4');
		 $this->var->add_def_cols('id_financiador','int4');
		 $this->var->add_def_cols('id_regional','int4');
		 $this->var->add_def_cols('id_programa','int4');
		 $this->var->add_def_cols('id_proyecto','int4');
		 $this->var->add_def_cols('id_actividad','int4');
		 
		 $this->var->add_def_cols('codigo_financiador','varchar');
		 $this->var->add_def_cols('codigo_regional','varchar');
		 $this->var->add_def_cols('codigo_programa','varchar');
		 $this->var->add_def_cols('codigo_proyecto','varchar');
		 $this->var->add_def_cols('codigo_actividad','varchar');
//		 
//		 
		 $this->var->add_def_cols('nombre_financiador','varchar');
		 $this->var->add_def_cols('nombre_regional','varchar');
		 $this->var->add_def_cols('nombre_programa','varchar');
		 $this->var->add_def_cols('nombre_proyecto','varchar');
		 $this->var->add_def_cols('nombre_actividad','varchar');
//		 
         $this->var->add_def_cols('desc_epe','text'); 
//         
		
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
		
	
	
	function ContarPrestoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_fina_regi_prog_proy_acti_sel';
		$this->codigo_procedimiento = "'PM_PRESTOEP_COUNT'";

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
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;

		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}

		
}?>
