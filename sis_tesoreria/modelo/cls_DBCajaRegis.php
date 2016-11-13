<?php
/**
 * Nombre de la clase:	cls_DBCajaRegis.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_caja_regis
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2008-10-21 15:53:14
 */

 
class cls_DBCajaRegis
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
	 * Nombre de la funci�n:	ListarReposicionCaja
	 * Prop�sito:				Desplegar los registros de tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 15:53:14
	 */
	function ListarReposicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_REPCAJ_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_caja_regis','int4');
		$this->var->add_def_cols('id_caja','int4');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('tipo_caja','numeric');
		$this->var->add_def_cols('desc_caja','text');
		$this->var->add_def_cols('id_cajero','int4');
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('tipo_caja_caja','numeric');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('codigo_empleado_empleado','varchar');
		$this->var->add_def_cols('estado_cajero_cajero','numeric');
		$this->var->add_def_cols('desc_cajero','text');
		$this->var->add_def_cols('fecha_regis','date');
		$this->var->add_def_cols('importe_regis','numeric');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('tipo_regis','numeric');
		$this->var->add_def_cols('estado_regis','integer');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('id_cheque','int4');
		$this->var->add_def_cols('nro_documento','int4');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('codigo_repo','varchar');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarReposicionCaja
	 * Prop�sito:				Contar los registros de tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 15:53:14
	 */
	function ContarReposicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_REPCAJ_COUNT'";

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
	
	/**
	 * Nombre de la funci�n:	InsertarReposicionCaja
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 15:53:14
	 */
	function InsertarReposicionCaja($id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis, $nro_documento ,$fecha_ini,$fecha_fin,$codigo_repo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_reposicion_iud';
			$this->codigo_procedimiento = "'TS_REPCAJ_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_caja);
		$this->var->add_param($id_cajero);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_regis'");
		$this->var->add_param($importe_regis);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//$id_unidad_organizacional
		$this->var->add_param("NULL");//$tipo_documento
		$this->var->add_param("NULL");//$fecha_documento
		$this->var->add_param("NULL");//$razon_social
		$this->var->add_param("NULL");//$nro_nit
		$this->var->add_param("NULL");//$nro_autorizacion
		$this->var->add_param("NULL");//$codigo_control
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("NULL");//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entregado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("$nro_documento");//$nro_documento
		$this->var->add_param("'$fecha_ini'");//$fecha_ini
		$this->var->add_param("'$fecha_fin'");//$fecha_fin
		$this->var->add_param("'$codigo_repo'");//codigo_repo
		
		
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarReposicionCaja
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 15:53:14
	 */
	function ModificarReposicionCaja($id_caja_regis,$id_caja,$id_cajero,$tipo_regis,$fecha_regis,$importe_regis,$id_cheque,$estado_regis ,$nro_documento ,$fecha_ini,$fecha_fin,$codigo_repo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_reposicion_iud';
		$this->codigo_procedimiento = "'TS_REPCAJ_UPD'";
 //echo $id_caja;exit;
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja_regis);
		$this->var->add_param($id_caja);
		$this->var->add_param($id_cajero);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($tipo_regis);
		$this->var->add_param("'$fecha_regis'");
		$this->var->add_param($importe_regis);
		$this->var->add_param("NULL");//id_moneda
		$this->var->add_param("NULL");//id_documento
		$this->var->add_param("NULL");//id_comprobate
		$this->var->add_param($id_cheque);//id_cheque
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//$id_unidad_organizacional
		$this->var->add_param("NULL");//$tipo_documento
		$this->var->add_param("NULL");//$fecha_documento
		$this->var->add_param("NULL");//$razon_social
		$this->var->add_param("NULL");//$nro_nit
		$this->var->add_param("NULL");//$nro_autorizacion
		$this->var->add_param("NULL");//$codigo_control
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param($estado_regis);//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("$nro_documento");//$nro_documento
		$this->var->add_param("'$fecha_ini'");//$fecha_ini
		$this->var->add_param("'$fecha_fin'");//$fecha_fin
		$this->var->add_param("'$codigo_repo'");//codigo_repo
		
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit();
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarReposicionCaja
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 15:53:14
	 */
	function EliminarReposicionCaja($id_caja_regis)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_reposicion_iud';
		$this->codigo_procedimiento = "'TS_REPCAJ_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja_regis);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_moneda
		$this->var->add_param("NULL");//id_documento
		$this->var->add_param("NULL");//id_comprobate
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//$id_unidad_organizacional
		$this->var->add_param("NULL");//$tipo_documento
		$this->var->add_param("NULL");//$fecha_documento
		$this->var->add_param("NULL");//$razon_social
		$this->var->add_param("NULL");//$nro_nit
		$this->var->add_param("NULL");//$nro_autorizacion
		$this->var->add_param("NULL");//$codigo_control
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//codigo_repo
		
		


		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarReposicionCaja
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 15:53:14
	 */
	function ValidarReposicionCaja($operacion_sql,$id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis)
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
				//Validar id_caja_regis - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_caja_regis");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja_regis", $id_caja_regis))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_caja - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_caja");
			$tipo_dato->set_MaxLength(10);
			//$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja", $id_caja))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar id_cajero - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cajero");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cajero", $id_cajero))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			

			/*//Validar importe_regis - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_regis");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_regis", $importe_regis))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_caja_regis - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_caja_regis");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja_regis", $id_caja_regis))
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
	/**
	 * Nombre de la funci�n:	ListarValesCaja
	 * Prop�sito:				Desplegar los registros de tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-22 10:36:48
	 */
	function ListarValesCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_VALCAJ_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_caja_regis','int4');
		$this->var->add_def_cols('id_caja','int4');
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('tipo_caja','numeric');
		$this->var->add_def_cols('desc_caja','varchar');
		$this->var->add_def_cols('id_cajero','int4');
		$this->var->add_def_cols('apellido_paterno_cajero','varchar');
		$this->var->add_def_cols('apellido_materno_cajero','varchar');
		$this->var->add_def_cols('nombre_cajero','varchar');
		$this->var->add_def_cols('codigo_empleado_cajero','varchar');
		$this->var->add_def_cols('estado_cajero_cajero','numeric');
		$this->var->add_def_cols('desc_cajero','text');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('codigo_empleado_empleado','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('importe_regis','numeric');
		$this->var->add_def_cols('fecha_regis','date');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('estado_regis','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('concepto_regis','text');
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('nro_vale','integer');
		$this->var->add_def_cols('id_devengado','integer');
		$this->var->add_def_cols('id_proveedor','integer');
		$this->var->add_def_cols('tipo_vale','text');
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function VerificarRendicionVale($id_caja_regis)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_VERVAL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $id_caja_regis;//para mandar el id_caja_regis como entero
		$this->var->puntero =0;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "''";
		
		$id_financiador='';
		$id_regional='';
		$id_programa='';
		$id_proyecto='';
		$id_actividad='';
		
		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('resultado','int4');
		$this->var->add_def_cols('monto','numeric');
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarValesCaja
	 * Prop�sito:				Contar los registros de tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-22 10:36:48
	 */
	function ContarValesCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_VALCAJ_COUNT'";

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
	
	/**
	 * Nombre de la funci�n:	ListarReposicionCaja
	 * Prop�sito:				Desplegar los registros de tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 15:53:14
	 */
	function ListarReporteValeCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_REVACA_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('hora','text');
		$this->var->add_def_cols('numero','text');
		$this->var->add_def_cols('caja','varchar');
		$this->var->add_def_cols('cajero','text');
		$this->var->add_def_cols('unidad','varchar');
		$this->var->add_def_cols('empleado','text');
		$this->var->add_def_cols('importe_entregado','numeric');
		$this->var->add_def_cols('concepto','text');
		$this->var->add_def_cols('importe_literal','varchar');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('lugar_sus','varchar');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('fecha_regis','text');
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
	    
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit();
		
		return $res;
	}
	
	
	
	function ListarReporteRendicionEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_RERENDIEP_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		$this->var->add_def_cols('financiador','varchar');
		$this->var->add_def_cols('regional','varchar');
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('actividad','varchar');
		$this->var->add_def_cols('unidad','varchar');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		
		return $res;
	}
	
	
	function ListarReporteRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_RERENDI_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nro','bigint');
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('total','numeric');
		$this->var->add_def_cols('retencion','numeric');
		$this->var->add_def_cols('cargo','varchar');
		$this->var->add_def_cols('descargo','numeric');
		
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		
		return $res;
	}
	
	function ListarReporteRendicionServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_RERENDISER_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nro','bigint');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('total','numeric');
		$this->var->add_def_cols('retencion','numeric');
		$this->var->add_def_cols('importe','numeric');
		
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		
		return $res;
	}
	
	
	/**
	 * Nombre de la funci�n:	InsertarValesCaja
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-22 10:36:48
	 */
	function InsertarValesCaja($id_caja_regis,$id_caja,$id_cajero,$id_empleado,$importe_regis,$fecha_regis,$concepto_regis,$id_proveedor)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_iud';
		$this->codigo_procedimiento = "'TS_VALCAJ_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_caja);
		$this->var->add_param($id_cajero);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_regis'");
		$this->var->add_param($importe_regis);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado);
		
		$this->var->add_param("NULL");//$id_unidad_organizacional
		$this->var->add_param("NULL");//$tipo_documento
		$this->var->add_param("NULL");//$fecha_documento
		$this->var->add_param("NULL");//$nro_documento
		$this->var->add_param("'$concepto_regis'");//$razon_social
		$this->var->add_param("NULL");//$nro_nit
		$this->var->add_param("NULL");//$nro_autorizacion
		$this->var->add_param("NULL");//$codigo_control
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis		
		$this->var->add_param(12);//fk_id_subsistema     12=TESORO
		$this->var->add_param("NULL");//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("$id_proveedor");//id_proveedor
		
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarValesCaja
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-22 10:36:48
	 */
	function ModificarValesCaja($id_caja_regis,$id_caja,$id_cajero,$id_empleado,$importe_regis,$fecha_regis,$estado_regis,$importe_entregado,$concepto_regis,$id_proveedor)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_iud';
		$this->codigo_procedimiento = "'TS_VALCAJ_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja_regis);
		$this->var->add_param($id_caja);
		$this->var->add_param($id_cajero);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_regis'");
		$this->var->add_param($importe_regis);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado);
		
		$this->var->add_param("NULL");//$id_unidad_organizacional
		$this->var->add_param("NULL");//$tipo_documento
		$this->var->add_param("NULL");//$fecha_documento
		$this->var->add_param("NULL");//$nro_documento
		$this->var->add_param("'$concepto_regis'");//$razon_social
		$this->var->add_param("NULL");//$nro_nit
		$this->var->add_param("NULL");//$nro_autorizacion
		$this->var->add_param("NULL");//$codigo_control
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("$estado_regis");//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("$importe_entregado");//importe_entregado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("$id_proveedor");//id_proveedor
		
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarValesCaja
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-22 10:36:48
	 */
	function EliminarValesCaja($id_caja_regis)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_iud';
		$this->codigo_procedimiento = "'TS_VALCAJ_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja_regis);
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
		
		
		$this->var->add_param("NULL");//$id_unidad_organizacional
		$this->var->add_param("NULL");//$tipo_documento
		$this->var->add_param("NULL");//$fecha_documento
		$this->var->add_param("NULL");//$nro_documento
		$this->var->add_param("NULL");//$razon_social
		$this->var->add_param("NULL");//$nro_nit
		$this->var->add_param("NULL");//$nro_autorizacion
		$this->var->add_param("NULL");//$codigo_control
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("NULL");//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarValesCaja
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-22 10:36:48
	 */
	function ValidarValesCaja($operacion_sql,$id_caja_regis,$id_caja,$id_cajero,$id_empleado,$importe_regis,$fecha_regis)
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
				//Validar id_caja_regis - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_caja_regis");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja_regis", $id_caja_regis))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_caja - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_caja");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja", $id_caja))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cajero - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cajero");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cajero", $id_cajero))
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

			//Validar importe_regis - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_regis");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_regis", $importe_regis))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_caja_regis - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_caja_regis");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja_regis", $id_caja_regis))
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
	
	/**
	 * Nombre de la funci�n:	ListarRendiciones
	 * Prop�sito:				Desplegar los registros de tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function ListarRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_RENDICI_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_caja_regis','int4');
		$this->var->add_def_cols('id_cajero','int4');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('codigo_empleado_empleado','varchar');
		$this->var->add_def_cols('desc_cajero','text');
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','int4');
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('id_concepto_ingas','int4');
		$this->var->add_def_cols('desc_partida_partida','varchar');
		$this->var->add_def_cols('desc_ingas_concepto_ingas','varchar');
		$this->var->add_def_cols('desc_concepto_ingas','text');
		$this->var->add_def_cols('fecha_regis','date');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('tipo_documento','numeric');
		$this->var->add_def_cols('desc_documento','varchar');
		$this->var->add_def_cols('fecha_documento','date');
		$this->var->add_def_cols('nro_documento','bigint');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_nit','varchar');
		$this->var->add_def_cols('nro_autorizacion','varchar');
		$this->var->add_def_cols('codigo_control','varchar');
		$this->var->add_def_cols('desc_epe','text');
		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('concepto_regis','text');
		$this->var->add_def_cols('estado_regis','integer');
	  
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ListarRendiciones
	 * Prop�sito:				Desplegar los registros de tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function ListarRendicionesPendientes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_RENCORR_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_documento','bigint');
		$this->var->add_def_cols('nro_nit','varchar');
		$this->var->add_def_cols('nro_autorizacion','varchar');
		$this->var->add_def_cols('codigo_control','varchar');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('tipo_documento','varchar');
		$this->var->add_def_cols('fecha_documento','date');
		$this->var->add_def_cols('tipo','numeric');
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarRendiciones
	 * Prop�sito:				Contar los registros de tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function ContarRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_RENDICI_COUNT'";

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
	
	/**
	 * Nombre de la funci�n:	ContarRendiciones
	 * Prop�sito:				Contar los registros de tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function ContarRendicionesPendientes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_RENCORR_COUNT'";

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
	
	/**
	 * Nombre de la funci�n:	InsertarRendiciones
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function InsertarRendiciones($id_caja_regis,$id_cajero,$id_presupuesto,$id_unidad_organizacional,$id_concepto_ingas,$importe_regis,$tipo_documento,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fk_id_caja_regis,$concepto_regis)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_iud';
		$this->codigo_procedimiento = "'TS_RENDICI_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_cajero);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($importe_regis);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$concepto_regis'");
		$this->var->add_param("NULL");
		
		$this->var->add_param($id_unidad_organizacional);//$id_unidad_organizacional
		$this->var->add_param($tipo_documento);//$tipo_documento
		$this->var->add_param("'$fecha_documento'");//$fecha_documento
		$this->var->add_param($nro_documento);//$nro_documento
		$this->var->add_param("'$razon_social'");//$razon_social
		$this->var->add_param("'$nro_nit'");//$nro_nit
		$this->var->add_param("'$nro_autorizacion'");//$nro_autorizacion
		$this->var->add_param("'$codigo_control'");//$codigo_control
		
		
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");
		$this->var->add_param($fk_id_caja_regis);//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("NULL");//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarRendiciones
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function ModificarRendiciones($id_caja_regis,$id_cajero,$id_presupuesto,$id_unidad_organizacional,$id_concepto_ingas,$importe_regis,$tipo_documento,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$concepto_regis)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_iud';
		$this->codigo_procedimiento = "'TS_RENDICI_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja_regis);
		$this->var->add_param("NULL");
		$this->var->add_param($id_cajero);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($importe_regis);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$concepto_regis'");
		$this->var->add_param("NULL");
		
		$this->var->add_param($id_unidad_organizacional);//$id_unidad_organizacional
		$this->var->add_param($tipo_documento);//$tipo_documento
		$this->var->add_param("'$fecha_documento'");//$fecha_documento
		$this->var->add_param($nro_documento);//$nro_documento
		$this->var->add_param("'$razon_social'");//$razon_social
		$this->var->add_param("'$nro_nit'");//$nro_nit
		$this->var->add_param("'$nro_autorizacion'");//$nro_autorizacion
		$this->var->add_param("'$codigo_control'");//$codigo_control
		
		
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("NULL");//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la funci�n:	ModificarRendiciones
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function ModificarRendicionesFin($id_caja_regis,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$concepto_regis)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_iud';
		$this->codigo_procedimiento = "'TS_RENFIN_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja_regis);
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
		$this->var->add_param("'$concepto_regis'");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//$id_unidad_organizacional
		$this->var->add_param("NULL");//$tipo_documento
		$this->var->add_param("'$fecha_documento'");//$fecha_documento
		$this->var->add_param($nro_documento);//$nro_documento
		$this->var->add_param("'$razon_social'");//$razon_social
		$this->var->add_param("'$nro_nit'");//$nro_nit
		$this->var->add_param("'$nro_autorizacion'");//$nro_autorizacion
		$this->var->add_param("'$codigo_control'");//$codigo_control
		
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("NULL");//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la funci�n:	ModificarRendiciones
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function ModificarRendicionesPendientes($fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_iud';
		$this->codigo_procedimiento = "'TS_RENCORR_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
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
		
		$this->var->add_param("NULL");//$id_unidad_organizacional
		$this->var->add_param("NULL");//$tipo_documento
		$this->var->add_param("'$fecha_documento'");//$fecha_documento
		$this->var->add_param($nro_documento);//$nro_documento
		$this->var->add_param("'$razon_social'");//$razon_social
		$this->var->add_param("'$nro_nit'");//$nro_nit
		$this->var->add_param("'$nro_autorizacion'");//$nro_autorizacion
		$this->var->add_param("'$codigo_control'");//$codigo_control
		
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("NULL");//estado_regis
		$this->var->add_param("$id_cotizacion");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarRendiciones
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function EliminarRendiciones($id_caja_regis)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_iud';
		$this->codigo_procedimiento = "'TS_RENDICI_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja_regis);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("NULL");//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarRendiciones
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function MarcarRendiciones($id_caja_regis)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_iud';
		$this->codigo_procedimiento = "'TS_RENMARC_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja_regis);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fk_id_caja_regis
		$this->var->add_param("NULL");//fk_id_subsistema
		$this->var->add_param("NULL");//estado_regis
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//importe_entegado
		$this->var->add_param("NULL");//id_devengado
		$this->var->add_param("NULL");//id_proveedor
		
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarRendiciones
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tts_caja_regis
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-11-06 19:01:07
	 */
	function ValidarRendiciones($operacion_sql,$id_caja_regis,$id_cajero,$id_presupuesto,$id_unidad_organizacional,$id_concepto_ingas,$importe_regis,$tipo_documento,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
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
				//Validar id_caja_regis - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_caja_regis");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja_regis", $id_caja_regis))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_cajero - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cajero");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cajero", $id_cajero))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_financiador - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_presupuesto");
			$tipo_dato->set_MaxLength(15);
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_presupuesto", $id_presupuesto))
			{
				$this->salida = $valid->salida;
				return false;
			}
	//Validar id_financiador - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_financiador");
			$tipo_dato->set_MaxLength(15);
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_financiador", $id_financiador))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_regional - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_regional");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_regional", $id_regional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_programa - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_programa");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_programa", $id_programa))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proyecto - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proyecto");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proyecto", $id_proyecto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_actividad - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_actividad");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_actividad", $id_actividad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_organizacional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
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

			//Validar importe_regis - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_regis");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_regis", $importe_regis))
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
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_caja_regis - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_caja_regis");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja_regis", $id_caja_regis))
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
	
	/**
	 * Nombre de la funci�n:	ListarReporteRendicionHeader
	 * Prop�sito:				Desplegar los registros de tts_caja_regis para reposiciones de caja regis
	 * Autor:				    Jos� Abraham Mita Huanca
	 * Fecha de creaci�n:		2009-04-08 15:53:14
	 */
	function ListarReporteRendicionHeader($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_RENHEA_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_regis','date');
		$this->var->add_def_cols('importe_regis','numeric');
		$this->var->add_def_cols('tipo_caja','numeric');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre','varchar');		
		$this->var->add_def_cols('fecha_actual','date');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
	    
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit();
		//echo $this->query;
		//exit;
		return $res;
	}
/**
	 * Nombre de la funci�n:	ListarReporteRendicionReposicion
	 * Prop�sito:				Desplegar los registros de tts_caja_regis para reposiciones de caja regis
	 * Autor:				    Jos� Abraham Mita Huanca
	 * Fecha de creaci�n:		2009-04-13 15:53:14
	 */
	function ListarReporteRendicionReposicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_RENREP_SEL'";

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

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nextval','bigint');
		$this->var->add_def_cols('fecha_documento','date');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('cargo','varchar');
		$this->var->add_def_cols('importe_regis','numeric');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
	    
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	   //echo $this->query; exit();
		
		return $res;
	}	
	
}?>