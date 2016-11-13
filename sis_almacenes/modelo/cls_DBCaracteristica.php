<?php
/**
 * Nombre de la Clase:	cls_DBCaracteristica.php
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_caracteristica
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		28-09-2007
 */
class cls_DBCaracteristica
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
	var $nombre_archivo = "cls_DBCaracteristica.php";

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
	 * Nombre de la función:	ListarCaracteristica
	 * Propósito:				Desplegar los registros de tal_caracteristica en función de los parámetros del filtro
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
	function ListarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_caracteristica_sel';
		$this->codigo_procedimiento = "'AL_CARACT_SEL'";

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
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('tipo_dato','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_tipo_unidad_medida','integer');
		$this->var->add_def_cols('id_tipo_caracteristica','integer');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('desc_tipo_unid_med','varchar');
		$this->var->add_def_cols('desc_tipo_caracteristica','varchar');


		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarCaracteristica
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
	function ContarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_caracteristica_sel';
		$this->codigo_procedimiento = "'AL_CARACT_COUNT'";

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
	 * Nombre de la función:	InsertarCaracteristica
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_caracteristica
	 * 							con los parámetros requeridos
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_caracteristica
	 * @param unknown_type $codigo
	 * @param unknown_type $nombre
	 * @param unknown_type $tipo_dato
	 * @param unknown_type $descripcion
	 * @param unknown_type $id_tipo_unidad_medida
	 * @param unknown_type $id_tipo_caracteristica
	 * @param unknown_type $fecha_reg
	 * @return unknown
	 */
	function InsertarCaracteristica($id_caracteristica,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_caracteristica_iud';
		$this->codigo_procedimiento = "'AL_CARACT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		//echo "unidad:".$id_tipo_unidad_medida;
		
		$codigo = strtoupper($codigo);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$tipo_dato'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("$id_tipo_unidad_medida");
		$this->var->add_param("$id_tipo_caracteristica");
		$this->var->add_param("'$fecha_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarCaracteristica
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_caracteristica
	 * 							con los parámetros requeridos
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_caracteristica
	 * @param unknown_type $codigo
	 * @param unknown_type $nombre
	 * @param unknown_type $tipo_dato
	 * @param unknown_type $descripcion
	 * @param unknown_type $id_tipo_unidad_medida
	 * @param unknown_type $id_tipo_caracteristica
	 * @param unknown_type $fecha_reg
	 * @return unknown
	 */
	function ModificarCaracteristica($id_caracteristica,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_caracteristica_iud';
		$this->codigo_procedimiento = "'AL_CARACT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_caracteristica");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$tipo_dato'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("$id_tipo_unidad_medida");
		$this->var->add_param("$id_tipo_caracteristica");
		$this->var->add_param("'$fecha_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarCaracteristica
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_caracteristica
	 * 							con los parámetros requeridos
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_caracteristica
	 * @return unknown
	 */
	function EliminarCaracteristica($id_caracteristica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_caracteristica_iud';
		$this->codigo_procedimiento = "'AL_CARACT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_caracteristica");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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

	/**
	 * Nombre de la función:	ValidarCaracteristica
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_caracteristica
	 * @param unknown_type $codigo
	 * @param unknown_type $nombre
	 * @param unknown_type $tipo_dato
	 * @param unknown_type $descripcion
	 * @param unknown_type $id_tipo_unidad_medida
	 * @param unknown_type $id_tipo_caracteristica
	 * @param unknown_type $fecha_reg
	 * @return unknown
	 */
	function ValidarCaracteristica($operacion_sql,$id_caracteristica,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)

		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validad el tipo de dato
		$tipo_datos = new cls_define_tipo_dato();

		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			/*******************************Verificación de datos****************************/
			//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
			//Se valida todas las columnas de la tabla

			if($operacion_sql == 'update')
			{
				//Validar id_caracteristica - tipo integer
				$tipo_datos->_reiniciar_valor();
				$tipo_datos->set_Columna("id_caracteristica");
				$tipo_datos->set_MaxLength(10);
				$tipo_datos->set_MinLength(0);

				if(!$valid->verifica_dato($tipo_datos->TipoDatoInteger(), "id_caracteristica", $id_caracteristica))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_datos->_reiniciar_valor();
			$tipo_datos->set_Columna("nombre");
			$tipo_datos->set_MaxLength(100);
			$tipo_datos->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_datos->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_dato - tipo varchar
			$tipo_datos->_reiniciar_valor();
			$tipo_datos->set_Columna("tipo_dato");
			$tipo_datos->set_MaxLength(30);
			$tipo_datos->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_datos->TipoDatoText(), "tipo_dato", $tipo_dato))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_datos->_reiniciar_valor();
			$tipo_datos->set_Columna("descripcion");
			$tipo_datos->set_MaxLength(200);
			$tipo_datos->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_datos->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_unidad_medida - tipo integer
			$tipo_datos->_reiniciar_valor();
			$tipo_datos->set_Columna("id_tipo_unidad_medida");
			$tipo_datos->set_MaxLength(15);
			$tipo_datos->set_MinLength(0);
			$tipo_datos->set_AllowBlank("true");

			if(!$valid->verifica_dato($tipo_datos->TipoDatoInteger(), "id_tipo_unidad_medida", $id_tipo_unidad_medida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_caracteristica - tipo integer
			$tipo_datos->_reiniciar_valor();
			$tipo_datos->set_Columna("id_tipo_caracteristica");
			$tipo_datos->set_MaxLength(15);
			$tipo_datos->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_datos->TipoDatoInteger(), "id_tipo_caracteristica", $id_tipo_caracteristica))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo integer
			$tipo_datos->_reiniciar_valor();
			$tipo_datos->set_Columna("fecha_reg");

			if(!$valid->verifica_dato($tipo_datos->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar tipo_dato
			$check = array ("Entero","Decimal","Texto","Fecha");
			if(!in_array($tipo_dato,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'tipo_dato': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = Validar Característica";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}

			if($tipo_dato=='Texto' || $tipo_dato=='Fecha')
			{
				if($id_tipo_unidad_medida!='')
				{
					$this->salida[0] = "f";
					$this->salida[1] = "Error de validación en columna 'unidad_medida': La unidad de medida debe ser vacía debido al tipo de dato seleccionado";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = Validar Característica";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_caracteristica - tipo integer
			$tipo_datos->_reiniciar_valor();
			$tipo_datos->set_Columna("id_caracteristica");
			$tipo_datos->set_MaxLength(10);
			$tipo_datos->set_MinLength(0);

			if(!$valid->verifica_dato($tipo_datos->TipoDatoInteger(), "id_caracteristica", $id_caracteristica))
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