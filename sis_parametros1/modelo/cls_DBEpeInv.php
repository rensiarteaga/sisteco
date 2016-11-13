<?php
/**
 * Nombre de la clase:	cls_DBEpeInv.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_epe_inv
 * Autor:				(autogenerado)
 * Fecha creación:		2009-01-23 10:58:13
 */

 
class cls_DBEpeInv
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
	 * Nombre de la función:	ListarEpeInv
	 * Propósito:				Desplegar los registros de tpm_epe_inv
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ListarEpeInv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_epe_inv_sel';
		$this->codigo_procedimiento = "'PM_EPEINV_SEL'";

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
		$this->var->add_def_cols('id_epe_inv','int4');
		$this->var->add_def_cols('id_epe','int4');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('importe_inv','numeric');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEpeInv
	 * Propósito:				Contar los registros de tpm_epe_inv
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ContarEpeInv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_epe_inv_sel';
		$this->codigo_procedimiento = "'PM_EPEINV_COUNT'";

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
	 * Nombre de la función:	InsertarEpeInv
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_epe_inv
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function InsertarEpeInv($id_epe_inv,$id_epe,$id_gestion,$id_moneda,$importe_inv)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_epe_inv_iud';
		$this->codigo_procedimiento = "'PM_EPEINV_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_epe);
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_inv);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEpeInv
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_epe_inv
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ModificarEpeInv($id_epe_inv,$id_epe,$id_gestion,$id_moneda,$importe_inv)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_epe_inv_iud';
		$this->codigo_procedimiento = "'PM_EPEINV_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_epe_inv);
		$this->var->add_param($id_epe);
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_inv);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEpeInv
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_epe_inv
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function EliminarEpeInv($id_epe_inv)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_epe_inv_iud';
		$this->codigo_procedimiento = "'PM_EPEINV_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_epe_inv);
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
	 * Nombre de la función:	ValidarEpeInv
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_epe_inv
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ValidarEpeInv($operacion_sql,$id_epe_inv,$id_epe,$id_gestion,$id_moneda,$importe_inv)
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
				//Validar id_epe_inv - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_epe_inv");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_epe_inv", $id_epe_inv))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_epe - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_epe");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_epe", $id_epe))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_gestion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_gestion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_epe_inv - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_epe_inv");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_epe_inv", $id_epe_inv))
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