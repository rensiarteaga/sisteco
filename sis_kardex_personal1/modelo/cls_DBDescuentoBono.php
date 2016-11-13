<?php
/**
 * Nombre de la clase:	cls_DBDescuentoBono.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_descuento_bono
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		12-08-2010
 */

class cls_DBDescuentoBono
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
	 * Nombre de la función:	ListarDescuentoBono
	 * Propósito:				Desplegar los registros de tkp_descuento_bono
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function ListarDescuentoBono($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_descuento_bono_sel';
		$this->codigo_procedimiento = "'KP_EMPBONO_SEL'";

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
		$this->var->add_def_cols('id_descuento_bono','int4');
		$this->var->add_def_cols('id_tipo_descuento_bono','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_moneda','int4');
		
		$this->var->add_def_cols('monto_total','numeric');
		$this->var->add_def_cols('num_cuotas','int4');
		$this->var->add_def_cols('monto_faltante','numeric');
		$this->var->add_def_cols('valor_por_cuota','numeric');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('desc_tipo_descuento_bono','varchar');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('cuotas','varchar');
		$this->var->add_def_cols('fecha_fin','date');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	   /* echo $this->query;
	    exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDescuentoBono
	 * Propósito:				Contar los registros de tkp_descuento_bono
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function ContarDescuentoBono($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_descuento_bono_sel';
		$this->codigo_procedimiento = "'KP_EMPBONO_COUNT'";

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
	 * Nombre de la función:	InsertarDescuentoBono
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_descuento_bono
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function InsertarDescuentoBono($id_descuento_bono,$id_tipo_descuento_bono,$id_empleado,$id_moneda,$monto_total,
	$num_cuotas,$monto_faltante,$valor_por_cuota,$fecha_ini,$fecha_reg,$estado_reg,$cuotas,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_descuento_bono_iud';
		$this->codigo_procedimiento = "'KP_EMPBONO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_tipo_descuento_bono");
		$this->var->add_param("$id_empleado");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$monto_total");
		
		$this->var->add_param("$num_cuotas");
		$this->var->add_param("$monto_faltante");
		$this->var->add_param("$valor_por_cuota");
		$this->var->add_param("'$fecha_ini'");
		
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$cuotas'");
		$this->var->add_param("'$fecha_fin'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDescuentoBono
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_descuento_bono
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function ModificarDescuentoBono($id_descuento_bono,$id_tipo_descuento_bono,$id_empleado,$id_moneda,$monto_total,
	$num_cuotas,$monto_faltante,$valor_por_cuota,$fecha_ini,$fecha_reg,$estado_reg,$cuotas,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_descuento_bono_iud';
		$this->codigo_procedimiento = "'KP_EMPBONO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_descuento_bono);
		$this->var->add_param("$id_tipo_descuento_bono");
		$this->var->add_param("$id_empleado");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$monto_total");
		
		$this->var->add_param("$num_cuotas");
		$this->var->add_param("$monto_faltante");
		$this->var->add_param("$valor_por_cuota");
		$this->var->add_param("'$fecha_ini'");
		
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$cuotas'");
		
		$this->var->add_param("'$fecha_fin'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDescuentoBono
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_descuento_bono
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	function EliminarDescuentoBono($id_descuento_bono)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_descuento_bono_iud';
		$this->codigo_procedimiento = "'KP_EMPBONO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_descuento_bono);
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
		$this->var->add_param("NULL");//cuotas -- 24mar11
		
		$this->var->add_param("NULL");// fecha_fin
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ValidarDescuentoBono
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_descuento_bono
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		12-08-2010
	 */
	
	function ValidarDescuentoBono($operacion_sql,$id_descuento_bono,$id_tipo_descuento_bono,$id_empleado,$id_moneda,$monto_total,
	$num_cuotas,$monto_faltante,$valor_por_cuota,$fecha_ini,$fecha_reg,$estado_reg)
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
				//Validar id_empleado_frppa - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_descuento_bono");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_descuento_bono", $id_descuento_bono))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_descuento_bono");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_descuento_bono", $id_tipo_descuento_bono))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_AllowBlank("true");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_empleado_frppa - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_descuento_bono");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_descuento_bono", $id_descuento_bono))
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