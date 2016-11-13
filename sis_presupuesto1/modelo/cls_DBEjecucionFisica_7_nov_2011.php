<?php
/**
 * Nombre de la clase:	cls_DBEjecucionFisica.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_ejecucion_fisica
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-04 08:54:27
 */

 
class cls_DBEjecucionFisica
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
	 * Nombre de la función:	ListarEjecucionFisica
	 * Propósito:				Desplegar los registros de tpr_ejecucion_fisica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	function ListarEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_ejecucion_fisica_sel';
		$this->codigo_procedimiento = "'PR_EJEC_FISICA_SEL'";

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
		$this->var->add_def_cols('id_ejecucion_fisica','int4');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('periodo_pres','numeric');
		$this->var->add_def_cols('porcentaje_ejecucion','numeric');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_usr_reg','integer');
		$this->var->add_def_cols('desc_usr_reg','text');
		$this->var->add_def_cols('fecha_reg','text');
		

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
	 * Nombre de la función:	ContarEjecucionFisica
	 * Propósito:				Contar los registros de tpr_ejecucion_fisica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	function ContarEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_ejecucion_fisica_sel';
		$this->codigo_procedimiento = "'PR_EJEC_FISICA_COUNT'";

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
	 * Nombre de la función:	InsertarEjecucionFisica
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_ejecucion_fisica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	function InsertarEjecucionFisica($id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_ejecucion_fisica_iud';
		$this->codigo_procedimiento = "'PR_EJEC_FISICA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_parametro);
		$this->var->add_param($id_proyecto);
		$this->var->add_param($periodo_pres);
		$this->var->add_param($porcentaje_ejecucion);
		$this->var->add_param("'$estado'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEjecucionFisica
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_ejecucion_fisica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	function ModificarEjecucionFisica($id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_ejecucion_fisica_iud';
		$this->codigo_procedimiento = "'PR_EJEC_FISICA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ejecucion_fisica);
		$this->var->add_param($id_parametro);
		$this->var->add_param($id_proyecto);
		$this->var->add_param($periodo_pres);
		$this->var->add_param($porcentaje_ejecucion);
		$this->var->add_param("'$estado'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEjecucionFisica
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_ejecucion_fisica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	function EliminarEjecucionFisica($id_ejecucion_fisica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_ejecucion_fisica_iud';
		$this->codigo_procedimiento = "'PR_EJEC_FISICA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ejecucion_fisica);
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
	
	function CambiarEstadoEjecucionFisica($id_ejecucion_fisica,$accion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_ejecucion_fisica_iud';
		$this->codigo_procedimiento = "'PR_EJEC_FISICA_CERRAR'";
		
		/*if($accion=='enviar_autorizar'){
			$this->codigo_procedimiento = "'PR_MODIFI_ENVIAR_AUTORIZAR'";
		}
		elseif ($accion=='aprobar_modificacion'){
			$this->codigo_procedimiento = "'PR_MODIFI_APROBAR'";
		}
		elseif ($accion=='rechazar_modificacion'){
			$this->codigo_procedimiento = "'PR_MODIFI_RECHAZAR'";
		}
		elseif ($accion=='concluir_modificacion'){
			$this->codigo_procedimiento = "'PR_MODIFI_CONCLUIR'";
		}*/

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param($id_ejecucion_fisica);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$accion'");

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarEjecucionFisica
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_ejecucion_fisica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	function ValidarEjecucionFisica($operacion_sql,$id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado)
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
				//Validar id_ejecucon_fisica - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_ejecucion_fisica");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ejecucion_fisica", $id_ejecucion_fisica))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_categoria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ejecucion_fisica");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ejecucion_fisica", $id_ejecucion_fisica))
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