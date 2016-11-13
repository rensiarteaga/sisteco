<?php
/**
 * Nombre de la clase:	cls_DBAsignacionEquipo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tst_tst_asignacion_equipo
 * Autor:				(autogenerado)
 * Fecha creación:		2016-04-28 19:44:10
 */

class cls_DBAsignacionEquipo
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
	 * Nombre de la función:	ListarAsignacionEquipo
	 * Propósito:				Desplegar los registros de tst_asignacion_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ListarAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_asignacion_equipo_sel';
		$this->codigo_procedimiento = "'ST_ASIGEQ_SEL'";

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

		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_asignacion_equipo','int4');
		$this->var->add_def_cols('id_equipo','int4');
		$this->var->add_def_cols('id_plan_llamada','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('nro_asignacion','varchar');
		$this->var->add_def_cols('desc_plan_llamada','text');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('desc_correspondencia','varchar');
		$this->var->add_def_cols('desc_equipo','text');
		$this->var->add_def_cols('id_componente','integer');
		$this->var->add_def_cols('desc_componente','varchar');
		$this->var->add_def_cols('id_linea','integer');
		$this->var->add_def_cols('desc_linea','varchar');
		$this->var->add_def_cols('tipo_asignacion','varchar');
		$this->var->add_def_cols('id_usuario_resp','integer');
		$this->var->add_def_cols('desc_usuario_resp','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarAsignacionEquipo
	 * Propósito:				Contar los registros de tst_asignacion_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ContarAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_asignacion_equipo_sel';
		$this->codigo_procedimiento = "'ST_ASIGEQ_COUNT'";

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

		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarAsignacionEquipo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tst_asignacion_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2016-04-18 19:44:10
	 */
	function InsertarAsignacionEquipo($id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg,$fecha_reg, $fecha_ini,$fecha_fin,$id_componente,$id_linea,$tipo_asignacion)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_asignacion_equipo_iud';
		$this->codigo_procedimiento = "'ST_ASIGEQ_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_equipo");
		$this->var->add_param("$id_plan_llamada");
		$this->var->add_param("$id_empleado");
		$this->var->add_param("$id_correspondencia");
        $this->var->add_param("'$estado_reg'");
        $this->var->add_param("'$fecha_ini'");
        $this->var->add_param("'$fecha_fin'");
        $this->var->add_param("$id_componente");
        $this->var->add_param("$id_linea");
        $this->var->add_param("'$tipo_asignacion'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarAsignacionEquipo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tst_asignacion_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ModificarAsignacionEquipo($id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg, $fecha_reg, $fecha_ini,$fecha_fin,$id_componente,$id_linea,$tipo_asignacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_asignacion_equipo_iud';
		$this->codigo_procedimiento = "'ST_ASIGEQ_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_asignacion_equipo);
		$this->var->add_param("$id_equipo");
		$this->var->add_param("$id_plan_llamada");
		$this->var->add_param("$id_empleado");
		$this->var->add_param("$id_correspondencia");
        $this->var->add_param("'$estado_reg'");
        $this->var->add_param("'$fecha_ini'");
        $this->var->add_param("'$fecha_fin'");
        $this->var->add_param("$id_componente");
        $this->var->add_param("$id_linea");
        $this->var->add_param("'$tipo_asignacion'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarAsignacionEquipo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tst_asignacion_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function EliminarAsignacionEquipo($id_asignacion_equipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_asignacion_equipo_iud';
		$this->codigo_procedimiento = "'ST_ASIGEQ_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_asignacion_equipo);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarAsignacionEquipo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tst_asignacion_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ValidarAsignacionEquipo($operacion_sql,$id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg,$fecha_reg, $fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_asignacion_equipo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_asignacion_equipo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_asignacion_equipo", $id_asignacion_equipo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar empresa - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_equipo");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_equipo", $id_equipo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_plan_llamada");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plan_llamada", $id_plan_llamada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_asignacion_equipo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_asignacion_equipo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_asignacion_equipo", $id_asignacion_equipo))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validación exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	function ListarRepAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tst_asignacion_equipo_sel';
		$this->codigo_procedimiento = "'ST_ASIGEQ_REP'";
	
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
		
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nro_asignacion','varchar');
		$this->var->add_def_cols('numero_telefono','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('monto_llamada','text');
		$this->var->add_def_cols('monto_datos','text');
		$this->var->add_def_cols('marca','varchar');
		$this->var->add_def_cols('modelo','varchar');
		$this->var->add_def_cols('imei','varchar');
		$this->var->add_def_cols('sim_card','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('resp_asignacion','text');
		$this->var->add_def_cols('empleado','text');
		$this->var->add_def_cols('desc_correspondencia','varchar');
		$this->var->add_def_cols('tipo_asignacion','varchar');
		//$this->var->add_def_cols('cargo_resp_pres','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	
	}
	
}?>