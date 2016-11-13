<?php
/**
 * Nombre de la clase:	cls_DBMemInversionGasto.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_mem_inversion_gasto
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-07 17:57:12
 */

 
class cls_DBMemInversionGasto
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
	 * Nombre de la función:	ListarMemoriaGasto
	 * Propósito:				Desplegar los registros de tpr_mem_inversion_gasto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:12
	 */
	function ListarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_inversion_gasto_sel';
		$this->codigo_procedimiento = "'PR_MEMGAS_SEL'";

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
		$this->var->add_def_cols('id_mem_inversion_gasto','int4');
		$this->var->add_def_cols('cantidad','int4');
		$this->var->add_def_cols('costo_unitario','numeric');
		$this->var->add_def_cols('periodo_pres','numeric');
		$this->var->add_def_cols('tipo_mem','numeric');
		$this->var->add_def_cols('id_memoria_calculo','int4');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarMemoriaGasto
	 * Propósito:				Contar los registros de tpr_mem_inversion_gasto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:12
	 */
	function ContarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_inversion_gasto_sel';
		$this->codigo_procedimiento = "'PR_MEMGAS_COUNT'";

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
	 * Nombre de la función:	InsertarMemoriaGasto
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_mem_inversion_gasto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:12
	 */
	function InsertarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_inversion_gasto_iud';
		$this->codigo_procedimiento = "'PR_MEMGAS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($periodo_pres);
		$this->var->add_param($tipo_mem);
		$this->var->add_param($id_memoria_calculo);
		$this->var->add_param($id_moneda);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarMemoriaGasto
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_mem_inversion_gasto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:12
	 */
	function ModificarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_inversion_gasto_iud';
		$this->codigo_procedimiento = "'PR_MEMGAS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_mem_inversion_gasto);
		$this->var->add_param($cantidad);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($periodo_pres);
		$this->var->add_param($tipo_mem);
		$this->var->add_param($id_memoria_calculo);
		$this->var->add_param($id_moneda);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarMemoriaGasto
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_mem_inversion_gasto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:12
	 */
	function EliminarMemoriaGasto($id_mem_inversion_gasto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_inversion_gasto_iud';
		$this->codigo_procedimiento = "'PR_MEMGAS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_mem_inversion_gasto);
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
	 * Nombre de la función:	ValidarMemoriaGasto
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_mem_inversion_gasto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:12
	 */
	function ValidarMemoriaGasto($operacion_sql,$id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda)
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
				//Validar id_mem_inversion_gasto - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_mem_inversion_gasto");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_mem_inversion_gasto", $id_mem_inversion_gasto))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar cantidad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "cantidad", $cantidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_unitario - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_unitario");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_unitario", $costo_unitario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar periodo_pres - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("periodo_pres");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "periodo_pres", $periodo_pres))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_mem - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_mem");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_mem", $tipo_mem))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_memoria_calculo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_memoria_calculo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_memoria_calculo", $id_memoria_calculo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_mem_inversion_gasto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_mem_inversion_gasto");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_mem_inversion_gasto", $id_mem_inversion_gasto))
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