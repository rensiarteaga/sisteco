<?php
/**
 * Nombre de la clase:	cls_DBTipoUnidadConsReemp.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_tipo_unidad_cons_reemp
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-07 15:46:32
 */

class cls_DBTipoUnidadConsReemp
{	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	function __construct()
	{	$this->decodificar=$decodificar;
	}
	/**
	 * Nombre de la función:	ListarTipoUnidadConsReemp
	 * Propósito:				Desplegar los registros de tal_tipo_unidad_cons_reemp
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:32
	 */
	function ListarTipoUnidadConsReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_cons_reemp_sel';
		$this->codigo_procedimiento = "'AL_TUCREEM_SEL'";
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
		$this->var->add_def_cols('id_tipo_unidad_cons_reemp','int4');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('desc_tipo_unidad_constructiva','varchar');
		$this->var->add_def_cols('desc_nombre','varchar');
		$this->var->add_def_cols('id_composicion_tuc','int4');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}	
	/**
	 * Nombre de la función:	ContarTipoUnidadConsReemp
	 * Propósito:				Contar los registros de tal_tipo_unidad_cons_reemp
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:32
	 */
	function ContarTipoUnidadConsReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_cons_reemp_sel';
		$this->codigo_procedimiento = "'AL_TUCREEM_COUNT'";
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
		{	$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}	
	
	
	function ListarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_cons_reemplazo_sel';
		$this->codigo_procedimiento = "'AL_TUCREEMPLAZO_SEL'";
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
		$this->var->add_def_cols('id_tipo_unidad_cons_reemp','int4');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('desc_tipo_unidad_constructiva','varchar');
		$this->var->add_def_cols('desc_nombre','varchar');
		$this->var->add_def_cols('id_composicion_tuc','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion_tuc','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('estado','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
			return $res;
	}	
	
	function ContarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_cons_reemplazo_sel';
		$this->codigo_procedimiento = "'AL_TUCREEMPLAZO_COUNT'";
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
		{	$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}	
	
	
	function ListarTUCReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_cons_reemplazo_sel';
		$this->codigo_procedimiento = "'AL_TUREHI_SEL'";
		$func = new cls_funciones();//Instancia de las funciones generales
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		
		//$criterio_filtro= "TUCREEM.id_composicion_tuc= 306";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		//Carga la definición de columnas con sus tipos de datos
	
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion_tuc','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('estado','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}	
	
	
	function ContarTUCReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_cons_reemplazo_sel';
		$this->codigo_procedimiento = "'AL_TUREHI_COUNT'";
		$func = new cls_funciones();//Instancia de las funciones generales
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		//$criterio_filtro= "TUCREEM.id_composicion_tuc= 306";
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
		{	$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}	
	
	/**
	 * Nombre de la función:	InsertarTipoUnidadConsReemp
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_cons_reemp
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:32
	 */
	function InsertarTipoUnidadConsReemp($id_tipo_unidad_cons_reemp,$descripcion,$id_tipo_unidad_constructiva,$id_composicion_tuc)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_cons_reemp_iud';
		$this->codigo_procedimiento = "'AL_TUCREEM_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($id_tipo_unidad_constructiva);
		$this->var->add_param($id_composicion_tuc);
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}	
	/**
	 * Nombre de la función:	ModificarTipoUnidadConsReemp
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_tipo_unidad_cons_reemp
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:32
	 */
	function ModificarTipoUnidadConsReemp($id_tipo_unidad_cons_reemp,$descripcion,$id_tipo_unidad_constructiva,$id_composicion_tuc)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_cons_reemp_iud';
		$this->codigo_procedimiento = "'AL_TUCREEM_UPD'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_unidad_cons_reemp);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($id_tipo_unidad_constructiva);
		$this->var->add_param($id_composicion_tuc);
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	EliminarTipoUnidadConsReemp
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_tipo_unidad_cons_reemp
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:32
	 */
	function EliminarTipoUnidadConsReemp($id_tipo_unidad_cons_reemp)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_cons_reemp_iud';
		$this->codigo_procedimiento = "'AL_TUCREEM_DEL'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_unidad_cons_reemp);
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
	 * Nombre de la función:	ValidarTipoUnidadConsReemp
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_tipo_unidad_cons_reemp
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:32
	 */
	function ValidarTipoUnidadConsReemp($operacion_sql,$id_tipo_unidad_cons_reemp,$descripcion,$id_tipo_unidad_constructiva,$id_composicion_tuc)
	{	$this->salida = "";
		$valid = new cls_validacion_serv();
		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{	if($operacion_sql == 'update')
			{	//Validar id_tipo_unidad_cons_reemp - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_unidad_cons_reemp");
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_unidad_cons_reemp", $id_tipo_unidad_cons_reemp))
				{	$this->salida = $valid->salida;
					return false;
				}
			}
			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validar id_tipo_unidad_constructiva - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_unidad_constructiva");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_unidad_constructiva", $id_tipo_unidad_constructiva))
			{  $this->salida = $valid->salida;
				return false;
			}
			//Validar id_composicion_tuc - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_composicion_tuc");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_composicion_tuc", $id_composicion_tuc))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{	//Validar id_tipo_unidad_cons_reemp - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_unidad_cons_reemp");
    		if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_unidad_cons_reemp", $id_tipo_unidad_cons_reemp))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;	
		}
		else
		{ return false;
		}
	}
}?>