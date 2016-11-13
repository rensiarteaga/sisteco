<?php
/**
 * Nombre de la clase:	cls_DBRepEmpleado.php
 * Propï¿½sito:			Permite obtener listados para reportes de Empleados
 * Autor:				avillegas
 * Fecha creaciï¿½n:		13/06/2011
 */

 
class cls_DBRepEmpleadoAFP
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
	 * Nombre de la función:	RepEmpleadoAFP's
	 * Propï¿½sito:				Desplegar los registros de tkp_empleado
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		13/06/2011
	 */
	function RepEmpleadoAFPsDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{    
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_afp_sel';
		$this->codigo_procedimiento = "'KP_EMPAFP_REP'";

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

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		
        $this->var->add_def_cols('doc_id',' VARCHAR'); 
        $this->var->add_def_cols('tipo',' VARCHAR'); 
        $this->var->add_def_cols('nro_afp',' VARCHAR');
        $this->var->add_def_cols('nombre_completo',' TEXT'); 
        $this->var->add_def_cols('dias_cot',' NUMERIC(18,0)'); 
        $this->var->add_def_cols('a',' varchar');
        $this->var->add_def_cols('b','VARCHAR');
        $this->var->add_def_cols('valor',' NUMERIC'); 
        $this->var->add_def_cols('nombre_afp',' VARCHAR'); 
        $this->var->add_def_cols('id_afp','integer'); 
		$this->var->add_def_cols('sw_jub55','text'); 
		$this->var->add_def_cols('may65','text'); 
		$this->var->add_def_cols('jub65','text');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	  /* echo $this->query;
		exit;*/
		return $res;
	}

	
	function RepDetalleAfp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{    
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_afp_sel';
		$this->codigo_procedimiento = "'KP_DETAFP_REP'";

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

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		
        $this->var->add_def_cols('importe',' numeric'); 
        $this->var->add_def_cols('codigo',' VARCHAR'); 
        $this->var->add_def_cols('id_afp',' integer');
        
	
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	    /*echo $this->query;
		exit;*/
		return $res;
	}

	
	
	function ObtenerAfps($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{    
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_afp_sel';
		$this->codigo_procedimiento = "'KP_OBTAFP_REP'";

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

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		
     /*   $this->var->add_def_cols('importe',' numeric'); 
        $this->var->add_def_cols('codigo',' VARCHAR'); */
        $this->var->add_def_cols('id_afp',' integer');
        $this->var->add_def_cols('nombre_afp','varchar');
        
	
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
		exit;*/
		return $res;
	}
}?>