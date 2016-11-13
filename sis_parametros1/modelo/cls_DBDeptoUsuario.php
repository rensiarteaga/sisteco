<?php
/**
 * Nombre de la clase:	cls_DBDeptoUsuario.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_depto_usuario
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2009-01-23 10:58:14
 */

 
class cls_DBDeptoUsuario
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
	 * Nombre de la funci�n:	ListarDepartamentoUsuario
	 * Prop�sito:				Desplegar los registros de tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function ListarDepartamentoUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_usuario_sel';
		$this->codigo_procedimiento = "'PM_PM_DEPUS_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_depto_usuario','int4');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','text');
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('cargo','varchar');
        $this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('login','varchar');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres

		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarDepartamentoUsuario
	 * Prop�sito:				Contar los registros de tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function ContarDepartamentoUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_usuario_sel';
		$this->codigo_procedimiento = "'PM_PM_DEPUS_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;

		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	InsertarDepartamentoUsuario
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function InsertarDepartamentoUsuario($id_depto_usuario,$id_depto,$id_usuario,$estado,$cargo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_usuario_iud';
		$this->codigo_procedimiento = "'PM_PM_DEPUS_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_depto);
		$this->var->add_param($id_usuario);
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$cargo'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarDepartamentoUsuario
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function ModificarDepartamentoUsuario($id_depto_usuario,$id_depto,$id_usuario,$estado,$cargo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_usuario_iud';
		$this->codigo_procedimiento = "'PM_PM_DEPUS_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto_usuario);
		$this->var->add_param($id_depto);
		$this->var->add_param($id_usuario);
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$cargo'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarDepartamentoUsuario
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function EliminarDepartamentoUsuario($id_depto_usuario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_usuario_iud';
		$this->codigo_procedimiento = "'PM_PM_DEPUS_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto_usuario);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarDepartamentoUsuario
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function ValidarDepartamentoUsuario($operacion_sql,$id_depto_usuario,$id_depto,$id_usuario,$estado)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validaci�n por el tipo de operaci�n
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_depto_usuario - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_depto_usuario");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_usuario", $id_depto_usuario))
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

			//Validar id_usuario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario", $id_usuario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_depto_usuario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto_usuario");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_usuario", $id_depto_usuario))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validaci�n exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
}?>