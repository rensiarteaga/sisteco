<?php
/**
 * Nombre de la clase:	cls_DBCuentaDoc.php
 * Propï¿½sito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_cuenta_doc
 * Autor:				(autogenerado)
 * Fecha creaciï¿½n:		2009-10-27 11:50:07
 */

 
class cls_DBCuentaDoc
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
	 * Nombre de la funciï¿½n:	ListarSolicitudViaticos2
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	/*function ListarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		
		if($vista=='solicitud_efectivo')
			$this->codigo_procedimiento = "'TS_SOLEFE_SEL'";
		else 	
			$this->codigo_procedimiento = "'TS_SOLVIA2_SEL'";
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("'$estado'");

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta_doc','int4');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_categoria','int4');
		$this->var->add_def_cols('desc_categoria','varchar');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('tipo_contrato','varchar');
		$this->var->add_def_cols('id_usuario_rendicion','int4');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('recorrido','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('fecha_sol','date');
		$this->var->add_def_cols('fa_solicitud','varchar');
		$this->var->add_def_cols('id_caja','int4');
		$this->var->add_def_cols('desc_caja','varchar');
		$this->var->add_def_cols('id_cajero','int4');
		$this->var->add_def_cols('desc_cajero','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('desc_parametro','numeric');
		if($vista=='solicitud_efectivo'){
			
			
			$this->var->add_def_cols('importe_entregado','numeric');
			$this->var->add_def_cols('id_proveedor','integer');
			$this->var->add_def_cols('desc_proveedor','text');
			$this->var->add_def_cols('id_subsistema','integer');
			$this->var->add_def_cols('tipo_recibo','varchar');
			$this->var->add_def_cols('fk_id_cuenta_doc','integer');
				
		} else{
			$this->var->add_def_cols('tipo_pago_fin','varchar');
			$this->var->add_def_cols('id_cuenta_bancaria','integer');
			$this->var->add_def_cols('id_cuenta_bancaria_fin','integer');
			$this->var->add_def_cols('id_caja_fin','integer');
			$this->var->add_def_cols('id_cajero_fin','integer');
			$this->var->add_def_cols('nro_deposito','varchar');
			$this->var->add_def_cols('desc_cuenta_bancaria_fin','varchar');
			$this->var->add_def_cols('desc_caja_fin','varchar');
			$this->var->add_def_cols('desc_cajero_fin','varchar');
			
			$this->var->add_def_cols('resp_registro','text');
			$this->var->add_def_cols('id_autorizacion','int4');	
			$this->var->add_def_cols('desc_autorizacion','text');
			$this->var->add_def_cols('nombre_cheque','varchar');
			$this->var->add_def_cols('saldo_solicitante','numeric');
		}

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit();
		
		return $res;
	}*/
	
/**
	 * Nombre de la funciï¿½n:	ListarSolicitudViaticos2
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	function ListarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		
		if($vista=='solicitud_efectivo')
			$this->codigo_procedimiento = "'TS_SOLEFE_SEL'";
		else 	
			$this->codigo_procedimiento = "'TS_SOLVIA2_SEL'";
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("'$estado'");

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta_doc','int4');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_categoria','int4');
		$this->var->add_def_cols('desc_categoria','varchar');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('tipo_contrato','varchar');
		$this->var->add_def_cols('id_usuario_rendicion','int4');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('recorrido','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('fecha_sol','date');
		$this->var->add_def_cols('fa_solicitud','varchar');
		$this->var->add_def_cols('id_caja','int4');
		$this->var->add_def_cols('desc_caja','varchar');
		$this->var->add_def_cols('id_cajero','int4');
		$this->var->add_def_cols('desc_cajero','varchar');
		
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('resp_registro','text');
		if($vista=='solicitud_efectivo'){
			
			
			$this->var->add_def_cols('importe_entregado','numeric');
			$this->var->add_def_cols('id_proveedor','integer');
			$this->var->add_def_cols('desc_proveedor','text');
			$this->var->add_def_cols('id_subsistema','integer');
			$this->var->add_def_cols('tipo_recibo','varchar');
			$this->var->add_def_cols('fk_id_cuenta_doc','integer');
			$this->var->add_def_cols('id_autorizacion','int4');	
			$this->var->add_def_cols('desc_autorizacion','text');
			$this->var->add_def_cols('nro_dias_para_rendir','integer');
			$this->var->add_def_cols('fecha_aut_rendicion','timestamp');
			$this->var->add_def_cols('cant_rend_registradas','bigint');
			$this->var->add_def_cols('cant_rend_finalizadas','bigint');
			$this->var->add_def_cols('cant_rend_contabilizadas','bigint');
				
		} else{
			$this->var->add_def_cols('tipo_pago_fin','varchar');
			$this->var->add_def_cols('id_cuenta_bancaria','integer');
			$this->var->add_def_cols('id_cuenta_bancaria_fin','integer'); 
			$this->var->add_def_cols('id_caja_fin','integer');
			$this->var->add_def_cols('id_cajero_fin','integer');
			$this->var->add_def_cols('nro_deposito','varchar');
			$this->var->add_def_cols('desc_cuenta_bancaria_fin','varchar');
			$this->var->add_def_cols('desc_caja_fin','varchar');
			$this->var->add_def_cols('desc_cajero_fin','varchar');
			
			
			$this->var->add_def_cols('id_autorizacion','int4');	
			$this->var->add_def_cols('desc_autorizacion','text');
			$this->var->add_def_cols('nombre_cheque','varchar');
			$this->var->add_def_cols('tipo_cuenta_doc','varchar');
			$this->var->add_def_cols('fk_id_cuenta_doc','integer');
			$this->var->add_def_cols('id_usuario_reg','integer');
			$this->var->add_def_cols('id_comprobante','integer');
			$this->var->add_def_cols('nro_dias_para_rendir','integer');
			$this->var->add_def_cols('fecha_aut_rendicion','timestamp');
			$this->var->add_def_cols('cant_rend_registradas','bigint');
			$this->var->add_def_cols('cant_rend_finalizadas','bigint');
			$this->var->add_def_cols('cant_rend_contabilizadas','bigint');
			
			$this->var->add_def_cols('codigo_caja','varchar');
			
			$this->var->add_def_cols('saldo_solicitante','numeric');
			
		}

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//if($_SESSION["ss_id_usuario"])
		/*echo $this->query;
		exit;*/
		/*if ($_SESSION["ss_id_usuario"]==131){
		echo $this->query;
		exit;
			}*/
			
		return $res;
	}	/**
	 * Nombre de la funciï¿½n:	ListarSolicitudViaticos2
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	function ListarDatosTesorero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		
		$this->codigo_procedimiento = "'TS_DATESOR_SEL'";
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("''");

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta_doc','int4');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('tipo_cuenta_doc','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_sol','date');
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('saldo_solicitante','numeric');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('tipo_pago_fin','varchar');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
		$this->var->add_def_cols('id_cuenta_bancaria_fin','integer');
		$this->var->add_def_cols('id_caja_fin','integer');
		$this->var->add_def_cols('id_cajero_fin','integer');
		$this->var->add_def_cols('nro_deposito','varchar');
		$this->var->add_def_cols('desc_cuenta_bancaria','text');
		$this->var->add_def_cols('desc_cuenta_bancaria_fin','text');
		$this->var->add_def_cols('desc_caja_fin','varchar');
		$this->var->add_def_cols('desc_cajero_fin','text');
		$this->var->add_def_cols('nombre_cheque','varchar');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/* if ($_SESSION['ss_id_usuario']==131){
	     echo $this->query;
		 exit;
		}*/
		return $res;
	}
	
	
	function VerificarRendicionRecibo($id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_VERFINCD_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $id_cuenta_doc;//para mandar el id_caja_regis como entero
		$this->var->puntero =0;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "''";
		
		$id_financiador='';
		$id_regional='';
		$id_programa='';
		$id_proyecto='';
		$id_actividad='';
		
		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));
		$this->var->add_param("'$estado'");


		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('resultado','int4');
		$this->var->add_def_cols('monto','numeric');
		

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
	/**
	 * Nombre de la funciï¿½n:	ContarSolicitudViaticos2
	 * Propï¿½sito:				Contar los registros de tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	function ContarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		if($vista=='solicitud_efectivo')
			$this->codigo_procedimiento = "'TS_SOLEFE_COUNT'";
		else 	
			$this->codigo_procedimiento = "'TS_SOLVIA2_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("'$estado'");
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;

		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ContarSolicitudViaticos2
	 * Propï¿½sito:				Contar los registros de tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	function ContarDatosTesorero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		
		$this->codigo_procedimiento = "'TS_DATESOR_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("''");
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;

		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	
	
	/**
	 * Nombre de la funciï¿½n:	InsertarSolicitudViaticos2
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de inserciï¿½n de la tabla tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	/**
	 * Nombre de la funciï¿½n:	InsertarSolicitudViaticos2
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de inserciï¿½n de la tabla tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	function InsertarSolicitudViaticos2($id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones,$fk_id_cuenta_doc,$id_moneda,$fecha_sol,$fa_solicitud,$vista,$id_caja,$id_cajero,$id_proveedor,$id_autorizacion,$nombre_cheque,$tipo_rendicion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_iud';
		if($vista=='rendicion_caja')
			$this->codigo_procedimiento = "'TS_CAJREN_INS'";
		else
			$this->codigo_procedimiento = "'TS_SOLVIA2_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_categoria);
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$tipo_pago'");
		$this->var->add_param("'$tipo_contrato'");
		$this->var->add_param($id_usuario_rendicion);
		$this->var->add_param("'$motivo'");
		$this->var->add_param("'$recorrido'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_depto);
		$this->var->add_param("'$vista'");
		if($fk_id_cuenta_doc==0)
			$this->var->add_param("NULL");
		else
			$this->var->add_param($fk_id_cuenta_doc);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$fecha_sol'");
		$this->var->add_param("'$fa_solicitud'");//fa_solicitud
		$this->var->add_param($id_caja);
		$this->var->add_param($id_cajero);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_proveedor);
		$this->var->add_param("NULL");//importe_entregado
		$this->var->add_param($id_autorizacion);
		$this->var->add_param("'$nombre_cheque'");
		$this->var->add_param("'$tipo_rendicion'");

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		/*if($_SESSION["ss_id_usuario"]==120){echo $this->query;
		exit;}*/

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ModificarSolicitudViaticos2
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de modificaciï¿½n de la tabla tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	function ModificarSolicitudViaticos2($id_cuenta_doc,$id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones,$fk_id_cuenta_doc,$id_moneda,$fecha_sol,$fa_solicitud,$vista,$id_caja,$id_cajero,$accion,$id_proveedor,$importe_entregado,$id_cuenta_bancaria,$id_autorizacion,$nombre_cheque,$tipo_rendicion)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_iud';
		if($vista=='rendicion_caja')
		{
			if($accion=='generar_reposicion')
				$this->codigo_procedimiento = "'TS_CAJREPO_UPD'";
			elseif($accion=='contabilizar_rendicion')
				$this->codigo_procedimiento = "'TS_RENCONT_UPD'";
			elseif($accion=='finalizar_rendicion')
				$this->codigo_procedimiento = "'TS_RENFIN_UPD2'";
			elseif($accion=='pagar_provisorio')
				$this->codigo_procedimiento = "'TS_PAGSOLEFE_UPD'";			
			else
				$this->codigo_procedimiento = "'TS_CAJREN_UPD'";
		}
		
		elseif($vista=='recibo_caja')
		{
			if($accion=='pagar_provisorio')
				$this->codigo_procedimiento = "'TS_PAGSOLEFE_UPD'";
									
			elseif($accion=='finalizar')
				$this->codigo_procedimiento = "'TS_FINSOLEFE_UPD'";
				
			else
				$this->codigo_procedimiento = "'TS_SOLVIA2_UPD'";
			
		}
		elseif($vista=='autorizacion_solicitud')
		{
			$this->codigo_procedimiento = "'TS_SOLVIA3_UPD'";
		}
		else
		{
			if($accion=='cheque')
				$this->codigo_procedimiento = "'TS_SOLVIA2_CHEQUE_UPD'";
			else
				$this->codigo_procedimiento = "'TS_SOLVIA2_UPD'";
		}

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_categoria);
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$tipo_pago'");
		$this->var->add_param("'$tipo_contrato'");
		$this->var->add_param($id_usuario_rendicion);
		$this->var->add_param("'$motivo'");
		$this->var->add_param("'$recorrido'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_depto);
		$this->var->add_param("'$vista'");
		if($fk_id_cuenta_doc==0)
			$this->var->add_param("NULL");
		else 
			$this->var->add_param($fk_id_cuenta_doc);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$fecha_sol'");
		$this->var->add_param("'$fa_solicitud'");//fa_solicitud
		$this->var->add_param($id_caja);
		$this->var->add_param($id_cajero);
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_proveedor);
		$this->var->add_param($importe_entregado);
		$this->var->add_param($id_autorizacion);
		$this->var->add_param("'$nombre_cheque'");
		$this->var->add_param("'$tipo_rendicion'");

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	EliminarSolicitudViaticos2
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	function EliminarSolicitudViaticos2($id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_iud';
		$this->codigo_procedimiento = "'TS_SOLVIA2_DEL'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc);
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
		$this->var->add_param("NULL");//fa_solicitud
		$this->var->add_param("NULL");//id_caja
		$this->var->add_param("NULL");//id_cajero
		$this->var->add_param("NULL");//id_cuenta_bancaria
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("NULL");//importe_entregado
		$this->var->add_param("NULL");//id_autorizacion
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//tipo_rendicion

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la funciï¿½n:	EliminarSolicitudViaticos2
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	function CambiarEstadoCuentaDoc($id_cuenta_doc,$accion,$id_caja,$id_cajero,$id_cuenta_bancaria,$nombre_cheque)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_iud';
		
		if($accion=='solicitar_pago'){
			$this->codigo_procedimiento = "'TS_SOLPAGCD_UPD'";
		}
		elseif ($accion=='corregir_solicitud'){
			$this->codigo_procedimiento = "'TS_CORSOLCD_UPD'";
		}
		elseif ($accion=='finalizar_rendicion'){
			$this->codigo_procedimiento = "'TS_FINRENCD_UPD'";
		}
		elseif ($accion=='corregir_rendicion'){
			$this->codigo_procedimiento = "'TS_CORRENCD_UPD'";
		}
		elseif ($accion=='contabilizar_sol_pago'){
			$this->codigo_procedimiento = "'TS_SOLPAG_CON'";
		} 

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc);
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
		$this->var->add_param("NULL");//fa_solicitud
		$this->var->add_param("$id_caja");//id_caja
		$this->var->add_param("$id_cajero");//id_cajero
		$this->var->add_param("$id_cuenta_bancaria");//id_cuenta_bancaria
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("NULL");//importe_entregado
		$this->var->add_param("NULL");//id_autorizacion
		$this->var->add_param("'$nombre_cheque'");
		$this->var->add_param("NULL");//tipo_rendicion
		
		//echo $this->var->get_query();
		//exit;

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
     /*if($_SESSION['ss_id_usuario']==131){
		     echo $this->query;
			 exit;
        }*/		
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	FinalizarRendiciones
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tts_cuenta_doc
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		14/11/2009
	 */
	function FinalizarRendiciones($id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_iud';
		$this->codigo_procedimiento = "'TS_RENDIC_FIN'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc);
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
		$this->var->add_param("NULL");//fa_solicitud
		$this->var->add_param("NULL");//id_caja
		$this->var->add_param("NULL");//id_cajero
		$this->var->add_param("NULL");//id_cuenta_bancaria
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("NULL");//importe_entregado
		$this->var->add_param("NULL");//id_autorizacion
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//tipo_rendicion

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la funciï¿½n:	ListarSolicitudViajes
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    ana maria villegas quispe
	 * Fecha de creaciï¿½n:		30/10/2009
	 * Fecha ult de mod:        08/12/2009
	 * Descripciï¿½n:             Se aï¿½adiï¿½ los atributos de las firmas de autorizaciï¿½n.
	 */
	function ListarSolicitudViajes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_SOLVIAT_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
		
		 $this->var->add_def_cols('id_cuenta_doc','INTEGER'); //0
  		 $this->var->add_def_cols('fecha_ini','text'); //1
  		 $this->var->add_def_cols('fecha_fin','text'); //2
  		  $this->var->add_def_cols('nro_dias','integer'); //2
  		 $this->var->add_def_cols('motivo','VARCHAR(500)'); //3
  		 $this->var->add_def_cols('observaciones','VARCHAR(500)'); //4
  	     $this->var->add_def_cols('recorrido','VARCHAR(300)'); //5
  		 $this->var->add_def_cols('tipo_pago','VARCHAR(15)'); //6
  		 $this->var->add_def_cols('tipo_contrato','VARCHAR(15)');//7 
  		 $this->var->add_def_cols('id_depto','INTEGER'); //8
  		 $this->var->add_def_cols('id_empleado','INTEGER'); //9
  	     $this->var->add_def_cols('tipo_transporte','VARCHAR');//10 
  		 $this->var->add_def_cols('unireg','TEXT'); // 11
  		 $this->var->add_def_cols('person_nombre','TEXT'); //12
  		 $this->var->add_def_cols('simbolo','VARCHAR');//13
  		 $this->var->add_def_cols('desc_categoria','VARCHAR');//14
		 $this->var->add_def_cols('fecha_sol','text');//15
  		 $this->var->add_def_cols('nro_documento','varchar');//16
		 $this->var->add_def_cols('nombre_cargo','varchar');//16
		 
		 $this->var->add_def_cols('gerente_financiero','text');
		 $this->var->add_def_cols('cargo_vo_bo','varchar');
		 $this->var->add_def_cols('firma_autorizador','text');
		 $this->var->add_def_cols('cargo_autorizador','varchar');
		 $this->var->add_def_cols('prioridad','integer');
		 
		 $this->var->add_def_cols('fecha_limite_rendicion','text'); 
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*if($_SESSION['ss_id_usuario']==131){
		echo $this->query; exit();}*/
		return $res;
	 }
	/**
	 * Nombre de la funciï¿½n:	ListarDetalleSolicitudViajes
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc_det
	 * Autor:				    ana maria villegas quispe
	 * Fecha de creaciï¿½n:		30/10/2009
	 */
	function ListarSolicitudViajesDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_SOLVIDE_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
		
		
		$this->var->add_def_cols('id_cuenta_doc','INTEGER');  
  		$this->var->add_def_cols('desc_ingas','text'); 
  		 $this->var->add_def_cols('tipo_destino','varchar'); 
  		$this->var->add_def_cols('importe_solicitado','NUMERIC'); 
  		$this->var->add_def_cols('importe_entregado','NUMERIC'); 
  		$this->var->add_def_cols('desc_presupuesto','TEXT'); 
  		$this->var->add_def_cols('observaciones','VARCHAR'); 
  		$this->var->add_def_cols('disponible','VARCHAR'); 
		
	
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	 }
	/**
	 * Nombre de la funciï¿½n:	ListarSolicitudFondosCab
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    avq
	 * Fecha de creaciï¿½n:		09/11/2009
	 */
	function ListarSolicitudFondosCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_SOFOAV_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
		

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		
		$this->var->add_def_cols('nro_sol',' varchar');
		$this->var->add_def_cols('fecha_solicitud',' TEXT');
		$this->var->add_def_cols('nombre_empleado',' TEXT');
		$this->var->add_def_cols('cargo','VARCHAR ');
		$this->var->add_def_cols('centro_responsabilidad',' VARCHAR ');
		$this->var->add_def_cols('motivo',' VARCHAR ');
		$this->var->add_def_cols('lugar',' VARCHAR ');
		$this->var->add_def_cols('fecha_ini',' TEXT');
		
		$this->var->add_def_cols('observaciones',' varchar');
		$this->var->add_def_cols('simbolo',' varchar');
		$this->var->add_def_cols('tipo_pago',' varchar');
		
		
		//añadido para firmas
		 $this->var->add_def_cols('person_nombre','TEXT'); //12
		  $this->var->add_def_cols('firma_autorizador','text');
		   $this->var->add_def_cols('gerente_financiero','text');
		    $this->var->add_def_cols('cargo_autorizador','varchar');
		     $this->var->add_def_cols('cargo_vo_bo','varchar');
  		
		 
		
		
		
		
		// $this->var->add_def_cols('prioridad','integer');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		/*if($_SESSION['ss_id_usuario']==131){
		echo $this->query; exit();}*/
		return $res;
	}
	
	
	/**
	 * Nombre de la funciï¿½n:	ListarReciboProvisionalFondosEfectivo
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    avq
	 * Fecha de creaciï¿½n:		09/11/2009
	 */
	function ListarReciboProvisionalFondosEfectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_REPRFA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha','TEXT'); 
 		$this->var->add_def_cols('hora',' TEXT'); 
  		$this->var->add_def_cols('caja','VARCHAR(100)'); 
  		$this->var->add_def_cols('cajero','TEXT'); 
  		$this->var->add_def_cols('nombre_moneda','VARCHAR(50)'); 
  		$this->var->add_def_cols('nombre_lugar','VARCHAR'); 
  		$this->var->add_def_cols('responsable','TEXT');
  		//$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('fk_id_cuenta_doc','integer');
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('id_subsistema','integer');
		$this->var->add_def_cols('monto_entregado','numeric');
		$this->var->add_def_cols('fecha_sol','text');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('aprobador','TEXT');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	    
		/*if($_SESSION['ss_id_usuario']==120){
		echo $this->query; exit();}*/
		return $res;
		
	}
	/**
	 * Nombre de la funciï¿½n:	ListarCabeceraRendicionPagoCaja
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    avq
	 * Fecha de creaciï¿½n:		11/12/2009
	 * Fecha de modificaciï¿½n:   14/12/2009
	 */
	function ListarCabeceraRendicionPagoCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_REPACA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha','TEXT'); 
 		$this->var->add_def_cols('hora',' TEXT'); 
  		$this->var->add_def_cols('caja','VARCHAR(100)'); 
  		$this->var->add_def_cols('cajero','TEXT'); 
  		$this->var->add_def_cols('nombre_moneda','VARCHAR(50)'); 
  		$this->var->add_def_cols('nombre_lugar','VARCHAR'); 
  		$this->var->add_def_cols('responsable','TEXT');
  		$this->var->add_def_cols('fk_id_cuenta_doc','integer');
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('id_subsistema','integer');
		$this->var->add_def_cols('monto_entregado','numeric');
		$this->var->add_def_cols('fecha_sol','text');
		$this->var->add_def_cols('retencion','TEXT'); 
  		$this->var->add_def_cols('importe_total','NUMERIC'); 
		$this->var->add_def_cols('importe_rendicion','NUMERIC'); 
		$this->var->add_def_cols('id_cuenta_doc_rendicion','INTEGER');
		$this->var->add_def_cols('importe_literal','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('aprobador','TEXT');		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	   // echo $this->query; exit();
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ListarReciboProvisionalDetalle
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc_det
	 * Autor:				    ana maria villegas quispe
	 * Fecha de creaciï¿½n:		30/10/2009
	 */
	function ListarReciboProvisionalDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_DERECPRO_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
		
		
		$this->var->add_def_cols('id_cuenta_doc','INTEGER');  
  		$this->var->add_def_cols('desc_ingas','text'); 
  		 
  		$this->var->add_def_cols('desc_presupuesto','TEXT'); 
  		$this->var->add_def_cols('observaciones','VARCHAR'); 
  		$this->var->add_def_cols('disponible','VARCHAR');
  		$this->var->add_def_cols('importe','NUMERIC');  
		
	
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	 }
	
	/**
	 * Nombre de la funciï¿½n:	ListarRendicionProvisionalFondosEfectivo
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    avq
	 * Fecha de creaciï¿½n:		24/11/2009
	 */
	function ListarRendicionProvisionalFondosEfectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_RENPRFE_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
 /*"id_cuenta_doc" INTEGER, 
  "desc_ingreso" TEXT, 
  "desc_presupuesto" TEXT, 
  "importe_total" NUMERIC(18,2)*/
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta_doc','INTEGER'); 
 		$this->var->add_def_cols('desc_ingreso',' TEXT'); 
  		$this->var->add_def_cols('desc_presupuesto','TEXT'); 
  		$this->var->add_def_cols('importe_total','NUMERIC'); 
  		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	    //echo $this->query; exit();
		return $res;
	}
	/**
	 * Nombre de la funciï¿½n:	ListarReciboCaja
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    avq
	 * Fecha de creaciï¿½n:		20/11/2009
	 */
	function ListarReciboCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_RECPAG_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta_doc','INTEGER'); 
 		$this->var->add_def_cols('desc_ingreso',' TEXT'); 
  		$this->var->add_def_cols('desc_presupuesto','TEXT'); 
  		$this->var->add_def_cols('importe_total','NUMERIC'); 
  		/*$this->var->add_def_cols('retencion','TEXT'); 
  		$this->var->add_def_cols('importe_rendicion','NUMERIC'); 
  		*/
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	  // echo $this->query; exit();
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ListarDetalleRendicionCaja
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    avq
	 * Fecha de creaciï¿½n:		15/11/2009
	 */
	function ListarDetalleRendicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_DERECADO_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta_doc_rendicion',' INTEGER'); 
 		$this->var->add_def_cols('fecha_documento',' TEXT');
  		$this->var->add_def_cols('desc_tipo_documento',' VARCHAR(150)'); 
  		$this->var->add_def_cols('documento','TEXT');
 		$this->var->add_def_cols('importe_total',' NUMERIC(18,2)'); 
 		$this->var->add_def_cols('retencion','TEXT'); 
  		$this->var->add_def_cols('importe_entregado','numeric'); 
 		$this->var->add_def_cols('importe_rendicion',' NUMERIC(18,2)');
  
  
    	//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	  //  echo $this->query; exit();
		return $res;
	}

/**
	 * Nombre de la funciï¿½n:	RegistrarDatosFinalizacion
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de inserciï¿½n de la tabla tts_cuenta_doc
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		14/11/2009
	 */
	function RegistrarDatosFinalizacion($id_cuenta_doc,$tipo_pago_fin,$id_cuenta_bancaria_fin,$id_caja_fin,$id_cajero_fin,$nro_deposito)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_iud';
		$this->codigo_procedimiento = "'TS_RECUDE_FIN'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cuenta_doc");
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
		$this->var->add_param("NULL");//id_caja
		$this->var->add_param("NULL");//id_cajero
		$this->var->add_param("NULL");//id_cuenta_bancaria
		$this->var->add_param("'$tipo_pago_fin'");
		$this->var->add_param("$id_cuenta_bancaria_fin");
		$this->var->add_param("$id_caja_fin");
		$this->var->add_param("$id_cajero_fin");
		$this->var->add_param("'$nro_deposito'");
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("NULL");//importe_entregado
		$this->var->add_param("NULL");//id_autorizacion
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//tipo_rendicion

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
/**
	 * Nombre de la funciï¿½n:	FinalizarRendiciones
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tts_cuenta_doc
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		14/11/2009
	 */
	function FinalizarCuentaDoc($id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_iud';
		$this->codigo_procedimiento = "'TS_CUEDOC_FIN'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc);
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
		$this->var->add_param("NULL");//fa_solicitud
		$this->var->add_param("NULL");//id_caja
		$this->var->add_param("NULL");//id_cajero
		$this->var->add_param("NULL");//id_cuenta_bancaria
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("NULL");//importe_entregado
		$this->var->add_param("NULL");//id_autorizacion
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//tipo_rendicion

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarDetalleRendicionDocumento
	 * Propósito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    avq
	 * Fecha de creación:		05/03/2010
	 */
	function ListarDetalleRendicionDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		$this->codigo_procedimiento = "'TS_DOCREN_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		
		$this->var->add_def_cols('id_caja',' INTEGER'); 
		$this->var->add_def_cols('id_cuenta_doc',' INTEGER'); 
 		$this->var->add_def_cols('id_cuenta_doc_rendicion','INTEGER');
  		$this->var->add_def_cols('id_documento','INTEGER'); 
  		$this->var->add_def_cols('nro_documento','VARCHAR');
 		$this->var->add_def_cols('razon_social','varchar'); 
 		$this->var->add_def_cols('motivo','varchar'); 
 		$this->var->add_def_cols('nro_nit','VARCHAR');
 		$this->var->add_def_cols('factura','bigint'); 
 		$this->var->add_def_cols('importe_rendicion','NUMERIC');
  		$this->var->add_def_cols('importe_total','numeric'); 
  		$this->var->add_def_cols('fk_id_cuenta_doc','integer'); 
  		$this->var->add_def_cols('id_subsistema','integer'); 
  		$this->var->add_def_cols('fecha','text'); 
  		
 		
    	//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	   // echo $this->query; exit();
		return $res;
	}
	
		/**
	 * Nombre de la función:	ContarDetalleRendicionDocumento
	 * Propósito:				Contar los registros de tts_cuenta_doc
	 * Autor:				    avq
	 * Fecha de creación:		08/03/2010
	 */
	function ContarDetalleRendicionDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
		
		$this->codigo_procedimiento = "'TS_DOCREN_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("''");
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;

		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;
*/
		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}

	
	/**
	 * Nombre de la función:	correccion de recibos
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tts_cuenta_doc
	 * Autor:				    avq
	 * Fecha de creaciï¿½n:		11/03/2010
	 */
	function CorregirRecibo($id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_iud';
		$this->codigo_procedimiento = "'TS_CORREC_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc);
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
		$this->var->add_param("NULL");//fa_solicitud
		$this->var->add_param("NULL");//id_caja
		$this->var->add_param("NULL");//id_cajero
		$this->var->add_param("NULL");//id_cuenta_bancaria
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("NULL");//importe_entregado
		$this->var->add_param("NULL");//id_autorizacion
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//tipo_rendicion

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la funciï¿½n:	ListarSolicitudAutorizar
	 * Propï¿½sito:				Desplegar los registros de tts_cuenta_doc que ya vencieron los dias de rendición
	 * Autor:				    AVQ
	 * Fecha de creaciï¿½n:		2013-09-10 11:50:07
	 */
	function ListarSolicitudAutorizar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_cuenta_doc,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_doc_sel';
	
		$this->codigo_procedimiento = "'TS_DOCAUTVIFAEF_SEL'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("'$estado'");
	
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta_doc','INTEGER');
		$this->var->add_def_cols('id_presupuesto','INTEGER');
		$this->var->add_def_cols('desc_presupuesto','TEXT');
		$this->var->add_def_cols('id_empleado','INTEGER');
		$this->var->add_def_cols('desc_empleado','TEXT');
		$this->var->add_def_cols('desc_categoria','VARCHAR');
		$this->var->add_def_cols('fecha_ini','DATE');
		$this->var->add_def_cols('fecha_fin','DATE');
		$this->var->add_def_cols('tipo_pago','VARCHAR(15)');
		$this->var->add_def_cols('tipo_contrato','VARCHAR(15)');
		$this->var->add_def_cols('id_usuario_reg','INTEGER');
		$this->var->add_def_cols('resp_registro','TEXT');
		$this->var->add_def_cols('estado','VARCHAR(25)');
		$this->var->add_def_cols('nro_documento','VARCHAR(40)');
		$this->var->add_def_cols('fecha_reg','DATE');
		$this->var->add_def_cols('motivo','VARCHAR(500)');
		$this->var->add_def_cols('recorrido','VARCHAR(300)');
		$this->var->add_def_cols('observaciones','VARCHAR(500)');
		$this->var->add_def_cols('id_depto','INTEGER');
		$this->var->add_def_cols('desc_depto','VARCHAR(20)');
		$this->var->add_def_cols('id_moneda','INTEGER');
		$this->var->add_def_cols('desc_moneda','VARCHAR(50)');
		$this->var->add_def_cols('fecha_sol','DATE');
		$this->var->add_def_cols('fa_solicitud','VARCHAR(2)');
		$this->var->add_def_cols('id_caja','INTEGER');
		$this->var->add_def_cols('desc_caja','VARCHAR');
		$this->var->add_def_cols('id_cajero','INTEGER');
		$this->var->add_def_cols('desc_cajero','TEXT');
		$this->var->add_def_cols('importe','NUMERIC(18,2)');
		$this->var->add_def_cols('fk_id_cuenta_doc','INTEGER');
		$this->var->add_def_cols('tipo_cuenta_doc','VARCHAR(25)');
		$this->var->add_def_cols('id_parametro','INTEGER');
		$this->var->add_def_cols('desc_parametro','NUMERIC');
		$this->var->add_def_cols('id_autorizacion','INTEGER');
		$this->var->add_def_cols('desc_autorizacion','TEXT');
		$this->var->add_def_cols('nro_dias_para_rendir','INTEGER');
		$this->var->add_def_cols('fecha_aut_rendicion','TIMESTAMP WITHOUT TIME ZONE');
		$this->var->add_def_cols('cant_rend_registradas','BIGINT');
		$this->var->add_def_cols('cant_rend_finalizadas','BIGINT');
		$this->var->add_def_cols('cant_rend_contabilizadas','BIGINT');
		/*
		
		$this->var->add_def_cols('id_cuenta_doc','int4');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_categoria','int4');
		$this->var->add_def_cols('desc_categoria','varchar');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('tipo_contrato','varchar');
		$this->var->add_def_cols('id_usuario_rendicion','int4');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('recorrido','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('fecha_sol','date');
		$this->var->add_def_cols('fa_solicitud','varchar');
		$this->var->add_def_cols('id_caja','int4');
		$this->var->add_def_cols('desc_caja','varchar');
		$this->var->add_def_cols('id_cajero','int4');
		$this->var->add_def_cols('desc_cajero','varchar');
	
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('resp_registro','text');
		if($vista=='solicitud_efectivo'){
				
				
			$this->var->add_def_cols('importe_entregado','numeric');
			$this->var->add_def_cols('id_proveedor','integer');
			$this->var->add_def_cols('desc_proveedor','text');
			$this->var->add_def_cols('id_subsistema','integer');
			$this->var->add_def_cols('tipo_recibo','varchar');
			$this->var->add_def_cols('fk_id_cuenta_doc','integer');
			$this->var->add_def_cols('id_autorizacion','int4');
			$this->var->add_def_cols('desc_autorizacion','text');
			$this->var->add_def_cols('nro_dias_para_rendir','integer');
			$this->var->add_def_cols('fecha_aut_rendicion','timestamp');
			$this->var->add_def_cols('cant_rend_registradas','bigint');
			$this->var->add_def_cols('cant_rend_finalizadas','bigint');
			$this->var->add_def_cols('cant_rend_contabilizadas','bigint');
	
		} else{
			$this->var->add_def_cols('tipo_pago_fin','varchar');
			$this->var->add_def_cols('id_cuenta_bancaria','integer');
			$this->var->add_def_cols('id_cuenta_bancaria_fin','integer');
			$this->var->add_def_cols('id_caja_fin','integer');
			$this->var->add_def_cols('id_cajero_fin','integer');
			$this->var->add_def_cols('nro_deposito','varchar');
			$this->var->add_def_cols('desc_cuenta_bancaria_fin','varchar');
			$this->var->add_def_cols('desc_caja_fin','varchar');
			$this->var->add_def_cols('desc_cajero_fin','varchar');
				
				
			$this->var->add_def_cols('id_autorizacion','int4');
			$this->var->add_def_cols('desc_autorizacion','text');
			$this->var->add_def_cols('nombre_cheque','varchar');
			$this->var->add_def_cols('tipo_cuenta_doc','varchar');
			$this->var->add_def_cols('fk_id_cuenta_doc','integer');
			$this->var->add_def_cols('id_usuario_reg','integer');
			$this->var->add_def_cols('id_comprobante','integer');
			$this->var->add_def_cols('nro_dias_para_rendir','integer');
			$this->var->add_def_cols('fecha_aut_rendicion','timestamp');
			$this->var->add_def_cols('cant_rend_registradas','bigint');
			$this->var->add_def_cols('cant_rend_finalizadas','bigint');
			$this->var->add_def_cols('cant_rend_contabilizadas','bigint');
				
			$this->var->add_def_cols('codigo_caja','varchar');
				
			$this->var->add_def_cols('saldo_solicitante','numeric');
				
		}   
	    */   
		//Ejecuta la funciï¿½n de consulta  
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	
		//if($_SESSION["ss_id_usuario"])
		/*echo $this->query;
			exit;*/
			/*if ($_SESSION['ss_id_usuario']==131){
			echo $this->query;
		exit;   
		}*/
		return $res;
	}	
	
	/**
	 * Nombre de la funciï¿½n:	ValidarSolicitudViaticos2
	 * Propï¿½sito:				Permite ejecutar la validaciï¿½n del lado del servidor de la tabla tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2009-10-27 11:50:07
	 */
	function ValidarSolicitudViaticos2($operacion_sql,$id_cuenta_doc,$id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validaciï¿½n por el tipo de operaciï¿½n
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			
			if($operacion_sql == 'update')
			{
				//Validar id_cuenta_doc - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cuenta_doc");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_doc", $id_cuenta_doc))
				{
					$this->salida = $valid->salida;
					return false;
				}
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

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_categoria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria", $id_categoria))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_ini - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ini");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ini", $fecha_ini))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_fin - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_fin");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_fin", $fecha_fin))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_pago - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_pago");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_pago", $tipo_pago))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_contrato - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_contrato");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_contrato", $tipo_contrato))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_usuario_rendicion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario_rendicion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario_rendicion", $id_usuario_rendicion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar motivo - tipo varchar
		/*	$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("motivo");
			$tipo_dato->set_MaxLength(500);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "motivo", $motivo))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar recorrido - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("recorrido");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "recorrido", $recorrido))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(500);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_depto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validaciï¿½n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cuenta_doc - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_doc");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_doc", $id_cuenta_doc))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validaciï¿½n exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
}?>