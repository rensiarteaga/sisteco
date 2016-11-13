<?php
/**
 * Nombre de la clase:	cls_DBTipoDocInstitucion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_tipo_doc_institucion
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-06 21:03:56
 */

class cls_DBTipoDocInstitucion
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
	 * Nombre de la función:	ListarTipoDocInstitucion
	 * Propósito:				Desplegar los registros de tpm_tipo_doc_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:03:56
	 */
	function ListarTipoDocInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_doc_institucion_sel';
		$this->codigo_procedimiento = "'PM_TIDOINS_SEL'";

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
		$this->var->add_def_cols('id_tipo_doc_institucion','int4');
		$this->var->add_def_cols('nombre_tipo_doc','varchar');
		$this->var->add_def_cols('observacion','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoDocInstitucion
	 * Propósito:				Contar los registros de tpm_tipo_doc_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:03:56
	 */
	function ContarTipoDocInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_doc_institucion_sel';
		$this->codigo_procedimiento = "'PM_TIDOINS_COUNT'";

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
	 * Nombre de la función:	InsertarTipoDocInstitucion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_tipo_doc_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:03:56
	 */
	function InsertarTipoDocInstitucion($id_tipo_doc_institucion,$nombre_tipo_doc,$observacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_doc_institucion_iud';
		$this->codigo_procedimiento = "'PM_TIDOINS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_tipo_doc'");
		$this->var->add_param("'$observacion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoDocInstitucion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_tipo_doc_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:03:56
	 */
	function ModificarTipoDocInstitucion($id_tipo_doc_institucion,$nombre_tipo_doc,$observacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_doc_institucion_iud';
		$this->codigo_procedimiento = "'PM_TIDOINS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_doc_institucion);
		$this->var->add_param("'$nombre_tipo_doc'");
		$this->var->add_param("'$observacion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoDocInstitucion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_tipo_doc_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:03:56
	 */
	function EliminarTipoDocInstitucion($id_tipo_doc_institucion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_doc_institucion_iud';
		$this->codigo_procedimiento = "'PM_TIDOINS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_doc_institucion);
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
	 * Nombre de la función:	ValidarTipoDocInstitucion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_tipo_doc_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:03:56
	 */
	function ValidarTipoDocInstitucion($operacion_sql,$id_tipo_doc_institucion,$nombre_tipo_doc,$observacion)
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
				//Validar id_tipo_doc_institucion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_doc_institucion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_doc_institucion", $id_tipo_doc_institucion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre_tipo_doc - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_tipo_doc");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_tipo_doc", $nombre_tipo_doc))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observacion");
			$tipo_dato->set_MaxLength(500);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observacion", $observacion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_doc_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_doc_institucion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_doc_institucion", $id_tipo_doc_institucion))
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