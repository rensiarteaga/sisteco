<?php
/**
 * Nombre de la clase:	cls_DBPlantillaCalculo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_plantilla_calculo
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-16 12:20:41
 */

 
class cls_DBPlantillaCalculo
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
	 * Nombre de la función:	ListarPlantillaCalculo
	 * Propósito:				Desplegar los registros de tct_plantilla_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:41
	 */
	function ListarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_calculo_sel';
		$this->codigo_procedimiento = "'CT_PLACAL_SEL'";

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
		$this->var->add_def_cols('id_plantilla_calculo','int4');
		$this->var->add_def_cols('id_plantilla','int4');
		$this->var->add_def_cols('desc_plantilla','numeric');
		$this->var->add_def_cols('tipo_cuenta','numeric');
		$this->var->add_def_cols('id_ejercicio','int4');
		$this->var->add_def_cols('desc_ejercicio','varchar');
		$this->var->add_def_cols('desc_cuenta_ejercicio','numeric');
		$this->var->add_def_cols('debe_haber','numeric');
		$this->var->add_def_cols('porcen_calculo','numeric');
		$this->var->add_def_cols('campo_doc','varchar');
		$this->var->add_def_cols('sw_porcentaje','numeric');
		$this->var->add_def_cols('sw_retencion','numeric');
		$this->var->add_def_cols('sw_contabilizacion','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPlantillaCalculo
	 * Propósito:				Contar los registros de tct_plantilla_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:41
	 */
	function ContarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_calculo_sel';
		$this->codigo_procedimiento = "'CT_PLACAL_COUNT'";

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
	 * Nombre de la función:	InsertarPlantillaCalculo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_plantilla_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:41
	 */
	function InsertarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo,$campo_doc,$sw_porcentaje,$sw_retencion,$sw_contabilizacion)
	{   
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_calculo_iud';
		$this->codigo_procedimiento = "'CT_PLACAL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_plantilla);
		$this->var->add_param($tipo_cuenta);
		$this->var->add_param($id_ejercicio);
		$this->var->add_param($debe_haber);
		$this->var->add_param($porcen_calculo);
		$this->var->add_param("'$campo_doc'");
		$this->var->add_param($sw_porcentaje);
		$this->var->add_param($sw_retencion);
		$this->var->add_param("'$sw_contabilizacion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPlantillaCalculo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_plantilla_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:41
	 */
	function ModificarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo,$campo_doc,$sw_porcentaje,$sw_retencion,$sw_contabilizacion)
	{  
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_calculo_iud';
		$this->codigo_procedimiento = "'CT_PLACAL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plantilla_calculo);
		$this->var->add_param($id_plantilla);
		$this->var->add_param($tipo_cuenta);
		$this->var->add_param($id_ejercicio);
		$this->var->add_param($debe_haber);
		$this->var->add_param($porcen_calculo);
		$this->var->add_param("'$campo_doc'");
		$this->var->add_param($sw_porcentaje);
        $this->var->add_param($sw_retencion);
        $this->var->add_param("'$sw_contabilizacion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPlantillaCalculo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_plantilla_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:41
	 */
	function EliminarPlantillaCalculo($id_plantilla_calculo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_calculo_iud';
		$this->codigo_procedimiento = "'CT_PLACAL_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plantilla_calculo);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarPlantillaCalculo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_plantilla_calculo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:41
	 */
	function ValidarPlantillaCalculo($operacion_sql,$id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo,$sw_porcentaje,$sw_retencion,$sw_contabilizacion)
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
				//Validar id_plantilla_calculo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_plantilla_calculo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plantilla_calculo", $id_plantilla_calculo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_plantilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_plantilla");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plantilla", $id_plantilla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_cuenta - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_cuenta");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_cuenta", $tipo_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_ejercicio - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ejercicio");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ejercicio", $id_ejercicio))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar debe_haber - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("debe_haber");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "debe_haber", $debe_haber))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcen_calculo - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcen_calculo");
			$tipo_dato->set_MaxLength(393218);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcen_calculo", $porcen_calculo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_porcentaje");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "sw_porcentaje", $sw_porcentaje))
			{
				$this->salida = $valid->salida;
				return false;
			}

			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_retencion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "sw_retencion", $sw_retencion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_contabilizacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "sw_contabilizacion", $sw_contabilizacion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_plantilla_calculo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_plantilla_calculo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plantilla_calculo", $id_plantilla_calculo))
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