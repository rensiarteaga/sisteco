<?php
/**
 * Nombre de la clase:	cls_DBAdmCheque.php
 * Propósito:			Permite ejecutar las funcionalidades para la impresión de cheques
 * Autor:				RCM
 * Fecha creación:		09/11/2009
 */

 
class cls_DBAdmCheque{
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
	 * Nombre de la función:	ListarAdmCheque
	 * Propósito:				Desplegar los cheques
	 * Autor:				    RCM
	 * Fecha de creación:		09/11/2009
	 */
	function ListarAdmCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_adm_cheque_sel';
		$this->codigo_procedimiento = "'TS_ADMCHE_SEL'";

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
		$this->var->add_def_cols('id_cheque','integer');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
		$this->var->add_def_cols('fecha_cheque','date');
		$this->var->add_def_cols('nombre_cheque','varchar');
		$this->var->add_def_cols('nro_cheque','integer');
		$this->var->add_def_cols('importe_cheque','numeric');
		$this->var->add_def_cols('id','integer');
		$this->var->add_def_cols('fecha_desde','text');
		$this->var->add_def_cols('fecha_hasta','text');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_empleado_origen','integer');
		$this->var->add_def_cols('desc_empleado_origen','text');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('tipo_especifico','varchar');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('banco','varchar');
		$this->var->add_def_cols('nro_cuenta_banco','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('tipo_largo','varchar');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('nombre_depto','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*if ($_SESSION["ss_id_usuario"]==131)
		{
		   echo $this->query;
		   exit;
		}*/
		//echo $this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarAdmCheque
	 * Propósito:				Contar los registros
	 * Autor:				    RCM
	 * Fecha de creación:		09/11/2009
	 */
	function ContarAdmCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_adm_cheque_sel';
		$this->codigo_procedimiento = "'TS_ADMCHE_COUNT'";

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
	 * Nombre de la función:	FinImpresionCheque
	 * Propósito:				Permite ejecutar una acción posterior a la impresión de cheques
	 * Autor:				    RCM
	 * Fecha de creación:		10/11/2009
	 */
	function FinImpresionCheque($tipo,$tipo_especifico,$id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_adm_cheque_iud';
		$this->codigo_procedimiento = "'TS_ESTADO_MOD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$tipo_especifico'");
		$this->var->add_param($id);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		if ($_SESSION["ss_id_usuario"]==131){
			echo $this->query;
			exit;
		}
		return $res;
	}
	
	
}?>