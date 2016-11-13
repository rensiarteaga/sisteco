<?php
/**
 * Nombre de la Clase:	cls_DBTipoContrato
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tkp_tipo_contrato
 * Autor:				Fernando Prudencio Cardona	
 * Fecha creación:		09-08-2010
 *
 */
class cls_DBTipoContrato
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
	var $nombre_archivo = "cls_DBTipoContrato.php";

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
	 * Nombre de la función:	ListarTipoContrato
	 * Propósito:				Desplegar los registros de tkp_tipo_contrato en función de los parámetros del filtro
	 * Autor:					Fernando Prudencio
	 * Fecha de creación:		09-08-2010
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarTipoContrato($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_tipo_contrato_sel';
		$this->codigo_procedimiento = "'KP_TIPCON_SEL'";

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
		$this->var->add_def_cols('id_tipo_contrato','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('usuario_reg','varchar');
        //Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarListaTipoContrato
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Fernando Prudencio 
	 * Fecha de creación:		09-08-2010
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarListaTipoContrato($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_tipo_contrato_sel';
		$this->codigo_procedimiento = "'KP_TIPCON_COUNT'";

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
	 * Nombre de la función:	InsertarTipoContrato
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_tipo_contrato
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		2007-10-18 09:06:56
	 * Fecha ultima de mod:     20/07/2009
	 * Descripción:             Se añadio los atributos fecha_reg, estado_reg
	
	 */
	function InsertarTipoContrato($id_tipo_contrato,$codigo,$nombre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_tipo_contrato_iud';
		$this->codigo_procedimiento = "'KP_TIPCON_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
     //  echo $this->query; exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoContrato
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_tipo_contrato
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2010-08-10 09:06:56
	 */
	function ModificarTipoContrato($id_tipo_contrato,$codigo,$nombre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_tipo_contrato_iud';
		$this->codigo_procedimiento = "'KP_TIPCON_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_contrato);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");	

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoContrato
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_tipo_contrato
	 * Autor:				    Fernando Prudencio 
	 * Fecha de creación:		2010-08-10 09:06:56
	 */
	function EliminarTipoContrato($id_tipo_contrato)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_tipo_contrato_iud';
		$this->codigo_procedimiento = "'KP_TIPCON_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_contrato);
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
	 * Nombre de la función:	ValidarHorario
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_horario
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2010-08-10 09:06:56
	 */
	function ValidarTipoContrato($operacion_sql,$id_tipo_contrato,$codigo,$nombre)
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
				//Validar id_horario - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_contrato");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_contrato", $id_tipo_contrato))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
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
			$tipo_dato->set_Columna("id_tipo_contrato");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_contrato", $id_tipo_contrato))
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