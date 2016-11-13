<?php
/**
 * Nombre de la clase:	cls_DBDevengadoConcepto.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_devengado_concepto
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-21 15:43:28
 */


class cls_DBDevengadoConcepto
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
	 * Nombre de la función:	ListarDevengadoConcepto
	 * Propósito:				Desplegar los registros de tts_devengado_concepto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ListarDevengadoConcepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_concepto_sel';
		$this->codigo_procedimiento = "'TS_DEVOTR_SEL'";

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
		$this->var->add_def_cols('id_devengado_concepto','int4');
		$this->var->add_def_cols('id_devengado','int4');
		$this->var->add_def_cols('id_concepto_ingas','int4');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('desc_concepto_ingas','text');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarDevengadoConcepto
	 * Propósito:				Contar los registros de tts_devengado_concepto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ContarDevengadoConcepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_concepto_sel';
		$this->codigo_procedimiento = "'TS_DEVOTR_COUNT'";

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
	 * Nombre de la función:	InsertarDevengadoConcepto
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_devengado_concepto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function InsertarDevengadoConcepto($id_devengado_concepto,$id_devengado,$id_concepto_ingas,$descripcion,$importe)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_concepto_iud';
		$this->codigo_procedimiento = "'TS_DEVOTR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_devengado);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($importe);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "query: ".$this->query;
		//exit;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarDevengadoConcepto
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_devengado_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ModificarDevengadoConcepto($id_devengado_concepto,$id_devengado,$id_concepto_ingas,$descripcion,$importe)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_concepto_iud';
		$this->codigo_procedimiento = "'TS_DEVOTR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado_concepto);
		$this->var->add_param($id_devengado);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($importe);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarDevengadoDetalle
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function EliminarDevengadoConcepto($id_devengado_concepto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_concepto_iud';
		$this->codigo_procedimiento = "'TS_DEVOTR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado_concepto);
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

		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarDevengadoDetalle
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_devengado_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ValidarDevengadoConcepto($operacion_sql,$id_devengado_concepto,$id_devengado,$id_concepto_ingas,$descripcion,$importe)
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
				//Validar id_devengado_detalle - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_devengado_concepto");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado_concepto", $id_devengado_concepto))
				{
					$this->salida = $valid->salida;
					return false;
				}

			}

			//Validar id_devengado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_devengado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado", $id_devengado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_financiador - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_concepto_ingas");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_concepto_ingas", $id_concepto_ingas))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_regional - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(150);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_programa - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe", $importe))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_devengado_detalle - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_devengado_concepto");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado_concepto", $id_devengado_concepto))
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