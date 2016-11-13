<?php
/**
 * Nombre de la clase:	cls_DBConceptoCta.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_concepto_cta
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-07 15:19:33
 */

 
class cls_DBConceptoCta
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
	 * Nombre de la función:	ListarConceptoCta
	 * Propósito:				Desplegar los registros de tpr_concepto_cta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 15:19:33
	 */
	function ListarConceptoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_concepto_cta_sel';
		$this->codigo_procedimiento = "'PR_CONCTA_SEL'";

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
		$this->var->add_def_cols('id_concepto_cta','int4');
		$this->var->add_def_cols('id_concepto_ingas','int4');
		$this->var->add_def_cols('id_cuenta','int4');
		$this->var->add_def_cols('desc_cta2','text');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('nombre_auxiliar','text');
		$this->var->add_def_cols('id_auxiliar','int4');
        //Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarConceptoCta
	 * Propósito:				Contar los registros de tpr_concepto_cta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 15:19:33
	 */
	function ContarConceptoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_concepto_cta_sel';
		$this->codigo_procedimiento = "'PR_CONCTA_COUNT'";

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
	
	function ListarConceptoPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_concepto_cta_sel';
		$this->codigo_procedimiento = "'PR_CONPARCTA_SEL'";

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
		$this->var->add_def_cols('id_concepto_cta','int4');
		$this->var->add_def_cols('id_concepto_ingas','int4');
		$this->var->add_def_cols('id_cuenta','int4');
		$this->var->add_def_cols('desc_cta2','text');
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_auxiliar','text');
		$this->var->add_def_cols('id_auxiliar','int4');
        //Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarConceptoCta
	 * Propósito:				Contar los registros de tpr_concepto_cta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 15:19:33
	 */
	function ContarConceptoPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_concepto_cta_sel';
		$this->codigo_procedimiento = "'PR_CONPARCTA_COUNT'";

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
	 * Nombre de la función:	InsertarConceptoCta
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_concepto_cta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 15:19:33
	 */
	function InsertarConceptoCta($id_concepto_cta,$id_concepto_ingas,$id_cuenta,$id_presupuesto,$id_auxiliar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_concepto_cta_iud';
		$this->codigo_procedimiento = "'PR_CONCTA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_concepto_ingas);
        $this->var->add_param($id_cuenta);
        $this->var->add_param($id_presupuesto);
        $this->var->add_param($id_auxiliar);
        
        //$this->var->add_param("'$sw_tesoro'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
		echo $this->query;
		exit();
	}
	
	/**
	 * Nombre de la función:	ModificarConceptoCta
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_concepto_cta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 15:19:33
	 */
	function ModificarConceptoCta($id_concepto_cta,$id_concepto_ingas,$id_cuenta,$id_presupuesto,$id_auxiliar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_concepto_cta_iud';
		$this->codigo_procedimiento = "'PR_CONCTA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_concepto_cta);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_cuenta);
        $this->var->add_param($id_presupuesto);
        $this->var->add_param($id_auxiliar);
        //$this->var->add_param($id_servicio);
        //$this->var->add_param($id_cuenta);
        //$this->var->add_param("'$sw_tesoro'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarConceptoCta
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_concepto_cta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 15:19:33
	 */
	function EliminarConceptoCta($id_concepto_cta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_concepto_cta_iud';
		$this->codigo_procedimiento = "'PR_CONCTA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_concepto_cta);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
        $this->var->add_param("NULL");
		$this->var->add_param("NULL");
		/*$this->var->add_param("NULL");*/
		//sw_tesoro
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $id_concepto_cta;
        echo $this->query;
		exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarConceptoCta
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_concepto_cta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 15:19:33
	 */
	function ValidarConceptoCta($operacion_sql,$id_concepto_cta,$id_concepto_ingas,$id_cuenta,$id_presupuesto)
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
				//Validar id_concepto_cta - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_concepto_cta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_concepto_cta", $id_concepto_cta))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar desc_ingas - tipo varchar
			    $tipo_dato->_reiniciar_valor();
		        $tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_concepto_ingas");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_concepto_ingas", $id_concepto_ingas))
				{
					$this->salida = $valid->salida;
					return false;
				}
		
			//Validar id_partida - tipo int4
			    $tipo_dato->_reiniciar_valor();
		        $tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cuenta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
			    $tipo_dato->_reiniciar_valor();
		        $tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_presupuesto");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_presupuesto", $id_presupuesto))
				{
					$this->salida = $valid->salida;
					return false;
				}	
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_concepto_cta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_concepto_cta");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_concepto_cta", $id_concepto_cta))
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