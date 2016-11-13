<?php
/**
 * Nombre de la clase:	cls_DBSucursal.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_sucursal
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-24 18:28:37
 */

class cls_DBSucursal
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
	 * Nombre de la función:	ListarSucursal
	 * Propósito:				Desplegar los registros de tpm_sucursal
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-24 18:28:37
	 */
	function ListarSucursal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_sucursal_sel';
		$this->codigo_procedimiento = "'PM_SUCURS_SEL'";

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
		$this->var->add_def_cols('id_sucursal','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nit','varchar');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('usuario_reg','varchar');
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
	 * Nombre de la función:	ContarSucursal
	 * Propósito:				Contar los registros de tpm_sucursal
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-24 18:28:37
	 */
	function ContarSucursal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_sucursal_sel';
		$this->codigo_procedimiento = "'PM_SUCURS_COUNT'";

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
	 * Nombre de la función:	InsertarSucursal
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_sucursal
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-24 18:28:37
	 */
	function InsertarSucursal($id_sucursal,$nombre,$razon_social,$nit,$direccion,$proyecto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_sucursal_iud';
		$this->codigo_procedimiento = "'PM_SUCURS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nit'");
		$this->var->add_param("'$direccion'");
		$this->var->add_param("'$proyecto'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarSucursal
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_sucursal
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-24 18:28:37
	 */
	function ModificarSucursal($id_sucursal,$nombre,$razon_social,$nit,$direccion,$proyecto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_sucursal_iud';
		$this->codigo_procedimiento = "'PM_SUCURS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_sucursal);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nit'");
		$this->var->add_param("'$direccion'");
		$this->var->add_param("'$proyecto'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarSucursal
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_sucursal
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-24 18:28:37
	 */
	function EliminarSucursal($id_sucursal)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_sucursal_iud';
		$this->codigo_procedimiento = "'PM_SUCURS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_sucursal);
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
	 * Nombre de la función:	ValidarSucursal
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_sucursal
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-24 18:28:37
	 */
	function ValidarSucursal($operacion_sql,$id_sucursal,$nombre,$razon_social,$nit,$direccion,$proyecto)
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
				//Validar id_sucursal - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_sucursal");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_sucursal", $id_sucursal))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("razon_social");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "razon_social", $razon_social))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nit");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nit", $nit))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validar direccion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("direccion");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "direccion", $direccion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("proyecto");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "proyecto", $proyecto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_sucursal - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_sucursal");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_sucursal", $id_sucursal))
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