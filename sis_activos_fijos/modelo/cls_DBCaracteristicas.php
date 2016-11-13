<?php
/**
 * Nombre de la Clase:	cls_DBCaracteristicas
 * Propósito:			Permite ejecutar la funcionalidad de la tabla taf_caracteristicas
 * Autor:				Rodrigo Chumacero M.
 * Fecha creación:		12-06-2007
 *
 */
class cls_DBCaracteristicas
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
	var $nombre_archivo = "cls_DBCaracteristicas.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct()
	{
		//Carga los parámetro de validación de todas las columnas
		$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarCaracteristicas
	 * Propósito:				Desplegar los registros de taf_caracteristicas en función de los parámetros del filtro
	 * Autor:					Rodrigo Chumacero M.
	 * Fecha de creación:		12-06-2007
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
	function ListarCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_caracteristicas_consultas';
		$this->codigo_procedimiento = "'AF_CARA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
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
		$this->var->add_def_cols('id_caracteristica','integer');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_subtipo_activo','integer');
		$this->var->add_def_cols('desc_subtipo_activo','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarListaCaracteristicas
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
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
	function ContarListaCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_caracteristicas_consultas';
		$this->codigo_procedimiento = "'AF_CARA_SEL_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
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
	 * Nombre de la función:	CrearCaracteristicas
	 * Propósito:				Permite ejecutar la función de inserción de la taf_caracteristicas de la base de datos,
	 * 							con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_caracteristicas
	 * @param unknown_type $descripcion
	 * @param unknown_type $id_caracteristica
	 * @param unknown_type $id_activo_fijo
	 * @return unknown
	 */
	function CrearCaracteristicas($id_caracteristica, $descripcion, $id_subtipo_activo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_caracteristicas';
		$this->codigo_procedimiento = "'AF_CARA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_caracteristica
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param($id_subtipo_activo);//id_tipo_activo

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarCaracetristicas
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_caracteristicas de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_caracteristica
	 * @return unknown
	 */
	function  EliminarCaracteristicas($id_caracteristica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_caracteristicas';
		$this->codigo_procedimiento = "'AF_CARA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_caracteristica);//id_caracteristica
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//id_tipo_activo
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ModificarCaracteristicas
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_caracteristicas de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_caracteristica
	 * @param unknown_type $descripcion
	 * @param unknown_type $id_tipo_activo
	 * @return unknown
	 */
	function  ModificarCaracteristicas($id_caracteristica, $descripcion, $id_subtipo_activo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_caracteristicas';
		$this->codigo_procedimiento = "'AF_CARA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_caracteristica);//id_caracteristica
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param($id_subtipo_activo);//id_tipo_activo
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ValidarCaracteristicas
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha creación:			12-06-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_caracteristica
	 * @param unknown_type $id_tipo_activo
	 * @return unknown
	 */
	function ValidarCaracteristicas($operacion_sql, $id_caracteristica,$descripcion, $id_subtipo_activo)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)

		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Ejecuta la validación por el tipo de operación
		switch ($operacion_sql) {
			case 'insert':

				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla
				if(!$valid->verifica_dato($this->matriz_validacion[1], "descripcion", $descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[2], "id_subtipo_activo", $id_subtipo_activo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validación de reglas de datos
				/*$def_estados = array ("activo", "inactivo","eliminado");
				if(!in_array($estado,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'estado': El valor no está dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
*/
				//Validación exitosa
				return true;
				break;

			case 'update':
				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla

				if(!$valid->verifica_dato($this->matriz_validacion[0], "id_caracteristica", $id_caracteristica))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[1], "descripcion", $descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[2], "id_subtipo_activo", $id_subtipo_activo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validación de reglas de datos
				/*$def_estados = array ("activo", "inactivo","eliminado");
				if(!in_array($estado,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'estado': El valor no está dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}*/

				//Validación exitosa
				return true;
				break;
			case 'delete':
				break;
			default:
				return false;
				break;
		}

	}

	function cargar_param_valid()
	{
		$this->matriz_validacion[0] = array();
		$this->matriz_validacion[0]['Columna'] = "id_caracteristica";
		$this->matriz_validacion[0]['allowBlank'] = "false";
		$this->matriz_validacion[0]['maxLength'] = 15;
		$this->matriz_validacion[0]['minLength'] = 0;
		$this->matriz_validacion[0]['SelectOnFocus'] = "true";
		$this->matriz_validacion[0]['vtype'] = "alphanum";
		$this->matriz_validacion[0]['dataType'] = "entero";
		$this->matriz_validacion[0]['width'] = "";
		$this->matriz_validacion[0]['grow'] = "";

		$this->matriz_validacion[1] = array();
		$this->matriz_validacion[1]['Columna'] = "descripcion";
		$this->matriz_validacion[1]['allowBlank'] = "true";
		$this->matriz_validacion[1]['maxLength'] = 50;
		$this->matriz_validacion[1]['minLength'] = 0;
		$this->matriz_validacion[1]['SelectOnFocus'] = "false";
		$this->matriz_validacion[1]['vtype'] = "alphaLatino";
		$this->matriz_validacion[1]['dataType'] = "texto";
		$this->matriz_validacion[1]['width'] = "";
		$this->matriz_validacion[1]['grow'] = "";

		$this->matriz_validacion[2] = array();
		$this->matriz_validacion[2]['Columna'] = "id_subtipo_activo";
		$this->matriz_validacion[2]['allowBlank'] = "false";
		$this->matriz_validacion[2]['maxLength'] = 15;
		$this->matriz_validacion[2]['minLength'] = 0;
		$this->matriz_validacion[2]['SelectOnFocus'] = "false";
		$this->matriz_validacion[2]['vtype'] = "alphaLatino";
		$this->matriz_validacion[2]['dataType'] = "entero";
		$this->matriz_validacion[2]['width'] = "";
		$this->matriz_validacion[2]['grow'] = "";

	}

}?>