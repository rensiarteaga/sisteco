<?php
/**
 * Nombre de la clase:	cls_DBCaja.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_caja
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2008-10-21 09:30:43
 */

 
class cls_DBCaja
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
	 * Nombre de la funci�n:	ListarCaja
	 * Prop�sito:				Desplegar los registros de tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:30:43
	 */
	function ListarCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_sel';
		$this->codigo_procedimiento = "'TS_CAJA_SEL'";

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
		$this->var->add_def_cols('id_caja','int4');
		$this->var->add_def_cols('tipo_caja','numeric');
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('id_dosifica','int4');
		$this->var->add_def_cols('desc_dosifica','varchar');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_cierre','date');
		$this->var->add_def_cols('sw_factura','numeric');
		$this->var->add_def_cols('importe_maximo','numeric');
		$this->var->add_def_cols('porcentaje_compra','numeric');
		$this->var->add_def_cols('porcentaje_rinde','numeric');
		$this->var->add_def_cols('nro_recibo','int4');
		$this->var->add_def_cols('estado_caja','numeric');
		$this->var->add_def_cols('id_partida_cuenta','integer');
		$this->var->add_def_cols('desc_par_cta','text');
		$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('desc_auxiliar','text');
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		$this->var->add_def_cols('desc_epe','text');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('codigo_caja','varchar');
		$this->var->add_def_cols('desc_caja','text');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('desc_cajero','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//if($_SESSION["ss_id_usuario"]==120){echo $this->query; exit;}
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarCaja
	 * Prop�sito:				Contar los registros de tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:30:43
	 */
	function ContarCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_sel';
		$this->codigo_procedimiento = "'TS_CAJA_COUNT'";

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
	 * Nombre de la funci�n:	InsertarCaja
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:30:43
	 */
	function InsertarCaja($id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti,$codigo_caja,$id_depto,$id_responsable_caja)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_iud';
		$this->codigo_procedimiento = "'TS_CAJA_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($tipo_caja);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_dosifica);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_cierre'");
		$this->var->add_param($sw_factura);
		$this->var->add_param($importe_maximo);
		$this->var->add_param($porcentaje_compra);
		$this->var->add_param($porcentaje_rinde);
		$this->var->add_param($nro_recibo);
		$this->var->add_param($estado_caja);
		$this->var->add_param("NULL");//ts_nro_vale
		$this->var->add_param("NULL");//ts_nro_rinde
		$this->var->add_param($id_partida_cuenta);//ts_nro_rinde
		$this->var->add_param($id_auxiliar);//ts_nro_rinde
		$this->var->add_param($id_fina_regi_prog_proy_acti);//ts_nro_rinde
		$this->var->add_param("'$codigo_caja'");//ts_codigo_Caja
		$this->var->add_param($id_depto);//ts_id_depto
		$this->var->add_param($id_responsable_caja);//ts_id_usuario

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarCaja
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:30:43
	 */
	function ModificarCaja($id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti,$codigo_caja,$id_depto,$id_responsable_caja)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_iud';
		$this->codigo_procedimiento = "'TS_CAJA_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja);
		$this->var->add_param($tipo_caja);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_dosifica);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_cierre'");
		$this->var->add_param($sw_factura);
		$this->var->add_param($importe_maximo);
		$this->var->add_param($porcentaje_compra);
		$this->var->add_param($porcentaje_rinde);
		$this->var->add_param($nro_recibo);
		$this->var->add_param($estado_caja);
		$this->var->add_param("NULL");//ts_nro_vale
		$this->var->add_param("NULL");//ts_nro_rinde
		$this->var->add_param($id_partida_cuenta);//ts_nro_rinde
		$this->var->add_param($id_auxiliar);//ts_nro_rinde
		$this->var->add_param($id_fina_regi_prog_proy_acti);//ts_nro_rinde
		$this->var->add_param("'$codigo_caja'");//ts_codigo_Caja
		$this->var->add_param($id_depto);//ts_id_depto
		$this->var->add_param($id_responsable_caja);//ts_id_usuario
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarCaja
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:30:43
	 */
	function EliminarCaja($id_caja)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_iud';
		$this->codigo_procedimiento = "'TS_CAJA_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_caja);
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
		$this->var->add_param("NULL");//ts_nro_vale
		$this->var->add_param("NULL");//ts_nro_rinde
		$this->var->add_param("NULL");//ts_nro_rinde
		$this->var->add_param("NULL");//ts_nro_rinde
		$this->var->add_param("NULL");//ts_nro_rinde
		$this->var->add_param("NULL");//ts_codigo_Caja
		$this->var->add_param("NULL");//ts_id_depto
		$this->var->add_param("NULL");//ts_id_usuario

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarCaja
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:30:43
	 */
	function ValidarCaja($operacion_sql,$id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti)
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
				//Validar id_caja - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_caja");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja", $id_caja))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar tipo_caja - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_caja");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_caja", $tipo_caja))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_organizacional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
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

			//Validar id_dosifica - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_dosifica");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_dosifica", $id_dosifica))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_inicio - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_inicio");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_inicio", $fecha_inicio))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_cierre - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_cierre");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_cierre", $fecha_cierre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar sw_factura - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_factura");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "sw_factura", $sw_factura))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_maximo - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_maximo");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_maximo", $importe_maximo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcentaje_compra - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcentaje_compra");
			$tipo_dato->set_MaxLength(393218);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcentaje_compra", $porcentaje_compra))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_recibo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_recibo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_recibo", $nro_recibo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_caja - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_caja");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_caja", $estado_caja))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida_cuenta - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_partida_cuenta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_cuenta", $id_partida_cuenta))
				{
					$this->salida = $valid->salida;
					return false;
				}
			//Validar id_auxiliar - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_auxiliar");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_auxiliar", $id_auxiliar))
				{
					$this->salida = $valid->salida;
					return false;
				}	
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_fina_regi_prog_proy_acti");
				$tipo_dato->set_AllowBlank(true);
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fina_regi_prog_proy_acti", $id_fina_regi_prog_proy_acti))
				{
					$this->salida = $valid->salida;
					return false;
				}
			
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_caja - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_caja");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja", $id_caja))
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
	 * Nombre de la funci�n:	ListarAperturaCaja
	 * Prop�sito:				Desplegar los registros de tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:59:46
	 */
	function ListarAperturaCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_sel';
		$this->codigo_procedimiento = "'TS_APECAJ_SEL'";

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
		$this->var->add_def_cols('id_caja','int4');
		$this->var->add_def_cols('tipo_caja','numeric');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('importe_maximo','numeric');
		$this->var->add_def_cols('porcentaje_compra','numeric');
		$this->var->add_def_cols('porcentaje_rinde','numeric');
		$this->var->add_def_cols('estado_caja','numeric');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('nro_recibo','integer');
		$this->var->add_def_cols('nro_vale','integer');
		$this->var->add_def_cols('nro_rinde','integer');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarAperturaCaja
	 * Prop�sito:				Contar los registros de tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:59:46
	 */
	function ContarAperturaCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_sel';
		$this->codigo_procedimiento = "'TS_APECAJ_COUNT'";

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
	 * Nombre de la funci�n:	ModificarAperturaCaja
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:59:46
	 */
	function ModificarAperturaCaja($id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre,$nro_vale,$nro_rinde,$nro_recibo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_iud';
		$this->codigo_procedimiento = "'TS_APECAJ_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param($id_caja);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param($importe_maximo);
		$this->var->add_param($porcentaje_compra);
		$this->var->add_param($porcentaje_rinde);
		$this->var->add_param($nro_recibo);
		$this->var->add_param('NULL');
		$this->var->add_param($nro_vale);//ts_nro_vale
		$this->var->add_param($nro_rinde);//ts_nro_rinde
		$this->var->add_param('null');//ts_nro_rinde
		$this->var->add_param('null');//ts_nro_rinde	
		$this->var->add_param('null');//ts_nro_rinde
		$this->var->add_param("NULL");//ts_codigo_Caja
		$this->var->add_param("NULL");//ts_id_depto	
		$this->var->add_param("NULL");//ts_id_usuario

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function EliminarAperturaCaja($id_caja)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_caja_iud';
		$this->codigo_procedimiento = "'TS_APECAJ_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param($id_caja);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param("NULL");//ts_codigo_Caja
		$this->var->add_param("NULL");//ts_id_depto
		$this->var->add_param("NULL");//ts_id_usuario
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarAperturaCaja
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tts_caja
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-21 09:59:46
	 */
	function ValidarAperturaCaja($operacion_sql,$id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre)
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
				//Validar id_caja - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_caja");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja", $id_caja))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar fecha_inicio - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_inicio");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_inicio", $fecha_inicio))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_maximo - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_maximo");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_maximo", $importe_maximo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcentaje_compra - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcentaje_compra");
			$tipo_dato->set_MaxLength(393218);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcentaje_compra", $porcentaje_compra))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_caja - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_caja");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caja", $id_caja))
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