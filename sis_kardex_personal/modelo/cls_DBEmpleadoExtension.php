<?php
/**
 * Nombre de la clase:	cls_DBEmpleadoExtension.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_empleado_extension
 * Autor:				(autogenerado)
 * Fecha creación:		2008-01-17 15:14:44
 */

class cls_DBEmpleadoExtension
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
	 * Nombre de la función:	ListarEmpleadoExtension
	 * Propósito:				Desplegar los registros de tkp_empleado_extension
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 15:14:44
	 */
	function ListarEmpleadoExtension($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_extension_sel';
		$this->codigo_procedimiento = "'KP_EMPEXT_SEL'";

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
		$this->var->add_def_cols('id_empleado_extension','int4');
		$this->var->add_def_cols('codigo_telefonico','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_gerencia','int4');
		$this->var->add_def_cols('desc_gerencia','varchar');
        $this->var->add_def_cols('estado','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEmpleadoExtension
	 * Propósito:				Contar los registros de tkp_empleado_extension
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 15:14:44
	 */
	function ContarEmpleadoExtension($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_extension_sel';
		$this->codigo_procedimiento = "'KP_EMPEXT_COUNT'";

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
	 * Nombre de la función:	ListarEmpleadoExtension
	 * Propósito:				Desplegar los registros de tkp_empleado_extension
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 15:14:44
	 */
	function ListarEmpleadoExtensionGerente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_extension_sel';
		$this->codigo_procedimiento = "'KP_EMPGER_SEL'";

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
		$this->var->add_def_cols('id_empleado_extension','int4');
		$this->var->add_def_cols('codigo_telefonico','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_gerencia','int4');
		$this->var->add_def_cols('desc_gerencia','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEmpleadoExtension
	 * Propósito:				Contar los registros de tkp_empleado_extension
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 15:14:44
	 */
	function ContarEmpleadoExtensionGerente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_extension_sel';
		$this->codigo_procedimiento = "'KP_EMPGER_COUNT'";

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
	 * Nombre de la función:	InsertarEmpleadoExtension
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_empleado_extension
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 15:14:44
	 */
	function InsertarEmpleadoExtension($id_empleado_extension,$codigo_telefonico,$id_empleado,$id_gerencia,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_extension_iud';
		$this->codigo_procedimiento = "'KP_EMPEXT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo_telefonico'");
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_gerencia);
        $this->var->add_param($estado);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
        return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEmpleadoExtension
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_empleado_extension
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 15:14:44
	 */
	function ModificarEmpleadoExtension($id_empleado_extension,$codigo_telefonico,$id_empleado,$id_gerencia,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_extension_iud';
		$this->codigo_procedimiento = "'KP_EMPEXT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_extension);
		$this->var->add_param("'$codigo_telefonico'");
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_gerencia);
        $this->var->add_param($estado);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEmpleadoExtension
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_empleado_extension
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 15:14:44
	 */
	function EliminarEmpleadoExtension($id_empleado_extension)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_extension_iud';
		$this->codigo_procedimiento = "'KP_EMPEXT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_extension);
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
	 * Nombre de la función:	ValidarEmpleadoExtension
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_empleado_extension
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 15:14:44
	 */
	function ValidarEmpleadoExtension($operacion_sql,$id_empleado_extension,$codigo_telefonico,$id_empleado,$id_gerencia,$estado)
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
				//Validar id_empleado_extension - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_empleado_extension");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_extension", $id_empleado_extension))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo_telefonico - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_telefonico");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_telefonico", $codigo_telefonico))
			{
				$this->salida = $valid->salida;
				return false;
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

			//Validar id_gerencia - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_gerencia");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gerencia", $id_gerencia))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_gerencia - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_empleado_extension - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado_extension");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_extension", $id_empleado_extension))
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