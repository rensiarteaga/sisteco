<?php
/**
 * Nombre de la Clase:	cls_DBTipoCaracteristica.php
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_tipo_caracteristica
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		28-09-2007
 */
class cls_DBTipoCaracteristica
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
	var $nombre_archivo = "cls_DBTipoCaracteristica.php";

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
	 * Nombre de la función:	ListarTipoCaracteristica
	 * Propósito:				Desplegar los registros de tal_tipo_caracteristica en función de los parámetros del filtro
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
	function ListarTipoCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_caracteristica_sel';
		$this->codigo_procedimiento = "'AL_TIPCAR_SEL'";

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
		$this->var->add_def_cols('id_tipo_caracteristica','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarTipoCaracteristica
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
	function ContarTipoCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_caracteristica_sel';
		$this->codigo_procedimiento = "'AL_TIPCAR_COUNT'";

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
	 * Nombre de la función:	InsertarTipoCaracteristica
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_caracteristica
	 * 							con los parámetros requeridos
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_tipo_caracteristica
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $fecha_reg
	 * @return unknown
	 */
	function InsertarTipoCaracteristica($id_tipo_caracteristica,$codigo,$descripcion,$fecha_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_caracteristica_iud';
		$this->codigo_procedimiento = "'AL_TIPCAR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$codigo = strtoupper($codigo);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
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
	 * Nombre de la función:	ModificarTipoCaracteristica
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_tipo_caracteristica
	 * 							con los parámetros requeridos
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_tipo_caracteristica
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $fecha_reg
	 * @return unknown
	 */
	function ModificarTipoCaracteristica($id_tipo_caracteristica,$codigo,$descripcion,$fecha_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_caracteristica_iud';
		$this->codigo_procedimiento = "'AL_TIPCAR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_tipo_caracteristica");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
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
	 * Nombre de la función:	EliminarTipoCaracteristica
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_tipo_caracteristica
	 * 							con los parámetros requeridos
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type id_tipo_caracteristica
	 * @return unknown
	 */
	function EliminarTipoCaracteristica($id_tipo_caracteristica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_caracteristica_iud';
		$this->codigo_procedimiento = "'AL_TIPCAR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_tipo_caracteristica");
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
	 * Nombre de la función:	ValidarTipoCaracteristica
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:				    Rodrigo Chumacero Moscoso
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_tipo_caracteristica
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $fecha_reg
	 * @return unknown
	 */
	function ValidarTipoCaracteristica($operacion_sql,$id_tipo_caracteristica,$codigo,$descripcion,$fecha_reg)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)
		
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validad el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();

		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
		/*******************************Verificación de datos****************************/
		//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
		//Se valida todas las columnas de la tabla
		
		if($operacion_sql == 'update')
		{
		//Validar id_tipo_caracteristica - tipo integer
		$tipo_dato->_reiniciar_valor();
		$tipo_dato->set_Columna("id_tipo_caracteristica");
		$tipo_dato->set_MaxLength(10);
		$tipo_dato->set_MinLength(0);
		
		if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_caracteristica", $id_tipo_caracteristica))
		{
		$this->salida = $valid->salida;
		return false;
		}
		}

		//Validar codigo - tipo varchar
		$tipo_dato->_reiniciar_valor();
		$tipo_dato->set_Columna("codigo");
		$tipo_dato->set_MaxLength(20);
		$tipo_dato->set_MinLength(0);
		
		

		if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
		{
		$this->salida = $valid->salida;
		return false;
		}

		//Validar descripcion - tipo varchar
		$tipo_dato->_reiniciar_valor();
		$tipo_dato->set_Columna("descripcion");
		$tipo_dato->set_MaxLength(100);
		$tipo_dato->set_MinLength(0);

		if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
		{
		$this->salida = $valid->salida;
		return false;
		}

		//Validar fecha_reg - tipo date
		$tipo_dato->_reiniciar_valor();
		$tipo_dato->set_Columna("fecha_reg");
		
		if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
		{
		$this->salida = $valid->salida;
		return false;
		}

		//Validación exitosa
		return true;
		}
		elseif ($operacion_sql=='delete')
		{
		//Validar id_tipo_caracteristica - tipo integer
		$tipo_dato->_reiniciar_valor();
		$tipo_dato->set_Columna("id_tipo_caracteristica");
		$tipo_dato->set_MaxLength(10);
		$tipo_dato->set_MinLength(0);
		$tipo_dato->set_Signo('2');

		if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_caracteristica", $id_tipo_caracteristica))
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
		
		return true;
	}

}?>