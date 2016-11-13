<?php
/**
 * Nombre de la clase:	cls_DBParametroKardex.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_parametro_kardex
 * Autor:				(autogenerado)
 * Fecha creación:		2010-08-13 09:27:55
 */

 
class cls_DBParametroKardex
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
	 * Nombre de la función:	ListarParametroKardex
	 * Propósito:				Desplegar los registros de tkp_parametro_kardex
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 09:27:55
	 */
	function ListarParametroKardex($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_kardex_sel';
		$this->codigo_procedimiento = "'KP_PARKAR_SEL'";

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
		$this->var->add_def_cols('id_parametro_kardex','int4');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('desc_gestion','numeric');

		$this->var->add_def_cols('salario_min_nacional','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('porcen_fijo_cooperativa','numeric');
		$this->var->add_def_cols('aporte_fijo_min_cooperativa','numeric');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('porcen_max_quincena','numeric');
		$this->var->add_def_cols('id_moneda_cooperativa','integer');
		$this->var->add_def_cols('desc_moneda_coop','varchar');
		$this->var->add_def_cols('horas_mes_laboral','integer');
		$this->var->add_def_cols('fecha_inicio','date');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarParametroKardex
	 * Propósito:				Contar los registros de tkp_parametro_kardex
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 09:27:55
	 */
	function ContarParametroKardex($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_kardex_sel';
		$this->codigo_procedimiento = "'KP_PARKAR_COUNT'";

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
	 * Nombre de la función:	InsertarParametroKardex
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_parametro_kardex
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 09:27:55
	 */
	function InsertarParametroKardex($id_parametro_kardex,$id_gestion,$salario_min_nacional,$id_moneda,$porcen_fijo_cooperativa,$aporte_fijo_min_cooperativa,$estado_reg,$fecha_reg,$porcen_max_quincena,$id_moneda_cooperativa,$horas_mes_laboral)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_kardex_iud';
		$this->codigo_procedimiento = "'KP_PARKAR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_gestion);
		$this->var->add_param($salario_min_nacional);
		$this->var->add_param($id_moneda);
		$this->var->add_param($porcen_fijo_cooperativa);
		$this->var->add_param($aporte_fijo_min_cooperativa);
	
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($porcen_max_quincena);
		$this->var->add_param($id_moneda_cooperativa);
		$this->var->add_param($horas_mes_laboral);
		$this->var->add_param("NULL");//fehca_inicio
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarParametroKardex
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_parametro_kardex
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 09:27:55
	 */
	function ModificarParametroKardex($id_parametro_kardex,$id_gestion,$salario_min_nacional,$id_moneda,$porcen_fijo_cooperativa,$aporte_fijo_min_cooperativa,$estado_reg,$fecha_reg,$porcen_max_quincena,$id_moneda_cooperativa,$horas_mes_laboral,$fecha_inicio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_kardex_iud';
		$this->codigo_procedimiento = "'KP_PARKAR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro_kardex);
		$this->var->add_param($id_gestion);
		$this->var->add_param($salario_min_nacional);
		$this->var->add_param($id_moneda);
		$this->var->add_param($porcen_fijo_cooperativa);
		$this->var->add_param($aporte_fijo_min_cooperativa);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($porcen_max_quincena);
		$this->var->add_param($id_moneda_cooperativa);
		$this->var->add_param($horas_mes_laboral);
		$this->var->add_param("'$fecha_inicio'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarParametroKardex
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_parametro_kardex
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 09:27:55
	 */
	function EliminarParametroKardex($id_parametro_kardex)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_kardex_iud';
		$this->codigo_procedimiento = "'KP_PARKAR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro_kardex);
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//$salario_min_nacional);
		$this->var->add_param("NULL");//$id_moneda);
		$this->var->add_param("NULL");//$porcen_fijo_cooperativa);
		$this->var->add_param("NULL");//$aporte_fijo_min_cooperativa);
		$this->var->add_param("NULL");//$estado_reg);
		$this->var->add_param("NULL");//$fecha_reg);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//$horas_mes_laboral
		$this->var->add_param("NULL");//$fecha_inicio
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarParametroKardex
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_parametro_kardex
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 09:27:55
	 */
	function ValidarParametroKardex($operacion_sql,$id_parametro_kardex,$id_gestion,$salario_min_nacional,$id_moneda,$porcen_fijo_cooperativa,$aporte_fijo_min_cooperativa,$estado_reg,$fecha_reg)
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
				//Validar id_parametro_kardex - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_parametro_kardex");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_kardex", $id_parametro_kardex))
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
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
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
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("salario_min_nacional");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "salario_min_nacional", $salario_min_nacional))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcen_fijo_cooperativa");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcen_fijo_cooperativa", $porcen_fijo_cooperativa))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("aporte_fijo_min_cooperativa");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "aporte_fijo_min_cooperativa", $aporte_fijo_min_cooperativa))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_parametro_kardex - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro_kardex");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_kardex", $id_parametro_kardex))
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