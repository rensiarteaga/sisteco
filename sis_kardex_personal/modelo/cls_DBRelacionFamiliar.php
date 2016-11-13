<?php
/**
 * Nombre de la Clase:	cls_DBRelacionFamiliar
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tkp_RelacionFamiliar
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		11-08-2010
 *
 */
class cls_DBRelacionFamiliar
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
	var $nombre_archivo = "cls_DBRelacionFamiliar.php";

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
	 * Nombre de la función:	ListarRelacionFamiliar
	 * Propósito:				Desplegar los registros de tkp_RelacionFamiliar en función de los parámetros del filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 *
	 */
	function ListarRelacionFamiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_relacion_familiar_sel';
		$this->codigo_procedimiento = "'KP_RELFAM_SEL'";

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
		$this->var->add_def_cols('id_relacion_familiar','integer');
		$this->var->add_def_cols('id_persona','integer');
		$this->var->add_def_cols('id_empleado','integer');$this->var->add_def_cols('id_institucion','integer');
		$this->var->add_def_cols('relacion','varchar');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('desc_institucion','varchar');
		
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarRelacionFamiliar
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 *
	 */
	function ContarRelacionFamiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_relacion_familiar_sel';
		$this->codigo_procedimiento = "'KP_RELFAM_COUNT'";

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
	 * Nombre de la función:	InsertarRelacionFamiliar
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_RelacionFamiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		11-08-2010
	 * Descripción:             Se añadio los atributos fecha_reg, estado_reg
	
	 */
	function InsertarRelacionFamiliar($id_relacion_familiar,$id_empleado,$id_persona,$id_institucion,$relacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_relacion_familiar_iud';
		$this->codigo_procedimiento = "'KP_RELFAM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_persona);
		$this->var->add_param($id_institucion);
		
		$this->var->add_param("'$relacion'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRelacionFamiliar
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_RelacionFamiliar
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function ModificarRelacionFamiliar($id_relacion_familiar,$id_empleado,$id_persona,$id_institucion,$relacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_relacion_familiar_iud';
		$this->codigo_procedimiento = "'KP_RELFAM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_relacion_familiar);
		
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_persona);
		$this->var->add_param($id_institucion);
		
		$this->var->add_param("'$relacion'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRelacionFamiliar
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_RelacionFamiliar
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function EliminarRelacionFamiliar($id_relacion_familiar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_relacion_familiar_iud';
		$this->codigo_procedimiento = "'KP_RELFAM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_relacion_familiar);
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
	
}
?>