<?php
/**
 * Nombre de la clase:	cls_DBEstadoCompraCategoriaAdq.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_estado_compra_categoria_adq
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-12 10:18:02
 */

 
class cls_DBEstadoCompraCategoriaAdq
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
	 * Nombre de la función:	ListarEstadoCompraCategoriaAdq
	 * Propósito:				Desplegar los registros de tad_estado_compra_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:02
	 */
	function ListarEstadoCompraCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_categoria_adq_sel';
		$this->codigo_procedimiento = "'AD_ESCOCA_SEL'";

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
		$this->var->add_def_cols('id_estado_compra_categoria_adq','int4');
		$this->var->add_def_cols('dias_min','int');
		$this->var->add_def_cols('dias_max','int');
		$this->var->add_def_cols('orden','int4');
		$this->var->add_def_cols('id_estado_compra','int4');
		$this->var->add_def_cols('desc_estado_compra','varchar');
		$this->var->add_def_cols('id_tipo_categoria_adq','int4');
		$this->var->add_def_cols('desc_tipo_categoria_adq','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEstadoCompraCategoriaAdq
	 * Propósito:				Contar los registros de tad_estado_compra_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:02
	 */
	function ContarEstadoCompraCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_categoria_adq_sel';
		$this->codigo_procedimiento = "'AD_ESCOCA_COUNT'";

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
	 * Nombre de la función:	InsertarEstadoCompraCategoriaAdq
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_estado_compra_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:02
	 */
	function InsertarEstadoCompraCategoriaAdq($id_estado_compra_categoria_adq,$dias_min,$dias_max,$orden,$id_estado_compra,$id_tipo_categoria_adq)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_ESCOCA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($dias_min);
		$this->var->add_param($dias_max);
		$this->var->add_param($orden);
		$this->var->add_param($id_estado_compra);
		$this->var->add_param($id_tipo_categoria_adq);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEstadoCompraCategoriaAdq
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_estado_compra_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:02
	 */
	function ModificarEstadoCompraCategoriaAdq($id_estado_compra_categoria_adq,$dias_min,$dias_max,$orden,$id_estado_compra,$id_tipo_categoria_adq)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_ESCOCA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_estado_compra_categoria_adq);
		$this->var->add_param($dias_min);
		$this->var->add_param($dias_max);
		$this->var->add_param($orden);
		$this->var->add_param($id_estado_compra);
		$this->var->add_param($id_tipo_categoria_adq);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEstadoCompraCategoriaAdq
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_estado_compra_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:02
	 */
	function EliminarEstadoCompraCategoriaAdq($id_estado_compra_categoria_adq)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_ESCOCA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_estado_compra_categoria_adq);
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
	 * Nombre de la función:	ValidarEstadoCompraCategoriaAdq
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_estado_compra_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:02
	 */
	function ValidarEstadoCompraCategoriaAdq($operacion_sql,$id_estado_compra_categoria_adq,$dias_min,$dias_max,$orden,$id_estado_compra,$id_tipo_categoria_adq)
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
				//Validar id_estado_compra_categoria_adq - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_estado_compra_categoria_adq");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estado_compra_categoria_adq", $id_estado_compra_categoria_adq))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar dias_min - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("dias_min");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "dias_min", $dias_min))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar dias_max - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("dias_max");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "dias_max", $dias_max))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar orden - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("orden");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "orden", $orden))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_estado_compra - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_estado_compra");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estado_compra", $id_estado_compra))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_categoria_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_categoria_adq");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_categoria_adq", $id_tipo_categoria_adq))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_estado_compra_categoria_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_estado_compra_categoria_adq");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estado_compra_categoria_adq", $id_estado_compra_categoria_adq))
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