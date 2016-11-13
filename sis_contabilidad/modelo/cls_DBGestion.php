<?php
/**
 * Nombre de la clase:	cls_DBGestion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_gestion
 * Autor:				(autogenerado)
 * Fecha creación:		2008-12-01 14:49:31
 */

 
class cls_DBGestion
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
	 * Nombre de la función:	ListarGestion
	 * Propósito:				Desplegar los registros de tct_gestion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:31
	 */
	function ListarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestion_sel';
		$this->codigo_procedimiento = "'CT_SCIGES_SEL'";

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
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('estado_ges_gral','varchar');
		$this->var->add_def_cols('id_empresa','int4');
		$this->var->add_def_cols('desc_empresa','varchar');
		$this->var->add_def_cols('id_moneda_base','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('estado_vigente','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarGestion
	 * Propósito:				Contar los registros de tct_gestion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:31
	 */
	function ContarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestion_sel';
		$this->codigo_procedimiento = "'CT_SCIGES_COUNT'";

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
	 * Nombre de la función:	InsertarGestion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_gestion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:31
	 */
	function InsertarGestion($id_gestion,$gestion,$estado_ges_gral,$id_empresa,$id_moneda_base,$estado_vigente)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestion_iud';
		$this->codigo_procedimiento = "'CT_SCIGES_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($gestion);
		$this->var->add_param("'$estado_ges_gral'");
		$this->var->add_param($id_empresa);
		$this->var->add_param($id_moneda_base);
		$this->var->add_param("'$estado_vigente'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarGestion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_gestion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:31
	 */
	function ModificarGestion($id_gestion,$gestion,$estado_ges_gral,$id_empresa,$id_moneda_base,$estado_vigente)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestion_iud';
		$this->codigo_procedimiento = "'CT_SCIGES_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_gestion);
		$this->var->add_param($gestion);
		$this->var->add_param("'$estado_ges_gral'");
		$this->var->add_param($id_empresa);
		$this->var->add_param($id_moneda_base);
		$this->var->add_param("'$estado_vigente'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarGestion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_gestion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:31
	 */
	function EliminarGestion($id_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestion_iud';
		$this->codigo_procedimiento = "'CT_SCIGES_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_gestion);
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
	 * Nombre de la función:	ValidarGestion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_gestion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-01 14:49:31
	 */
	function ValidarGestion($operacion_sql,$id_gestion,$gestion,$estado_ges_gral,$id_empresa,$id_moneda_base,$estado_vigente)
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
				//Validar id_gestion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_gestion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar gestion - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("gestion");
			$tipo_dato->set_MaxLength(262144);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "gestion", $gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empresa - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empresa");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empresa", $id_empresa))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda_base - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda_base");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda_base", $id_moneda_base))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_gestion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_gestion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
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