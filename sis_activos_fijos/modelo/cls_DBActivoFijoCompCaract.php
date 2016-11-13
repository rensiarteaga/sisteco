<?php
/**
 * Nombre de la Clase:	cls_DBActivoFijoCompCaract
 * Propósito:			Permite ejecutar la funcionalidad de la tabla taf_activo_fijo_comp_caract
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		10-06-2007
 */
class cls_DBActivoFijoCompCaract
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

	var $nombre_archivo = "cls_DBActivoFijoCompCaract.php";
	
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
 * Nombre de la función:	ListarActivoFijoCompCaract
 * Propósito:				Desplegar los registros de taf_activo_fijo_comp_caract en función de los parámetros del filtro
 * Autor:					Mercedes Zambrana Meneses
 * Fecha de creación:		10-06-2007
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
	function ListarActivoFijoCompCaract($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{


		$this->salida ="";
		$this->nombre_funcion = 'f_taf_activo_fijo_comp_caract_consultas';
		$this->codigo_procedimiento = "'AF_AF_COM_CAR_SEL'";

		$func = new cls_funciones();
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";


		//Carga los parámetros específos
        $this->var->add_param($func->iif($id_financiador == '','NULL',"'$id_financiador'"));//id_financiador
        $this->var->add_param($func->iif($id_regional == '','NULL',"'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',"'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',"'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',"'$id_actividad'"));//id_actividad

		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_activo_fijo_comp_caract','integer');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_caracteristica','integer');
		$this->var->add_def_cols('id_componente','integer');
		$this->var->add_def_cols('des_caracteristica','varchar');
		$this->var->add_def_cols('des_componente','varchar');
		

		//Ejecuta la función de consulta
		$res = $this ->var->exec_query();


	//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
	/*	echo $this->query;
		exit;	*/
		return $res;
	}
/**
 * 
 * Nombre de la función:	ContarListaActivoFijoCompCaract
 * Propósito:				Contar los registros de taf_activo_fijo_comp_caract en función de los parámetros del filtro
 * Autor:					Mercedes Zambrana Meneses
 * Fecha de creación:		10-06-2007
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
	function ContarListaActivoFijoCompCaract($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_comp_caract_consultas';
		$this->codigo_procedimiento = "'AF_AF_COM_CAR_SEL_COUNT'";


		$func = new cls_funciones();//Instancia de las funciones generales
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);


		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga parámetros específicos
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));
		$this->var->add_param($func->iif($id_proyecto== '','NULL',$id_proyecto));
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva al total de la consulta
		if($res)
		{
			$this->salida[1] = $this->var->salida[1][0][0];

		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//Retorna el resultado de la ejecución
		return $res;
	}

	/**
	 * 
 	 * Nombre de la función:		CrearActivoFijoCompCaract
 	 * Propósito:				Permite ejecutar la función de inserción de la taf_activo_fijo_comp_caract de la base de datos,
	 * 							con los parámetros requeridos
 	 * Autor:					Mercedes Zambrana Meneses
 	 * Fecha de creación:		10-06-2007
	 *
	 * @param unknown_type $id_activo_fijo_comp_caract
	 * @param unknown_type $descripcion
	 * @param unknown_type $id_caracteristica
	 * @param unknown_type $id_componente
	 * @return unknown
	 */
	
	
	function CrearActivoFijoCompCaract($id_activo_fijo_comp_caract,$descripcion,$id_caracteristica,$id_componente)
	{
	
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_comp_caract';
		$this->codigo_procedimiento = "'AF_AF_COM_CAR_INS'";

		
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

//echo $id_activo_fijo_comp_caract."       desc->  ".$descripcion."       id_car->  ".$id_caracteristica."        id_comp-> ".$id_componente;

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param('NULL');//id_fina_regi_
		$this->var->add_param('NULL');//id_act_fij_com_car
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param($id_caracteristica);//id_caracteristica
		$this->var->add_param($id_componente);//id_componente

		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}


	/**
	 * Nombre de la función:	EliminarActivoFijoCompCaract
 	 * Propósito:				Permite ejecutar la función de eliminacion de la taf_activo_fijo_comp_caract de la base de datos,
	 * 							con los parámetros requeridos
 	 * Autor:					Mercedes Zambrana Meneses
 	 * Fecha de creación:		10-06-2007
	 *
	 * @param unknown_type $id_activo_fijo_comp_caract
	 * @return unknown
	 */
	function  EliminarActivoFijoCompCaract($id_activo_fijo_comp_caract)
	{

		$this->salida="";
		$this->nombre_funcion = 'f_taf_activo_fijo_comp_caract';
		$this->codigo_procedimiento = "'AF_AF_COM_CAR_DEL'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param('NULL');//id_fina_regi
		$this->var->add_param($id_activo_fijo_comp_caract);//id_MOTIVO
		$this->var->add_param('NULL');//descripcion
		$this->var->add_param('NULL');//CARAC
		$this->var->add_param('NULL');//COMP

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
/**
 * Nombre de la función:	ModificarActivoFijoCompCaract
 * Propósito:				Permite ejecutar la función de modificacion de taf_activo_fijo_comp_caract de la base de datos,
 * 							con los parámetros requeridos
 * Autor:					Mercedes Zambrana Meneses
 * Fecha de creación:		10-06-2007
 *
 * @param unknown_type $id_activo_fijo_comp_caract
 * @param unknown_type $descripcion
 * @param unknown_type $id_caracteristica
 * @param unknown_type $id_componente
 * @return unknown
 */

	function  ModificarActivoFijoCompCaract($id_activo_fijo_comp_caract,$descripcion,$id_caracteristica,$id_componente)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_comp_caract';
		$this->codigo_procedimiento = "'AF_AF_COM_CAR_UPD'";

		
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		
		$this->var->add_param('NULL');//id_fina_regi_
		$this->var->add_param($id_activo_fijo_comp_caract);//id_act_fij_com_car
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param($id_caracteristica);//id_caracteristica
		$this->var->add_param($id_componente);//id_componente

		//Carga parámetros específicos (no incluyen los parámetros fijos)

		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
/**
 * Nombre de la función:	ValidarActivoFijoCompCaract
 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
 * Autor:					Mercedes Zambrana Meneses
 * Fecha de creación:		10-06-2007
 *
 * @param unknown_type $operacion_sql
 * @param unknown_type $id_activo_fijo_comp_caract
 * @param unknown_type $descripcion
 * @param unknown_type $id_caracteristica
 * @param unknown_type $id_componente
 * @return unknown
 */
	function ValidarActivoFijoCompCaract($operacion_sql,$id_activo_fijo_comp_caract,$descripcion,$id_caracteristica,$id_componente)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)
		
		$this->salida = "";
		$valid = new cls_validacion_serv();
		$tipo_dato = new cls_define_tipo_dato();
		//Ejecuta la validación por el tipo de operación
			if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_cotizacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_activo_fijo_comp_caract");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_activo_fijo_comp_caract", $id_activo_fijo_comp_caract))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

//Validar id_proceso_compra - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_caracteristica");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_caracteristica", $id_caracteristica))
			{
				$this->salida = $valid->salida;
				return false;
			}

			

			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_componente");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_componente", $id_componente))
			{
				$this->salida = $valid->salida;
				return false;
			}
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cotizacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_activo_fijo_comp_caract");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_activo_fijo_comp_caract", $id_activo_fijo_comp_caract))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validaciï¿½n exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}



	function cargar_param_valid()
	{
		$this->matriz_validacion[0] = array();
		$this->matriz_validacion[0]['Columna'] = "id_activo_fijo_comp_caract";
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
		$this->matriz_validacion[1]['allowBlank'] = "false";
		$this->matriz_validacion[1]['maxLength'] = 100;
		$this->matriz_validacion[1]['minLength'] = 0;
		$this->matriz_validacion[1]['SelectOnFocus'] = "false";
		$this->matriz_validacion[1]['vtype'] = "alphaLatino";
		$this->matriz_validacion[1]['dataType'] = "texto";
		$this->matriz_validacion[1]['width'] = "";
		$this->matriz_validacion[1]['grow'] = "";
		
		
		$this->matriz_validacion[2] = array();
		$this->matriz_validacion[2]['Columna'] = "id_caracteristica";
		$this->matriz_validacion[2]['allowBlank'] = "false";
		$this->matriz_validacion[2]['maxLength'] = 15;
		$this->matriz_validacion[2]['minLength'] = 0;
		$this->matriz_validacion[2]['SelectOnFocus'] = "false";
		$this->matriz_validacion[2]['vtype'] = "alphaLatino";
		$this->matriz_validacion[2]['dataType'] = "integer";
		$this->matriz_validacion[2]['width'] = "";
		$this->matriz_validacion[2]['grow'] = "";

		
		$this->matriz_validacion[3] = array();
		$this->matriz_validacion[3]['Columna'] = "id_componente";
		$this->matriz_validacion[3]['allowBlank'] = "false";
		$this->matriz_validacion[3]['maxLength'] = 15;
		$this->matriz_validacion[3]['minLength'] = 0;
		$this->matriz_validacion[3]['SelectOnFocus'] = "false";
		$this->matriz_validacion[3]['vtype'] = "alphaLatino";
		$this->matriz_validacion[3]['dataType'] = "integer";
		$this->matriz_validacion[3]['width'] = "";
		$this->matriz_validacion[3]['grow'] = "";

	}

}?>