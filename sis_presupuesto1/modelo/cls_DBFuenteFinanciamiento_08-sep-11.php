<?php
/**
 * Nombre de la clase:	cls_DBFuenteFinanciamiento.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_fuente_financiamiento
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-15 10:55:06
 */

 
class cls_DBFuenteFinanciamiento
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
	 * Nombre de la función:	ListarFuenteFinanciamiento
	 * Propósito:				Desplegar los registros de tpr_fuente_financiamiento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function ListarFuenteFinanciamiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_fuente_financiamiento_sel';
		$this->codigo_procedimiento = "'PR_FUNFIN_SEL'";

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
		$this->var->add_def_cols('id_fuente_financiamiento','int4');
		$this->var->add_def_cols('codigo_fuente','varchar');
		$this->var->add_def_cols('denominacion','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('sigla','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo($this->query = $this->var->query);
		exit();*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarFuenteFinanciamiento
	 * Propósito:				Contar los registros de tpr_fuente_financiamiento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function ContarFuenteFinanciamiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_fuente_financiamiento_sel';
		$this->codigo_procedimiento = "'PR_FUNFIN_COUNT'";

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
	 * Nombre de la función:	InsertarFuenteFinanciamiento
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_fuente_financiamiento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function InsertarFuenteFinanciamiento($id_fuente_financiamiento,$codigo_fuente,$denominacion,$descripcion,$sigla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_fuente_financiamiento_iud';
		$this->codigo_procedimiento = "'PR_FUNFIN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		
		$this->var->add_param("'$codigo_fuente'");
		$this->var->add_param("'$denominacion'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$sigla'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarFuenteFinanciamiento
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_fuente_financiamiento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function ModificarFuenteFinanciamiento($id_fuente_financiamiento,$codigo_fuente,$denominacion,$descripcion,$sigla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_fuente_financiamiento_iud';
		$this->codigo_procedimiento = "'PR_FUNFIN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_fuente_financiamiento);
		$this->var->add_param("'$codigo_fuente'");
		$this->var->add_param("'$denominacion'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$sigla'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarFuenteFinanciamiento
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_fuente_financiamiento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function EliminarFuenteFinanciamiento($id_fuente_financiamiento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_fuente_financiamiento_iud';
		$this->codigo_procedimiento = "'PR_FUNFIN_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_fuente_financiamiento);
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
	 * Nombre de la función:	ValidarFuenteFinanciamiento
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_fuente_financiamiento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function ValidarFuenteFinanciamiento($operacion_sql,$id_fuente_financiamiento,$codigo_fuente,$denominacion,$descripcion,$sigla)
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
				//Validar id_fuente_financiamiento - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_fuente_financiamiento");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fuente_financiamiento", $id_fuente_financiamiento))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo_fuente - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_fuente");
			$tipo_dato->set_MaxLength(3);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_fuente", $codigo_fuente))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar denominacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("denominacion");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "denominacion", $denominacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(1000);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar sigla - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sigla");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "sigla", $sigla))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_fuente_financiamiento - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_fuente_financiamiento");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fuente_financiamiento", $id_fuente_financiamiento))
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