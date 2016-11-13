<?php
/**
 * Nombre de la Clase:	cls_DBSuperGrupo
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_supergrupo
 * Autor:				Susana Castro Guaman
 * Fecha creación:		28-09-2007
 */
class cls_DBSuperGrupo
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
	var $nombre_archivo = "cls_DBSuperGrupo.php";

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
	 * Nombre de la función:	ListarSuperGrupo
	 * Propósito:				Desplegar los registros de tal_supergrupo en función de los parámetros del filtro
	 * Autor:					Susana Castro Guaman
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
	function ListarSuperGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supergrupo_sel';
		$this->codigo_procedimiento = "'AL_SUPGRU_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
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
		$this->var->add_def_cols('id_supergrupo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('demasia','varchar');
		$this->var->add_def_cols('registro','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
/**
	 * Nombre de la función:	ListarSuperGrupo
	 * Propósito:				Desplegar los registros de tal_supergrupo en función de los parámetros del filtro
	 * Autor:					Susana Castro Guaman
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
	function ListarSuperGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supergrupo_sel';
		$this->codigo_procedimiento = "'AL_SGRUAL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
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
		$this->var->add_def_cols('id_supergrupo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('demasia','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
/**
	 * Nombre de la función:	ContarSuperGrupo
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Susana Castro Guaman
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
	function ContarSuperGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supergrupo_sel';
		$this->codigo_procedimiento = "'AL_SGRUAL_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
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
	 * Nombre de la función:	ContarSuperGrupo
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					
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
	function ContarSuperGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supergrupo_sel';
		$this->codigo_procedimiento = "'AL_SUPGRU_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
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
		//echo $this->var->get_query_sel();exit;

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
	 * Nombre de la función:	InsertarSuperGrupo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_supergrupo,
	 * 							con los parámetros requeridos
	 * Autor:					Susana Castro Guaman
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_supergrupo
	 * @param unknown_type $codigo
	 * @param unknown_type $nombre
	 * @param unknown_type $descripcion
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $fecha_reg
	 * @return unknown
	 */
	function InsertarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$demasia,$registro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supergrupo_iud';
		$this->codigo_procedimiento = "'AL_SUPGRU_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_supergrupo
		$this->var->add_param("'$codigo'");// codigo
		$this->var->add_param("'$nombre'");//nombre
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$estado_registro'");//estado_registro
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$demasia'");//demasia
		$this->var->add_param("'$registro'");//registro
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}


	/**
	 * Nombre de la función:	ModificarSuperGrupo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_supergrupo
	 * 							con los parámetros requeridos
	 * Autor:					Susana Castro Guaman
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_supergrupo
	 * @param unknown_type $codigo
	 * @param unknown_type $nombre
	 * @param unknown_type $descripcion
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_tipo_material
	 * @param unknown_type $id_grupo
	 * @param unknown_type $id_supergrupo
	 * @return unknown
	 */
	function ModificarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$demasia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supergrupo_iud';
		$this->codigo_procedimiento = "'AL_SUPGRU_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_supergrupo");//id_supergrupo
		$this->var->add_param("'$codigo'");// codigo
		$this->var->add_param("'$nombre'");//nombre
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$estado_registro'");//estado
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$demasia'");//demasia
		$this->var->add_param("NULL");//registro
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}



	/**
	 * Nombre de la función:	EliminarSuperGrupo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_supergrupo
	 * 							con los parámetros requeridos
	 * Autor:					Susana Castro Guaman
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_supergrupo
	 * @return unknown
	 */
	function EliminarSuperGrupo($id_supergrupo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_supergrupo_iud';
		$this->codigo_procedimiento = "'AL_SUPGRU_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_supergrupo");//id_supergrupo
		$this->var->add_param("NULL");// codigo
		$this->var->add_param("NULL");//nombre
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//estado
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//demasia
		$this->var->add_param("NULL");//registro
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}


	/**
	  * Nombre de la función:	ValidaSuperGrupo
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	* Autor:					Susana Castro Guaman
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_supergrupo
	 * @param unknown_type $codigo
	 * @param unknown_type $nombre
	 * @param unknown_type $descripcion
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $fecha_reg
	 * @return unknown
	 */
	function ValidarSuperGrupo($operacion_sql,$id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg)
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
					//Validar id_supergrupo - tipo integer
					$tipo_dato->_reiniciar_valor();
					$tipo_dato->set_Columna("id_supergrupo");
					$tipo_dato->set_MaxLength(10);
					$tipo_dato->set_MinLength(0);
					
					if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_supergrupo", $id_supergrupo))
					{
						$this->salida = $valid->salida;
						return false;
					}
				}

				//Validar codigo - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("codigo");
				$tipo_dato->set_MaxLength(5);
				$tipo_dato->set_MinLength(1);
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validar nombre - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("nombre");
				$tipo_dato->set_MaxLength(100);
				$tipo_dato->set_MinLength(0);

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validar descripcion - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("descripcion");
				$tipo_dato->set_MaxLength(200);
				$tipo_dato->set_MinLength(0);

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validar observaciones - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("observaciones");
				$tipo_dato->set_MaxLength(500);
				$tipo_dato->set_MinLength(0);

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validar estado - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("estado_registro");
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado))
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
				//Validar id_supergrupo - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_supergrupo");
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);
			
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_supergrupo", $id_supergrupo))
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