<?php
/**
 * Nombre de la Clase:	cls_DBPlantillaBancariz
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tct_plantilla_bancariz
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		02-10-2007
 */
class cls_DBPlantillaBancariz
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
	 * Nombre de la función:	ListarPlantillaBancariz
	 * Propósito:				Desplegar los registros de tct_plantilla_bancariz
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ListarPlantillaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_bancariz_sel';
		$this->codigo_procedimiento = "'CT_PLANBANC_SEL'";

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
		$this->var->add_def_cols('id_plantilla_bancariz','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_usuario_reg','integer');
		$this->var->add_def_cols('login','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPlantillaBancariz
	 * Propósito:				Contar los registros de tct_plantilla_bancariz
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ContarPlantillaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_bancariz_sel';
		$this->codigo_procedimiento = "'CT_PLANBANC_COUNT'";

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
	 * Nombre de la función:	InsertarPlantillaBancariz
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_plantilla_bancariz
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function InsertarPlantillaBancariz($id_plantilla_bancariz,$codigo,$descripcion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_bancariz_iud';
		$this->codigo_procedimiento = "'CT_PLANBANC_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPlantillaBancariz
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_plantilla_bancariz
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ModificarPlantillaBancariz($id_plantilla_bancariz,$codigo,$descripcion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_bancariz_iud';
		$this->codigo_procedimiento = "'CT_PLANBANC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plantilla_bancariz);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPlantillaBancariz
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_plantilla_bancariz
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function EliminarPlantillaBancariz($id_plantilla_bancariz)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_bancariz_iud';
		$this->codigo_procedimiento = "'CT_PLANBANC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plantilla_bancariz);
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
	 * Nombre de la función:	ValidarPlantillaBancariz
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_plantilla_bancariz
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ValidarPlantillaBancariz($operacion_sql,$id_plantilla_bancariz,$codigo,$descripcion)
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
				//Validar id_cuenta - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_plantilla_bancariz");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plantilla_bancariz", $id_plantilla_bancariz))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			
			
			//Validar id_cuenta_padre - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar id_cuenta_padre - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_plantilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_plantilla_bancariz");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plantilla_bancariz", $id_plantilla_bancariz))
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