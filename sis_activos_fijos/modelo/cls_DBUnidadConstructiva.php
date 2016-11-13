<?php
/**
 * Nombre de la clase:	cls_DBUnidadConstructiva
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla taf_unidad_constructiva
 * Autor:				unknow
 * Fecha creacion:		29/07/2013
 */
class cls_DBUnidadConstructiva
{
	//Variable que contiene la salida de la ejecuci�n de la funci�n
	
	var $salida;

	//Variable que contedr� la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecuci�n de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la funci�n a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBUnidadConstructiva";

	//Matriz de par�metros de validaci�n de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los par�metro de validaci�n de todas las columnas
		$this->cargar_param_valid();
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la funci�n:	ListarUnidadConstructiva
	 * Proposito:				Desplegar los registros de taf_unidad_constructiva en funcionn de los par�metros del filtro
	 * Autor:					unknow
	 * Fecha de creacion:		
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */
	
	/***************************************************************************************************/
	function ListarUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AF_UNI_CONS_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_unidad_constructiva','integer');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado','varchar');  
		

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo "query:" .$this->query;
		//exit;
		return $res;
	}
	/**
	 * Nombre de la funci�n:	CountUnidadConstructiva
	 * Prop�sito:					 
	 * Autor:					
	 * Fecha de creaci�n:		
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */
	
	function ContarListaUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AF_UNI_CONS_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		
		
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;

		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	/**
	 * Nombre de la funci�n:	CrearUnidadConstructiva
	 * Prop�sito:				anadir registro a la tabla taf_unidad_constructiva				 
	 * Autor:					unknow
	 * Fecha de creaci�n:		20/07/2013
	 *
	 * @param integer $id_unidad_constructiva
	 * @param varchar $descripcion
	 * @param date $fecha_reg
	 * @param varchar $estado
	 * @return unknown
	 */
	function CrearUnidadConstructiva($id_unidad_constructiva, $descripcion, $fecha_reg, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_unidad_constructiva_iud';
		$this->codigo_procedimiento = "'AF_UNI_CONS_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_unidad_constructiva
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	
	/**
	 * Nombre de la funci�n:	EliminarUnidadConstructiva
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla taf_unidad_constructiva de la base de datos
	 * con los par�metros requeridos
	 * Autor:					unknow
	 * Fecha de creaci�n:		29/07/2013
	 *
	 * @param unknown_type $id_unidad_constructiva
	 * @return unknown
	 */
	function EliminarUnidadConstructiva($id_unidad_constructiva)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_unidad_constructiva_iud';
		$this->codigo_procedimiento = "'AF_UNI_CONS_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("$id_unidad_constructiva");//id_unidad_constructiva
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//estado
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la funci�n:	ModificarUnidadConstructiva
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla taf_unidad_constructiva de la base de datos
	 * con los par�metros requeridos
	 * Autor:					unknow
	 * Fecha de creaci�n:		29/07/2013
	 *
	 * @param unknown_type $id_unidad_constructiva
	 * @param unknown_type $descripcion
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @return unknown
	 */
	function ModificarUnidadConstructiva($id_unidad_constructiva, $descripcion, $fecha_reg, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_unidad_constructiva_iud';
		$this->codigo_procedimiento = "'AF_UNI_CONS_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		//Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("$id_unidad_constructiva");//id_unidad_constructiva
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la funci�n:	ValidarUnidadConstructiva
	 * Prop�sito:				Realiza una validaci�n de datos del lado del servidor (sin consultar a BD)
	 * Autor:					Unknow
	 * Fecha creaci�n:			29/07/2013
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_unidad_constructiva
	 * @param unknown_type $descripcion
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @return unknown
	 */

	function ValidarUnidadConstructiva($operacion_sql,$id_unidad_constructiva,$descripcion,$fecha_reg, $estado)
	{
		//operacion_sql se refiere a que operaci�n validar (por ejemplo: insert, update, delete; podr�an ser otros espec�ficos)

		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Ejecuta la validaci�n por el tipo de operaci�n
		switch ($operacion_sql) {
			case 'insert':

				/*******************************Verificaci�n de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato valido y un tamanio valido
				//Se valida todas las columnas de la tabla
				if(!$valid->verifica_dato($this->matriz_validacion[0], "id_unidad_constructiva", $id_unidad_constructiva))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[1], "descripcion", $descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[2], "fecha_reg", $fecha_reg))
				{
					$this->salida = $valid->salida;
					return false;
				}
				$def_estados = array ("activo", "inactivo","eliminado");
				if(!in_array($estado,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validacion en columna 'estado': El valor no esta dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
				
				//Validaci�n exitosa
				return true;
				break;

			case 'update':
				/*******************************Verificaci�n de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato v�lido y un tama�o v�lido
				//Se valida todas las columnas de la tabla

				if(!$valid->verifica_dato($this->matriz_validacion[0], "id_unidad_constructiva", $id_unidad_constructiva))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[1], "descripcion", $descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[2], "fecha_reg", $fecha_reg))
				{
					$this->salida = $valid->salida;
					return false;
				}
				$def_estados = array ("activo", "inactivo","eliminado");
				if(!in_array($estado,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validacion en columna 'estado': El valor no esta dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
				//Validaci�n exitosa
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
		$this->matriz_validacion[0]['Columna'] = "id_unidad_constructiva";
		$this->matriz_validacion[0]['allowBlank'] = "true";
		$this->matriz_validacion[0]['maxLength'] = 15;
		$this->matriz_validacion[0]['minLength'] = 0;
		$this->matriz_validacion[0]['SelectOnFocus'] = "true";
		$this->matriz_validacion[0]['vtype'] = "alphanum";
		$this->matriz_validacion[0]['dataType'] = "entero";
		$this->matriz_validacion[0]['width'] = "";
		$this->matriz_validacion[0]['grow'] = "";
		
		$this->matriz_validacion[1] = array();
		$this->matriz_validacion[1]['Columna'] = "descripcion";
		$this->matriz_validacion[1]['allowBlank'] = "false";
		$this->matriz_validacion[1]['maxLength'] = 300;
		$this->matriz_validacion[1]['minLength'] = 2;
		$this->matriz_validacion[1]['SelectOnFocus'] = "false";
		$this->matriz_validacion[1]['vtype'] = "alphaLatino";
		$this->matriz_validacion[1]['dataType'] = "texto";
		$this->matriz_validacion[1]['width'] = "";
		$this->matriz_validacion[1]['grow'] = "";
		
		$this->matriz_validacion[2] = array();
		$this->matriz_validacion[2]['Columna'] = "estado";
		$this->matriz_validacion[2]['allowBlank'] = "false";
		$this->matriz_validacion[2]['maxLength'] = 20;
		$this->matriz_validacion[2]['minLength'] = 0;
		$this->matriz_validacion[2]['SelectOnFocus'] = "false";
		$this->matriz_validacion[2]['vtype'] = "alphaLatino";
		$this->matriz_validacion[2]['dataType'] = "texto";
		$this->matriz_validacion[2]['width'] = "";
		$this->matriz_validacion[2]['grow'] = "";
		
		$this->matriz_validacion[4] = array();
		$this->matriz_validacion[4]['Columna'] = "fecha_reg";
		$this->matriz_validacion[4]['allowBlank'] = "true";
		$this->matriz_validacion[4]['maxLength'] = 30;
		$this->matriz_validacion[4]['minLength'] = 0;
		$this->matriz_validacion[4]['SelectOnFocus'] = "true";
		$this->matriz_validacion[4]['vtype'] = "alphaLatino";
		$this->matriz_validacion[4]['dataType'] = "fecha";
		$this->matriz_validacion[4]['width'] = "";
		$this->matriz_validacion[4]['grow'] = "";
	}
		
}?>
