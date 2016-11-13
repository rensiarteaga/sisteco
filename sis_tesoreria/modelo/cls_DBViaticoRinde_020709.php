<?php
/**
 * Nombre de la clase:	cls_DBViaticoRinde.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_viatico_rinde
 * Autor:				(autogenerado)
 * Fecha creación:		2008-11-27 12:11:22
 */

 
class cls_DBViaticoRinde
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
	 * Nombre de la función:	ListarRendicionViaticos
	 * Propósito:				Desplegar los registros de tts_viatico_rinde
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-27 12:11:22
	 */
	function ListarRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_rinde_sel';
		$this->codigo_procedimiento = "'TS_RENVIA_SEL'";

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
		$this->var->add_def_cols('id_viatico_rinde','int4');
		$this->var->add_def_cols('id_viatico','int4');
		$this->var->add_def_cols('tipo_documento','numeric');
		$this->var->add_def_cols('nro_documento','bigint');
		$this->var->add_def_cols('fecha_documento','date');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_nit','varchar');
		$this->var->add_def_cols('nro_autorizacion','varchar');
		$this->var->add_def_cols('codigo_control','varchar');
		$this->var->add_def_cols('id_concepto_ingas','int4');			
		$this->var->add_def_cols('desc_concepto_ingas','varchar');
		$this->var->add_def_cols('importe_rendicion','numeric');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('id_transaccion','integer');
		$this->var->add_def_cols('id_partida_ejecucion','integer');
		$this->var->add_def_cols('estado_rendicion','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;exit();
		
		return $res;
	}
	/**
	 * Nombre de la función:	ListarReporteRendicionViaticos
	 * Propósito:				Desplegar los registros 
	 * Autor:				    JoSé Mita
	 * Fecha de creación:		hoy
	 */
	function ListarNombreGerente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_rinde_sel';
		$this->codigo_procedimiento = "'TS_OBTNOM_SEL'";

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

		$this->var->add_def_cols('nombre_nivel','varchar');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('nombre','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit();
		return $res;
	}
	/**
	 * Nombre de la función:	ListarRendicionViaticosDetalle
	 * Propósito:				Desplegar los registros de tts_viatico_rinde
	 * Autor:				    José Abraham Mita Huanca
	 * Fecha de creación:		2009-03-26 10:48:22
	 */
	function ListarRendicionViaticosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_rinde_sel';
		$this->codigo_procedimiento = "'TS_RENVIADET_SEL'";

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
		$this->var->add_def_cols('nextval','bigint');
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('detalle','text');
		$this->var->add_def_cols('cargo','varchar');
		$this->var->add_def_cols('total','numeric');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;exit();
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRendicionViaticos
	 * Propósito:				Contar los registros de tts_viatico_rinde
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-27 12:11:22
	 */
	function ContarRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_rinde_sel';
		$this->codigo_procedimiento = "'TS_RENVIA_COUNT'";

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
	 * Nombre de la función:	InsertarRendicionViaticos
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_viatico_rinde
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-27 12:11:22
	 */
	function InsertarRendicionViaticos($id_viatico_rinde,$id_viatico,$id_concepto_ingas,$importe_rendicion,
										$tipo_documento,$nro_documento,$fecha_documento,$razon_social,
										$nro_nit,$nro_autorizacion,$codigo_control,$id_presupuesto,$id_depto,
										$id_transaccion,$id_partida_ejecucion,$estado_rendicion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_rinde_iud';
		$this->codigo_procedimiento = "'TS_RENVIA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_viatico);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($importe_rendicion);
		$this->var->add_param($tipo_documento);
		$this->var->add_param($nro_documento);
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param($id_presupuesto);
        $this->var->add_param($id_depto);
        $this->var->add_param($id_transaccion);
		$this->var->add_param($id_partida_ejecucion);
		$this->var->add_param($estado_rendicion);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRendicionViaticos
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_viatico_rinde
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-27 12:11:22
	 */
	function ModificarRendicionViaticos($id_viatico_rinde,$id_viatico,$id_concepto_ingas,$importe_rendicion,
										$tipo_documento,$nro_documento,$fecha_documento,$razon_social,
										$nro_nit,$nro_autorizacion,$codigo_control,$id_presupuesto,$id_depto,
										$id_transaccion,$id_partida_ejecucion,$estado_rendicion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_rinde_iud';
		$this->codigo_procedimiento = "'TS_RENVIA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_viatico_rinde);
		$this->var->add_param($id_viatico);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($importe_rendicion);
		$this->var->add_param($tipo_documento);
		$this->var->add_param($nro_documento);
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param($id_presupuesto);
        $this->var->add_param($id_depto);
        $this->var->add_param($id_transaccion);
		$this->var->add_param($id_partida_ejecucion);
		$this->var->add_param($estado_rendicion);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRendicionViaticos
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_viatico_rinde
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-27 12:11:22
	 */
	function EliminarRendicionViaticos($id_viatico_rinde)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_rinde_iud';
		$this->codigo_procedimiento = "'TS_RENVIA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_viatico_rinde);
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
		
		$this->var->add_param("NULL");	//id_presupuesto
		$this->var->add_param("NULL");	//id_depto
		$this->var->add_param("NULL"); //$id_transaccion
		$this->var->add_param("NULL"); //$id_partida_ejecucion
		$this->var->add_param("NULL"); //$estado_rendicion

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarRendicionViaticos
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_viatico_rinde
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-27 12:11:22
	 */
	function ValidarRendicionViaticos($operacion_sql,$id_viatico_rinde,$id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control)
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
				//Validar id_viatico_rinde - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_viatico_rinde");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_viatico_rinde", $id_viatico_rinde))
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

			//Validar id_concepto_ingas - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_concepto_ingas");
			$tipo_dato->set_MaxLength(10);			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_concepto_ingas", $id_concepto_ingas))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_rendicion - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_rendicion");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_rendicion", $importe_rendicion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_documento - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_documento");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_documento", $tipo_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_documento - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_documento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_documento", $nro_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_documento - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_documento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_documento", $fecha_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar razon_social - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("razon_social");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "razon_social", $razon_social))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_nit - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_nit");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_nit", $nro_nit))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_autorizacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_autorizacion");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_autorizacion", $nro_autorizacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo_control - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_control");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_control", $codigo_control))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_viatico_rinde - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_viatico_rinde");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_viatico_rinde", $id_viatico_rinde))
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