<?php
/**
 * Nombre de la clase:	cls_DBRelacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_relacion
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-17 16:09:00
 */

 
class cls_DBRelacion
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
	 * Nombre de la función:	ListarRelacion
	 * Propósito:				Desplegar los registros de tsg_relacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-17 16:09:00
	 */
	function ListarRelacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$esquema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_relacion_sel';
		$this->codigo_procedimiento = "'SG_RELACO_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		$esquema=strtolower($esquema);
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
		$this->var->add_param("'$esquema'");
		//Carga la definición de columnas con sus tipos de datos
		
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('codigo','text');
		$this->var->add_def_cols('titulo','text');
		$this->var->add_def_cols('descripcion','text');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRelacion
	 * Propósito:				Contar los registros de tsg_relacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-17 16:09:00
	 */
	function ContarRelacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$esquema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_relacion_sel';
		$this->codigo_procedimiento = "'SG_RELACO_COUNT'";
		$esquema=strtolower($esquema);
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
		$this->var->add_param("'$esquema'");
		
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
	 * Nombre de la función:	InsertarRelacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_relacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-17 16:09:00
	 */
	function InsertarRelacion($id_relacion,$nombre,$codigo,$titulo,$descripcion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_relacion_iud';
		$this->codigo_procedimiento = "'SG_RELACO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$titulo'");
		$this->var->add_param("'$descripcion'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRelacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_relacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-17 16:09:00
	 */
	function ModificarRelacion($id_relacion,$nombre,$codigo,$titulo,$descripcion,$esquema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_relacion_iud';
		$this->codigo_procedimiento = "'SG_RELACO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$titulo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$esquema'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRelacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_relacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-17 16:09:00
	 */
	function EliminarRelacion($id_relacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_relacion_iud';
		$this->codigo_procedimiento = "'SG_RELACO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_relacion);
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
	 * Nombre de la función:	ValidarRelacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_relacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-17 16:09:00
	 */
	function ValidarRelacion($operacion_sql,$id_relacion,$nombre,$codigo,$titulo,$descripcion)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			

			//Validar nombre - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar titulo - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("titulo");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "titulo", $titulo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_relacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_relacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_relacion", $id_relacion))
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