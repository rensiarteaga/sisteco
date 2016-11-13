<?php
/**
 * Nombre de la clase:	cls_DBMetaproceso.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_metaproceso
 * Autor:				Rensi Arteaga Copari
 * Fecha creación:		2007-10-26 16:42:27
 */

class cls_DBProcedimiento_db{
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
	 * Nombre de la función:	ListarMetaproceso
	 * Propósito:				Desplegar los registros de tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ListarProcedimiento_db($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_procedimiento_db_sel';
		$this->codigo_procedimiento = "'SG_PROCDB_SEL'";
		$func = new cls_funciones();//Instancia de las funciones generales
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";;
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
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('nombre_funcion','varchar');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('habilitar_log','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nombre_largo','text');
	

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query ;
		return $res;
	}

	

	/**
	 * Nombre de la función:	ContarMetaproceso
	 * Propósito:				Contar los registros de tsg_metaproceso
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ContarProcedimiento_db($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_procedimiento_db_sel';
		$this->codigo_procedimiento = "'SG_PROCDB_COUNT'";
		$func = new cls_funciones();//Instancia de las funciones generales
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";;
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
	 * Nombre de la función:	InsertarMetaproceso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function InsertarProcedimiento_db($codigo_procedimiento,$nombre_funcion,$descripcion,$habilitar_log,$fecha_reg,$id_subsistema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_procedimiento_db_iud';
		$this->codigo_procedimiento = "'SG_PROCDB_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$nombre_funcion'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$habilitar_log'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_subsistema);
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarMetaproceso
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ModificarProcedimiento_db($codigo_procedimiento,$nombre_funcion,$descripcion,$habilitar_log,$fecha_reg,$id_subsistema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_procedimiento_db_iud';
		$this->codigo_procedimiento = "'SG_PROCDB_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$nombre_funcion'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$habilitar_log'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_subsistema);
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarMetaproceso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function EliminarProcedimiento_db($codigo_procedimiento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_procedimiento_db_iud';
		$this->codigo_procedimiento = "'SG_PROCDB_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$codigo_procedimiento'");
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
	 * Nombre de la función:	ValidarMetaproceso
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ValidarProcedimiento_db($operacion_sql,$codigo_procedimiento,$nombre_funcion,$descripcion,$habilitar_log,$fecha_reg,$id_subsistema)
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
				//Validar id_metaproceso - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(30);
				$tipo_dato->set_Columna("codigo_procedimiento");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_procedimiento", $codigo_procedimiento))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_subsistema - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subsistema");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subsistema", $id_subsistema))
			{
				$this->salida = $valid->salida;
				return false;
			}

				
			//Validar nombre - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_funcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_funcion", $nombre_funcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			//Validar ruta_archivo - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			//Validar habilitar_log - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("habilitar_log");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "habilitar_log", $habilitar_log))
			{
				$this->salida = $valid->salida;
				return false;
			}


			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			
			//Validar habilitar_log
			$check = array ("si","no");
			if(!in_array($habilitar_log,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'habilitar_log': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarMetaproceso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete'){
			//Validar id_metaproceso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_procedimiento");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "codigo_procedimiento", $codigo_procedimiento)){
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