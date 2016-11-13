<?php
/**
**********************************************************
Nombre de archivo:	    middle_client.php
Propósito:				Enlace con la base de datos, que pemite ejecutar funciones de la BD, tanto de cosultas (querys) o de inserciones,
modificaciones y eliminaciones
(realiza la conexión a la base de datos)
Parámetros:				$nombre_funcion
$codigo_procedimiento
$id_usuario
$ip_origen
$mac_maquina
$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
Array de parámetros específicos de la función (mediante la función add_param)
Array de definición de columnas (caso de querys, mediante la función add_def_cols)
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Verdadero + Resultado -> si la función se ejecutó correctamente
Falso + Mensaje error -> si la función no pudo ejecutarse
Fecha de Creación:		22 - 05 - 07
Versión:				1.0.0
Autor:					Rodrigo Chumacero Moscoso
**********************************************************
*/
class middle_client
{
	/*	//Variables para manejo de errores
	var $pg_error;
	var $mensaje_error;*/

	//Array de salida $salida[0] -> TRUE - FALSE  (indica si la función se ejecutó correctamente o no
	//				  $salida[1] -> contendrá el resultado de la función, ya sea mensaje de error, conjunto de datos ,etc.
	var $salida = array();

	//Parámetros Fijos
	var $id_usuario;
	var $ip_origen;
	var $mac_maquina;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $proc_almacenado;
	var $parametros = array(); //array de parámetros específicos por tabla
	var $def_cols = array();//array de las definiciones de columnas en caso de que sea QUERY
	var $cols_def;

	//Parámetros para el filtro
	var $cant;
	var $puntero;
	var $sortcol;
	var $sortdir;
	var $criterio_filtro;

	/**
	 * Función de inicialización
	 *
	 * @param unknown_type $nombre_funcion
	 * @param unknown_type $codigo_procedimiento
	 */
	function init($nombre_funcion,$codigo_procedimiento)
	{
		//Inicializa los parámetros fijos
		$this->id_usuario = "";
		$this->ip_origen = "";
		$this->mac_maquina = "";
		$this->nombre_funcion = "";
		$this->codigo_procedimiento = "";
		$this->proc_almacenado = "";

		$this->parametros = array();
		$this->def_cols = array();

		//Inicializa los parámetros del filtro
		$this->cant = "15";
		$this->puntero = "";
		$this->sortcol = "";
		$this->sortdir = "asc";
		$this->criterio_filtro = "";

		//Obtiene los parámetros fijos de la sesión del usuario
		$this->id_usuario = 10;
		$this->ip_origen = '\'200.87.181.201\'';
		$this->mac_maquina = '\'00:19:d1:09:22:7e\'';

		//Asigna los valores enviados
		$this->nombre_funcion = $nombre_funcion;
		$this->codigo_procedimiento = $codigo_procedimiento;
		$this->proc_almacenado='NULL';
	}

	/**
	 * Ejecuta las funciones que no sean querys
	 *
	 * @return unknown
	 */
	function exec_non_query()
	{
		$salida_temp = array();//array que contendrá el resultado del query
		$Funciones = new funciones();
		$link = $Funciones->conectar_pg();

		//Forma la llamada a la función
		$query = "SELECT $this->nombre_funcion ($this->id_usuario,$this->ip_origen,$this->mac_maquina,$this->codigo_procedimiento,$this->proc_almacenado";

		//Concantena los parámetros específicos; sino existieran añade un paréntesis
		if(sizeof($this->parametros)>0)
		{
			$query .= ','.implode(",",$this->parametros).')';
		}
		else
		{
			$query .=')';
		}

		//Ejecuta la función
		if($result = pg_query($link,$query))
		{
			//Carga el resultado en el array temporal de salida
			while ($row = pg_fetch_array($result))
			{
				array_push ($salida_temp, $row);
			}

			//Libera la memoria
			pg_free_result($result);

			//Cierra la conexión con postegres
			$res = $Funciones->desconectar_pg($link);

			//Verifica si se produjo algún error lógico en la función
			$resp_funcion = $salida_temp[0][0];

			if($resp_funcion==t)
			{
				//No existe error lógico
				$this->salida[0] = true;
				$this->salida[1] = $resp_funcion;
				return true;
			}
			else
			{
				//Existe error lógico
				$this->salida[0] = false;
				$this->salida[1] = $resp_funcion;
				return false;
			}
		}
		else
		{
			//Se produjo un error a nivel de base de datos
			$this->salida[0]=false;
			$this->salida[1]=pg_last_error($link);
			return false;
		}
	}


	/**
	 * Ejecuta las funciones del tipo QUERY
	 *
	 * @return unknown
	 */
	function exec_query()
	{
		$salida_temp = array();//array que contendrá el resultado del query
		$Funciones = new funciones();
		$link = $Funciones ->conectar_pg();

		//Forma la llamda a la función
		$query = "SELECT * FROM $this->nombre_funcion ($this->id_usuario,$this->ip_origen,$this->mac_maquina,$this->codigo_procedimiento,$this->proc_almacenado";

		//Concantena los parámetros del filtro
		$query .= ", $this->cant,$this->puntero,$this->sortcol,$this->sortdir,$this->criterio_filtro";

		//Concatena los parámetros específicos si existieran, caso contrario cierra paréntesis
		if(sizeof($this->parametros)>0)
		{
			$query .= ','.implode(",",$this->parametros) . ")";
		}
		else
		{
			$query.= ')';
		}

		//Concatena la lista de columnas con sus respectivos tipos de datos
		if(sizeof($this->def_cols)>0)
		{
			$query .= " AS (". implode(",",$this->def_cols).')';
		}


		/**
		 * Ejecuta la función 
		 */
		if($result = pg_query($link,$query))
		{
			//Carga el resultado en el array temporal de salida
			while ($row = pg_fetch_array($result))
			{
				array_push ($salida_temp, $row);
			}

			//Libera la memoria
			pg_free_result($result);

			//Cierra la conexión con postegres
			$res = $Funciones->desconectar_pg($link);

			//Define el array de salida
			$this->salida[0] = true;
			$this->salida[1] = $salida_temp;

			return true;

			/*$this->pg_error = false;
			return $salida; //Devuelve el array resultado de la consulta*/
		}
		else
		{
			//Se produjo un error a nivel de base de datos
			$this->salida[0]=false;
			$this->salida[1]=pg_last_error($link);
			return false;
			/*
			$this->pg_error = true;
			$this->mensaje_error = pg_last_error($link);
			return $this->mensaje_error;*/
		}
	}

	/**
	 * Función que adiciona parámetros específicos para las funciones (aparte de los fijos y del filtro)
	 *
	 * @param unknown_type $param
	 */
	function add_param($param)
	{
		array_push ($this->parametros, $param);
	}

	/**
	 * Función que adiciona definición de columnas para querys
	 *
	 * @param unknown_type $nombre_col
	 * @param unknown_type $tipo_dato
	 */
	function add_def_cols($nombre_col,$tipo_dato)
	{
		$aux = $nombre_col . " ".$tipo_dato;
		array_push($this->def_cols, $aux);
	}

}//FIN CLASE
?>
