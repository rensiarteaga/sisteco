<?php
/**
 * Nombre de la clase:	cls_DBRegistroEvento.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_registro_evento
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-26 16:05:00
 */

class cls_DBRegistroEvento
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
	 * Nombre de la función:	ListarRegistroEvento
	 * Propósito:				Desplegar los registros de tsg_registro_evento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:05:00
	 */
	function ListarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_registro_evento_sel';
		$this->codigo_procedimiento = "'SG_REGEVE_SEL'";

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
		$this->var->add_def_cols('id_registro_eventos','bigint');
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('desc_subsistema','varchar');
		$this->var->add_def_cols('id_lugar','int4');
		$this->var->add_def_cols('desc_lugar','varchar');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('hora','time');
		$this->var->add_def_cols('numero_error','varchar');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('ip_origen','varchar');
		$this->var->add_def_cols('log_error','varchar');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('proc_almacenado','varchar');
		$this->var->add_def_cols('mac_maquina','text');
		$this->var->add_def_cols('nombre','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
	
		
		
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRegistroEvento
	 * Propósito:				Contar los registros de tsg_registro_evento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:05:00
	 */
	function ContarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_registro_evento_sel';
		$this->codigo_procedimiento = "'SG_REGEVE_COUNT'";

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
	 * Nombre de la función:	InsertarRegistroEvento
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_registro_evento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:05:00
	 */
	function InsertarRegistroEvento($id_registro_eventos,$id_usuario,$id_subsistema,$id_lugar,$fecha,$hora,$numero_error,$descripcion,$ip_origen,$log_error,$codigo_procedimiento,$proc_almacenado,$mac_maquina)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_registro_evento_iud';
		$this->codigo_procedimiento = "'SG_REGEVE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_usuario);
		$this->var->add_param($id_subsistema);
		$this->var->add_param($id_lugar);
		$this->var->add_param("'$fecha'");
		$this->var->add_param("'$hora'");
		$this->var->add_param("'$numero_error'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$ip_origen'");
		$this->var->add_param("'$log_error'");
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$proc_almacenado'");
		$this->var->add_param($mac_maquina);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRegistroEvento
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_registro_evento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:05:00
	 */
	function ModificarRegistroEvento($id_registro_eventos,$id_usuario,$id_subsistema,$id_lugar,$fecha,$hora,$numero_error,$descripcion,$ip_origen,$log_error,$codigo_procedimiento,$proc_almacenado,$mac_maquina)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_registro_evento_iud';
		$this->codigo_procedimiento = "'SG_REGEVE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_registro_eventos);
		$this->var->add_param($id_usuario);
		$this->var->add_param($id_subsistema);
		$this->var->add_param($id_lugar);
		$this->var->add_param("'$fecha'");
		$this->var->add_param("'$hora'");
		$this->var->add_param("'$numero_error'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$ip_origen'");
		$this->var->add_param("'$log_error'");
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$proc_almacenado'");
		$this->var->add_param($mac_maquina);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRegistroEvento
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_registro_evento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:05:00
	 */
	function EliminarRegistroEvento($id_registro_eventos)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_registro_evento_iud';
		$this->codigo_procedimiento = "'SG_REGEVE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_registro_eventos);
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
	 * Nombre de la función:	ValidarRegistroEvento
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_registro_evento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:05:00
	 */
	function ValidarRegistroEvento($operacion_sql,$id_registro_eventos,$id_usuario,$id_subsistema,$id_lugar,$fecha,$hora,$numero_error,$descripcion,$ip_origen,$log_error,$codigo_procedimiento,$proc_almacenado,$mac_maquina)
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
				//Validar id_registro_eventos - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_registro_eventos");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_registro_eventos", $id_registro_eventos))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_usuario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario", $id_usuario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_subsistema - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subsistema");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subsistema", $id_subsistema))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_lugar - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_lugar");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_lugar", $id_lugar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha", $fecha))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora", $hora))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar numero_error - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("numero_error");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "numero_error", $numero_error))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar ip_origen - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("ip_origen");
			$tipo_dato->set_MaxLength(40);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "ip_origen", $ip_origen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar log_error - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("log_error");
			$tipo_dato->set_MaxLength(5);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "log_error", $log_error))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo_procedimiento - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_procedimiento");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_procedimiento", $codigo_procedimiento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar proc_almacenado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("proc_almacenado");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "proc_almacenado", $proc_almacenado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mac_maquina - tipo macaddr
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mac_maquina");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "mac_maquina", $mac_maquina))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar log_error
			$check = array ("log","error","list");
			if(!in_array($log_error,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'log_error': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarRegistroEvento";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_registro_eventos - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_registro_eventos");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_registro_eventos", $id_registro_eventos))
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
