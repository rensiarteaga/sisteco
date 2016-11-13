<?php
/**
 * Nombre de la clase:	cls_DBCategoriaTipoDestino.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_categoria_tipo_destino
 * Autor:				(autogenerado)
 * Fecha creación:		2009-10-27 12:25:02
 */

 
class cls_DBCategoriaTipoDestino
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
	 * Nombre de la función:	ListarCategoriaTipoDestino
	 * Propósito:				Desplegar los registros de tts_categoria_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-27 12:25:02
	 */
	function ListarCategoriaTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_categoria_tipo_destino_sel';
		$this->codigo_procedimiento = "'TS_CATIDE_SEL'";

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
		$this->var->add_def_cols('id_categoria_tipo_destino','int4');
		$this->var->add_def_cols('id_categoria','int4');
		$this->var->add_def_cols('desc_categoria','varchar');
		$this->var->add_def_cols('id_tipo_destino','int4');
		$this->var->add_def_cols('importe_viatico','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_usr_reg','int4');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('tipo_hotel','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCategoriaTipoDestino
	 * Propósito:				Contar los registros de tts_categoria_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-27 12:25:02
	 */
	function ContarCategoriaTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_categoria_tipo_destino_sel';
		$this->codigo_procedimiento = "'TS_CATIDE_COUNT'";

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
	 * Nombre de la función:	InsertarCategoriaTipoDestino
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_categoria_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-27 12:25:02
	 */
	function InsertarCategoriaTipoDestino($id_categoria_tipo_destino,$id_categoria,$id_tipo_destino,$importe_viatico,$tipo_hotel)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_categoria_tipo_destino_iud';
		$this->codigo_procedimiento = "'TS_CATIDE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_categoria);
		$this->var->add_param($id_tipo_destino);
		$this->var->add_param($importe_viatico);
		$this->var->add_param("'$tipo_hotel'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCategoriaTipoDestino
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_categoria_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-27 12:25:02
	 */
	function ModificarCategoriaTipoDestino($id_categoria_tipo_destino,$id_categoria,$id_tipo_destino,$importe_viatico,$tipo_hotel)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_categoria_tipo_destino_iud';
		$this->codigo_procedimiento = "'TS_CATIDE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria_tipo_destino);
		$this->var->add_param($id_categoria);
		$this->var->add_param($id_tipo_destino);
		$this->var->add_param($importe_viatico);
		$this->var->add_param("'$tipo_hotel'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCategoriaTipoDestino
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_categoria_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-27 12:25:02
	 */
	function EliminarCategoriaTipoDestino($id_categoria_tipo_destino)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_categoria_tipo_destino_iud';
		$this->codigo_procedimiento = "'TS_CATIDE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria_tipo_destino);
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
	 * Nombre de la función:	ValidarCategoriaTipoDestino
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_categoria_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-27 12:25:02
	 */
	function ValidarCategoriaTipoDestino($operacion_sql,$id_categoria_tipo_destino,$id_categoria,$id_tipo_destino,$importe_viatico,$tipo_hotel)
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
				//Validar id_categoria_tipo_destino - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_categoria_tipo_destino");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_tipo_destino", $id_categoria_tipo_destino))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_categoria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria", $id_categoria))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_destino");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_destino", $id_tipo_destino))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_viatico - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_viatico");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_viatico", $importe_viatico))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_hotel - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_hotel");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_hotel", $tipo_hotel))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_categoria_tipo_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria_tipo_destino");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_tipo_destino", $id_categoria_tipo_destino))
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