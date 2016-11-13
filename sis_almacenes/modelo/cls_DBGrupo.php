<?php
/**
 * Nombre de la Clase:	cls_DBGrupo
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_grupo
 * Autor:				Susana Castro Guaman
 * Fecha creación:		28-09-2007
 */
class cls_DBGrupo
{	//Variable que contiene la salida de la ejecución de la función
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
	var $nombre_archivo = "cls_DBGrupo.php";

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
	 * Nombre de la función:	ListarGrupo
	 * Propósito:				Desplegar los registros de tal_grupo en función de los parámetros del filtro
	 * Autor:					Susana Castro G.
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
	function ListarGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_grupo_sel';
		$this->codigo_procedimiento = "'AL_GRUPO_SEL'";

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
		$this->var->add_def_cols('id_grupo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_supergrupo','integer');
		$this->var->add_def_cols('desc_supergrupo','varchar');
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
	 * Nombre de la función:	ContarGrupo
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Susana Castro G.
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
	function ContarGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_grupo_sel';
		$this->codigo_procedimiento = "'AL_GRUPO_COUNT'";

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
	 * Nombre de la función:	ListarGrupoAlmacen
	 * Propósito:				Desplegar los registros de tal_grupo en función de los parámetros del filtro
	 * Autor:					Susana Castro G.
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
	function ListarGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_grupo_sel';
		$this->codigo_procedimiento = "'AL_GRUAL_SEL'";

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
		$this->var->add_def_cols('id_grupo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_supergrupo','integer');
		$this->var->add_def_cols('desc_supergrupo','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarGrupo
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Susana Castro G.
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
	function ContarGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_grupo_sel';
		$this->codigo_procedimiento = "'AL_GRUAL_COUNT'";

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
	 * Nombre de la función:	InsertarGrupo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_grupo,
	 * 							con los parámetros requeridos
	 * Autor:					Susana Castro G.
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_grupo
	 * @param unknown_type $nombre
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_supergrupo
	 * @return unknown
	 */
	function InsertarGrupo($id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo,$registro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_grupo_iud';
		$this->codigo_procedimiento = "'AL_GRUPO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_grupo
		$this->var->add_param("'$codigo'");//codigo
		$this->var->add_param("'$nombre'");// nombre
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$estado_registro'");//estado_registro
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("$id_supergrupo");//id_supergrupo
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
	 * Nombre de la función:	ModificarGrupo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_grupo
	 * 							con los parámetros requeridos
	 * Autor:					Susana Castro G
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_grupo
	 * @param unknown_type $nombre
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_supergrupo
	 * @return unknown
	 */
	function ModificarGrupo($id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_grupo_iud';
		$this->codigo_procedimiento = "'AL_GRUPO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_grupo");//id_grupo
		$this->var->add_param("'$codigo'");// codigo
		$this->var->add_param("'$nombre'");//nombre
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$estado_registro'");//estado
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("$id_supergrupo");//id_supergrupo
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
	 * Nombre de la función:	EliminarGrupo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_grupo
	 * 							con los parámetros requeridos
	 * Autor:					Susana Castro G.
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $id_grupo
	 * @return unknown
	 */
	function EliminarGrupo($id_grupo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_grupo_iud';
		$this->codigo_procedimiento = "'AL_GRUPO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_grupo");//id_parametros_almacen
		$this->var->add_param("NULL");//nombre
		$this->var->add_param("NULL");// codigo
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//estado
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//id_supergrupo
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
	  * Nombre de la función:	ValidarGrupo
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	* Autor:					Susana Castro G.
	 * Fecha de creación:		28-09-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_grupo
	 * @param unknown_type $nombre
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_supergrupo
	 * @return unknown
	 */
	function ValidarGrupo($operacion_sql,$id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo)
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
					//Validar id_grupo - tipo integer
					$tipo_dato->_reiniciar_valor();
					$tipo_dato->set_Columna("id_grupo");
					$tipo_dato->set_MaxLength(10);
					$tipo_dato->set_MinLength(0);
					
					if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo", $id_grupo))
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
				$tipo_dato->set_MaxLength(100);
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
						
				//Validar id_super_grupo - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_supergrupo");
				$tipo_dato->set_MaxLength(15);
				$tipo_dato->set_MinLength(0);
			
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_supergrupo", $id_supergrupo))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validación exitosa
				return true;
		}
		elseif ($operacion_sql=='delete')
		{
				//Validar id_grupo - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_grupo");
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);
			
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo", $id_grupo))
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