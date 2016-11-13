<?php
/**
 * Nombre de la Clase:	cls_DBAvisoRRHH
 * Propósito:			Permite ejecutar la funcionalidad de la tabla com_aviso_rrhh
 * Autor:				Morgan Huascar Checa Lopez
 * Fecha creación:		14-05-2013
 *
 */
class cls_DBAvisoRRHH
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
	var $nombre_archivo = "cls_DBAvisoRRHH.php";

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
	 * Nombre de la función:	ListarAvisoRRHH
	 * Propósito:				Desplegar los registros de com_pensamiento_dia
	 * Autor:					Morgan Huascar Checa Lopez
	 * Fecha de creación:		14-05-2013
	 *
	 */
	function ListarAvisoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_aviso_rrhh_administracion_sel';
		$this->codigo_procedimiento = "'CO_AVIRRHH_SEL'";

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
		$this->var->add_def_cols('id_aviso_rrhh','integer');
		$this->var->add_def_cols('nombre_aviso_rrhh','varchar');
		$this->var->add_def_cols('descripcion_aviso_rrhh','varchar');
		$this->var->add_def_cols('rrhh_ruta_archivo','varchar');
		$this->var->add_def_cols('rrhh_fecha_registro','date');
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
	 * Nombre de la función:	ContarPensamiento
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Morgan Huascar checa Lopez
	 * Fecha de creación:		15-05-2013
	 *
	 */
	function ContarAvisoRRHH($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_aviso_rrhh_administracion_sel';
		$this->codigo_procedimiento = "'CO_AVIRRHH_COUNT'";

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
	 * Nombre de la función:	InsertarAvisoRRHH
	 * Propósito:				Permite ejecutar la función de inserción de la tabla comunidad.com_avisos_rrhh
	 * Autor:				    (Morgan Huascar Checa Lopez)
	 * Fecha de creación:		15-05-2013
	 * Descripción:             
	
	 */
	function InsertarAvisoRRHH($id_aviso,$nombre_aviso,$descripcion_aviso,$ruta_archivo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_aviso_rrhh_administracion_iud';
		$this->codigo_procedimiento = "'CO_AVIRRHH_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param(0);
		$this->var->add_param("'$nombre_aviso'");
		$this->var->add_param("'$descripcion_aviso'");
		$this->var->add_param("'$ruta_archivo'");
	
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ModificarPensamiento
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_TipoObligacion
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function ModificarAvisoRRHH($id_aviso,$nombre_aviso,$descripcion_aviso,$ruta_archivo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_aviso_rrhh_administracion_iud';
		$this->codigo_procedimiento = "'CO_AVIRRHH_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_aviso);
		$this->var->add_param("'$nombre_aviso'");
		$this->var->add_param("'$descripcion_aviso'");
		$this->var->add_param("'$ruta_archivo'");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	EliminarPensamiento
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_TipoObligacion
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function EliminarAvisoRRHH($id_aviso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'comunidad.f_com_aviso_rrhh_administracion_iud';
		$this->codigo_procedimiento = "'CO_AVIRRHH_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_aviso);
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
	
	
	
}
?>