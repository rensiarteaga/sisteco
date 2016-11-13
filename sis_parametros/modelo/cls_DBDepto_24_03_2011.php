<?php
/**
 * Nombre de la clase:	cls_DBDepto.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_depto
 * Autor:				(autogenerado)
 * Fecha creación:		2009-01-23 10:58:13
 */

 
class cls_DBDepto
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
	 * Nombre de la función:	ListarDepartamento
	 * Propósito:				Desplegar los registros de tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ListarDepartamento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_sel';
		$this->codigo_procedimiento = "'PM_PM_DEPTOS_SEL'";

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
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nombre_corto','varchar');
		$this->var->add_def_cols('nombre_largo','text');
		$this->var->add_def_cols('despliegue_rep','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDepartamento
	 * Propósito:				Contar los registros de tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ContarDepartamento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_sel';
		$this->codigo_procedimiento = "'PM_PM_DEPTOS_COUNT'";

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
	 * Nombre de la función:	InsertarDepartamento
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function InsertarDepartamento($id_depto,$codigo_depto,$nombre_depto,$estado,$id_subsistema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_iud';
		$this->codigo_procedimiento = "'PM_PM_DEPTOS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo_depto'");
		$this->var->add_param("'$nombre_depto'");
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_subsistema);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDepartamento
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ModificarDepartamento($id_depto,$codigo_depto,$nombre_depto,$estado,$id_subsistema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_iud';
		$this->codigo_procedimiento = "'PM_PM_DEPTOS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto);
		$this->var->add_param("'$codigo_depto'");
		$this->var->add_param("'$nombre_depto'");
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_subsistema);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDepartamento
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function EliminarDepartamento($id_depto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_iud';
		$this->codigo_procedimiento = "'PM_PM_DEPTOS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto);
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
	 * Nombre de la función:	ListarDepartamentoEPUsuario
	 * Propósito:				Desplegar los registros de tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ListarDepartamentoEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_sel';
		$this->codigo_procedimiento = "'PM_DPTOEP_SEL'";

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
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('estado','varchar');

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
	 * Nombre de la función:	ContarDepartamentoEPUsuario
	 * Propósito:				Contar los registros de tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ContarDepartamentoEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_sel';
		$this->codigo_procedimiento = "'PM_DPTOEP_COUNT'";

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
	 * Nombre de la función:	ValidarDepartamento
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ValidarDepartamento($operacion_sql,$id_depto,$codigo_depto,$nombre_depto,$estado)
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
				//Validar id_depto - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_depto");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo_depto - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_depto");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_depto", $codigo_depto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_depto - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_depto");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_depto", $nombre_depto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_depto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto))
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