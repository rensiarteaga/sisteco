<?php
/**
 * Nombre de la clase:	cls_DBEnvioAlerta.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_envio_alerta
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-31 09:09:12
 */

class cls_DBEnvioAlerta
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
	 * Nombre de la función:	ListarEnvioAlerta
	 * Propósito:				Desplegar los registros de tsg_envio_alerta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 09:09:12
	 */
	function ListarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_envio_alerta_sel';
		$this->codigo_procedimiento = "'SG_ENVALE_SEL'";

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
		$this->var->add_def_cols('id_envio_alerta','int4');
		$this->var->add_def_cols('nombre_alerta','varchar');
		$this->var->add_def_cols('prioridad','varchar');
		$this->var->add_def_cols('titulo_mensaje','varchar');
		$this->var->add_def_cols('mensaje','varchar');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEnvioAlerta
	 * Propósito:				Contar los registros de tsg_envio_alerta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 09:09:12
	 */
	function ContarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_envio_alerta_sel';
		$this->codigo_procedimiento = "'SG_ENVALE_COUNT'";

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
	 * Nombre de la función:	InsertarEnvioAlerta
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_envio_alerta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 09:09:12
	 */
	function InsertarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_envio_alerta_iud';
		$this->codigo_procedimiento = "'SG_ENVALE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_alerta'");
		$this->var->add_param("'$prioridad'");
		$this->var->add_param("'$titulo_mensaje'");
		$this->var->add_param("'$mensaje'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEnvioAlerta
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_envio_alerta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 09:09:12
	 */
	function ModificarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_envio_alerta_iud';
		$this->codigo_procedimiento = "'SG_ENVALE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_envio_alerta);
		$this->var->add_param("'$nombre_alerta'");
		$this->var->add_param("'$prioridad'");
		$this->var->add_param("'$titulo_mensaje'");
		$this->var->add_param("'$mensaje'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEnvioAlerta
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_envio_alerta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 09:09:12
	 */
	function EliminarEnvioAlerta($id_envio_alerta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_envio_alerta_iud';
		$this->codigo_procedimiento = "'SG_ENVALE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_envio_alerta);
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
	 * Nombre de la función:	ValidarEnvioAlerta
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_envio_alerta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 09:09:12
	 */
	function ValidarEnvioAlerta($operacion_sql,$id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
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
				//Validar id_envio_alerta - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_envio_alerta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_envio_alerta", $id_envio_alerta))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre_alerta - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_alerta");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_alerta", $nombre_alerta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar prioridad - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("prioridad");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "prioridad", $prioridad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar titulo_mensaje - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("titulo_mensaje");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "titulo_mensaje", $titulo_mensaje))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mensaje - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mensaje");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "mensaje", $mensaje))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_registro", $fecha_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_registro - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_registro");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_registro", $hora_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_ultima_modificacion - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ultima_modificacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ultima_modificacion", $fecha_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_ultima_modificacion - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_ultima_modificacion");
			$tipo_dato->set_MaxLength(8);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_ultima_modificacion", $hora_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar prioridad
			$check = array ("baja","normal","alta","super alta");
			if(!in_array($prioridad,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'prioridad': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarEnvioAlerta";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_envio_alerta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_envio_alerta");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_envio_alerta", $id_envio_alerta))
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