<?php
/**
 * Nombre de la clase:	cls_DBEstadoAutorizado.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_estado_autorizado
 * Autor:				(autogenerado)
 * Fecha creación:		2008-09-03 14:44:35
 */

 
class cls_DBEstadoAutorizado
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
	 * Nombre de la función:	ListarEstadoAutorizado
	 * Propósito:				Desplegar los registros de tpr_estado_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-03 14:44:35
	 */
	function ListarEstadoAutorizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_estado_autorizado_sel';
		$this->codigo_procedimiento = "'PR_ESTAUT_SEL'";

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
		$this->var->add_def_cols('id_estado_autorizado','int4');
		$this->var->add_def_cols('id_usuario_autorizado','int4');
		$this->var->add_def_cols('id_concepto_colectivo','int4');
		$this->var->add_def_cols('estado_autorizado','numeric');
		$this->var->add_def_cols('desc_estado_autorizado','varchar');
		
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEstadoAutorizado
	 * Propósito:				Contar los registros de tpr_estado_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-03 14:44:35
	 */
	function ContarEstadoAutorizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_estado_autorizado_sel';
		$this->codigo_procedimiento = "'PR_ESTAUT_COUNT'";

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
	 * Nombre de la función:	InsertarEstadoAutorizado
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_estado_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-03 14:44:35
	 */
	function InsertarEstadoAutorizado($id_estado_autorizado,$id_usuario_autorizado,$id_concepto_colectivo,$estado_autorizado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_estado_autorizado_iud';
		$this->codigo_procedimiento = "'PR_ESTAUT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_usuario_autorizado);
		$this->var->add_param($id_concepto_colectivo);
		$this->var->add_param($estado_autorizado);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEstadoAutorizado
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_estado_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-03 14:44:35
	 */
	function ModificarEstadoAutorizado($id_estado_autorizado,$id_usuario_autorizado,$id_concepto_colectivo,$estado_autorizado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_estado_autorizado_iud';
		$this->codigo_procedimiento = "'PR_ESTAUT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_estado_autorizado);
		$this->var->add_param($id_usuario_autorizado);
		$this->var->add_param($id_concepto_colectivo);
		$this->var->add_param($estado_autorizado);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEstadoAutorizado
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_estado_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-03 14:44:35
	 */
	function EliminarEstadoAutorizado($id_estado_autorizado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_estado_autorizado_iud';
		$this->codigo_procedimiento = "'PR_ESTAUT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_estado_autorizado);
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
	 * Nombre de la función:	ValidarEstadoAutorizado
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_estado_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-03 14:44:35
	 */
	function ValidarEstadoAutorizado($operacion_sql,$id_estado_autorizado,$id_usuario_autorizado,$id_concepto_colectivo,$estado_autorizado)
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
				//Validar id_estado_autorizado - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_estado_autorizado");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estado_autorizado", $id_estado_autorizado))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_usuario_autorizado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario_autorizado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario_autorizado", $id_usuario_autorizado))
			{
				$this->salida = $valid->salida;
				return false;
			}

		/*	//Validar id_concepto_colectivo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_concepto_colectivo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_concepto_colectivo", $id_concepto_colectivo))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar estado_autorizado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_autorizado");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_autorizado", $estado_autorizado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_estado_autorizado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_estado_autorizado");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estado_autorizado", $id_estado_autorizado))
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