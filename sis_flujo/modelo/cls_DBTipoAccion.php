<?php
/**
 * Nombre de la clase:	cls_DBTipoAccion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_tipo_accion
 * Autor:				Silvia Ximena Ortiz Fernández
 * Fecha creación:		2010-12-22 17:04:51
 */

 
/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
*
* */

class cls_DBTipoAccion
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
	 * Nombre de la función:	ListarTipoAccion
	 * Propósito:				Desplegar los registros de tfl_tipo_accion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-12-23 09:50:51
	 */
	
	
	function ListarTipoAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_accion_sel';
		$this->codigo_procedimiento = "'FL_TIPACC_SEL'";

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
		$this->var->add_def_cols('id_tipo_accion','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('empleado_sel','varchar');
		$this->var->add_def_cols('criterio','varchar');
		$this->var->add_def_cols('tipo_aplicacion','varchar');

                            
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoAccion
	 * Propósito:				Contar los registros de tfl_tipo_accion
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2010-12-23 09:59:51
	 */
	function ContarTipoAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_accion_sel';
		$this->codigo_procedimiento = "'FL_TIPACC_COUNT'";

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
	 * Nombre de la función:	InsertarTipoAccion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfl_tipo_accion
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2010-12-23 10:17:51
	 */
	
	function InsertarTipoAccion($codigo, $nombre, $empleado_sel, $criterio, $tipo_aplicacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_accion_iud';
		$this->codigo_procedimiento = "'FL_TIPACC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$empleado_sel'");
		$this->var->add_param("'$criterio'");
		$this->var->add_param("'$tipo_aplicacion'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
       
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoAccion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfl_tipo_nod
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2010-12-23 10:16:51
	 */
	function ModificarTipoAccion($id_tipo_accion, $codigo, $nombre, $empleado_sel, $criterio, $tipo_aplicacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_accion_iud';
		$this->codigo_procedimiento = "'FL_TIPACC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$id_tipo_accion'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$empleado_sel'");
		$this->var->add_param("'$criterio'");
		$this->var->add_param("'$tipo_aplicacion'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
      /* echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoAccion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_tipo_accion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:34:51
	 */
	function EliminarTipoAccion($id_tipo_accion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_accion_iud';
		$this->codigo_procedimiento = "'FL_TIPACC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_accion);
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
	 * Nombre de la función:	ValidarTipoAccion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tipo_accion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:34:51
	 */
	function ValidarTipoAccion($operacion_sql, $id_tipo_accion, $codigo, $nombre, $empleado_sel, $criterio, $tipo_aplicacion)
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
				//Validar id_tipo_accion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_accion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_accion", $id_tipo_accion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false; 
			}

			//Validar empleado_sel - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("empleado_sel");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "empleado_sel", $empleado_sel))
			{
				$this->salida = $valid->salida;
				return false; 
			}
			
			//Validar criterio- tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("criterio");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "criterio", $criterio))
			{
				$this->salida = $valid->salida;
				return false; 
			}
			
			//Validar nombre - tipo_aplicacion
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_aplicacion");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_aplicacion", $tipo_aplicacion))
			{
				$this->salida = $valid->salida;
				return false; 
			}
			
			
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_accion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_accion", $id_tipo_accion))
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