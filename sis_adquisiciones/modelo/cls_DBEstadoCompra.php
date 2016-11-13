<?php
/**
 * Nombre de la clase:	cls_DBEstadoCompra.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_estado_compra
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-09 18:25:28
 */

 
class cls_DBEstadoCompra
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
	 * Nombre de la función:	ListarEstadoCompra
	 * Propósito:				Desplegar los registros de tad_estado_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 18:25:28
	 */
	function ListarEstadoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_sel';
		$this->codigo_procedimiento = "'AD_ESTCOM_SEL'";

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
		$this->var->add_def_cols('id_estado_compra','int4');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('proceso_sistema','varchar');
		$this->var->add_def_cols('cronometrable','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('tiempo_estimado','int4');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEstadoCompra
	 * Propósito:				Contar los registros de tad_estado_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 18:25:28
	 */
	function ContarEstadoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_sel';
		$this->codigo_procedimiento = "'AD_ESTCOM_COUNT'";

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
	 * Nombre de la función:	InsertarEstadoCompra
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_estado_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 18:25:28
	 */
	function InsertarEstadoCompra($id_estado_compra,$descripcion,$proceso_sistema,$cronometrable,$nombre,$tiempo_estimado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_iud';
		$this->codigo_procedimiento = "'AD_ESTCOM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$proceso_sistema'");
		$this->var->add_param("'$cronometrable'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param($tiempo_estimado);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEstadoCompra
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_estado_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 18:25:28
	 */
	function ModificarEstadoCompra($id_estado_compra,$descripcion,$proceso_sistema,$cronometrable,$nombre,$tiempo_estimado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_iud';
		$this->codigo_procedimiento = "'AD_ESTCOM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_estado_compra);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$proceso_sistema'");
		$this->var->add_param("'$cronometrable'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param($tiempo_estimado);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEstadoCompra
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_estado_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 18:25:28
	 */
	function EliminarEstadoCompra($id_estado_compra)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_estado_compra_iud';
		$this->codigo_procedimiento = "'AD_ESTCOM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_estado_compra);
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
	 * Nombre de la función:	ValidarEstadoCompra
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_estado_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-09 18:25:28
	 */
	function ValidarEstadoCompra($operacion_sql,$id_estado_compra,$descripcion,$proceso_sistema,$cronometrable,$nombre,$tiempo_estimado)
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
				//Validar id_estado_compra - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_estado_compra");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estado_compra", $id_estado_compra))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar proceso_sistema - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("proceso_sistema");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "proceso_sistema", $proceso_sistema))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cronometrable - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cronometrable");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cronometrable", $cronometrable))
			{
				$this->salida = $valid->salida;
				return false;
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

			//Validar tiempo_estimado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tiempo_estimado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "tiempo_estimado", $tiempo_estimado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar proceso_sistema
			$check = array ("si","no");
			if(!in_array($proceso_sistema,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'proceso_sistema': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarEstadoCompra";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar cronometrable
			$check = array ("si","no");
			if(!in_array($cronometrable,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'cronometrable': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarEstadoCompra";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_estado_compra - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_estado_compra");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estado_compra", $id_estado_compra))
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