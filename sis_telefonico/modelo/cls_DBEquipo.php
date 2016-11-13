<?php
/**
 * Nombre de la clase:	cls_DBEquipo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tst_tst_equipo
 * Autor:				(autogenerado)
 * Fecha creación:		2016-04-18 19:44:10
 */

class cls_DBEquipo
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
	 * Nombre de la función:	ListarEquipo
	 * Propósito:				Desplegar los registros de tst_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ListarEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_equipo_sel';
		$this->codigo_procedimiento = "'ST_EQUIPO_SEL'";

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
		$this->var->add_def_cols('id_equipo','int4');
		$this->var->add_def_cols('modelo','varchar');
		$this->var->add_def_cols('marca','varchar');
		$this->var->add_def_cols('fecha_ingreso','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('imei','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEquipo
	 * Propósito:				Contar los registros de tst_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ContarEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_equipo_sel';
		$this->codigo_procedimiento = "'ST_EQUIPO_COUNT'";

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
	 * Nombre de la función:	InsertarEquipo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tst_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2016-04-18 19:44:10
	 */
	function InsertarEquipo($id_equipo, $modelo,$marca, $fecha_ingreso, $estado_reg, $observaciones,$imei)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_equipo_iud';
		$this->codigo_procedimiento = "'ST_EQUIPO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$modelo'");
		$this->var->add_param("'$marca'");
		$this->var->add_param("'$fecha_ingreso'");
		$this->var->add_param("'$estado_reg'");
        $this->var->add_param("'$observaciones'");
        $this->var->add_param("'$imei'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEquipo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tst_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ModificarEquipo($id_equipo, $modelo,$marca, $fecha_ingreso, $estado_reg, $observaciones,$imei)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_equipo_iud';
		$this->codigo_procedimiento = "'ST_EQUIPO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_equipo);
		$this->var->add_param("'$modelo'");
		$this->var->add_param("'$marca'");
		$this->var->add_param("'$fecha_ingreso'");
		$this->var->add_param("'$estado_reg'");
        $this->var->add_param("'$observaciones'");
        $this->var->add_param("'$imei'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEquipo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tst_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function EliminarEquipo($id_equipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_equipo_iud';
		$this->codigo_procedimiento = "'ST_EQUIPO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_equipo);
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
	 * Nombre de la función:	ValidarEquipo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tst_equipo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ValidarEquipo($operacion_sql,$id_equipo, $modelo,$marca, $fecha_ingreso, $estado_reg, $observaciones,$imei)
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
				//Validar id_equipo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_equipo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_equipo", $id_equipo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar empresa - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("modelo");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "modelo", $modelo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar puerto_equipo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("marca");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "marca", $marca))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(150);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("imei");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "imei", $imei))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_equipo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_equipo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_equipo", $id_equipo))
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