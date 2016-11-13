<?php
/**
 * Nombre de la Clase:	cls_DBCuentaSigma
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tct_cuenta_sigma
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		02-10-2007
 */
class cls_DBCuentaSigma
{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $nro_procedimiento;
	var $decodificar;
	
	function __construct()
	{
		$this->decodificar=$decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarCuentaSigma
	 * Propósito:				Desplegar los registros de tct_cuenta_sigma
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ListarCuentaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cuenta_sigma_sel';
		$this->nro_procedimiento = "'CT_CSIGMA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->nro_procedimiento);

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
		$this->var->add_def_cols('id_cuenta_sigma','int4');
		$this->var->add_def_cols('nro_cuenta_sigma','varchar');
		$this->var->add_def_cols('nombre_cuenta_sigma','varchar');
		$this->var->add_def_cols('estado_cuenta_sigma','numeric');
		$this->var->add_def_cols('desc_sigma','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
			/*echo ($this->query );
	exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCuentaSigma
	 * Propósito:				Contar los registros de tct_cuenta_sigma
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ContarCuentaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cuenta_sigma_sel';
		$this->nro_procedimiento = "'CT_CSIGMA_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->nro_procedimiento);

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
	 * Nombre de la función:	InsertarCuentaSigma
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_cuenta_sigma
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function InsertarCuentaSigma($id_cuenta_sigma,$nro_cuenta_sigma,$nombre_cuenta_sigma,$estado_cuenta_sigma)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cuenta_sigma_iud';
		$this->nro_procedimiento = "'CT_CSIGMA_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->nro_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nro_cuenta_sigma'");
		$this->var->add_param("'$nombre_cuenta_sigma'");
		$this->var->add_param($estado_cuenta_sigma);
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCuentaSigma
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_cuenta_sigma
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ModificarCuentaSigma($id_cuenta_sigma,$nro_cuenta_sigma,$nombre_cuenta_sigma,$estado_cuenta_sigma)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cuenta_sigma_iud';
		$this->nro_procedimiento = "'CT_CSIGMA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->nro_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cuenta_sigma");
		$this->var->add_param("'$nro_cuenta_sigma'");
		$this->var->add_param("'$nombre_cuenta_sigma'");
		$this->var->add_param($estado_cuenta_sigma);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCuentaSigma
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_cuenta_sigma
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function EliminarCuentaSigma($id_cuenta_sigma)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cuenta_sigma_iud';
		$this->nro_procedimiento = "'CT_CSIGMA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->nro_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_sigma);
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
	 * Nombre de la función:	ReporteCuentaCuentaSigma
	 * Propósito:				Desplegar los registros de tct_cuenta_cuenta_sigma y tct_cuenta_sigma
	 * Autor:				    avq
	 * Fecha de creación:		2008-12-17 11:01:39
	 */
	function ReporteCuentaCuentaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cuenta_sigma_sel';
		$this->nro_procedimiento = "'CT_RECUAU_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->nro_procedimiento);

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
		$this->var->add_def_cols('id_cuenta_sigma','int4');
		$this->var->add_def_cols('nro_cuenta_sigma','varchar');
		$this->var->add_def_cols('nombre_cuenta_sigma','varchar');
		$this->var->add_def_cols('estado_cuenta_sigma','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ValidarCuentaSigma
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_cuenta_sigma
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ValidarCuentaSigma($operacion_sql,$id_cuenta_sigma,$nro_cuenta_sigma,$nombre_cuenta_sigma,$estado_cuenta_sigma)
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
				$tipo_dato->set_Columna("id_cuenta_sigma");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_sigma", $id_cuenta_sigma))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nro_cuenta - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_cuenta_sigma");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_cuenta_sigma", $nro_cuenta_sigma))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_cuenta_sigma");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_cuenta_sigma", $nombre_cuenta_sigma))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cuenta_padre - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_cuenta_sigma");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "estado_cuenta_sigma", $estado_cuenta_sigma))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_sigma");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_sigma", $id_cuenta_sigma))
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