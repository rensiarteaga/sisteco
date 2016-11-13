<?php
/**
 * Nombre de la clase:	cls_DBCircuito.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_circuito
 * Autor:				Ariel Ayaviri Omonte
 * Fecha creación:		2011-02-28 09:21:51
 */

 
/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
*
* */
class cls_DBCircuito
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
	 * Nombre de la función:	ListarCircuito
	 * Propósito:				Desplegar los registros de tfl_circuito
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-02-14 17:55:51
	 */
	
	
	function ListarCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_circuito_sel';
		$this->codigo_procedimiento = "'FL_CIRCUIT_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_circuito','int4');
		$this->var->add_def_cols('id_nodo_origen','int4');
		$this->var->add_def_cols('id_nodo_destino','int4');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('id_accion','int4');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCircuito
	 * Propósito:				Contar los registros de tfl_circuito
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-02-14 17:55:51
	 */
	function ContarCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_circuito_sel';
		$this->codigo_procedimiento = "'FL_CIRCUIT_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
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
	 * Nombre de la función:	InsertarCircuito
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfl_tipo_nodo
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-02-14 17:21:51
	 */
	
	function InsertarCircuito($id_nodo_origen, $id_nodo_destino, $id_accion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_circuito_iud';
		$this->codigo_procedimiento = "'FL_CIRCUIT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_nodo_origen);
		$this->var->add_param($id_nodo_destino);
		$this->var->add_param($id_accion);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCircuito
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfl_circuito
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-02-14 17:54:51
	 */
	function ModificarCircuito($id_circuito,$id_nodo_origen,$id_nodo_destino,$id_accion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_circuito_iud';
		$this->codigo_procedimiento = "'FL_CIRCUIT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_circuito);
		$this->var->add_param($id_nodo_origen);
		$this->var->add_param($id_nodo_destino);
		$this->var->add_param($id_accion);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
      /* echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCircuito
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_circuito
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-02-14 17:54:51
	 */
	function EliminarCircuito($id_circuito)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_circuito_iud';
		$this->codigo_procedimiento = "'FL_CIRCUIT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_nodo);
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
	 * Nombre de la función:	ValidarCircuito
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tfl_circuito
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2011-02-14 17:54:51
	 */
	function ValidarCircuito($operacion_sql,$id_circuito,$id_nodo_origen,$id_nodo_destino,$id_accion)
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
				$tipo_dato->set_Columna("id_circuito");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_circuito", $id_circuito))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_tipo_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_nodo_origen");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nodo_origen", $id_nodo_origen))
			{
				$this->salida = $valid->salida;
				return false;
			}
			

			//Validar id_tipo_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_nodo_destino");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nodo_destino", $id_nodo_destino))
			{
				$this->salida = $valid->salida;
				return false;
			}
			/*
			//Validar id_tipo_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_accion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_accion", $id_accion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			*/
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_accion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_accion", $id_accion))
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