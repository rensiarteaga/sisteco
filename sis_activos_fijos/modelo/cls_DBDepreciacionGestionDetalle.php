<?php
/**
 * Nombre de la clase:	cls_DBGrupoDepreciacionGestiondetalle.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tpm_depreciacion
 * Autor:				(autogenerado)
 * Fecha creaci�n:		27/10/2015
 */

 
class cls_DBDepreciacionGestionDetalle
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
	 * Nombre de la funci�n:	ListarDepreciacionGestionDetalle
	 * Prop�sito:				Desplegar los registros de tpm_depreciacion_gestion
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		27/10/2015
	 */
	function ListarDepreciacionGestionDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_gestion_detalle_sel';
		$this->codigo_procedimiento = "'AF_DEPGESDET_SEL'";

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
		$this->var->add_def_cols('id_depreciacion_gestion_det','integer');
		$this->var->add_def_cols('id_depreciacion_gestion','integer');
		$this->var->add_def_cols('fecha_desde','date');
		$this->var->add_def_cols('fecha_hasta','date');
		$this->var->add_def_cols('monto_vigente_ant','numeric');
		$this->var->add_def_cols('monto_vigente','numeric');
		$this->var->add_def_cols('vida_util_restante','integer');
		$this->var->add_def_cols('tipo_cambio_ini','numeric');
		$this->var->add_def_cols('tipo_cambio_fin','numeric');
		$this->var->add_def_cols('depreciacion_acum_ant','numeric');
		$this->var->add_def_cols('depreciacion','numeric');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('monto_actualiz_ant','numeric');
		$this->var->add_def_cols('monto_actualiz','numeric');
		$this->var->add_def_cols('dep_acum_actualiz','numeric');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('vida_util_original','integer');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarDepreciacionGestionDetalle
	 * Prop�sito:				Contar los registros de tpm_depreciacion_gestion
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		27/10/2015
	 */
	function ContarDepreciacionGestionDetalle($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_gestion_detalle_sel';
		$this->codigo_procedimiento = "'AF_DEPGESDET_COUNT'";

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
	function EliminarDepreciacionGestionDetalle($id_depreciacion_gestion_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_gestion_detalle_iud';
		$this->codigo_procedimiento = "'AF_DEPGESDET_DEL'";
		
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depreciacion_gestion_detalle);//af_id_dep_gestion_detalle
		$this->var->add_param("NULL");//af_id_depreciacion_gestion
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
}?>
