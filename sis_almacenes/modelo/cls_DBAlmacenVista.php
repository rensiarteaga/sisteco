<?php
/**
 * Nombre de la clase:	cls_DBAlmacenVista.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla val_almacen_vista
 * Autor:				José Abraham Mita Huanca
 * Fecha creación:		2007-11-15
 */

class cls_DBAlmacenVista
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
	 * Nombre de la función:	ListarAlmacenVista
	 * Propósito:				Desplegar los registros de val_almacen_vista
	 * Autor:				    José Abraham Mita Huanca
	 * Fecha de creación:		2007-11-15 
	 */
	function ListarAlmacenVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_val_almacen_vista';
		$this->codigo_procedimiento = "'AL_ALMACEN_VISTA_SEL'";

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
		$this->var->add_def_cols('id_item','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('precio_venta_almacen','numeric');
		$this->var->add_def_cols('costo_estimado','numeric');
		$this->var->add_def_cols('stock_min','numeric');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('nivel_convertido','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_unidad_medida_base','integer');
		$this->var->add_def_cols('id_id3','integer');
		$this->var->add_def_cols('id_id2','integer');
		$this->var->add_def_cols('id_id1','integer');
		$this->var->add_def_cols('id_subgrupo','integer');
		$this->var->add_def_cols('id_grupo','integer');
		$this->var->add_def_cols('id_supergrupo','integer');
		$this->var->add_def_cols('nombre_id3','varchar');
		$this->var->add_def_cols('nombre_id2','varchar');
		$this->var->add_def_cols('nombre_id1','varchar');
		$this->var->add_def_cols('nombre_subg','varchar');
		$this->var->add_def_cols('nombre_grupo','varchar');
		$this->var->add_def_cols('nombre_supg','varchar');
		$this->var->add_def_cols('nombre_unid_base','varchar');
		$this->var->add_def_cols('total','numeric');
		$this->var->add_def_cols('id_almacen','integer');
		$this->var->add_def_cols('nuevo','numeric');
		$this->var->add_def_cols('usado','numeric');


		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;


		return $res;
	}

	/**
	 * Nombre de la función:	ContarKardexLogico
	 * Propósito:				Contar los registros de tal_kardex_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 15:20:16
	 */
	function ContarAlmacenVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_val_almacen_vista';
		$this->codigo_procedimiento = "'AL_ALMACEN_VISTA_COUNT'";

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
}
?>