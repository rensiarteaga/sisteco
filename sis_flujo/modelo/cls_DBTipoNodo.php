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
class cls_DBTipoNodo
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
	
	
	function ListarTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_sel';
		$this->codigo_procedimiento = "'FL_TIPNOD_SEL'";

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
		$this->var->add_def_cols('id_tipo_nodo','int4');
		$this->var->add_def_cols('posx','int4');
		$this->var->add_def_cols('posy','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_tipo_proceso','int4');
		$this->var->add_def_cols('nombre_proceso','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('ini_emp_list','varchar');


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
	function ContarTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_sel';
		$this->codigo_procedimiento = "'FL_TIPNOD_COUNT'";

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
	
	function InsertarTipoNodo($nombre,$codigo,$id_tipo_proceso,$ini_emp_list,$posx,$posy)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_iud';
		$this->codigo_procedimiento = "'FL_TIPNOD_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$id_tipo_proceso'");
		$this->var->add_param("'$ini_emp_list'");
		$this->var->add_param("'$posx'");
		$this->var->add_param("'$posy'");
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
	function ModificarTipoNodo($id_tipo_nodo,$nombre,$codigo,$id_tipo_proceso,$ini_emp_list,$posx,$posy)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_iud';
		$this->codigo_procedimiento = "'FL_TIPNOD_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$id_tipo_nodo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$id_tipo_proceso'");
		$this->var->add_param("'$ini_emp_list'");
		$this->var->add_param("'$posx'");
		$this->var->add_param("'$posy'");
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
	function EliminarTipoNodo($id_tipo_nodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_iud';
		$this->codigo_procedimiento = "'FL_TIPNOD_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_nodo);
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
	 * Nombre de la función:	ValidarTipoAdq
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_tipo_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:34:51
	 */
	function ValidarTipoNodo($operacion_sql,$id_tipo_nodo,$nombre,$codigo,$id_tipo_proceso,$ini_emp_list,$posx,$posy)
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
				$tipo_dato->set_Columna("id_tipo_nodo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_nodo", $id_tipo_nodo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(250);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar ini_emp_list - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("ini_emp_list");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "ini_emp_list", $ini_emp_list))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar posx - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("posx");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "posx", $posx))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar posy - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("posy");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "posy", $posy))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_nodo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_nodo", $id_tipo_nodo))
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