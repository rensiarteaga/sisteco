<?php
/**
 * Nombre de la clase:	cls_DBDetalleBeneficiario.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfv_tfv_detalle_beneficiario
 * Autor:				José Mita
 * Fecha creación:		2011-06-14 10:51:07
 */

 
class cls_DBDetalleBeneficiarioGral
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
	 * Nombre de la función:	ListarDetalleBeneficiario
	 * Propósito:				Desplegar los registros de tfv_detalle_beneficiario
	 * Autor:				    José Mita
	 * Fecha de creación:		2011-06-14 10:58:07
	 */
	function ListarDetalleBeneficiarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_detalle_beneficiario_sel';
		$this->codigo_procedimiento = "'FV_DETBENN_SEL'";

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
		$this->var->add_def_cols('beneficiario','varchar');
		$this->var->add_def_cols('codigo_control_factura_ben','varchar');
		$this->var->add_def_cols('consumo','int4');
		$this->var->add_def_cols('estado','int4');
		$this->var->add_def_cols('fecha_nacimiento','text');
		$this->var->add_def_cols('id_archivo_control','int4');
		$this->var->add_def_cols('id_beneficiario_vejez','int4');
		$this->var->add_def_cols('id_cliente','int4');
		$this->var->add_def_cols('id_lectura','int4');
		$this->var->add_def_cols('importe_des_direc','numeric');
		$this->var->add_def_cols('importe_des_indirec','numeric');
		$this->var->add_def_cols('importe_facturado','numeric');
		$this->var->add_def_cols('numero_autorizacion_fecha_ben','numeric');
		$this->var->add_def_cols('numero_factura_ben','int4');
		$this->var->add_def_cols('numero_ident','varchar');
		$this->var->add_def_cols('tipo_identificacion','varchar');
		$this->var->add_def_cols('regional','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRespuestaReclamo
	 * Propósito:				Contar los registros de tfv_respuesta_reclamo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-19 09:51:07
	 */
	function ContarDetalleBeneficiarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_detalle_beneficiario_sel';
		$this->codigo_procedimiento = "'FV_DETBENN_COUNT'";

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
	 * Nombre de la función:	InsertarRespuestaReclamo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfv_respuesta_reclamo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-19 09:51:07
	 */
	function InsertarDetalleBeneficiario($id_beneficiario_vejez, $id_archivo_control, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_respuesta_reclamo_iud';
		$this->codigo_procedimiento = "'FV_RESRECC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_reclamo);
		$this->var->add_param("'$respuesta'");
		$this->var->add_param($sw_procendente);
		$this->var->add_param("'$fecha_hora_respuesta'");
		$this->var->add_param("'$fecha_hora_comunicacion'");
		$this->var->add_param($medio_comunicacion);
		$this->var->add_param("'$fecha_hora_fin_proceso'");
		$this->var->add_param("'$solucion'");
		$this->var->add_param("'$motivo_demora'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo($this->query);
		exit;*/

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDetalleBeneficiario
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfv_respuesta_reclamo
	 * Autor:				    José Mita
	 * Fecha de creación:		2011-06-15
	 */
	function ModificarDetalleBeneficiario($id_beneficiario_vejez, $id_archivo_control, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_beneficiario_vejez_iud';
		$this->codigo_procedimiento = "'FV_BENVEJJ_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_beneficiario_vejez);
		$this->var->add_param($id_archivo_control);
		$this->var->add_param($estado);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRespuestaReclamo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfv_respuesta_reclamo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-19 09:51:07
	 */
	function EliminarDetalleBeneficiario($id_respuesta_reclamo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_respuesta_reclamo_iud';
		$this->codigo_procedimiento = "'FV_RESRECC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_respuesta_reclamo);
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
	 * Nombre de la función:	ValidarRespuestaReclamo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tfv_respuesta_reclamo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-10-19 09:51:07
	 */
	function ValidarDetalleBeneficiario($operacion_sql,$id_beneficiario_vejez, $id_archivo_control, $estado)
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
				//Validar id_respuesta_reclamo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_beneficiario_vejez");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_beneficiario_vejez", $id_beneficiario_vejez))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			/*//Validar id_reclamo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_reclamo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_reclamo", $id_reclamo))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar respuesta - tipo text
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("respuesta");
			//$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "respuesta", $respuesta))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar solucion - tipo text
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("solucion");
			//$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "solucion", $solucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar motivo_demora - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("motivo_demora");
			//$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "motivo_demora", $motivo_demora))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_respuesta_reclamo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_beneficiario_vejez");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_beneficiario_vejez", $id_beneficiario_vejez))
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
	
/**
	 * Nombre de la función:	ListarDetalleBeneficiario
	 * Propósito:				Desplegar los registros de tfv_detalle_beneficiario
	 * Autor:				    José Mita
	 * Fecha de creación:		2011-06-14 10:58:07
	 */
	function ListarDetalleBeneficiariosGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_detalle_beneficiario_sel';
		$this->codigo_procedimiento = "'FV_GENBENN_SEL'";

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
		$this->var->add_def_cols('numero_factura_ben','int4');
		$this->var->add_def_cols('numero_autorizacion_fecha_ben','numeric');
		$this->var->add_def_cols('beneficiario','varchar');
		$this->var->add_def_cols('tipo_identificacion','varchar');
		$this->var->add_def_cols('numero_ident','varchar');
		$this->var->add_def_cols('fecha_nacimiento','text');
		$this->var->add_def_cols('consumo','int4');
		$this->var->add_def_cols('importe_des_direc','numeric');
		$this->var->add_def_cols('importe_des_indirec','numeric');
		$this->var->add_def_cols('importe_facturado','numeric');
		$this->var->add_def_cols('codigo_control_factura_ben','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
}?>