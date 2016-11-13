<?php
/**
 * Nombre de la clase:	cls_DBRepEmpleado.php
 * Propï¿½sito:			Permite obtener listados para reportes de Empleados
 * Autor:				avillegas
 * Fecha creaciï¿½n:		17/05/2011
 */

 
class cls_DBRepEmpleado
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
	 * Nombre de la función:	RepEmpleadoContratosDetalle
	 * Propï¿½sito:				Desplegar los registros de tkp_empleado
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		17/05/2011
	 */
	function RepEmpleadoContratosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPCON_REP'";

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
		$this->var->add_def_cols('id_lugar','integer'); 
 		$this->var->add_def_cols('nombre_lugar',' text'); 
  		$this->var->add_def_cols('tipo_contrato',' VARCHAR'); 
 		$this->var->add_def_cols('codigo_empleado','varchar');
 		$this->var->add_def_cols('nombre_completo','text'); 
 		
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
/**
	 * Nombre de la función:	RepEmpleadoContratosCargosDetalle
	 * Propï¿½sito:				Desplegar los registros de tkp_empleado con sus respectivos cargos de historico asignación
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		17/05/2011
	 */
	function RepEmpleadoContratosCargosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPCARG_REP'";

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

		
		
		$this->var->add_def_cols('id_lugar','integer'); 
 		$this->var->add_def_cols('nombre_lugar',' text'); 
  		$this->var->add_def_cols('tipo_contrato',' VARCHAR'); 
 		$this->var->add_def_cols('codigo_empleado','varchar');
 		$this->var->add_def_cols('nombre_completo','text'); 
 		
  		$this->var->add_def_cols('nombre_cargo','varchar');
 		$this->var->add_def_cols('fecha_inicio_contrato','text'); 
 		$this->var->add_def_cols('fecha_fin_contrato','text');
 		$this->var->add_def_cols('fecha_inicio_cargo','text'); 
 		$this->var->add_def_cols('fecha_fin_cargo','text');
 		
 		
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
	/**
	 * Nombre de la función:	DatosEmpleadoCV
	 * Propï¿½sito:				Desplegar datos del empleado para el curriculum vitae
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		27/06/2011
	 */
	function DatosEmpleadoCV($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPCVDE_REP'";

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

		
		
		$this->var->add_def_cols('nombre_completo','text'); 
 		$this->var->add_def_cols('fecha_nacimiento','text'); 
  		$this->var->add_def_cols('doc_id',' VARCHAR'); 
 		$this->var->add_def_cols('genero','varchar');
 		$this->var->add_def_cols('telefono','varchar'); 
 		$this->var->add_def_cols('email','varchar');
 		$this->var->add_def_cols('direccion','varchar');
 		$this->var->add_def_cols('nro_contrato','integer');
 		$this->var->add_def_cols('tipo_contrato','varchar');
 		
 		
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
	/**
	 * Nombre de la función:	DatosCapacitacionEmpleadoCV
	 * Propï¿½sito:				Desplegar datos de capacitacion del empleado para el curriculum vitae
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		27/06/2011
	 */
	function DatosCapacitacionEmpleadoCV($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPCVDC_REP'";

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

		
		
		$this->var->add_def_cols('id_empleado','integer'); 
 		$this->var->add_def_cols('nombre_nivel','varchar'); 
  		$this->var->add_def_cols('nombre_institucion',' VARCHAR'); 
 		$this->var->add_def_cols('fecha_ini','text');
 		$this->var->add_def_cols('fecha_fin','text');
 		$this->var->add_def_cols('graduacion','integer');
 		$this->var->add_def_cols('nombre_titulo','varchar');
 		$this->var->add_def_cols('descripcion','varchar'); 
 		$this->var->add_def_cols('reg_profesional','varchar'); 
 		
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
	/**
	 * Nombre de la función:	DatosExperienciaLabEmpleadoCV
	 * Propï¿½sito:				Desplegar datos de experiencia  Laboral del empleado para el curriculum vitae
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		27/06/2011
	 */
	function DatosExperienciaLabEmpleadoCV($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPCVDEL_REP'";

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

		
		
		$this->var->add_def_cols('fecha_ini','text'); 
 		$this->var->add_def_cols('fecha_fin','text'); 
  		$this->var->add_def_cols('ins_nombre',' VARCHAR'); 
 		$this->var->add_def_cols('cargo','varchar');
 		$this->var->add_def_cols('descriPcion','varchar'); 
 		 		
 		
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
	/**
	 * Nombre de la función:	DatosRelacionesFamiliares
	 * Propï¿½sito:				Desplegar datos del empleado para el curriculum vitae
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		01/07/2011
	 */
	function DatosRelacionesFamiliares($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPREFA_REP'";

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

		
		$this->var->add_def_cols('nombre_completo','text'); 
 		$this->var->add_def_cols('fecha_nacimiento','date'); 
  		$this->var->add_def_cols('doc_id',' VARCHAR'); 
 		$this->var->add_def_cols('genero','varchar');
 		$this->var->add_def_cols('relacion','varchar');
 		$this->var->add_def_cols('nombre_institucion','varchar');
 		$this->var->add_def_cols('id_persona','integer');
 		$this->var->add_def_cols('id_institucion','integer');
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
	/**
	 * Nombre de la función:	DescuentosEmpleadosHoras
	 * Propï¿½sito:				Desplegar datos del empleado para el curriculum vitae
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		14/03/2012   
	 */
	function DescuentosEmpleadosHoras($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPDESC_REP'";

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

		
		$this->var->add_def_cols('codigo_empleado','varchar'); 
 		$this->var->add_def_cols('nombre_completo','text'); 
  		//$this->var->add_def_cols('doc_id',' VARCHAR'); 
 		$this->var->add_def_cols('desc_atraso','numeric');
 		$this->var->add_def_cols('hrs_aprobado','interval');
 		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

	 	return $res;
	}
	/**
	 * Nombre de la función:	DescuentosEmpleadosHoras
	 * Propï¿½sito:				Desplegar datos del empleado para el curriculum vitae
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		24/05/2012   
	 */
	function DatosEmpleadosAreas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_sel';
		$this->codigo_procedimiento = "'KP_DATOSEMP_REP'";

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

		 $this->var->add_def_cols('id_unidad_organizacional',' INTEGER');
         $this->var->add_def_cols('prioridad',' VARCHAR'); 
         $this->var->add_def_cols('area','VARCHAR'); 
         $this->var->add_def_cols('nombre_unidad','VARCHAR(100)'); 
		 $this->var->add_def_cols('codigo_empleado','VARCHAR(20)'); 
		$this->var->add_def_cols('nombre_completo','TEXT'); 
		$this->var->add_def_cols('doc_id','VARCHAR(50)'); 
		$this->var->add_def_cols('expedicion','VARCHAR(50)'); 
		$this->var->add_def_cols('fecha_nacimiento','DATE'); 
		$this->var->add_def_cols('nombre_cargo','VARCHAR(150)'); 
		$this->var->add_def_cols('cod_uniorg','VARCHAR(15)'); 
		$this->var->add_def_cols('fecha_asignacion','DATE'); 
		$this->var->add_def_cols('cod_columna','VARCHAR(30)'); 
		$this->var->add_def_cols('valor','NUMERIC(18,2)');
		/*$this->var->add_def_cols('codigo_empleado','varchar'); 
 		$this->var->add_def_cols('nombre_completo','text'); 
  		//$this->var->add_def_cols('doc_id',' VARCHAR'); 
 		$this->var->add_def_cols('desc_atraso','numeric');
 		$this->var->add_def_cols('hrs_aprobado','interval');*/
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
	
	/**
	 * Nombre de la función:	DatosEmpleadoSindicato
	 * Propï¿½sito:				Desplegar datos de empleados con sus respectivos sindicatos
	 * Autor:				    avillegas
	 * Fecha de creaciï¿½n:		12/03/2013
	 */
	function DatosEmpleadosSindicato($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{  
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_empleado_sel';
		$this->codigo_procedimiento = "'KP_DATOSEMPSIND_REP'";

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

		 $this->var->add_def_cols('lugar_trabajo','varchar');
         $this->var->add_def_cols('nombre_completo',' VARCHAR'); 
         $this->var->add_def_cols('valor','numeric'); 
         $this->var->add_def_cols('codigo_sindicato','VARCHAR'); 
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