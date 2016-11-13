<?php
/*
* Nombre de archivo:	    cls_DBTipoFormulario.php
* Propósito:				
* Fecha de Creación:		2010-12-20
* Autor:					Marcos A. Flores Valda
*/
class cls_DBTipoFormulario
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
	 * Nombre de la función:	ListarColumna
	 * Propósito:				Desplegar los registros de tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ListarTipoFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_tipo_formulario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_formulario_sel';
		$this->codigo_procedimiento = "'FL_TIPFOR_SEL'";
		
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
		$this->var->add_def_cols('id_tipo_formulario','int4');
		$this->var->add_def_cols('id_tipo_proceso','int4');
		$this->var->add_def_cols('id_usuario_reg','int4');
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('prioridad','int4');
		$this->var->add_def_cols('documento','varchar');		//crea el nodo para mostrarlo en el grid
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarColumna
	 * Propósito:				Contar los registros de tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ContarTipoFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_formulario_sel';
		$this->codigo_procedimiento = "'FL_TIPFOR_COUNT'";

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
	 * Nombre de la función:	InsertarColumna
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function InsertarTipoFormulario($id_tipo_proceso,$id_documento,$codigo,$nombre,$prioridad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_formulario_iud';
		$this->codigo_procedimiento = "'FL_TIPFOR_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param($id_documento);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
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
	 * Nombre de la función:	ModificarColumna
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ModificarTipoFormulario($id_tipo_formulario,$id_tipo_proceso,$id_documento,$codigo,$nombre,$prioridad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_formulario_iud';
		$this->codigo_procedimiento = "'FL_TIPFOR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_formulario);
		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param($id_documento);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
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
	 * Nombre de la función:	EliminarColumna
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function EliminarTipoFormulario($id_tipo_formulario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_formulario_iud';
		$this->codigo_procedimiento = "'FL_TIPFOR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_formulario);
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
	 * Nombre de la función:	ValidarColumna
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ValidarTipoFormulario($operacion_sql,$id_tipo_formulario,$id_tipo_proceso,$id_documento,$codigo,$nombre,$prioridad)
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
				//Validar id_columna - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_formulario");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_formulario", $id_tipo_formulario))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_tipo_planilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_proceso");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_proceso", $id_tipo_proceso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_documento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_documento", $id_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}
						
			//Validar formula - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar valor_defecto - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar prioridad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("prioridad");

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
			//Validar id_columna - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_formulario");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_formulario", $id_tipo_formulario))
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