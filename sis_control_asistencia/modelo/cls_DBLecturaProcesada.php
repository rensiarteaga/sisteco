<?php
class cls_DBLecturaProcesada
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

	var $nombre_archivo = "cls_DBLecturaProcesada.php";

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
	function ListarLecturaProcesada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_procesada_sel';
		$this->codigo_procedimiento = "'CA_LEC_PROC_SEL'";

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
		$this->var->add_def_cols('id_lectura_procesada','integer');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('horas_trabajadas','time');
		$this->var->add_def_cols('tipo_permiso','varchar');
		$this->var->add_def_cols('aprobado','varchar');
		$this->var->add_def_cols('especial','varchar');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('total_horas_trabajadas','time');
		$this->var->add_def_cols('horas_no_trab_con_permiso','time');
		$this->var->add_def_cols('horas_no_trab_sin_permiso','time');
		$this->var->add_def_cols('horas_extras','time');
		$this->var->add_def_cols('desc_empleado','text');
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
	function ContarListaLecturaProcesada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_procesada_sel';
		$this->codigo_procedimiento = "'CA_LEC_PROC_SEL_COUNT'";

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
		//echo $this->query;
		//exit;
		//Retorna el resultado de la ejecución
		return $res;
	}

	/*
	**********************************************************
	Nombre de la función:	CrearLecturaProcesada()

	Propósito:				Se utiliza esta función para insertar una nueva Lectura Procesada en la base de datos
	Parámetros:				$descripcion	-->	desc 
	&obs --> observaciones pertinentes
	Valores de Retorno:		 0	-->	Retorna el nombre del archivo
	-1	--> Indica que se produjo un error y no se pudo subir el archivo al servidor
	**********************************************************
	*/
	function CrearLecturaProcesada($id_lectura_procesada,$fecha,$horas_trabajadas,$tipo_permiso,$aprobado,$especial,$observaciones,$id_empleado,$total_horas_trabajadas,$horas_no_trab_con_permiso,$horas_no_trab_sin_permiso,$horas_extras)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_procesada_iud';
		$this->codigo_procedimiento = "'CA_LEC_PROC_INS'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_lectura_procesada
		$this->var->add_param("'$fecha'");//fecha
		$this->var->add_param("'$horas_trabajadas'");//horas_trabajadas
		$this->var->add_param("'$tipo_permiso'");//tipo_permiso
        $this->var->add_param("'$aprobado'");//aprobado
        $this->var->add_param("'$especial'");//especial
        $this->var->add_param("'$observaciones'");//observaciones
        $this->var->add_param("'$id_empleado'");//id_empleado
        $this->var->add_param("'$total_horas_trabajadas'");//total_horas_trabajadas
        $this->var->add_param("'$horas_no_trab_con_permiso'");//horas_no_trab_con_permiso
		$this->var->add_param("'$horas_no_trab_sin_permiso'");//horas_no_trab_sin_permiso
        $this->var->add_param("'$horas_extras'");//horas_extras				
        
      
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}


	
	function  EliminarLecturaProcesada($id_lectura_procesada)
	{

		$this->salida="";
		$this->nombre_funcion = 'casis.f_tca_lectura_procesada_iud';
		$this->codigo_procedimiento = "'CA_LEC_PROC_DEL'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("'$id_lectura_procesada'");
		$this->var->add_param("NULL");//fecha
		$this->var->add_param("NULL");//horas_trabajadas
		$this->var->add_param("NULL");//horas_no_trab_con_permiso
		$this->var->add_param("NULL");//horas_no_trab_sin_permiso
        $this->var->add_param("NULL");//horas_extras				
        $this->var->add_param("NULL");//tipo_permiso
        $this->var->add_param("NULL");//aprobado
        $this->var->add_param("NULL");//especial
        $this->var->add_param("NULL");//total_horas_trabajadas
        $this->var->add_param("NULL");//observaciones
        $this->var->add_param("NULL");//id_empleado
				
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		$this->query = $this->var->query;
	
		return $res;
	}


	function  ModificarLecturaProcesada($id_lectura_procesada,$fecha,$horas_trabajadas,$tipo_permiso,$aprobado,$especial,$observaciones,$id_empleado,$total_horas_trabajadas,$horas_no_trab_con_permiso,$horas_no_trab_sin_permiso,$horas_extras)
	{
		$this->salida="";
		$this->nombre_funcion = 'casis.f_tca_lectura_procesada_iud';
		$this->codigo_procedimiento = "'CA_LEC_PROC_UPD'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("'$id_lectura_procesada'");//id_lectura_procesada
		$this->var->add_param("'$fecha'");//fecha
		$this->var->add_param("'$horas_trabajadas'");//horas_trabajadas
		$this->var->add_param("'$tipo_permiso'");//tipo_permiso
        $this->var->add_param("'$aprobado'");//aprobado
        $this->var->add_param("'$especial'");//especial
        $this->var->add_param("'$observaciones'");//observaciones
        $this->var->add_param("'$id_empleado'");//id_empleado
        $this->var->add_param("'$total_horas_trabajadas'");//total_horas_trabajadas
		$this->var->add_param("'$horas_no_trab_con_permiso'");//horas_no_trab_con_permiso
		$this->var->add_param("'$horas_no_trab_sin_permiso'");//horas_no_trab_sin_permiso
        $this->var->add_param("'$horas_extras'");//horas_extras				
       
       	    		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		$this->query = $this->var->query;
		return $res;
	}
	
	function TransferirLectura($id_, $id_activo_fijo, $id_activo_fijo_destino)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_procesada_iud';
		$this->codigo_procedimiento = "'CA_LEC_PROC_TRANSF'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_componente);//id_componente
		$this->var->add_param("'$codigo'");//código
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado_funcional'");//estado_funcional
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param($id_activo_fijo_destino);//id_activo_fijo_destino

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
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
	function ValidarLecturaProcesada($operacion_sql,$id_lectura_procesada,$fecha,$horas_trabajadas,$tipo_permiso,$aprobado,$especial,$observaciones,$id_empleado,$total_horas_trabajadas,$horas_no_trab_con_permiso,$horas_no_trab_sin_permiso,$horas_extras)
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
							
									
				//Validar fecha - tipo date
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("fecha");	
				if(!$valid->verifica_dato($tipo_dato->TipoDatoDate, "fecha", $fecha))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar horas_trabajadas - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("horas_trabajadas");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "horas_trabajadas", $horas_trabajadas))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validar horas_no_trab_con_permiso - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("horas_no_trab_con_permiso");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "horas_no_trab_con_permiso", $horas_no_trab_con_permiso))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar horas_no_trab_sin_permiso - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("horas_no_trab_sin_permiso");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "horas_no_trab_sin_permiso", $horas_no_trab_sin_permiso))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar horas_extras - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("horas_extras");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "horas_extras", $horas_extras))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar tipo_permiso - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("tipo_permiso");
				$tipo_dato->set_MaxLength(50);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_permiso", $tipo_permiso))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar aprobado - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("aprobado");
				$tipo_dato->set_MaxLength(2);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "aprobado", $aprobado))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar especial - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("especial");
				$tipo_dato->set_MaxLength(30);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "especial", $especial))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar total_horas_trabajadas - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("total_horas_trabajadas");
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "total_horas_trabajadas", $total_horas_trabajadas))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar observaciones - tipo text
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("observaciones");
				$tipo_dato->set_MaxLength(5000);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar id_empleado - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_empleado");
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))				
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
				
					
				//Validar id_grupo_horario - tipo entero
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_lectura_procesada");	
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);				
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_lectura_procesada", $id_lectura_procesada))					
				//if(!$valid->verifica_dato($this->matriz_validacion[0], "id_parametro_general", $id_parametro_general))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar fecha - tipo date
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("fecha");	
				if(!$valid->verifica_dato($tipo_dato->TipoDatoDate, "fecha", $fecha))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar horas_trabajadas - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("horas_trabajadas");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "horas_trabajadas", $horas_trabajadas))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validar horas_no_trab_con_permiso - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("horas_no_trab_con_permiso");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "horas_no_trab_con_permiso", $horas_no_trab_con_permiso))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar horas_no_trab_sin_permiso - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("horas_no_trab_sin_permiso");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "horas_no_trab_sin_permiso", $horas_no_trab_sin_permiso))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar horas_extras - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("horas_extras");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "horas_extras", $horas_extras))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar tipo_permiso - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("tipo_permiso");
				$tipo_dato->set_MaxLength(50);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_permiso", $tipo_permiso))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar aprobado - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("aprobado");
				$tipo_dato->set_MaxLength(2);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "aprobado", $aprobado))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar especial - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("especial");
				$tipo_dato->set_MaxLength(30);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "especial", $especial))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar total_horas_trabajadas - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("total_horas_trabajadas");
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "total_horas_trabajadas", $total_horas_trabajadas))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar observaciones - tipo text
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("observaciones");
				$tipo_dato->set_MaxLength(5000);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar id_empleado - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_empleado");
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))				
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