<?php
/**
 * Nombre de la clase:	cls_DBCbteClase.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_cbte_clase
 * Autor:				(autogenerado)
 * Fecha creación:		2008-09-18 09:21:10
 */

 
class cls_DBCbteClase
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
	 * Nombre de la función:	ListarCbteClase
	 * Propósito:				Desplegar los registros de tct_cbte_clase
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-18 09:21:10
	 */
	function ListarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cbte_clase_sel';
		$this->codigo_procedimiento = "'CT_CBTECL_SEL'";

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
		$this->var->add_def_cols('id_clase_cbte','int4');
		$this->var->add_def_cols('desc_clase','varchar');
		$this->var->add_def_cols('estado_clase','numeric');
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('desc_documento','varchar');
        $this->var->add_def_cols('titulo_cbte','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCbteClase
	 * Propósito:				Contar los registros de tct_cbte_clase
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-18 09:21:10
	 */
	function ContarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cbte_clase_sel';
		$this->codigo_procedimiento = "'CT_CBTECL_COUNT'";

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
	 * Nombre de la función:	InsertarCbteClase
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_cbte_clase
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-18 09:21:10
	 */
	function InsertarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento,$titulo_cbte)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cbte_clase_iud';
		$this->codigo_procedimiento = "'CT_CBTECL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$desc_clase'");
		$this->var->add_param($estado_clase);
		$this->var->add_param($id_documento);
		$this->var->add_param("'$titulo_cbte'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCbteClase
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_cbte_clase
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-18 09:21:10
	 */
	function ModificarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento,$titulo_cbte)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cbte_clase_iud';
		$this->codigo_procedimiento = "'CT_CBTECL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_clase_cbte);
		$this->var->add_param("'$desc_clase'");
		$this->var->add_param($estado_clase);
		$this->var->add_param($id_documento);
		$this->var->add_param("'$titulo_cbte'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCbteClase
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_cbte_clase
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-18 09:21:10
	 */
	function EliminarCbteClase($id_clase_cbte)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cbte_clase_iud';
		$this->codigo_procedimiento = "'CT_CBTECL_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_clase_cbte);
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
	 * Nombre de la función:	ValidarCbteClase
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_cbte_clase
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-18 09:21:10
	 */
	function ValidarCbteClase($operacion_sql,$id_clase_cbte,$desc_clase,$estado_clase,$id_documento,$titulo_cbte)
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
				//Validar id_clase_cbte - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_clase_cbte");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clase_cbte", $id_clase_cbte))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar desc_clase - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("desc_clase");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "desc_clase", $desc_clase))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_clase - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_clase");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_clase", $estado_clase))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_documento - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_documento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_documento", $id_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_clase_cbte - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_clase_cbte");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clase_cbte", $id_clase_cbte))
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