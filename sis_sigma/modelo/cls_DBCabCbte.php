<?php
/**
 * Nombre de la clase:	cls_DBDeclaracion.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_Declaracion
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2008-09-16 17:55:36
 */
 
class cls_DBCabCbte
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
	 * Nombre de la funci�n:	ListarCabCbte
	 * Prop�sito:				Desplegar los registros de tct_Declaracion
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-09-16 17:55:36
	 */
	function ListarCabCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_CABCBT_SEL'";

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
		$this->var->add_def_cols('id_cab_cbte','integer');
		$this->var->add_def_cols('nro_cbte','varchar');
		$this->var->add_def_cols('id_cbte','integer');
		$this->var->add_def_cols('compromiso','varchar');
	 	$this->var->add_def_cols('devengado','varchar');
		$this->var->add_def_cols('pagado','varchar');
		$this->var->add_def_cols('operacion','varchar');
		$this->var->add_def_cols('nro_cbte_orig','varchar');
		$this->var->add_def_cols('id_cbte_orig','integer');
		$this->var->add_def_cols('fecha_validacion','date');
		$this->var->add_def_cols('tipo_mov','varchar');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('id_declaracion','integer');
		$this->var->add_def_cols('fecha_reg','timestamp');
		$this->var->add_def_cols('tipo_reg','varchar');
		$this->var->add_def_cols('presentado','boolean');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('modificado','varchar');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarCabCbte
	 * Prop�sito:				Contar los registros de tct_Declaracion
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-09-16 17:55:36
	 */
	function ContarCabCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_CABCBT_COUNT'";

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
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;

		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		/*	echo $this->query;
		exit();*/		
		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	function InsertarCabCbte($id_cab_cbte,$nro_cbte,$id_cbte,$compromiso,$devengado,$pagado,$operacion,$id_cbte_orig,$tipo_mov,$tipo_pago,$tipo,$id_declaracion,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cab_cbte_iud';
		$this->codigo_procedimiento = "'SI_CABCBT_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$compromiso'");
		$this->var->add_param("'$devengado'");
		$this->var->add_param("'$pagado'");
        $this->var->add_param("'$nro_cbte'");
        $this->var->add_param($id_cbte);
        $this->var->add_param("'$operacion'");
        $this->var->add_param($id_cbte_orig);
        $this->var->add_param("'$tipo_mov'");
        $this->var->add_param("'$tipo_pago'");
        $this->var->add_param("'$tipo'");
        $this->var->add_param($id_declaracion);
        $this->var->add_param("'$observaciones'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		return $res;
	}
	
	function ModificarCabCbte($id_cab_cbte,$nro_cbte,$id_cbte,$compromiso,$devengado,$pagado,$operacion,$id_cbte_orig,$tipo_mov,$tipo_pago,$tipo,$id_declaracion,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cab_cbte_iud';
		$this->codigo_procedimiento = "'SI_CABCBT_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cab_cbte");
		$this->var->add_param("'$compromiso'");
		$this->var->add_param("'$devengado'");
		$this->var->add_param("'$pagado'");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("'$observaciones'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		return $res;
	}
	
	//Generacion de Archivos
	function ListarRECCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_RECCAB_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('nro_comp','varchar');
		$this->var->add_def_cols('devengado','varchar');
		$this->var->add_def_cols('percibido','varchar');
		$this->var->add_def_cols('operacion','varchar');
		$this->var->add_def_cols('comp_orig','varchar');
		$this->var->add_def_cols('fecha_aprobacion','date');
		$this->var->add_def_cols('mes_cadena','varchar');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	
	function ListarGTOCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_GTOCAB_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('nro_comp','varchar');
		$this->var->add_def_cols('compromiso','varchar');		
		$this->var->add_def_cols('devengado','varchar');
		$this->var->add_def_cols('pago','varchar');
		$this->var->add_def_cols('operacion','varchar');
		$this->var->add_def_cols('comp_orig','varchar');
		$this->var->add_def_cols('tipo_mov','varchar');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('fecha_aprobacion','date');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	                          
	function ListarRECDET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_RECDET_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('nro_comp','varchar');		
		$this->var->add_def_cols('fuente','varchar');	
		$this->var->add_def_cols('organismo','varchar');	
		$this->var->add_def_cols('rubro','varchar');		
		$this->var->add_def_cols('ent_trf','varchar');
		$this->var->add_def_cols('oec','varchar');
		$this->var->add_def_cols('banco','varchar');
		$this->var->add_def_cols('cuenta','varchar');
		$this->var->add_def_cols('libreta','varchar');
		$this->var->add_def_cols('importe','numeric');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
		                          
	function ListarRECANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_RECANX_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('nro_comp','varchar');				
		$this->var->add_def_cols('tipo_dato','varchar');	
		$this->var->add_def_cols('rub_cta','varchar');
		$this->var->add_def_cols('importe','numeric');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	
	function ListarGTODET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_GTODET_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('nro_comp','varchar');	
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('actividad','varchar');				
		$this->var->add_def_cols('fuente','varchar');	
		$this->var->add_def_cols('organismo','varchar');
		$this->var->add_def_cols('objeto','varchar');		
		$this->var->add_def_cols('ent_trf','varchar');
		$this->var->add_def_cols('oec','varchar');
		$this->var->add_def_cols('banco','varchar');
		$this->var->add_def_cols('cuenta','varchar');
		$this->var->add_def_cols('libreta','varchar');
		$this->var->add_def_cols('importe','numeric');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	                          
	function ListarGTOANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_GTOANX_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('nro_comp','varchar');				
		$this->var->add_def_cols('tipo_dato','varchar');	
		$this->var->add_def_cols('obj_cta','varchar');
		$this->var->add_def_cols('importe','numeric');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	
	function ListarMODCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_MODCAB_REP'";

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

		//Carga la definicion de columnas con sus tipos de datos
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('docmod_nro','varchar');
		$this->var->add_def_cols('docmod_tipo','varchar');
		$this->var->add_def_cols('docmod_fecha','text');
		$this->var->add_def_cols('docdis_tipo','varchar');
		$this->var->add_def_cols('docdis_nro','varchar');
		$this->var->add_def_cols('docdis_fecha','text');
		$this->var->add_def_cols('mes_cadena','varchar');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	
	function ListarMODDET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_MODDET_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('docmod_nro','varchar');	
		$this->var->add_def_cols('tipo_reg','text');
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('actividad','varchar');				
		$this->var->add_def_cols('fuente','varchar');	
		$this->var->add_def_cols('organismo','varchar');
		$this->var->add_def_cols('objeto','varchar');		
		$this->var->add_def_cols('ent_trf','varchar');
		$this->var->add_def_cols('finalidad','varchar');
		$this->var->add_def_cols('tipo_inv','text');
		$this->var->add_def_cols('importe','numeric');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	
	function ListarPPTINI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_PPTINI_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');	
		$this->var->add_def_cols('tipo_reg','text');
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('actividad','varchar');				
		$this->var->add_def_cols('fuente','varchar');	
		$this->var->add_def_cols('organismo','varchar');
		$this->var->add_def_cols('objeto','varchar');		
		$this->var->add_def_cols('ent_trf','varchar');
		$this->var->add_def_cols('finalidad','varchar');
		$this->var->add_def_cols('tipo_inv','text');
		$this->var->add_def_cols('importe','numeric');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	
	function ListarDIRADM($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_DIRADM_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');	
		$this->var->add_def_cols('finalidad','varchar');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	
	function ListarAPEPRO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_APEPRO_REP'";

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
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('entidad','numeric');
		$this->var->add_def_cols('dir_adm','integer');	
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('actividad','varchar');				
		$this->var->add_def_cols('descripcion','varchar');	
		$this->var->add_def_cols('sector_economico','numeric');
		$this->var->add_def_cols('subsector_economico','numeric');		
		$this->var->add_def_cols('activ_eco','numeric');
		$this->var->add_def_cols('departamento','numeric');
		$this->var->add_def_cols('provincia','numeric');
		$this->var->add_def_cols('seccion_mun','numeric');
		$this->var->add_def_cols('codigo_sisin','varchar');
		$this->var->add_def_cols('pnd','varchar');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	
	function ListarCONTRL($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_CONTRL_REP'";

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
		$this->var->add_def_cols('gestion','text');
		$this->var->add_def_cols('entidad','text');
		$this->var->add_def_cols('periodo','text');	
		$this->var->add_def_cols('archivo','text');
		$this->var->add_def_cols('nroreg','text');
	
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
	}
	
	function EliminarCabCbte($id_cab_cbte)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cab_cbte_iud';
		$this->codigo_procedimiento = "'SI_CABCBT_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cab_cbte");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		return $res;
	}
	


}?>