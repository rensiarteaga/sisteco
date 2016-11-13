<?php
/**
 * Nombre de la clase:	cls_DBProcesoTipoCuenta.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla taf_taf_proceso
 * Autor:				(autogenerado)
 * Fecha creación:		2010-10-13 17:05:17
 */

 
class cls_DBProcesoTipoCuenta
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
	 * Nombre de la función:	ListarProceso
	 * Propósito:				Desplegar los registros de taf_proceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-10-13 17:05:17
	 */
	function ListarProcesoTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_proceso_tipo_cuenta_sel';
		$this->codigo_procedimiento = "'AF_PRTICU_SEL'";

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
		$this->var->add_def_cols('id_proceso_tipo_cuenta','integer');
		$this->var->add_def_cols('id_proceso','integer');
		$this->var->add_def_cols('id_tipo_cuenta','integer');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('debe_haber','varchar');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query = $this->var->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarProceso
	 * Propósito:				Contar los registros de taf_proceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-10-13 17:05:17
	 */
	function ContarProcesoTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_proceso_tipo_cuenta_sel';
		$this->codigo_procedimiento = "'AF_PRTICU_COUNT'";

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
		//echo $this->query = $this->var->query; exit;
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarProceso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla taf_proceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-10-13 17:05:17
	 */
	function InsertarProcesoTipoCuenta($txt_des_proceso,$hidden_id_proceso,$debe_haber)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_proceso_tipo_cuenta_iud';
		$this->codigo_procedimiento = "'AF_PRTICU_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($txt_des_proceso);
		$this->var->add_param($hidden_id_proceso);
		$this->var->add_param("'$debe_haber'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query = $this->var->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarProceso
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_proceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-10-13 17:05:17
	 */
	function ModificarProcesoTipoCuenta($hidden_id_proceso_tipo_cuenta,$txt_des_proceso,$hidden_id_proceso,$debe_haber)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_proceso_tipo_cuenta_iud';
		$this->codigo_procedimiento = "'AF_PRTICU_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($hidden_id_proceso_tipo_cuenta);
		$this->var->add_param($txt_des_proceso);
		$this->var->add_param($hidden_id_proceso);
		$this->var->add_param("'$debe_haber'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarProceso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_proceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-10-13 17:05:17
	 */
	function EliminarProcesoTipoCuenta($id_proceso_tipo_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_proceso_tipo_cuenta_iud';
		$this->codigo_procedimiento = "'AF_PRTICU_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_tipo_cuenta);
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
	 * Nombre de la función:	ValidarProceso
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla taf_proceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-10-13 17:05:17
	 */
	function ValidarProcesoTipoCuenta($operacion_sql,$hidden_id_proceso_tipo_cuenta,$txt_des_proceso,$hidden_id_proceso)
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
				//Validar descripcion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_proceso_tipo_cuenta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_tipo_cuenta", $hidden_id_proceso_tipo_cuenta))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_cuenta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_cuenta", $txt_des_proceso))
				{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar descripcion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proceso_tipo_cuenta");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_tipo_cuenta", $hidden_id_proceso_tipo_cuenta))
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