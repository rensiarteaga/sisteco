<?php
/**
 * Nombre de la Clase:	cls_DBAuxiliar
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tfl_Auxiliar
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		10-02-2011
 *
 */
class cls_DBAuxiliar
{
	//Variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;
	
	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecución de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la función a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBAuxiliar.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los parámetro de validación de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarAuxiliar
	 * Propósito:				Desplegar los registros de tfl_auxiliar en función de los parámetros del filtro
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		10-02-2011
	 *
	 */
	function ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_auxiliar_sel';
		$this->codigo_procedimiento = "'FL_AUXILI_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('id_uo','integer');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('login','varchar');
		$this->var->add_def_cols('id_persona','integer');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarAuxiliar
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Fernando Prudencio Cardona
	 * Fecha de creación:		10-02-2011
	 *
	 */
	function ContarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_auxiliar_sel';
		$this->codigo_procedimiento = "'FL_AUXILI_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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
	 * Nombre de la función:	InsertarAuxiliar
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_auxiliar
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		10-02-2011
	 * 
	
	 */
	function InsertarAuxiliar($id_auxiliar,$id_uo,$id_usuario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_auxiliar_iud';
		$this->codigo_procedimiento = "'FL_AUXILI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_uo);
		$this->var->add_param($id_usuario);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarAuxiliar
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfl_auxiliar
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		10-02-2011
	 */
	function ModificarAuxiliar($id_auxiliar,$id_uo,$id_usuario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_auxiliar_iud';
		$this->codigo_procedimiento = "'FL_AUXILI_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param($id_uo);
		$this->var->add_param($id_usuario);
				
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarAuxiliar
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_auxiliar
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		10-02-2011
	 */
	function EliminarAuxiliar($id_auxiliar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_auxiliar_iud';
		$this->codigo_procedimiento = "'FL_AUXILI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_auxiliar);
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
	 * Nombre de la función:	ValidarAuxiliar
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tfl_auxiliar
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		10-02-2011
	 */
	function ValidarAuxiliar($operacion_sql,$id_auxiliar,$id_uo,$id_usuario)
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
				//Validar id_auxiliar - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_auxiliar");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_auxiliar", $id_auxiliar))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_uo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_uo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_uo", $id_uo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			//Validar id_usuario - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_usuario");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario", $id_usuario))
				{
					$this->salida = $valid->salida;
					return false;
				}	
			
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_auxiliar");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_auxiliar", $id_auxiliar))
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
	
}
?>