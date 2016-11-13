<?php
/**
 * Nombre de la clase:	cls_DBUnidadOrganizacional.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla kard.tkp_unidad_organizacional
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-07 15:46:18
 */
class cls_DBUnidadOrganizacionalDiagrama
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
	 * ***********************************************************
	 * Para el Mannejo de Árboles
	 * 
	 * 
	 ************************************************************* 
	 */
	
	/**
	 * Nombre de la función:	ListarUnidadOrganizacionalDiagrama
	 * Propósito:				Desplegar los registros de tkp_unidad_organizacional
	 * Autor:				    avq
	 * Fecha de creación:		17/08/2010
	 */
	/**
	 * Nombre de la función:	ListarUnidadOrganizacional
	 * Propósito:				Desplegar los registros de tkp_estructura_organizacional
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2010
	 */
	function ListarUnidadOrganizacionalDiagrama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$v_id,$v_crit_fil)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_organigrama_recursivo_diagrama';
		//$this->nombre_funcion = 'kard.f_tkp_organigrama_recursivo_inicia';
		$this->codigo_procedimiento = "'KP_UNIORG_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

	
		$this->var->add_param("$v_id");//raiz
		//$this->var->add_param(1);//raiz
		//Carga la definición de columnas con sus tipo
		
		$this->var->add_param("'$v_crit_fil'");//raiz
		$this->var->add_def_cols('niveles','varchar');
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('centro','varchar');
		$this->var->add_def_cols('cargo_individual','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_nivel_organizacional','integer');
		$this->var->add_def_cols('numero_nivel','integer');
		$this->var->add_def_cols('nombre_nivel','varchar');
		$this->var->add_def_cols('id_estructura_organizacional','integer');
		$this->var->add_def_cols('relacion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_padre','integer');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('importe_max_apro','numeric');
		$this->var->add_def_cols('importe_max_pre','numeric');
		$this->var->add_def_cols('funcionarios','varchar');
		$this->var->add_def_cols('resaltar','varchar');
	
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		$this->query = $this->var->query;
		//echo "-----".$this->query; exit;
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		
	
		return $res;
	}
	
	
	
}?>