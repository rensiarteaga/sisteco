<?php
/**
 * Nombre de la clase:	cls_DBParametroBancarizacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_ParametroBancarizacion
 * Autor:				(autogenerado)
 * Fecha creación:		2008-09-19 11:45:26
 */

 
class cls_DBParametroBancarizacion
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
	 * Nombre de la función:	ListarParametroBancarizacion
	 * Propósito:				Desplegar los registros de tpm_ParametroBancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		22.07.2015
	 */
	function ListarParametroBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_parametro_bancarizacion_sel';
		$this->codigo_procedimiento = "'PM_PARBAN_SEL'";

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
		$this->var->add_def_cols('id_parametro_bancarizacion','int4');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('desc_moneda','varchar');

		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarParametroBancarizacion
	 * Propósito:				Contar los registros de tpm_ParametroBancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		22.07.2015
	 */
	function ContarParametroBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_parametro_bancarizacion_sel';
		$this->codigo_procedimiento = "'PM_PARBAN_COUNT'";

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
	 * Nombre de la función:	InsertarParametroBancarizacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_ParametroBancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		22.07.2015
	 */
	function InsertarParametroBancarizacion($id_parametro_bancarizacion,$monto, $id_moneda,$fecha_ini)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_parametro_bancarizacion_iud';
		$this->codigo_procedimiento = "'PM_PARBAN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$monto");
		$this->var->add_param($id_moneda);
		$this->var->add_param("null"); //estado_reg
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("null");//fecha_fin
				
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarParametroBancarizacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_ParametroBancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		22.07.2015
	 */
	function ModificarParametroBancarizacion($id_parametro_bancarizacion,$monto, $id_moneda,$estado_reg,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_parametro_bancarizacion_iud';
		$this->codigo_procedimiento = "'PM_PARBAN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro_bancarizacion);
		$this->var->add_param("$monto");
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$estado_reg'"); //estado_reg
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");//fecha_fin
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarParametroBancarizacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_ParametroBancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		22.07.2015
	 */
	function EliminarParametroBancarizacion($id_ParametroBancarizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_parametro_bancarizacion_iud';
		$this->codigo_procedimiento = "'PM_PARBAN_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ParametroBancarizacion);
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
	 * Nombre de la función:	ValidarParametroBancarizacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_ParametroBancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		22.07.2015
	 */
	function ValidarParametroBancarizacion($operacion_sql,$id_parametro_bancarizacion,$monto, $id_moneda,$fecha_ini)
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
				//Validar id_ParametroBancarizacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_parametro_bancarizacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_bancarizacion", $id_parametro_bancarizacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			
			//Validar nro_nit - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("monto");
			$tipo_dato->set_MaxLength(983040);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "monto", $monto))
			{
				$this->salida = $valid->salida;
				return false;
			}

						//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_ParametroBancarizacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro_bancarizacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_bancarizacion", $id_parametro_bancarizacion))
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