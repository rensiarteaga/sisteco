<?php
/**
 * Nombre de la Clase:	cls_DBActivoFijoEmpleado
 * Propósito:			Permite ejecutar la funcionalidad de la tabla taf_sub_tipo_activo
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		12-06-2007
 *
 */
class cls_DBActivoFijoEmpleado
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
	var $nombre_archivo = "cls_DBActivoFijoEmpleado.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los parámetro de validación de todas las columnas
		$this->cargar_param_valid();

		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}


	/**
	 * Nombre de la función:	ListarActivoFijoEmpleado
	 * Propósito:				Desplegar los registros de taf_activo_fijo_empleado en función de los parámetros del filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado_consultas';
		$this->codigo_procedimiento = "'AF_AF_EMPL_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_activo_fijo_empleado','integer');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('desc_activo_fijo','varchar');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_deposito','integer');
		$this->var->add_def_cols('nombre_deposito','varchar');
		$this->var->add_def_cols('fecha_asig','date');
		$this->var->add_def_cols('descripcion_larga','varchar');
		$this->var->add_def_cols('codigo','varchar');	

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
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function ListarActivoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado_consultas';
		$this->codigo_procedimiento = "'AF_TRANS_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',"'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',"'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',"'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',"'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',"'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		//$this->var->add_def_cols('id_activo_fijo_empleado','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion_larga','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('desc_empleado_anterior','text');
		$this->var->add_def_cols('desc_unidad_organizacional1','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function ListarActivoTransferenciaVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado_consultas';
		$this->codigo_procedimiento = "'AF_TRANS_VIST_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',"'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',"'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',"'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',"'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',"'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('desc_estado_funcional','varchar');
		$this->var->add_def_cols('fecha_compra','text');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('desc_empleado_anterior','text');
		$this->var->add_def_cols('desc_unidad_organizacional1','varchar');
		$this->var->add_def_cols('empleado','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}



	/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * 
	 * Nombre de la función:	ContarListaActivoFijoEmpleado
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarListaActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado_consultas';
		$this->codigo_procedimiento = "'AF_AF_EMPL_SEL_COUNT'";

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
	 * Nombre de la función:	CrearActivoFijoEmpleado
	 * Propósito:				Permite ejecutar la función de inserción de la taf_activo_fijo_empleado de la base de datos,
	 * 							con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_activo_fijo_empleado
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_activo_fijo
	 * @param unknown_type $id_empleado
	 * @return unknown
	 */
	function CrearActivoFijoEmpleado($id_activo_fijo_empleado, $fecha_reg, $estado, $id_activo_fijo, $id_empleado, $fecha_asig)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado';
		$this->codigo_procedimiento = "'AF_AF_EMPL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_activo_fijo_empleado
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param($id_empleado);//id_empleado
		$this->var->add_param("NULL");//id_empleado_destino
		$this->var->add_param("'$fecha_asig'");//id_empleado_destino
		$this->var->add_param("NULL");//id_transferencia

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarActivoFijoEmpleado
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_activo_fijo_empleado de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_activo_fijo_empleado
	 * @return unknown
	 */
	function  EliminarActivoFijoEmpleado($id_activo_fijo_empleado)
	{

		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado';
		$this->codigo_procedimiento = "'AF_AF_EMPL_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_activo_fijo_empleado);//id_activo_fijo_empleado
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//estado
		$this->var->add_param("NULL");//id_activo_fijo
		$this->var->add_param("NULL");//id_empleado
		$this->var->add_param("NULL");//id_empleado_destino
		$this->var->add_param("NULL");//fecha_asig
		$this->var->add_param("NULL");//id_transferencia

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;


		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarActivoFijoEmpleado
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_activo_fijo_empleado
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_activo_fijo_empleado
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_activo_fijo
	 * @param unknown_type $id_empleado
	 * @return unknown
	 */
	function  ModificarActivoFijoEmpleado($id_activo_fijo_empleado, $fecha_reg, $estado, $id_activo_fijo, $id_empleado, $fecha_asig)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado';
		$this->codigo_procedimiento = "'AF_AF_EMPL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_activo_fijo_empleado);//id_activo_fijo_empleado
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param($id_empleado);//id_empleado
		$this->var->add_param("NULL");//id_empleado_destino
		$this->var->add_param("'$fecha_asig'");//fecha_asig
		$this->var->add_param("NULL");//id_transferencia

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	///////////////////////////////////////////////////////////////////////////////////
	/*function TransferirActivoFijoEmpleado($id_activo_fijo, $id_empleado, $id_empleado_destino, $id_activo_fijo_empleado)
	{
	$this->salida = "";
	$this->nombre_funcion = 'f_taf_activo_fijo_empleado';
	$this->codigo_procedimiento = "'AF_AF_TRANSF'";

	//Instancia la clase midlle para la ejecución de la función de la BD
	$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	//Carga parámetros específicos (no incluyen los parámetros fijos)

	//aqui falta ver que parrametros se le va mandar a la funcion de la BD


	$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
	$this->var->add_param($id_activo_fijo_empleado);//id_act_fij_emp
	$this->var->add_param("NULL");//id_act_fij_emp
	$this->var->add_param("NULL");//id_act_fij_emp
	$this->var->add_param($id_activo_fijo);//id_activo_fijo
	$this->var->add_param($id_empleado);//id_activo_fijo_destino
	$this->var->add_param($id_empleado_destino);//id_activo_fijo_destino
	$this->var->add_param("NULL");//fecha_asig

	//Ejecuta la función
	$res = $this->var->exec_non_query();

	//Obtiene el array de salida de la función y retorna el resultado de la ejecución
	$this->salida = $this->var->salida;

	//Obtiene la cadena con que se llamó a la función de postgres
	$this->query = $this->var->query;

	return $res;
	}*/

	//RCM: 30/10/2008
	function TransferirActivoFijoEmpleado($id_activo_fijo_empleado,$id_empleado_destino,$fecha_asig,$id_transferencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado';
		$this->codigo_procedimiento = "'AF_AF_TRANSF'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		///*****************************/
		//aqui falta ver que parrametros se le va mandar a la funcion de la BD

		/////////*////////////////////
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_activo_fijo_empleado);//id_act_fij_emp
		$this->var->add_param("NULL");//id_act_fij_emp
		$this->var->add_param("NULL");//id_act_fij_emp
		$this->var->add_param("NULL");//id_activo_fijo
		$this->var->add_param("NULL");//id_activo_fijo_destino
		$this->var->add_param($id_empleado_destino);//id_activo_fijo_destino
		$this->var->add_param("'$fecha_asig'");//fecha_asig
		$this->var->add_param("$id_transferencia");//fecha_asig

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}


	//RCM: 31/10/2008
	function  EliminarTransferencia($id_activo_fijo_empleado)
	{

		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado';
		$this->codigo_procedimiento = "'AF_TRANSF_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_activo_fijo_empleado);//id_activo_fijo_empleado
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//estado
		$this->var->add_param("NULL");//id_activo_fijo
		$this->var->add_param("NULL");//id_empleado
		$this->var->add_param("NULL");//id_empleado_destino
		$this->var->add_param("NULL");//fecha_asig

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;


		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	////////////////////REPORTE ASIGNACION RESPONSABLES////////////////////////////////////////////////////////

function ListarAsignacionResponsableActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado_consultas';
		$this->codigo_procedimiento = "'AF_RESPAF'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',"'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',"'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',"'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',"'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',"'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('descripcion_larga','varchar');
		$this->var->add_def_cols('ubicacion_fisica','varchar');
		$this->var->add_def_cols('fecha_asig','text');
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	function ListarAsignacionResponsable($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_empleado_consultas';
		$this->codigo_procedimiento = "'AF_RESPON'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',"'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',"'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',"'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',"'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',"'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('cargo','text');
		$this->var->add_def_cols('uni_org','text');
		$this->var->add_def_cols('resp_af','text');
        
				               
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Nombre de la función:	ValidarActivoFijoEmpleado
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha creación:			12-06-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_activo_fijo_empleado
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_activo_fijo
	 * @param unknown_type $id_empleado
	 * @return unknown
	 */
	function ValidarActivoFijoEmpleado($operacion_sql, $id_activo_fijo_empleado, $fecha_reg, $estado, $id_activo_fijo, $id_empleado, $fecha_asig)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)
		$this->salida = "";
		$valid = new cls_validacion_serv();
		//Ejecuta la validación por el tipo de operación
		switch ($operacion_sql) {
			case 'insert':
				
				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla
				if(!$valid->verifica_dato($this->matriz_validacion[1], "fecha_reg", $fecha_reg))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[2], "estado", $estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
				/*if(!$valid->verifica_dato($this->matriz_validacion[3], "id_activo_fijo", $id_activo_fijo))
				{
					$this->salida = $valid->salida;
					return false;
				}*/
				/*if(!$valid->verifica_dato($this->matriz_validacion[4], "id_empleado", $id_empleado))
				{
					$this->salida = $valid->salida;
					return false;
				}*/
				if(!$valid->verifica_dato($this->matriz_validacion[5], "fecha_asig", $fecha_asig))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validación de reglas de datos
				$def_estados = array ("activo", "inactivo","eliminado");
				if(!in_array($estado,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'estado': El valor no está dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}

				//Validación exitosa
				return true;
				break;

			case 'update':
				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla

				if(!$valid->verifica_dato($this->matriz_validacion[0], "id_activo_fijo_empleado", $id_activo_fijo_empleado))
				{	$this->salida = $valid->salida;
				return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[1], "fecha_reg", $fecha_reg))
				{	$this->salida = $valid->salida;
				return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[2], "estado", $estado))
				{	$this->salida = $valid->salida;
				return false;
				}
				/*if(!$valid->verifica_dato($this->matriz_validacion[3], "id_activo_fijo", $id_activo_fijo))
				{	$this->salida = $valid->salida;
				return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[4], "id_empleado", $id_empleado))
				{	$this->salida = $valid->salida;
				return false;
				}*/
				if(!$valid->verifica_dato($this->matriz_validacion[5], "fecha_asig", $fecha_asig))
				{
					$this->salida = $valid->salida;
					return false;
				}



				//Validación de reglas de datos
				$def_estados = array ("activo", "inactivo","eliminado");
				if(!in_array($estado,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'estado': El valor no está dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}

				//Validación exitosa
				return true;
				break;
			case 'delete':
				break;
			default:
				return false;
				break;
		}

	}

	function cargar_param_valid()
	{
		$this->matriz_validacion[0] = array();
		$this->matriz_validacion[0]['Columna'] = "id_activo_fijo_empleado";
		$this->matriz_validacion[0]['allowBlank'] = "false";
		$this->matriz_validacion[0]['maxLength'] = 15;
		$this->matriz_validacion[0]['minLength'] = 0;
		$this->matriz_validacion[0]['SelectOnFocus'] = "true";
		$this->matriz_validacion[0]['vtype'] = "alphanum";
		$this->matriz_validacion[0]['dataType'] = "entero";
		$this->matriz_validacion[0]['width'] = "";
		$this->matriz_validacion[0]['grow'] = "";

		$this->matriz_validacion[1] = array();
		$this->matriz_validacion[1]['Columna'] = "fecha_reg";
		$this->matriz_validacion[1]['allowBlank'] = "true";
		$this->matriz_validacion[1]['maxLength'] = 10;
		$this->matriz_validacion[1]['minLength'] = 0;
		$this->matriz_validacion[1]['SelectOnFocus'] = "true";
		$this->matriz_validacion[1]['vtype'] = "alphaLatino";
		$this->matriz_validacion[1]['dataType'] = "fecha";
		$this->matriz_validacion[1]['width'] = "";
		$this->matriz_validacion[1]['grow'] = "";

		$this->matriz_validacion[2] = array();
		$this->matriz_validacion[2]['Columna'] = "estado";
		$this->matriz_validacion[2]['allowBlank'] = "false";
		$this->matriz_validacion[2]['maxLength'] = 10;
		$this->matriz_validacion[2]['minLength'] = 0;
		$this->matriz_validacion[2]['SelectOnFocus'] = "true";
		$this->matriz_validacion[2]['vtype'] = "alphaLatino";
		$this->matriz_validacion[2]['dataType'] = "texto";
		$this->matriz_validacion[2]['width'] = "";
		$this->matriz_validacion[2]['grow'] = "";

		$this->matriz_validacion[3] = array();
		$this->matriz_validacion[3]['Columna'] = "id_activo_fijo";
		$this->matriz_validacion[3]['allowBlank'] = "false";
		$this->matriz_validacion[3]['maxLength'] = 15;
		$this->matriz_validacion[3]['minLength'] = 0;
		$this->matriz_validacion[3]['SelectOnFocus'] = "false";
		$this->matriz_validacion[3]['vtype'] = "alphaLatino";
		$this->matriz_validacion[3]['dataType'] = "integer";
		$this->matriz_validacion[3]['width'] = "";
		$this->matriz_validacion[3]['grow'] = "";

		$this->matriz_validacion[4] = array();
		$this->matriz_validacion[4]['Columna'] = "id_empleado";
		$this->matriz_validacion[4]['allowBlank'] = "false";
		$this->matriz_validacion[4]['maxLength'] = 15;
		$this->matriz_validacion[4]['minLength'] = 0;
		$this->matriz_validacion[4]['SelectOnFocus'] = "false";
		$this->matriz_validacion[4]['vtype'] = "alphaLatino";
		$this->matriz_validacion[4]['dataType'] = "integer";
		$this->matriz_validacion[4]['width'] = "";
		$this->matriz_validacion[4]['grow'] = "";

		$this->matriz_validacion[5] = array();
		$this->matriz_validacion[5]['Columna'] = "fecha_asig";
		$this->matriz_validacion[5]['allowBlank'] = "true";
		$this->matriz_validacion[5]['maxLength'] = 10;
		$this->matriz_validacion[5]['minLength'] = 0;
		$this->matriz_validacion[5]['SelectOnFocus'] = "true";
		$this->matriz_validacion[5]['vtype'] = "alphaLatino";
		$this->matriz_validacion[5]['dataType'] = "fecha";
		$this->matriz_validacion[5]['width'] = "";
		$this->matriz_validacion[5]['grow'] = "";
	}

}?>