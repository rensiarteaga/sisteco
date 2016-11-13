<?php
/**
 * Nombre de la clase:	cls_DBTipoLlamada.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tst_tst_tipo_llamada
 * Autor:				(autogenerado)
 * Fecha creación:		2008-01-17 18:29:44
 */

class cls_DBTipoLlamada
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
	 * Nombre de la función:	ListarTipoLlamada
	 * Propósito:				Desplegar los registros de tst_tipo_llamada
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 18:29:44
	 */
	function ListarTipoLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_tipo_llamada_sel';
		$this->codigo_procedimiento = "'ST_TIPLLA_SEL'";

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
		$this->var->add_def_cols('id_tipo_llamada','int4');
		$this->var->add_def_cols('nombre_tipo_llamada','varchar');
		$this->var->add_def_cols('costo_minuto','numeric');
		$this->var->add_def_cols('descripcion','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoLlamada
	 * Propósito:				Contar los registros de tst_tipo_llamada
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 18:29:44
	 */
	function ContarTipoLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_tipo_llamada_sel';
		$this->codigo_procedimiento = "'ST_TIPLLA_COUNT'";

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
	 * Nombre de la función:	InsertarTipoLlamada
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tst_tipo_llamada
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 18:29:44
	 */
	function InsertarTipoLlamada($id_tipo_llamada,$nombre_tipo_llamada,$costo_minuto,$descripcion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_tipo_llamada_iud';
		$this->codigo_procedimiento = "'ST_TIPLLA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_tipo_llamada'");
		$this->var->add_param($costo_minuto);
		$this->var->add_param("'$descripcion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoLlamada
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tst_tipo_llamada
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 18:29:44
	 */
	function ModificarTipoLlamada($id_tipo_llamada,$nombre_tipo_llamada,$costo_minuto,$descripcion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_tipo_llamada_iud';
		$this->codigo_procedimiento = "'ST_TIPLLA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_llamada);
		$this->var->add_param("'$nombre_tipo_llamada'");
		$this->var->add_param($costo_minuto);
		$this->var->add_param("'$descripcion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoLlamada
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tst_tipo_llamada
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 18:29:44
	 */
	function EliminarTipoLlamada($id_tipo_llamada)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_tipo_llamada_iud';
		$this->codigo_procedimiento = "'ST_TIPLLA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_llamada);
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
	 * Nombre de la función:	ValidarTipoLlamada
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tst_tipo_llamada
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-17 18:29:44
	 */
	function ValidarTipoLlamada($operacion_sql,$id_tipo_llamada,$nombre_tipo_llamada,$costo_minuto,$descripcion)
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
				//Validar id_tipo_llamada - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_llamada");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_llamada", $id_tipo_llamada))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre_tipo_llamada - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_tipo_llamada");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_tipo_llamada", $nombre_tipo_llamada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_minuto - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_minuto");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_minuto", $costo_minuto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_llamada - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_llamada");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_llamada", $id_tipo_llamada))
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