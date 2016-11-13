<?php
/**
 * Nombre de la clase:	cls_DBCuentaDocDet.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_cuenta_doc_det
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2009-10-27 11:50:09
 */

 
class cls_DBCuentaDocDet
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
	 * Nombre de la funci�n:	ListarDetalleViatico
	 * Prop�sito:				Desplegar los registros de tts_cuenta_doc_det
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 11:50:09
	 */
	function ListarDetalleViatico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_det_sel';
		$this->codigo_procedimiento = "'TS_DETVIA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta_doc_det','int4');
		$this->var->add_def_cols('id_cuenta_doc','int4');
		$this->var->add_def_cols('cantidad','int4');
		$this->var->add_def_cols('tipo_transporte','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('importe_entregado','numeric');
		$this->var->add_def_cols('id_tipo_destino','int4');
		$this->var->add_def_cols('desc_tipo_destino','varchar');
		$this->var->add_def_cols('id_cobertura','int4');
		$this->var->add_def_cols('desc_cobertura','varchar');
		$this->var->add_def_cols('id_concepto_ingas','int4');
		$this->var->add_def_cols('desc_concepto_ingas','varchar');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_cuenta_doc_rendicion','int4');
		$this->var->add_def_cols('id_orden_trabajo','int4');
		$this->var->add_def_cols('desc_orden_trabajo','varchar');
		$this->var->add_def_cols('entrega_importe','varchar');
		$this->var->add_def_cols('nombre_item','varchar');
		$this->var->add_def_cols('nombre_servicio','varchar');
		$this->var->add_def_cols('id_solicitud_compra','int4');
		
		$this->var->add_def_cols('id_partida','int4');	      
		$this->var->add_def_cols('desc_partida','text');
		$this->var->add_def_cols('id_cuenta','int4');		
 		$this->var->add_def_cols('desc_cuenta','text');
 		$this->var->add_def_cols('id_auxiliar','int4');
 		$this->var->add_def_cols('desc_auxiliar','text');
 		$this->var->add_def_cols('id_categoria','integer');
 		$this->var->add_def_cols('desc_categoria','varchar');
 		$this->var->add_def_cols('id_parametro','integer');
 		$this->var->add_def_cols('desc_parametro','numeric');
 		$this->var->add_def_cols('fecha_ini','date');
 		$this->var->add_def_cols('fecha_fin','date');
 		$this->var->add_def_cols('cantidad_dias_ant','integer');
 		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarDetalleViatico
	 * Prop�sito:				Contar los registros de tts_cuenta_doc_det
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 11:50:09
	 */
	function ContarDetalleViatico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_det_sel';
		$this->codigo_procedimiento = "'TS_DETVIA_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;

		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	function ListarImportesTotalesRendicionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_det_sel';
		$this->codigo_procedimiento = "'TS_IMPTOTRENDET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Carga la definici�n de columnas con sus tipos de datos		
		$this->var->add_def_cols('id_cuenta_doc','int4');
		$this->var->add_def_cols('id_cuenta_doc_rendicion','int4');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('importe_entregado','numeric');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	InsertarDetalleViatico
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tts_cuenta_doc_det
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 11:50:09
	 */
	function InsertarDetalleViatico($id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto,$observaciones,$id_cuenta_doc_rendicion,$id_orden_trabajo,$id_solicitud,$entrega_importe,$id_categoria,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_det_iud';
		$this->codigo_procedimiento = "'TS_DETVIA_INS'";
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_cuenta_doc);
		$this->var->add_param($cantidad);
		$this->var->add_param("'$tipo_transporte'");
		$this->var->add_param($importe);
		$this->var->add_param($id_tipo_destino);
		$this->var->add_param($id_cobertura);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_cuenta_doc_rendicion);
		$this->var->add_param($id_orden_trabajo);
		$this->var->add_param($id_solicitud);
		$this->var->add_param("'$entrega_importe'");
		$this->var->add_param($id_categoria);
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
        /* if($_SESSION['ss_id_usuario']==131){
		     echo $this->query;
			 exit;
        }*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarDetalleViatico
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_cuenta_doc_det
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 11:50:09
	 */
	//function ModificarDetalleViatico($id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_cuenta_doc_det,$id_cuenta_doc,$id_concepto_ingas,$id_presupuesto,$observaciones,$id_cuenta_doc_rendicion)
	function ModificarDetalleViatico($id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto,$observaciones,$id_cuenta_doc_rendicion,$id_orden_trabajo,$id_solicitud,$entrega_importe,$id_categoria,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_det_iud';
		$this->codigo_procedimiento = "'TS_DETVIA_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc_det);
		$this->var->add_param($id_cuenta_doc);
		$this->var->add_param($cantidad);
		$this->var->add_param("'$tipo_transporte'");
		$this->var->add_param($importe);
		$this->var->add_param($id_tipo_destino);
		$this->var->add_param($id_cobertura);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_cuenta_doc_rendicion);
		$this->var->add_param($id_orden_trabajo);
        $this->var->add_param($id_solicitud);
        $this->var->add_param("'$entrega_importe'");
        $this->var->add_param($id_categoria);
        $this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
/*if($_SESSION['ss_id_usuario']==131){
		     echo $this->query;
			 exit;
        }*/	
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarDetalleViatico
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tts_cuenta_doc_det
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 11:50:09
	 */
	function EliminarDetalleViatico($id_cuenta_doc_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_det_iud';
		$this->codigo_procedimiento = "'TS_DETVIA_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc_det);
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
		$this->var->add_param("NULL");//id_orden_trabajo
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fecha_ini
		$this->var->add_param("NULL");//fecha_fin

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function ObtenerImporteViatico($id_categoria,$id_cobertura,$id_tipo_destino,$cantidad,$fecha,$fecha_ini,$fecha_fin,$id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_det_sel';
		$this->codigo_procedimiento = "'TS_IMPVIA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = 0;//para mandar el id_caja_regis como entero
		$this->var->puntero =0;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "''";
		
		$id_financiador=$id_categoria;
		$id_regional=$id_cobertura;
		$id_programa=$id_tipo_destino;
		$id_proyecto=$cantidad;
		$id_actividad=$id_cuenta_doc;
		
		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("'$fecha'");
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('resultado','int4');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('cantidad','int4');
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;
		*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarDetalleViatico
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tts_cuenta_doc_det
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 11:50:09
	 */
	function ValidarDetalleViatico($operacion_sql,$id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validaci�n por el tipo de operaci�n
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_cuenta_doc_det - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cuenta_doc_det");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_doc_det", $id_cuenta_doc_det))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_cuenta_doc - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_doc");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_doc", $id_cuenta_doc))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cantidad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "cantidad", $cantidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_transporte - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_transporte");
			$tipo_dato->set_MaxLength(25);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_transporte", $tipo_transporte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe", $importe))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_destino");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_destino", $id_tipo_destino))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cobertura - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cobertura");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cobertura", $id_cobertura))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_concepto_ingas - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_concepto_ingas");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_concepto_ingas", $id_concepto_ingas))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_presupuesto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_presupuesto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_presupuesto", $id_presupuesto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cuenta_doc_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_doc_det");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_doc_det", $id_cuenta_doc_det))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validaci�n exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
}?>