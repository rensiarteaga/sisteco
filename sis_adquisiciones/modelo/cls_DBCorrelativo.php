<?php
/**
 * Nombre de la clase:	cls_DBCorrelativo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_correlativo
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-09 09:36:29
 */

 
class cls_DBCorrelativo
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
	 * Nombre de la función:	ListarCorrelativo
	 * Propósito:				Desplegar los registros de tad_correlativo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 09:36:29
	 */
	function ListarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_correlativo_sel';
		$this->codigo_procedimiento = "'AD_SECADQ_SEL'";

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
		$this->var->add_def_cols('id_correlativo','int4');
		$this->var->add_def_cols('valor_actual','int4');
		$this->var->add_def_cols('valor_siguiente','int4');
		$this->var->add_def_cols('incremento','int4');
		$this->var->add_def_cols('id_parametro_adquisicion','int4');
		$this->var->add_def_cols('desc_parametro_adquisicion','date');
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('desc_documento','varchar');
		$this->var->add_def_cols('prefijo','varchar');
		$this->var->add_def_cols('sufijo','varchar');
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','int4');
		$this->var->add_def_cols('desc_fina_regi_prog_proy_acti','int4');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCorrelativo
	 * Propósito:				Contar los registros de tad_correlativo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 09:36:29
	 */
	function ContarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_correlativo_sel';
		$this->codigo_procedimiento = "'AD_SECADQ_COUNT'";

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
	 * Nombre de la función:	InsertarCorrelativo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_correlativo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 09:36:29
	 */
	function InsertarCorrelativo($id_correlativo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_adquisicion,$id_documento,$prefijo,$sufijo,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_correlativo_iud';
		$this->codigo_procedimiento = "'AD_SECADQ_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($valor_actual);
		$this->var->add_param($valor_siguiente);
		$this->var->add_param($incremento);
		$this->var->add_param($id_parametro_adquisicion);
		$this->var->add_param($id_documento);
		$this->var->add_param("'$prefijo'");
		$this->var->add_param("'$sufijo'");
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCorrelativo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_correlativo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 09:36:29
	 */
	function ModificarCorrelativo($id_correlativo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_adquisicion,$id_documento,$prefijo,$sufijo,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_correlativo_iud';
		$this->codigo_procedimiento = "'AD_SECADQ_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_correlativo);
		$this->var->add_param($valor_actual);
		$this->var->add_param($valor_siguiente);
		$this->var->add_param($incremento);
		$this->var->add_param($id_parametro_adquisicion);
		$this->var->add_param($id_documento);
		$this->var->add_param("'$prefijo'");
		$this->var->add_param("'$sufijo'");
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCorrelativo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_correlativo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 09:36:29
	 */
	function EliminarCorrelativo($id_correlativo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_correlativo_iud';
		$this->codigo_procedimiento = "'AD_SECADQ_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_correlativo);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarCorrelativo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_correlativo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 09:36:29
	 */
	function ValidarCorrelativo($operacion_sql,$id_correlativo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_adquisicion,$id_documento,$prefijo,$sufijo,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
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
				//Validar id_correlativo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_correlativo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_correlativo", $id_correlativo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar valor_actual - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("valor_actual");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "valor_actual", $valor_actual))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar valor_siguiente - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("valor_siguiente");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "valor_siguiente", $valor_siguiente))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar incremento - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("incremento");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "incremento", $incremento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_parametro_adquisicion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro_adquisicion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_adquisicion", $id_parametro_adquisicion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_documento - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_documento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_documento", $id_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar prefijo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("prefijo");
			$tipo_dato->set_MaxLength(5);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "prefijo", $prefijo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar sufijo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sufijo");
			$tipo_dato->set_MaxLength(5);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "sufijo", $sufijo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_financiador - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_financiador");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_financiador", $id_financiador))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_regional - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_regional");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_regional", $id_regional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_programa - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_programa");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_programa", $id_programa))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proyecto - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proyecto");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proyecto", $id_proyecto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_actividad - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_actividad");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_actividad", $id_actividad))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_correlativo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_correlativo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_correlativo", $id_correlativo))
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