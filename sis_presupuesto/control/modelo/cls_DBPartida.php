<?php
/**
 * Nombre de la clase:	cls_DBPartida.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_partida
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-07 11:38:59
 */

 
class cls_DBPartida
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
	 * Nombre de la función:	ListarPartida
	 * Propósito:				Desplegar los registros de tpr_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ListarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_sel';
		$this->codigo_procedimiento = "'PR_PARGAS_SEL'";

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
		$this->var->add_def_cols('id_partida','int4');
		
		$this->var->add_def_cols('codigo_partida','varchar');
		$this->var->add_def_cols('nombre_partida','varchar');
		$this->var->add_def_cols('nivel_partida','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('tipo_partida','numeric');
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('id_partida_padre','int4');
		$this->var->add_def_cols('descrip_partida','varchar');
		$this->var->add_def_cols('tipo_memoria','numeric');
		$this->var->add_def_cols('desc_partida','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPartida
	 * Propósito:				Contar los registros de tpr_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ContarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_sel';
		$this->codigo_procedimiento = "'PR_PARGAS_COUNT'";

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
	 * Nombre de la función:	InsertarPartida
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function InsertarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_iud';
		$this->codigo_procedimiento = "'PR_PARGAS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo_partida'");
		$this->var->add_param("'$nombre_partida'");
		$this->var->add_param($nivel_partida);
		$this->var->add_param($sw_transaccional);
		$this->var->add_param($tipo_partida);
		$this->var->add_param($id_parametro);
		$this->var->add_param($id_partida_padre);
		$this->var->add_param($tipo_memoria);
		$this->var->add_param("'$desc_partida'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPartida
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ModificarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_iud';
		$this->codigo_procedimiento = "'PR_PARGAS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida);
		$this->var->add_param("'$codigo_partida'");
		$this->var->add_param("'$nombre_partida'");
		$this->var->add_param($nivel_partida);
		$this->var->add_param($sw_transaccional);
		$this->var->add_param($tipo_partida);
		$this->var->add_param($id_parametro);
		$this->var->add_param($id_partida_padre);
		$this->var->add_param($tipo_memoria);
		$this->var->add_param("'$desc_partida'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPartida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function EliminarPartida($id_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_iud';
		$this->codigo_procedimiento = "'PR_PARGAS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida);
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
	 * Nombre de la función:	ValidarPartida
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ValidarPartida($operacion_sql,$id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
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
				//Validar id_partida - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_partida");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida", $id_partida))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo_partida - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_partida");
			$tipo_dato->set_MaxLength(18);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_partida", $codigo_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_partida - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_partida");
			$tipo_dato->set_MaxLength(75);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_partida", $nombre_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nivel_partida - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nivel_partida");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "nivel_partida", $nivel_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar sw_transaccional - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_transaccional");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "sw_transaccional", $sw_transaccional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_partida - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_partida");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_partida", $tipo_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_parametro - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida_padre - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_padre");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_padre", $id_partida_padre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_memoria - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_memoria");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_memoria", $tipo_memoria))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar desc_partida - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("desc_partida");
			$tipo_dato->set_MaxLength(400);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "desc_partida", $desc_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_partida - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida", $id_partida))
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