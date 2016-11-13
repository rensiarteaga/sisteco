<?php
/*
* Nombre de archivo:	    cls_DBAtributo.php
* Propósito:				
* Fecha de Creación:		2010-12-27
* Autor:					Marcos A. Flores Valda
*/
 
class cls_DBAtributo
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
	function ListarAtributo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_sel';
		$this->codigo_procedimiento = "'FL_TIPATR_SEL'";
		
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
		$this->var->add_def_cols('id_atributo','int4');
		$this->var->add_def_cols('id_tipo_formulario','int4');
		$this->var->add_def_cols('tipo_field','varchar');
		$this->var->add_def_cols('tipo_datos','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('label','varchar');
		$this->var->add_def_cols('opcional','varchar');
		$this->var->add_def_cols('remoto','varchar');
		$this->var->add_def_cols('valor_defecto','text');
		$this->var->add_def_cols('id_action','int4');
		$this->var->add_def_cols('valores_combo','text');
		$this->var->add_def_cols('valor','varchar');
		$this->var->add_def_cols('display','varchar');
		$this->var->add_def_cols('id_usuario_reg','int4');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('nombre_action','varchar');		//crea el nodo para mostrarlo en el grid
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarColumna
	 * Propósito:				Contar los registros de tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ContarAtributo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_sel';
		$this->codigo_procedimiento = "'FL_TIPATR_COUNT'";

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
	function InsertarAtributo($id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display,$id_tipo_proceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_iud';
		$this->codigo_procedimiento = "'FL_TIPATR_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_formulario);
		$this->var->add_param("'$tipo_field'");
		$this->var->add_param("'$tipo_datos'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$label'");
		$this->var->add_param("'$opcional'");
		$this->var->add_param("'$remoto'");
		$this->var->add_param("'$valor_defecto'");
		$this->var->add_param($id_action);		
		$this->var->add_param("'$valores_combo'");
		$this->var->add_param("'$valor'");
		$this->var->add_param("'$display'");
		$this->var->add_param($id_tipo_proceso);
		
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
	function ModificarAtributo($id_atributo,$id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_iud';
		$this->codigo_procedimiento = "'FL_TIPATR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_atributo);
		$this->var->add_param($id_tipo_formulario);		
		$this->var->add_param("'$tipo_field'");
		$this->var->add_param("'$tipo_datos'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$label'");
		$this->var->add_param("'$opcional'");		
		$this->var->add_param("'$remoto'");
		$this->var->add_param("'$valor_defecto'");
		$this->var->add_param($id_action);
		$this->var->add_param("'$valores_combo'");
		$this->var->add_param("'$valor'");
		$this->var->add_param("'$display'");
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
	 * Nombre de la función:	EliminarColumna
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function EliminarAtributo($id_atributo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_atributo_iud';
		$this->codigo_procedimiento = "'FL_TIPATR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_atributo);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarColumna
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ValidarAtributo($operacion_sql,$id_atributo,$id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display)
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
				$tipo_dato->set_Columna("id_atributo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_atributo", $id_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_tipo_planilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_formulario");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_formulario", $id_tipo_formulario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar valor_defecto - tipo numeric
			$tipo_dato ->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_datos");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_datos", $tipo_datos))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_field");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_field", $tipo_field))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("label");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "label", $label))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("opcional");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "opcional", $opcional))
			{
				$this->salida = $valid->salida;
				return false;
			}
			/*
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_action");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_action", $id_action))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("remoto");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "remoto", $remoto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("valor_defecto");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "valor_defecto", $valor_defecto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("valores_combo");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "valores_combo", $valores_combo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("valor");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "valor", $valor))
			{				
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("display");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "display", $display))
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
			$tipo_dato->set_Columna("id_atributo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_atributo", $id_atributo))
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