<?php
/**
 * Nombre de la clase:	cls_DBEmpleadoPpto.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_empleado_ppto
 * Autor:				(autogenerado)
 * Fecha creación:		2010-08-23 11:07:48
 */

 
class cls_DBEmpleadoPpto
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
	 * Nombre de la función:	ListarEmpleadoPpto
	 * Propósito:				Desplegar los registros de tkp_empleado_ppto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function ListarEmpleadoPpto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_ppto_sel';
		$this->codigo_procedimiento = "'KP_EMPPTO_SEL'";

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
		$this->var->add_def_cols('id_empleado_ppto','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('porcentaje','numeric');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('gestion','numeric');
		
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	
	
	
	
	/**
	 * Nombre de la función:	ContarEmpleadoPpto
	 * Propósito:				Contar los registros de tkp_empleado_ppto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function ContarEmpleadoPpto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_ppto_sel';
		$this->codigo_procedimiento = "'KP_EMPPTO_COUNT'";

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
	 * Nombre de la función:	InsertarEmpleadoPpto
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_empleado_ppto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function InsertarEmpleadoPpto($id_empleado_ppto,$id_empleado,$id_presupuesto,$id_gestion,$porcentaje,$estado_reg,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_ppto_iud';
		$this->codigo_procedimiento = "'KP_EMPPTO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_gestion);
		$this->var->add_param($porcentaje);
		
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$estado_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo '->'. $this->query; exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEmpleadoPpto
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_empleado_ppto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function ModificarEmpleadoPpto($id_empleado_ppto,$id_empleado,$id_presupuesto,$id_gestion,$porcentaje,$estado_reg,$fecha_ini,$fecha_fin)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_ppto_iud';
		$this->codigo_procedimiento = "'KP_EMPPTO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_ppto);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_gestion);
		$this->var->add_param($porcentaje);
		
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$estado_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEmpleadoPpto
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_empleado_ppto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function EliminarEmpleadoPpto($id_empleado_ppto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_ppto_iud';
		$this->codigo_procedimiento = "'KP_EMPPTO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_ppto);
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
	
	
}?>