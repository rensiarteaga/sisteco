<?php
/**
 * Nombre de la Clase:	cls_DBHorario
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tkp_horario
 * Autor:				
 * Fecha creación:		09-08-2010
 *
 */
class cls_DBPptoPlanillaCuenta
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
	var $nombre_archivo = "cls_DBPptoPlanillaCuenta.php";

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
	 * Nombre de la función:	ListarHorario
	 * Propósito:				Desplegar los registros de tkp_horario en función de los parámetros del filtro
	 * Autor:					Fernando Prudencio
	 * Fecha de creación:		09-08-2010
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
	function ListarPptoPlanillaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_ppto_planilla_cuenta_sel';
		$this->codigo_procedimiento = "'KP_PTOCUE_SEL'";

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
		$this->var->add_def_cols('id_ppto_planilla_cuenta','integer');
		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('id_categoria_vacacion','integer');
		$this->var->add_def_cols('nombre_cat_vacacion','varchar');
		$this->var->add_def_cols('fecha_inicio','date');
        $this->var->add_def_cols('fecha_fin','date');
        $this->var->add_def_cols('numero_periodo','integer');
        $this->var->add_def_cols('horas_por_dia','numeric');
        $this->var->add_def_cols('hora_ini_p1','time');
        $this->var->add_def_cols('hora_fin_p1','time');
        $this->var->add_def_cols('hora_ini_p2','time');
        $this->var->add_def_cols('hora_fin_p2','time');
        $this->var->add_def_cols('tipo_periodo','varchar');
        $this->var->add_def_cols('fecha_reg','date');
        $this->var->add_def_cols('observaciones','varchar');
        $this->var->add_def_cols('repite_anualmente','varchar');
        $this->var->add_def_cols('estado_reg','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarListaHorario
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Fernando Prudencio 
	 * Fecha de creación:		09-08-2010
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
	function ContarPptoPlanillaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_horario_sel';
		$this->codigo_procedimiento = "'KP_HORARI_COUNT'";

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
	 * Nombre de la función:	EliminarHorario
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_horario
	 * Autor:				    Fernando Prudencio 
	 * Fecha de creación:		2010-08-10 09:06:56
	 */
	
	function InsertarPptoPlanillaCuenta($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$numero_periodo,$horas_por_dia,$hora_ini_p1,$hora_fin_p1,$hora_ini_p2,$hora_fin_p2,$tipo_periodo,$observaciones,$repite_anualmente,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_HORARI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_horario);
		$this->var->add_param($id_vacacion);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param($numero_periodo);
		$this->var->add_param($horas_por_dia);
		$this->var->add_param("'$hora_ini_p1'");
		$this->var->add_param("'$hora_fin_p1'");
		$this->var->add_param("'$hora_ini_p2'");
		$this->var->add_param("'$hora_fin_p2'");
		$this->var->add_param("'$tipo_periodo'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$repite_anualmente'");
		$this->var->add_param("'$estado_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarHorario
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_horario
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2010-08-10 09:06:56
	 */
	function ModificarPptoPlanillaCuenta($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$numero_periodo,$horas_por_dia,$hora_ini_p1,$hora_fin_p1,$hora_ini_p2,$hora_fin_p2,$tipo_periodo,$observaciones,$repite_anualmente,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_HORARI_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_horario);
		$this->var->add_param($id_tipo_horario);
		$this->var->add_param($id_vacacion);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param($numero_periodo);
		$this->var->add_param($horas_por_dia);
		$this->var->add_param("'$hora_ini_p1'");
		$this->var->add_param("'$hora_fin_p1'");
		$this->var->add_param("'$hora_ini_p2'");
		$this->var->add_param("'$hora_fin_p2'");
		$this->var->add_param("'$tipo_periodo'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$repite_anualmente'");
        $this->var->add_param("'$estado_reg'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarHorario
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_horario
	 * Autor:				    Fernando Prudencio 
	 * Fecha de creación:		2010-08-10 09:06:56
	 */
	function EliminarPptoPlanillaCuenta($id_horario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_HORARI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_horario);
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
	

	
}
?>