<?php
/**
 * Nombre de la clase:	cls_DBTipoActivoCuenta
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla taf_tipo_activo_cuenta
 * Autor:				unknow
 * Fecha creacion:		
 */
class cls_DBContraCuenta
{
	//Variable que contiene la salida de la ejecuci�n de la funci�n
	
	var $salida;

	//Variable que contedr� la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecuci�n de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la funci�n a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBContraCuenta";

	//Matriz de par�metros de validaci�n de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la funci�n:	ListarTipoActivoCuenta
	 * Proposito:				Desplegar los registros de taf_contra_cuenta en funcionn de los par�metros del filtro
	 * Autor:					unknow
	 * Fecha de creacion:		
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */
	
	/***************************************************************************************************/
	function ListarContraCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_contra_cuenta_sel';
		$this->codigo_procedimiento = "'AF_CONCTA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_contra_cuenta','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('desc_regional','text');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('id_cuenta_titular','integer');
		$this->var->add_def_cols('desc_cuenta','text');
		$this->var->add_def_cols('id_cuenta_auxiliar','integer');
		$this->var->add_def_cols('desc_cuenta_aux','text');
		$this->var->add_def_cols('id_tipo_proceso','integer');
		$this->var->add_def_cols('desc_proceso','text');
		$this->var->add_def_cols('tipo_importe','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_usuario_reg','integer');
		//$this->var->add_def_cols('descripcion','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo "query:" .$this->query;
		//exit;
		return $res;
	}
	/**
	 * Nombre de la funci�n:	CountTipoActivoCuenta
	 * Prop�sito:				Contar los registros de taf_contra_cuenta 
	 * Autor:					
	 * Fecha de creaci�n:		
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */
	
	function CountContraCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_contra_cuenta_sel';
		$this->codigo_procedimiento = "'AF_CONCTA_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
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
	/*
	 * Nombre de la funci�n:	InsertarContraCuenta
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla taf_contra_cuenta
	 * Autor:				    
	 * Fecha de creacion:		
	 */
	function InsertarContraCuenta($id_contra_cuenta,$id_gestion,$id_regional,$id_cuenta,$id_cuenta_aux,$id_proceso,$id_importe)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_contra_cuenta_iud';
		$this->codigo_procedimiento = "'AF_CONCTA_INS'";
  
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_contra_cuenta);//af_id_contra_cuenta
		$this->var->add_param($id_gestion);//af_id_gestion 
		$this->var->add_param($id_regional);//af_id_regional
		$this->var->add_param($id_cuenta);//af_id_cuenta_titular
		$this->var->add_param($id_cuenta_aux);//af_id_cuenta_auxiliar
		$this->var->add_param($id_proceso);//af_id_tipo_proceso
		$this->var->add_param("'$id_importe'");//af_tipo_importe
		 
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo "query:" .$this->query;
		//exit;
		 
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ModificarContraCuenta
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla taf_contra_cuenta
	 * Autor:				    
	 * Fecha de creaci�n:		
	 */
	function ModificarContraCuenta($id_contra_cuenta,$id_gestion,$id_regional,$id_cuenta,$id_cuenta_aux,$id_proceso,$id_importe)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_contra_cuenta_iud';   
		$this->codigo_procedimiento = "'AF_CONCTA_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_contra_cuenta);//af_id_contra_cuenta
		$this->var->add_param($id_gestion);//af_id_gestion 
		$this->var->add_param($id_regional);//af_id_regional
		$this->var->add_param($id_cuenta);//af_id_cuenta_titular
		$this->var->add_param($id_cuenta_aux);//af_id_cuenta_auxiliar
		$this->var->add_param($id_proceso);//af_id_tipo_proceso
		$this->var->add_param("'$id_importe'");//af_tipo_importe
		
		 
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();     

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
     
		return $res;    
	}
	/*
	 * Nombre de la funci�n:	EliminarContraCuenta 
	 * Prop�sito:				Permite ejecutar la funcionde eliminacion de la tabla taf_contra_cuenta
	 * Autor:				    
	 * Fecha de creaci�n:		
	 */
	function EliminarContraCuenta($id_contra_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_contra_cuenta_iud';
		$this->codigo_procedimiento = "'AF_CONCTA_DEL'"; 
 
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_contra_cuenta);//af_id_contra_cuenta
		$this->var->add_param("NULL");//af_id_gestion 
		$this->var->add_param("NULL");//af_id_regional
		$this->var->add_param("NUll");//af_id_cuenta_titular
		$this->var->add_param("NUll");//af_id_cuenta_auxiliar
		$this->var->add_param("NUll");//af_id_tipo_proceso
		$this->var->add_param("NULL");//af_tipo_importe
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
}?>