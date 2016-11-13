<?php
/**
 * Nombre de la clase:	cls_DBAtributoTipoNodo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_tipo_nodo
 * Autor:				Ariel Ayaviri Omonte
 * Fecha creación:		2011-01-19 12:09:51
 */

/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
*/
class cls_DBFormGen
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
	
	function ListarAtributoTipoNodoForm($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_tipo_nodo_form_sel';
		$this->codigo_procedimiento = "'FL_ATRTIPNOD_FORM_SEL'";

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
		$this->var->add_def_cols('id_atributo_tipo_nodo','int4');
		$this->var->add_def_cols('id_atributo','int4');
		$this->var->add_def_cols('id_tipo_formulario','int4');
		$this->var->add_def_cols('tipo_datos','varchar');
		$this->var->add_def_cols('tipo_field','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('label','varchar');
		$this->var->add_def_cols('opcional','varchar');
		$this->var->add_def_cols('remoto','varchar');
		$this->var->add_def_cols('valor_defecto','text');
		$this->var->add_def_cols('valores_combo','text');
		$this->var->add_def_cols('valor','varchar');
		$this->var->add_def_cols('display','varchar');
		$this->var->add_def_cols('id_tipo_nodo','int4');
		$this->var->add_def_cols('visible','varchar');
		$this->var->add_def_cols('editable','varchar');
		$this->var->add_def_cols('orden','int4');

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
	function ContarAtributoTipoNodoForm($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_tipo_nodo_form_sel';
		$this->codigo_procedimiento = "'FL_ATRTIPNOD_FORM_COUNT'";

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
/*	
	function InsertarAtributoTipoNodo($id_atributo,$id_tipo_nodo,$visible,$editable,$orden)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_tipo_nodo_iud';
		$this->codigo_procedimiento = "'FL_ATRTIPNOD_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_atributo);
		$this->var->add_param($id_tipo_nodo);
		$this->var->add_param("'$visible'");
		$this->var->add_param("'$editable'");
		$this->var->add_param($orden);
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
/*
	function ModificarAtributoTipoNodo($id_atributo_tipo_nodo,$id_atributo,$id_tipo_nodo,$visible,$editable,$orden)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_tipo_nodo_iud';
		$this->codigo_procedimiento = "'FL_ATRTIPNOD_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_atributo_tipo_nodo);
		$this->var->add_param($id_atributo);
		$this->var->add_param($id_tipo_nodo);
		$this->var->add_param("'$visible'");
		$this->var->add_param("'$editable'");
		$this->var->add_param($orden);
				$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoNodo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_tipo_nodo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:34:51
	 */
/*	function EliminarAtributoTipoNodo($id_atributo_tipo_nodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_tipo_nodo_iud';
		$this->codigo_procedimiento = "'FL_ATRTIPNOD_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_atributo_tipo_nodo);
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
/*	function ValidarAtributoTipoNodo($operacion_sql,$id_atributo_tipo_nodo,$id_atributo,$id_tipo_nodo,$orden)
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
				$tipo_dato->set_Columna("id_atributo_tipo_nodo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_atributo_tipo_nodo", $id_atributo_tipo_nodo)){
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_atributo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_atributo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_atributo", $id_atributo)){
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_tipo_nodo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_tipo_nodo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_nodo", $id_tipo_nodo)){
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar orden - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("orden");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "orden", $orden)){
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
				$tipo_dato->set_Columna("id_atributo_tipo_nodo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_atributo_tipo_nodo", $id_atributo_tipo_nodo)){
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
	}*/
}?>