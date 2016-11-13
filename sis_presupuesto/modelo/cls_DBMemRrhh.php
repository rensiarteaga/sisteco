<?php
/**
 * Nombre de la clase:	cls_DBMemRrhh.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_mem_rrhh
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-10 08:45:15
 */

 
class cls_DBMemRrhh
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
	 * Nombre de la función:	ListarRrhhGasto
	 * Propósito:				Desplegar los registros de tpr_mem_rrhh
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-10 08:45:15
	 */
	function ListarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_rrhh_sel';
		$this->codigo_procedimiento = "'PR_MERHGA_SEL'";

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
		$this->var->add_def_cols('id_mem_rrhh','int4');
		$this->var->add_def_cols('periodo_pres','numeric');
		$this->var->add_def_cols('id_memoria_calculo','int4');
		$this->var->add_def_cols('desc_memoria_calculo','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('total_general','numeric');
		
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRrhhGasto
	 * Propósito:				Contar los registros de tpr_mem_rrhh
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-10 08:45:15
	 */
	function ContarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_rrhh_sel';
		$this->codigo_procedimiento = "'PR_MERHGA_COUNT'";

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
	 * Nombre de la función:	InsertarRrhhGasto
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_mem_rrhh
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-10 08:45:15
	 */
	function InsertarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_gasto,$tipo_insercion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_rrhh_iud';
		$this->codigo_procedimiento = "'PR_MERHGA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		//$this->var->add_param($id_mem_rrhh);
		$this->var->add_param($periodo_pres);
		$this->var->add_param($id_memoria_calculo);
		$this->var->add_param($id_moneda);
		$this->var->add_param($total_gasto);
		$this->var->add_param($tipo_insercion);	

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRrhhGasto
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_mem_rrhh
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-10 08:45:15
	 */
	function ModificarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_gasto,$tipo_insercion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_rrhh_iud';
		$this->codigo_procedimiento = "'PR_MERHGA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_mem_rrhh);
		$this->var->add_param($periodo_pres);
		$this->var->add_param($id_memoria_calculo);
		$this->var->add_param($id_moneda);
		$this->var->add_param($total_gasto);
		$this->var->add_param($tipo_insercion);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRrhhGasto
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_mem_rrhh
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-10 08:45:15
	 */
	function EliminarRrhhGasto($id_mem_rrhh)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_rrhh_iud';
		$this->codigo_procedimiento = "'PR_MERHGA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_mem_rrhh);
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
	 * Nombre de la función:	ValidarRrhhGasto
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_mem_rrhh
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-10 08:45:15
	 */
	function ValidarRrhhGasto($operacion_sql,$id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_gasto)
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
				//Validar id_mem_rrhh - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_mem_rrhh");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_mem_rrhh", $id_mem_rrhh))
				{
					$this->salida = $valid->salida;
					return false;
				}
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
			
			//Validar total_general - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("total_general");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "total_general", $total_general))
			{
				$this->salida = $valid->salida;
				return false;
			}
						
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_mem_rrhh - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_mem_rrhh");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_mem_rrhh", $id_mem_rrhh))
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