<?php
/**
 * Nombre de la Clase:	cls_DBCuenta
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tct_cuenta
 * Autor:				Rensi Arteaga Copari
 * Fecha creación:		16-06-2010
 */
class cls_DBSigma
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
/*******************--------------------------------------------------------------*/
	function ListarRECCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 	
  		$this->salida = "";
		$this->nombre_funcion = 'sigma.f_tsi_cab_cbte_sel';
		$this->codigo_procedimiento = "'SI_RECCAB_REP'";

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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','varchar');
		$this->var->add_def_cols('entidad','varchar');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('nro_comp','varchar');
		$this->var->add_def_cols('devengado','varchar');
		$this->var->add_def_cols('percibido','varchar');
		$this->var->add_def_cols('operacion','varchar');
		$this->var->add_def_cols('comp_orig','varchar');
		$this->var->add_def_cols('fecha_aprobacion','date');
		
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','varchar');
		$this->var->add_def_cols('entidad','varchar');
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
		
		
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','varchar');
		$this->var->add_def_cols('entidad','varchar');
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
		
		
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','varchar');
		$this->var->add_def_cols('entidad','varchar');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('nro_comp','varchar');				
		$this->var->add_def_cols('tipo_dato','varchar');	
		$this->var->add_def_cols('rub_cta','varchar');
		$this->var->add_def_cols('importe','numeric');
		
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','varchar');
		$this->var->add_def_cols('entidad','varchar');
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
		
		
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('mes','varchar');
		$this->var->add_def_cols('entidad','varchar');
		$this->var->add_def_cols('dir_adm','integer');
		$this->var->add_def_cols('nro_comp','varchar');				
		$this->var->add_def_cols('tipo_dato','varchar');	
		$this->var->add_def_cols('obj_cta','varchar');
		$this->var->add_def_cols('importe','numeric');
		
		
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo ($this->query);exit();
		return $res;
		
	}
	
	
	
}?>