<?php
/**
 * Nombre de la clase:	cls_DBUsuarioAutorizado.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_usuario_autorizado
 * Autor:				(autogenerado)
 * Fecha creación:		2008-08-18 17:10:52
 */

 
class cls_DBUsuarioAutorizado
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
	 * Nombre de la función:	ListarAutorizacionPresupuesto
	 * Propósito:				Desplegar los registros de tpr_usuario_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-18 17:10:52
	 */
	function ListarAutorizacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_usuario_autorizado_sel';
		$this->codigo_procedimiento = "'PR_USUAUT_SEL'";

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
		$this->var->add_def_cols('id_usuario_autorizado','integer');
		$this->var->add_def_cols('id_usuario','integer');
 		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('sw_responsable','numeric');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('desc_usuario_reg','text');
		$this->var->add_def_cols('fecha_reg','timestamp');	
	 	$this->var->add_def_cols('fecha_ultima_mod','timestamp');	

 
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarAutorizacionPresupuesto
	 * Propósito:				Contar los registros de tpr_usuario_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-18 17:10:52
	 */
	function ContarAutorizacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_usuario_autorizado_sel';
		$this->codigo_procedimiento = "'PR_USUAUT_COUNT'";

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
	 * Nombre de la función:	InsertarAutorizacionPresupuesto
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_usuario_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-18 17:10:52
	 */
	function InsertarAutorizacionPresupuesto($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,$sw_responsable,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_usuario_autorizado_iud';
		$this->codigo_procedimiento = "'PR_USUAUT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_usuario);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($sw_responsable);
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
	 * Nombre de la función:	ModificarAutorizacionPresupuesto
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_usuario_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-18 17:10:52
	 */
	function ModificarAutorizacionPresupuesto($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,$sw_responsable,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_usuario_autorizado_iud';
		$this->codigo_procedimiento = "'PR_USUAUT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_usuario_autorizado);
		$this->var->add_param($id_usuario);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($sw_responsable);
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
	 * Nombre de la función:	EliminarAutorizacionPresupuesto
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_usuario_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-18 17:10:52
	 */
	function EliminarAutorizacionPresupuesto($id_usuario_autorizado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_usuario_autorizado_iud';
		$this->codigo_procedimiento = "'PR_USUAUT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_usuario_autorizado);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL"); //estado

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarUsuarioAutorizadoPresup
	 * Propósito:				Desplegar los registros de tpr_usuario_autorizado
	 * Autor:				    RCM
	 * Fecha de creación:		23/10/2009
	 */
	function ListarUsuarioAutorizadoPresup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_usuario_autorizado_sel';
		$this->codigo_procedimiento = "'PR_AUTORI_SEL'";

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
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('nombre_completo','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*if ($_SESSION['ss_id_usuario']==131){
		 echo $this->query;
		exit;
		}*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarUsuarioAutorizadoPresup
	 * Propósito:				Contar los registros de tpr_usuario_autorizado
	 * Autor:				    RCM
	 * Fecha de creación:		23/10/2009
	 */
	function ContarUsuarioAutorizadoPresup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_usuario_autorizado_sel';
		$this->codigo_procedimiento = "'PR_AUTORI_COUNT'";

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
	 * Nombre de la función:	ValidarAutorizacionPresupuesto
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_usuario_autorizado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-18 17:10:52
	 */
	function ValidarAutorizacionPresupuesto($operacion_sql,$id_usuario_autorizado,$id_usuario,$id_unidad_organizacional)
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
				//Validar id_usuario_autorizado - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_usuario_autorizado");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario_autorizado", $id_usuario_autorizado))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_usuario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario", $id_usuario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_organizacional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
			{
				$this->salida = $valid->salida;
				return false;
			}

		 
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_usuario_autorizado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario_autorizado");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario_autorizado", $id_usuario_autorizado))
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