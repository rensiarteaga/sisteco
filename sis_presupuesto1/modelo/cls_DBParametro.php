<?php
/**
 * Nombre de la clase:	cls_DBParametro.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_parametro
 * Autor:				(autogenerado)
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
	 * Propósito:				Desplegar los registros de tpr_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-02 21:46:09
	 */
	function ListarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_parametro_sel';
		$this->codigo_procedimiento = "'PR_PARAMP_SEL'";

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
		$this->var->add_def_cols('gestion_pres','numeric');
		$this->var->add_def_cols('estado_gral','numeric');
		$this->var->add_def_cols('cod_institucional','varchar');
		$this->var->add_def_cols('porcentaje_sobregiro','numeric');
		$this->var->add_def_cols('niveles_recurso','numeric');
		$this->var->add_def_cols('niveles_gasto','numeric'); 
		$this->var->add_def_cols('cod_formulario_gasto','varchar');
		$this->var->add_def_cols('cod_formulario_recurso','varchar');
		$this->var->add_def_cols('desc_estado_gral','varchar');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('desc_gestion','numeric');
		$this->var->add_def_cols('mod_inversion','varchar');

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
	 * Nombre de la función:	ContarParametro
	 * Propósito:				Contar los registros de tpr_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-02 21:46:09
	 */
	function ContarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_parametro_sel';
		$this->codigo_procedimiento = "'PR_PARAMP_COUNT'";

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
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-02 21:46:09
	 */
	function InsertarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_parametro_iud';
		$this->codigo_procedimiento = "'PR_PARAMP_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($gestion_pres);
		$this->var->add_param($estado_gral);
		$this->var->add_param("'$cod_institucional'");
		$this->var->add_param($porcentaje_sobregiro);
		$this->var->add_param($niveles_recurso);
		$this->var->add_param("'$cod_formulario_gasto'");
		$this->var->add_param("'$cod_formulario_recurso'");
		$this->var->add_param($id_gestion);
		$this->var->add_param($niveles_gasto);
		$this->var->add_param("'$mod_inversion'");

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
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-02 21:46:09
	 */
	function ModificarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_parametro_iud';
		$this->codigo_procedimiento = "'PR_PARAMP_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro);
		$this->var->add_param($gestion_pres);
		$this->var->add_param($estado_gral);
		$this->var->add_param("'$cod_institucional'");
		$this->var->add_param($porcentaje_sobregiro);
		$this->var->add_param($niveles_recurso);		
		$this->var->add_param("'$cod_formulario_gasto'");
		$this->var->add_param("'$cod_formulario_recurso'");
		$this->var->add_param($id_gestion);
		$this->var->add_param($niveles_gasto);
		$this->var->add_param("'$mod_inversion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function AprobarParametro($id_parametro,$estado_gral)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_parametro_iud';
		$this->codigo_procedimiento = "'PR_APROBAR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro);
		$this->var->add_param("NULL");
		$this->var->add_param($estado_gral);
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
	
	function CerrarParametro($id_parametro,$estado_gral)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_parametro_iud';
		$this->codigo_procedimiento = "'PR_CERRAR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro);
		$this->var->add_param("NULL");
		$this->var->add_param($estado_gral);
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
	
	function MigrarParametro($id_parametro,$estado_gral)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_parametro_iud';
		$this->codigo_procedimiento = "'PR_MIGRAR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro);
		$this->var->add_param("NULL");
		$this->var->add_param($estado_gral);
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
	 * Nombre de la función:	EliminarParametro
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-02 21:46:09
	 */
	function EliminarParametro($id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_parametro_iud';
		$this->codigo_procedimiento = "'PR_PARAMP_DEL'";

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
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_parametro
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-02 21:46:09
	 */
	function ValidarParametro($operacion_sql,$id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion)
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

			//Validar gestion_pres - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("gestion_pres");
			$tipo_dato->set_MaxLength(262144);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "gestion_pres", $gestion_pres))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_gral - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_gral");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_gral", $estado_gral))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cod_institucional - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cod_institucional");
			$tipo_dato->set_MaxLength(4);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cod_institucional", $cod_institucional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcentaje_sobregiro - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcentaje_sobregiro");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcentaje_sobregiro", $porcentaje_sobregiro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar $niveles_recurso - tipo numeric,,
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("niveles_recurso");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "niveles_recurso", $niveles_recurso))
			{
				$this->salida = $valid->salida;
				return false;
			}	//Validar cantidad_niveles - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("niveles_gasto");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "niveles_gasto", $niveles_gasto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar cod_formulario_gasto - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cod_formulario_gasto");
			$tipo_dato->set_MaxLength(25);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cod_formulario_gasto", $cod_formulario_gasto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar cod_formulario_recurso - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cod_formulario_recurso");
			$tipo_dato->set_MaxLength(25);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cod_formulario_recurso", $cod_formulario_recurso))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_gestion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_gestion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
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