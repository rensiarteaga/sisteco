<?php
/**
 * Nombre de la clase:	cls_DBDevPasaje.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_cuenta_doc_det
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-21 15:43:28
 */


class cls_DBDevPasaje
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
	 * Nombre de la función:	ListarDevPasaje
	 * Propósito:				Desplegar los registros de tts_cuenta_doc_det
	 * Autor:				    TSL
	 * Fecha de creación:		2009.11.12
	 */
	function ListarDevPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dev_pasaje_sel';
		$this->codigo_procedimiento = "'TS_DEVPAS_SEL'";

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
		$this->var->add_def_cols('id_cuenta_doc_det','int4');
		$this->var->add_def_cols('sw_select','numeric');
		$this->var->add_def_cols('partida','text');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('pasaje_orden','numeric');
		$this->var->add_def_cols('nota_debito','varchar');
		$this->var->add_def_cols('pasaje_nro','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('pasaje_cobrar','numeric');
		$this->var->add_def_cols('pasaje_credito','numeric');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('fecha_sol', 'date' );
		$this->var->add_def_cols('recorrido','varchar');
		$this->var->add_def_cols('res_pago','text');
		$this->var->add_def_cols('res_dev','text');
		$this->var->add_def_cols('nro_documento','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo "query:".$this->query;
		exit;*/
		return $res;
	}

	/**
	 * Nombre de la función:	ContarDevPasaje
	 * Propósito:				Contar los registros de tts_cuenta_doc_det
	 * Autor:				    TSL
	 * Fecha de creación:		2009.11.12
	 */
	function ContarDevPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dev_pasaje_sel';
		$this->codigo_procedimiento = "'TS_DEVPAS_COUNT'";

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
	 * Nombre de la función:	InsertarDevPasaje
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_dev_pasaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function InsertarDevPasaje($id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dev_pasaje_iud';
		$this->codigo_procedimiento = "'TS_DEVPAS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($sw_select);
		$this->var->add_param($desc_presupuesto);
		$this->var->add_param($fecha_ini);
		$this->var->add_param($importe);
		$this->var->add_param($observaciones);
 		
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
	 * Nombre de la función:	ModificarDevPasaje
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_dev_pasaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ModificarDevPasaje($id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dev_pasaje_iud';
		$this->codigo_procedimiento = "'TS_DEVPAS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc_det);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($sw_select);
		$this->var->add_param($desc_presupuesto);
		$this->var->add_param($fecha_ini);
		$this->var->add_param($importe);
		$this->var->add_param($observaciones);
 

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarDevPasaje
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_dev_pasaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function EliminarDevPasaje($id_cuenta_doc_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dev_pasaje_iud';
		$this->codigo_procedimiento = "'TS_DEVPAS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc_det);
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

		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	SelectDevPasaje
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_dev_pasaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function SelectDevPasaje($id_cuenta_doc_det,$sw_select)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dev_pasaje_iud';
		$this->codigo_procedimiento = "'TS_DEVPAS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc_det);
		$this->var->add_param("NULL");
		$this->var->add_param($sw_select);
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
	 * Nombre de la función:	SelectDevPasaje
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_dev_pasaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ProceDevPasaje($id_depto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dev_pasaje_iud';
		$this->codigo_procedimiento = "'TS_DEVPAS_PRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_depto");//en vez de id_cuenta_doc_det mando el id_depto
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
	 * Nombre de la función:	ValidarDevPasaje
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_dev_pasaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ValidarDevPasaje($operacion_sql,$id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones)
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
				//Validar id_dev_pasaje - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cuenta_doc_det");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_doc_det", $id_dev_pasaje))
				{
					$this->salida = $valid->salida;
					return false;
				}

			}

			//Validar importe_devengado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_select");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "sw_select", $importe_devengado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_dev_pasaje - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_doc_det");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_doc_det", $id_dev_pasaje))
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