<?php
/**
 * Nombre de la clase:	cls_DBParametroAlmacen.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_parametro_almacen
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-18 15:38:45
 */

class cls_DBParametroAlmacen
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
	 * Nombre de la función:	ListarParametroAlmacen
	 * Propósito:				Desplegar los registros de tal_parametro_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 15:38:45
	 */
	function ListarParametroAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_parametro_almacen_sel';
		$this->codigo_procedimiento = "'AL_PARALM_SEL'";

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
		$this->var->add_def_cols('id_parametro_almacen','int4');
		$this->var->add_def_cols('dias_reserva','int4');
		$this->var->add_def_cols('cierre','varchar');
		$this->var->add_def_cols('gestion','varchar');
		$this->var->add_def_cols('bloqueado','varchar');
		$this->var->add_def_cols('actualizar','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_cuenta','int4');
		$this->var->add_def_cols('desc_cuenta','varchar');
		$this->var->add_def_cols('demasia_porc','numeric');
		$this->var->add_def_cols('estado','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarParametroAlmacen
	 * Propósito:				Contar los registros de tal_parametro_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 15:38:45
	 */
	function ContarParametroAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_parametro_almacen_sel';
		$this->codigo_procedimiento = "'AL_PARALM_COUNT'";

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
	 * Nombre de la función:	InsertarParametroAlmacen
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_parametro_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 15:38:45
	 */
	function InsertarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta,$demasia_porc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_parametro_almacen_iud';
		$this->codigo_procedimiento = "'AL_PARALM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($dias_reserva);
		$this->var->add_param("'$cierre'");
		$this->var->add_param("'$gestion'");
		$this->var->add_param("'$bloqueado'");
		$this->var->add_param("'$actualizar'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("$id_cuenta");
		$this->var->add_param("$demasia_porc");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarParametroAlmacen
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_parametro_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 15:38:45
	 */
	function ModificarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta,$demasia_porc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_parametro_almacen_iud';
		$this->codigo_procedimiento = "'AL_PARALM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro_almacen);
		$this->var->add_param($dias_reserva);
		$this->var->add_param("'$cierre'");
		$this->var->add_param("'$gestion'");
		$this->var->add_param("'$bloqueado'");
		$this->var->add_param("'$actualizar'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("$id_cuenta");
		$this->var->add_param("$demasia_porc");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarParametroAlmacen
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_parametro_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 15:38:45
	 */
	function EliminarParametroAlmacen($id_parametro_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_parametro_almacen_iud';
		$this->codigo_procedimiento = "'AL_PARALM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro_almacen);
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
	 * Nombre de la función:	ValidarParametroAlmacen
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_parametro_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 15:38:45
	 */
	function ValidarParametroAlmacen($operacion_sql,$id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta)
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
				//Validar id_parametro_almacen - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_parametro_almacen");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_almacen", $id_parametro_almacen))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar dias_reserva - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("dias_reserva");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "dias_reserva", $dias_reserva))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cierre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cierre");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cierre", $cierre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar gestion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("gestion");
			$tipo_dato->set_MaxLength(4);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "gestion", $gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar bloqueado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("bloqueado");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "bloqueado", $bloqueado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar actualizar - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("actualizar");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "actualizar", $actualizar))
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

			//Validar id_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(0);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación de reglas de datos
			//Validar bloqueado
			$check = array ("si","no");
			if(!in_array($bloqueado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'bloqueado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarParametroAlmacen";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar actualizar
			$check = array ("si","no");
			if(!in_array($actualizar,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'actualizar': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarParametroAlmacen";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_parametro_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro_almacen");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_almacen", $id_parametro_almacen))
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