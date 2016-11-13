<?php
/**
 * Nombre de la Clase:	cls_DBActivoFijoEmpleado
 * Propósito:			Permite ejecutar la funcionalidad de la tabla taf_sub_tipo_activo
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		12-06-2007
 *
 */
class cls_DBActivacionGestion
{
	var $salida;

	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecución de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la función a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBActivacionGestion.php";

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

	
	
	/*--------------------------------------- CABECERA REPORTE DEPRECIACION ------------------------------*/
	
	/*------------------------------- LISTA REPORTE DEPRECIACION DETALLE ------------------------------*/
	/*----------------------------- Adicionado por Marcos A. Flores Valda -----------------------------*/

	function Cabecera_rep_act_gestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$gestion, $id_tipo_activo, $id_sub_tipo_activo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_rep_activacion_gestion';
		$this->codigo_procedimiento = "'AF_RDD_CABECERA'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($func->iif($id_activo_fijo == '',"'%'","'$id_activo_fijo'"));//id_actividad
		$this->var->add_param($func->iif($gestion == '',"'%'","'$gestion'"));//gestion
		$this->var->add_param($func->iif($id_tipo_activo == '',"'%'","'$id_tipo_activo'"));//gestion
		$this->var->add_param($func->iif($id_sub_tipo_activo == '',"'%'","'$id_sub_tipo_activo'"));//gestion
		
		
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_ini_dep','date');
  		//$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		//pfrppa.id_fina_regi_prog_proy_acti		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();		

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this-query; exit; 	
		return $res;
	}
	
	/*--------------------------------------- CUERPO REPORTE DEPRECIACION DETALLE ------------------------------*/
			 																	  	
	function Cuerpo_rep_act_gestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$gestion, $id_tipo_activo, $id_sub_tipo_activo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_rep_activacion_gestion';
		$this->codigo_procedimiento = "'AF_RDD_CUERPO'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($func->iif($id_activo_fijo == '',"'%'","'$id_activo_fijo'"));//id_actividad
		$this->var->add_param($func->iif($gestion == '',"'%'","'$gestion'"));//gestion
		$this->var->add_param($func->iif($id_tipo_activo == '',"'%'","'$id_tipo_activo'"));//gestion
		$this->var->add_param($func->iif($id_sub_tipo_activo == '',"'%'","'$id_sub_tipo_activo'"));//gestion
		
		//$this->var->add_param($id_activo_fijo);//id_activo_fijo
		//$this->var->add_param($gestion);//gestion
		//$this->var->add_param($func->iif($fecha_hasta == '',"'%'","'$fecha_hasta'"));//fecha_hasta
				
		//Carga la definiciï¿½n de columnas con sus tipos de datos	
		
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_ini_dep','date');
		$this->var->add_def_cols('codigo_finanaciador','varchar');
        $this->var->add_def_cols('codigo_regional','varchar');
        $this->var->add_def_cols('codigo_programa','varchar');
        $this->var->add_def_cols('codigo_proyecto','varchar'); 
		$this->var->add_def_cols('codigo_actividad','varchar'); 
		$this->var->add_def_cols('codigo_tipo','varchar'); 
		$this->var->add_def_cols('codigo_subtipo','varchar'); 
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();		

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;	

		//echo $this->query; exit;
			
		return $res;
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