<?php
/**
 * Nombre de la clase:	cls_DBViaticoCalculo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_viatico_calculo
 * Autor:				(autogenerado)
 * Fecha creación:		2009-04-16 11:37:06
 */

 
class cls_DBViaticoCalculo
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
	 * Nombre de la función:	ListarViaticoCalculo
	 * Propósito:				Desplegar los registros de tts_viatico_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-04-16 11:37:06
	 */
	function ListarViaticoCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_calculo_sel';
		$this->codigo_procedimiento = "'TS_VIACAL_SEL'";

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
		$this->var->add_def_cols('id_viatico_calculo','int4');
		$this->var->add_def_cols('id_viatico','int4');
		$this->var->add_def_cols('id_origen','int4');
		$this->var->add_def_cols('lugar_origen','varchar');
		$this->var->add_def_cols('id_destino','int4');
		$this->var->add_def_cols('lugar_destino','varchar');
		$this->var->add_def_cols('tipo_destino','numeric');
		$this->var->add_def_cols('id_cobertura','int4');
		$this->var->add_def_cols('desc_cobertura','numeric');
		$this->var->add_def_cols('id_entidad','int4');
		$this->var->add_def_cols('nombre_entidad','varchar');
		$this->var->add_def_cols('fecha_inicio','text');
		$this->var->add_def_cols('fecha_final','text');
		$this->var->add_def_cols('hora_inicio','text');
		$this->var->add_def_cols('hora_final','text');
		$this->var->add_def_cols('nro_dias','numeric');
		$this->var->add_def_cols('importe_pasaje','numeric');
		$this->var->add_def_cols('importe_viatico','numeric');
		$this->var->add_def_cols('importe_hotel','numeric');
		$this->var->add_def_cols('importe_otros','numeric');
		$this->var->add_def_cols('total_pasaje','numeric');
		$this->var->add_def_cols('total_viaticos','numeric');
		$this->var->add_def_cols('total_hotel','numeric');
		$this->var->add_def_cols('total_general','numeric');
		$this->var->add_def_cols('tipo_viaje','numeric');
		$this->var->add_def_cols('importe_retencion','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarViaticoCalculo
	 * Propósito:				Contar los registros de tts_viatico_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-04-16 11:37:06
	 */
	function ContarViaticoCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_calculo_sel';
		$this->codigo_procedimiento = "'TS_VIACAL_COUNT'";

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
	 * Nombre de la función:	InsertarViaticoCalculo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_viatico_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-04-16 11:37:06
	 */
	function InsertarViaticoCalculo($id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_viaje,$importe_retencion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_calculo_iud';
		$this->codigo_procedimiento = "'TS_VIACAL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_viatico);
		$this->var->add_param($id_origen);
		$this->var->add_param($id_destino);
		$this->var->add_param($id_cobertura);
		$this->var->add_param($id_entidad);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_final'");
		$this->var->add_param($nro_dias);
		$this->var->add_param($importe_pasaje);
		$this->var->add_param($importe_viatico);
		$this->var->add_param($importe_hotel);
		$this->var->add_param($importe_otros);
		$this->var->add_param($total_pasaje);
		$this->var->add_param($total_viaticos);
		$this->var->add_param($total_hotel);
		$this->var->add_param($total_general);
		$this->var->add_param($tipo_viaje);
		$this->var->add_param($importe_retencion);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarViaticoCalculo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_viatico_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-04-16 11:37:06
	 */
	function ModificarViaticoCalculo($id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_viaje,$importe_retencion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_calculo_iud';
		$this->codigo_procedimiento = "'TS_VIACAL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_viatico_calculo);
		$this->var->add_param($id_viatico);
		$this->var->add_param($id_origen);
		$this->var->add_param($id_destino);
		$this->var->add_param($id_cobertura);
		$this->var->add_param($id_entidad);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_final'");
		$this->var->add_param($nro_dias);
		$this->var->add_param($importe_pasaje);
		$this->var->add_param($importe_viatico);
		$this->var->add_param($importe_hotel);
		$this->var->add_param($importe_otros);
		$this->var->add_param($total_pasaje);
		$this->var->add_param($total_viaticos);
		$this->var->add_param($total_hotel);
		$this->var->add_param($total_general);
		$this->var->add_param($tipo_viaje);
		$this->var->add_param($importe_retencion);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarViaticoCalculo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_viatico_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-04-16 11:37:06
	 */
	function EliminarViaticoCalculo($id_viatico_calculo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_calculo_iud';
		$this->codigo_procedimiento = "'TS_VIACAL_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_viatico_calculo);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//importe_retencion

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarViaticoCalculo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_viatico_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-04-16 11:37:06
	 */
	function ValidarViaticoCalculo($operacion_sql,$id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_viaje)
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
				//Validar id_viatico_calculo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_viatico_calculo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_viatico_calculo", $id_viatico_calculo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_viatico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_viatico");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_viatico", $id_viatico))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_origen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_origen");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_origen", $id_origen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_destino");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_destino", $id_destino))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cobertura - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cobertura");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cobertura", $id_cobertura))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_entidad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_entidad");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_entidad", $id_entidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_inicio - tipo timestamptz
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_inicio");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fecha_inicio", $fecha_inicio))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_final - tipo timestamptz
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_final");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fecha_final", $fecha_final))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_dias - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_dias");
			$tipo_dato->set_MaxLength(196608);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "nro_dias", $nro_dias))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_pasaje - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_pasaje");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_pasaje", $importe_pasaje))
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

			//Validar importe_hotel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_hotel");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_hotel", $importe_hotel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_otros - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_otros");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_otros", $importe_otros))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar total_pasaje - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("total_pasaje");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "total_pasaje", $total_pasaje))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar total_viaticos - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("total_viaticos");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "total_viaticos", $total_viaticos))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar total_hotel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("total_hotel");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "total_hotel", $total_hotel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar total_general - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("total_general");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "total_general", $total_general))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_viaje - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_viaje");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_viaje", $tipo_viaje))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_viatico_calculo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_viatico_calculo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_viatico_calculo", $id_viatico_calculo))
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