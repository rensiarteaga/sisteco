<?php
/**
 * Nombre de la clase:	cls_DBParametroGeneral.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_parametro_general
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-26 12:42:57
 */

class cls_DBParametroGeneral
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
	 * Nombre de la función:	ListarParametroGeneral
	 * Propósito:				Desplegar los registros de tsg_parametro_general
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 12:42:57
	 */
	function ListarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_parametro_general_sel';
		$this->codigo_procedimiento = "'SG_PARGEN_SEL'";

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
		$this->var->add_def_cols('id_parametro_general','int4');
		$this->var->add_def_cols('nombre_atributo','varchar');
		$this->var->add_def_cols('valor_atributo','varchar');
		$this->var->add_def_cols('descripcion','text');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarParametroGeneral
	 * Propósito:				Contar los registros de tsg_parametro_general
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 12:42:57
	 */
	function ContarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_parametro_general_sel';
		$this->codigo_procedimiento = "'SG_PARGEN_COUNT'";

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
	 * Nombre de la función:	InsertarParametroGeneral
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_parametro_general
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 12:42:57
	 */
	function InsertarParametroGeneral($id_parametro_general,$nombre_atributo,$valor_atributo,$descripcion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_parametro_general_iud';
		$this->codigo_procedimiento = "'SG_PARGEN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_atributo'");
		$this->var->add_param("'$valor_atributo'");
		$this->var->add_param("'$descripcion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarParametroGeneral
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_parametro_general
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 12:42:57
	 */
	function ModificarParametroGeneral($id_parametro_general,$nombre_atributo,$valor_atributo,$descripcion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_parametro_general_iud';
		$this->codigo_procedimiento = "'SG_PARGEN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro_general);
		$this->var->add_param("'$nombre_atributo'");
		$this->var->add_param("'$valor_atributo'");
		$this->var->add_param("'$descripcion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarParametroGeneral
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_parametro_general
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 12:42:57
	 */
	function EliminarParametroGeneral($id_parametro_general)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_parametro_general_iud';
		$this->codigo_procedimiento = "'SG_PARGEN_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro_general);
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
	 * Nombre de la función:	ValidarParametroGeneral
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_parametro_general
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 12:42:57
	 */
	function ValidarParametroGeneral($operacion_sql,$id_parametro_general,$nombre_atributo,$valor_atributo,$descripcion)
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
				//Validar id_parametro_general - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_parametro_general");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_general", $id_parametro_general))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre_atributo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_atributo");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_atributo", $nombre_atributo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar valor_atributo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("valor_atributo");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "valor_atributo", $valor_atributo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_parametro_general - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro_general");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_general", $id_parametro_general))
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