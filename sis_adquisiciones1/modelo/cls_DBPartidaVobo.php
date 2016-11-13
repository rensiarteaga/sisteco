<?php
/**
 * Nombre de la clase:	cls_DBPartidaVobo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_partida_vobo
 * Autor:				(autogenerado)
 * Fecha creación:	2010-02-05
 */

 
class cls_DBPartidaVobo
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
	 * Nombre de la funciï¿½n:	ListarPlanPago
	 * Propï¿½sito:				Desplegar los registros de tad_plan_pago
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 17:32:18
	 */
	function ListarPartidaVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_partida_vobo_sel';
		$this->codigo_procedimiento = "'AD_PARTVB_SEL'";

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
		

		$this->var->add_def_cols('id_partida_vobo','int4');
		$this->var->add_def_cols('id_partida','int4');
		$this->var->add_def_cols('desc_partida','text');
		$this->var->add_def_cols('id_parametro_adquisicion','int4');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('id_vobo_detalle','int4');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	
	
	
	function ContarPartidaVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_partida_vobo_sel';
		$this->codigo_procedimiento = "'AD_PARTVB_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
//		echo $criterio_filtro."puntero: ".$puntero."sortcol: ".$sortcol."sortdir: ".$sortdir." cant:".$cant;
//		exit;
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
	
	
	
	
	function InsertarPartidaVobo($id_partida,$id_parametro_adquisicion,$estado_reg,$id_vobo_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_partida_vobo_iud';
		$this->codigo_procedimiento = "'AD_PARTVB_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_partida);
		$this->var->add_param($id_parametro_adquisicion);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param($id_vobo_detalle);
		
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	
	function ModificarPartidaVobo($id_partida_vobo,$id_partida,$id_parametro_adquisicion,$estado_reg,$id_vobo_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_partida_vobo_iud';
		$this->codigo_procedimiento = "'AD_PARTVB_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_vobo);
		$this->var->add_param($id_partida);
		$this->var->add_param($id_parametro_adquisicion);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param($id_vobo_detalle);
		
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function EliminarPartidaVobo($id_partida_vobo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_partida_vobo_iud';
		$this->codigo_procedimiento = "'AD_PARTVB_DEL'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_vobo);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	////////////////////////////////////////DETALLE VOBO
	
	function ListarDetalleVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_detalle_vobo_sel';
		$this->codigo_procedimiento = "'AD_VBDET_SEL'";

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
		

		$this->var->add_def_cols('id_vobo_detalle','int4');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','text');
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('desc_empleado','text');
		
		$this->var->add_def_cols('estado_reg','varchar');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	
	
	
	function ContarDetalleVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_detalle_vobo_sel';
		$this->codigo_procedimiento = "'AD_VBDET_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
//		echo $criterio_filtro."puntero: ".$puntero."sortcol: ".$sortcol."sortdir: ".$sortdir." cant:".$cant;
//		exit;
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
	
	
	
	
	function InsertarDetalleVobo($id_depto,$id_empleado,$id_partida_vobo,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_detalle_vobo_iud';
		$this->codigo_procedimiento = "'AD_VBDET_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_depto);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_partida_vobo);
		$this->var->add_param("'$estado_reg'");
		
		
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	
	function ModificarDetalleVobo($id_detalle_vobo,$id_depto,$id_empleado,$id_partida_vobo,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_detalle_vobo_iud';
		$this->codigo_procedimiento = "'AD_VBDET_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_detalle_vobo);
		$this->var->add_param($id_depto);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_partida_vobo);
		$this->var->add_param("'$estado_reg'");
		
		
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function EliminarDetalleVobo($id_detalle_vobo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_detalle_vobo_iud';
		$this->codigo_procedimiento = "'AD_VBDET_DEL'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_detalle_vobo);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
}?>