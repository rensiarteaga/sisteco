<?php
/**
 * Nombre de la clase:	cls_DBItemRemplazo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_item_remplazo
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-03 12:22:41
 */

class cls_DBItemRemplazo
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
	 * Nombre de la función:	ListarItemRemplazo
	 * Propósito:				Desplegar los registros de tal_item_remplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 12:22:41
	 */
	function ListarItemRemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_remplazo_sel';
		$this->codigo_procedimiento = "'AL__SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarItemRemplazo
	 * Propósito:				Contar los registros de tal_item_remplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 12:22:41
	 */
	function ContarItemRemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_remplazo_sel';
		$this->codigo_procedimiento = "'AL__COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		
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
	 * Nombre de la función:	InsertarItemRemplazo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_item_remplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 12:22:41
	 */
	function InsertarItemRemplazo(	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_remplazo_iud';
		$this->codigo_procedimiento = "'AL__INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
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
	 * Nombre de la función:	ModificarItemRemplazo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_item_remplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 12:22:41
	 */
	function ModificarItemRemplazo(	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_remplazo_iud';
		$this->codigo_procedimiento = "'AL__UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarItemRemplazo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_item_remplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 12:22:41
	 */
	function EliminarItemRemplazo($)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_remplazo_iud';
		$this->codigo_procedimiento = "'AL__DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarItemRemplazo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_item_remplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 12:22:41
	 */
	function ValidarItemRemplazo($operacion_sql,	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validad el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar  - tipo 
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "", $))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar  - tipo 
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "", $))
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