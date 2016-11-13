<?php
/**
 * Nombre de la clase:	cls_DBDosifica.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_dosifica
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-21 10:19:31
 */

 
class cls_DBDosifica
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
	 * Nombre de la función:	ListarDosifica
	 * Propósito:				Desplegar los registros de tts_dosifica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 10:19:31
	 */
	function ListarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dosifica_sel';
		$this->codigo_procedimiento = "'TS_DOSIFI_SEL'";

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
		$this->var->add_def_cols('id_dosifica','int4');
		$this->var->add_def_cols('fecha_vence','date');
		$this->var->add_def_cols('llave_activar','varchar');
		$this->var->add_def_cols('nro_autoriza','numeric');
		$this->var->add_def_cols('nro_inicial','integer');
		$this->var->add_def_cols('nro_final','integer');
		$this->var->add_def_cols('estado_dosifica','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDosifica
	 * Propósito:				Contar los registros de tts_dosifica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 10:19:31
	 */
	function ContarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dosifica_sel';
		$this->codigo_procedimiento = "'TS_DOSIFI_COUNT'";

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
	 * Nombre de la función:	InsertarDosifica
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_dosifica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 10:19:31
	 */
	function InsertarDosifica($id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dosifica_iud';
		$this->codigo_procedimiento = "'TS_DOSIFI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_vence'");
		$this->var->add_param("'$llave_activar'");
		$this->var->add_param($nro_autoriza);
		$this->var->add_param($nro_inicial);
		$this->var->add_param($nro_final);
		$this->var->add_param($estado_dosifica);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDosifica
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_dosifica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 10:19:31
	 */
	function ModificarDosifica($id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dosifica_iud';
		$this->codigo_procedimiento = "'TS_DOSIFI_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_dosifica);
		$this->var->add_param("'$fecha_vence'");
		$this->var->add_param("'$llave_activar'");
		$this->var->add_param($nro_autoriza);
		$this->var->add_param($nro_inicial);
		$this->var->add_param($nro_final);
		$this->var->add_param($estado_dosifica);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDosifica
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_dosifica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 10:19:31
	 */
	function EliminarDosifica($id_dosifica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_dosifica_iud';
		$this->codigo_procedimiento = "'TS_DOSIFI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_dosifica);
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
	 * Nombre de la función:	ValidarDosifica
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_dosifica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 10:19:31
	 */
	function ValidarDosifica($operacion_sql,$id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica)
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
				//Validar id_dosifica - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_dosifica");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_dosifica", $id_dosifica))
				{
					$this->salida = $valid->salida;
					return false;
				}
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

			//Validar llave_activar - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("llave_activar");
			$tipo_dato->set_MaxLength(256);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "llave_activar", $llave_activar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_autoriza - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_autoriza");
			$tipo_dato->set_MaxLength(983040);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "nro_autoriza", $nro_autoriza))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_inicial - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_inicial");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_inicial", $nro_inicial))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_final - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_final");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_final", $nro_final))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_dosifica - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_dosifica");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_dosifica", $estado_dosifica))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_dosifica - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_dosifica");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_dosifica", $id_dosifica))
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