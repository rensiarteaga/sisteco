<?php
/**
 * Nombre de la Clase:	cls_DBTipoActivo
 * Propósito:			Permite ejecutar la funcionalidad de la tabla taf_tipo_activo
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		08-06-2007
 *
 */
class cls_DBTipoActivo
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
	var $nombre_archivo = "cls_DBTipoActivo.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los parámetro de validación de todas las columnas
		$this->cargar_param_valid();

		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarTipoActivo
	 * Propósito:				Desplegar los registros de taf_tipo_activo en función de los parámetros del filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		08-06-2007
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
	function ListarTipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_consultas';
		$this->codigo_procedimiento = "'AF_TIP_SEL'";

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
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('flag_depreciacion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_metodo_depreciacion','integer');
		$this->var->add_def_cols('desc_metodo_depreciacion','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/***************************************************************************************************/
	function ListarTipoActivoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_consultas';
		$this->codigo_procedimiento = "'AF_TIP_EP_SEL'";

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
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/*****************************************************************************************************/

	/**
	 * Nombre de la función:	ContarListaTipoActivo
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		08-06-2007
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
	function ContarListaTipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_consultas';
		$this->codigo_procedimiento = "'AF_TIP_SEL_COUNT'";

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
/************************************************************************************************/

function ContarListaTipoActivoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo_consultas';
		$this->codigo_procedimiento = "'AF_TIP_EP_SEL_COUNT'";

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


/******************************************************************************************************************/
	/**
	 * Nombre de la función:	CrearTipoActivo
	 * Propósito:				Permite ejecutar la función de inserción de la taf_tipo_activo de la base de datos,
	 * 							con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		08-06-2007
	 *
	 * @param unknown_type $id_tipo_activo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $flag_depreciacion
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_metodo_depreciacion
	 * @param unknown_type $id_moneda
	 * @return unknown
	 */
	function CrearTipoActivo($id_tipo_activo, $codigo, $descripcion, $flag_depreciacion, $fecha_reg, $estado, $id_metodo_depreciacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo';
		$this->codigo_procedimiento = "'AF_TIP_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_tipo_activo
		$this->var->add_param("'$codigo'");//código
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$flag_depreciacion'");//flag_depreciacion
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_metodo_depreciacion);//id_metodo_depreciacion

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarTipoActivo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_tipo_activo de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		08-06-2007
	 *
	 * @param unknown_type $id_tipo_activo
	 * @return unknown
	 */
	function  EliminarTipoActivo($id_tipo_activo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo';
		$this->codigo_procedimiento = "'AF_TIP_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param('NULL');//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_tipo_activo);//id_tipo_activo
		$this->var->add_param('NULL');//código
		$this->var->add_param('NULL');//descripcion
		$this->var->add_param('NULL');//flag_depreciacion
		$this->var->add_param('NULL');//fecha_reg
		$this->var->add_param('NULL');//estado
		$this->var->add_param('NULL');//id_metodo_depreciacion

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarTipoActivo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_tipo_activo de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		08-06-2007
	 *
	 * @param unknown_type $id_tipo_activo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $flag_depreciacion
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_metodo_depreciacion
	 * @param unknown_type $id_moneda
	 * @return unknown
	 */
	function  ModificarTipoActivo($id_tipo_activo, $codigo, $descripcion, $flag_depreciacion, $fecha_reg, $estado, $id_metodo_depreciacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_activo';
		$this->codigo_procedimiento = "'AF_TIP_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_tipo_activo);//id_tipo_activo
		$this->var->add_param("'$codigo'");//código
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$flag_depreciacion'");//flag_depreciacion
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_metodo_depreciacion);//id_metodo_depreciacion

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	  * Nombre de la función:	ValidarTipoActivo
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha creación:			08-06-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_tipo_activo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $flag_depreciacion
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_metodo_depreciacion
	 * @param unknown_type $id_moneda
	 * @return unknown
	 */
	function ValidarTipoActivo($operacion_sql, $id_tipo_activo, $codigo, $descripcion, $flag_depreciacion, $fecha_reg, $estado, $id_metodo_depreciacion)
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
				if(!$valid->verifica_dato($this->matriz_validacion[1], "codigo", $codigo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				/*$val =  new cls_define_tipo_dato();
				$aux = array();
				$aux=$val->TipoDatoText($$nombre_columna ="columna45",$$minLength=8);

				//$aux=$val->TipoDatoText()
				//echo"matriz->".sizeof($val->TipoDatoText($nombre_columna = "codigo"));
				echo "matriz->".$aux['Columna']."<br>";
				echo "matriz->".$aux['minLength']."<br>";
				echo "matriz->".$aux['$allowBlank']."<br>";
				exit;*/
				/*if(!$valid->verifica_dato($val->TipoDatoText($nombre_columna = "codigo"), "codigo", $codigo))
				{
				$this->salida = $valid->salida;
				return false;
				}*/


				if(!$valid->verifica_dato($this->matriz_validacion[2], "descripcion", $descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[3], "flag_depreciacion", $flag_depreciacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[4], "fecha_reg", $fecha_reg))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[5] ,"estado", $estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
//				if(!$valid->verifica_dato($this->matriz_validacion[6] ,"id_metodo_depreciacion", $id_metodo_depreciacion))
//				{
//					$this->salida = $valid->salida;
//					return false;
//				}

				//Validación de reglas de datos
				$def_estados = array ("activo", "inactivo","eliminado");
				if(!in_array($estado,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'estado': El valor no está dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
				
				$def_estados = array ("si","no");
				if(!in_array($flag_depreciacion,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'depreciable': El valor no está dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
				
				if($flag_depreciacion = "si")
				{
					if($id_metodo_depreciacion = "")
					{
						$this->salida[0] = "f";
						$this->salida[1] = "MENSAJE ERROR = El campo 'id_metodo_depreciacion' no puede estar vacío";
						$this->salida[2] = "ORIGEN = $this->nombre_archivo";
						$this->salida[3] = "PROC = ValidaUnidadConstructiva";
						$this->salida[4] = "NIVEL = 3";
						return false;
					}
				}
				else 
				{
					if($id_metodo_depreciacion != "")
					{
						$this->salida[0] = "f";
						$this->salida[1] = "MENSAJE ERROR = El campo 'id_metodo_depreciacion' debe ser nulo por la condición de Depreciable del Tipo de Activo";
						$this->salida[2] = "ORIGEN = $this->nombre_archivo";
						$this->salida[3] = "PROC = ValidaUnidadConstructiva";
						$this->salida[4] = "NIVEL = 3";
						return false;
					}
				}

				//Validación exitosa
				return true;
				break;

			case 'update':
				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla

				if(!$valid->verifica_dato($this->matriz_validacion[0], "id_tipo_activo", $id_tipo_activo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[1], "codigo", $codigo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[2], "descripcion", $descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[3], "flag_depreciacion", $flag_depreciacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[4], "fecha_reg", $fecha_reg))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[5] ,"estado", $estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
//				if(!$valid->verifica_dato($this->matriz_validacion[6] ,"id_metodo_depreciacion", $id_metodo_depreciacion))
//				{
//					$this->salida = $valid->salida;
//					return false;
//				}
//
				//Validación de reglas de datos
				$def_estados = array ("activo", "inactivo","eliminado");
				if(!in_array($estado,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'estado': El valor no está dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}

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
		$this->matriz_validacion[0]['Columna'] = "id_tipo_activo";
		$this->matriz_validacion[0]['allowBlank'] = "false";
		$this->matriz_validacion[0]['maxLength'] = 15;
		$this->matriz_validacion[0]['minLength'] = 0;
		$this->matriz_validacion[0]['SelectOnFocus'] = "true";
		$this->matriz_validacion[0]['vtype'] = "alphanum";
		$this->matriz_validacion[0]['dataType'] = "entero";
		$this->matriz_validacion[0]['width'] = "";
		$this->matriz_validacion[0]['grow'] = "";

		$this->matriz_validacion[1] = array();
		$this->matriz_validacion[1]['Columna'] = "codigo";
		$this->matriz_validacion[1]['allowBlank'] = "false";
		$this->matriz_validacion[1]['maxLength'] = 2;
		$this->matriz_validacion[1]['minLength'] = 2;
		$this->matriz_validacion[1]['SelectOnFocus'] = "false";
		$this->matriz_validacion[1]['vtype'] = "alphaLatino";
		$this->matriz_validacion[1]['dataType'] = "texto";
		$this->matriz_validacion[1]['width'] = "";
		$this->matriz_validacion[1]['grow'] = "";

		$this->matriz_validacion[2] = array();
		$this->matriz_validacion[2]['Columna'] = "descripcion";
		$this->matriz_validacion[2]['allowBlank'] = "false";
		$this->matriz_validacion[2]['maxLength'] = 100;
		$this->matriz_validacion[2]['minLength'] = 0;
		$this->matriz_validacion[2]['SelectOnFocus'] = "false";
		$this->matriz_validacion[2]['vtype'] = "alphaLatino";
		$this->matriz_validacion[2]['dataType'] = "texto";
		$this->matriz_validacion[2]['width'] = "";
		$this->matriz_validacion[2]['grow'] = "";

		$this->matriz_validacion[3] = array();
		$this->matriz_validacion[3]['Columna'] = "flag_depreciacion";
		$this->matriz_validacion[3]['allowBlank'] = "false";
		$this->matriz_validacion[3]['maxLength'] = 2;
		$this->matriz_validacion[3]['minLength'] = 0;
		$this->matriz_validacion[3]['SelectOnFocus'] = "false";
		$this->matriz_validacion[3]['vtype'] = "alphaLatino";
		$this->matriz_validacion[3]['dataType'] = "texto";
		$this->matriz_validacion[3]['width'] = "";
		$this->matriz_validacion[3]['grow'] = "";

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

		$this->matriz_validacion[5] = array();
		$this->matriz_validacion[5]['Columna'] = "estado";
		$this->matriz_validacion[5]['allowBlank'] = "false";
		$this->matriz_validacion[5]['maxLength'] = 10;
		$this->matriz_validacion[5]['minLength'] = 0;
		$this->matriz_validacion[5]['SelectOnFocus'] = "true";
		$this->matriz_validacion[5]['vtype'] = "alphaLatino";
		$this->matriz_validacion[5]['dataType'] = "texto";
		$this->matriz_validacion[5]['width'] = "";
		$this->matriz_validacion[5]['grow'] = "";

		$this->matriz_validacion[6] = array();
		$this->matriz_validacion[6]['Columna'] = "id_metodo_depreciacion";
		$this->matriz_validacion[6]['allowBlank'] = "true";
		$this->matriz_validacion[6]['maxLength'] = 15;
		$this->matriz_validacion[6]['minLength'] = 0;
		$this->matriz_validacion[6]['SelectOnFocus'] = "false";
		$this->matriz_validacion[6]['vtype'] = "alphaLatino";
		$this->matriz_validacion[6]['dataType'] = "integer";
		$this->matriz_validacion[6]['width'] = "";
		$this->matriz_validacion[6]['grow'] = "";
	}

}?>