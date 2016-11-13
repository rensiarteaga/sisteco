<?php
/**
 * Nombre de la clase:	cls_DBParametro.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_nivel_oec
 * Autor:				Fernando Prudencio
 * Fecha creación:		2008-07-02 21:46:09
 */

 
class cls_DBParametro
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
	 * Nombre de la función:	ListarParametro
	 * Propósito:				Desplegar los registros de tts_parametro
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 * Autor Modificacion:		Ana Maria Villegas
	 * Fecha de modificación:	2014/12/05
	 * Proposito:               Se ha adicionado las fechas fecha_fin_viaje y fecha_viaje_al esto para el control de fechas de viaje en viaticos 
	 */
	function ListarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_parametro_sel';
		$this->codigo_procedimiento = "'TS_PARAME_SEL'";

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
		
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('cantidad_nivel','numeric');
		$this->var->add_def_cols('estado_gestion','numeric');
		$this->var->add_def_cols('gestion_tesoro','numeric');
		$this->var->add_def_cols('max_sol_pendientes_viatico','int4');
		$this->var->add_def_cols('max_sol_pendientes_fa','int4');
		$this->var->add_def_cols('descuento_viaticos','varchar');
		$this->var->add_def_cols('dias_aplica_descuento','int4');
		$this->var->add_def_cols('porcentaje_descuento','numeric');
		$this->var->add_def_cols('max_sol_pendientes_efe','int4');
		$this->var->add_def_cols('sw_detiene','varchar');
		$this->var->add_def_cols('fecha_del','date');
		$this->var->add_def_cols('fecha_al','date');
		$this->var->add_def_cols('fecha_fin_viaje','date');
		$this->var->add_def_cols('fecha_fin_viaje_al','date');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarParametro
	 * Propósito:				Contar los registros de tts_nivel_oec
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 */
	function ContarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_parametro_sel';
		$this->codigo_procedimiento = "'TS_PARAME_COUNT'";

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
	 * Nombre de la función:	InsertarParametro
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_parametro
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 */
	function InsertarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro,$max_sol_pendientes_viatico,$max_sol_pendientes_fa,$sw_descuento_viaticos,$dias_aplica_descuento,$porcentaje_descuento,$max_sol_pendientes_efe,$sw_detiene,$fecha_del,$fecha_al,$fecha_fin_viaje,$fecha_fin_viaje_al)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_parametro_iud';
		$this->codigo_procedimiento = "'TS_PARAME_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_gestion);
		$this->var->add_param($cantidad_nivel);
		$this->var->add_param($estado_gestion);
		$this->var->add_param($gestion_tesoro);
		
		$this->var->add_param($max_sol_pendientes_viatico);
		$this->var->add_param($max_sol_pendientes_fa);
		$this->var->add_param("'$sw_descuento_viaticos'");
		$this->var->add_param($dias_aplica_descuento);
		$this->var->add_param($porcentaje_descuento);
		$this->var->add_param($max_sol_pendientes_efe);
		
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
	 * Nombre de la función:	ModificarParametro
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_parametro
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 */
	function ModificarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro,$max_sol_pendientes_viatico,$max_sol_pendientes_fa,$sw_descuento_viaticos,$dias_aplica_descuento,$porcentaje_descuento,$max_sol_pendientes_efe,$sw_detiene,$fecha_del,$fecha_al,$fecha_fin_viaje,$fecha_fin_viaje_al)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_parametro_iud';
		$this->codigo_procedimiento = "'TS_PARAME_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);		
		$this->var->add_param($id_parametro);
		$this->var->add_param($id_gestion);
		$this->var->add_param($cantidad_nivel);
		$this->var->add_param($estado_gestion);
		$this->var->add_param($gestion_tesoro);
		$this->var->add_param($max_sol_pendientes_viatico);
		$this->var->add_param($max_sol_pendientes_fa);
		$this->var->add_param("'$sw_descuento_viaticos'");
		$this->var->add_param($dias_aplica_descuento);
		$this->var->add_param($porcentaje_descuento);
		$this->var->add_param($max_sol_pendientes_efe);
		
		$this->var->add_param("'$sw_detiene'");
		$this->var->add_param("'$fecha_del'");
		$this->var->add_param("'$fecha_al'");
		$this->var->add_param("'$fecha_fin_viaje'");
		$this->var->add_param("'$fecha_fin_viaje_al'");
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarParametro
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_parametro
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-10-10 21:46:09
	 */
	function EliminarParametro($id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_parametro_iud';
		$this->codigo_procedimiento = "'TS_PARAME_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro);
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
	 * Nombre de la función:	ValidarParametro
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_nivel_oec
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2008-07-02 21:46:09
	 */
	function ValidarParametro($operacion_sql,$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro)
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
				//Validar id_parametro - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_parametro");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_gestion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_gestion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar cantidad_nivel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad_nivel");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad_nivel", $cantidad_nivel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_gestion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_gestion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "estado_gestion", $estado_gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}
           //Validar gestion_tesoro - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("gestion_tesoro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "gestion_tesoro", $gestion_tesoro))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_parametro - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_parametro");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
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