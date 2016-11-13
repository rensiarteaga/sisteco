<?php
/**
 * Nombre de la Clase:	cls_DBActualizarLibros
 * Propósito:			Permite ejecutar la funcion que actualiza los datos de los libros de ventas
 * Autor:				
 * Fecha creación:		
 */
class cls_DBActualizarLibros
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
	 * Nombre de la función:	ActualizarLibros
	 * Propósito:				
	 * Autor:				    
	 * Fecha de creación:		
	 */
	function ActualizarLibros($id_transaccion,$subsistema,$gestion,$periodo)
	{
		//echo "h".$id_transaccion.$subsistema.$gestion.$periodo;exit;
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_ct_actualizar_libros';
		$this->codigo_procedimiento = "'CT_REGDOCINS_BLO'";

		if($subsistema=='cobija')// si el subsistema es cobija
			$tipo_documento=3;
		else 
			$tipo_documento=2;
		$tabla='sci.vct_'.$subsistema.'';
		$id_moneda=1;//Bs.
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_transaccion");
		
		$this->var->add_param("$tipo_documento");
		$this->var->add_param("'$tabla'");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$gestion");
		$this->var->add_param("$periodo");
		//echo '$id_actualizacion'.$id_actualizacion; exit();
	    
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
       /* echo $this->query;
        exit;*/
		return $res;
	}
	
	function ContarActualizacion($id_transaccion,$subsistema,$gestion,$periodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_trafo_sel';
		$this->codigo_procedimiento = "'FV_TRAFOS_COUNT'";

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
	 * Nombre de la función:	ActualizarLibros
	 * Propósito:
	 * Autor: AVQ
	 * Fecha de creación:11/09/2013
	 */
	function ActualizarLibrosCompras($id_transaccion,$subsistema,$gestion,$periodo)
	{
		//echo "h".$id_transaccion.$subsistema.$gestion.$periodo;exit;
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_ct_actualizar_libros';
		$this->codigo_procedimiento = "'CT_REGDOCCOMP_INS'";
	
		//if($subsistema=='cobija')// si el subsistema es cobija
			$tipo_documento=1;
		/*else
			$tipo_documento=2;*/
		$tabla='sci.vct_'.$subsistema.'';
		$id_moneda=1;//Bs.
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_transaccion");
	
		$this->var->add_param("$tipo_documento");
		$this->var->add_param("'$tabla'");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$gestion");
		$this->var->add_param("$periodo");
		//echo '$id_actualizacion'.$id_actualizacion; exit();
		 
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/* echo $this->query;
		 exit;*/
		return $res;
	}
	
	
	
}?>