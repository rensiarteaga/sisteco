<?php
/**
 * Nombre de la clase:	cls_DBCategoriaVacacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_categoria_vacacion
 * Autor:				(autogenerado)
 * Fecha creación:		2010-08-13 15:23:28
 */

 
class cls_DBCategoriaVacacion
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
	 * Nombre de la función:	ListarCategoriaVacacion
	 * Propósito:				Desplegar los registros de tkp_categoria_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 15:23:28
	 */
	function ListarCategoriaVacacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_categoria_vacacion_sel';
		$this->codigo_procedimiento = "'KP_CATVAC_SEL'";

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
		$this->var->add_def_cols('id_categoria_vacacion','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('dias_vacacion','int4');
		$this->var->add_def_cols('caducidad','int4');
		$this->var->add_def_cols('antiguedad_ini','int4');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('antiguedad_fin','int4');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCategoriaVacacion
	 * Propósito:				Contar los registros de tkp_categoria_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 15:23:28
	 */
	function ContarCategoriaVacacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_categoria_vacacion_sel';
		$this->codigo_procedimiento = "'KP_CATVAC_COUNT'";

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
	 * Nombre de la función:	InsertarCategoriaVacacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_categoria_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 15:23:28
	 */
	function InsertarCategoriaVacacion($id_categoria_vacacion,$nombre,$dias_vacacion,$caducidad,$antiguedad_ini,$descripcion,$fecha_reg,$estado_reg,$antiguedad_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_categoria_vacacion_iud';
		$this->codigo_procedimiento = "'KP_CATVAC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param($dias_vacacion);
		$this->var->add_param("'$caducidad'");
		$this->var->add_param("$antiguedad_ini");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("$antiguedad_fin");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCategoriaVacacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_categoria_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 15:23:28
	 */
	function ModificarCategoriaVacacion($id_categoria_vacacion,$nombre,$dias_vacacion,$caducidad,$antiguedad_ini,$descripcion,$fecha_reg,$estado_reg,$antiguedad_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_categoria_vacacion_iud';
		$this->codigo_procedimiento = "'KP_CATVAC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria_vacacion);
		$this->var->add_param("'$nombre'");
		$this->var->add_param($dias_vacacion);
		$this->var->add_param("'$caducidad'");
		$this->var->add_param("$antiguedad_ini");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("$antiguedad_fin");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCategoriaVacacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_categoria_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 15:23:28
	 */
	function EliminarCategoriaVacacion($id_categoria_vacacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_categoria_vacacion_iud';
		$this->codigo_procedimiento = "'KP_CATVAC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria_vacacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//antiguedad fin

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarCategoriaVacacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_categoria_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-13 15:23:28
	 */
	function ValidarCategoriaVacacion($operacion_sql,$id_categoria_vacacion,$nombre,$dias_vacacion,$caducidad,$antiguedad_ini,$descripcion,$fecha_reg,$estado_reg)
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
				//Validar id_categoria_vacacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_categoria_vacacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_vacacion", $id_categoria_vacacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar dias_vacacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("dias_vacacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "dias_vacacion", $dias_vacacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar caducidad - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("caducidad");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "caducidad", $caducidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar antiguedad_ini - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("antiguedad_ini");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "antiguedad_ini", $antiguedad_ini))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar estado_reg - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_categoria_vacacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria_vacacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_vacacion", $id_categoria_vacacion))
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