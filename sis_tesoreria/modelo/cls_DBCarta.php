<?php
/**
 * Nombre de la clase:	cls_DBCarta.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_carta
 * Autor:				(autogenerado)
 * Fecha creación:		2008-11-18 20:39:03
 */

 
class cls_DBCarta
{	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	
	function __construct()
	{		$this->decodificar=$decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarCartaRegistro
	 * Propósito:				Desplegar los registros de tts_carta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-18 20:39:03
	 */
	function ListarCartaRegistro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_carta_sel';
		$this->codigo_procedimiento = "'TS_CARTA_SEL'";

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
		$this->var->add_def_cols('id_carta','int4');//id_carta
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','int4');//id_fina_regi_prog_proy_acti
		$this->var->add_def_cols('id_unidad_organizacional','int4');//id_unidad_organizacional
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');//desc_unidad_organizacional
		$this->var->add_def_cols('id_moneda','int4');//id_moneda
		$this->var->add_def_cols('desc_moneda','varchar');//desc_moneda
		$this->var->add_def_cols('clase_carta','numeric');//clase_carta
		$this->var->add_def_cols('tipo_carta','numeric');//tipo_carta
		$this->var->add_def_cols('estado_carta','numeric');//estado_carta
		$this->var->add_def_cols('id_cuenta_bancaria','int4');//id_cuenta_bancaria
		$this->var->add_def_cols('nro_cuenta_banco_cuenta_bancaria','varchar');//nro_cuenta_banco_cuenta_bancaria
		$this->var->add_def_cols('desc_cuenta_bancaria_inst','text');//desc_cuenta_bancaria
		$this->var->add_def_cols('id_institucion','int4');//id_institucion
		$this->var->add_def_cols('desc_institucion','varchar');//desc_institucion
		$this->var->add_def_cols('id_proveedor','int4');//id_proveedor
		$this->var->add_def_cols('desc_proveedor','text');//
		$this->var->add_def_cols('fecha_inicio','date');//fecha_inicio
		$this->var->add_def_cols('fecha_vence','date');//fecha_vence
		$this->var->add_def_cols('obs_carta','varchar');//obs_carta
		$this->var->add_def_cols('importe_carta','numeric');//importe_carta
		$this->var->add_def_cols('importe_pagado','numeric');//importe_pagado
		$this->var->add_def_cols('id_cheque','int4');//id_cheque
		$this->var->add_def_cols('nombre_cheque_cheque','varchar');//nombre_cheque_cheque
		$this->var->add_def_cols('nro_cheque_cheque','int4');//nro_cheque_cheque
		$this->var->add_def_cols('fecha_cheque_cheque','date');//fecha_cheque_cheque
		$this->var->add_def_cols('desc_cheque','text');//desc_cheque
		$this->var->add_def_cols('id_comprobante','int4');//id_comprobante
		$this->var->add_def_cols('desc_comprobante','int4');//desc_comprobante
		$this->var->add_def_cols('desc_carta','text');//desc_carta
		$this->var->add_def_cols('fk_carta','int4');//fk_carta
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
	
	/*echo $this->query;
	exit;*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCartaRegistro
	 * Propósito:				Contar los registros de tts_carta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-18 20:39:03
	 */
	function ContarCartaRegistro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_carta_sel';
		$this->codigo_procedimiento = "'TS_CARTA_COUNT'";

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
	 * Nombre de la función:	InsertarCartaRegistro
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_carta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-18 20:39:03
	 */
	function InsertarCartaRegistro($id_carta,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_moneda,$clase_carta,$tipo_carta,$estado_carta,$id_cuenta_bancaria,$id_institucion,$id_proveedor,$fecha_inicio,$fecha_vence,$obs_carta,$importe_carta,$importe_pagado,$id_cheque,$id_comprobante,$fk_carta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_carta_iud';
		$this->codigo_procedimiento = "'TS_CARTA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//id_carta
		$this->var->add_param($id_fina_regi_prog_proy_acti);//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_unidad_organizacional);//id_unidad_organizacional
		$this->var->add_param($id_moneda);//id_moneda
		$this->var->add_param($clase_carta);
		$this->var->add_param($tipo_carta);
		$this->var->add_param($estado_carta);
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_proveedor);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_vence'");
		$this->var->add_param("'$obs_carta'");
		$this->var->add_param($importe_carta);
		$this->var->add_param($importe_pagado);
		$this->var->add_param($id_cheque);
		$this->var->add_param($id_comprobante);
		$this->var->add_param($fk_carta);
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
/*echo $this->query;
	exit;*/
		return $res;
	}
	
	
	
	/**
	 * Nombre de la función:	ModificarCartaRegistro
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_carta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-18 20:39:03
	 */
	function ModificarCartaRegistro($id_carta,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_moneda,$clase_carta,$tipo_carta,$estado_carta,$id_cuenta_bancaria,$id_institucion,$id_proveedor,$fecha_inicio,$fecha_vence,$obs_carta,$importe_carta,$importe_pagado,$id_cheque,$id_comprobante,$fk_carta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_carta_iud';
		$this->codigo_procedimiento = "'TS_CARTA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_carta);
		$this->var->add_param($id_fina_regi_prog_proy_acti);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_moneda);
		$this->var->add_param($clase_carta);
		$this->var->add_param($tipo_carta);
		$this->var->add_param($estado_carta);
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_proveedor);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_vence'");
		$this->var->add_param("'$obs_carta'");
		$this->var->add_param($importe_carta);
		$this->var->add_param($importe_pagado);
		$this->var->add_param($id_cheque);
		$this->var->add_param($id_comprobante);
		$this->var->add_param($fk_carta);
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
		
	//function InsertarCartaAmortizacionDetalle($id_carta,$fecha_inicio,$importe_pagado,$fk_carta)
	function InsertarCartaAmortizacionDetalle($id_carta,$fecha_inicio,$importe_pagado,$fk_carta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_carta_iud';
		$this->codigo_procedimiento = "'TS_CARAMO_INS'";

		
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
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($importe_pagado);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($fk_carta);
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
	
	function ModificarCartaAmortizacionDetalle($id_carta,$fecha_inicio,$importe_pagado,$fk_carta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_carta_iud';
		$this->codigo_procedimiento = "'TS_CARAMO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_carta);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($importe_pagado);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($fk_carta);
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
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Nombre de la función:	EliminarCartaRegistro
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_carta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-18 20:39:03
	 */
	function EliminarCartaRegistro($id_carta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_carta_iud';
		$this->codigo_procedimiento = "'TS_CARTA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_carta);
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

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarCartaRegistro
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_carta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-18 20:39:03
	 */
	function ValidarCartaRegistro($operacion_sql,$id_carta,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_moneda,$clase_carta,$tipo_carta,$estado_carta,$id_cuenta_bancaria,$id_institucion,$id_proveedor,$fecha_inicio,$fecha_vence,$obs_carta,$importe_carta,$importe_pagado,$id_cheque,$id_comprobante,$fk_carta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
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
				//Validar id_carta - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_carta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_carta", $id_carta))
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

			//Validar clase_carta - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("clase_carta");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "clase_carta", $clase_carta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_carta - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_carta");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_carta", $tipo_carta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_carta - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_carta");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_carta", $estado_carta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cuenta_bancaria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_bancaria");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_bancaria", $id_cuenta_bancaria))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_institucion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion", $id_institucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
			{
				$this->salida = $valid->salida;
				return false;
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

			//Validar fecha_vence - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_vence");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_vence", $fecha_vence))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar obs_carta - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("obs_carta");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "obs_carta", $obs_carta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_carta - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_carta");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_carta", $importe_carta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_pagado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_pagado");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_pagado", $importe_pagado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cheque - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cheque");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cheque", $id_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_comprobante - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_comprobante");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_comprobante", $id_comprobante))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fk_carta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fk_carta");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "fk_carta", $fk_carta))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_carta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_carta");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_carta", $id_carta))
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