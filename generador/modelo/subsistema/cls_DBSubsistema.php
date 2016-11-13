<?php
/**
 * Nombre de la clase:	cls_DBSubsistema.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_subsistema
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-10 11:02:01
 */

class cls_DBSubsistema
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
	 * Nombre de la función:	ListarSubsistema
	 * Propósito:				Desplegar los registros de tsg_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-10 11:02:01
	 */
	function ListarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_subsistema_sel';
		$this->codigo_procedimiento = "'SG_SUBSIS_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nombre_corto','varchar');
		$this->var->add_def_cols('nombre_largo','text');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('version_desarrollo','varchar');
		$this->var->add_def_cols('desarrolladores','text');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('hora_reg','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');
		$this->var->add_def_cols('observaciones','text');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSubsistema
	 * Propósito:				Contar los registros de tsg_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-10 11:02:01
	 */
	function ContarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_subsistema_sel';
		$this->codigo_procedimiento = "'SG_SUBSIS_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		
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
	 * Nombre de la función:	InsertarSubsistema
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-10 11:02:01
	 */
	function InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_subsistema_iud';
		$this->codigo_procedimiento = "'SG_SUBSIS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_corto'");
		$this->var->add_param("'$nombre_largo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$version_desarrollo'");
		$this->var->add_param("'$desarrolladores'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$hora_reg'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$observaciones'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarSubsistema
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-10 11:02:01
	 */
	function ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_subsistema_iud';
		$this->codigo_procedimiento = "'SG_SUBSIS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_subsistema);
		$this->var->add_param("'$nombre_corto'");
		$this->var->add_param("'$nombre_largo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$version_desarrollo'");
		$this->var->add_param("'$desarrolladores'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$hora_reg'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$observaciones'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarSubsistema
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-10 11:02:01
	 */
	function EliminarSubsistema($id_subsistema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_subsistema_iud';
		$this->codigo_procedimiento = "'SG_SUBSIS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_subsistema);
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarSubsistema
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_subsistema
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-10 11:02:01
	 */
	function ValidarSubsistema($operacion_sql,$id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
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
				//Validar id_subsistema - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_subsistema");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subsistema", $id_subsistema))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre_corto - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_corto");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_corto", $nombre_corto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_largo - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_largo");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_largo", $nombre_largo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar version_desarrollo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("version_desarrollo");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "version_desarrollo", $version_desarrollo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar desarrolladores - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("desarrolladores");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "desarrolladores", $desarrolladores))
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

			//Validar hora_reg - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_reg");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_reg", $hora_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_ultima_modificacion - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ultima_modificacion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ultima_modificacion", $fecha_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_ultima_modificacion - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_ultima_modificacion");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_ultima_modificacion", $hora_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_subsistema - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subsistema");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subsistema", $id_subsistema))
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