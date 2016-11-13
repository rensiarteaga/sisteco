<?php
/**
 * Nombre de la Clase:	cls_DBDetalleNormativa
 * Propósito:			Permite ejecutar la funcionalidad de la tabla com_detalle_normativa
 * Autor:				Morgan Huascar Checa Lopez
 * Fecha creación:		14-05-2013
 *
 */
class cls_DBDetalleNormativa
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
	var $nombre_archivo = "cls_DBDetalleNormativa.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los parámetro de validación de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarNormativas
	 * Propósito:				Desplegar los registros de com_normativa_interna
	 * Autor:					Morgan Huascar Checa Lopez
	 * Fecha de creación:		14-05-2013
	 *
	 */
	function ListarDetalleNormativa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_detalle_normativa_sel';
		$this->codigo_procedimiento = "'CO_DETNORM_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

	

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_detalle_normativa','integer');
		$this->var->add_def_cols('nombre_subcategoria','varchar');
		$this->var->add_def_cols('descripcion_subcategoria','varchar');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('id_normativa_interna','integer');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarNormativas
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Morgan Huascar checa Lopez
	 * Fecha de creación:		15-05-2013
	 *
	 */
	function ContarDetalleNormativa($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_detalle_normativa_sel';
		$this->codigo_procedimiento = "'CO_DETNORM_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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
	 * Nombre de la función:	InsertarNormativas
	 * Propósito:				Permite ejecutar la función de inserción de la tabla comunidad.com_normativa_interna
	 * Autor:				    (Morgan Huascar Checa Lopez)
	 * Fecha de creación:		15-05-2013
	 * Descripción:             
	
	 */
	function InsertarDetalleNormativa($id_detalle_normativa, $nombre_subcategoria, $descripcion_subcategoria, $id_normativa_interna)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_detalle_normativa_iud';
		$this->codigo_procedimiento = "'CO_DETNORM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param(0);
		$this->var->add_param("'$nombre_subcategoria'");
		$this->var->add_param("'$descripcion_subcategoria'");
		$this->var->add_param("'$id_normativa_interna'");
	
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ModificarNormativas
	 * Propósito:				Permite ejecutar la función de modificación de la tabla comunidad.com_normativa_interna
	 * Autor:				    Morgan Huascar Checa Lopez
	 * Fecha de creación:		16-05-2013
	 */
	function ModificarDetalleNormativa($id_detalle_normativa, $nombre_subcategoria, $descripcion_subcategoria, $id_normativa_interna)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_detalle_normativa_iud';
		$this->codigo_procedimiento = "'CO_DETNORM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		//$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_detalle_normativa);
		$this->var->add_param("'$nombre_subcategoria'");
		$this->var->add_param("'$descripcion_subcategoria'");
		$this->var->add_param("'$id_normativa_interna'");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	EliminarNormativas
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla com_normativa_interna
	 * Autor:				    Morgan Huascar Checa Lopez
	 * Fecha de creación:		15-05-2013
	 */
	function EliminarDetalleNormativa($id_detalle_normativa)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_detalle_normativa_iud';
		$this->codigo_procedimiento = "'CO_DETNORM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_detalle_normativa);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param(0);

		

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