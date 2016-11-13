<?php
/**
 * Nombre de la clase:	cls_DBTipoNodo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_tipo_nodo
 * Autor:				Ariel Ayaviri Omonte
 * Fecha creación:		2010-12-22 17:04:51
 */

 
/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
*
* */
class cls_DBTipoNodoEmpleado
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
	 * Nombre de la función:	ListarTipoNodoEmpleado
	 * Propósito:				Desplegar los registros de tfl_tipo_nodo_empleado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2011-01-04 18:40:51
	 */
	
	function ListarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_empleado_sel';
		$this->codigo_procedimiento = "'FL_TINOEM_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_nodo_empleado','int4');
		$this->var->add_def_cols('id_tipo_nodo','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('criterio_condicion','varchar');
		$this->var->add_def_cols('prioridad','int4');
		$this->var->add_def_cols('seguimiento','varchar');
		
		$this->var->add_def_cols('id_usuario_reg','int4');
		$this->var->add_def_cols('estado_reg','varchar');		
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('desc_persona','text');
		
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoNodoEmpleado
	 * Propósito:				Contar los registros de tfl_tipo_nod_empelado
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-01-04 18:40:51
	 */
	function ContarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_empleado_sel';
		$this->codigo_procedimiento = "'FL_TINOEM_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		
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
	 * Nombre de la función:	InsertarTipoNodoEmpleado
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfl_tipo_nodo_empleado
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-01-04 18:41:51
	 */
	
	function InsertarTipoNodoEmpleado($id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_empleado_iud';
		$this->codigo_procedimiento = "'FL_TINOEM_INS'"; 

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_nodo);
		$this->var->add_param($id_empleado);		
		$this->var->add_param("'$criterio_condicion'");		
		$this->var->add_param("'$seguimiento'");		
		$this->var->add_param($prioridad);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoNodoEmpleado
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfl_tipo_nod
	 * Autor:				    Ariel Ayaviri Omonte
	 * Fecha de creación:		2010-12-23 10:16:51
	 */
	function ModificarTipoNodoEmpleado($id_tipo_nodo_empleado,$id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_empleado_iud';
		$this->codigo_procedimiento = "'FL_TINOEM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_nodo_empleado);
		$this->var->add_param($id_tipo_nodo);
		$this->var->add_param($id_empleado);		
		$this->var->add_param("'$criterio_condicion'");		
		$this->var->add_param("'$seguimiento'");		
		$this->var->add_param($prioridad);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
     
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoNodoEmpleado
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_tipo_nodo_empleado
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-01-04 18:52:51
	 */
	function EliminarTipoNodoEmpleado($id_tipo_nodo_empleado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_nodo_empleado_iud';
		$this->codigo_procedimiento = "'FL_TINOEM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_nodo_empleado);
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
	 * Nombre de la función:	ValidarTipoNodoEmpleado
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tfl_tipo_nodo_empelado
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-01-04 18:54:51
	 */
	function ValidarTipoNodoEmpleado($operacion_sql,$id_tipo_nodo_empleado,$id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad)
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
				//Validar id_tipo_adq - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_nodo_empleado");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_nodo_empleado", $id_tipo_nodo_empleado))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_nodo");
			$tipo_dato->set_MaxLength(250);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_nodo", $id_tipo_nodo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empleado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empelado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar criterio_condicion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("criterio_condicion");
			$tipo_dato->set_MaxLength(255);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "criterio_condicion", $criterio_condicion))
			{
				$this->salida = $valid->salida;
				return false;
			}


		//Validar seguimiento - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("seguimiento");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "seguimiento", $seguimiento))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
		//Validar prioridad
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("prioridad");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "prioridad", $prioridad))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_nodo_empleado");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_nodo_empleado", $id_tipo_nodo_empleado))
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