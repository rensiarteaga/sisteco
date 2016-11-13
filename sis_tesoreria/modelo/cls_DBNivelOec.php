<?php
/**
 * Nombre de la clase:	cls_DBNivelOec.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_nivel_oec
 * Autor:				Fernando Prudencio
 * Fecha creación:		2008-07-02 21:46:09
 */

 
class cls_DBNivelOec
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
	 * Nombre de la función:	ListarNivelOec
	 * Propósito:				Desplegar los registros de tts_nivel_oec
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 */
	function ListarNivelOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_nivel_oec_sel';
		$this->codigo_procedimiento = "'TS_NIVOEC_SEL'";

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
		$this->var->add_def_cols('id_nivel_oec','int4');
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
	 * Nombre de la función:	ContarNivelOec
	 * Propósito:				Contar los registros de tts_nivel_oec
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 */
	function ContarNivelOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_nivel_oec_sel';
		$this->codigo_procedimiento = "'TS_NIVOEC_COUNT'";

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
	 * Nombre de la función:	InsertarNivelOec
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_nivel_oec
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 */
	function InsertarNivelOec($id_nivel_oec,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_nivel_oec_iud';
		$this->codigo_procedimiento = "'TS_NIVOEC_INS'";

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
	 * Nombre de la función:	ModificarNivelOec
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_nivel_oec
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 */
	function ModificarNivelOec($id_nivel_oec,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_nivel_oec_iud';
		$this->codigo_procedimiento = "'TS_NIVOEC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);		
		$this->var->add_param($id_nivel_oec);
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
	 * Nombre de la función:	EliminarNivelOec
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_nivel_oec
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 */
	function EliminarNivelOec($id_nivel_oec)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_nivel_oec_iud';
		$this->codigo_procedimiento = "'TS_NIVOEC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_nivel_oec);
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
	 * Nombre de la función:	ValidarNivelOec
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_nivel_oec
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-07-02 21:46:09
	 */
	function ValidarNivelOec($operacion_sql,$id_nivel_oec,$id_parametro,$nivel,$dig_nivel)
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
				//Validar id_nivel_oec - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_nivel_oec");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nivel_oec", $id_nivel_oec))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_parametro - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar nivel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nivel");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "nivel", $nivel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar dig_nivel - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("dig_nivel");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "dig_nivel", $dig_nivel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_nivel_oec - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_nivel_oec");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nivel_oec", $id_nivel_oec))
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