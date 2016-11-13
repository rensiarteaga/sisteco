<?php
/**
 * Nombre de la clase:	cls_DBTipoAlmacen.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_tipo_almacen
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-06 17:22:57
 */

class cls_DBTipoAlmacen
{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	
	function __construct()
	{
		$this->decodificar=$decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarTipoAlmacen
	 * Propósito:				Desplegar los registros de tal_tipo_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 17:22:57
	 */
	function ListarTipoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_almacen_sel';
		$this->codigo_procedimiento = "'AL_TIPALM_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_almacen','int4');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('contabilizar','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoAlmacen
	 * Propósito:				Contar los registros de tal_tipo_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 17:22:57
	 */
	function ContarTipoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_almacen_sel';
		$this->codigo_procedimiento = "'AL_TIPALM_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
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
	 * Nombre de la función:	InsertarTipoAlmacen
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 17:22:57
	 */
	function InsertarTipoAlmacen($id_tipo_almacen,$descripcion,$nombre,$contabilizar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_almacen_iud';
		$this->codigo_procedimiento = "'AL_TIPALM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$contabilizar'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoAlmacen
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_tipo_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 17:22:57
	 */
	function ModificarTipoAlmacen($id_tipo_almacen,$descripcion,$nombre,$contabilizar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_almacen_iud';
		$this->codigo_procedimiento = "'AL_TIPALM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_almacen);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$contabilizar'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoAlmacen
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_tipo_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 17:22:57
	 */
	function EliminarTipoAlmacen($id_tipo_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_almacen_iud';
		$this->codigo_procedimiento = "'AL_TIPALM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_almacen);
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
	 * Nombre de la función:	ValidarTipoAlmacen
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_tipo_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 17:22:57
	 */
	function ValidarTipoAlmacen($operacion_sql,$id_tipo_almacen,$descripcion,$nombre,$contabilizar)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_tipo_almacen - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_almacen");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_almacen", $id_tipo_almacen))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar contabilizar - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("contabilizar");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "contabilizar", $contabilizar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar contabilizar
			$check = array ("si","no");
			if(!in_array($contabilizar,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'contabilizar': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarTipoAlmacen";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_almacen");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_almacen", $id_tipo_almacen))
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