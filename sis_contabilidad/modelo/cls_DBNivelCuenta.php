<?php
/**
 * Nombre de la clase:	cls_DBNivelCuenta.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_nivel_cuenta
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-15 17:39:52
 */

 
class cls_DBNivelCuenta
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
	 * Nombre de la función:	ListarNivelCuenta
	 * Propósito:				Desplegar los registros de tct_nivel_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:52
	 */
	function ListarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_nivel_cuenta_sel';
		$this->codigo_procedimiento = "'CT_NIVCTA_SEL'";

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
		$this->var->add_def_cols('id_nivel_cuenta','int4');
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('nivel','numeric');
		$this->var->add_def_cols('dig_nivel','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarNivelCuenta
	 * Propósito:				Contar los registros de tct_nivel_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:52
	 */
	function ContarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_nivel_cuenta_sel';
		$this->codigo_procedimiento = "'CT_NIVCTA_COUNT'";

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
	 * Nombre de la función:	InsertarNivelCuenta
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_nivel_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:52
	 */
	function InsertarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_nivel_cuenta_iud';
		$this->codigo_procedimiento = "'CT_NIVCTA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_parametro);
		$this->var->add_param($nivel);
		$this->var->add_param($dig_nivel);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarNivelCuenta
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_nivel_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:52
	 */
	function ModificarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_nivel_cuenta_iud';
		$this->codigo_procedimiento = "'CT_NIVCTA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_nivel_cuenta);
		$this->var->add_param($id_parametro);
		$this->var->add_param($nivel);
		$this->var->add_param($dig_nivel);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarNivelCuenta
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_nivel_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:52
	 */
	function EliminarNivelCuenta($id_nivel_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_nivel_cuenta_iud';
		$this->codigo_procedimiento = "'CT_NIVCTA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_nivel_cuenta);
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
	 * Nombre de la función:	ValidarNivelCuenta
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_nivel_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:52
	 */
	function ValidarNivelCuenta($operacion_sql,$id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel)
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
				//Validar id_nivel_cuenta - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_nivel_cuenta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nivel_cuenta", $id_nivel_cuenta))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_parametro - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nivel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nivel");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "nivel", $nivel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar dig_nivel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("dig_nivel");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "dig_nivel", $dig_nivel))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_nivel_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_nivel_cuenta");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nivel_cuenta", $id_nivel_cuenta))
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