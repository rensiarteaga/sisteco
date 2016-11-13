<?php
/**
 * Nombre de la Clase:	cls_DBPlanillaTrimestral
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tkp_PlanillaTrimestral
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		11-08-2010
 *
 */
class cls_DBPlanillaTrimestral
{
	//Variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;
	
	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecución de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la función a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBPlanillaTrimestral.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los parámetro de validación de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarPlanillaTrimestral
	 * Propósito:				Desplegar los registros de tkp_PlanillaTrimestral en función de los parámetros del filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 *
	 */
	function ListarPlanillaTrimestral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_trimestral_sel';
		$this->codigo_procedimiento = "'KP_PLATRI_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_planilla_trimestral','integer');
		$this->var->add_def_cols('ci_firma','varchar');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('firma','varchar');
		$this->var->add_def_cols('inc_permanente_p','integer');
		$this->var->add_def_cols('inc_permanente_t','integer');
		$this->var->add_def_cols('inc_temporal','integer');
		$this->var->add_def_cols('muerte','integer');
		$this->var->add_def_cols('num_accidentes','integer');
		$this->var->add_def_cols('num_enfermedad_trabajo','integer');
		$this->var->add_def_cols('num_ingresos_trim','integer');
		$this->var->add_def_cols('num_retiros_trim','integer');
		$this->var->add_def_cols('num_turnos_trabajo','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarPlanillaTrimestral
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 *
	 */
	function ContarPlanillaTrimestral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_trimestral_sel';
		$this->codigo_procedimiento = "'KP_PLATRI_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

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
	 * Nombre de la función:	InsertarPlanillaTrimestral
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_PlanillaTrimestral
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		11-08-2010
	 * Descripción:             Se añadio los atributos fecha_reg, estado_reg
	
	 */
	function InsertarPlanillaTrimestral($id_planilla_trimestral,$ci_firma,$fecha,$firma,$inc_permanente_p,$inc_permanente_t,$inc_temporal,$muerte,$num_accidentes,$num_enfermedad_trabajo,$num_ingresos_trim,$num_retiros_trim,$num_turnos_trabajo, $id_planilla,$lugar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_trimestral_iud';
		$this->codigo_procedimiento = "'KP_PLATRI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$ci_firma'");
		$this->var->add_param("'$fecha'");
		$this->var->add_param("'$firma'");
		$this->var->add_param($inc_permanente_p);
		$this->var->add_param($inc_permanente_t);
		$this->var->add_param($inc_temporal);
		$this->var->add_param($muerte);
		$this->var->add_param($num_accidentes);
		$this->var->add_param($num_enfermedad_trabajo);
		$this->var->add_param($num_ingresos_trim);
		$this->var->add_param($num_retiros_trim);
		$this->var->add_param($num_turnos_trabajo);
		$this->var->add_param($id_planilla);
		$this->var->add_param("'$lugar'");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo $this->query; exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPlanillaTrimestral
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_PlanillaTrimestral
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function ModificarPlanillaTrimestral($id_planilla_trimestral,$ci_firma,$fecha,$firma,$inc_permanente_p,$inc_permanente_t,$inc_temporal,$muerte,$num_accidentes,$num_enfermedad_trabajo,$num_ingresos_trim,$num_retiros_trim,$num_turnos_trabajo,$id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_trimestral_iud';
		$this->codigo_procedimiento = "'KP_PLATRI_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla_trimestral);
		$this->var->add_param("'$ci_firma'");
		$this->var->add_param("'$fecha'");
		$this->var->add_param("'$firma'");
		$this->var->add_param($inc_permanente_p);
		$this->var->add_param($inc_permanente_t);
		$this->var->add_param($inc_temporal);
		$this->var->add_param($muerte);
		$this->var->add_param($num_accidentes);
		$this->var->add_param($num_enfermedad_trabajo);
		$this->var->add_param($num_ingresos_trim);
		$this->var->add_param($num_retiros_trim);
		$this->var->add_param($num_turnos_trabajo);
		$this->var->add_param($id_planilla);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPlanillaTrimestral
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_PlanillaTrimestral
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function EliminarPlanillaTrimestral($id_planilla_trimestral)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_trimestral_iud';
		$this->codigo_procedimiento = "'KP_PLATRI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla_trimestral);
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
	 * Nombre de la función:	ValidarPlanillaTrimestral
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_PlanillaTrimestral
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function ValidarPlanillaTrimestral($operacion_sql,$id_planilla_trimestral,$ci_firma,$fecha,$firma,$inc_permanente_p,$inc_permanente_t,$inc_temporal,$muerte,$num_accidentes,$num_enfermedad_trabajo,$num_ingresos_trim,$num_retiros_trim,$num_turnos_trabajo)
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
				//Validar id_PlanillaTrimestral - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_planilla_trimestral");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_planilla_trimestral", $id_planilla_trimestral))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_planilla_trimestral");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_planilla_trimestral", $id_planilla_trimestral))
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
	
}
?>