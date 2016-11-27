<?php
/**
 * Nombre de la Clase:	cls_DBItem
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_item
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		28-09-2007
 */
class cls_DBItem
{
	//Variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;

	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecución de funciones
	var $var; //middle
	var $nombre_funcion; //nombre de la función a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBItem.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct()
	{
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarItem
	 * Propósito:				Desplegar los registros de tal_item en función de los parámetros del filtro
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
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
	function ListarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITEM_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

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
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('nombre_id3','varchar');
		$this->var->add_def_cols('nombre_id2','varchar');
		$this->var->add_def_cols('nombre_id1','varchar');
		$this->var->add_def_cols('nombre_subg','varchar');
		$this->var->add_def_cols('nombre_grupo','varchar');
		$this->var->add_def_cols('nombre_supg','varchar');
		$this->var->add_def_cols('nombre_unid_base','varchar');
		$this->var->add_def_cols('peso_kg','numeric');
		$this->var->add_def_cols('mat_bajo_responsabilidad','varchar');
		$this->var->add_def_cols('calidad','varchar');
		$this->var->add_def_cols('descripcion_aux','varchar');
		$this->var->add_def_cols('registro','varchar');	

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
			
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
		
	}
	
	/**
	 * Nombre de la función:	ListarItemFiltrado
	 * Propósito:				Desplegar los registros  tal_item en función de los parámetros del filtro
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */ 
	
	function ListarItemFiltrado($criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITEFIL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = 0;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_item','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_id3','integer');
		$this->var->add_def_cols('id_id2','integer');
		$this->var->add_def_cols('id_id1','integer');
		$this->var->add_def_cols('id_subgrupo','integer');
		$this->var->add_def_cols('id_grupo','integer');
		$this->var->add_def_cols('id_supergrupo','integer');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('nombre_id3','varchar');
		$this->var->add_def_cols('nombre_id2','varchar');
		$this->var->add_def_cols('nombre_id1','varchar');
		$this->var->add_def_cols('nombre_subg','varchar');
		$this->var->add_def_cols('nombre_grupo','varchar');
		$this->var->add_def_cols('nombre_supg','varchar');
		$this->var->add_def_cols('descripcion_id3','varchar');
		$this->var->add_def_cols('descripcion_id2','varchar');
		$this->var->add_def_cols('descripcion_id1','varchar');
		$this->var->add_def_cols('descripcion_subg','varchar');
		$this->var->add_def_cols('descripcion_grupo','varchar');
		$this->var->add_def_cols('descripcion_supg','varchar');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	
		/**
	 * Nombre de la función:	ContarItem
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
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
	function ContarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITEM_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

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
		///////////////////////////////////////////////////////////////////////////
/**
	 * Nombre de la función:	ListarGrupoAlmacen
	 * Propósito:				Desplegar los registros de tal_grupo en función de los parámetros del filtro
	 * Autor:					Susana Castro G.
	 * Fecha de creación:		28-09-2007
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
	function ListarItemAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITEAL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_item','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
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
		$this->var->add_def_cols('desc_unidad_medida_base','varchar');
		$this->var->add_def_cols('desc_id3','varchar');
		$this->var->add_def_cols('desc_id2','varchar');
		$this->var->add_def_cols('desc_id1','varchar');
		$this->var->add_def_cols('desc_subgrupo','varchar');
		$this->var->add_def_cols('desc_grupo','varchar');
		$this->var->add_def_cols('desc_supergrupo','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarGrupo
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Susana Castro G.
	 * Fecha de creación:		28-09-2007
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
	function ContarItemAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITEAL_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

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
//////////////////////////////////////////////////////////////////////////
	
	
	/**
	 * Nombre de la función:	ListarItem
	 * Propósito:				Desplegar los registros de tal_item en función de los parámetros del filtro
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
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
	function ListarItemSal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITESAL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

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
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('nombre_id3','varchar');
		$this->var->add_def_cols('nombre_id2','varchar');
		$this->var->add_def_cols('nombre_id1','varchar');
		$this->var->add_def_cols('nombre_subg','varchar');
		$this->var->add_def_cols('nombre_grupo','varchar');
		$this->var->add_def_cols('nombre_supg','varchar');
		$this->var->add_def_cols('nombre_unid_base','varchar');
		$this->var->add_def_cols('mat_bajo_responsabilidad','varchar');
		$this->var->add_def_cols('descripcion_aux','varchar');
		
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ContarItem
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
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
	function ContarItemSal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITESAL_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

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
	 * Nombre de la función:	ListarItemKardex
	 * Propósito:				Desplegar los items que tengan su registro en Kardex
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
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
	function ListarItemKardex($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITEKAR_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

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
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('nombre_id3','varchar');
		$this->var->add_def_cols('nombre_id2','varchar');
		$this->var->add_def_cols('nombre_id1','varchar');
		$this->var->add_def_cols('nombre_subg','varchar');
		$this->var->add_def_cols('nombre_grupo','varchar');
		$this->var->add_def_cols('nombre_supg','varchar');
		$this->var->add_def_cols('nombre_unid_base','varchar');
		$this->var->add_def_cols('total','numeric');
		$this->var->add_def_cols('nuevo','numeric');
		$this->var->add_def_cols('usado','numeric');
		$this->var->add_def_cols('descripcion_aux','varchar');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query: ".$this->query;
		//exit;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ContarItemkardex
	 * Propósito:				Contar el total de registros que tienen registro en Kardex
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
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
	function ContarItemkardex($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITEKAR_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

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
	 * Nombre de la función:	InsertarParametrosAlmacen
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_item,
	 * 							con los parámetros requeridos
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_item
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $precio_venta_almacen
	 * @param unknown_type $costo_estimado
	 * @param unknown_type $costo_almacen
	 * @param unknown_type $stock_min
	 * @param unknown_type $stock_total
	 * @param unknown_type $observaciones
	 * @param unknown_type $nivel_convertido
	 * @param unknown_type $estado_item
	 * @param unknown_type $estado_registro
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_unidad_medida_base
	 * @param unknown_type $id_id3
	 * @param unknown_type $id_id2
	 * @param unknown_type $id_id1
	 * @param unknown_type $id_subgrupo
	 * @param unknown_type $id_grupo
	 * @param unknown_type $id_supergrupo
	 * @param unknown_type $nombre
	 * @return unknown
	 */
	function InsertarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$stock_min,$observaciones,$nivel_convertido,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre,$peso_kg,$mat_bajo_responsabilidad,$calidad,$descripcion_aux,$registro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_iud';
		$this->codigo_procedimiento = "'AL_ITEM_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("'$codigo'");//codigo
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("$precio_venta_almacen");//precio_venta_almacen
		$this->var->add_param("$costo_estimado");//costo_estimado
		$this->var->add_param("$stock_min");//stock_min
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$nivel_convertido'");//nivel_convertido
		$this->var->add_param("'$estado_registro'");//estado_registro
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("$id_unidad_medida_base");//id_unidad_medida_base
		$this->var->add_param("$id_id3");//id_id3
		$this->var->add_param("$id_id2");//id_id2
		$this->var->add_param("$id_id1");//id_id1
		$this->var->add_param("$id_subgrupo");//id_subgrupo
		$this->var->add_param("$id_grupo");//id_grupo
		$this->var->add_param("$id_supergrupo");//id_supergrupo
		$this->var->add_param("'$nombre'");//nombre
		$this->var->add_param("$peso_kg");//peso_kg
		$this->var->add_param("'$mat_bajo_responsabilidad'");//material bajo responsabilidad
		$this->var->add_param("'$calidad'");//calidad
		$this->var->add_param("'$descripcion_aux'");//descripcion_aux
		$this->var->add_param("'$registro'");//registro

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}


	/**
	 * Nombre de la función:	ModificarParametrosAlmacen
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_item
	 * 							con los parámetros requeridos
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_parametros_almacen
	 * @param unknown_type $dias_reserva
	 * @param unknown_type $cierre
	 * @param unknown_type $gestion
	 * @param unknown_type $bloqueado
	 * @param unknown_type $actualizar
	 * @param unknown_type $observaciones
	 * @param unknown_type $id_cuenta
	 * @return unknown
	 */
	function ModificarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$stock_min,$observaciones,$nivel_convertido,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre,$peso_kg,$mat_bajo_responsabilidad,$calidad,$descripcion_aux)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_iud';
		$this->codigo_procedimiento = "'AL_ITEM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_item");//id_item
		$this->var->add_param("'$codigo'");//codigo
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("$precio_venta_almacen");//precio_venta_almacen
		$this->var->add_param("$costo_estimado");//costo_estimado
		$this->var->add_param("$stock_min");//stock_min
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$nivel_convertido'");//nivel_convertido
		$this->var->add_param("'$estado_registro'");//estado_registro
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("$id_unidad_medida_base");//id_unidad_medida_base
		$this->var->add_param("$id_id3");//id_id3
		$this->var->add_param("$id_id2");//id_id2
		$this->var->add_param("$id_id1");//id_id1
		$this->var->add_param("$id_subgrupo");//id_subgrupo
		$this->var->add_param("$id_grupo");//id_grupo
		$this->var->add_param("$id_supergrupo");//id_supergrupo
		$this->var->add_param("'$nombre'");//nombre
		$this->var->add_param("$peso_kg");//peso_kg
		$this->var->add_param("'$mat_bajo_responsabilidad'");// material bajo responsabilidad
		$this->var->add_param("'$calidad'");//calidad
		$this->var->add_param("'$descripcion_aux'");//descripcion_aux
		$this->var->add_param("NULL");//registro

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}



	/**
	 * Nombre de la función:	EliminarParametrosAlmacen
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_item
	 * 							con los parámetros requeridos
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_parametros_almacen
	 * @return unknown
	 */
	function EliminarItem($id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_iud';
		$this->codigo_procedimiento = "'AL_ITEM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_item");//id_item
		$this->var->add_param("NULL");//codigo
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//precio_venta_almacen
		$this->var->add_param("NULL");//costo_estimado
		$this->var->add_param("NULL");//stock_min
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//nivel_convertido
		$this->var->add_param("NULL");//estado_registro
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//id_unidad_medida_base
		$this->var->add_param("NULL");//id_id3
		$this->var->add_param("NULL");//id_id2
		$this->var->add_param("NULL");//id_id1
		$this->var->add_param("NULL");//id_subgrupo
		$this->var->add_param("NULL");//id_grupo
		$this->var->add_param("NULL");//id_supergrupo
		$this->var->add_param("NULL");//nombre
		$this->var->add_param("NULL");//peso_kg
		$this->var->add_param("NULL");//mat_bajo_responsabilidad
		$this->var->add_param("NULL");//calidad
		$this->var->add_param("NULL");//descripcion_aux
		$this->var->add_param("NULL");//registro

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ActivarInactivarItem($id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_iud';
		$this->codigo_procedimiento = "'AL_ITEM_INA'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param($id_item);//id_item
		$this->var->add_param("NULL");//codigo
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//precio_venta_almacen
		$this->var->add_param("NULL");//costo_estimado
		$this->var->add_param("NULL");//stock_min
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//nivel_convertido
		$this->var->add_param("NULL");//estado_registro
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//id_unidad_medida_base
		$this->var->add_param("NULL");//id_id3
		$this->var->add_param("NULL");//id_id2
		$this->var->add_param("NULL");//id_id1
		$this->var->add_param("NULL");//id_subgrupo
		$this->var->add_param("NULL");//id_grupo
		$this->var->add_param("NULL");//id_supergrupo
		$this->var->add_param("NULL");//nombre
		$this->var->add_param("NULL");//peso_kg
		$this->var->add_param("NULL");//material bajo responsabilidad
		$this->var->add_param("NULL");//calidad
		$this->var->add_param("NULL");//descripcion_aux
		$this->var->add_param("NULL");//registro
		
		/*echo $this->var->get_query_iud();
		exit;*/

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		

		return $res;
	}


	/**
	 * Nombre de la función:	ValidaParametrosAlmacen
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_parametros_almacen
	 * @param unknown_type $dias_reserva
	 * @param unknown_type $cierre
	 * @param unknown_type $gestion
	 * @param unknown_type $bloqueado
	 * @param unknown_type $actualizar
	 * @param unknown_type $observaciones
	 * @param unknown_type $id_cuenta
	 * @return unknown
	 */
	function ValidarItem($operacion_sql,$id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$stock_min,$observaciones,$nivel_convertido,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre,$peso_kg,$mat_bajo_responsabilidad,$calidad,$descripcion_aux)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)


		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validad el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();

		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			/*******************************Verificación de datos****************************/
			//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
			//Se valida todas las columnas de la tabla

			if($operacion_sql == 'update')
			{
				//Validar id_item - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_item");
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);
				$tipo_dato->set_Signo('2');

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			//$tipo_dato->set_MaxLength(3);
			$tipo_dato->set_MinLength(1);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar precio_venta_almacen - tipo numérico
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_venta_almacen");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_venta_almacen", $precio_venta_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_estimado - tipo numerico
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_estimado");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_estimado", $costo_estimado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			/******************************************************************/
			//Validar stock_min - tipo numerico
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("stock_min");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "stock_min", $stock_min))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nivel_convertido - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nivel_convertido");
			$tipo_dato->set_MaxLength(1);
			$tipo_dato->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nivel_convertido", $nivel_convertido))
			{
				$this->salida = $valid->salida;
				return false;
			}


			//Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_registro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_medida_base - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_medida_base");
			$tipo_dato->set_MaxLength(10);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_medida_base", $id_unidad_medida_base))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_id3 - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_id3");
			$tipo_dato->set_MaxLength(10);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_id3", $id_id3))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_id2 - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_id2");
			$tipo_dato->set_MaxLength(10);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_id2", $id_id2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_id1 - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_id1");
			$tipo_dato->set_MaxLength(10);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_id1", $id_id1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_subgrupo - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subgrupo");
			$tipo_dato->set_MaxLength(10);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subgrupo", $id_subgrupo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_grupo - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_grupo");
			$tipo_dato->set_MaxLength(10);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo", $id_grupo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_supergrupo - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_supergrupo");
			$tipo_dato->set_MaxLength(10);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_supergrupo", $id_supergrupo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
		//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_item - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
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
