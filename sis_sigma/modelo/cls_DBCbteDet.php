<?php
/**
 * Nombre de la clase:	cls_DBCbteDet.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_Declaracion
 * Autor:				(autogenerado)
 * Fecha creación:		2008-09-16 17:55:36
 */
 
class cls_DBCbteDet
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
	 * Nombre de la función:	ListarCabCbte
	 * Propósito:				Desplegar los registros de tct_Declaracion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ListarCbteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cbte_det_sel';
		$this->codigo_procedimiento = "'SI_CBTEDE_SEL'";

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
		$this->var->add_def_cols('id_cbte_det','integer');
		$this->var->add_def_cols('ent_trf','varchar');
		$this->var->add_def_cols('libreta','varchar');
		$this->var->add_def_cols('importe','numeric');
	 	$this->var->add_def_cols('tipo_dato','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
		$this->var->add_def_cols('id_cab_cbte','integer');
		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('id_partida','integer');
		$this->var->add_def_cols('id_oec','integer');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
		$this->var->add_def_cols('id_transaccion','integer');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('partida','text');
		$this->var->add_def_cols('sigla_oec','varchar');
		$this->var->add_def_cols('codigo_oec','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('banco','varchar');
		$this->var->add_def_cols('reportar','varchar');
		$this->var->add_def_cols('fuente_fin','varchar');
		$this->var->add_def_cols('organismo_fin','varchar');
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('actividad','varchar');
		$this->var->add_def_cols('desc_cuenta','text');
		$this->var->add_def_cols('cuenta_sigma','varchar');
		$this->var->add_def_cols('modificado','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCbteDet
	 * Propósito:				Contar los registros de tct_Declaracion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ContarCbteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cbte_det_sel';
		$this->codigo_procedimiento = "'SI_CBTEDE_COUNT'";

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

		/*	echo $this->query;
		exit();*/		
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function InsertarCbteDet($id_cbte_det,$tipo,$tipo_dato,$reportar,$ent_trf,$id_cab_cbte,$id_cuenta_bancaria,$id_partida,$id_presupuesto,$importe,$libreta,$cuenta_sigma,$id_transaccion,$modificado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cbte_det_iud';
		$this->codigo_procedimiento = "'SI_CBTEDE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$tipo_dato'");
		$this->var->add_param("'$reportar'");
		$this->var->add_param("'$ent_trf'");
		$this->var->add_param("$id_cab_cbte");
		$this->var->add_param("$id_cuenta_bancaria");
		$this->var->add_param("$id_partida");
		$this->var->add_param("$id_presupuesto");
		$this->var->add_param("$importe");
		$this->var->add_param("'$libreta'");
        $this->var->add_param("'$cuenta_sigma'");
        $this->var->add_param("$id_transaccion");
        $this->var->add_param("'$modificado'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	function ModificarCbteDet($id_cbte_det,$tipo,$tipo_dato,$reportar,$ent_trf,$id_cab_cbte,$id_cuenta_bancaria,$id_partida,$id_presupuesto,$importe,$libreta,$cuenta_sigma,$modificado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cbte_det_iud';
		$this->codigo_procedimiento = "'SI_CBTEDE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cbte_det");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$tipo_dato'");
		$this->var->add_param("'$reportar'");
		$this->var->add_param("'$ent_trf'");
		$this->var->add_param("$id_cab_cbte");
		$this->var->add_param("$id_cuenta_bancaria");
		$this->var->add_param("$id_partida");
		$this->var->add_param("$id_presupuesto");
		$this->var->add_param("$importe");
		$this->var->add_param("'$libreta'");
        $this->var->add_param("'$cuenta_sigma'");
        $this->var->add_param("$id_transaccion");
        $this->var->add_param("'$modificado'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function EliminarCbteDet($id_cbte_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cbte_det_iud';
		$this->codigo_procedimiento = "'SI_CBTEDE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cbte_det");
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
        $this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ListarTransac($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cbte_det_sel';
		$this->codigo_procedimiento = "'SI_TRANSA_SEL'";

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
		$this->var->add_def_cols('id_transaccion','integer');
		$this->var->add_def_cols('cuenta','text');
		$this->var->add_def_cols('cuenta_sigma','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;exit;

		return $res;
	}
	
	function ContarTransac($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_cbte_det_sel';
		$this->codigo_procedimiento = "'SI_TRANSA_COUNT'";

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

		/*	echo $this->query;
		exit();*/		
		//Retorna el resultado de la ejecución
		return $res;
	}


}?>