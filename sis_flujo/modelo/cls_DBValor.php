<?php
/**
 * Nombre de la clase:	cls_DBValor.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_valor
 * Autor:				Ariel Ayaviri Omonte
 * Fecha creación:		2011-01-26 17:04:51
 */

/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
*/
class cls_DBValor
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
	 * Nombre de la función:	ListarValor
	 * Propósito:				Desplegar los registros de tfl_valor
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-01-26 18:12:51
	 */
	
	function ListarValorDinamico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_tipo_proceso,$id_empleado,$id_tipo_formulario,$c_names)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_valor_dinamico_sel';
		$this->codigo_procedimiento = "'FL_VALORDIN_SEL'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_tipo_formulario);
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_formulario','int4');
		$this->var->add_def_cols('id_proceso','int4');
		$this->var->add_def_cols('id_tipo_nodo','int4');
		$this->var->add_def_cols('estado','varchar');
		for($i=0;$i<count($c_names);$i++){
			$this->var->add_def_cols($c_names[$i],'text');
			$this->var->add_def_cols($c_names[$i]."_idvalor",'text');
			$this->var->add_def_cols($c_names[$i]."_idnodo",'text');
		}
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarValor
	 * Propósito:				Contar los registros de tfl_valor
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-01-26 18:12:51
	 */
	function ContarValorDinamico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_tipo_proceso,$id_empleado,$id_tipo_formulario,$c_names)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_valor_dinamico_sel';
		$this->codigo_procedimiento = "'FL_VALORDIN_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_tipo_formulario);
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
	 * Nombre de la función:	InsertarValor
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfl_valor
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-01-26 18:12:51
	 */

	function InsertarValor($id_formulario,$id_atributo,$id_nodo,$valor_text)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_valor_iud';
		$this->codigo_procedimiento = "'FL_VALOR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_formulario);
		$this->var->add_param($id_atributo);
		$this->var->add_param($id_nodo);
		$this->var->add_param("'$valor_text'");
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
	 * Nombre de la función:	ModificarValor
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfl_valor
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-01-26 18:12:51
	 */

	function ModificarValor($id_valor,$id_formulario,$id_atributo,$id_nodo,$valor_text)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_valor_iud';
		$this->codigo_procedimiento = "'FL_VALOR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_valor);
		$this->var->add_param($id_formulario);
		$this->var->add_param($id_atributo);
		$this->var->add_param($id_nodo);
		$this->var->add_param("'$valor_text'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
				$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarValor
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_valor
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-01-26 18:12:51
	 */
	function EliminarValor($id_valor)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_valor_iud';
		$this->codigo_procedimiento = "'FL_VALOR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_valor);
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
	 * Nombre de la función:	ValidarValor
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tfl_valor
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-01-26 18:12:51
	 */
	function ValidarValor($operacion_sql,$id_valor,$id_formulario,$id_atributo,$id_nodo)
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
				//Validar id_tipo_adq - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_valor");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_valor", $id_valor)){
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			//Validar id_formulario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_formulario");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_formulario", $id_formulario)){
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_atributo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_atributo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_atributo", $id_atributo)){
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_nodo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_nodo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nodo", $id_nodo)){
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete'){
		//Validar id_tipo_adq - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_valor");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_valor", $id_valor)){
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