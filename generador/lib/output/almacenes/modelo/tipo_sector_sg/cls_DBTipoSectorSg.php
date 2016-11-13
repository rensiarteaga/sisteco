<?php
/**
 * Nombre de la clase:	cls_DBTipoSectorSg.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_tipo_sector_sg
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-11 16:16:51
 */

class cls_DBTipoSectorSg
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
	 * Nombre de la función:	ListarTipoSectorSg
	 * Propósito:				Desplegar los registros de tal_tipo_sector_sg
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:16:51
	 */
	function ListarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_sector_sg_sel';
		$this->codigo_procedimiento = "'AL_TISESG_SEL'";

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
		$this->var->add_def_cols('id_tal_tipo_sector_sg','int4');
		$this->var->add_def_cols('id_tipo_sector','int4');
		$this->var->add_def_cols('desc_tipo_sector','varchar');
		$this->var->add_def_cols('id_supergrupo','int4');
		$this->var->add_def_cols('desc_supergrupo','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoSectorSg
	 * Propósito:				Contar los registros de tal_tipo_sector_sg
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:16:51
	 */
	function ContarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_sector_sg_sel';
		$this->codigo_procedimiento = "'AL_TISESG_COUNT'";

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
	 * Nombre de la función:	InsertarTipoSectorSg
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_sector_sg
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:16:51
	 */
	function InsertarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_sector_sg_iud';
		$this->codigo_procedimiento = "'AL_TISESG_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_sector);
		$this->var->add_param($id_supergrupo);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoSectorSg
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_tipo_sector_sg
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:16:51
	 */
	function ModificarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_sector_sg_iud';
		$this->codigo_procedimiento = "'AL_TISESG_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tal_tipo_sector_sg);
		$this->var->add_param($id_tipo_sector);
		$this->var->add_param($id_supergrupo);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoSectorSg
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_tipo_sector_sg
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:16:51
	 */
	function EliminarTipoSectorSg($id_tal_tipo_sector_sg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_sector_sg_iud';
		$this->codigo_procedimiento = "'AL_TISESG_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tal_tipo_sector_sg);
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
	 * Nombre de la función:	ValidarTipoSectorSg
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_tipo_sector_sg
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:16:51
	 */
	function ValidarTipoSectorSg($operacion_sql,$id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo)
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
				//Validar id_tal_tipo_sector_sg - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tal_tipo_sector_sg");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tal_tipo_sector_sg", $id_tal_tipo_sector_sg))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_tipo_sector - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_sector");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_sector", $id_tipo_sector))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_supergrupo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_supergrupo");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_supergrupo", $id_supergrupo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tal_tipo_sector_sg - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tal_tipo_sector_sg");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tal_tipo_sector_sg", $id_tal_tipo_sector_sg))
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