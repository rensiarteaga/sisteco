<?php
/**
 * Nombre de la clase:	cls_DBIngreso.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_ingreso
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-18 20:48:41
 */

class cls_DBIngreso
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
	 * Nombre de la función:	ListarIngreso
	 * Propósito:				Desplegar los registros de tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ListarIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_sel';
		$this->codigo_procedimiento = "'AL_INGRES_SEL'";

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
		$this->var->add_def_cols('id_ingreso','int4');
		$this->var->add_def_cols('correlativo_ord_ing','varchar');
		$this->var->add_def_cols('correlativo_ing','text');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('costo_total','numeric');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_ingreso','varchar');
		
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('cod_inf_tec','varchar');
		$this->var->add_def_cols('resumen_inf_tec','varchar');
		$this->var->add_def_cols('fecha_borrador','date');
		$this->var->add_def_cols('fecha_pendiente','date');
		$this->var->add_def_cols('fecha_aprobado_rechazado','date');
		$this->var->add_def_cols('fecha_ing_fisico','date');
		$this->var->add_def_cols('fecha_ing_valorado','date');
		$this->var->add_def_cols('fecha_finalizado_cancelado','date');
		$this->var->add_def_cols('fecha_reg','date');
		
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('desc_proveedor','varchar');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','int4');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_motivo_ingreso_cuenta','int4');
		$this->var->add_def_cols('desc_motivo_ingreso_cuenta','varchar');
		$this->var->add_def_cols('nombre_proveedor','varchar');
		$this->var->add_def_cols('nombre_contratista','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('desc_motivo_ingreso','varchar');
		
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarIngreso
	 * Propósito:				Contar los registros de tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ContarIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_sel';
		$this->codigo_procedimiento = "'AL_INGRES_COUNT'";

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
	 * Nombre de la función:	InsertarIngreso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function InsertarIngreso($id_ingreso,$correlativo_ord_ing,$correlativo_ing,$descripcion,$costo_total,$contabilizar,$contabilizado,$estado_ingreso,$estado_registro,$cod_inf_tec,$resumen_inf_tec,$fecha_borrador,$fecha_pendiente,$fecha_aprobado_rechazado,$fecha_ing_fisico,$fecha_ing_valorado,$fecha_finalizado_cancelado,$fecha_reg,$id_responsable_almacen,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_firma_autorizada,$id_institucion,$id_motivo_ingreso_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_INGRES_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($correlativo_ord_ing);
		$this->var->add_param($correlativo_ing);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($costo_total);
		$this->var->add_param("'$contabilizar'");
		$this->var->add_param("'$contabilizado'");
		$this->var->add_param("'$estado_ingreso'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$cod_inf_tec'");//10
		$this->var->add_param("'$resumen_inf_tec'");
		$this->var->add_param("'$fecha_borrador'");
		$this->var->add_param("'$fecha_pendiente'");
		$this->var->add_param("'$fecha_aprobado_rechazado'");
		$this->var->add_param("'$fecha_ing_fisico'");
		$this->var->add_param("'$fecha_ing_valorado'");
		$this->var->add_param("'$fecha_finalizado_cancelado'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param($id_proveedor);//20
		$this->var->add_param($id_contratista);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param($id_firma_autorizada);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_motivo_ingreso_cuenta);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//40
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
	 * Nombre de la función:	ModificarIngreso
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ModificarIngreso($id_ingreso,$correlativo_ord_ing,$correlativo_ing,$descripcion,$costo_total,$contabilizar,$contabilizado,$estado_ingreso,$estado_registro,$cod_inf_tec,$resumen_inf_tec,$fecha_borrador,$fecha_pendiente,$fecha_aprobado_rechazado,$fecha_ing_fisico,$fecha_ing_valorado,$fecha_finalizado_cancelado,$fecha_reg,$id_responsable_almacen,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_firma_autorizada,$id_institucion,$id_motivo_ingreso_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_INGRES_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ingreso);
		$this->var->add_param($correlativo_ord_ing);
		$this->var->add_param($correlativo_ing);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($costo_total);
		$this->var->add_param("'$contabilizar'");
		$this->var->add_param("'$contabilizado'");
		$this->var->add_param("'$estado_ingreso'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$cod_inf_tec'");//10
		$this->var->add_param("'$resumen_inf_tec'");
		$this->var->add_param("'$fecha_borrador'");
		$this->var->add_param("'$fecha_pendiente'");
		$this->var->add_param("'$fecha_aprobado_rechazado'");
		$this->var->add_param("'$fecha_ing_fisico'");
		$this->var->add_param("'$fecha_ing_valorado'");
		$this->var->add_param("'$fecha_finalizado_cancelado'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param($id_proveedor);//20
		$this->var->add_param($id_contratista);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param($id_firma_autorizada);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_motivo_ingreso_cuenta);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//40
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
	 * Nombre de la función:	EliminarIngreso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function EliminarIngreso($id_ingreso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_INGRES_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ingreso);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//40
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
	 * Nombre de la función:	ValidarIngreso
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ValidarIngreso($operacion_sql,$id_ingreso,$correlativo_ord_ing,$correlativo_ing,$descripcion,$costo_total,$contabilizar,$contabilizado,$estado_ingreso,$estado_registro,$cod_inf_tec,$resumen_inf_tec,$fecha_borrador,$fecha_pendiente,$fecha_aprobado_rechazado,$fecha_ing_fisico,$fecha_ing_valorado,$fecha_finalizado_cancelado,$fecha_reg,$id_responsable_almacen,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_firma_autorizada,$id_institucion,$id_motivo_ingreso_cuenta)
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
				//Validar id_ingreso - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_ingreso");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso", $id_ingreso))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar correlativo_ord_ing - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("correlativo_ord_ing");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "correlativo_ord_ing", $correlativo_ord_ing))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar correlativo_ing - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("correlativo_ing");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "correlativo_ing", $correlativo_ing))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_total - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_total");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_total", $costo_total))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar contabilizar - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("contabilizar");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "contabilizar", $contabilizar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar contabilizado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("contabilizado");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "contabilizado", $contabilizado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_ingreso - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_ingreso");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_ingreso", $estado_ingreso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cod_inf_tec - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cod_inf_tec");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cod_inf_tec", $cod_inf_tec))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar resumen_inf_tec - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("resumen_inf_tec");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "resumen_inf_tec", $resumen_inf_tec))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_borrador - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_borrador");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_borrador", $fecha_borrador))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_pendiente - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_pendiente");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_pendiente", $fecha_pendiente))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_aprobado_rechazado - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_aprobado_rechazado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_aprobado_rechazado", $fecha_aprobado_rechazado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_ing_fisico - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ing_fisico");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ing_fisico", $fecha_ing_fisico))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_ing_valorado - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ing_valorado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ing_valorado", $fecha_ing_valorado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_finalizado_cancelado - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_finalizado_cancelado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_finalizado_cancelado", $fecha_finalizado_cancelado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_responsable_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_responsable_almacen");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_responsable_almacen", $id_responsable_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_contratista - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_contratista");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_contratista", $id_contratista))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_almacen_logico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_logico");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_logico", $id_almacen_logico))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_firma_autorizada - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_firma_autorizada");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_firma_autorizada", $id_firma_autorizada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_institucion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion", $id_institucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_motivo_ingreso_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_motivo_ingreso_cuenta");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_motivo_ingreso_cuenta", $id_motivo_ingreso_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar contabilizar
			$check = array ("si","no");
			if(!in_array($contabilizar,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'contabilizar': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarIngreso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar contabilizado
			$check = array ("si","no");
			if(!in_array($contabilizado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'contabilizado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarIngreso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar estado_ingreso
			$check = array ("Borrador","Pendiente","Aprobado","Ejecutado","Anulado");
			if(!in_array($estado_ingreso,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_ingreso': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarIngreso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar estado_registro
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado_registro,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_registro': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarIngreso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_ingreso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ingreso");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso", $id_ingreso))
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