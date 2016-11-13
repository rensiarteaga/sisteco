<?php
/**
 * Nombre de la Clase:	cls_DBUnidadConstructiva
 * Proposito:			Permite ejecutar la funcionalidad de la tabla tal_unidad_constructiva
 * Autor:				UNKNOW
 * Fecha creacion:		11-08-2014
 *
 */
class cls_DBUnidadConstructiva 
{
	var $salida;
	var $query;
	// Variables para la ejecuci�n de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la funci�n a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBUnidadConstructiva.php";
	
	// Matriz de par�metros de validaci�n de todas las columnas
	var $matriz_validacion = array ();
	
	// Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;
	function __construct() {
		// Carga los par�metro de validaci�n de todas las columnas
		// $this->cargar_param_valid();
		
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	function ListarUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AL_UNICONST_SEL'";
		
		$func = new cls_funciones();
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('id_unidad_constructiva', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('observaciones', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('desc_unidad_const', 'text');
		$this->var->add_def_cols('id_unidad_constructiva_fk', 'integer');
		$this->var->add_def_cols('tipo_rama', 'varchar');
		$this->var->add_def_cols('orden', 'integer');
		$this->var->add_def_cols('cod_tramo', 'varchar'); 
		 
		// Ejecuta la funcion de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llama la funcion de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ContarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_clasificacion_sel';
		$this->codigo_procedimiento = "'AL_CLASIF_COUNT'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		
		// Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		// Retorna el resultado de la ejecuci�n
		return $res;
	}
	function InsertarUnidadConstructivaArb($id_unidad_constructiva_fk,$codigo,$nombre,$descripcion,$observaciones,$estado,$orden,$cod_tramo) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_unidad_constructiva_iud';
		$this->codigo_procedimiento = "'AL_UNICONST_INS'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param("NULL");
		$this->var->add_param($id_unidad_constructiva_fk);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$estado'");
			
		$this->var->add_param($orden);//al_orden
		$this->var->add_param("'$cod_tramo'");//al_cod_tramo
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ModificarUnidadConstructivaArb($id_unidad_constructiva,$id_unidad_constructiva_fk, $codigo,$nombre,$descripcion,$observaciones,$estado,$orden,$cod_tramo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_unidad_constructiva_iud'; 
		$this->codigo_procedimiento = "'AL_UNICONST_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		//echo $id_unidad_constructiva.'</br>'.$id_unidad_constructiva_fk.'</br>'.$codigo.'</br>'.$nombre.'</br>'.$descripcion.'</br>'.$observaciones.'</br>'.$estado.'</br>'.$orden.'</br>'.$cod_tramo;exit;		
		$this->var->add_param($id_unidad_constructiva);
		$this->var->add_param($id_unidad_constructiva_fk);
		$this->var->add_param("'$codigo'"); 
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$estado'");
		$this->var->add_param($orden);//al_orden
		$this->var->add_param("'$cod_tramo'");//al_cod_tramo
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function EliminarUnidadConstructivaArb($id_unidad_constructiva) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_unidad_constructiva_iud';
		$this->codigo_procedimiento = "'AL_UNICONST_DEL'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		$this->var->add_param($id_unidad_constructiva);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//al_orden
		$this->var->add_param("NULL");//al_cod_tramo
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function ContarUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AL_UNICONSTRAM_COUNT'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		 
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		
		// Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		// Retorna el resultado de la ejecuci�n
		return $res;
	}
	function ListarUnidadConstructivaTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AL_UNICONSTRAM_SEL'";
		
		$func = new cls_funciones();
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_unidad_constructiva', 'integer');
		$this->var->add_def_cols('id_unidad_constructiva_fk', 'integer');
		$this->var->add_def_cols('desc_unidad_constructiva', 'text');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('observaciones', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
			
		// Ejecuta la funcion de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llama la funcion de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
}
?>
