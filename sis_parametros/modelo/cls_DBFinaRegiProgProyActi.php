<?php
/**
 * Nombre de la clase:	cls_DBFinaRegiProgProyActi.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_fina_regi_prog_proy_acti
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-07 10:19:37
 */

class cls_DBFinaRegiProgProyActi
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
	 * Nombre de la función:	ListarFinaRegiProgProyActi
	 * Propósito:				Desplegar los registros de tpm_fina_regi_prog_proy_acti
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 10:19:37
	 */
	function ListarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_fina_regi_prog_proy_acti_sel';
		$this->codigo_procedimiento = "'PM_FRPPA_SEL'";

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
    	$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		$this->var->add_def_cols('id_prog_proy_acti','integer');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('desc_financiador','varchar');
		$this->var->add_def_cols('desc_regional','varchar');
		$this->var->add_def_cols('desc_prog_proy_acti','text');
        $this->var->add_def_cols('desc_frppa','text');
        $this->var->add_def_cols('codigo_ep','text');
        $this->var->add_def_cols('nombre_programa','varchar');
        $this->var->add_def_cols('nombre_proyecto','varchar');
        $this->var->add_def_cols('nombre_actividad','varchar');
        
        $this->var->add_def_cols('descripcion_financiador','text');
		$this->var->add_def_cols('descripcion_regional','text');
		$this->var->add_def_cols('descripcion_programa','text');
        $this->var->add_def_cols('descripcion_proyecto','text');
        $this->var->add_def_cols('descripcion_actividad','text');
        
        $this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
        $this->var->add_def_cols('codigo_proyecto','varchar');
        $this->var->add_def_cols('codigo_actividad','varchar');

		$this->var->add_def_cols('id_programa','integer');
        $this->var->add_def_cols('id_proyecto','integer');
        $this->var->add_def_cols('id_actividad','integer');
        
        $this->var->add_def_cols('presup_relacionados','bigint');
				
	    
		
		

	/*	$this->var->add_def_cols('id_fina_regi_prog_proy_acti','int4');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('desc_financiador','varchar');
		$this->var->add_def_cols('desc_regional','varchar');
		$this->var->add_def_cols('desc_programa','varchar');
		$this->var->add_def_cols('desc_proyecto','varchar');
		$this->var->add_def_cols('desc_actividad','varchar');
		$this->var->add_def_cols('id_prog_proy_acti','int4');
		$this->var->add_def_cols('desc_programa_proyecto_actividad','int4');
		$this->var->add_def_cols('id_regional','int4');
		$this->var->add_def_cols('desc_regional','varchar');
		$this->var->add_def_cols('id_financiador','int4');
		$this->var->add_def_cols('desc_financiador','text');*/

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	
	function ListarFinaRegiProgProyActiUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_fina_regi_prog_proy_acti_sel';
		$this->codigo_procedimiento = "'PM_FRPPA_SEL_USU'";

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
    	$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		$this->var->add_def_cols('id_prog_proy_acti','integer');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('desc_financiador','varchar');
		$this->var->add_def_cols('desc_regional','varchar');
		$this->var->add_def_cols('desc_prog_proy_acti','text');
        $this->var->add_def_cols('desc_frppa','text');
				
			//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ContarFinaRegiProgProyActi
	 * Propósito:				Contar los registros de tpm_fina_regi_prog_proy_acti
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 10:19:37
	 */
	function ContarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_fina_regi_prog_proy_acti_sel';
		$this->codigo_procedimiento = "'PM_FRPPA_COUNT'";

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
	 * Nombre de la función:	InsertarFinaRegiProgProyActi
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_fina_regi_prog_proy_acti
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 10:19:37
	 */
	function InsertarFinaRegiProgProyActi($id_prog_proy_acti,$id_regional,$id_financiador,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_fina_regi_prog_proy_acti_iud';
		$this->codigo_procedimiento = "'PM_FRPPA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_prog_proy_acti);
		$this->var->add_param($id_regional);
		$this->var->add_param($id_financiador);
		$this->var->add_param($id_programa);
		$this->var->add_param($id_proyecto);
		$this->var->add_param($id_actividad);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarFinaRegiProgProyActi
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_fina_regi_prog_proy_acti
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 10:19:37
	 */
	function ModificarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_regional,$id_financiador,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_fina_regi_prog_proy_acti_iud';
		$this->codigo_procedimiento = "'PM_FRPPA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_fina_regi_prog_proy_acti);
		$this->var->add_param($id_prog_proy_acti);
		$this->var->add_param($id_regional);
		$this->var->add_param($id_financiador);
		$this->var->add_param($id_programa);
		$this->var->add_param($id_proyecto);
		$this->var->add_param($id_actividad);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarFinaRegiProgProyActi
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_fina_regi_prog_proy_acti
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 10:19:37
	 */
	function EliminarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_fina_regi_prog_proy_acti_iud';
		$this->codigo_procedimiento = "'PM_FRPPA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_fina_regi_prog_proy_acti);
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
	 * Nombre de la función:	ObtenerIdEp
	 * Propósito:				Obtiene el id_fina_regi_prog_proy_acti a partir de id_financiador, id_regional, id_programa, id_proyecto, id_actividad
	 * Autor:				    RCM
	 * Fecha de creación:		26/03/2009
	 */
	function ObtenerIdEp($id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_pm_obtener_id_ep';
		$this->codigo_procedimiento = "'PM_OBTEP_OBT'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_financiador);
		$this->var->add_param($id_regional);
		$this->var->add_param($id_programa);
		$this->var->add_param($id_proyecto);
		$this->var->add_param($id_actividad);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarFinaRegiProgProyActi
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_fina_regi_prog_proy_acti
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 10:19:37
	 */
	function ValidarFinaRegiProgProyActi($operacion_sql,$id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_regional,$id_financiador)
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
				//Validar id_fina_regi_prog_proy_acti - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_fina_regi_prog_proy_acti");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fina_regi_prog_proy_acti", $id_fina_regi_prog_proy_acti))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_prog_proy_acti - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_prog_proy_acti");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_prog_proy_acti", $id_prog_proy_acti))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar id_regional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_regional");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_regional", $id_regional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_financiador - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_financiador");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_financiador", $id_financiador))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_fina_regi_prog_proy_acti - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_fina_regi_prog_proy_acti");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fina_regi_prog_proy_acti", $id_fina_regi_prog_proy_acti))
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