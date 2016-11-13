<?php
/**
 * Nombre de la clase:	cls_DBComposicionTuc.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_composicion_tuc
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-06 16:27:45
 */

class cls_DBComposicionTuc
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
	 * Nombre de la función:	ListarComposicionTuc
	 * Propósito:				Desplegar los registros de tal_composicion_tuc
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function ListarComposicionTuc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_composicion_tuc_sel';
		$this->codigo_procedimiento = "'AL_COMPTUC_SEL'";

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
		$this->var->add_def_cols('id_composicion_tuc','int4');
		$this->var->add_def_cols('cantidad','int4');
		$this->var->add_def_cols('opcional','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_tuc_hijo','int4');
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('desc_tipo_unidad_constructiva','varchar');
		$this->var->add_def_cols('desc_tuc_hijo','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarComposicionTuc
	 * Propósito:				Contar los registros de tal_composicion_tuc
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function ContarComposicionTuc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_composicion_tuc_sel';
		$this->codigo_procedimiento = "'AL_COMPTUC_COUNT'";

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
	 * Nombre de la función:	InsertarComposicionTuc
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_composicion_tuc
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function InsertarComposicionTuc($id_composicion_tuc,$cantidad,$opcional,$fecha_reg,$id_tuc_hijo,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_composicion_tuc_iud';
		$this->codigo_procedimiento = "'AL_COMPTUC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad);
		$this->var->add_param("'$opcional'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_tuc_hijo);
		$this->var->add_param($id_tipo_unidad_constructiva);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarComposicionTuc
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_composicion_tuc
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function ModificarComposicionTuc($id_composicion_tuc,$cantidad,$opcional,$fecha_reg,$id_tuc_hijo,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_composicion_tuc_iud';
		$this->codigo_procedimiento = "'AL_COMPTUC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_composicion_tuc);
		$this->var->add_param($cantidad);
		$this->var->add_param("'$opcional'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_tuc_hijo);
		$this->var->add_param($id_tipo_unidad_constructiva);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarComposicionTuc
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_composicion_tuc
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function EliminarComposicionTuc($id_composicion_tuc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_composicion_tuc_iud';
		$this->codigo_procedimiento = "'AL_COMPTUC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_composicion_tuc);
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
	 * Nombre de la función:	ValidarComposicionTuc
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_composicion_tuc
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function ValidarComposicionTuc($operacion_sql,$id_composicion_tuc,$cantidad,$opcional,$fecha_reg,$id_tuc_hijo,$id_tipo_unidad_constructiva)
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
				//Validar id_composicion_tuc - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_composicion_tuc");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_composicion_tuc", $id_composicion_tuc))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar cantidad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "cantidad", $cantidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar opcional - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("opcional");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "opcional", $opcional))
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

			//Validar id_tuc_hijo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tuc_hijo");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tuc_hijo", $id_tuc_hijo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_unidad_constructiva - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_unidad_constructiva");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_unidad_constructiva", $id_tipo_unidad_constructiva))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar opcional
			$check = array ("si","no");
			if(!in_array($opcional,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'opcional': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarComposicionTuc";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_composicion_tuc - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_composicion_tuc");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_composicion_tuc", $id_composicion_tuc))
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