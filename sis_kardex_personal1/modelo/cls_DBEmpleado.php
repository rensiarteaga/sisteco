<?php
/**
 * Nombre de la Clase:	cls_DBEmpleado
 * Prop�sito:			Permite ejecutar la funcionalidad de la tabla tkp_empleado
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creaci�n:		21-06-2007
 *
 */
class cls_DBEmpleado
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

	//Nombre del archivo
	var $nombre_archivo = "cls_DBEmpleado.php";

	//Matriz de par�metros de validaci�n de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificar�n o nofe
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los par�metro de validaci�n de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la funci�n:	ListarEmpleado
	 * Prop�sito:				Desplegar los registros de tkp_empleado en funci�n de los par�metros del filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creaci�n:		21-06-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMP_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('nombre_tipo_documento','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('email1','varchar');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la funci�n:	ContarListaEmpleado
	 * Prop�sito:				Contar el total de registros desplegados en funci�n de los par�metros de filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creaci�n:		21-06-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarListaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMP_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	
	/**
	 * Nombre de la funci�n:	ListarEmpleadoRep
	 * Prop�sito:				Desplegar los registros de tkp_empleado en funci�n de los par�metros del filtro
	 * Autor:					Veimar Soliz Poveda 
	 * Fecha de creaci�n:		26-07-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarEmpleadoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_consultas';
		$this->codigo_procedimiento = "'KP_EMP_SEL_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('apellido_paterno','varchar');
		$this->var->add_def_cols('apellido_materno','varchar');
		$this->var->add_def_cols('nombre','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la funci�n:	ContarListaEmpleadoRep
	 * Prop�sito:				Contar el total de registros desplegados en funci�n de los par�metros de filtro para el Reporte
	 * Autor:					Veimar Soliz Poveda
	 * Fecha de creaci�n:		26-07-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarListaEmpleadoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_consultas';
		$this->codigo_procedimiento = "'KP_EMP_SEL_COUNT_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	
	
	
	/////////////////////////////////////////////////////////////////
	///////////// �LTIMA VERSI�N (C�DIGO AUTOGENERADO) //////////////
	///////////////////////////////////////////////////////////////// 
	
	/**
	 * Nombre de la funci�n:	ListarEmpleado
	 * Prop�sito:				Desplegar los registros de tkp_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 * Fecha ultima de mod:     20/07/2009
	 * Descripci�n:             Se a�adio los atributos fecha_reg, estado_reg
	 */
	function ListarEmpleado_($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{//Este m�todo es el �ltimo creado, y est� con el gui�n bajo porque el antiguo se llama igual
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPLEA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		if($_SESSION['kp_bandera_correspondencia']==1)
		{	
			$this->var->add_param("'correspondencia'");//id_financiador
			$this->var->add_param("'".$_SESSION['ss_id_usuario']."'");//id_regional
			$_SESSION['kp_bandera_correspondencia']=0;
		}
		else
		{ 
			$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_finanaciador'"));//id_financiador	
			$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		}
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('nombre_unidad_presupuesta','varchar');
		
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('nombre_tipo_documento','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('email1','varchar');
		
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('nombre_auxiliar','varchar');
        $this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*if ($_SESSION['ss_id_usuario']==120){
		 echo $this->query;
		 exit;   
		}*/
		return $res;
	}
	
	function ListarFuncionario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{//Este m�todo es el �ltimo creado, y est� con el gui�n bajo porque el antiguo se llama igual
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_FUNCIONARIO_SEL'";

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
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('nombre_unidad_presupuesta','varchar');
		
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('nombre_tipo_documento','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('email1','varchar');
		
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('nombre_auxiliar','varchar');
        $this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('desc_depto','text');
		$this->var->add_def_cols('id_lugar_trabajo','integer');
		$this->var->add_def_cols('desc_lugar','varchar');
		$this->var->add_def_cols('fecha_ingreso','date');
		$this->var->add_def_cols('antiguedad_ant','integer');
		
		$this->var->add_def_cols('id_usuario_reg','integer');
		$this->var->add_def_cols('id_escala_salarial','integer');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('desc_escala_salarial','text');
		$this->var->add_def_cols('compensa','varchar');
		$this->var->add_def_cols('marca','varchar');
		
		$this->var->add_def_cols('foto_persona','bytea','numero','extension','../../../sis_seguridad/control/persona/archivo/',true);
		$this->var->add_def_cols('numero','bigint');
		$this->var->add_def_cols('extension','varchar');
		$this->var->add_def_cols('nombre_foto','varchar');
		$this->var->add_def_cols('nivel_academico','varchar');
		$this->var->add_def_cols('tiene_descuento','varchar');
		
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
	 * Nombre de la funci�n:	ListarEmpleadoGerencia
	 * Prop�sito:				Desplegar los registros de tkp_empleado
	 * Autor:				    Fernando Prudencio
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function ListarEmpleadoGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{//Este m�todo es el �ltimo creado, y est� con el gui�n bajo porque el antiguo se llama igual
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPLEA_GER_SEL'";

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
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('nombre_tipo_documento','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('email1','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ListarEmpleado
	 * Prop�sito:				Desplegar los registros de tkp_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function ListarEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{//Este m�todo es el �ltimo creado, y est� con el gui�n bajo porque el antiguo se llama igual
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPLEA_SELEP'";
		
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
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('nombre_tipo_documento','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('email1','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo"querry: ".$this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarEmpleado
	 * Prop�sito:				Contar los registros de tkp_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function ContarEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPLEA_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		if($_SESSION['kp_bandera_correspondencia']==1)
		{	
			$this->var->add_param("'correspondencia'");//id_financiador
			$this->var->add_param("'".$_SESSION['ss_id_usuario']."'");//id_regional
		}
		else
		{ 
			$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_finanaciador'"));//id_financiador	
			$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		}
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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	function ContarFuncionario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_FUNCIONARIO_COUNT'";

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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ContarEmpleadoGerencia
	 * Prop�sito:				Contar los registros de tkp_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function ContarEmpleadoGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPLEA_GER_COUNT'";

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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ContarEmpleado
	 * Prop�sito:				Contar los registros de tkp_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function ContarEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPLEA_COUNTEP'";

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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	
	function ListarEmpleadoUsuarioEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{//Este m�todo es el �ltimo creado, y est� con el gui�n bajo porque el antiguo se llama igual
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPUSU_SELEP'";
		
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
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('nombre_tipo_documento','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('email1','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ContarEmpleadoUsuarioEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPUSU_COUNTEP'";

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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	function ListarEmpleadoLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{//Este m�todo es el �ltimo creado, y est� con el gui�n bajo porque el antiguo se llama igual
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMP_LIC'";
		
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
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('tipo_contrato','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ContarEmpleadoLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMP_LIC_COUNT'";

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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	/**
	 * Nombre de la funci�n:	InsertarEmpleado
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tkp_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 * Fecha ultima de mod:     20/07/2009
	 * Descripci�n:             Se a�adio los atributos fecha_reg, estado_reg
	
	 */
	function InsertarEmpleado($id_empleado,$id_persona,$codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg,$id_depto,$id_lugar,$fecha_ingreso,$antiguedad_ant,$id_escala_salarial,$compensa,$marca
	,$nivel_academico,$tiene_descuento
	)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_iud';
		$this->codigo_procedimiento = "'KP_EMPLEA_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_persona);
		$this->var->add_param("'$codigo_empleado'");
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param($id_depto);
		$this->var->add_param($id_lugar);
		$this->var->add_param("'$fecha_ingreso'");
		$this->var->add_param($antiguedad_ant);
		$this->var->add_param($id_escala_salarial);
		$this->var->add_param("'$compensa'");
		$this->var->add_param("'$marca'");
		$this->var->add_param("'$nivel_academico'");
		$this->var->add_param("'$tiene_descuento'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarEmpleado
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tkp_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function ModificarEmpleado($id_empleado,$id_persona,$codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg,$id_depto,$id_lugar,$fecha_ingreso,$antiguedad_ant,$id_escala_salarial,$compensa,$marca
	,$nivel_academico
	,$tiene_descuento
	)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_iud';
		$this->codigo_procedimiento = "'KP_EMPLEA_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_persona);
		$this->var->add_param("'$codigo_empleado'");
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param($id_depto);
		$this->var->add_param($id_lugar);
		$this->var->add_param("'$fecha_ingreso'");
		$this->var->add_param($antiguedad_ant);
		$this->var->add_param($id_escala_salarial);
		$this->var->add_param("'$compensa'");
		$this->var->add_param("'$marca'");
		$this->var->add_param("'$nivel_academico'");
		$this->var->add_param("'$tiene_descuento'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query ;
		exit();*/

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarEmpleado
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tkp_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function EliminarEmpleado($id_empleado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_iud';
		$this->codigo_procedimiento = "'KP_EMPLEA_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fecha_ingreso
		$this->var->add_param("NULL");//antiguedad_ant
		$this->var->add_param("NULL");//($id_escala_salarial);
		$this->var->add_param("NULL");//$compensa
		$this->var->add_param("NULL");//$marca
		$this->var->add_param("NULL");//"'$nivel_academico'");
		$this->var->add_param("'$mail'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarEmpleado
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tkp_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function ValidarEmpleado($operacion_sql,$id_empleado,$id_persona,$codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validaci�n por el tipo de operaci�n
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_empleado - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_empleado");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_persona - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_persona");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_persona", $id_persona))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo_empleado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_empleado");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_empleado", $codigo_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_cuenta - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_auxiliar - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_auxiliar");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_auxiliar", $id_auxiliar))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validaci�n exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	///////////// FIN �LTIMA VERSI�N (C�DIGO AUTOGENERADO) //////////////
	
	
	function ListarEmpleados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
	    //Este m�todo es el �ltimo creado, y est� con el gui�n bajo porque el antiguo se llama igual
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPLEAD_SEL'";

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
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('nombre_tipo_documento','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('email1','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	function ContarEmpleados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_EMPLEAD_COUNT'";

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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	function InsertarEmpleadoSuplente($id_empleado,$id_empleado_suplente,$subsis,$vista)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_iud';
		$this->codigo_procedimiento = "'KP_EMPSUP_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_empleado_suplente);
		$this->var->add_param("'$subsis'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$vista'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//$compensa
		$this->var->add_param("NULL");//$marca
		$this->var->add_param("null");
		$this->var->add_param("null");
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
	
  function ListarSelPersonal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_SELPER_SEL'";

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
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('id_tipo_doc_identificacion','integer');
		$this->var->add_def_cols('genero','varchar');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('celular1','varchar');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('fecha_nacimiento','date');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('nro_registro','varchar');
		
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
	
	function ContarSelPersonal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_SELPER_COUNT'";

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

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	
	/*AQUI FALTA empleado_hoja_vida*/
	
	////////////////////04Nov11: enviar informacion de cambios en empleado///////////////////
	function ListarInformacionEmpleadoMail($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_sel';
		$this->codigo_procedimiento = "'KP_INFEMPMAIL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par?metros espec?ficos de la estructura program?tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		

		//Carga la definici?n de columnas con sus tipos de datos
		
	
		$this->var->add_def_cols('empleado','text');
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('ultima_mod_empleado','date');
		$this->var->add_def_cols('nivel_academico','varchar');
		$this->var->add_def_cols('fecha_ingreso','date');
		$this->var->add_def_cols('usuregemp','integer');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('id_lugar','integer');
		$this->var->add_def_cols('lugar','varchar');
		$this->var->add_def_cols('id_usuario_reg','integer');
		$this->var->add_def_cols('usuario_reg','text');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('id_usuario_mod','integer');
		$this->var->add_def_cols('usario_mod','text');
		$this->var->add_def_cols('fecha_ultima_mod','timestamp');	
		$this->var->add_def_cols('fecha_asignacion','date');
		$this->var->add_def_cols('fecha_finalizacion','date');
		$this->var->add_def_cols('id_contrato','integer');
		$this->var->add_def_cols('nro_contrato','integer');
		$this->var->add_def_cols('tipo_contrato','varchar');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('eventual','varchar');
		$this->var->add_def_cols('tiene_quincena','varchar');
		$this->var->add_def_cols('socio_cooperativa','varchar');
		$this->var->add_def_cols('dependencia','varchar');
		
		
		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	/********************* MZM - 08Nov11: asignacion de correo a funcionario ************************/
	function ModificarEmpleadoCorreo($id_empleado, $mail)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_empleado_iud';
		$this->codigo_procedimiento = "'KP_EMPCORR_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado);
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("'$mail'");
		$this->var->add_param("null");
		$this->var->add_param("null");
		
		//$this->var->add_param("'$mail'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
}
?>