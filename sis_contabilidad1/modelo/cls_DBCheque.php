<?php
/**
 * Nombre de la clase:	cls_DBCheque.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_cheque
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-17 11:24:35
 */

 
class cls_DBCheque
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
	
	function ListarChequeCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_cbte_sel';
		$this->codigo_procedimiento = "'CT_CHEQUECBTE_SEL'";

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
		$this->var->add_def_cols('id_cheque','INTEGER');
		$this->var->add_def_cols('nombre','VARCHAR');
		$this->var->add_def_cols('nro_cuenta_banco','VARCHAR');
		$this->var->add_def_cols('nro_cheque','INTEGER');
		$this->var->add_def_cols('nombre_cheque','VARCHAR');
		$this->var->add_def_cols('fecha_cheque','date');
		$this->var->add_def_cols('nro_cbte','INTEGER');
		$this->var->add_def_cols('codigo_depto','VARCHAR');
		$this->var->add_def_cols('importe_cheque','NUMERIC');
		$this->var->add_def_cols('moneda','VARCHAR');
		$this->var->add_def_cols('observaciones_anulacion','text');
		$this->var->add_def_cols('estado_cheque','NUMERIC');
     	$this->var->add_def_cols('tipo_cheque','VARCHAR');
		$this->var->add_def_cols('id_cuenta_bancaria','INTEGER');
		$this->var->add_def_cols('desc_banco','text');
		$this->var->add_def_cols('id_comprobante','INTEGER');
		$this->var->add_def_cols('id_moneda','INTEGER');
		$this->var->add_def_cols('simbolo','VARCHAR');
		$this->var->add_def_cols('desc_clase','VARCHAR');
		$this->var->add_def_cols('momento_cbte','NUMERIC');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
 
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCheque
	 * Propósito:				Contar los registros de tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function ContarChequeCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_cbte_sel';
		$this->codigo_procedimiento = "'CT_CHEQUECBTE_COUNT'";

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
	 * Nombre de la función:	ListarCheque
	 * Propósito:				Desplegar los registros de tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function ListarCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_sel';
		$this->codigo_procedimiento = "'CT_CHEQUE_SEL'";

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
		$this->var->add_def_cols('id_cheque','int4');
		$this->var->add_def_cols('id_transaccion','int4');
		$this->var->add_def_cols('desc_transaccion','varchar');
		$this->var->add_def_cols('nro_cheque','int4');
		$this->var->add_def_cols('nro_deposito','varchar');
		$this->var->add_def_cols('fecha_cheque','date');
		$this->var->add_def_cols('nombre_cheque','varchar');
		$this->var->add_def_cols('estado_cheque','numeric');
		$this->var->add_def_cols('id_cuenta_bancaria','int4');
		$this->var->add_def_cols('fecha_cobro','date');
        $this->var->add_def_cols('id_cheque_valor','int4');
        $this->var->add_def_cols('id_moneda','int4');
        $this->var->add_def_cols('nombre_moneda','varchar');
        $this->var->add_def_cols('importe_cheque','numeric');
        $this->var->add_def_cols('nro_cuenta_banco','varchar');
        $this->var->add_def_cols('nro_transaccion','varchar');
        $this->var->add_def_cols('tipo_cheque','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	   //  echo $this->query;
	    //exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCheque
	 * Propósito:				Contar los registros de tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function ContarCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_sel';
		$this->codigo_procedimiento = "'CT_CHEQUE_COUNT'";

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
	 * Nombre de la función:	ListarLibretaBancaria
	 * Propósito:				Desplegar los registros de tct_cheque
	 * Autor:				    ana maria v. q.
	 * Fecha de creación:		01/02/2010
	 */
	function ListarLibretaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libreta_bancaria_sel';
		$this->codigo_procedimiento = "'CT_LIBBAN_SEL'";

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
        $this->var->add_param($id_cuenta_bancaria);//id_cuenta_bancaria
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");//fecha_inicio
        $this->var->add_param("'$fecha_fin'");//fecha_fin
        $this->var->add_param("'$m_sw_actualizacion'");//fecha_fin
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_comprobante','integer');
		  $this->var->add_def_cols('fecha_cbte','text');
		
		$this->var->add_def_cols('comprobante','varchar');
		$this->var->add_def_cols('num_cheque','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('concepto','varchar');
		$this->var->add_def_cols('importe_deposito','numeric');
        $this->var->add_def_cols('importe_cheque','numeric');
		$this->var->add_def_cols('estado','numeric');
        $this->var->add_def_cols('saldo','numeric');
      	$this->var->add_def_cols('fecha_libreta','date');
      	//$this->var->add_def_cols('valor_anulado','numeric');
        
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
/*echo $this->query;
	    exit; */
		return $res;
	}
	/**
	 * Nombre de la función:	ContarCheque
	 * Propósito:				Contar los registros de tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function ContarLibretaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libreta_bancaria_sel';
		$this->codigo_procedimiento = "'CT_LIBBAN_COUNT'";

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
        $this->var->add_param($id_cuenta_bancaria);//id_cuenta_bancaria
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");//fecha_inicio
        $this->var->add_param("'$fecha_fin'");//fecha_fin
        $this->var->add_param("'$m_sw_actualizacion'");//fecha_fin

		
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
	 * Nombre de la función:	ListarLibretaBancariaAnulado
	 * Propósito:				Desplegar los registros de tct_cheque
	 * Autor:				    ana maria v. q.
	 * Fecha de creación:		01/02/2010
	 */
	function ListarLibretaBancariaAnulado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libreta_bancaria_sel';
		$this->codigo_procedimiento = "'CT_LIBBAN_NULO_SEL'";

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
        $this->var->add_param($id_cuenta_bancaria);//id_cuenta_bancaria
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");//fecha_inicio
        $this->var->add_param("'$fecha_fin'");//fecha_fin
        $this->var->add_param("'$m_sw_actualizacion'");//fecha_fin
		
        //Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('fecha_reg','text');
		$this->var->add_def_cols('fecha_cbte','text');
		$this->var->add_def_cols('comprobante','text');
		$this->var->add_def_cols('num_cheque','integer');
		$this->var->add_def_cols('importe_cheque','numeric');
		$this->var->add_def_cols('nombre_cheque','varchar');
		$this->var->add_def_cols('observaciones_anulacion','text');
        $this->var->add_def_cols('usuario_reg','varchar');
        
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
/**
	 * Nombre de la función:	ContarChequeAnulado
	 * Propósito:				Contar los registros de tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function ContarLibretaBancariaAnulado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libreta_bancaria_sel';
		$this->codigo_procedimiento = "'CT_LIBBAN_NULO_COUNT'";

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
        $this->var->add_param($id_cuenta_bancaria);//id_cuenta_bancaria
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");//fecha_inicio
        $this->var->add_param("'$fecha_fin'");//fecha_fin
        $this->var->add_param("'$m_sw_actualizacion'");//fecha_fin

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
	 * Nombre de la función:	InsertarCheque
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function InsertarCheque($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$estado_cheque,$id_cuenta_bancaria,$nombre_tabla,$nombre_campo,$id_tabla,$id_moneda,$importe_cheque,$cambio_estado,$tipo_cheque)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_iud';
		$this->codigo_procedimiento = "'CT_CHEQUE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_transaccion);
		$this->var->add_param($nro_cheque);
		$this->var->add_param("'$nro_deposito'");
		$this->var->add_param("'$fecha_cheque'");
		$this->var->add_param("'$nombre_cheque'");
		$this->var->add_param($estado_cheque);
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$nombre_campo'");
		$this->var->add_param("$id_tabla");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$importe_cheque");
		$this->var->add_param("'$cambio_estado'");
		$this->var->add_param("'$tipo_cheque'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	function InsertarChequeRegTra($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria,$tipo_cheque,$id_moneda,$importe_cheque,$tipo_cambio,$nro_transaccion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestionar_cheque_iud';
		$this->codigo_procedimiento = "'CT_CHEQUEREGTRA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_transaccion);
		$this->var->add_param($nro_cheque);
		$this->var->add_param("'$nro_deposito'");
		$this->var->add_param("'$fecha_cheque'");
		$this->var->add_param("'$nombre_cheque'");
		$this->var->add_param($estado_cheque);
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$nombre_campo'");
		$this->var->add_param("$id_tabla");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$importe_cheque");
		$this->var->add_param("'$cambio_estado'");
		$this->var->add_param("'$tipo_cheque'");
		
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$tipo_cambio");
		$this->var->add_param("'$nro_transaccion'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	function ModificarChequeRegTra($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria,$tipo_cheque,$id_moneda,$importe_cheque,$tipo_cambio,$nro_transaccion,$estado_cheque)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestionar_cheque_iud';
		$this->codigo_procedimiento = "'CT_CHEQUEREGTRA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cheque");
		$this->var->add_param($id_transaccion);
		$this->var->add_param($nro_cheque);
		$this->var->add_param("'$nro_deposito'");
		$this->var->add_param("'$fecha_cheque'");
		$this->var->add_param("'$nombre_cheque'");
		$this->var->add_param($estado_cheque);
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$nombre_campo'");
		$this->var->add_param("$id_tabla");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$importe_cheque");
		$this->var->add_param("'$cambio_estado'");
		$this->var->add_param("'$tipo_cheque'");
		
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$tipo_cambio");
		$this->var->add_param("'$nro_transaccion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ModificarChequeAnula($id_cheque,$estado_cheque,$nombre_cheque,$observaciones_anulacion,$tipo_cheque,$id_cuenta_bancaria,$nro_cheque,$fecha,$nro_doc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_cbte_iud';
		$this->codigo_procedimiento = "'CT_CHEQUECBTE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cheque");
		$this->var->add_param($estado_cheque);
		$this->var->add_param("'$nombre_cheque'");
		$this->var->add_param("'$observaciones_anulacion'");
		$this->var->add_param("'$tipo_cheque'");
		$this->var->add_param("$id_cuenta_bancaria");
		$this->var->add_param("$nro_cheque"); 
		$this->var->add_param("'$fecha'"); 
 		$this->var->add_param("'$nro_doc'"); 
 
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
 
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCheque
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function ModificarCheque($id_cheque,$estado_cheque,$fecha_cobro,$nro_cheque,$fecha_cheque,$nombre_cheque)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_conciliacion_iud';
		$this->codigo_procedimiento = "'CT_CONCIL_UPD'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cheque);
		$this->var->add_param($estado_cheque);
		$this->var->add_param("'$fecha_cobro'");
		$this->var->add_param($nro_cheque);
		$this->var->add_param("'$fecha_cheque'");
		$this->var->add_param("'$nombre_cheque'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
      
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCheque
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function EliminarCheque($id_cheque)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_iud';
		$this->codigo_procedimiento = "'CT_SCCHEQ_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cheque);
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
	 * Nombre de la función:	ValidarCheque
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function ValidarCheque($operacion_sql,$id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$nro_deposito,$fecha_cheque,$nombre_cheque,$estado_cheque,$id_cuenta_bancaria)
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
				//Validar id_cheque - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cheque");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cheque", $id_cheque))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_transaccion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_transaccion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_transaccion", $id_transaccion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_cheque - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_cheque");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_cheque", $nro_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_deposito - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_deposito");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_deposito", $nro_deposito))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_deposito - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_deposito");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_deposito", $nro_deposito))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_cheque - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_cheque");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_cheque", $fecha_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_cheque - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_cheque");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_cheque", $nombre_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_cheque - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_cheque");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_cheque", $estado_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cuenta_bancaria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_bancaria");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_bancaria", $id_cuenta_bancaria))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cheque - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cheque");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cheque", $id_cheque))
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
	
	
	/**
	 * Nombre de la función:	ListarChequeAnulacion
	 * Propósito:				Desplegar los registros de tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function ListarChequeAnulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_sel';
		$this->codigo_procedimiento = "'CT_CHEANU_SEL'";

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
		$this->var->add_def_cols('id_cheque','int4');
		$this->var->add_def_cols('nro_cheque','int4');
		$this->var->add_def_cols('fecha_cheque','text');
		$this->var->add_def_cols('nombre_cheque','varchar');
		$this->var->add_def_cols('estado_cheque','numeric');
		$this->var->add_def_cols('nro_cuenta_banco','varchar');
		$this->var->add_def_cols('banco','varchar');
		$this->var->add_def_cols('importe_cheque','numeric');
		$this->var->add_def_cols('mon_simbolo','varchar');
		$this->var->add_def_cols('moneda','varchar');
        $this->var->add_def_cols('tipo','varchar');
        $this->var->add_def_cols('id_tabla','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarChequeAnulacion
	 * Propósito:				Contar los registros de tct_cheque
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-17 11:24:35
	 */
	function ContarChequeAnulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_sel';
		$this->codigo_procedimiento = "'CT_CHEANU_COUNT'";

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
	 * Nombre de la función:	AnularCheque
	 * Propósito:				Anulación de cheques
	 * Autor:				    RCM
	 * Fecha de creación:		11/02/2009
	 */
	function AnularCheque($id_cheque,$id_tabla,$tipo_cheque)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_iud';
		$this->codigo_procedimiento = "'CT_CHEQUE_ANU'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cheque");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_tabla");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo_cheque'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function ListarChequeReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_sel';
		$this->codigo_procedimiento = "'CT_CHEQUES_REP'";

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
		 $this->var->add_def_cols('id_cheque','INTEGER'); 
         $this->var->add_def_cols('nro_cheque','INTEGER'); 
         $this->var->add_def_cols('nro_deposito','VARCHAR(20)'); 
         $this->var->add_def_cols('fecha_cheque','DATE'); 
         $this->var->add_def_cols('nombre_cheque','VARCHAR'); 
         $this->var->add_def_cols('estado','TEXT'); 
         //$this->var->add_def_cols('nombre','VARCHAR(100)'); 
         $this->var->add_def_cols('cuenta_bancaria','TEXT'); 
         $this->var->add_def_cols('observaciones_anulacion','TEXT'); 
         $this->var->add_def_cols('tipo_cheque','VARCHAR(14)');
		 $this->var->add_def_cols('id_moneda','integer');
		 $this->var->add_def_cols('importe_cheque','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
 
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	function ContarChequeReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cheque_sel';
		$this->codigo_procedimiento = "'CT_CHEQUES_CTREP'";

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
	
	/*************************/
	function ValidarChequeRegTra($operacion_sql,$id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria)
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
				//Validar id_cheque - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cheque");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cheque", $id_cheque))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_transaccion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_transaccion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_transaccion", $id_transaccion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_cheque - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_cheque");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_cheque", $nro_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_deposito - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_deposito");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_deposito", $nro_deposito))
			{
				$this->salida = $valid->salida;
				return false;
			}


			//Validar fecha_cheque - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_cheque");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_cheque", $fecha_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_cheque - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_cheque");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_cheque", $nombre_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}
 
			//Validar id_cuenta_bancaria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_bancaria");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_bancaria", $id_cuenta_bancaria))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cheque - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cheque");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cheque", $id_cheque))
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