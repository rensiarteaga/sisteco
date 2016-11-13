<?php
/**
 * Nombre de la clase:	cls_DBTipoCircuito.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_tipo_nodo
 * Autor:				Ariel Ayaviri Omonte
 * Fecha creación:		2010-12-27 15:36:51
 */

 
/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
*
* */

class cls_DBTipoCircuito
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
	 * Nombre de la función:	ListarTipoCircuito
	 * Propósito:				Desplegar los registros de tfl_tipo_nodo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-12-27 15:36:51
	 */
	/*
	 * Modificaciones:
	 * 17-02-2011	Ariel ayaviri Omonte	Se aumentó 2 atributos a la función listar el atributo nombre_inicio y nombre_fin
	 */
	
	function ListarTipoCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_circuito_sel';
		$this->codigo_procedimiento = "'FL_TIPCIR_SEL'";

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
		$this->var->add_def_cols('id_tipo_circuito','int4');
		$this->var->add_def_cols('id_tipo_nodo_inicio','int4');
		$this->var->add_def_cols('nombre_inicio','varchar');
		$this->var->add_def_cols('id_tipo_nodo_fin','int4');
		$this->var->add_def_cols('nombre_fin','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('tipo','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoCircuito
	 * Propósito:				Contar los registros de tfl_tipo_circuito
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2010-12-27 15:50:51
	 */
	function ContarTipoCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_circuito_sel';
		$this->codigo_procedimiento = "'FL_TIPCIR_COUNT'";

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
	 * Nombre de la función:	InsertarTipoCircuito
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfl_tipo_circuito
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2010-12-23 15:50:51
	 */
	
	function InsertarTipoCircuito($id_tipo_nodo_inicio,$id_tipo_nodo_fin,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_circuito_iud';
		$this->codigo_procedimiento = "'FL_TIPCIR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$id_tipo_nodo_inicio'");
		$this->var->add_param("'$id_tipo_nodo_fin'");
		$this->var->add_param("'$tipo'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
       
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipCircuito
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfl_tipo_circuito
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2010-12-27 15:52:51
	 */
	function ModificarTipoCircuito($id_tipo_circuito,$id_tipo_nodo_inicio,$id_tipo_nodo_fin,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_circuito_iud';
		$this->codigo_procedimiento = "'FL_TIPCIR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$id_tipo_circuito'");
		$this->var->add_param("'$id_tipo_nodo_inicio'");
		$this->var->add_param("'$id_tipo_nodo_fin'");
		$this->var->add_param("'$tipo'");
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
	 * Nombre de la función:	EliminarTipoCircuito
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_tipo_circuito
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:34:51
	 */
	function EliminarTipoCircuito($id_tipo_circuito)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_circuito_iud';
		$this->codigo_procedimiento = "'FL_TIPCIR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_circuito);
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
	 * Nombre de la función:	ValidarTipoCircuito
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_tipo_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2012-12-27 15:54:51
	 */
	function ValidarTipoCircuito($operacion_sql,$id_tipo_circuito,$id_tipo_nodo_inicio,$id_tipo_nodo_fin,$tipo)
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
				//Validar id_tipo_circuito - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_circuito");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_circuito", $id_tipo_circuito))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_tipo_nodo_inicio - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_tipo_nodo_inicio");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_nodo_inicio", $id_tipo_nodo_inicio))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_nodo_fin - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_tipo_nodo_fin");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_nodo_fin", $id_tipo_nodo_fin))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar tipo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(250);
			$tipo_dato->set_Columna("tipo");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo", $tipo))
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
			$tipo_dato->set_Columna("id_tipo_circuito");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_circuito", $id_tipo_circuito))
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