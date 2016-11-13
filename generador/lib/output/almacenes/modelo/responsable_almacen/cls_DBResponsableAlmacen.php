<?php
/**
 * Nombre de la clase:	cls_DBResponsableAlmacen.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_responsable_almacen
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-12 15:53:18
 */

class cls_DBResponsableAlmacen
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
	 * Nombre de la función:	ListarResponsableAlmacen
	 * Propósito:				Desplegar los registros de tal_responsable_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-12 15:53:18
	 */
	function ListarResponsableAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_responsable_almacen_sel';
		$this->codigo_procedimiento = "'AL_RESALM_SEL'";

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
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('cargo','varchar');
		$this->var->add_def_cols('fecha_asignacion','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_almacen','int4');
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','int4');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarResponsableAlmacen
	 * Propósito:				Contar los registros de tal_responsable_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-12 15:53:18
	 */
	function ContarResponsableAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_responsable_almacen_sel';
		$this->codigo_procedimiento = "'AL_RESALM_COUNT'";

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
	 * Nombre de la función:	InsertarResponsableAlmacen
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_responsable_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-12 15:53:18
	 */
	function InsertarResponsableAlmacen($id_responsable_almacen,$estado,$cargo,$fecha_asignacion,$fecha_reg,$observaciones,$id_almacen,$id_empleado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_responsable_almacen_iud';
		$this->codigo_procedimiento = "'AL_RESALM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$cargo'");
		$this->var->add_param("'$fecha_asignacion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_empleado);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarResponsableAlmacen
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_responsable_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-12 15:53:18
	 */
	function ModificarResponsableAlmacen($id_responsable_almacen,$estado,$cargo,$fecha_asignacion,$fecha_reg,$observaciones,$id_almacen,$id_empleado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_responsable_almacen_iud';
		$this->codigo_procedimiento = "'AL_RESALM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$cargo'");
		$this->var->add_param("'$fecha_asignacion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_empleado);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarResponsableAlmacen
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_responsable_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-12 15:53:18
	 */
	function EliminarResponsableAlmacen($id_responsable_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_responsable_almacen_iud';
		$this->codigo_procedimiento = "'AL_RESALM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_responsable_almacen);
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
	 * Nombre de la función:	ValidarResponsableAlmacen
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_responsable_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-12 15:53:18
	 */
	function ValidarResponsableAlmacen($operacion_sql,$id_responsable_almacen,$estado,$cargo,$fecha_asignacion,$fecha_reg,$observaciones,$id_almacen,$id_empleado)
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
				//Validar id_responsable_almacen - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_responsable_almacen");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_responsable_almacen", $id_responsable_almacen))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(18);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cargo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cargo");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cargo", $cargo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_asignacion - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_asignacion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_asignacion", $fecha_asignacion))
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

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado
			$check = array ("activo","inactivo");
			if(!in_array($estado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarResponsableAlmacen";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar cargo
			$check = array ("Jefe de Almacen","Almacenero");
			if(!in_array($cargo,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'cargo': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarResponsableAlmacen";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_responsable_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_responsable_almacen");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_responsable_almacen", $id_responsable_almacen))
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