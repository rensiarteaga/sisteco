<?php
class cls_DBHorario
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

	var $nombre_archivo = "cls_DBHorario.php";

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
	 *
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_parametros_generales
	 * @param unknown_type $nombre_atributo
	 * @param unknown_type $valor_atributo
	 * @param unknown_type $descripcion
	 * @return unknown
	 */
	function ListarHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_horario_sel';
		$this->codigo_procedimiento = "'CA_HOR_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_codigo_horario','integer');
		$this->var->add_def_cols('entra_lunes','time');
		$this->var->add_def_cols('sale_lunes','time');
		$this->var->add_def_cols('entra_martes','time');
		$this->var->add_def_cols('sale_martes','time');
		$this->var->add_def_cols('entra_miercoles','time');
		$this->var->add_def_cols('sale_miercoles','time');
		$this->var->add_def_cols('entra_jueves','time');
		$this->var->add_def_cols('sale_jueves','time');
		$this->var->add_def_cols('entra_viernes','time');
		$this->var->add_def_cols('sale_viernes','time');
		$this->var->add_def_cols('entra_sabado','time');
		$this->var->add_def_cols('sale_sabado','time');
		$this->var->add_def_cols('entra_domingo','time');
		$this->var->add_def_cols('sale_domingo','time');
		$this->var->add_def_cols('min_tolerancia_entra','time');
		$this->var->add_def_cols('hora_extra_lunes','time');
		$this->var->add_def_cols('hora_extra_martes','time');
		$this->var->add_def_cols('hora_extra_miercoles','time');
		$this->var->add_def_cols('hora_extra_jueves','time');
		$this->var->add_def_cols('hora_extra_viernes','time');
		$this->var->add_def_cols('hora_extra_sabado','time');
		$this->var->add_def_cols('hora_extra_domingo','time');
		$this->var->add_def_cols('id_grupo_horario','integer');
		$this->var->add_def_cols('desc_horario','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}


/**
 * 
 * 
 *
 * @param unknown_type $cant
 * @param unknown_type $puntero
 * @param unknown_type $sortcol
 * @param unknown_type $sortdir
 * @param unknown_type $criterio_filtro
 * @param unknown_type $id_parametros_generales
 * @param unknown_type $nombre_atributo
 * @param unknown_type $valor_atributo
 * @param unknown_type $descripcion
 * @return unknown
 */
	function ContarListaHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_horario_sel';
		$this->codigo_procedimiento = "'CA_HOR_SEL_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

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

	/*
	**********************************************************
	Nombre de la función:	CrearHorario()

	Propósito:				Se utiliza esta función para insertar un nuevo Horario en la base de datos
	Parámetros:				$descripcion	-->	desc 
	&obs --> observaciones pertinentes
	Valores de Retorno:		 0	-->	Retorna el nombre del archivo
	-1	--> Indica que se produjo un error y no se pudo subir el archivo al servidor
	**********************************************************
	*/
	function CrearHorario($id_codigo_horario,$entra_lunes,$sale_lunes,$entra_martes,$sale_martes,$entra_miercoles,$sale_miercoles,$entra_jueves,$sale_jueves,$entra_viernes,$sale_viernes,$entra_sabado,$sale_sabado,$entra_domingo,$sale_domingo,$min_tolerancia_entra,$hora_extra_lunes,$hora_extra_martes,$hora_extra_miercoles,$hora_extra_jueves,$hora_extra_viernes,$hora_extra_sabado,$hora_extra_domingo,$id_grupo_horario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_horario_iud';
		$this->codigo_procedimiento = "'CA_HOR_INS'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_codigo_horario
		$this->var->add_param("'$entra_lunes'");//entra_lunes
		$this->var->add_param("'$sale_lunes'");//sale_lunes
		$this->var->add_param("'$entra_martes'");//entra_martes
		$this->var->add_param("'$sale_martes'");//sale_martes
		$this->var->add_param("'$entra_miercoles'");//entra_miercoles
		$this->var->add_param("'$sale_miercoles'");//sale_miercoles
		$this->var->add_param("'$entra_jueves'");//entra_jueves
		$this->var->add_param("'$sale_jueves'");//sale_jueves
		$this->var->add_param("'$entra_viernes'");//entra_viernes
		$this->var->add_param("'$sale_viernes'");//sale_viernes
		$this->var->add_param("'$entra_sabado'");//entra_sabado
		$this->var->add_param("'$sale_sabado'");//sale_sabado
		$this->var->add_param("'$entra_domingo'");//entra_domingo
		$this->var->add_param("'$sale_domingo'");//sale_domingo
		$this->var->add_param("'$min_tolerancia_entra'");//min_tolerancia_entra
		$this->var->add_param("'$hora_extra_lunes'");//hora_extra_lunes
        $this->var->add_param("'$hora_extra_martes'");//hora_extra_martes
        $this->var->add_param("'$hora_extra_miercoles'");//hora_extra_miercoles
        $this->var->add_param("'$hora_extra_jueves'");//hora_extra_jueves
        $this->var->add_param("'$hora_extra_viernes'");//hora_extra_viernes
        $this->var->add_param("'$hora_extra_sabado'");//hora_extra_sabado
        $this->var->add_param("'$hora_extra_domingo'");//hora_extra_domingo
		$this->var->add_param("'$id_grupo_horario'");//id_grupo_horario
        				
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}


	
	function  EliminarHorario($id_codigo_horario)
	{

		$this->salida="";
		$this->nombre_funcion = 'casis.f_tca_horario_iud';
		$this->codigo_procedimiento = "'CA_HOR_DEL'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("'$id_codigo_horario'");//$id_codigo_horario
		$this->var->add_param("NULL");//entra_lunes
		$this->var->add_param("NULL");//sale_lunes
		$this->var->add_param("NULL");//entra_martes
		$this->var->add_param("NULL");//sale_martes
		$this->var->add_param("NULL");//entra_miercoles
		$this->var->add_param("NULL");//sale_miercoles
		$this->var->add_param("NULL");//entra_jueves
		$this->var->add_param("NULL");//sale_jueves
		$this->var->add_param("NULL");//entra_viernes
		$this->var->add_param("NULL");//sale_viernes
		$this->var->add_param("NULL");//entra_sabado
		$this->var->add_param("NULL");//sale_sabado
		$this->var->add_param("NULL");//entra_domingo
		$this->var->add_param("NULL");//sale_domingo
		$this->var->add_param("NULL");//min_tolerancia_entra
		$this->var->add_param("NULL");//hora_extra_lunes
        $this->var->add_param("NULL");//hora_extra_martes
        $this->var->add_param("NULL");//hora_extra_miercoles
        $this->var->add_param("NULL");//hora_extra_jueves
        $this->var->add_param("NULL");//hora_extra_viernes
        $this->var->add_param("NULL");//hora_extra_sabado
        $this->var->add_param("NULL");//hora_extra_domingo
		$this->var->add_param("NULL");//id_grupo_horario
				
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		$this->query = $this->var->query;
	
		return $res;
	}


	function  ModificarHorario($id_codigo_horario,$entra_lunes,$sale_lunes,$entra_martes,$sale_martes,$entra_miercoles,$sale_miercoles,$entra_jueves,$sale_jueves,$entra_viernes,$sale_viernes,$entra_sabado,$sale_sabado,$entra_domingo,$sale_domingo,$min_tolerancia_entra,$hora_extra_lunes,$hora_extra_martes,$hora_extra_miercoles,$hora_extra_jueves,$hora_extra_viernes,$hora_extra_sabado,$hora_extra_domingo,$id_grupo_horario)
	{
		$this->salida="";
		$this->nombre_funcion = 'casis.f_tca_horario_iud';
		$this->codigo_procedimiento = "'CA_HOR_UPD'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("'$id_codigo_horario'");//id_codigo_horario
		$this->var->add_param("'$entra_lunes'");//entra_lunes
		$this->var->add_param("'$sale_lunes'");//sale_lunes
		$this->var->add_param("'$entra_martes'");//entra_martes
		$this->var->add_param("'$sale_martes'");//sale_martes
		$this->var->add_param("'$entra_miercoles'");//entra_miercoles
		$this->var->add_param("'$sale_miercoles'");//sale_miercoles
		$this->var->add_param("'$entra_jueves'");//entra_jueves
		$this->var->add_param("'$sale_jueves'");//sale_jueves
		$this->var->add_param("'$entra_viernes'");//entra_viernes
		$this->var->add_param("'$sale_viernes'");//sale_viernes
		$this->var->add_param("'$entra_sabado'");//entra_sabado
		$this->var->add_param("'$sale_sabado'");//sale_sabado
		$this->var->add_param("'$entra_domingo'");//entra_domingo
		$this->var->add_param("'$sale_domingo'");//sale_domingo
		$this->var->add_param("'$min_tolerancia_entra'");//min_tolerancia_entra
		$this->var->add_param("'$hora_extra_lunes'");//hora_extra_lunes
        $this->var->add_param("'$hora_extra_martes'");//hora_extra_martes
        $this->var->add_param("'$hora_extra_miercoles'");//hora_extra_miercoles
        $this->var->add_param("'$hora_extra_jueves'");//hora_extra_jueves
        $this->var->add_param("'$hora_extra_viernes'");//hora_extra_viernes
        $this->var->add_param("'$hora_extra_sabado'");//hora_extra_sabado
        $this->var->add_param("'$hora_extra_domingo'");//hora_extra_domingo
		$this->var->add_param("'$id_grupo_horario'");//id_grupo_horario
	    		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_parametros_generales
	 * @param unknown_type $nombre_atributo
	 * @param unknown_type $valor_atributo
	 * @param unknown_type $descripcion
	 * @return unknown
	 */
	function ValidarHorario($operacion_sql,$id_codigo_horario,$entra_lunes,$sale_lunes,$entra_martes,$sale_martes,$entra_miercoles,$sale_miercoles,$entra_jueves,$sale_jueves,$entra_viernes,$sale_viernes,$entra_sabado,$sale_sabado,$entra_domingo,$sale_domingo,$min_tolerancia_entra,$hora_extra_lunes,$hora_extra_martes,$hora_extra_miercoles,$hora_extra_jueves,$hora_extra_viernes,$hora_extra_sabado,$hora_extra_domingo,$id_grupo_horario)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)

		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();

		//Ejecuta la validación por el tipo de operación
		switch ($operacion_sql)
		{
			case 'insert' :
				
					/*******************************Verificación de datos****************************/
					//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
					//Se valida todas las columnas de la tabla
							
									
				//Validar entra_lunes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_lunes");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_lunes", $entra_lunes))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_lunes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_lunes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_lunes", $sale_lunes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar entra_martes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_martes");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_martes", $entra_martes))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_martes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_martes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_martes", $sale_martes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar entra_miercoles - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_miercoles");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_miercoles", $entra_miercoles))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_miercoles - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_miercoles");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_miercoles", $sale_miercoles))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar entra_jueves - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_jueves");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_jueves", $entra_jueves))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_jueves - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_jueves");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_jueves", $sale_jueves))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar entra_viernes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_viernes");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_viernes", $entra_viernes))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_viernes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_viernes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_viernes", $sale_viernes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
                
				//Validar entra_sabado - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_sabado");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_sabado", $entra_sabado))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_sabado - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_sabado");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_sabado", $sale_sabado))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}  

				//Validar entra_domingo - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_domingo");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_domingo", $entra_domingo))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_domingo - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_domingo");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_domingo", $sale_domingo))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar min_tolerancia_entra - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("min_tolerancia_entra");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "min_tolerancia_entra", $min_tolerancia_entra))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_lunes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_lunes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_lunes", $hora_extra_lunes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}	
				
				//Validar hora_extra_martes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_martes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_martes", $hora_extra_martes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_miercoles - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_miercoles");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_miercoles", $hora_extra_miercoles))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_jueves - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_jueves");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_jueves", $hora_extra_jueves))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_viernes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_viernes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_viernes", $hora_extra_viernes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_sabado - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_sabado");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_sabado", $hora_extra_sabado))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_domingo - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_domingo");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_domingo", $hora_extra_domingo))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}		

				//Validar id_grupo_horario - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_grupo_horario");	
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);				
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo_horario", $id_grupo_horario))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}

				
				//Validación exitosa
				return true;				
				break;
				
			case 'update' :
				
					/*******************************Verificación de datos****************************/
					//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
					//Se valida todas las columnas de la tabla
				
					
				//Validar id_codigo_horario - tipo entero
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_codigo_horario");	
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);				
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_codigo_horario", $id_codigo_horario))					
				//if(!$valid->verifica_dato($this->matriz_validacion[0], "id_parametro_general", $id_parametro_general))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar entra_lunes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_lunes");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_lunes", $entra_lunes))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_lunes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_lunes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_lunes", $sale_lunes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar entra_martes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_martes");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_martes", $entra_martes))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_martes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_martes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_martes", $sale_martes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar entra_miercoles - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_miercoles");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_miercoles", $entra_miercoles))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_miercoles - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_miercoles");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_miercoles", $sale_miercoles))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar entra_jueves - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_jueves");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_jueves", $entra_jueves))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_jueves - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_jueves");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_jueves", $sale_jueves))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar entra_viernes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_viernes");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_viernes", $entra_viernes))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_viernes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_viernes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_viernes", $sale_viernes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
                
				//Validar entra_sabado - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_sabado");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_sabado", $entra_sabado))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_sabado - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_sabado");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_sabado", $sale_sabado))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}  

				//Validar entra_domingo - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("entra_domingo");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "entra_domingo", $entra_domingo))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar sale_domingo - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("sale_domingo");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "sale_domingo", $sale_domingo))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar min_tolerancia_entra - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("min_tolerancia_entra");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "min_tolerancia_entra", $min_tolerancia_entra))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_lunes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_lunes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_lunes", $hora_extra_lunes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}	
				
				//Validar hora_extra_martes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_martes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_martes", $hora_extra_martes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_miercoles - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_miercoles");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_miercoles", $hora_extra_miercoles))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_jueves - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_jueves");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_jueves", $hora_extra_jueves))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_viernes - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_viernes");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_viernes", $hora_extra_viernes))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_sabado - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_sabado");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_sabado", $hora_extra_sabado))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar hora_extra_domingo - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora_extra_domingo");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_extra_domingo", $hora_extra_domingo))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}		

				//Validar id_grupo_horario - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_grupo_horario");	
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);				
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo_horario", $id_grupo_horario))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
								
				//Validación exitosa
				return true;
				break;


			case 'delete':
				break;
			default:
				{
					return false;
				}
				break;
		}

	}
	


}
?>