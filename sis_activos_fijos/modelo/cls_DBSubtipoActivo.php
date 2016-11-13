<?php
/**
 * Nombre de la Clase:	cls_DBSubtipoActivo
 * Propósito:			Permite ejecutar la funcionalidad de la tabla taf_sub_tipo_activo
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		12-06-2007
 *
 */
class cls_DBSubtipoActivo
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
	var $nombre_archivo = "cls_DBSubtipoActivo.php";

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
	 * Nombre de la función:	ListarSubtipoActivo
	 * Propósito:				Desplegar los registros de taf_subtipo_activo en función de los parámetros del filtro
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
	function ListarSubtipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_sub_tipo_activo_consultas';
		$this->codigo_procedimiento = "'AF_SUBTIP_SEL'";

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
		$this->var->add_def_cols('id_sub_tipo_activo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('vida_util','integer');
		$this->var->add_def_cols('tasa_depreciacion','real');
		$this->var->add_def_cols('ini_correlativo','integer');
		$this->var->add_def_cols('correlativo_act','integer');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('desc_tipo_activo','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query ;
		//exit;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ContarListaSubtipoActivo
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
	function ContarListaSubtipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_sub_tipo_activo_consultas';
		$this->codigo_procedimiento = "'AF_SUBTIP_SEL_COUNT'";

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
	 * Nombre de la función:	CrearSubtipoActivo
	 * Propósito:				Permite ejecutar la función de inserción de la taf_sub_tipo_activo de la base de datos,
	 * 							con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_sub_tipo_activo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $vida_util
	 * @param unknown_type $tasa_depreciacion
	 * @param unknown_type $ini_correlativo
	 * @param unknown_type $fin_correlativo
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_tipo_activo
	 * @return unknown
	 */
	function CrearSubtipoActivo($id_sub_tipo_activo, $codigo, $descripcion, $vida_util, $tasa_depreciacion, $ini_correlativo, $correlativo_act, $fecha_reg, $estado, $id_tipo_activo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_sub_tipo_activo';
		$this->codigo_procedimiento = "'AF_SUBTIP_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_sub_tipo_activo
		$this->var->add_param("'$codigo'");//código
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param($vida_util);//vida_util
		$this->var->add_param($tasa_depreciacion);//tasa_depreciacion
		$this->var->add_param($ini_correlativo);//ini_correlativo
		$this->var->add_param($correlativo_act);//fin_correlativo
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_tipo_activo);//id_tipo_activo
			
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarSubtipoActivo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_subtipo_activo de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_sub_tipo_activo
	 * @return unknown
	 */
	function  EliminarSubtipoActivo($id_sub_tipo_activo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_sub_tipo_activo';
		$this->codigo_procedimiento = "'AF_SUBTIP_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_sub_tipo_activo);//id_sub_tipo_activo
		$this->var->add_param("NULL");//código
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//vida_util
		$this->var->add_param("NULL");//tasa_depreciacion
		$this->var->add_param("NULL");//ini_correlativo
		$this->var->add_param("NULL");//fin_correlativo
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//estado
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
	 * Nombre de la función:	ModificarSubtipoActivo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_sub_tipo_activo de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_sub_tipo_activo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $vida_util
	 * @param unknown_type $tasa_depreciacion
	 * @param unknown_type $ini_correlativo
	 * @param unknown_type $fin_correlativo
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_tipo_activo
	 * @return unknown
	 */
	function  ModificarSubtipoActivo($id_sub_tipo_activo, $codigo, $descripcion, $vida_util, $tasa_depreciacion, $ini_correlativo, $correlativo_act, $fecha_reg, $estado, $id_tipo_activo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_sub_tipo_activo';
		$this->codigo_procedimiento = "'AF_SUBTIP_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_sub_tipo_activo);//id_sub_tipo_activo
		$this->var->add_param("'$codigo'");//código
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param($vida_util);//vida_util
		$this->var->add_param($tasa_depreciacion);//tasa_depreciacion
		$this->var->add_param($ini_correlativo);//ini_correlativo
		$this->var->add_param($correlativo_act);//fin_correlativo
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_tipo_activo);//id_tipo_activo
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ValidarSubtipoActivo
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha creación:			12-06-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_sub_tipo_activo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $vida_util
	 * @param unknown_type $tasa_depreciacion
	 * @param unknown_type $ini_correlativo
	 * @param unknown_type $fin_correlativo
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_tipo_activo
	 * @return unknown
	 */
	function ValidarSubtipoActivo($operacion_sql, $id_sub_tipo_activo, $codigo, $descripcion, $vida_util, $tasa_depreciacion, $ini_correlativo, $correlativo_act, $fecha_reg, $estado, $id_tipo_activo)
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
				if(!$valid->verifica_dato($this->matriz_validacion[2], "descripcion", $descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[3], "vida_util", $vida_util))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[4], "tasa_depreciacion", $tasa_depreciacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[5] ,"ini_correlativo", $ini_correlativo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[6] ,"correlativo_act", $correlativo_act))
				{
					$this->salida = $valid->salida;
					return false;
				}
//				if(!$valid->verifica_dato($this->matriz_validacion[7] ,"fecha_reg", $fecha_reg))
//				{
//					$this->salida = $valid->salida;
//					return false;
//				}
				if(!$valid->verifica_dato($this->matriz_validacion[8] ,"estado", $estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
//				if(!$valid->verifica_dato($this->matriz_validacion[9] ,"id_tipo_activo", $id_tipo_activo))
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
				
				//Valida que la tasa de depreciación esté entre 0 y 1
				if($tasa_depreciacion < 0 || $tasa_depreciacion > 100)
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'tasa_depreciacion': El valor debe estar entre 0 y 100";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaUnidadConstructiva";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}

				//Validación exitosa
				return true;
				break;

			case 'update':
				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla

				if(!$valid->verifica_dato($this->matriz_validacion[0], "id_sub_tipo_activo", $id_sub_tipo_activo))
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
				if(!$valid->verifica_dato($this->matriz_validacion[3], "vida_util", $vida_util))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[4], "tasa_depreciacion", $tasa_depreciacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[5] ,"ini_correlativo", $ini_correlativo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[6] ,"correlativo_act", $correlativo_act))
				{
					$this->salida = $valid->salida;
					return false;
				}
//				if(!$valid->verifica_dato($this->matriz_validacion[7] ,"fecha_reg", $fecha_reg))
//				{
//					$this->salida = $valid->salida;
//					return false;
//				}
				if(!$valid->verifica_dato($this->matriz_validacion[8] ,"estado", $estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
//				if(!$valid->verifica_dato($this->matriz_validacion[9] ,"id_tipo_activo", $id_tipo_activo))
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
				
				//Valida que la tasa de depreciación esté entre 0 y 1
				if($tasa_depreciacion < 0 || $tasa_depreciacion > 100)
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'tasa_depreciacion': El valor debe estar entre 0 y 100";
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
		$this->matriz_validacion[0]['Columna'] = "id_sub_tipo_activo";
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
		$this->matriz_validacion[1]['maxLength'] = 3;
		$this->matriz_validacion[1]['minLength'] = 3;
		$this->matriz_validacion[1]['SelectOnFocus'] = "false";
		$this->matriz_validacion[1]['vtype'] = "alphaLatino";
		$this->matriz_validacion[1]['dataType'] = "texto";
		$this->matriz_validacion[1]['width'] = "";
		$this->matriz_validacion[1]['grow'] = "";

		$this->matriz_validacion[2] = array();
		$this->matriz_validacion[2]['Columna'] = "descripcion";
		$this->matriz_validacion[2]['allowBlank'] = "true";
		$this->matriz_validacion[2]['maxLength'] = 100;
		$this->matriz_validacion[2]['minLength'] = 0;
		$this->matriz_validacion[2]['SelectOnFocus'] = "false";
		$this->matriz_validacion[2]['vtype'] = "alphaLatino";
		$this->matriz_validacion[2]['dataType'] = "texto";
		$this->matriz_validacion[2]['width'] = "";
		$this->matriz_validacion[2]['grow'] = "";

		$this->matriz_validacion[3] = array();
		$this->matriz_validacion[3]['Columna'] = "vida_util";
		$this->matriz_validacion[3]['allowBlank'] = "true";
		$this->matriz_validacion[3]['maxLength'] = 2;
		$this->matriz_validacion[3]['minLength'] = 0;
		$this->matriz_validacion[3]['SelectOnFocus'] = "false";
		$this->matriz_validacion[3]['vtype'] = "alphaLatino";
		$this->matriz_validacion[3]['dataType'] = "entero";
		$this->matriz_validacion[3]['width'] = "";
		$this->matriz_validacion[3]['grow'] = "";

		$this->matriz_validacion[4] = array();
		$this->matriz_validacion[4]['Columna'] = "tasa_depreciacion";
		$this->matriz_validacion[4]['allowBlank'] = "true";
		$this->matriz_validacion[4]['maxLength'] = 30;
		$this->matriz_validacion[4]['minLength'] = 0;
		$this->matriz_validacion[4]['SelectOnFocus'] = "true";
		$this->matriz_validacion[4]['vtype'] = "alphaLatino";
		$this->matriz_validacion[4]['dataType'] = "real";
		$this->matriz_validacion[4]['width'] = "";
		$this->matriz_validacion[4]['grow'] = "";

		$this->matriz_validacion[5] = array();
		$this->matriz_validacion[5]['Columna'] = "ini_correlativo";
		$this->matriz_validacion[5]['allowBlank'] = "false";
		$this->matriz_validacion[5]['maxLength'] = 10;
		$this->matriz_validacion[5]['minLength'] = 0;
		$this->matriz_validacion[5]['SelectOnFocus'] = "true";
		$this->matriz_validacion[5]['vtype'] = "alphaLatino";
		$this->matriz_validacion[5]['dataType'] = "entero";
		$this->matriz_validacion[5]['width'] = "";
		$this->matriz_validacion[5]['grow'] = "";

		$this->matriz_validacion[6] = array();
		$this->matriz_validacion[6]['Columna'] = "correlativo_act";
		$this->matriz_validacion[6]['allowBlank'] = "false";
		$this->matriz_validacion[6]['maxLength'] = 15;
		$this->matriz_validacion[6]['minLength'] = 0;
		$this->matriz_validacion[6]['SelectOnFocus'] = "false";
		$this->matriz_validacion[6]['vtype'] = "alphaLatino";
		$this->matriz_validacion[6]['dataType'] = "entero";
		$this->matriz_validacion[6]['width'] = "";
		$this->matriz_validacion[6]['grow'] = "";

		$this->matriz_validacion[7] = array();
		$this->matriz_validacion[7]['Columna'] = "fecha_reg";
		$this->matriz_validacion[7]['allowBlank'] = "true";
		$this->matriz_validacion[7]['maxLength'] = 15;
		$this->matriz_validacion[7]['minLength'] = 0;
		$this->matriz_validacion[7]['SelectOnFocus'] = "false";
		$this->matriz_validacion[7]['vtype'] = "alphaLatino";
		$this->matriz_validacion[7]['dataType'] = "date";
		$this->matriz_validacion[7]['width'] = "";
		$this->matriz_validacion[7]['grow'] = "";
		
		$this->matriz_validacion[8] = array();
		$this->matriz_validacion[8]['Columna'] = "estado";
		$this->matriz_validacion[8]['allowBlank'] = "false";
		$this->matriz_validacion[8]['maxLength'] = 10;
		$this->matriz_validacion[8]['minLength'] = 0;
		$this->matriz_validacion[8]['SelectOnFocus'] = "false";
		$this->matriz_validacion[8]['vtype'] = "alphaLatino";
		$this->matriz_validacion[8]['dataType'] = "texto";
		$this->matriz_validacion[8]['width'] = "";
		$this->matriz_validacion[8]['grow'] = "";
		
		$this->matriz_validacion[9] = array();
		$this->matriz_validacion[9]['Columna'] = "id_tipo_activo";
		$this->matriz_validacion[9]['allowBlank'] = "false";
		$this->matriz_validacion[9]['maxLength'] = 15;
		$this->matriz_validacion[9]['minLength'] = 0;
		$this->matriz_validacion[9]['SelectOnFocus'] = "false";
		$this->matriz_validacion[9]['vtype'] = "alphaLatino";
		$this->matriz_validacion[9]['dataType'] = "integer";
		$this->matriz_validacion[9]['width'] = "";
		$this->matriz_validacion[9]['grow'] = "";
		
	
	}

}?>