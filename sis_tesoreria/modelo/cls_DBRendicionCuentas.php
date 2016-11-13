<?php
/**
 * Nombre de la clase:	cls_DBRendicionCuentas.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad del reporte rendicion de cuentas
 * Autor:				Ana Mar�a Villegas Quispe
 * Fecha creaci�n:		2009-06-05 17:43:09
 */

 
class cls_DBRendicionCuentas
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
	 * Nombre de la funci�n:	CabeRendicionCuentas
	 * Prop�sito:				Desplegar los registros de la cabecera
	 * Autor:				    Ana Mar�a Villegas
	 * Fecha de creaci�n:		2009-06-05 21:46:09
	 */
	function CabeRendicionCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';
		$this->codigo_procedimiento = "'TS_RENCUE_SEL'";

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
		$this->var->add_param($id_avance);//id_avance
        

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_completo',' TEXT'); 
        $this->var->add_def_cols('nombre_cargo',' VARCHAR(50)'); 
        $this->var->add_def_cols('nombre_lugar',' VARCHAR(200)'); 
        $this->var->add_def_cols('concepto_avance',' VARCHAR(500)'); 
        $this->var->add_def_cols('fecha_ini_rendicion',' text'); 
        $this->var->add_def_cols('fecha_fin_rendicion','text');
        $this->var->add_def_cols('fecha_avance',' text'); 
        $this->var->add_def_cols('nro_avance','varchar');
        
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	DetalleRendicionCuentas
	 * Prop�sito:				Desplegar los registros del detalle
	 * Autor:				    Ana Mar�a Villegas
	 * Fecha de creaci�n:		2009-06-05 21:46:09
	 */
	function DetalleRendicionCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';
	 	//$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel_prueba';
		$this->codigo_procedimiento = "'TS_RECUDE_SEL'";

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
		$this->var->add_param($id_avance);//id_avance
        
      

		//Carga la definici�n de columnas con sus tipos de datos
		
         // $this->var->add_def_cols('orden',' INTEGER'); 
         $this->var->add_def_cols('orden',' numeric'); 
		// $this->var->add_def_cols('fecha_avance',' date'); 
		$this->var->add_def_cols('fecha_avance','text'); 
        $this->var->add_def_cols('concepto_avance','TEXT'); 
        //$this->var->add_def_cols('nro','INTEGER');
       $this->var->add_def_cols('nro','numeric');
        $this->var->add_def_cols('desc_epe','TEXT'); 
        $this->var->add_def_cols('cargo','NUMERIC'); 
        $this->var->add_def_cols('descargo','NUMERIC');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
	/**
	 * Nombre de la funci�n:	CabeRendicionCuentasViaticos
	 * Prop�sito:				Desplegar los registros de la cabecera
	 * Autor:				    Ana Mar�a Villegas
	 * Fecha de creaci�n:		2009-07-14 21:46:09
	 */
	function CabeRendicionCuentasViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';
		$this->codigo_procedimiento = "'TS_RECUVI_SEL'";

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
		$this->var->add_param($id_avance);//id_avance
        

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_completo',' TEXT'); 
        $this->var->add_def_cols('nombre_cargo',' VARCHAR(50)'); 
        $this->var->add_def_cols('nombre_lugar',' VARCHAR(200)'); 
        $this->var->add_def_cols('concepto_avance',' VARCHAR(500)'); 
        $this->var->add_def_cols('fecha_ini_rendicion',' text'); 
        $this->var->add_def_cols('fecha_fin_rendicion','text');
        $this->var->add_def_cols('fecha_avance',' text'); 
        $this->var->add_def_cols('nro_avance','varchar');
        
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	DetalleRendicionCuentasViaticos
	 * Prop�sito:				Desplegar los registros del detalle para Viaticos
	 * Autor:				    Ana Mar�a Villegas
	 * Fecha de creaci�n:		2009-07-14 21:46:09
	 */
	function DetalleRendicionCuentasViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		 $this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';
		// $this->nombre_funcion = 'f_tts_rendicion_cuenta_sel_prueba';
		$this->codigo_procedimiento = "'TS_RECUVIDE_SEL'";

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
		$this->var->add_param($id_avance);//id_avance
        
      

		//Carga la definici�n de columnas con sus tipos de datos
		
        //$this->var->add_def_cols('orden',' INTEGER'); //0
        $this->var->add_def_cols('orden','numeric'); //0
		$this->var->add_def_cols('fecha_avance','text');//1 
        $this->var->add_def_cols('concepto_avance','TEXT'); //2
        $this->var->add_def_cols('nro','numeric');//3
       //$this->var->add_def_cols('nro','INTEGER');//3
        $this->var->add_def_cols('desc_epe','TEXT'); //4
        $this->var->add_def_cols('cargo','NUMERIC'); //5
        $this->var->add_def_cols('descargo','NUMERIC');//6
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
		exit;*/
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	CabeRendicionCuentasCajas
	 * Prop�sito:				Desplegar los registros de la cabecera
	 * Autor:				    Ana Mar�a Villegas
	 * Fecha de creaci�n:		30/07/2009
	 */
	function CabeRendicionCuentasCajas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_caja_regis)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';
		$this->codigo_procedimiento = "'TS_RECUCA_SEL'";

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
		$this->var->add_param($id_caja_regis);//id_avance


		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_completo',' TEXT'); 
        $this->var->add_def_cols('nombre_cargo',' VARCHAR(50)'); 
        $this->var->add_def_cols('nombre_lugar',' VARCHAR(200)'); 
        $this->var->add_def_cols('concepto_avance',' TEXT'); 
        $this->var->add_def_cols('fecha_ini_rendicion',' text'); 
        $this->var->add_def_cols('fecha_fin_rendicion','text');
        $this->var->add_def_cols('fecha_avance',' text'); 
        $this->var->add_def_cols('nro_rendicion','text');
        
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	DetalleRendicionCuentas
	 * Prop�sito:				Desplegar los registros del detalle
	 * Autor:				    Ana Mar�a Villegas
	 * Fecha de creaci�n:		2009-06-05 21:46:09
	 */
	function DetalleRendicionCuentasCajas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_caja_regis)
	{
		$this->salida = "";
		 $this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';
		
		$this->codigo_procedimiento = "'TS_RECUCADE_SEL'";

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
		$this->var->add_param($id_caja_regis);//id_avance
        
       
		//Carga la definici�n de columnas con sus tipos de datos
		
         $this->var->add_def_cols('orden',' Numeric'); 
        //$this->var->add_def_cols('orden','integer'); 
		$this->var->add_def_cols('fecha_avance','text'); 
        $this->var->add_def_cols('concepto_avance','TEXT'); 
        $this->var->add_def_cols('nro','numeric');
        $this->var->add_def_cols('desc_epe','TEXT'); 
        $this->var->add_def_cols('cargo','NUMERIC'); 
        $this->var->add_def_cols('descargo','NUMERIC');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
			/*echo $this->query;
			exit;*/
		
		return $res;
	}
	
	/*****************NUEVO ***********************/
	
	/**
	 * Nombre de la funci�n:	CabeRendicionCuentaDoc
	 * Prop�sito:				Desplegar los registros de la cabecera
	 * Autor:				    Ana Mar�a Villegas
	 * Fecha de creaci�n:		12/11/2009
	 */
	function CabeRendicionCuentaDoc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';
		$this->codigo_procedimiento = "'TS_RENCTADOCCAB_SEL'";

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
		$this->var->add_param($id_avance);//id_avance
        
/*"nombre_completo" TEXT,
 "nombre_cargo" VARCHAR(50),
 "nombre_lugar" VARCHAR(200),
 "concepto" VARCHAR(500),
 "fecha_ini" TEXT,
 "fecha_fin" TEXT,
 "fecha_rendi" TEXT,
 "nro_rendicion" INTEGER */
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_completo',' TEXT'); 
        $this->var->add_def_cols('nombre_cargo',' VARCHAR(50)'); 
        $this->var->add_def_cols('nombre_lugar',' VARCHAR(200)'); 
        $this->var->add_def_cols('concepto',' VARCHAR(500)'); 
        $this->var->add_def_cols('fecha_ini_rendicion',' text'); 
        $this->var->add_def_cols('fecha_fin_rendicion','text');
        $this->var->add_def_cols('fecha_avance',' text'); 
        $this->var->add_def_cols('nro_avance','varchar');
        $this->var->add_def_cols('subtitulo','varchar');
        
        $this->var->add_def_cols('firma_autorizada',' TEXT'); 
        $this->var->add_def_cols('revisado_por',' TEXT'); 
        $this->var->add_def_cols('contabilidad',' TEXT');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	DetalleRendicionCuentaDoc
	 * Prop�sito:				Desplegar los registros del detalle
	 * Autor:				    Ana Mar�a Villegas
	 * Fecha de creaci�n:		12/11/2009
	 */
	function DetalleRendicionCuentaDoc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';
	 	//$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel_prueba';
		$this->codigo_procedimiento = "'TS_RENCTADOCDET_SEL'";

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
		$this->var->add_param($id_avance);//id_avance
        
		

		//Carga la definici�n de columnas con sus tipos de datos
		/*
		$this->var->add_def_cols('orden',' numeric'); //1
		$this->var->add_def_cols('fecha_avance','text'); //2
        $this->var->add_def_cols('concepto_avance','TEXT'); //3
        $this->var->add_def_cols('nro','numeric');//4
        $this->var->add_def_cols('desc_epe','TEXT'); //5
        $this->var->add_def_cols('cargo','NUMERIC'); //6
        $this->var->add_def_cols('descargo','NUMERIC');//7
		
		*/
        $this->var->add_def_cols('orden',' numeric'); //1
		$this->var->add_def_cols('fecha_documento','text');//2 
        $this->var->add_def_cols('descripcion','TEXT'); //3
        $this->var->add_def_cols('nro','numeric');//4
        $this->var->add_def_cols('imputacion','TEXT'); //5
        $this->var->add_def_cols('cargo','NUMERIC'); //6
        $this->var->add_def_cols('descargo','NUMERIC'); //7
		
		//Ejecuta la funci�n de consulta
        //echo $this->var->query;	exit;
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*if ($_SESSION["sss_id_usuario"]==131){
		echo $this->query;
		exit;
		
			}
			*/   
	return $res;
	}
	
	function DetalleRendicionCuentaDoc2($id_caja,$fecha_ini,$fecha_fin,$tipo_rendicion)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_temp_sel';
	 	//$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel_prueba';
		$this->codigo_procedimiento = "'TS_RENCTADOCDET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
		$this->var->sortcol = "''";
		$this->var->sortdir = "''";
		$this->var->criterio_filtro = "''";

		
		$this->var->add_param($id_caja);
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$tipo_rendicion'");
        
      
        $this->var->add_def_cols('orden',' numeric'); //1
		$this->var->add_def_cols('fecha_documento','text');//2 
        $this->var->add_def_cols('descripcion','TEXT'); //3
        $this->var->add_def_cols('nro','numeric');//4
        $this->var->add_def_cols('imputacion','TEXT'); //5
        $this->var->add_def_cols('cargo','NUMERIC'); //6
        $this->var->add_def_cols('descargo','NUMERIC'); //7
		
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
	
	function ListarReporteCabRendicionVerificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';
		$this->codigo_procedimiento = "'TS_CABVERPREREN_SEL'";

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
		$this->var->add_param($id_cuenta_doc);//id_cuenta_doc        

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_y_apellido',' TEXT'); 
        $this->var->add_def_cols('fecha_rendicion',' TEXT'); 
        $this->var->add_def_cols('centro_responsabilidad',' VARCHAR(200)');        
        $this->var->add_def_cols('periodo',' TEXT'); 
        $this->var->add_def_cols('concepto',' VARCHAR(500)');        
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/
		
		return $res;
	}	
	function ListarReporteDetSolicitudesAmpliaciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';	 	
		$this->codigo_procedimiento = "'TS_DET_SOLAMP_SEL'";
		
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
		$this->var->add_param($id_cuenta_doc);//id_cuenta_doc            
		
  		$this->var->add_def_cols('desc_partida','TEXT');
  		$this->var->add_def_cols('desc_presupuesto','TEXT'); 
  		$this->var->add_def_cols('importe_total_rendicion','NUMERIC');  		
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
		
	function ListarReporteDetRendicionesAnteriores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';	 	
		$this->codigo_procedimiento = "'TS_DET_RENANT_SEL'";
		
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
		$this->var->add_param($id_cuenta_doc);//id_cuenta_doc        
           
		//$this->var->add_def_cols('id_cuenta_doc','INTEGER');  
  		$this->var->add_def_cols('desc_partida','TEXT');
  		$this->var->add_def_cols('desc_presupuesto','TEXT');  
  		$this->var->add_def_cols('importe_total_rendicion','NUMERIC'); 	
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/
		
		return $res;
	}	
	
	function ListarReporteDetRendicionVerificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_rendicion_cuenta_sel';	 	
		$this->codigo_procedimiento = "'TS_DETVERPREREN_SEL'";
		
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
		$this->var->add_param($id_cuenta_doc);//id_cuenta_doc        
           
		$this->var->add_def_cols('id_cuenta_doc','INTEGER');  
  		$this->var->add_def_cols('desc_partida','TEXT');
  		$this->var->add_def_cols('desc_presupuesto','TEXT');
  		$this->var->add_def_cols('importe_total_rendicion','NUMERIC');    	
  		$this->var->add_def_cols('disponible','VARCHAR');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/
		
		return $res;
	}	
	
}?>