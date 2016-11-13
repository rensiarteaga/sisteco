<?php
/**
 * Nombre de la clase:	cls_DBSupervisor.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_supervisor
 * Autor:				RCM
 * Fecha creación:		02/07/2008
 */

class cls_DBSupervisor
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
	 * Nombre de la función:	ListarSupervisor
	 * Propósito:				Desplegar los registros de tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 10:54:54
	 */
	function ListarSupervisor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supervisor_sel';
		$this->codigo_procedimiento = "'AL_SUPERV_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_supervisor','integer');
		$this->var->add_def_cols('id_persona','integer');
		$this->var->add_def_cols('nombre_superv','text');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('fecha_reg','date');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSupervisor
	 * Propósito:				Contar los registros de tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 10:54:54
	 */
	function ContarSupervisor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supervisor_sel';
		$this->codigo_procedimiento = "'AL_SUPERV_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		
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
	 * Nombre de la función:	InsertarSupervisor
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 10:54:54
	 */
	function InsertarSupervisor($id_supervisor,$id_persona,$fecha_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supervisor_iud';
		$this->codigo_procedimiento = "'AL_SUPERV_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_persona");
		$this->var->add_param("'$fecha_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarSupervisor
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 10:54:54
	 */
	function ModificarSupervisor($id_supervisor,$id_persona,$fecha_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supervisor_iud';
		$this->codigo_procedimiento = "'AL_SUPERV_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_supervisor);
		$this->var->add_param("$id_persona");
		$this->var->add_param("'$fecha_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarSupervisor
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 10:54:54
	 */
	function EliminarSupervisor($id_supervisor)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supervisor_iud';
		$this->codigo_procedimiento = "'AL_SUPERV_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_supervisor);
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
	 * Nombre de la función:	ValidarSupervisor
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 10:54:54
	 */
	function ValidarSupervisor($operacion_sql,$id_supervisor,$id_persona,$fecha_reg)
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
				//Validar id_estante - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_supervisor");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_supervisor", $id_supervisor))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_persona - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_persona");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_persona", $id_persona))
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
			
			
				//Validación exitosa
				return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_supervisor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_supervisor");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_supervisor", $id_supervisor))
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