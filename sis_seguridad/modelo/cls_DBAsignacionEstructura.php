<?php
/**
 * Nombre de la clase:	cls_DBAsignacionEstructura.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_asignacion_estructura
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2007-10-31 11:34:02
 */

class cls_DBAsignacionEstructura
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

	
	
	/************************************************************************************************/
	function ListarEPUsuarioSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_sel';
		$this->codigo_procedimiento = "'SG_EPUSUASCI_SEL'";



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
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('id_prog_proy_acti','integer');
		
		
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		
		$this->var->add_def_cols('desc_epe','text');

	
  
		
		//Verifca si se aplica un filtro a nivel de funci�n
	 
			//Ejecuta la funci�n de consulta
			$res = $this->var->exec_query();

			//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
			$this->salida = $this->var->salida;

			//Obtiene la cadena con que se llam� a la funci�n de postgres
			$this->query = $this->var->query;
/*	echo " ".$this->query;
		exit;*/
	return $res;
	}

	/**
	 * Nombre de la funci�n:	ContarEPEUsuario
	 * Prop�sito:				Contar los registros de tsg_asignacion_estructura
	 * Autor:				    RCM
	 * Fecha de creaci�n:		28/07"008
	 */
	function ContarEPUsuarioSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_sel';
		$this->codigo_procedimiento = "'SG_EPUSUASCI_COUNT'";

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
		//$this->var->add_filtro_funcion('id_fina_regi_prog_proy_acti in  (select id_fina_regi_prog_proy_acti from presto.tpr_presupuesto where id_fuente_financiamiento=16)');
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
	/*echo " ".$this->query;
		exit;*/
		//Retorna el resultado de la ejecuci�n
		return $res;
	}

	/*************************************************************************************************/

	/**
	 * Nombre de la funci�n:	ListarAsignacionEstructura
	 * Prop�sito:				Desplegar los registros de tsg_asignacion_estructura
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:02
	 */
	function ListarAsignacionEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_sel';
		$this->codigo_procedimiento = "'SG_ASIEST_SEL'";

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
		$this->var->add_def_cols('id_asignacion_estructura','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');
		$this->var->add_def_cols('validar_estructura','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*
		echo ($this->query);
		exit();*/
		return $res;
	}

	/**
	 * Nombre de la funci�n:	ContarAsignacionEstructura
	 * Prop�sito:				Contar los registros de tsg_asignacion_estructura
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:02
	 */
	function ContarAsignacionEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_sel';
		$this->codigo_procedimiento = "'SG_ASIEST_COUNT'";

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
	 * Nombre de la funci�n:	InsertarAsignacionEstructura
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tsg_asignacion_estructura
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:02
	 */
	function InsertarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_iud';
		$this->codigo_procedimiento = "'SG_ASIEST_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$validar_estructura'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la funci�n:	ModificarAsignacionEstructura
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tsg_asignacion_estructura
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:02
	 */
	function ModificarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_iud';
		$this->codigo_procedimiento = "'SG_ASIEST_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_asignacion_estructura);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$validar_estructura'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la funci�n:	EliminarAsignacionEstructura
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tsg_asignacion_estructura
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:02
	 */
	function EliminarAsignacionEstructura($id_asignacion_estructura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_iud';
		$this->codigo_procedimiento = "'SG_ASIEST_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_asignacion_estructura);
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

		return $res;
	}

	/**
	 * Nombre de la funci�n:	ListarEPEUsuario
	 * Prop�sito:				Despliega las EPE's del usuario
	 * Autor:				    RCM
	 * Fecha de creaci�n:		28/07/2008
	 */
	function ListarEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$filtro_funcion='',$count=0)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_sel';
		$this->codigo_procedimiento = "'SG_EPUSUA_SEL'";

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
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('codigo_actividad','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');

		//Verifca si se aplica un filtro a nivel de funci�n
		if($filtro_funcion!=''){
			$this->var->add_filtro_funcion($filtro_funcion);
		}

		//Verifica si se ejecutar� la consulta para contar los registros
		if($count){
			//Ejecuta la funci�n de consulta
			$res = $this->var->exec_query('COUNT(*)');

			//Obtiene el array de salida de la funci�n
			$this->salida = $this->var->salida;

			//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
			if($res)
			{
				$this->salida = $this->var->salida[0][0];
			}
		}
		else{
			//Ejecuta la funci�n de consulta
			$res = $this->var->exec_query();

			//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
			$this->salida = $this->var->salida;

			//Obtiene la cadena con que se llam� a la funci�n de postgres
			$this->query = $this->var->query;
		}

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;


		/*echo"<pre>";
		print_r($this->salida);
		echo"</pre>";*/



		//echo "query: ".$this->query;
		//exit;

		return $res;
	}

	/**
	 * Nombre de la funci�n:	ContarEPEUsuario
	 * Prop�sito:				Contar los registros de tsg_asignacion_estructura
	 * Autor:				    RCM
	 * Fecha de creaci�n:		28/07"008
	 */
	function ContarEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_sel';
		$this->codigo_procedimiento = "'SG_EPUSUA_COUNT'";

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
		//$this->var->add_filtro_funcion('id_fina_regi_prog_proy_acti in  (select id_fina_regi_prog_proy_acti from presto.tpr_presupuesto where id_fuente_financiamiento=16)');
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
	 * Nombre de la funci�n:	ValidarAsignacionEstructura
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tsg_asignacion_estructura
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:02
	 */
	function ValidarAsignacionEstructura($operacion_sql,$id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura)
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
				//Validar id_asignacion_estructura - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_asignacion_estructura");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_asignacion_estructura", $id_asignacion_estructura))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_registro", $fecha_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_registro - tipo time
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_registro");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_registro", $hora_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar fecha_ultima_modificacion - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ultima_modificacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ultima_modificacion", $fecha_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_ultima_modificacion - tipo time
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_ultima_modificacion");
			$tipo_dato->set_MaxLength(8);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_ultima_modificacion", $hora_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar validar_estructura - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("validar_estructura");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "validar_estructura", $validar_estructura))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validaci�n de reglas de datos

			//Validar validar_estructura
			$check = array ("si","no");
			if(!in_array($validar_estructura,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validaci�n en columna 'validar_estructura': El valor no est� dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarAsignacionEstructura";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_asignacion_estructura - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_asignacion_estructura");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_asignacion_estructura", $id_asignacion_estructura))
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
}?>