<?php
/**
 * Nombre de la clase:	cls_DBEmpleadoAfp.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_empleado_afp
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		12-08-2010
 */

class cls_DBEmpleadoAfp
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
	 * Nombre de la función:	ListarEmpleadoAfp
	 * Propósito:				Desplegar los registros de tkp_empleado_afp
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function ListarEmpleadoAfp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_afp_sel';
		$this->codigo_procedimiento = "'KP_EMPAFP_SEL'";

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
		$this->var->add_def_cols('id_empleado_afp','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_afp','int4');
		
		$this->var->add_def_cols('nro_afp','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('desc_afp','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('jubilado','varchar');
		$this->var->add_def_cols('fecha_asignacion','date');
		$this->var->add_def_cols('fecha_finalizacion','date');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	   /* echo $this->query;
	    exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEmpleadoAfp
	 * Propósito:				Contar los registros de tkp_empleado_afp
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function ContarEmpleadoAfp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_afp_sel';
		$this->codigo_procedimiento = "'KP_EMPAFP_COUNT'";

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
	 * Nombre de la función:	InsertarEmpleadoAfp
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_empleado_afp
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function InsertarEmpleadoAfp($id_empleado_afp,$id_empleado,$id_afp,$nro_afp,$fecha_reg,$estado_reg,$jubilado,$fecha_asignacion,$fecha_finalizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_afp_iud';
		$this->codigo_procedimiento = "'KP_EMPAFP_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_empleado");
		$this->var->add_param("$id_afp");
		$this->var->add_param("'$nro_afp'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$jubilado'");
		
		$this->var->add_param("'$fecha_asignacion'");
		$this->var->add_param("'$fecha_finalizacion'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEmpleadoAfp
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_empleado_afp
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function ModificarEmpleadoAfp($id_empleado_afp,$id_empleado,$id_afp,$nro_afp,$fecha_reg,$estado_reg,$jubilado,$fecha_asignacion,$fecha_finalizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_afp_iud';
		$this->codigo_procedimiento = "'KP_EMPAFP_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_afp);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_afp);
		$this->var->add_param("'$nro_afp'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$jubilado'");
		
		$this->var->add_param("'$fecha_asignacion'");
		$this->var->add_param("'$fecha_finalizacion'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEmpleadoAfp
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_empleado_afp
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function EliminarEmpleadoAfp($id_empleado_afp)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_afp_iud';
		$this->codigo_procedimiento = "'KP_EMPAFP_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_afp);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//("'$jubilado'");
		
		
		$this->var->add_param("NULL");//("'$fecha_asignacion'");
		$this->var->add_param("NULL");//("'$fecha_finalizacion'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ValidarEmpleadoAfp
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_empleado_afp
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	
	function ValidarEmpleadoAfp($operacion_sql,$id_empleado_afp,$id_empleado,$id_afp,$nro_afp,$fecha_reg,$estado_reg)
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
				//Validar id_empleado_frppa - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_empleado_afp");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_afp", $id_empleado_afp))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_afp");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_afp", $id_afp))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_afp");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_afp", $nro_afp))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_AllowBlank("true");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_empleado_frppa - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado_afp");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_afp", $id_empleado_afp))
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