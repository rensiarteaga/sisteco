<?php
/**
 * Nombre de la Clase:	cls_DBCompensacion
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tkp_compensacion
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		11-05-2011
 *
 */
class cls_DBCompensacion
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
	var $nombre_archivo = "cls_DBCompensacion.php";

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
	 * Nombre de la función:	ListarCompensacion
	 * Propósito:				Desplegar los registros de tkp_compensacion en función de los parámetros del filtro
	 * Autor:					Fernando Prudencio Cardona
	 * Fecha de creación:		11-05-2011
	 *
	 */
	function ListarCompensacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_compensacion_sel';
		$this->codigo_procedimiento = "'KP_COMPEN_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_compensacion','integer');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_fin','date');	
		$this->var->add_def_cols('compensado','varchar');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('total_dias','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('dias_tomados','numeric');
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarCompensacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Fernando Prudencio Cardona
	 * Fecha de creación:		11-05-2011
	 *
	 */
	function ContarCompensacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_compensacion_sel';
		$this->codigo_procedimiento = "'KP_COMPEN_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

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
	 * Nombre de la función:	InsertarCompensacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_compensacion
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		11-05-2011
	 * Descripción:             
	
	 */
	function InsertarCompensacion($id_compensacion,$fecha_inicio,$fecha_fin,$compensado,$id_empleado,$total_dias)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_compensacion_iud';
		$this->codigo_procedimiento = "'KP_COMPEN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$compensado'");
		$this->var->add_param($id_empleado);
		$this->var->add_param($total_dias);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCompensacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_compensacion
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		11-05-2011
	 */
	function ModificarCompensacion($id_compensacion,$fecha_inicio,$fecha_fin,$compensado,$id_empleado,$total_dias)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_compensacion_iud';
		$this->codigo_procedimiento = "'KP_COMPEN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_compensacion);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$compensado'");
		$this->var->add_param($id_empleado);
		$this->var->add_param($total_dias);
	
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCompensacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_compensacion
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		11-05-2011
	 */
	function EliminarCompensacion($id_compensacion,$id_empleado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_compensacion_iud';
		$this->codigo_procedimiento = "'KP_COMPEN_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_compensacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado);
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
	 * Nombre de la función:	ValidarCompensacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_compensacion
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		11-05-2011
	 */
	function ValidarCompensacion($operacion_sql,$id_compensacion,$fecha_inicio,$fecha_fin,$compensado,$id_empleado,$total_dias)
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
				//Validar id_Contrato - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_compensacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_compensacion", $id_compensacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			
						
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_inicio");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_inicio", $fecha_inicio))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_fin");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_fin", $fecha_fin))
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
			$tipo_dato->set_Columna("id_compensacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_compensacion", $id_compensacion))
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