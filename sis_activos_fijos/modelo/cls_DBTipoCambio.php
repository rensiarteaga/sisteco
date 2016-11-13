<?php
/**
 * Nombre de la Clase:	cls_DBTipoCambio
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tpm_tipo_cambio
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		28-06-2007
 *
 */
class cls_DBTipoCambio
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
	var $nombre_archivo = "cls_DBTipoCambio.php";

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
	 * Nombre de la función:	ListarTipoCambio
	 * Propósito:				Desplegar los registros de tpm_tipo_cambio en función de los parámetros del filtro
	 * Autor:					
	 * Fecha de creación:		29-06-2007
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

	
	
	function ListarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio_consultas';
		$this->codigo_procedimiento = "'PM_TIP_CAM_SEL'";

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
		$this->var->add_def_cols('id_tipo_cambio','integer');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('hora','time');
		$this->var->add_def_cols('oficial','numeric');
		$this->var->add_def_cols('compra','numeric');
		$this->var->add_def_cols('venta','numeric');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('des_moneda','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarListaTipoCambio
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					
	 * Fecha de creación:		29-06-2007
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
	function ContarListaTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio_consultas';
		$this->codigo_procedimiento = "'PM_TIP_CAM_SEL_COUNT'";

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
	 * Nombre de la función:	CrearTipoCambio
	 * Propósito:				Permite ejecutar la función de inserción de la tpm_tipo_cambio de la base de datos,
	 * 							con los parámetros requeridos
	 * Autor:					
	 * Fecha de creación:		29-06-2007
	 *
	 * @param unknown_type $id_tipo_cambio
	 * @param unknown_type $fecha
	 * @param unknown_type $oficial
	 * @param unknown_type $compra
	 * @param unknown_type $venta
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $id_moneda
	 * @return unknown
	 */
	function CrearTipoCambio($id_tipo_cambio, $fecha, $oficial, $compra, $venta,$observaciones,$estado,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio';
		$this->codigo_procedimiento = "'PM_TIP_CAM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_tipo_cambio
		$this->var->add_param("'$fecha'");//fecha
		$this->var->add_param("'$oficial'");//oficial
		$this->var->add_param("'$compra'");//compra
		$this->var->add_param("'$venta'");//venta
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_moneda);//id_moneda

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarTipoCambio
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_tipo_cambio de la base de datos
	 * con los parámetros requeridos
	 * Autor:					
	 * Fecha de creación:		29-06-2007
	 *
	 * @param unknown_type $id_tipo_cambio
	 * @return unknown
	 */
	function  EliminarTipoCambio($id_tipo_cambio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio';
		$this->codigo_procedimiento = "'PM_TIP_CAM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_tipo_cambio);//id_tipo_cambio
		$this->var->add_param("NULL");//fecha
		
		$this->var->add_param("NULL");//oficial
		$this->var->add_param("NULL");//compra
		$this->var->add_param("NULL");//venta
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//estado
		$this->var->add_param("NULL");//id_moneda

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
/**
 * Nombre de la función:	ModificarTipoCambio
 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_tipo_cambio de la base de datos
 * 							con los parámetros requeridos
 * Autor:					
 * Fecha de creación:		29-06-2007
 *
 * @param unknown_type $id_tipo_cambio
 * @param unknown_type $fecha
 * @param unknown_type $oficial
 * @param unknown_type $compra
 * @param unknown_type $venta
 * @param unknown_type $observaciones
 * @param unknown_type $estado
 * @param unknown_type $id_moneda
 * @return unknown
 */
	
	function  ModificarTipoCambio($id_tipo_cambio, $fecha,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio';
		$this->codigo_procedimiento = "'PM_TIP_CAM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_tipo_cambio);//id_tipo_cambio
		$this->var->add_param("'$fecha'");//fecha
		$this->var->add_param("'$oficial'");//oficial
		$this->var->add_param("'$compra'");//compra
		$this->var->add_param("'$venta'");//venta
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_moneda);//id_moneda

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ValidarTipoCambio
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					
	 * Fecha creación:			29-06-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_tipo_cambio
	 * @param unknown_type $fecha
	 * @param unknown_type $oficial
	 * @param unknown_type $compra
	 * @param unknown_type $venta
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $id_moneda
	 * @return unknown
	 */
	function ValidarTipoCambio($operacion_sql, $id_tipo_cambio, $fecha,$oficial, $compra, $venta,$observaciones,$estado,$id_moneda)
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
				if(!$valid->verifica_dato($this->matriz_validacion[1], "fecha", $fecha))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				if(!$valid->verifica_dato($this->matriz_validacion[3], "oficial", $oficial))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[4], "compra", $compra))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[5] ,"venta", $venta))
				{
					$this->salida = $valid->salida;
					return false;
				}

				if(!$valid->verifica_dato($this->matriz_validacion[6] ,"observaciones", $observaciones))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[7] ,"estado", $estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[8] ,"id_moneda", $id_moneda))
				{
					$this->salida = $valid->salida;
					return false;
				}



				//Validación de reglas de datos
				$def_estados = array ("activo", "inactivo");
				if(!in_array($estado,$def_estados))
				{
					$this->salida[0] = "f";
					$this->salida[1] = "MENSAJE ERROR = Error de validación en columna 'estado': El valor no está dentro del dominio definido";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidaMoneda";
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

				if(!$valid->verifica_dato($this->matriz_validacion[0], "id_tipo_cambio", $id_tipo_cambio))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[1], "fecha", $fecha))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				if(!$valid->verifica_dato($this->matriz_validacion[3], "oficial", $oficial))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[4], "compra", $compra))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[5] ,"venta", $venta))
				{
					$this->salida = $valid->salida;
					return false;
				}

				if(!$valid->verifica_dato($this->matriz_validacion[6] ,"observaciones", $observaciones))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[7] ,"estado", $estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[8] ,"id_moneda", $id_moneda))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validación de reglas de datos
				$def_estados = array ("activo", "inactivo");
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
	
	
	/**
	 * Nombre de la función:	ObtenerTipoCambio
	 * Propósito:				Obtener el tipo de cambio de la moneda1 en función de la moneda2 a una fecha específica
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-06-2007
	 *
	 * @param unknown_type $fecha
	 * @param unknown_type $id_moneda1
	 * @param unknown_type $id_moneda2
	 * @param unknown_type $tipo
	 * @return unknown
	 */
	function ObtenerTipoCambio($fecha, $id_moneda1, $id_moneda2, $tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_pm_get_tipo_cambio';
		$this->codigo_procedimiento = "NULL";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		
		//Carga los parámetros específicos de la estructura programática
		
		$this->var->add_param($func->iif($fecha == '','NULL' ,"'$fecha'"));//fecha
		$this->var->add_param($func->iif($id_moneda1 == '',1,$id_moneda1));//id_moneda1
		$this->var->add_param($func->iif($id_moneda2 == '',2,$id_moneda2));//id_moneda2
		$this->var->add_param($func->iif($tipo == '',"'O'","'$tipo'"));//tipo

		//Ejecuta la función de consulta
		$res = $this->var->exec_function();

		//Obtiene el tipo de cambio devuelto por la función
		$this->salida = $this->var->salida;
		
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ObtenerTipoCambio
	 * Propósito:				Obtener el tipo de cambio de la moneda1 en función de la moneda2 a una fecha específica
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-06-2007
	 *
	 * @param unknown_type $fecha
	 * @param unknown_type $id_moneda1
	 * @param unknown_type $id_moneda2
	 * @param unknown_type $tipo
	 * @return unknown
	 */
	function ConvertirMonto($fecha, $monto, $id_moneda1, $id_moneda2, $tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_pm_conversion_monedas';
		$this->codigo_procedimiento = "NULL";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param("'$fecha'");//fecha
		$this->var->add_param($monto);//monto
		$this->var->add_param($func->iif($id_moneda1 == '','NULL',$id_moneda1));//id_moneda1
		$this->var->add_param($func->iif($id_moneda2 == '','NULL',$id_moneda2));//id_moneda2
		$this->var->add_param($func->iif($tipo == '','O',"'$tipo'"));//tipo

		//Ejecuta la función de consulta
		$res = $this->var->exec_function();

		//Obtiene el tipo de cambio devuelto por la función
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function cargar_param_valid()
	{
		$this->matriz_validacion[0] = array();
		$this->matriz_validacion[0]['Columna'] = "id_tipo_cambio";
		$this->matriz_validacion[0]['allowBlank'] = "false";
		$this->matriz_validacion[0]['maxLength'] = 15;
		$this->matriz_validacion[0]['minLength'] = 0;
		$this->matriz_validacion[0]['SelectOnFocus'] = "true";
		$this->matriz_validacion[0]['vtype'] = "alphanum";
		$this->matriz_validacion[0]['dataType'] = "entero";
		$this->matriz_validacion[0]['width'] = "";
		$this->matriz_validacion[0]['grow'] = "";

		$this->matriz_validacion[1] = array();
		$this->matriz_validacion[1]['Columna'] = "fecha";
		$this->matriz_validacion[1]['allowBlank'] = "false";
		$this->matriz_validacion[1]['maxLength'] = 15;
		$this->matriz_validacion[1]['minLength'] = 0;
		$this->matriz_validacion[1]['SelectOnFocus'] = "false";
		$this->matriz_validacion[1]['vtype'] = "alphanum";
		$this->matriz_validacion[1]['dataType'] = "fecha";
		$this->matriz_validacion[1]['width'] = "";
		$this->matriz_validacion[1]['grow'] = "";

		
		
		$this->matriz_validacion[2] = array();
		$this->matriz_validacion[2]['Columna'] = "oficial";
		$this->matriz_validacion[2]['allowBlank'] = "false";
		$this->matriz_validacion[2]['maxLength'] = 5;
		$this->matriz_validacion[2]['minLength'] = 0;
		$this->matriz_validacion[2]['SelectOnFocus'] = "false";
		$this->matriz_validacion[2]['vtype'] = "alphanum";
		$this->matriz_validacion[2]['dataType'] = "numeric";
		$this->matriz_validacion[2]['width'] = "";
		$this->matriz_validacion[2]['grow'] = "";

		$this->matriz_validacion[3] = array();
		$this->matriz_validacion[3]['Columna'] = "compra";
		$this->matriz_validacion[3]['allowBlank'] = "false";
		$this->matriz_validacion[3]['maxLength'] = 5;
		$this->matriz_validacion[3]['minLength'] = 0;
		$this->matriz_validacion[3]['SelectOnFocus'] = "false";
		$this->matriz_validacion[3]['vtype'] = "alphanum";
		$this->matriz_validacion[3]['dataType'] = "numeric";
		$this->matriz_validacion[3]['width'] = "";
		$this->matriz_validacion[3]['grow'] = "";

		$this->matriz_validacion[4] = array();
		$this->matriz_validacion[4]['Columna'] = "venta";
		$this->matriz_validacion[4]['allowBlank'] = "false";
		$this->matriz_validacion[4]['maxLength'] = 5;
		$this->matriz_validacion[4]['minLength'] = 0;
		$this->matriz_validacion[4]['SelectOnFocus'] = "true";
		$this->matriz_validacion[4]['vtype'] = "alphanum";
		$this->matriz_validacion[4]['dataType'] = "numeric";
		$this->matriz_validacion[4]['width'] = "";
		$this->matriz_validacion[4]['grow'] = "";

		$this->matriz_validacion[5] = array();
		$this->matriz_validacion[5]['Columna'] = "observaciones";
		$this->matriz_validacion[5]['allowBlank'] = "true";
		$this->matriz_validacion[5]['maxLength'] = 100;
		$this->matriz_validacion[5]['minLength'] = 0;
		$this->matriz_validacion[5]['SelectOnFocus'] = "true";
		$this->matriz_validacion[5]['vtype'] = "alphaLatino";
		$this->matriz_validacion[5]['dataType'] = "texto";
		$this->matriz_validacion[5]['width'] = "";
		$this->matriz_validacion[5]['grow'] = "";
		
		
		$this->matriz_validacion[6] = array();
		$this->matriz_validacion[6]['Columna'] = "estado";
		$this->matriz_validacion[6]['allowBlank'] = "false";
		$this->matriz_validacion[6]['maxLength'] = 10;
		$this->matriz_validacion[6]['minLength'] = 0;
		$this->matriz_validacion[6]['SelectOnFocus'] = "true";
		$this->matriz_validacion[6]['vtype'] = "alphaLatino";
		$this->matriz_validacion[6]['dataType'] = "texto";
		$this->matriz_validacion[6]['width'] = "";
		$this->matriz_validacion[6]['grow'] = "";

		$this->matriz_validacion[7] = array();
		$this->matriz_validacion[7]['Columna'] = "id_moneda";
		$this->matriz_validacion[7]['allowBlank'] = "false";
		$this->matriz_validacion[7]['maxLength'] = 10;
		$this->matriz_validacion[7]['minLength'] = 0;
		$this->matriz_validacion[7]['SelectOnFocus'] = "true";
		$this->matriz_validacion[7]['vtype'] = "alphanum";
		$this->matriz_validacion[7]['dataType'] = "entero";
		$this->matriz_validacion[7]['width'] = "";
		$this->matriz_validacion[7]['grow'] = "";
		
		
		
	}
	

}?>