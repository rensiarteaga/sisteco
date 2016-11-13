<?php
/**
 * Nombre de la clase:	cls_DBCorteArqueo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_corte_arqueo
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-23 18:24:29
 */

 
class cls_DBCorteArqueo
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
	 * Nombre de la función:	ListarDetalleCortes
	 * Propósito:				Desplegar los registros de tts_corte_arqueo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-23 18:24:29
	 */
	function ListarDetalleCortes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_corte_arqueo_sel';
		$this->codigo_procedimiento = "'TS_DETCOR_SEL'";

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
		$this->var->add_def_cols('id_corte_arqueo','int4');
		$this->var->add_def_cols('id_caja_arqueo','int4');
		$this->var->add_def_cols('desc_caja_arqueo','int4');
		$this->var->add_def_cols('id_corte','int4');
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('importe_valor_corte_moneda','numeric');
		$this->var->add_def_cols('tipo_corte_corte_moneda','numeric');
		$this->var->add_def_cols('desc_corte_moneda','text');
		$this->var->add_def_cols('cantidad_corte','int4');
		$this->var->add_def_cols('importe_total','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDetalleCortes
	 * Propósito:				Contar los registros de tts_corte_arqueo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-23 18:24:29
	 */
	function ContarDetalleCortes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_corte_arqueo_sel';
		$this->codigo_procedimiento = "'TS_DETCOR_COUNT'";

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
	 * Nombre de la función:	InsertarDetalleCortes
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_corte_arqueo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-23 18:24:29
	 */
	function InsertarDetalleCortes($id_corte_arqueo,$id_caja_arqueo,$id_corte,$cantidad_corte)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_corte_arqueo_iud';
		$this->codigo_procedimiento = "'TS_DETCOR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_caja_arqueo);
		$this->var->add_param($id_corte);
		$this->var->add_param($cantidad_corte);
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
	 * Nombre de la función:	ModificarDetalleCortes
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_corte_arqueo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-23 18:24:29
	 */
	function ModificarDetalleCortes($id_corte_arqueo,$id_caja_arqueo,$id_corte,$cantidad_corte)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_corte_arqueo_iud';
		$this->codigo_procedimiento = "'TS_DETCOR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_corte_arqueo);
		$this->var->add_param($id_caja_arqueo);
		$this->var->add_param($id_corte);
		$this->var->add_param($cantidad_corte);
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
	 * Nombre de la función:	EliminarDetalleCortes
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_corte_arqueo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-23 18:24:29
	 */
	function EliminarDetalleCortes($id_corte_arqueo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_corte_arqueo_iud';
		$this->codigo_procedimiento = "'TS_DETCOR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_corte_arqueo);
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
	 * Nombre de la función:	ValidarDetalleCortes
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_corte_arqueo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-23 18:24:29
	 */
	function ValidarDetalleCortes($operacion_sql,$id_corte_arqueo,$id_caja_arqueo,$id_corte,$cantidad_corte)
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
				//Validar id_corte_arqueo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_corte_arqueo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_corte_arqueo", $id_corte_arqueo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_caja_arqueo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_caja_arqueo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja_arqueo", $id_caja_arqueo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_corte - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_corte");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_corte", $id_corte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cantidad_corte - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad_corte");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "cantidad_corte", $cantidad_corte))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_corte_arqueo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_corte_arqueo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_corte_arqueo", $id_corte_arqueo))
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