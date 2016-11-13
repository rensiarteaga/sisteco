<?php
/**
 * Nombre de la clase:	cls_DBUnidadMedidaSec.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_unidad_medida_sec
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-23 10:02:44
 */

class cls_DBUnidadMedidaSec
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
	 * Nombre de la función:	ListarUnidadMedidaSec
	 * Propósito:				Desplegar los registros de tpm_unidad_medida_sec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-23 10:02:44
	 */
	function ListarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_unidad_medida_sec_sel';
		$this->codigo_procedimiento = "'PM_UNMEDS_SEL'";

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
		$this->var->add_def_cols('id_unidad_medida_sec','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('abreviatura','varchar');
		$this->var->add_def_cols('factor_conv','numeric');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_unidad_medida_base','int4');
		$this->var->add_def_cols('desc_unidad_medida_base','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarUnidadMedidaSec
	 * Propósito:				Contar los registros de tpm_unidad_medida_sec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-23 10:02:44
	 */
	function ContarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_unidad_medida_sec_sel';
		$this->codigo_procedimiento = "'PM_UNMEDS_COUNT'";

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
	 * Nombre de la función:	InsertarUnidadMedidaSec
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_unidad_medida_sec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-23 10:02:44
	 */
	function InsertarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$fecha_reg,$id_unidad_medida_base)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_unidad_medida_sec_iud';
		$this->codigo_procedimiento = "'PM_UNMEDS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$abreviatura'");
		$this->var->add_param($factor_conv);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_unidad_medida_base);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarUnidadMedidaSec
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_unidad_medida_sec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-23 10:02:44
	 */
	function ModificarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$fecha_reg,$id_unidad_medida_base)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_unidad_medida_sec_iud';
		$this->codigo_procedimiento = "'PM_UNMEDS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_unidad_medida_sec);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$abreviatura'");
		$this->var->add_param($factor_conv);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_unidad_medida_base);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarUnidadMedidaSec
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_unidad_medida_sec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-23 10:02:44
	 */
	function EliminarUnidadMedidaSec($id_unidad_medida_sec)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_unidad_medida_sec_iud';
		$this->codigo_procedimiento = "'PM_UNMEDS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_unidad_medida_sec);
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarUnidadMedidaSec
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_unidad_medida_sec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-23 10:02:44
	 */
	function ValidarUnidadMedidaSec($operacion_sql,$id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$fecha_reg,$id_unidad_medida_base)
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
				//Validar id_unidad_medida_sec - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_unidad_medida_sec");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_medida_sec", $id_unidad_medida_sec))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar abreviatura - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("abreviatura");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "abreviatura", $abreviatura))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar factor_conv - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("factor_conv");
			$tipo_dato->set_MaxLength(1179654);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "factor_conv", $factor_conv))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_medida_base - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_medida_base");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_medida_base", $id_unidad_medida_base))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_unidad_medida_sec - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_medida_sec");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_medida_sec", $id_unidad_medida_sec))
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