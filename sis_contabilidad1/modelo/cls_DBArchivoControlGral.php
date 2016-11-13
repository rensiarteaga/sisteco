<?php
/**
 * Nombre de la clase:	cls_DBArchivoControlGral.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfv_tfv_archivo_control
 * Autor:				José Mita
 * Fecha creación:		2011-05-20 18:32:45
 */

 
class cls_DBArchivoControlGral
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
	 * Nombre de la función:	ListarArchivoControl
	 * Propósito:				Desplegar los registros de tfv_archivo_control
	 * Autor:				    José Mita
	 * Fecha de creación:		2011-05-20 18:33:48
	 */
	function ListarRecuperacionVejez($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_archivo_control_sel';
		$this->codigo_procedimiento = "'FV_ARCCONN_SEL'";

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
		$this->var->add_def_cols('id_archivo_control','int4');
		$this->var->add_def_cols('id_factura','int4');
		$this->var->add_def_cols('nro_factura','int4');
		$this->var->add_def_cols('nro_autoriza','numeric');
		$this->var->add_def_cols('fecha_envio','text');
		$this->var->add_def_cols('nro_nit','numeric');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('codigo_form','int4');
		$this->var->add_def_cols('numero_orden','bigint');
		$this->var->add_def_cols('mes_per_fiscal','int4');
		$this->var->add_def_cols('anio_per_fiscal','int4');
		$this->var->add_def_cols('fecha_emision','text');
		$this->var->add_def_cols('importe_factura','numeric');
		$this->var->add_def_cols('cantidad_valor_solicitado','int4');
		$this->var->add_def_cols('nro_beneficiarios_directos','int4');
		$this->var->add_def_cols('nro_beneficiarios_indirectos','int4');
		$this->var->add_def_cols('cant_reg_beneficiarios','int4');
		$this->var->add_def_cols('importe_directo','numeric');
		$this->var->add_def_cols('importe_indirecto','numeric');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('cod_control','varchar');
		$this->var->add_def_cols('estado','int4');		
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarReclamo
	 * Propósito:				Contar los registros de tfv_reclamo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-15 17:33:45
	 */
	function ContarRecuperacionVejez($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_archivo_control_sel';
		$this->codigo_procedimiento = "'FV_ARCCONN_COUNT'";
 
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
	
	function ListarArchivoControlGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_archivo_control_sel';
		$this->codigo_procedimiento = "'FV_ARCOTXT_SEL'";

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

		$this->var->add_def_cols('nro_factura','int4');
		$this->var->add_def_cols('nro_autoriza','numeric');
		$this->var->add_def_cols('fecha_envio','text');
		$this->var->add_def_cols('nro_nit','numeric');
		$this->var->add_def_cols('codigo_form','int4');
		$this->var->add_def_cols('numero_orden','bigint');
		$this->var->add_def_cols('mes_per_fiscal','int4');
		$this->var->add_def_cols('anio_per_fiscal','int4');
		$this->var->add_def_cols('fecha_emision','text');
		$this->var->add_def_cols('importe_factura','numeric');
		$this->var->add_def_cols('cantidad_valor_solicitado','int4');
		$this->var->add_def_cols('nro_beneficiarios_directos','int4');
		$this->var->add_def_cols('nro_beneficiarios_indirectos','int4');
		$this->var->add_def_cols('cant_reg_beneficiarios','int4');
		$this->var->add_def_cols('importe_directo','numeric');
		$this->var->add_def_cols('importe_indirecto','numeric');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('cod_control','varchar');
				
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query = $this->var->query; exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarRecuperacionVejez
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfv_archivo_control
	 * Autor:				    José Mita
	 * Fecha de creación:		2011-05-19 17:33:45
	 */
	function InsertarRecuperacionVejez($id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_archivo_control_iud';
		$this->codigo_procedimiento = "'FV_ARCCONN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($anio_per_fiscal); 
		$this->var->add_param($cantidad_valor_solicitado);
		$this->var->add_param($codigo_form);
		$this->var->add_param("'$fecha_envio'");
		$this->var->add_param($mes_per_fiscal);
		$this->var->add_param($numero_orden);
		$this->var->add_param($nro_factura);
		$this->var->add_param($nro_autoriza);
		$this->var->add_param("'$cod_control'");
		$this->var->add_param("'$fecha_emision'");
		//Ejecuta la función 
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query = $this->var->query; exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRecuperacionVejez
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfv_archivo_control
	 * Autor:				    José Mita
	 * Fecha de creación:		2011-05-19 17:33:45
	 */
	function ModificarRecuperacionVejez($id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_archivo_control_iud';
		$this->codigo_procedimiento = "'FV_ARCCONN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_archivo_control);
		$this->var->add_param($anio_per_fiscal);
		$this->var->add_param($cantidad_valor_solicitado);
		$this->var->add_param($codigo_form);
		$this->var->add_param("'$fecha_envio'");
		$this->var->add_param($mes_per_fiscal);
		$this->var->add_param($numero_orden);
		$this->var->add_param($nro_factura);
		$this->var->add_param($nro_autoriza);
		$this->var->add_param($cod_control);
		$this->var->add_param("'$fecha_emision'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRecuperacionVejez
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfv_archivo_control
	 * Autor:				    José Mita
	 * Fecha de creación:		2011-05-20 17:33:45
	 */
	function EliminarRecuperacionVejez($id_archivo_control)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_archivo_control_iud';
		$this->codigo_procedimiento = "'FV_ARCCONN_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_archivo_control);
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
	
	function ModificarFinalizarFormulario($id_archivo_control,$mes_per_fiscal,$anio_per_fiscal)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_archivo_control_iud';
		$this->codigo_procedimiento = "'FV_ARCCONN_FOR'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_archivo_control);
		$this->var->add_param($anio_per_fiscal);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($mes_per_fiscal);
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
	 * Nombre de la función:	ValidarRecuperacionVejez
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tfv_archivo_control
	 * Autor:				    José Mita
	 * Fecha de creación:		2011-05-19 17:33:45
	 */
	function ValidarRecuperacionVejez($operacion_sql,$id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision)
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
				//Validar id_reclamo - tipo int8
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_archivo_control");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_archivo_control", $id_archivo_control))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_cod_gescom - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("anio_per_fiscal");
			$tipo_dato->set_MaxLength(4);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "anio_per_fiscal", $anio_per_fiscal))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_categoria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad_valor_solicitado");
			$tipo_dato->set_MaxLength(3);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "cantidad_valor_solicitado", $cantidad_valor_solicitado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_regional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_form");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "codigo_form", $codigo_form))
			{
				$this->salida = $valid->salida;
				return false;
			}


			//Validar nro_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_per_fiscal");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "mes_per_fiscal", $mes_per_fiscal))
			{
				$this->salida = $valid->salida;
				return false;
			}

		
			//Validar telefono - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("numero_orden");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "numero_orden", $numero_orden))
			{
				$this->salida = $valid->salida;
				return false;
			}
	
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_reclamo - tipo int8
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_archivo_control");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_archivo_control", $id_archivo_control))
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
	
	function InsertarBeneficiarios($dt_id_archivo_control,$dt_mes_periodo,$dt_anio_periodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_registrar_beneficiarios_iud';
		$this->codigo_procedimiento = "'FV_REGBENN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($dt_id_archivo_control);
		$this->var->add_param($dt_mes_periodo);
		$this->var->add_param($dt_anio_periodo);
			
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
}?>