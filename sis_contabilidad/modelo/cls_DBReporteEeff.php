<?php
/**
 * Nombre de la clase:	cls_DBReporteEeff.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_reporte_eeff
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-02 11:34:33
 */

 
class cls_DBReporteEeff
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
	 * Nombre de la función:	ListarEeff
	 * Propósito:				Desplegar los registros de tct_reporte_eeff
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-02 11:34:33
	 */
	function ListarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_sel';
		$this->codigo_procedimiento = "'CT_REEEFF_SEL'";

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
		$this->var->add_def_cols('id_reporte_eeff','int4');
		$this->var->add_def_cols('nombre_eeff','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEeff
	 * Propósito:				Contar los registros de tct_reporte_eeff
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-02 11:34:33
	 */
	function ContarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_sel';
		$this->codigo_procedimiento = "'CT_REEEFF_COUNT'";

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
	 * Nombre de la función:	InsertarEeff
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_reporte_eeff
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-02 11:34:33
	 */
	function InsertarEeff($id_reporte_eeff,$nombre_eeff)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_iud';
		$this->codigo_procedimiento = "'CT_REEEFF_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_eeff'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEeff
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_reporte_eeff
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-02 11:34:33
	 */
	function ModificarEeff($id_reporte_eeff,$nombre_eeff)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_iud';
		$this->codigo_procedimiento = "'CT_REEEFF_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_reporte_eeff);
		$this->var->add_param("'$nombre_eeff'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEeff
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_reporte_eeff
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-02 11:34:33
	 */
	function EliminarEeff($id_reporte_eeff)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_iud';
		$this->codigo_procedimiento = "'CT_REEEFF_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_reporte_eeff);
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
	 * Nombre de la función:	ValidarEeff
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_reporte_eeff
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-02 11:34:33
	 */
	function ValidarEeff($operacion_sql,$id_reporte_eeff,$nombre_eeff)
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
				//Validar id_reporte_eeff - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_reporte_eeff");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_reporte_eeff", $id_reporte_eeff))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre_eeff - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_eeff");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_eeff", $nombre_eeff))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_reporte_eeff - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_reporte_eeff");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_reporte_eeff", $id_reporte_eeff))
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