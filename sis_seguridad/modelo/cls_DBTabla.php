<?php
/**
 * Nombre de la clase:	cls_DBTabla.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_tabla
 * Autor:				(autogenerado)
 * Fecha creación:		2008-06-04 16:11:03
 */

 
class cls_DBTabla
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
	 * Nombre de la función:	ListarTabla
	 * Propósito:				Desplegar los registros de tsg_tabla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-06-04 16:11:03
	 */
	function ListarTabla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tabla_sel';
		$this->codigo_procedimiento = "'SG_TABVIS_SEL'";

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
		$this->var->add_def_cols('id_tabla','int4');
		$this->var->add_def_cols('nombre_metaproceso','text');
		$this->var->add_def_cols('descripcion_metaproceso','text');
		$this->var->add_def_cols('nombre_tabla','varchar');
		$this->var->add_def_cols('desc_tabla','text');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('desc_metaproceso','text');
		$this->var->add_def_cols('fk_id_tabla','int4');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTabla
	 * Propósito:				Contar los registros de tsg_tabla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-06-04 16:11:03
	 */
	function ContarTabla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tabla_sel';
		$this->codigo_procedimiento = "'SG_TABVIS_COUNT'";

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
	 * Nombre de la función:	InsertarTabla
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_tabla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-06-04 16:11:03
	 */
	function InsertarTabla($id_tabla,$nombre,$observaciones,$id_metaproceso,$fk_id_tabla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tabla_iud';
		$this->codigo_procedimiento = "'SG_TABVIS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_metaproceso);
		$this->var->add_param($fk_id_tabla);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTabla
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_tabla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-06-04 16:11:03
	 */
	function ModificarTabla($id_tabla,$nombre,$observaciones,$id_metaproceso,$fk_id_tabla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tabla_iud';
		$this->codigo_procedimiento = "'SG_TABVIS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tabla);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_metaproceso);
		$this->var->add_param($fk_id_tabla);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTabla
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_tabla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-06-04 16:11:03
	 */
	function EliminarTabla($id_tabla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tabla_iud';
		$this->codigo_procedimiento = "'SG_TABVIS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tabla);
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
	 * Nombre de la función:	ValidarTabla
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_tabla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-06-04 16:11:03
	 */
	function ValidarTabla($operacion_sql,$id_tabla,$nombre,$observaciones,$id_metaproceso,$fk_id_tabla)
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
				//Validar id_tabla - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tabla");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tabla", $id_tabla))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_metaproceso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_metaproceso");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_metaproceso", $id_metaproceso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fk_id_tabla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fk_id_tabla");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "fk_id_tabla", $fk_id_tabla))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tabla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tabla");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tabla", $id_tabla))
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