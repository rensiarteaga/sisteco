<?php
/**
 * Nombre de la clase:	cls_DBEntidad.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_entidad
 * Autor:				(autogenerado)
 * Fecha creación:		2009-03-16 16:16:15
 */

 
class cls_DBEntidad
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
	 * Nombre de la función:	ListarEntidad
	 * Propósito:				Desplegar los registros de tts_entidad
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-03-16 16:16:15
	 */
	function ListarEntidad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_entidad_sel';
		$this->codigo_procedimiento = "'TS_ENTIDA_SEL'";

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
		$this->var->add_def_cols('id_entidad','int4');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('gestion_tesoro','numeric');
		$this->var->add_def_cols('tipo_entidad','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEntidad
	 * Propósito:				Contar los registros de tts_entidad
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-03-16 16:16:15
	 */
	function ContarEntidad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_entidad_sel';
		$this->codigo_procedimiento = "'TS_ENTIDA_COUNT'";

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
	 * Nombre de la función:	InsertarEntidad
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_entidad
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-03-16 16:16:15
	 */
	function InsertarEntidad($id_entidad,$id_institucion,$id_parametro,$tipo_entidad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_entidad_iud';
		$this->codigo_procedimiento = "'TS_ENTIDA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_parametro);
		$this->var->add_param($tipo_entidad);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEntidad
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_entidad
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-03-16 16:16:15
	 */
	function ModificarEntidad($id_entidad,$id_institucion,$id_parametro,$tipo_entidad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_entidad_iud';
		$this->codigo_procedimiento = "'TS_ENTIDA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_entidad);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_parametro);
		$this->var->add_param($tipo_entidad);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEntidad
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_entidad
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-03-16 16:16:15
	 */
	function EliminarEntidad($id_entidad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_entidad_iud';
		$this->codigo_procedimiento = "'TS_ENTIDA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_entidad);
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
	 * Nombre de la función:	ValidarEntidad
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_entidad
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-03-16 16:16:15
	 */
	function ValidarEntidad($operacion_sql,$id_entidad,$id_institucion,$id_parametro,$tipo_entidad)
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
				//Validar id_entidad - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_entidad");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_entidad", $id_entidad))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_institucion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion", $id_institucion))
			{
				$this->salida = $valid->salida;
				return false;
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

			//Validar tipo_entidad - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_entidad");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_entidad", $tipo_entidad))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_entidad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_entidad");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_entidad", $id_entidad))
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