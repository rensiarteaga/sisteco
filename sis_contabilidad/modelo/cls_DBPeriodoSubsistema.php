<?php
/**
 * Nombre de la clase:	cls_DBPeriodoSubsistema.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_periodo_subsistema
 * Autor:				(autogenerado)
 * Fecha creación:		2008-12-01 14:49:33
 */

 
class cls_DBPeriodoSubsistema
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
	 * Nombre de la función:	ListarPeriodoSubsistema
	 * Propósito:				Desplegar los registros de tct_periodo_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:33
	 */
	function ListarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_periodo_subsistema_sel';
		$this->codigo_procedimiento = "'CT_PERSIS_SEL'";

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
		$this->var->add_def_cols('id_periodo_subsistema','int4');
		$this->var->add_def_cols('id_periodo','int4');
		$this->var->add_def_cols('desc_periodo','numeric');
		$this->var->add_def_cols('estado_periodo','varchar');
		$this->var->add_def_cols('nombre_largo','text');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_final','date');
		$this->var->add_def_cols('desc_periodo_subsistema','varchar');
		$this->var->add_def_cols('gestion','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*if($_SESSION['ss_id_usuario']=131){
		echo $this->query ; 
		exit;
		
		}*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPeriodoSubsistema
	 * Propósito:				Contar los registros de tct_periodo_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:33
	 */
	function ContarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_periodo_subsistema_sel';
		$this->codigo_procedimiento = "'CT_PERSIS_COUNT'";

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
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarPeriodoSubsistema
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_periodo_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:33
	 */
	function InsertarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$estado_periodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_periodo_subsistema_iud';
		$this->codigo_procedimiento = "'CT_PERSIS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_periodo);
		$this->var->add_param("'$estado_periodo'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	InsertarPeriodoSubsistema
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_periodo_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:33
	 */
	function abrirCerrarPeriodoSubsistema($id_periodo_subsistema, $accion)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_periodo_subsistema_iud';
		$this->codigo_procedimiento = "'CT_PERSIS_PRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_periodo_subsistema");
		$this->var->add_param("null");
		$this->var->add_param("'$accion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPeriodoSubsistema
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_periodo_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:33
	 */
	function ModificarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$estado_periodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_periodo_subsistema_iud';
		$this->codigo_procedimiento = "'CT_PERSIS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_periodo_subsistema);
		$this->var->add_param($id_periodo);
		$this->var->add_param("'$estado_periodo'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPeriodoSubsistema
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_periodo_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:33
	 */
	function EliminarPeriodoSubsistema($id_periodo_subsistema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_periodo_subsistema_iud';
		$this->codigo_procedimiento = "'CT_PERSIS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_periodo_subsistema);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarPeriodoSubsistema
	 * Propósito:				Desplegar los registros de tct_periodo_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:33
	 */
	function ListarPeriodoGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_periodo_subsistema_sel';
		$this->codigo_procedimiento = "'CT_PEGESU_SEL'";

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
		$this->var->add_def_cols('id_periodo_subsistema','int4');
		$this->var->add_def_cols('id_periodo','int4');
		$this->var->add_def_cols('desc_periodo','text');
		$this->var->add_def_cols('estado_periodo','varchar');
		$this->var->add_def_cols('periodo','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*
		 if($_SESSION["ss_id_usuario"]==131){
	      echo $this->query;
	      exit;
	  } */
		//echo $this->query;exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPeriodoSubsistema
	 * Propósito:				Contar los registros de tct_periodo_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:33
	 */
	function ContarPeriodoGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_periodo_subsistema_sel';
		$this->codigo_procedimiento = "'CT_PEGESU_COUNT'";

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
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarPeriodoSubsistema
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_periodo_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:33
	 */
	function ValidarPeriodoSubsistema($operacion_sql,$id_periodo_subsistema,$id_periodo,$estado_periodo)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_periodo_subsistema - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_periodo_subsistema");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_periodo_subsistema", $id_periodo_subsistema))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_periodo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_periodo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_periodo", $id_periodo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_periodo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_periodo");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_periodo", $estado_periodo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_periodo_subsistema - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_periodo_subsistema");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_periodo_subsistema", $id_periodo_subsistema))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validación exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
}?>