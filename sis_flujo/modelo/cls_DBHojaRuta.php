<?php
/**
 * Nombre de la clase:	cls_DBHojaRuta.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tfl_accion
 * Autor:				Silvia Ximena Ortiz Fern�ndez
 * Fecha creaci�n:		2010-12-27 15:36:51
 */

 
/*
* Se deben poner en comentario las funcion de selecci�n
* No se ha realizado ning�n cambio sobre esta clase.
*
* */

class cls_DBHojaRuta
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
	 * Nombre de la funci�n:	ListarReporteHojaRuta
	 * Prop�sito:				Desplegar los registros de tfl_accion
	 * Autor:				    Grover Velasquez Colque
	 * Fecha de creaci�n:		2011-04-01 15:36:51
	 */
	
	function ListarReporteHojaRuta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_hoja_ruta_sel';
		$this->codigo_procedimiento = "'FL_REPORTE_HOJA_RUTA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('numero_ref','varchar');
		$this->var->add_def_cols('fecha_recepcion','timestamp');	
		
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('area','varchar');
		$this->var->add_def_cols('fecha_doc','date');	
		$this->var->add_def_cols('remitente_empleado','text');
		$this->var->add_def_cols('remitente_persona','text');
		$this->var->add_def_cols('remitente_institucion','varchar');
		$this->var->add_def_cols('remitente','text');
		$this->var->add_def_cols('referencia','text');
		$this->var->add_def_cols('contenido','text');
		$this->var->add_def_cols('acciones','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('observaciones','text');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit();*/
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarAccion
	 * Prop�sito:				Contar los registros de tfl_accion
	 * Autor:				    Grover Velasquez Colque
	 * Fecha de creaci�n:		2010-12-27 15:50:51
	 */
	function ListarReporteHojaRutaFlujo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_hoja_ruta_sel';
		$this->codigo_procedimiento = "'FL_REPORTE_HOJA_RUTA_FLUJO_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('login','varchar');
		//$this->var->add_def_cols('empleado','text');
		$this->var->add_def_cols('fecha_recepcion','date');		
		$this->var->add_def_cols('dirigido_a','text');
		$this->var->add_def_cols('mensaje','text');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit();*/
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ListarReporteHojaRuta
	 * Prop�sito:				Desplegar los registros de tfl_accion
	 * Autor:				    Grover Velasquez Colque
	 * Fecha de creaci�n:		2011-04-01 15:36:51
	 */
	
	function ListarReporteHojaRutaDerivada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_hoja_ruta_sel';
		$this->codigo_procedimiento = "'FL_REPORTE_HOJA_RUTA_DERIVADA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('numero_ref','varchar');
		$this->var->add_def_cols('fecha_recepcion','text');	
		
		$this->var->add_def_cols('tipo','text');
		$this->var->add_def_cols('area','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('remitente_empleado','text');
		$this->var->add_def_cols('remitente_persona','text');
		$this->var->add_def_cols('remitente_institucion','varchar');
		$this->var->add_def_cols('remitente','text');
		$this->var->add_def_cols('referencia','text');
		$this->var->add_def_cols('contenido','text');
		//$this->var->add_def_cols('acciones','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('observaciones','text');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit();
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarAccion
	 * Prop�sito:				Contar los registros de tfl_accion
	 * Autor:				    Grover Velasquez Colque
	 * Fecha de creaci�n:		2010-12-27 15:50:51
	 */
	function ListarReporteHojaRutaFlujoDerivada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_hoja_ruta_sel';
		$this->codigo_procedimiento = "'FL_REPORTE_HOJA_RUTA_FLUJO_DERIVADA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('login','varchar');
		//$this->var->add_def_cols('empleado','text');
		$this->var->add_def_cols('fecha_derivacion','text');		
		$this->var->add_def_cols('dirigido_a','text');
		$this->var->add_def_cols('acciones','varchar');
		$this->var->add_def_cols('mensaje','text');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit();
		
		return $res;
	}

	

	
}?>
