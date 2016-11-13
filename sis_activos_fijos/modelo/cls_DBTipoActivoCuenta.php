<?php
/**
 * Nombre de la clase:	cls_DBTipoActivoCuenta
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla taf_tipo_activo_cuenta
 * Autor:				Elmer Velasquez
 * Fecha creación:		01/02/2013
 */
class cls_DBTipoActivoCuenta
{
	//Variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;

	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecución de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la función a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBTipoActivoCuenta";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarTipoActivoCuenta
	 * Propósito:				Desplegar los registros de taf_tipo_activo_cuenta en función de los parámetros del filtro
	 * Autor:					
	 * Fecha de creación:		
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */
	
	/***************************************************************************************************/
	function ListarTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_cuenta_sel';
		$this->codigo_procedimiento = "'AF_TAFCTA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales  
		
		//Instancia la clase middle para la ejecución de la función de la BD 
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_activo_cuenta','integer');
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('descripcion_programa','varchar');
		$this->var->add_def_cols('cuenta_activo','varchar');
		$this->var->add_def_cols('cuenta_dep_acumulada','varchar');
		$this->var->add_def_cols('cuenta_gasto','varchar');
		$this->var->add_def_cols('cuenta_activo_auxiliar','varchar');
		$this->var->add_def_cols('cuenta_dep_acumulada_auxiliar','varchar');
		$this->var->add_def_cols('cuenta_gasto_auxiliar','varchar');
		$this->var->add_def_cols('tension','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('nombre_cuenta_activo','text');
		$this->var->add_def_cols('nombre_cuenta_activo_auxiliar','text');
		$this->var->add_def_cols('id_cta_activo','integer');
		$this->var->add_def_cols('id_cta_activo_auxiliar','integer');
		$this->var->add_def_cols('nombre_cuenta_dep_acumulada','text');
		$this->var->add_def_cols('nombre_cuenta_dep_acumulada_auxiliar','text');
		$this->var->add_def_cols('nombre_cuenta_gasto','text');
		$this->var->add_def_cols('nombre_cuenta_gasto_auxiliar','text');
		$this->var->add_def_cols('id_cta_dep_acum','integer');
		$this->var->add_def_cols('id_cta_dep_acum_auxiliar','integer');
		$this->var->add_def_cols('id_cta_gasto','integer');
		$this->var->add_def_cols('id_cta_gasto_auxiliar','integer');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	CountTipoActivoCuenta
	 * Propósito:				Contar los registros de taf_tipo_activo_cuenta 
	 * Autor:					
	 * Fecha de creación:		
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */
	
	function CountTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_cuenta_sel';
		$this->codigo_procedimiento = "'AF_TAFCTA_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
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
	 * Nombre de la función:	InsertarProceso
	 * Propósito:				Permite ejecutar la función de inserción en la tabla actif.taf_tipo_activo_cuenta
	 * Autor:				    (
	 * Fecha de creación:		
	 */
	function InsertarTipoActivoCuenta($id_tipo_activo_cuenta,$id_tipo_activo,$codigo_programa,$descripcion_programa,$cuenta_activo,$cuenta_depacum,$cuenta_gasto,$cuenta_activo_auxiliar,$cuenta_dep_acumulada_auxiliar,$cuenta_gasto_auxiliar,$id_tension)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_cuenta_iud';
		$this->codigo_procedimiento = "'AF_TAFCTA_INS'";
  
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_activo_cuenta);//af_id_tipo_activo_cuenta
		$this->var->add_param($id_tipo_activo);//af_id_tipo_activo 
		$this->var->add_param("'$codigo_programa'");//af_codigo_programa
		$this->var->add_param("'$descripcion_programa'");//af_descripcion_programa
		$this->var->add_param("'$cuenta_activo'");//af_cuenta_activo
		$this->var->add_param("'$cuenta_depacum'");//af_cuenta_dep_acumulada
		$this->var->add_param("'$cuenta_gasto'");//af_cuenta_gasto
		$this->var->add_param("'$cuenta_activo_auxiliar'");//af_cuenta_activo_auxiliar
		$this->var->add_param("'$cuenta_dep_acumulada_auxiliar'");//af_cuenta_dep_acumulada_auxiliar
		$this->var->add_param("'$cuenta_gasto_auxiliar'");//af_cuenta_gasto_auxiliar
		$this->var->add_param("'$id_tension'");//af_id_tension	

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "query:" .$this->query;
		//exit;
		
		return $res;
	}
	/*
	 * Nombre de la función:	EliminarTipoActivoCuenta
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_activo_fijo_cuenta
	 * Autor:				    
	 * Fecha de creación:		
	 */
	function EliminarTipoActivoCuenta($id_tipo_activo_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_cuenta_iud';
		$this->codigo_procedimiento = "'AF_TAFCTA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_activo_cuenta);//af_id_tipo_activo_cuenta
		$this->var->add_param("NULL");//af_id_tipo_activo
		$this->var->add_param("NULL");//af_codigo_programa
		$this->var->add_param("NULL");//af_descripcion_programa
		$this->var->add_param("NULL");//af_cuenta_activo
		$this->var->add_param("NULL");//af_cuenta_dep_acumulada
		$this->var->add_param("NULL");//af_cuenta_gasto
		$this->var->add_param("NULL");//af_cuenta_activo_auxiliar
		$this->var->add_param("NULL");//af_cuenta_dep_acumulada_auxiliar
		$this->var->add_param("NULL");//af_cuenta_gasto_auxiliar
		$this->var->add_param("NULL");//af_id_tension

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	ModificarTipoActivoCuenta
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_tipo_activo_cuenta
	 * Autor:				    
	 * Fecha de creación:		
	 */
	function ModificarTipoActivoCuenta($id_tipo_activo_cuenta,$id_tipo_activo,$codigo_programa,$descripcion_programa,$cuenta_activo,$cuenta_depacum,$cuenta_gasto,$cuenta_activo_auxiliar,$cuenta_dep_acumulada_auxiliar,$cuenta_gasto_auxiliar,$id_tension)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_cuenta_iud';
		$this->codigo_procedimiento = "'AF_TAFCTA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_activo_cuenta);//af_id_tipo_activo_cuenta
		$this->var->add_param($id_tipo_activo);//af_id_tipo_activo
		$this->var->add_param("'$codigo_programa'");//af_codigo_programa
		$this->var->add_param("'$descripcion_programa'");//af_descripcion_programa
		$this->var->add_param("'$cuenta_activo'");//af_cuenta_activo
		$this->var->add_param("'$cuenta_depacum'");//af_cuenta_dep_acumulada
		$this->var->add_param("'$cuenta_gasto'");//af_cuenta_gasto	
		$this->var->add_param("'$cuenta_activo_auxiliar'");//af_cuenta_activo_auxiliar
		$this->var->add_param("'$cuenta_dep_acumulada_auxiliar'");//af_cuenta_dep_acumulada_auxiliar
		$this->var->add_param("'$cuenta_gasto_auxiliar'");//af_cuenta_gasto_auxiliar
		$this->var->add_param("'$id_tension'");//af_id_tension
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
     
		return $res;	
	}
	/*INICIO FUNCIONES EXTRAS PARA LISTAR LAS CUENTAS CONTABLES REGISTRAS LA ACTUAL GESTION*/
	/**
	 * Nombre de la función:	ContarCuentasContablesGestion
	 * Propósito:				cantidad de cuentas registradas la gestion contable actual
	 * Autor:				    
	 * Fecha de creación:		
	 */
	function ContarCuentasContablesGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_cuenta_sel';
		$this->codigo_procedimiento = "'CTAS_GEST_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
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
		//echo "query:" .$this->query;
		//exit;
		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	ListarCuentasContablesGestion
	 * Propósito:				Lista  las cuentas registradas la gestion contable actual
	 * Autor:				    
	 * Fecha de creación:		
	 */
	function ListarCuentasContablesGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_cuenta_sel';
		$this->codigo_procedimiento = "'CTAS_GEST_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('descripcion','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "query:" .$this->query;
		//exit;
		return $res;
	}
	/*FIN FUNCIONES EXTRAS PARA LISTAR LAS CUENTAS CONTABLES REGISTRAS LA ACTUAL GESTION*/
	
	/**
	 * Nombre de la función:	CountActivoFijoDistribucion
	 * Propósito:				determinar la cantidad de activos fijos con programa distribucion
	 * 							dado un grupo proceso como parametro
	 * Autor:				    
	 * Fecha de creación:		
	 */
	function CountActivoFijoDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_cuenta_sel';
		$this->codigo_procedimiento = "'AF_TAFCTA_COUNTDIST'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
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
	function ListarActivoFijoDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = ""; 		$this->nombre_funcion = 'f_taf_tipo_activo_cuenta_sel';
		$this->codigo_procedimiento = "'AF_TAFCTA_SELDIST'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_activo_fijo','integer'); 
		$this->var->add_def_cols('descripcion_activo_fijo','text');
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('tipo_activo','varchar');
		$this->var->add_def_cols('id_sub_tipo_activo','integer');
		$this->var->add_def_cols('subtipo_activo','varchar');
		$this->var->add_def_cols('programa','text');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('tension','varchar');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
}?>