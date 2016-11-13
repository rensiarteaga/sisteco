<?php
/**
 * Nombre de la clase:	cls_DBDeptoUo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_depto_ep
 * Autor:				Silvia Ximena Ortiz Fernández
 * Fecha creación:		16-02-2011
 */

class cls_DBDeptoUO
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
	 * Nombre de la función:	ListarDepartamentoUo
	 * Propósito:				Desplegar los registros de tpm_depto_ep
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		16-02-2011
	 */
	function ListarDepartamentoUo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_uo_sel';
		$this->codigo_procedimiento = "'PM_PM_DEPUO_SEL'";

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
		$this->var->add_def_cols('id_depto_uo','int4');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('desc_depto','text');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('estado','varchar');		

		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDepartamentoEP
	 * Propósito:				Contar los registros de tpm_depto_ep
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ContarDepartamentoUO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_uo_sel';
		$this->codigo_procedimiento = "'PM_PM_DEPUO_COUNT'";

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
	 * Nombre de la función:	InsertarDepartamentoUo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_depto_ep
	 * Autor:				    Silvia Ximena Ortiz Fernandez
	 * Fecha de creación:		16-02-2011
	 */
	function InsertarDepartamentoUO($id_depto,$id_unidad_organizacional,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_uo_iud';
		$this->codigo_procedimiento = "'PM_PM_DEPUO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_depto);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param("'$estado'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDepartamentoUo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_unidad_organizacional
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		16-02-2011
	 */
	function ModificarDepartamentoUO($id_depto_uo,$id_depto,$id_unidad_organizacional,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_uo_iud';
		$this->codigo_procedimiento = "'PM_PM_DEPUO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto_uo);
		$this->var->add_param($id_depto);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param("'$estado'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDepartamentoUo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_unidad_organizacional
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		16-02-2011
	 */
	function EliminarDepartamentoUO($id_depto_uo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_uo_iud';
		$this->codigo_procedimiento = "'PM_PM_DEPUO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto_uo);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarDepartamentoUo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_unidad_organizacional
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		16-02-2011
	 */
	function ValidarDepartamentoUO($operacion_sql,$id_depto_uo,$id_depto,$id_unidad_organizacional,$estado)
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
				//Validar id_depto_uo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_depto_uo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_uo", $id_depto_uo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_depto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_ep - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
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
			//Validar id_depto_ep - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto_uo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_uo", $id_depto_uo))
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