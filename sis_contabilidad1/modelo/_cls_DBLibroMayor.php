<?php
/**
 * Nombre de la clase:	cls_DBLibroMayor.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_comprobante
 * Autor:				Ana Maria
 * Fecha creación:		2009-06-15 17:55:36
 */

 
class cls_DBLibroMayor
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
	 * Nombre de la función:	Reporte para Libro Mayor x Partidas la cabecera 
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    ana maria
	 * Fecha de creación:		2009-06-15 8:36:36
	 * 
	 */
	function LibroMayorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_partida_sel';
		$this->codigo_procedimiento = "'CT_ELIMAPA_SEL'";

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
		$this->var->add_param($id_partida);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
      

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo_partida','varchar');
		$this->var->add_def_cols('nombre_partida','varchar');
		$this->var->add_def_cols('desc_partida','varchar');
	 	//$this->var->add_def_cols('nombre_auxiliar','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo  $this->query;
		exit;*/
		
	return $res;
	}
	
	
	/**
	 * Nombre de la función:	ReporteLibroMayor Detalle
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-15 17:57:07
	 */
	function LibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_partida_sel';
		$this->codigo_procedimiento = "'CT_LMPADE_SEL'";

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
		$this->var->add_param($id_partida);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
      
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('prefijo','varchar');
		$this->var->add_def_cols('nro_cbte','integer');
		$this->var->add_def_cols('concepto_cbte','varchar');
		$this->var->add_def_cols('tipo_cambio','numeric');
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
		$this->var->add_def_cols('saldo','numeric');
		
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
	/**
	 * Nombre de la función:	ContarRegistroLibroMayor
	 * Propósito:				Contar los registros de libro mayor
	 * Autor:				    amvq
	 * Fecha de creación:		2008-12-8 17:55:36
	 */
	function ContarLibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_partida_sel';
		$this->codigo_procedimiento = "'CT_LMPADE_COUNT'";

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
		$this->var->add_param($id_partida);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
       
	
		
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

	  /* echo $this->query;
		exit();*/
		//Retorna el resultado de la ejecución
		return $res;
	}
		
}?>