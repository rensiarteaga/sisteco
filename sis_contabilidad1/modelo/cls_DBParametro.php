<?php
/**
 * Nombre de la clase:	cls_DBParametro.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_parametro
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-15 17:39:51
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
	 * Propósito:				Desplegar los registros de tct_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function ListarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_parametro_sel';
		$this->codigo_procedimiento = "'CT_PARGRL_SEL'";

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
		$this->var->add_def_cols('desc_gestion','numeric');
		$this->var->add_def_cols('cantidad_nivel','numeric');
		$this->var->add_def_cols('estado_gestion','numeric');
		$this->var->add_def_cols('gestion_conta','numeric');
		$this->var->add_def_cols('porcen_iva','numeric');
		$this->var->add_def_cols('porcen_it','numeric');
		$this->var->add_def_cols('porcen_servicio','numeric');
		$this->var->add_def_cols('porcen_bien','numeric');
		$this->var->add_def_cols('porcen_remesa','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		$this->var->add_def_cols('desc_epe','text');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('nombre_unidad','varchar');
        $this->var->add_def_cols('desc_estado','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query ; exit();
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarParametro
	 * Propósito:				Contar los registros de tct_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function ContarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_parametro_sel';
		$this->codigo_procedimiento = "'CT_PARGRL_COUNT'";

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
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function InsertarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa,$id_moneda,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_parametro_iud';
		$this->codigo_procedimiento = "'CT_PARGRL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_gestion);
		$this->var->add_param($cantidad_nivel);
		$this->var->add_param($estado_gestion);
		$this->var->add_param($gestion_conta);
		$this->var->add_param($porcen_iva);
		$this->var->add_param($porcen_it);
		$this->var->add_param($porcen_servicio);
		$this->var->add_param($porcen_bien);
		$this->var->add_param($porcen_remesa);
        $this->var->add_param($id_moneda);
        $this->var->add_param($id_fina_regi_prog_proy_acti);
        $this->var->add_param($id_unidad_organizacional);
       
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
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function ModificarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa,$id_moneda,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_parametro_iud';
		$this->codigo_procedimiento = "'CT_PARGRL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro);
		$this->var->add_param($id_gestion);
		$this->var->add_param($cantidad_nivel);
		$this->var->add_param($estado_gestion);
		$this->var->add_param($gestion_conta);
		$this->var->add_param($porcen_iva);
		$this->var->add_param($porcen_it);
		$this->var->add_param($porcen_servicio);
		$this->var->add_param($porcen_bien);
		$this->var->add_param($porcen_remesa);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_fina_regi_prog_proy_acti);
		$this->var->add_param($id_unidad_organizacional);
		

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
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function EliminarParametro($id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_parametro_iud';
		$this->codigo_procedimiento = "'CT_PARGRL_DEL'";

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
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function MigrarParametro($id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_parametro_iud';
		$this->codigo_procedimiento = "'CT_MIGRAR_UPD'";

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
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ActualParametro($id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_parametro_iud';
		$this->codigo_procedimiento = "'CT_MIGMODI_UPD'";

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
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function ValidarParametro($operacion_sql,$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional)
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
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}	
		
			//Validar id_gestion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_fina_regi_prog_proy_acti");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fina_regi_prog_proy_acti", $id_fina_regi_prog_proy_acti))
			{
				$this->salida = $valid->salida;
				return false;
			}	//Validar id_gestion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cantidad_nivel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad_nivel");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad_nivel", $cantidad_nivel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_gestion - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_gestion");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_gestion", $estado_gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar gestion_conta - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("gestion_conta");
			$tipo_dato->set_MaxLength(262144);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "gestion_conta", $gestion_conta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcen_iva - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcen_iva");
			$tipo_dato->set_MaxLength(524290);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcen_iva", $porcen_iva))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcen_it - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcen_it");
			$tipo_dato->set_MaxLength(524290);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcen_it", $porcen_it))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcen_servicio - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcen_servicio");
			$tipo_dato->set_MaxLength(524290);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcen_servicio", $porcen_servicio))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcen_bien - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcen_bien");
			$tipo_dato->set_MaxLength(524290);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcen_bien", $porcen_bien))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcen_remesa - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcen_remesa");
			$tipo_dato->set_MaxLength(524290);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcen_remesa", $porcen_remesa))
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