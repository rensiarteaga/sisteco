<?php
/**
 * Nombre de la clase:	cls_DBConfigAprobador.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_config_aprobador
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-06 21:05:09
 */

class cls_DBConfigAprobador
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
	 * Nombre de la función:	ListarConfigAprobador
	 * Propósito:				Desplegar los registros de tpm_config_aprobador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:05:09
	 */
	function ListarConfigAprobador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_config_aprobador_sel';
		$this->codigo_procedimiento = "'PM_CONF_APRO_SEL'";

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
		$this->var->add_def_cols('id_config_aprobador','int4');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('id_uo','int4');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('concepto','varchar');
		$this->var->add_def_cols('min_monto','numeric');
		$this->var->add_def_cols('max_monto','numeric');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('nombre_completo','text');
		
        $this->var->add_def_cols('prioridad','int4');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('fecha_expiracion','date');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
		$this->var->add_def_cols('usuario_mod','varchar');
		$this->var->add_def_cols('fecha_mod','timestamp');
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarConfigAprobador
	 * Propósito:				Contar los registros de tpm_config_aprobador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:05:09
	 */
	function ContarConfigAprobador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_config_aprobador_sel';
		$this->codigo_procedimiento = "'PM_CONF_APRO_COUNT'";

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
	 * Nombre de la función:	InsertarConfigAprobador
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_config_aprobador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:05:09
	 */
	function InsertarConfigAprobador($id_config_aprobador,$id_gestion,$id_presupuesto,$id_uo,$concepto,$min_monto,$max_monto,$id_empleado,$prioridad,$estado,$fecha_expiracion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_config_aprobador_iud';
		$this->codigo_procedimiento = "'PM_CONF_APRO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_uo);
		$this->var->add_param("'$concepto'");
		$this->var->add_param($min_monto);
		$this->var->add_param($max_monto);
		$this->var->add_param($id_empleado);
		$this->var->add_param($prioridad);
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$fecha_expiracion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarConfigAprobador
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_config_aprobador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:05:09
	 */
	function ModificarConfigAprobador($id_config_aprobador,$id_gestion,$id_presupuesto,$id_uo,$concepto,$min_monto,$max_monto,$id_empleado,$prioridad,$estado,$fecha_expiracion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_config_aprobador_iud';
		$this->codigo_procedimiento = "'PM_CONF_APRO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_config_aprobador);
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_uo);
		$this->var->add_param("'$concepto'");
		$this->var->add_param($min_monto);
		$this->var->add_param($max_monto);
		$this->var->add_param($id_empleado);
		$this->var->add_param($prioridad);
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$fecha_expiracion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarConfigAprobador
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_config_aprobador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:05:09
	 */
	function EliminarConfigAprobador($id_config_aprobador)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_config_aprobador_iud';
		$this->codigo_procedimiento = "'PM_CONF_APRO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_config_aprobador);
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
	 * Nombre de la función:	ValidarConfigAprobador
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_config_aprobador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:05:09
	 */
	function ValidarConfigAprobador($operacion_sql,$id_config_aprobador,$id_gestion,$id_presupuesto,$id_uo,$concepto,$min_monto,$max_monto,$id_empleado,$prioridad)
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
				//Validar id_contratista - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_config_aprobador");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_config_aprobador", $id_config_aprobador))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_gestion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
				{
					$this->salida = $valid->salida;
					return false;
				}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_presupuesto");
				$tipo_dato->set_AllowBlank("true");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_presupuesto", $id_presupuesto))
				{
					$this->salida = $valid->salida;
					return false;
				}

			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_uo");
				$tipo_dato->set_AllowBlank("true");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_uo", $id_uo))
				{
					$this->salida = $valid->salida;
					return false;
				}

			//Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("concepto");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "concepto", $concepto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_persona - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("prioridad");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "prioridad", $prioridad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_contratista - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_config_aprobador");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_config_aprobador", $id_config_aprobador))
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