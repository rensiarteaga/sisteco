<?php
/**
 * Nombre de la clase:	cls_DBPedidoTucInt.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla val_tal_kardex_logico
 * Autor:				RAC
 * Fecha creación:		29/12/2016
 */

class cls_DBPedidoTucInt
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
	 * Nombre de la función:	ListarParametroAlmacenLogico
	 * Propósito:				Desplegar los registros de f_tal_parametro_almacen_logico_sel
	 * Autor:				    rac
	 * Fecha de creación:		03/12/2016
	 */
	function ListarPedidoTucInt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_pedido_tuc_int_sel';
		$this->codigo_procedimiento = "'AL_PEDTUCINT_SEL'";
		
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
		$this->var->add_def_cols('id_pedido_tuc_int','integer');
	    $this->var->add_def_cols('id_salida','integer');
	    $this->var->add_def_cols('id_orden_salida_uc_detalle','integer');
	    $this->var->add_def_cols('id_tipo_unidad_constructiva','integer');
	    $this->var->add_def_cols('id_item','integer');
	    $this->var->add_def_cols('cantidad_solicitada','integer');
	    $this->var->add_def_cols('nuevo','integer');
	    $this->var->add_def_cols('fecha_reg','date');
	    $this->var->add_def_cols('usado','integer');
	    $this->var->add_def_cols('demasia','integer');
	    $this->var->add_def_cols('sw_autorizado','varchar');
	    $this->var->add_def_cols('sw_entregado','varchar');
	    $this->var->add_def_cols('id_salida_complementaria','integer');
	    $this->var->add_def_cols('nombre','varchar');
	    $this->var->add_def_cols('codigo','varchar');
	    $this->var->add_def_cols('descripcion','varchar');
	    $this->var->add_def_cols('correlativo_sal_com','varchar'); 
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "sql:". $this->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarKardexLogico
	 * Propósito:				Contar los registros de f_tal_parametro_almacen_logico_sel
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 15:20:16
	 */
	function ContarPedidoTucInt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_pedido_tuc_int_sel';
		$this->codigo_procedimiento = "'AL_PEDTUCINT_COUNT'";

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
		$this->var->add_def_cols('totales','bigint');

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
	 * Nombre de la función:	autorizarSalida
	 * Propósito:				autoriza la no entrega de material por faltantes
	 * Autor:				    RAC
	 * Fecha de creación:		29/12/2016
	 */
	function ActionAutorizaPedido($id_pedido_tuc_int)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_pedido_tuc_int_iud';
		$this->codigo_procedimiento = "'AL_AUTPEDITUC_IUD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_pedido_tuc_int);
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
	 * Nombre de la función:	GenerarSalidaPendiente
	 * Propósito:				genera una salida simple con los item no entregados
	 * Autor:				    RAC
	 * Fecha de creación:		30/12/2016
	 */
	function GenerarSalidaPendiente($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_pedido_tuc_int_iud';
		$this->codigo_procedimiento = "'AL_GENSALIPEN_IUD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);	
		
		$this->var->add_param("NULL");		
		$this->var->add_param($id_salida);
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
}
?>