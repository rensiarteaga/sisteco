<?php
/**
 * Nombre de la clase:	cls_DBReparacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_servicio
 * Autor:				avq
 * Fecha creación:		23/07/2010
 */

 
class cls_DBReparacion
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
	 * Nombre de la función:	ListarServicio
	 * Propósito:				Desplegar los registros de tad_servicio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-16 10:48:13
	 */
	function ListarReparacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_reparacion_consultas';
		$this->codigo_procedimiento = "'AF_REP_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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
		$this->var->add_def_cols('id_reparacion','integer');
		$this->var->add_def_cols('fecha_desde','date');
		$this->var->add_def_cols('fecha_hasta','date');
		$this->var->add_def_cols('problema','text');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('id_persona','integer');
		$this->var->add_def_cols('id_institucion','integer');
		$this->var->add_def_cols('des_activo_fijo','varchar');
		$this->var->add_def_cols('des_persona','text');
		$this->var->add_def_cols('des_institucion','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ContarListaReparacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarListaReparacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_reparacion_consultas';
		$this->codigo_procedimiento = "'AF_REP_SEL_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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
		//echo $this->query;
		//exit;
		//Retorna el resultado de la ejecución
		return $res;
	}	
	/**
	 * Nombre de la función:	CrearReparacion
	 * Propósito:				Permite ejecutar la función de inserción de la taf_reparacion de la base de datos,
	 * 							con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_reparacion
	 * @param unknown_type $fecha_desde
	 * @param unknown_type $fecha_hasta
	 * @param unknown_type $problema
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $id_institucion
	 * @param unknown_type $id_persona
	 * @param unknown_type $id_activo_fijo
	 * @return unknown
	 */
	function InsertarReparacion($id_reparacion, $fecha_desde, $fecha_hasta, $problema, $fecha_reg, $observaciones, $estado,  $id_activo_fijo, $id_persona,$id_institucion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_reparacion_iud';
		$this->codigo_procedimiento = "'AF_REPARA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//id_reparacion
		$this->var->add_param("'$fecha_desde'");//fecha_desde
		$this->var->add_param("'$fecha_hasta'");//fecha_hasta
		$this->var->add_param("'$problema'");//problema
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param($id_persona);//id_persona
		$this->var->add_param($id_institucion);//id_institucion

      //  $this->var->add_param("'$servicio'");
       //Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
      
		return $res;
		
		
	}
	
	/**
	 * Nombre de la función:	ModificarServicio
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_servicio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-16 10:48:13
	 */
	function ModificarReparacion($id_reparacion, $fecha_desde, $fecha_hasta, $problema, $fecha_reg, $observaciones, $estado,  $id_activo_fijo, $id_persona,$id_institucion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_reparacion_iud';
		$this->codigo_procedimiento = "'AF_REPARA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_reparacion");//id_reparacion
		$this->var->add_param("'$fecha_desde'");//fecha_desde
		$this->var->add_param("'$fecha_hasta'");//fecha_hasta
		$this->var->add_param("'$problema'");//problema
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param($id_persona);//id_persona
		$this->var->add_param($id_institucion);//id_institucion
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarReparacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_reparacion
	 * Autor:				    AVQ
	 * Fecha de creación:		26/07/2010
	 */
	function EliminarReparacion($id_reparacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_reparacion_iud';
		$this->codigo_procedimiento = "'AF_REPARA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_reparacion);
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
	 * Nombre de la función:	ValidarServicio
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_servicio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-16 10:48:13
	 */
	function ValidarReparacion($operacion_sql, $id_reparacion, $fecha_desde, $fecha_hasta, $problema, $fecha_reg, $observaciones, $estado,$id_activo_fijo, $id_persona,  $id_institucion)
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
				//Validar id_servicio - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_reparacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_reparacion", $id_reparacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			//Validar nombre - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(150);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(500);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
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

			//Validar id_tipo_servicio - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_servicio");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_servicio", $id_tipo_servicio))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
*/
			//Validación exitosa
			return true;
		}
		/*elseif ($operacion_sql=='delete')
		{
			//Validar id_servicio - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_servicio");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_servicio", $id_servicio))
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
		}*/
	}
}?>