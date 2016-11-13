<?php
/**
 * Nombre de la clase:	cls_DBEmpresa.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_empresa
 * Autor:				(autogenerado)
 * Fecha creación:		2008-09-19 11:45:26
 */

 
class cls_DBEmpresa
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
	 * Nombre de la función:	ListarEmpresa
	 * Propósito:				Desplegar los registros de tpm_empresa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-19 11:45:26
	 */
	function ListarEmpresa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_empresa_sel';
		$this->codigo_procedimiento = "'PM_EMPRES_SEL'";

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
		$this->var->add_def_cols('id_empresa','int4');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('denominacion','varchar');
		$this->var->add_def_cols('nro_nit','numeric');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('finalidad','varchar');
		$this->var->add_def_cols('dir_adm','integer');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEmpresa
	 * Propósito:				Contar los registros de tpm_empresa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-19 11:45:26
	 */
	function ContarEmpresa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_empresa_sel';
		$this->codigo_procedimiento = "'PM_EMPRES_COUNT'";

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
	 * Nombre de la función:	InsertarEmpresa
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_empresa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-19 11:45:26
	 */
	function InsertarEmpresa($id_empresa,$razon_social,$denominacion,$nro_nit,$codigo,$finalidad,$dir_adm)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_empresa_iud';
		$this->codigo_procedimiento = "'PM_EMPRES_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$denominacion'");
		$this->var->add_param($nro_nit);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$finalidad'");
		$this->var->add_param($dir_adm);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEmpresa
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_empresa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-19 11:45:26
	 */
	function ModificarEmpresa($id_empresa,$razon_social,$denominacion,$nro_nit,$codigo,$finalidad,$dir_adm)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_empresa_iud';
		$this->codigo_procedimiento = "'PM_EMPRES_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empresa);
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$denominacion'");
		$this->var->add_param($nro_nit);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$finalidad'");
		$this->var->add_param($dir_adm);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEmpresa
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_empresa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-19 11:45:26
	 */
	function EliminarEmpresa($id_empresa)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_empresa_iud';
		$this->codigo_procedimiento = "'PM_EMPRES_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empresa);
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
	
	/**
	 * Nombre de la función:	ValidarEmpresa
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_empresa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-19 11:45:26
	 */
	function ValidarEmpresa($operacion_sql,$id_empresa,$razon_social,$denominacion,$nro_nit,$codigo,$finalidad,$dir_adm)
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
				//Validar id_empresa - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_empresa");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empresa", $id_empresa))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar razon_social - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("razon_social");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "razon_social", $razon_social))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar denominacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("denominacion");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "denominacion", $denominacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_nit - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_nit");
			$tipo_dato->set_MaxLength(983040);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "nro_nit", $nro_nit))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_empresa - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empresa");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empresa", $id_empresa))
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