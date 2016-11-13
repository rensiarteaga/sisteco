<?php
/**
 * Nombre de la clase:	cls_DBEmpleadoPlanilla.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_empleado_planilla
 * Autor:				(autogenerado)
 * Fecha creación:		2010-08-23 11:07:48
 */

 
class cls_DBEmpleadoPlanilla
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
	 * Nombre de la función:	ListarEmpleadoPlanilla
	 * Propósito:				Desplegar los registros de tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function ListarEmpleadoPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_sel';
		$this->codigo_procedimiento = "'KP_EMPPLA_SEL'";

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
		$this->var->add_def_cols('id_empleado_planilla','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('id_planilla','int4');
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('usuario','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
$this->var->add_def_cols('pago_liquido','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ListarEmpleadoPlanilla
	 * Propósito:				Desplegar los registros de tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function ListarEmpleadoPlanillaDinamica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_planilla,$id_tipo_planilla,$cc)
	{
		
				
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_dinamica_sel';
		$this->codigo_procedimiento = "'KP_EMPLAD_SEL'";

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
		$this->var->add_param($id_planilla);//id_actividad
		$this->var->add_param($id_tipo_planilla);//id_actividad
		
	
		$this->var->add_def_cols('id_empleado_planilla','int4');
		$this->var->add_def_cols('nombre_completo','text');
	
		
			for ($i=2 ; $i< count($cc); $i++){
			
			
			$this->var->add_def_cols($cc[$i],'numeric');
			$this->var->add_def_cols('visible_'.$cc[$i],'varchar');
			
		  }
		
		
	

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//if($_SESSION["ss_id_usuario"]==120){echo $this->query; exit;}
//		echo $this->query;
//		exit;
		
		return $res;
	}
	
	
	
	/**
	 * Nombre de la función:	ContarEmpleadoPlanilla
	 * Propósito:				Contar los registros de tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function ContarEmpleadoPlanillaDinamica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_planilla,$id_tipo_planilla,$cc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_dinamica_sel';
		$this->codigo_procedimiento = "'KP_EMPLAD_COUNT'";

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
		
		
		$this->var->add_param($id_planilla);//id_actividad
		$this->var->add_param($id_tipo_planilla);//id_actividad

		
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
	 * Nombre de la función:	ContarEmpleadoPlanilla
	 * Propósito:				Contar los registros de tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function ContarEmpleadoPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_sel';
		$this->codigo_procedimiento = "'KP_EMPPLA_COUNT'";

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
	 * Nombre de la función:	InsertarEmpleadoPlanilla
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function InsertarEmpleadoPlanilla($id_empleado_planilla,$id_empleado,$id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_iud';
		$this->codigo_procedimiento = "'KP_EMPPLA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_planilla);
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
	 * Nombre de la función:	ModificarEmpleadoPlanilla
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function ModificarEmpleadoPlanilla($id_empleado_planilla,$id_empleado,$id_planilla,$pago_liquido)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_iud';
		$this->codigo_procedimiento = "'KP_EMPPLA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_planilla);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_planilla);
$this->var->add_param("'$pago_liquido'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEmpleadoPlanilla
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function EliminarEmpleadoPlanilla($id_empleado_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_iud';
		$this->codigo_procedimiento = "'KP_EMPPLA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_planilla);
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
	
	
	
	function ModificarEmpleadoColumna($bandera,$id_grid,$id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_planilla_iud';
		$this->codigo_procedimiento = "'KP_EMCOLPLA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($bandera);
		$this->var->add_param($id_grid);
		$this->var->add_param($id_planilla);
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
	 * Nombre de la función:	ValidarEmpleadoPlanilla
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_empleado_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:48
	 */
	function ValidarEmpleadoPlanilla($operacion_sql,$id_empleado_planilla,$id_empleado,$id_planilla)
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
				//Validar id_empleado_planilla - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_empleado_planilla");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_planilla", $id_empleado_planilla))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_planilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_planilla");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_planilla", $id_planilla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_empleado_planilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado_planilla");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_planilla", $id_empleado_planilla))
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
	
	
	
	
	
}?>