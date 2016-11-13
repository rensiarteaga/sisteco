<?php
/**
 * Nombre de la Clase:	cls_DBActualizacion
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tct_actualizacion
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		13/12/2010
 */
class cls_DBActualizacion
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
	 * Nombre de la función:	ListarActualizacion
	 * Propósito:				Desplegar los registros de tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ListarActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_actualizacion_sel';
		$this->codigo_procedimiento = "'CT_ACTUAL_SEL'";

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
		$this->var->add_def_cols('id_actualizacion','integer');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('desc_depto','text');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('glosa_cbte','varchar');
		$this->var->add_def_cols('nro_cbte','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarActualizacion
	 * Propósito:				Contar los registros de tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ContarActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_actualizacion_sel';
		$this->codigo_procedimiento = "'CT_ACTUAL_COUNT'";

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
	 * Nombre de la función:	InsertarActualizacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function GenerarActualizacion($id_actualizacion, $sw_proce)
	{
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_i_ct_gestionar_generacion_comprobantes_sci';
		if ($sw_proce == 'gen_act'){
			$this->codigo_procedimiento = "'CT_CONTACTUALIZACION_INS'";
		}
		if ($sw_proce == 'aju_sal'){
			$this->codigo_procedimiento = "'CT_AJUSTASALDO_UPD'";
		}
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_actualizacion");
		//echo '$id_actualizacion'.$id_actualizacion; exit();
	 
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo $this->query;exit;
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarActualizacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function InsertarActualizacion($id_actualizacion,$id_depto,$fecha,$descripcion,$fecha_reg,$id_usuario,$id_moneda,$id_comprobante)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_actualizacion_iud';
		$this->codigo_procedimiento = "'CT_ACTUAL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_depto");	
		$this->var->add_param("'$fecha'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("$id_usuario");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$id_comprobante");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
        //echo $this->query;
        //exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarActualizacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ModificarActualizacion($id_actualizacion,$id_depto,$fecha,$descripcion,$fecha_reg,$id_usuario,$id_moneda,$id_comprobante)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_actualizacion_iud';
		$this->codigo_procedimiento = "'CT_ACTUAL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_actualizacion);
		$this->var->add_param("$id_depto");	
		$this->var->add_param("'$fecha'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("$id_usuario");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$id_comprobante");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarActualizacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function EliminarActualizacion($id_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_actualizacion_iud';
		$this->codigo_procedimiento = "'CT_ACTUAL_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_actualizacion);
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
	 * Nombre de la función:	ValidarActualizacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_actualizacion
	 * Autor:				    avq
	 * Fecha de creación:		2010-12-13
	 */
	function ValidarActualizacion($operacion_sql,$id_actualizacion,$id_depto,$fecha,$descripcion,$fecha_reg,$id_usuario,$id_moneda,$id_comprobante)
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
				//Validar id_actualizacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_actualizacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_actualizacion", $id_actualizacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			//Validar id_usuario - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "id_depto", $id_depto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha", $fecha))
			{
				$this->salida = $valid->salida;
				return false;
			}
			

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_actualizacion - tipo int4
			/*	$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_usuario");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario", $id_usuario))
				{
					$this->salida = $valid->salida;
					return false;
				}
				*/
				
				//Validar id_actualizacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_moneda");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				
				//Validar id_actualizacion - tipo int4
				/*$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_comprobante");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_comprobante", $id_comprobante))
				{
					$this->salida = $valid->salida;
					return false;
				}
				*/
				
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_actualizacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_actualizacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_actualizacion", $id_actualizacion))
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