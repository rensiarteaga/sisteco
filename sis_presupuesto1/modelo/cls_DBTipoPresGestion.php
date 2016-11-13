<?php
/**
 * Nombre de la clase:	cls_DBTipoPresGestion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_categoria
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-04 08:54:27
 */

 
class cls_DBTipoPresGestion
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
	 * Nombre de la función:	ListarCategoria
	 * Propósito:				Desplegar los registros de tpr_categoria
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	function ListarTipoPresGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_tipo_pres_gestion_sel';
		$this->codigo_procedimiento = "'PR_TIPREGES_SEL'";

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
		$this->var->add_def_cols('id_tipo_pres_gestion','int4');
		$this->var->add_def_cols('id_tipo_pres','varchar');
		$this->var->add_def_cols('desc_tipo_pres','varchar');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('doble','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCategoria
	 * Propósito:				Contar los registros de tpr_categoria
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	function ContarTipoPresGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_tipo_pres_gestion_sel';
		$this->codigo_procedimiento = "'PR_TIPREGES_COUNT'";

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
	
	/*/**
	 * Nombre de la función:	InsertarCategoria
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_categoria
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	/*function InsertarCategoria($id_categoria,$desc_categoria,$cod_categoria)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_categoria_iud';
		$this->codigo_procedimiento = "'PR_CATEGO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$desc_categoria'");
		$this->var->add_param("'$cod_categoria'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}*/
	
	/**
	 * Nombre de la función:	ModificarCategoria
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_categoria
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	/*function ModificarCategoria($id_categoria,$desc_categoria,$cod_categoria)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_categoria_iud';
		$this->codigo_procedimiento = "'PR_CATEGO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria);
		$this->var->add_param("'$desc_categoria'");
		$this->var->add_param("'$cod_categoria'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}*/
	
	/**
	 * Nombre de la función:	EliminarCategoria
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_categoria
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	/*function EliminarCategoria($id_categoria)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_categoria_iud';
		$this->codigo_procedimiento = "'PR_CATEGO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}*/
	
	/**
	 * Nombre de la función:	ValidarCategoria
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_categoria
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:27
	 */
	/*function ValidarCategoria($operacion_sql,$id_categoria,$desc_categoria)
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
				//Validar id_categoria - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_categoria");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria", $id_categoria))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar desc_categoria - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("desc_categoria");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "desc_categoria", $desc_categoria))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_categoria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria", $id_categoria))
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
	}*/
}?>