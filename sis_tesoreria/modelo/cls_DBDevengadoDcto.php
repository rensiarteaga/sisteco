<?php
/**
 * Nombre de la clase:	cls_DBDevengadoDcto.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_devengado_dcto
 * Autor:				RCM
 * Fecha creación:		13/03/2009
 */


class cls_DBDevengadoDcto
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
	 * Nombre de la función:	ListarDevengarServicios
	 * Propósito:				Desplegar los registros de tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function ListarDevengadoDcto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_dcto_sel';
		$this->codigo_procedimiento = "'TS_DEVDTO_SEL'";

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
		$this->var->add_def_cols('id_devengado_dcto','int4');
		$this->var->add_def_cols('id_devengado','int4');
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('fecha_reg','text');
		$this->var->add_def_cols('id_transaccion','int4');
		$this->var->add_def_cols('tipo_documento','numeric');
		$this->var->add_def_cols('nro_documento','bigint');
		$this->var->add_def_cols('fecha_documento','text');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_nit','varchar');
		$this->var->add_def_cols('nro_autorizacion','varchar');
		$this->var->add_def_cols('codigo_control','varchar');
		$this->var->add_def_cols('poliza_dui','varchar');
		$this->var->add_def_cols('formulario','varchar');
		$this->var->add_def_cols('tipo_retencion','numeric');
		$this->var->add_def_cols('estado_documento','integer');
		$this->var->add_def_cols('id_documento_valor','integer');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('importe_ice','numeric');
		$this->var->add_def_cols('importe_exento','numeric');
		$this->var->add_def_cols('importe_sujeto','numeric');
		$this->var->add_def_cols('importe_credito','numeric');
		$this->var->add_def_cols('importe_iue','numeric');
		$this->var->add_def_cols('importe_it','numeric');
		$this->var->add_def_cols('importe_debito','numeric');
		$this->var->add_def_cols('desc_tipo_documento','varchar');
		$this->var->add_def_cols('desc_estado_documento','text');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('fk_devengado_dcto','integer');
		$this->var->add_def_cols('desc_tipo_documento_padre','varchar');
		$this->var->add_def_cols('nro_documento_padre','bigint');
		
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
	 * Nombre de la función:	ContarDevengarServicios
	 * Propósito:				Contar los registros de tts_devengado
	 * Autor:				    RCM
	 * Fecha de creación:		13/03/2009
	 */
	function ContarDevengadoDcto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_dcto_sel';
		$this->codigo_procedimiento = "'TS_DEVDTO_COUNT'";

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
	 * Nombre de la función:	InsertarDevengarServicios
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function InsertarDevengadoDcto($id_devengado_dcto,$id_devengado,$tipo_documento,$importe_doc,$id_moneda,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$estado_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_dcto_iud';
		$this->codigo_procedimiento = "'TS_DEVDTO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_devengado);	
		$this->var->add_param($tipo_documento);
		$this->var->add_param($importe_doc);
		$this->var->add_param($id_moneda);
		$this->var->add_param($nro_documento);
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");//10
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param("'$poliza_dui'");
		$this->var->add_param("'$formulario'");
		$this->var->add_param("'$tipo_retencion'");
		$this->var->add_param($estado_documento);//15

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarDevengarServicios
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function ModificarDevengadoDcto($id_devengado_dcto,$id_devengado,$tipo_documento,$importe_doc,$id_moneda,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$estado_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_dcto_iud';
		$this->codigo_procedimiento = "'TS_DEVDTO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado_dcto);
		$this->var->add_param($id_devengado);
		$this->var->add_param($tipo_documento);
		$this->var->add_param($importe_doc);
		$this->var->add_param($id_moneda);
		$this->var->add_param($nro_documento);
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");//10
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param("'$poliza_dui'");
		$this->var->add_param("'$formulario'");
		$this->var->add_param("'$tipo_retencion'");
		$this->var->add_param($estado_documento);//15

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarDevengarServicios
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function EliminarDevengadoDcto($id_devengado_dcto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_dcto_iud';
		$this->codigo_procedimiento = "'TS_DEVDTO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado_dcto);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//15

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	RegularizarProformasDevengado
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function RegularizarProformasDevengado($id_devengado_dcto,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$importe,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_devengado_regulariz_proforma';
		$this->codigo_procedimiento = "'TS_PROFOR_REG'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado_dcto);
		$this->var->add_param("$tipo_documento");
		$this->var->add_param("$nro_documento");
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param("$importe");
		$this->var->add_param("$id_moneda");//10

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
	 * Nombre de la función:	ObtenerTipoDocumentoAdq
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function ObtenerTipoDocumentoAdq($id_cotizacion,$id_plan_pago)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_ad_obtener_tipo_documento';
		$this->codigo_procedimiento = "''";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param($id_plan_pago);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;
		
		$this->salida=$this->var->salida;
		
		//echo $this->salida;
		//exit;
		
		//echo"<pre>";
		//print_r($this->salida);
		//echo"</pre>";
		//exit;

		return $res;
	}


	/**
	 * Nombre de la función:	ValidarDevengarServicios
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function ValidarDevengarServicios($operacion_sql,$id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado)
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
				//Validar id_devengado - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_devengado");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado", $id_devengado))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_concepto_ingas - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_concepto_ingas");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_concepto_ingas", $id_concepto_ingas))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_devengado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_devengado");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_devengado", $importe_devengado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_devengado - tipo numeric
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_devengado");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_devengado", $estado_devengado))
			{
			$this->salida = $valid->salida;
			return false;
			}*/

			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_devengado - tipo numeric
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_devengado");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_devengado", $tipo_devengado))
			{
			$this->salida = $valid->salida;
			return false;
			}*/
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_devengado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_devengado");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado", $id_devengado))
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