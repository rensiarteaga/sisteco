<?php
/**
 * Nombre de la clase:	cls_DBPreferenciaDetalle.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_preferencia_detalle
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-29 15:55:39
 */

class cls_DBPreferenciaDetalle
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
	 * Nombre de la función:	ListarPreferenciaDetalle
	 * Propósito:				Desplegar los registros de tsg_preferencia_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-29 15:55:39
	 */
	function ListarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_preferencia_detalle_sel';
		$this->codigo_procedimiento = "'SG_PREDET_SEL'";

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
		$this->var->add_def_cols('id_preferencia_detalle','int4');
		$this->var->add_def_cols('nombre_atributo','varchar');
		$this->var->add_def_cols('valor_atributo','varchar');
		$this->var->add_def_cols('descripcion_atributo','varchar');
		$this->var->add_def_cols('id_preferencia','int4');
		$this->var->add_def_cols('desc_preferencia','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPreferenciaDetalle
	 * Propósito:				Contar los registros de tsg_preferencia_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-29 15:55:39
	 */
	function ContarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_preferencia_detalle_sel';
		$this->codigo_procedimiento = "'SG_PREDET_COUNT'";

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
	 * Nombre de la función:	InsertarPreferenciaDetalle
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_preferencia_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-29 15:55:39
	 */
	function InsertarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_preferencia_detalle_iud';
		$this->codigo_procedimiento = "'SG_PREDET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_atributo'");
		$this->var->add_param("'$valor_atributo'");
		$this->var->add_param("'$descripcion_atributo'");
		$this->var->add_param($id_preferencia);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPreferenciaDetalle
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_preferencia_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-29 15:55:39
	 */
	function ModificarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_preferencia_detalle_iud';
		$this->codigo_procedimiento = "'SG_PREDET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_preferencia_detalle);
		$this->var->add_param("'$nombre_atributo'");
		$this->var->add_param("'$valor_atributo'");
		$this->var->add_param("'$descripcion_atributo'");
		$this->var->add_param($id_preferencia);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPreferenciaDetalle
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_preferencia_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-29 15:55:39
	 */
	function EliminarPreferenciaDetalle($id_preferencia_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_preferencia_detalle_iud';
		$this->codigo_procedimiento = "'SG_PREDET_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_preferencia_detalle);
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
	 * Nombre de la función:	ValidarPreferenciaDetalle
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_preferencia_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-29 15:55:39
	 */
	function ValidarPreferenciaDetalle($operacion_sql,$id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
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
				//Validar id_preferencia_detalle - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_preferencia_detalle");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_preferencia_detalle", $id_preferencia_detalle))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre_atributo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_atributo");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_atributo", $nombre_atributo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar valor_atributo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("valor_atributo");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "valor_atributo", $valor_atributo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion_atributo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion_atributo");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion_atributo", $descripcion_atributo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_preferencia - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_preferencia");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_preferencia", $id_preferencia))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_preferencia_detalle - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_preferencia_detalle");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_preferencia_detalle", $id_preferencia_detalle))
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