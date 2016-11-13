<?php
/**
 * Nombre de la clase:	cls_DBProveedorCuentaAuxiliar.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_proveedor_cuenta_auxiliar
 * Autor:				(autogenerado)
 * Fecha creación:		2008-12-16 16:05:57
 */

 
class cls_DBProveedorCuentaAuxiliar
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
	 * Nombre de la función:	ListarProveedorCuentaDetalle
	 * Propósito:				Desplegar los registros de tad_proveedor_cuenta_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-16 16:05:57
	 */
	function ListarProveedorCuentaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_cuenta_auxiliar_sel';
		$this->codigo_procedimiento = "'AD_PROCUA_SEL'";

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
		$this->var->add_def_cols('id_proveedor_cuenta_auxiliar','int4');
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('id_cuenta','int4');
		$this->var->add_def_cols('desc_cuenta','varchar');
		$this->var->add_def_cols('id_auxiliar','int4');
		$this->var->add_def_cols('desc_auxiliar','varchar');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('denominacion_empresa','varchar');
		$this->var->add_def_cols('gestion_gestion','numeric');
		$this->var->add_def_cols('desc_gestion','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('id_cuenta_anticipo','integer');
		$this->var->add_def_cols('desc_cta_anticipo','varchar');
		$this->var->add_def_cols('id_cuenta_garantia','integer');
		$this->var->add_def_cols('desc_cta_garantia','varchar');
		
		$this->var->add_def_cols('id_cuenta_descuento','integer');
		$this->var->add_def_cols('desc_cta_descuento','varchar');
		
		$this->var->add_def_cols('id_cuenta_multa','integer');
		$this->var->add_def_cols('desc_cta_multa','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarProveedorCuentaDetalle
	 * Propósito:				Contar los registros de tad_proveedor_cuenta_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-16 16:05:57
	 */
	function ContarProveedorCuentaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_cuenta_auxiliar_sel';
		$this->codigo_procedimiento = "'AD_PROCUA_COUNT'";

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
	 * Nombre de la función:	InsertarProveedorCuentaDetalle
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_proveedor_cuenta_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-16 16:05:57
	 */
	function InsertarProveedorCuentaDetalle($id_proveedor_cuenta_auxiliar,$id_proveedor,$id_cuenta,$id_auxiliar,$id_gestion,$tipo,$id_cuenta_anticipo,$id_cuenta_garantia,$id_cuenta_descuento,$id_cuenta_multa)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_cuenta_auxiliar_iud';
		$this->codigo_procedimiento = "'AD_PROCUA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_proveedor);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param($id_gestion);
		$this->var->add_param("'$tipo'");
		$this->var->add_param($id_cuenta_anticipo);
		$this->var->add_param($id_cuenta_garantia);
		$this->var->add_param($id_cuenta_descuento);
		$this->var->add_param($id_cuenta_multa);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarProveedorCuentaDetalle
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_proveedor_cuenta_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-16 16:05:57
	 */
	function ModificarProveedorCuentaDetalle($id_proveedor_cuenta_auxiliar,$id_proveedor,$id_cuenta,$id_auxiliar,$id_gestion,$tipo,$id_cuenta_anticipo,$id_cuenta_garantia,$id_cuenta_descuento,$id_cuenta_multa)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_cuenta_auxiliar_iud';
		$this->codigo_procedimiento = "'AD_PROCUA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proveedor_cuenta_auxiliar);
		$this->var->add_param($id_proveedor);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param($id_gestion);
		$this->var->add_param("'$tipo'");
		$this->var->add_param($id_cuenta_anticipo);
		$this->var->add_param($id_cuenta_garantia);
		$this->var->add_param($id_cuenta_descuento);
		$this->var->add_param($id_cuenta_multa);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarProveedorCuentaDetalle
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_proveedor_cuenta_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-16 16:05:57
	 */
	function EliminarProveedorCuentaDetalle($id_proveedor_cuenta_auxiliar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_cuenta_auxiliar_iud';
		$this->codigo_procedimiento = "'AD_PROCUA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proveedor_cuenta_auxiliar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//id_cta_multa

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarProveedorCuentaDetalle
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_proveedor_cuenta_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-16 16:05:57
	 */
	function ValidarProveedorCuentaDetalle($operacion_sql,$id_proveedor_cuenta_auxiliar,$id_proveedor,$id_cuenta,$id_auxiliar,$id_gestion,$id_cuenta_anticipo,$id_cuenta_garantia)
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
				//Validar id_proveedor_cuenta_auxiliar - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_proveedor_cuenta_auxiliar");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor_cuenta_auxiliar", $id_proveedor_cuenta_auxiliar))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_cuenta_anticipo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_anticipo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_anticipo", $id_cuenta_anticipo))
			{
				$this->salida = $valid->salida;
				return false;
			}//Validar id_cuenta_garantia - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_garantia");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_garantia", $id_cuenta_garantia))
			{
				$this->salida = $valid->salida;
				return false;
			}
			

			//Validar id_auxiliar - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_auxiliar");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_auxiliar", $id_auxiliar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_gestion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_gestion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_proveedor_cuenta_auxiliar - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor_cuenta_auxiliar");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor_cuenta_auxiliar", $id_proveedor_cuenta_auxiliar))
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