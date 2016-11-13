<?php
/**
 * Nombre de la clase:	cls_DBCajero.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_cajero
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-21 12:27:13
 */

 
class cls_DBTransferencia
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
	 * Nombre de la función:	ListarCajero
	 * Propósito:				Desplegar los registros de tts_cajero
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 12:27:13
	 */
	function ListarTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_transferencia_sel';
		$this->codigo_procedimiento = "'AF_TRANSFER_SEL'";

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
		$this->var->add_def_cols('id_transferencia','int4');
		$this->var->add_def_cols('id_empleado_origen','int4');
		$this->var->add_def_cols('desc_empleado_origen','text');
		$this->var->add_def_cols('id_empleado_destino','int4');
		$this->var->add_def_cols('desc_empleado_destino','text');
		$this->var->add_def_cols('fecha_transferencia','date');
		$this->var->add_def_cols('fecha_fin','timestamp');
		$this->var->add_def_cols('estado','varchar');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCajero
	 * Propósito:				Contar los registros de tts_cajero
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 12:27:13
	 */
	function ContarTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_transferencia_sel';
		$this->codigo_procedimiento = "'AF_TRANSFER_COUNT'";

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
	 * Nombre de la función:	InsertarCajero
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_cajero
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 12:27:13
	 */
	function CrearTransferencia($id_empleado_origen,$id_empleado_destino,$fecha_transferencia,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_transferencia_iud';
		$this->codigo_procedimiento = "'AF_TRANSFER_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado_origen);
		$this->var->add_param($id_empleado_destino);
		$this->var->add_param("'$fecha_transferencia'");
		$this->var->add_param("'$estado'");
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCajero
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_cajero
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 12:27:13
	 */
	function ModificarTransferenciaEmpleado($id_transferencia,$id_empleado_origen,$id_empleado_destino,$fecha_transferencia,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_transferencia_iud';
		$this->codigo_procedimiento = "'AF_TRANSFER_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_transferencia);
		$this->var->add_param($id_empleado_origen);
		$this->var->add_param($id_empleado_destino);
		$this->var->add_param("'$fecha_transferencia'");
		$this->var->add_param("'$estado'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	
	/**
	 * Nombre de la función:	EliminarCajero
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_cajero
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 12:27:13
	 */
	function EliminarTransferenciaEmpleado($id_transferencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_transferencia_iud';
		$this->codigo_procedimiento = "'AF_TRANSFER_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_transferencia);
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
	 * Nombre de la función:	ValidarCajero
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_cajero
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 12:27:13
	 */
	function ValidarCajero($operacion_sql,$id_cajero,$id_empleado,$fecha_inicio,$fecha_final,$estado_cajero,$id_caja)
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
				//Validar id_cajero - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cajero");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cajero", $id_cajero))
				{	$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{	$this->salida = $valid->salida;
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

			//Validar fecha_final - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_final");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_final", $fecha_final))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_cajero - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_cajero");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_cajero", $estado_cajero))
			{
				$this->salida = $valid->salida;
				return false;
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
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cajero - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cajero");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cajero", $id_cajero))
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