<?php
/**
 * Nombre de la clase:	cls_DBComprador.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_comprador
 * Autor:				(autogenerado)
 * Fecha creación:		2008-11-17 11:14:48
 */

 
class cls_DBComprador
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
	 * Nombre de la función:	ListarComprador
	 * Propósito:				Desplegar los registros de tad_comprador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-17 11:14:48
	 */
	function ListarComprador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_comprador_sel';
		$this->codigo_procedimiento = "'AD_COMPRAD_SEL'";

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
		$this->var->add_def_cols('id_comprador','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('fecha_asignacion','date');
		$this->var->add_def_cols('estado','varchar');
		
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('nombre_depto','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarComprador
	 * Propósito:				Contar los registros de tad_comprador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-17 11:14:48
	 */
	function ContarComprador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_comprador_sel';
		$this->codigo_procedimiento = "'AD_COMPRAD_COUNT'";

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
	 * Nombre de la función:	InsertarComprador
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_comprador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-17 11:14:48
	 */
	function InsertarComprador($id_comprador,$id_empleado,$fecha_asignacion,$estado,$id_depto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_comprador_iud';
		$this->codigo_procedimiento = "'AD_COMPRAD_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado);
		$this->var->add_param("'$fecha_asignacion'");
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_depto);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarComprador
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_comprador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-17 11:14:48
	 */
	function ModificarComprador($id_comprador,$id_empleado,$fecha_asignacion,$estado,$id_depto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_comprador_iud';
		$this->codigo_procedimiento = "'AD_COMPRAD_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprador);
		$this->var->add_param($id_empleado);
		$this->var->add_param("'$fecha_asignacion'");
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_depto);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarComprador
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_comprador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-17 11:14:48
	 */
	function EliminarComprador($id_comprador)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_comprador_iud';
		$this->codigo_procedimiento = "'AD_COMPRAD_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprador);
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
	 * Nombre de la función:	ValidarComprador
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_comprador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-17 11:14:48
	 */
	function ValidarComprador($operacion_sql,$id_comprador,$id_empleado,$fecha_asignacion,$estado)
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
				//Validar id_comprador - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_comprador");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_comprador", $id_comprador))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_asignacion - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_asignacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_asignacion", $fecha_asignacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(18);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_comprador - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_comprador");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_comprador", $id_comprador))
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