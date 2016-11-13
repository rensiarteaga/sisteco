<?php
/**
 * Nombre de la Clase:	cls_DBMotivoIngreso
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_motivo_ingreso
 * Autor:				José A. Mita Huanca
 * Fecha creación:		04-10-2007
 */
class cls_DBMotivoIngreso
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
	var $nombre_archivo = "cls_DBMotivoIngreso.php";

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
	 * Nombre de la función:	ListarMotivoIngreso
	 * Propósito:				Desplegar los registros de tal_motivo_ingreso en función de los parámetros del filtro
	 * Autor:					José A. Mita Huanca
	 * Fecha de creación:		04-10-2007
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
	function ListarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_motivo_ingreso_sel';
		$this->codigo_procedimiento = "'AL_MOTING_SEL'";

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
		$this->var->add_def_cols('id_motivo_ingreso','integer');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_cuenta','integer');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarMotivoIngreso
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					José A. Mita Huanca
	 * Fecha de creación:		04-10-2007
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
	function ContarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_motivo_ingreso_sel';
		$this->codigo_procedimiento = "'AL_MOTING_COUNT'";

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
	 * Nombre de la función:	InsertarMotivoIngreso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_motivo_ingreso
	 * 							con los parámetros requeridos
	 * Autor:					José A. Mita Huanca
	 * Fecha de creación:		04-10-2007
	 * @param unknown_type $id_motivo_ingreso
	 * @param unknown_type $nombre
	 * @param unknown_type $descripcion
	 * @param unknown_type $estado_registro
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_cuenta
	 * @return unknown
	 */
	function InsertarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$id_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_motivo_ingreso_iud';
		$this->codigo_procedimiento = "'AL_MOTING_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_motivo_ingreso
		$this->var->add_param("'$nombre'");//nombre
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$estado_registro'");//estado_registro
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("$id_cuenta");//id_cuenta

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}


	
	/**
	 * Nombre de la función:	ModificarMotivoIngreso
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_motivo_ingreso
	 * 							con los parámetros requeridos
	 * Autor:					José A. Mita Huanca
	 * Fecha de creación:		04-10-2007
	 *
	 * @param unknown_type $id_motivo_ingreso
	 * @param unknown_type $nombre
	 * @param unknown_type $descripcion
	 * @param unknown_type $estado_registro
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_cuenta
	 * @return unknown
	 */
	function ModificarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$id_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_motivo_ingreso_iud';
		$this->codigo_procedimiento = "'AL_MOTING_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_motivo_ingreso");//id_motivo_ingreso
		$this->var->add_param("'$nombre'");//nombre
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$estado_registro'");//estado_registro
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("$id_cuenta");//id_cuenta

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}


	/**
	 * Nombre de la función:	EliminarMotivoIngreso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_motivo_ingreso
	 * 							con los parámetros requeridos
	 * Autor:					José A. Mita Huanca
	 * Fecha de creación:		04-10-2007
	 *
	 * @param unknown_type $id_motivo_ingreso
	 * @return unknown
	 */
	function EliminarMotivoIngreso($id_motivo_ingreso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_motivo_ingreso_iud';
		$this->codigo_procedimiento = "'AL_MOTING_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_motivo_ingreso");//id_motivo_ingreso
		$this->var->add_param("NULL");//nombre
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//estado_registro
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//id_cuenta


		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}


	/**
	 * Nombre de la función:	ValidaMotivoIngreso
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					José A. Mita Huanca
	 * Fecha de creación:		04-10-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_motivo_ingreso
	 * @param unknown_type $nombre
	 * @param unknown_type $descripcion
	 * @param unknown_type $estado_registro
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_cuenta
	 * @return unknown
	 */
	function ValidarMotivoIngreso($operacion_sql, $id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$id_cuenta)
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
				//Validar id_motivo_ingreso - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_motivo_ingreso");
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);
				$tipo_dato->set_Signo('2');

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_motivo_ingreso", $id_motivo_ingreso))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(70);
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
			$tipo_dato->set_MinLength(2);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_registro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(4);

			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_rerg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cuenta - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_MinLength(0);
			$tipo_dato->set_Signo('2');

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_motivo_ingreso - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_motivo_ingreso");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(0);
			$tipo_dato->set_Signo('2');

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_motivo_ingreso", $id_motivo_ingreso))
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