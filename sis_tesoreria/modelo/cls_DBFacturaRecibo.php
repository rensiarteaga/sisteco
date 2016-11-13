<?php
/**
 * Nombre de la clase:	cls_DBFacturaRecibo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_factura_recibo
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-29 17:35:03
 */

 
class cls_DBFacturaRecibo
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
	 * Nombre de la función:	ListarEmisionFactura
	 * Propósito:				Desplegar los registros de tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function ListarEmisionFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_sel';
		$this->codigo_procedimiento = "'TS_EMIFAC_SEL'";

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
		$this->var->add_def_cols('id_factura_recibo','int4');
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','int4');
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('id_caja','int4');
		$this->var->add_def_cols('nombre_unidad_unidad_organizacional','varchar');
		$this->var->add_def_cols('desc_caja','varchar');
		$this->var->add_def_cols('id_cajero','int4');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('codigo_empleado_empleado','varchar');
		$this->var->add_def_cols('desc_cajero','text');
		$this->var->add_def_cols('id_concepto_ingas','int4');
		$this->var->add_def_cols('desc_partida_partida','varchar');
		$this->var->add_def_cols('desc_ingas_concepto_ingas','varchar');
		$this->var->add_def_cols('desc_concepto_ingas','text');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('nro_factura','int4');
		$this->var->add_def_cols('importe_factura','numeric');
		$this->var->add_def_cols('nro_deposito','varchar');
		$this->var->add_def_cols('fecha_factura','date');
		$this->var->add_def_cols('fecha_deposito','date');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_nit','varchar');
		$this->var->add_def_cols('codigo_control','varchar');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEmisionFactura
	 * Propósito:				Contar los registros de tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function ContarEmisionFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_sel';
		$this->codigo_procedimiento = "'TS_EMIFAC_COUNT'";

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
	 * Nombre de la función:	InsertarEmisionFactura
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function InsertarEmisionFactura($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$nro_nit,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_iud';
		$this->codigo_procedimiento = "'TS_EMIFAC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_fina_regi_prog_proy_acti);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_cajero);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_moneda);
		
		$this->var->add_param($importe_factura);
		$this->var->add_param("'$nro_deposito'");
		$this->var->add_param("'$fecha_deposito'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEmisionFactura
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function ModificarEmisionFactura($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$nro_nit,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_iud';
		$this->codigo_procedimiento = "'TS_EMIFAC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_factura_recibo);
		$this->var->add_param($id_fina_regi_prog_proy_acti);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_cajero);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_factura);
		$this->var->add_param("'$nro_deposito'");
		$this->var->add_param("'$fecha_deposito'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEmisionFactura
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function EliminarEmisionFactura($id_factura_recibo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_iud';
		$this->codigo_procedimiento = "'TS_EMIFAC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_factura_recibo);
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
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarEmisionFactura
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function ValidarEmisionFactura($operacion_sql,$id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$nro_nit,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
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
				//Validar id_factura_recibo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_factura_recibo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_factura_recibo", $id_factura_recibo))
				{
					$this->salida = $valid->salida;
					return false;
				}
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
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
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

			

			//Validar importe_factura - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_factura");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_factura", $importe_factura))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_deposito - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_deposito");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_deposito", $nro_deposito))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_deposito - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_deposito");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_deposito", $fecha_deposito))
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
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_nit", $nro_nit))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_factura_recibo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_factura_recibo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_factura_recibo", $id_factura_recibo))
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
	
	
	
	/***************REcibos*********************************************/
	
	/**
	 * Nombre de la función:	ListarEmisionFactura
	 * Propósito:				Desplegar los registros de tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function ListarEmisionRecibo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_sel';
		$this->codigo_procedimiento = "'TS_EMIREC_SEL'";

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
		$this->var->add_def_cols('id_factura_recibo','int4');
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','int4');
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('id_caja','int4');
		$this->var->add_def_cols('nombre_unidad_unidad_organizacional','varchar');
		$this->var->add_def_cols('desc_caja','varchar');
		$this->var->add_def_cols('id_cajero','int4');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('codigo_empleado_empleado','varchar');
		$this->var->add_def_cols('desc_cajero','text');
		$this->var->add_def_cols('id_concepto_ingas','int4');
		$this->var->add_def_cols('desc_partida_partida','varchar');
		$this->var->add_def_cols('desc_ingas_concepto_ingas','varchar');
		$this->var->add_def_cols('desc_concepto_ingas','text');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('nro_factura','int4');
		$this->var->add_def_cols('importe_factura','numeric');
		$this->var->add_def_cols('nro_deposito','varchar');
		$this->var->add_def_cols('fecha_factura','date');
		$this->var->add_def_cols('fecha_deposito','date');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEmisionFactura
	 * Propósito:				Contar los registros de tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function ContarEmisionRecibo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_sel';
		$this->codigo_procedimiento = "'TS_EMIREC_COUNT'";

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
	 * Nombre de la función:	InsertarEmisionFactura
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function InsertarEmisionRecibo($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_iud';
		$this->codigo_procedimiento = "'TS_EMIREC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_fina_regi_prog_proy_acti);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_cajero);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_moneda);
		
		$this->var->add_param($importe_factura);
		$this->var->add_param("'$nro_deposito'");
		$this->var->add_param("'$fecha_deposito'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("NULL");
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEmisionFactura
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function ModificarEmisionRecibo($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_iud';
		$this->codigo_procedimiento = "'TS_EMIREC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_factura_recibo);
		$this->var->add_param($id_fina_regi_prog_proy_acti);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_cajero);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_factura);
		$this->var->add_param("'$nro_deposito'");
		$this->var->add_param("'$fecha_deposito'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("NULL");
		
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEmisionFactura
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function EliminarEmisionRecibo($id_factura_recibo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_factura_recibo_iud';
		$this->codigo_procedimiento = "'TS_EMIREC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_factura_recibo);
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
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarEmisionFactura
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_factura_recibo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-29 17:35:03
	 */
	function ValidarEmisionRecibo($operacion_sql,$id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
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
				//Validar id_factura_recibo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_factura_recibo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_factura_recibo", $id_factura_recibo))
				{
					$this->salida = $valid->salida;
					return false;
				}
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
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
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

			

			//Validar importe_factura - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_factura");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_factura", $importe_factura))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_deposito - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_deposito");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_deposito", $nro_deposito))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_deposito - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_deposito");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_deposito", $fecha_deposito))
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
			return true;
			
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_factura_recibo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_factura_recibo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_factura_recibo", $id_factura_recibo))
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