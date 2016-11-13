<?php
/**
 * Nombre de la clase:	cls_DBCuentaDoc.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_cuenta_doc
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2009-10-27 11:50:07
 */

 
class cls_DBRepReciboPago
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
	 * Nombre de la funci�n:	ListarSolicitudViaticos2
	 * Prop�sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 11:50:07
	 */
	function RepReciboPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rep_recibo_pago';
		
		$this->codigo_procedimiento = "'TS_RECPAG_REP'";
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		//$this->var->add_param("'$estado'");

		//Carga la definici�n de columnas con sus tipos de datos
		
		
		 $this->var->add_def_cols('id_cuenta_doc',' INTEGER'); 
 		 $this->var->add_def_cols('id_cuenta_doc_rendicion',' INTEGER'); 
  		 $this->var->add_def_cols('id_documento',' INTEGER'); 
  		 $this->var->add_def_cols('motivo',' VARCHAR(500)'); 
  		 $this->var->add_def_cols('id_presupuesto',' INTEGER'); 
  		 $this->var->add_def_cols('id_unidad_organizacional',' INTEGER'); 
  		 $this->var->add_def_cols('nombre_unidad',' VARCHAR(100)'); 
  		 $this->var->add_def_cols('id_empleado',' INTEGER'); 
  		 $this->var->add_def_cols('nombre_completo',' TEXT');
  		 $this->var->add_def_cols('importe_total','NUMERIC'); 	
		 $this->var->add_def_cols('importe_rendicion','NUMERIC'); 	
  		 $this->var->add_def_cols('importe_literal','VARCHAR'); 
  		 $this->var->add_def_cols('categoria','VARCHAR'); 
  		 $this->var->add_def_cols('fecha','VARCHAR'); 
  		 $this->var->add_def_cols('lugar','VARCHAR'); 
  		 $this->var->add_def_cols('iue','NUMERIC'); 
  		 $this->var->add_def_cols('it','NUMERIC'); 
		//$this->var->add_def_cols('id_cuenta_doc','int4');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*if($_SESSION['ss_id_usuario']==131){
		     echo $this->query;
			 exit;
        }		*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ListarSolicitudViaticos2
	 * Prop�sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 11:50:07
	 */
	function RepReciboPagoMes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rep_recibo_pago';
		
		$this->codigo_procedimiento = "'TS_RECPAGMES_REP'";
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		//$this->var->add_param("'$estado'");

		//Carga la definici�n de columnas con sus tipos de datos
		
		
		 $this->var->add_def_cols('mes','INTEGER'); 
 		 $this->var->add_def_cols('gestion','INTEGER'); 
  		 $this->var->add_def_cols('mes_literal','VARCHAR'); 
  		 $this->var->add_def_cols('rendiciones_anteriores','TEXT'); 
  		 
  		 
		//$this->var->add_def_cols('id_cuenta_doc','int4');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
	 /* if($_SESSION['ss_id_usuario']==131){
		     echo $this->query;
			 exit;
        }	
		*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ListarSolicitudViaticos2
	 * Prop�sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 11:50:07
	 */
	function RepReciboPagoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rep_recibo_pago';
		
		$this->codigo_procedimiento = "'TS_RECPAGDET_REP'";
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		//$this->var->add_param("'$estado'");

		//Carga la definici�n de columnas con sus tipos de datos
		
		
		 $this->var->add_def_cols('dias_acumulados','INTEGER'); 
 		 $this->var->add_def_cols('dias','INTEGER'); 
  		 $this->var->add_def_cols('tipo_destino','VARCHAR'); 
  		 $this->var->add_def_cols('importe_total','NUMERIC'); 
  		 $this->var->add_def_cols('cobertura','NUMERIC'); 
  		 $this->var->add_def_cols('importe_cobertura','NUMERIC'); 
  		 $this->var->add_def_cols('descuento','NUMERIC'); 
  		 $this->var->add_def_cols('importe_liquido','NUMERIC'); 
  		 //abril2016
  		 $this->var->add_def_cols('rango_fechas','text');
  		 
		//$this->var->add_def_cols('id_cuenta_doc','int4');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
	 /* if($_SESSION['ss_id_usuario']==131){
		     echo $this->query;
			 exit;
        }	
		*/
		return $res;
	}
	
	
}?>