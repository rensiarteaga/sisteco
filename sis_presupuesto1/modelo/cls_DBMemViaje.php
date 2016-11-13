<?php
/**
 * Nombre de la clase:	cls_DBMemViaje.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_mem_viaje
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-07 17:57:09
 */

 
class cls_DBMemViaje
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
	 * Nombre de la función:	ListarViajeGasto
	 * Propósito:				Desplegar los registros de tpr_mem_viaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:09
	 */
	function ListarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_viaje_sel';
		$this->codigo_procedimiento = "'PR_MEVIGA_SEL'";

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
		$this->var->add_def_cols('id_mem_viaje','integer');
		$this->var->add_def_cols('id_destino','integer');
		$this->var->add_def_cols('nombre_lugar','varchar');
		$this->var->add_def_cols('ubicacion_lugar','text');
		$this->var->add_def_cols('desc_destino','text');
		$this->var->add_def_cols('id_cobertura','integer');
		$this->var->add_def_cols('desc_cobertura','numeric');
		$this->var->add_def_cols('nro_dias','integer');
		$this->var->add_def_cols('importe_viaticos','numeric');
		$this->var->add_def_cols('total_viaticos','numeric');
		$this->var->add_def_cols('importe_hotel','numeric');
		$this->var->add_def_cols('total_hotel','numeric');
		$this->var->add_def_cols('importe_otros','numeric');
		$this->var->add_def_cols('total_general','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('periodo_pres','numeric');
		$this->var->add_def_cols('id_memoria_calculo','integer');
		$this->var->add_def_cols('desc_memoria_calculo','varchar');
		$this->var->add_def_cols('id_mem_pasaje','integer');
		$this->var->add_def_cols('id_categoria','integer');
		$this->var->add_def_cols('desc_categoria','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarViajeGasto
	 * Propósito:				Contar los registros de tpr_mem_viaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:09
	 */
	function ContarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_viaje_sel';
		$this->codigo_procedimiento = "'PR_MEVIGA_COUNT'";

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
	 * Nombre de la función:	InsertarViajeGasto
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_mem_viaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:09
	 */
	function InsertarViajeGasto($id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_viaje_iud';
		$this->codigo_procedimiento = "'PR_MEVIGA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		 
		
		$this->var->add_param("NULL");
		$this->var->add_param($nro_dias);
		$this->var->add_param($importe_viaticos);
		$this->var->add_param($importe_hotel);
		$this->var->add_param($importe_otros);
		$this->var->add_param($periodo_pres);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_cobertura); 
		$this->var->add_param($id_memoria_calculo);	
		$this->var->add_param($total_viaticos);		
		$this->var->add_param($total_hotel);		
		$this->var->add_param($total_general);			
		$this->var->add_param($id_mem_pasaje);
	

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*	echo($this->query);
		exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarViajeGasto
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_mem_viaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:09
	 */
	function ModificarViajeGasto($id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_viaje_iud';
		$this->codigo_procedimiento = "'PR_MEVIGA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_mem_viaje);
		$this->var->add_param($nro_dias);
		$this->var->add_param($importe_viaticos);
		$this->var->add_param($importe_hotel);
		$this->var->add_param($importe_otros);
		$this->var->add_param($periodo_pres);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_cobertura); 
		$this->var->add_param($id_memoria_calculo);	
		$this->var->add_param($total_viaticos);		
		$this->var->add_param($total_hotel);		
		$this->var->add_param($total_general);			
		$this->var->add_param($id_mem_pasaje);
	

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarViajeGasto
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_mem_viaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:09
	 */
	function EliminarViajeGasto($id_mem_viaje)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_mem_viaje_iud';
		$this->codigo_procedimiento = "'PR_MEVIGA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_mem_viaje);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarViajeGasto
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_mem_viaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:09
	 */
	function ValidarViajeGasto($operacion_sql,$id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje)
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
				//Validar id_mem_viaje - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_mem_viaje");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_mem_viaje", $id_mem_viaje))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
 
			//Validar id_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_mem_pasaje");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_mem_pasaje", $id_mem_pasaje))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cobertura - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cobertura");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cobertura", $id_cobertura))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_dias - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_dias");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_dias", $nro_dias))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_viaticos - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_viaticos");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_viaticos", $importe_viaticos))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar total_viaticos - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("total_viaticos");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "total_viaticos", $total_viaticos))
			{
				$this->salida = $valid->salida;
				return false;
			}
 
			//Validar importe_hotel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_hotel");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_hotel", $importe_hotel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar total_hotel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("total_hotel");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "total_hotel", $total_hotel))
			{
				$this->salida = $valid->salida;
				return false;
			}

		

			//Validar importe_otros - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_otros");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_otros", $importe_otros))
			{
				$this->salida = $valid->salida;
				return false;
			}
 
			//Validar total_general - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("total_general");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "total_general", $total_general))
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
						
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_mem_viaje - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_mem_viaje");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_mem_viaje", $id_mem_viaje))
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