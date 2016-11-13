<?php
class cls_DBActivoFijoProceso
{

	//Variable que contiene la salida de la ejecuci�n de la funci�n
	//si la funci�n tuvo error (false), salida contendr� el mensaje de error
	//si la funci�n no tuvo error (true), salida contendr� el resultado, ya sea un conjunto de datos o un mensaje de confirmaci�n
	var $salida;
	//Variable que contedr� la cadena de llamada a las funciones postgres
	var $query;
	//Variables para la ejecuci�n de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la funci�n a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	var $nombre_archivo = "cls_DBActivoFijoProceso.php";

	//Matriz de par�metros de validaci�n de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los par�metro de validaci�n de todas las columnas
		//$this->cargar_param_valid();

		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	function ListarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{

		$this->salida ="";
		$this->nombre_funcion = 'f_taf_activo_fijo_proceso_sel';
		$this->codigo_procedimiento = "'AF_AFPROC_SEL'";

		$func = new cls_funciones();
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";


		//Carga los par�metros espec�fos
		$this->var->add_param($func->iif($id_financiador == '','NULL',"'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',"'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',"'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',"'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',"'$id_actividad'"));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('desc_activo','varchar');
		$this->var->add_def_cols('vida_util_actual','integer');
		$this->var->add_def_cols('monto_actualiz_ant','numeric');
		$this->var->add_def_cols('actualizacion','numeric');
		$this->var->add_def_cols('monto_actualiz','numeric');
		$this->var->add_def_cols('depreciacion_acumulada_anterior','numeric');
		$this->var->add_def_cols('actualizacion_depre','numeric');
		$this->var->add_def_cols('depreciacion_acumulada_actualiz','numeric');
		$this->var->add_def_cols('depreciacion','numeric');
		$this->var->add_def_cols('depreciacion_acumulada','numeric');
		$this->var->add_def_cols('monto_vigente_actual','numeric');
		$this->var->add_def_cols('flag_revalorizacion','varchar');
		$this->var->add_def_cols('id_activo_fijo_proceso','integer');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('id_sub_tipo_activo','integer');
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('id_transaccion','integer');
		$this->var->add_def_cols('id_grupo_proceso','integer');
		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('vida_util_anterior','integer');
		$this->var->add_def_cols('monto_vigente_anterior','numeric');
		$this->var->add_def_cols('desc_tipo_activo','varchar');
		$this->var->add_def_cols('desc_sub_tipo_activo','varchar');
		$this->var->add_def_cols('desc_presupuesto','varchar');
		$this->var->add_def_cols('monto_revalorizacion','numeric');
		$this->var->add_def_cols('vida_util_revalorizacion','integer');
		$this->var->add_def_cols('fecha_ini_dep','date');
		$this->var->add_def_cols('desc_proceso','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado_detalle','varchar');
		$this->var->add_def_cols('asignar','varchar');
		
		
		//Ejecuta la funci�n de consulta
		$res = $this ->var->exec_query();
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}

	function ContarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_proceso_sel';
		$this->codigo_procedimiento = "'AF_AFPROC_COUNT'";


		$func = new cls_funciones();//Instancia de las funciones generales
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);


		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga par�metros espec�ficos
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));
		$this->var->add_param($func->iif($id_proyecto== '','NULL',$id_proyecto));
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva al total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];

		}
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuci�n
		//echo $this->query;
		//exit;
		return $res;
	}

	
	
	function InsertarActivoFijoGrupoProceso($id_grupo_proceso,$id_activo_fijo,$monto_revalorizacion,$vida_util_revalorizacion,$fecha_ini_dep,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_proceso_iud';
		$this->codigo_procedimiento = "'AF_AF_PROC_INS'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		
		$this->var->add_param('NULL');//id_act_fij_proceso
		$this->var->add_param($id_grupo_proceso);//mont_vig_ant
		$this->var->add_param($id_activo_fijo);//mont_vig_ant
		$this->var->add_param($monto_revalorizacion);//monto_vig_act
		$this->var->add_param($vida_util_revalorizacion);//vida_util_ant
		$this->var->add_param("'$fecha_ini_dep'");//fecha_reg
		$this->var->add_param("'$observaciones'");//fecha_reg
		$this->var->add_param('NULL');//asignar
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	
	function ModificarActivoFijoGrupoProceso($id_activo_fijo_proceso,$id_grupo_proceso,$id_activo_fijo,$monto_revalorizacion,$vida_util_revalorizacion,$fecha_ini_dep,$observaciones,$asignar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_proceso_iud';
		$this->codigo_procedimiento = "'AF_AF_PROC_UPD'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		
		$this->var->add_param($id_activo_fijo_proceso);//id_act_fij_proceso
		$this->var->add_param($id_grupo_proceso);//mont_vig_ant
		$this->var->add_param($id_activo_fijo);//mont_vig_ant
		$this->var->add_param($monto_revalorizacion);//monto_vig_act
		$this->var->add_param($vida_util_revalorizacion);//vida_util_ant
		$this->var->add_param("'$fecha_ini_dep'");//fecha_reg
		$this->var->add_param("'$observaciones'");//fecha_reg
		$this->var->add_param("'$asignar'");//asignar

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res;
	}
	
	function  EliminarActivoFijoGrupoProceso($id_activo_fijo_proceso)
	{

		$this->salida="";
		$this->nombre_funcion = 'f_taf_activo_fijo_proceso_iud';
		$this->codigo_procedimiento = "'AF_AF_PROC_DEL'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		
		$this->var->add_param($id_activo_fijo_proceso);//id_activo_fijo_proceso
		$this->var->add_param('NULL');//monot_vig_ant
		$this->var->add_param('NULL');//monot_vig_act
		$this->var->add_param('NULL');//vida_util_ant
		$this->var->add_param('NULL');//vida_util_act
		$this->var->add_param('NULL');//vida_util_act
		$this->var->add_param('NULL');//vida_util_act
		$this->var->add_param('NULL');//asignar
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		$this->query = $this->var->query;
		return $res;
	}
	
	function  DevolucionActivoProceso($id_activo_fijo_proceso)
	{

		$this->salida="";
		$this->nombre_funcion = 'f_taf_activo_fijo_proceso_iud';
		$this->codigo_procedimiento = "'AF_AF_DEVACT_UPD'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		
		$this->var->add_param($id_activo_fijo_proceso);//id_activo_fijo_proceso
		$this->var->add_param('NULL');//monot_vig_ant
		$this->var->add_param('NULL');//monot_vig_act
		$this->var->add_param('NULL');//vida_util_ant
		$this->var->add_param('NULL');//vida_util_act
		$this->var->add_param('NULL');//vida_util_act
		$this->var->add_param('NULL');//vida_util_act
		$this->var->add_param('NULL');//asignar
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		$this->query = $this->var->query;
		return $res;
	}
	
	/*------------------------------- LISTA REPORTE ACTIVO FIJO PROCESO ------------------------------*/
	/*----------------------------- Adicionado por Silvia Ximena Ortiz Fern�ndez -----------------------------*/
	function ListarPDFActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_proceso_sel';
		$this->codigo_procedimiento = "'AF_AFASIG_REP'";

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
						
		//Carga la definici�n de columnas con sus tipos de datos	
		
		//$this->var->add_def_cols('id_activo_fijo','integer'); 
		$this->var->add_def_cols('codigo','varchar'); 
  		$this->var->add_def_cols('denominacion','varchar'); 
  		$this->var->add_def_cols('descripcion','varchar');
  		$this->var->add_def_cols('desc_sub_tipo_activo','varchar');
  		$this->var->add_def_cols('observaciones','varchar');
  		$this->var->add_def_cols('estado','varchar');
  		$this->var->add_def_cols('cargo','varchar');
  		$this->var->add_def_cols('nombre_completo','text');
  		$this->var->add_def_cols('uo_origen','varchar');
  		$this->var->add_def_cols('uo_destino','varchar');
  		$this->var->add_def_cols('tipo_af_bien','varchar');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query('*','numeral');

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida; 

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;		
				
		//echo $this->query; exit;
		
		return $res;
	}
	/*--------------------------------------- FIN REPORTE ACTIVO FIJO PROCESO ------------------------------*/
	/*----------------------------- Adicionado por Silvia Ximena Ortiz Fern�ndez -----------------------------*/
	function ObtieneResponsableAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_proceso_sel';
		$this->codigo_procedimiento = "'OBT_RESP_AF'";

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
						
		//Carga la definici�n de columnas con sus tipos de datos	
		
		$this->var->add_def_cols('responsable','text'); 
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query('*','numeral');

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida; 

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;		
				
		//echo $this->query; exit;
		
		return $res;
	}
	/*--------------------------------------- FIN REPORTE ACTIVO FIJO PROCESO ------------------------------*/
	
	function ReporteActivosFijosRespaldoCbtesBaja($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_plan_cuentas_sel';
		$this->codigo_procedimiento = "'AF_RESP_CBTEBAJ'";
		
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
		
		//Carga la definici�n de columnas con sus tipos de datos
		

		$this->var->add_def_cols('desc_af','text');
		$this->var->add_def_cols('desc_tipo_af','varchar');
		$this->var->add_def_cols('desc_epe','text');
		$this->var->add_def_cols('desc_cuenta','text');
		$this->var->add_def_cols('monto_actual','numeric');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		$this->var->add_def_cols('diferencia','numeric');
		
		$this->var->add_def_cols('id_tipo','integer');
		$this->var->add_def_cols('id_cta','integer');

		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
}?>