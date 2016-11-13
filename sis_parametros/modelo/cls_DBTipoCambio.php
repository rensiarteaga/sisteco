<?php
/**
 * Nombre de la clase:	cls_DBTipoCambio.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_tipo_cambio
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-06 20:48:42
 */

class cls_DBTipoCambio
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
	 * Nombre de la función:	ListarTipoCambio
	 * Propósito:				Desplegar los registros de tpm_tipo_cambio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:42
	 */
	function ListarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio_sel';
		$this->codigo_procedimiento = "'PM_TIPOCA_SEL'";

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
		$this->var->add_def_cols('id_tipo_cambio','int4');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('hora','time');
		$this->var->add_def_cols('oficial','numeric');
		$this->var->add_def_cols('compra','numeric');
		$this->var->add_def_cols('venta','numeric');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('variacion_tc','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}
	function ListarTipoCambioOCV($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio_sel';
		$this->codigo_procedimiento = "'PM_TIPCAB_OCV_SEL'";

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
		$this->var->add_def_cols('tc_origen','varchar');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('tipo_cambio','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
 
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoCambio
	 * Propósito:				Contar los registros de tpm_tipo_cambio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:42
	 */
	function ContarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio_sel';
		$this->codigo_procedimiento = "'PM_TIPOCA_COUNT'";

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
	function ContarTipoCambioOCV($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio_sel';
		$this->codigo_procedimiento = "'PM_TIPCAB_OCV_COUNT'";

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
	 * Nombre de la función:	InsertarTipoCambio
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_tipo_cambio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:42
	 */
	function InsertarTipoCambio($id_tipo_cambio,$fecha,$hora,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio_iud';
		$this->codigo_procedimiento = "'PM_TIPOCA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha'");
		$this->var->add_param("'$hora'");
		$this->var->add_param($oficial);
		$this->var->add_param($compra);
		$this->var->add_param($venta);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$estado'");
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
	 * Nombre de la función:	ModificarTipoCambio
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_tipo_cambio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:42
	 */
	function ModificarTipoCambio($id_tipo_cambio,$fecha,$hora,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio_iud';
		$this->codigo_procedimiento = "'PM_TIPOCA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_cambio);
		$this->var->add_param("'$fecha'");
		$this->var->add_param("'$hora'");
		$this->var->add_param($oficial);
		$this->var->add_param($compra);
		$this->var->add_param($venta);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$estado'");
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
	 * Nombre de la función:	EliminarTipoCambio
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_tipo_cambio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:42
	 */
	function EliminarTipoCambio($id_tipo_cambio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_tipo_cambio_iud';
		$this->codigo_procedimiento = "'PM_TIPOCA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_cambio);
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
	function ConvertirMonto($fecha, $monto, $id_moneda1, $id_moneda2, $tipo)
	{
		/*$this->salida = "";
		$this->nombre_funcion = 'f_pm_conversion_monedas';
		$this->codigo_procedimiento = "'PM_TIPOCA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$fecha'");
		$this->var->add_param($monto);
		$this->var->add_param($id_moneda1);
		$this->var->add_param($id_moneda2);
		$this->var->add_param("'$tipo'");*/

		$var = new cls_middle("f_pm_conversion_monedas"," " );
	    $var->add_param("'$fecha'");
		$var->add_param($monto);
		$var->add_param($id_moneda1);
		$var->add_param($id_moneda2);
		$var->add_param("'$tipo'");
		
	    $res=$var->exec_function();
	    
	    $this->salida = $var->salida;
	   	
		return $res;
	}
	
	function ObtenerTipoCambio($fecha, $id_moneda1, $id_moneda2, $tipo)
	{
		/*$this->salida = "";
		$this->nombre_funcion = 'f_pm_conversion_monedas';
		$this->codigo_procedimiento = "'PM_TIPOCA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$fecha'");
		$this->var->add_param($monto);
		$this->var->add_param($id_moneda1);
		$this->var->add_param($id_moneda2);
		$this->var->add_param("'$tipo'");*/

		$var = new cls_middle("f_pm_get_tipo_cambio"," " );
	    $var->add_param("'$fecha'");
		$var->add_param($id_moneda1);
		$var->add_param($id_moneda2);
		$var->add_param("'$tipo'");
		
	    $res=$var->exec_function();
	    
	    $this->salida = $var->salida;
	   	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarTipoCambio
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_tipo_cambio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 20:48:42
	 */
	function ValidarTipoCambio($operacion_sql,$id_tipo_cambio,$fecha,$hora,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
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
				//Validar id_tipo_cambio - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_cambio");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_cambio", $id_tipo_cambio))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar fecha - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha", $fecha))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora", $hora))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar oficial - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("oficial");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "oficial", $oficial))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar compra - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("compra");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "compra", $compra))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar venta - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("venta");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "venta", $venta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarTipoCambio";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_cambio - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_cambio");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_cambio", $id_tipo_cambio))
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