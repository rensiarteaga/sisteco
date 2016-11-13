<?php
/**
 * Nombre de la Clase:	cls_DBClasificadorRetenciones
 * Prop�sito:			Permite ejecutar la funcionalidad de la tabla tkp_clasificador_retenciones
 * Autor:				
 * Fecha creaci�n:		21-06-2014
 *
 */
class cls_DBClasificadorRetenciones
{
	//Variable que contiene la salida de la ejecuci�n de la funci�n
	//si la funci�n tuvo error (false), salida contendr� el mensaje de error
	//si la funci�n no tuvo error (true), salida contendr� el resultado, ya sea un conjunto de datos o un mensaje de confirmaci�n
	var $salida;
	
	//Variable que contedr� la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecuci�n de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la funci�n a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBClasificadorRetenciones.php";

	//Matriz de par�metros de validaci�n de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificar�n o nofe
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los par�metro de validaci�n de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la funci�n:	ListarClasificadorRetenciones
	 * Prop�sito:				Desplegar los registros de tkp_clasificador_retenciones en funci�n de los par�metros del filtro
	 * Autor:					
	 * Fecha de creaci�n:		21-06-2014
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
	function ListarClasificadorRetenciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_clasificador_retenciones_sel';
		$this->codigo_procedimiento = "'KP_CLARET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_clasificador_retenciones','int4');
		//$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('nombre','varchar');
		/*$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');*/
		$this->var->add_def_cols('id_tipo_columna','int4');
		$this->var->add_def_cols('desc_tipo_columna','varchar');
		$this->var->add_def_cols('codigo','varchar');

		
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('usuario_reg','varchar');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	//	echo $this->query; exit;
		return $res;
	}

	/**
	 * Nombre de la funci�n:	ContarListaClasificadorRetenciones
	 * Prop�sito:				Contar el total de registros desplegados en funci�n de los par�metros de filtro
	 * Autor:					
	 * Fecha de creaci�n:		21-06-2014
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
	function ContarClasificadorRetenciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_clasificador_retenciones_sel';
		$this->codigo_procedimiento = "'KP_CLARET_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;

		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	

	
	
	/**
	 * Nombre de la funci�n:	InsertarClasificadorRetenciones
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tkp_clasificador_retenciones
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 * Fecha ultima de mod:     20/07/2009
	 * Descripci�n:             Se a�adio los atributos fecha_reg, estado_reg
	
	 */
	function InsertarClasificadorRetenciones($id_clasificador_retenciones,$nombre,$id_tipo_columna,$codigo,$estado_reg
	
	)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_clasificador_retenciones_iud';
		$this->codigo_procedimiento = "'KP_CLARET_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		//$this->var->add_param($id_institucion);
		$this->var->add_param("'$nombre'");
		$this->var->add_param($id_tipo_columna);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$estado_reg'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarClasificadorRetenciones
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tkp_clasificador_retenciones
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function ModificarClasificadorRetenciones($id_clasificador_retenciones,$nombre,$id_tipo_columna,$codigo,$estado_reg
	
	)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_clasificador_retenciones_iud';
		$this->codigo_procedimiento = "'KP_CLARET_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_clasificador_retenciones);
		//$this->var->add_param($id_institucion);
		$this->var->add_param("'$nombre'");
		$this->var->add_param($id_tipo_columna);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$estado_reg'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query ;
		exit();*/

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarClasificadorRetenciones
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tkp_clasificador_retenciones
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function EliminarClasificadorRetenciones($id_clasificador_retenciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_clasificador_retenciones_iud';
		$this->codigo_procedimiento = "'KP_CLARET_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_clasificador_retenciones);
		//$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarClasificadorRetenciones
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tkp_clasificador_retenciones
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-18 09:06:56
	 */
	function ValidarClasificadorRetenciones($operacion_sql,$id_clasificador_retenciones,$id_institucion,$id_persona,$id_tipo_columna,$codigo,$estado_reg)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validaci�n por el tipo de operaci�n
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_clasificador_retenciones - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_clasificador_retenciones");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clasificador_retenciones", $id_clasificador_retenciones))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

		

			//Validar codigo_clasificador_retenciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
		
			
			
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_clasificador_retenciones - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_clasificador_retenciones");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clasificador_retenciones", $id_clasificador_retenciones))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validaci�n exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	
	
}
?>