<?php
/**
 * Nombre de la clase:	cls_DBCuentaDoc.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_cuenta_doc
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2009-10-27 11:50:07
 */

 
class cls_DBRepSolicitudEfectivo
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
	 * Nombre de la funci�n:	RepFondoRotatorio
	 * Prop�sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    AVQ
	 * Fecha de creaci�n:		24/07/2014
	 */
	function RepFondoRotatorio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_caja,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rep_solicitud_efectivo';
		$this->codigo_procedimiento = "'TS_FONDROT_REP'";
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
		/*$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	*/	$this->var->add_param("'$id_caja'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		
		//Carga la definici�n de columnas con sus tipos de datos
		
		 $this->var->add_def_cols('id_cuenta_doc','INTEGER'); 
 		 $this->var->add_def_cols('nro_documento','VARCHAR'); 
  		 $this->var->add_def_cols('fecha_fin','DATE'); 
  		 $this->var->add_def_cols('importe_recibido','numeric'); 
  		 $this->var->add_def_cols('importe_rendido','numeric'); 
  		 $this->var->add_def_cols('importe_reposicion','numeric'); 
  		 $this->var->add_def_cols('importe_impuesto','numeric'); 
  		 //Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*if($_SESSION['ss_id_usuario']==131){
		     echo $this->query;
			 exit;
        }*/		
		return $res;
	}


	/**
	 * Nombre de la funci�n:	RepImpViatico
	 * Prop�sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    AVQ
	 * Fecha de creaci�n:		24/07/2014
	 */
	function RepImpViaticoo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rep_solicitud_efectivo';
	
		$this->codigo_procedimiento = "'TS_VIAIMP_REP'";
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		$this->var->add_param("'$id_empleado'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
	
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_inicio','DATE');
		$this->var->add_def_cols('fecha_fin','DATE');
		$this->var->add_def_cols('nro_documento','VARCHAR(40)');
		$this->var->add_def_cols('nombre_completo','TEXT');
		$this->var->add_def_cols('concepto','VARCHAR(500)');
		$this->var->add_def_cols('estado_rendicion','VARCHAR(25)');
		$this->var->add_def_cols('importe_entregado','NUMERIC');
		$this->var->add_def_cols('importe_rendido','NUMERIC');
		$this->var->add_def_cols('importe_viatico','NUMERIC');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*if($_SESSION['ss_id_usuario']==131){
		 echo $this->query;
		exit;
		}*/
		return $res;
	}
		
	/**
	 * Nombre de la funci�n:	RepImpViaticoDias
	 * Prop�sito:				Desplegar los registros de tts_cuenta_doc
	 * Autor:				    AVQ
	 * Fecha de creaci�n:		01/08/2014
	 */
	function RepImpViaticoDias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rep_solicitud_efectivo';
	
		$this->codigo_procedimiento = "'TS_VIADIA_REP'";
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		$this->var->add_param("'$id_empleado'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
	
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('cant_dias_periodo_ant','integer');
		$this->var->add_def_cols('cant_dias_periodo_act','integer');
		$this->var->add_def_cols('nro_documento','VARCHAR');
		$this->var->add_def_cols('nombre_completo','TEXT');
		$this->var->add_def_cols('concepto','VARCHAR');
		$this->var->add_def_cols('importe_viatico','NUMERIC');
		
		
		/*$this->var->add_def_cols('fecha_inicio','DATE');
		$this->var->add_def_cols('fecha_fin','DATE');
		$this->var->add_def_cols('nro_documento','VARCHAR(40)');
		$this->var->add_def_cols('nombre_completo','TEXT');
		$this->var->add_def_cols('concepto','VARCHAR(500)');
		$this->var->add_def_cols('estado_rendicion','VARCHAR(25)');
		$this->var->add_def_cols('importe_entregado','NUMERIC');
		$this->var->add_def_cols('importe_rendido','NUMERIC');
		$this->var->add_def_cols('importe_viatico','NUMERIC');
	*/
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*if($_SESSION['ss_id_usuario']==131){
		 echo $this->query;
		exit;   
		}*/   
		return $res;
	}
	
}?>