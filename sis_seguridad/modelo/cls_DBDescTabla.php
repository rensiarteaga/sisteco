<?php
/**
 * Nombre de la clase:	cls_DBMetaproceso.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_metaproceso
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-26 16:42:27
 */

class cls_DBDescTabla
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
	
	
	
	function ListarDescCol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tabla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_sg_desc_tabla_sel';
		$this->codigo_procedimiento = "'SG_DESTAB_SEL'";

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
		$this->var->add_param("'$tabla'");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('descripcion','text');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
	function InsertarDescCol($tabla,$campo,$cadena_desc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_sg_desc_tabla_iud';
		$this->codigo_procedimiento = "'SG_DESCOL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$tabla=$this->var->esquema_filtro(' '.$tabla);
		$tabla=trim($tabla);
		$this->var->add_param("'$tabla'");
		$this->var->add_param("'$campo'");
		$this->var->add_param("'$cadena_desc'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function InsertarDescTabla($tabla,$cadena_desc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_sg_desc_tabla_iud';
		$this->codigo_procedimiento = "'SG_DESTAB_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$tabla=$this->var->esquema_filtro(' '.$tabla);
		$tabla=trim($tabla);
		$this->var->add_param("'$tabla'");
		$this->var->add_param("NULL");
		$this->var->add_param("'$cadena_desc'");
		
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