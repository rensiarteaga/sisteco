<?php
/**
 * Nombre de la clase:	cls_DBTipoNodo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_tipo_nodo
 * Autor:				Ariel Ayaviri Omonte
 * Fecha creación:		2010-12-22 17:04:51
 */

 
/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
*
* */
class cls_DBProceso
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
	 * Nombre de la función:	ListarTipoNod
	 * Propósito:				Desplegar los registros de tfl_tipo_nodo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-12-23 09:50:51
	 */
	
	
	function ListarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_proceso_sel';
		$this->codigo_procedimiento = "'FL_PROCES_SEL'";

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
		$this->var->add_def_cols('id_proceso','int4');
		$this->var->add_def_cols('id_tipo_proceso','int4');
		$this->var->add_def_cols('fecha_proceso','date');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoNodo
	 * Propósito:				Contar los registros de tfl_tipo_nod
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2010-12-23 09:59:51
	 */
	function ContarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_proceso_sel';
		$this->codigo_procedimiento = "'FL_PROCES_COUNT'";

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
	 * Nombre de la función:	InsertarTipoNodo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfl_tipo_nodo
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2010-12-23 10:17:51
	 */
	
	function InsertarProceso($id_tipo_proceso,$fecha_proceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_proceso_iud';
		$this->codigo_procedimiento = "'FL_PROCES_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param($fecha_proceso);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoNodo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfl_tipo_nod
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2010-12-23 10:16:51
	 */
	function ModificarProceso($id_proceso,$id_tipo_proceso,$fecha_proceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_proceso_iud';
		$this->codigo_procedimiento = "'FL_PROCES_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso);
		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param($fecha_proceso);
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
	 * Nombre de la función:	EliminarTipoNodo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_tipo_nodo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:34:51
	 */
	function EliminarProceso($id_proceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_proceso_iud';
		$this->codigo_procedimiento = "'FL_PROCESO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso);
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
	 * Nombre de la función:	ValidarTipoAdq
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_tipo_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:34:51
	 */
	function ValidarProceso($operacion_sql,$id_proceso,$id_tipo_proceso)
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
				$tipo_dato->set_Columna("id_proceso");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso", $id_proceso))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_tipo_proceso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_tipo_proceso");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_proceso", $id_tipo_proceso))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_proceso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_proceso");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso", $id_proceso))
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