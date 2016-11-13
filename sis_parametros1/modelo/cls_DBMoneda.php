<?php
/**
 * Nombre de la clase:	cls_DBMoneda.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_moneda
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-06 20:48:38
 */

class cls_DBMoneda
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
	 * Nombre de la función:	ListarMoneda
	 * Propósito:				Desplegar los registros de tpm_moneda
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:38
	 */
	function ListarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_moneda_sel';
		$this->codigo_procedimiento = "'PM_MONEDA_SEL'";

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
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('simbolo','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('origen','varchar');
		$this->var->add_def_cols('prioridad','int4');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarMoneda
	 * Propósito:				Contar los registros de tpm_moneda
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:38
	 */
	function ContarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_moneda_sel';
		$this->codigo_procedimiento = "'PM_MONEDA_COUNT'";

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
	 * Nombre de la función:	InsertarMoneda
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_moneda
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:38
	 */
	function InsertarMoneda($id_moneda,$nombre,$simbolo,$estado,$origen,$prioridad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_moneda_iud';
		$this->codigo_procedimiento = "'PM_MONEDA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$simbolo'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$origen'");
		$this->var->add_param($prioridad);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarMoneda
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_moneda
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:38
	 */
	function ModificarMoneda($id_moneda,$nombre,$simbolo,$estado,$origen,$prioridad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_moneda_iud';
		$this->codigo_procedimiento = "'PM_MONEDA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$simbolo'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$origen'");
		$this->var->add_param($prioridad);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarMoneda
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_moneda
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:38
	 */
	function EliminarMoneda($id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_moneda_iud';
		$this->codigo_procedimiento = "'PM_MONEDA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_moneda);
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
	 * Nombre de la función:	ValidarMoneda
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_moneda
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:38
	 */
	function ValidarMoneda($operacion_sql,$id_moneda,$nombre,$simbolo,$estado,$origen,$prioridad)
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
				//Validar id_moneda - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_moneda");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar simbolo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("simbolo");
			$tipo_dato->set_MaxLength(5);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "simbolo", $simbolo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar origen - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("origen");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "origen", $origen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar prioridad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("prioridad");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "prioridad", $prioridad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarMoneda";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar origen
			$check = array ("nacional","extranjera");
			if(!in_array($origen,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'origen': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarMoneda";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
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