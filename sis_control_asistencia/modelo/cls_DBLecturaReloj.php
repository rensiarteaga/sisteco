<?php
class cls_DBLecturaReloj
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

	var $nombre_archivo = "cls_DBLecturaReloj.php";

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
	
	function ListarLecturaRelojOrig($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_orig_sel';
		$this->codigo_procedimiento = "'CA_LEC_REL_ORIG_SEL'";

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
		$this->var->add_def_cols('id_lectura_reloj_orig','bigint');
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('hora','time');
		$this->var->add_def_cols('tipo_movimiento','varchar');
		$this->var->add_def_cols('id_empleado','integer');
			
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
	function ListarLecturaReloj($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_sel';
		$this->codigo_procedimiento = "'CA_LEC_REL_SEL'";

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
		$this->var->add_def_cols('id_lectura_reloj','bigint');
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('hora','time');
		$this->var->add_def_cols('tipo_movimiento','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('turno','varchar');
		
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


	function ListarDistintoLecturaReloj($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_sel';
		$this->codigo_procedimiento = "'CA_LEC_REL_DIS_SEL'";

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
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('apellido_paterno','varchar');
		$this->var->add_def_cols('apellido_materno','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('email1','varchar');
	
		
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
	function ContarListaLecturaReloj($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_sel';
		$this->codigo_procedimiento = "'CA_LEC_REL_SEL_COUNT'";

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
	
	
	function ContarListaLecturaRelojDistinto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_sel';
		$this->codigo_procedimiento = "'CA_LEC_REL_SEL_DIS_COUNT'";

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
	Nombre de la función:	CrearLecturaReloj()

	Propósito:				Se utiliza esta función para insertar una nueva Lectura del Reloj en la base de datos
	Parámetros:				$descripcion	-->	desc 
	&obs --> observaciones pertinentes
	Valores de Retorno:		 0	-->	Retorna el nombre del archivo
	-1	--> Indica que se produjo un error y no se pudo subir el archivo al servidor
	**********************************************************
	*/
	function CrearLecturaReloj($id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_iud';
		$this->codigo_procedimiento = "'CA_LEC_REL_INS'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_lectura_reloj
		$this->var->add_param("'$codigo_empleado'");//codigo_empleado
		$this->var->add_param("'$fecha'");//fecha
		$this->var->add_param("'$hora'");//hora
		$this->var->add_param("'$tipo_movimiento'");//tipo_movimiento
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$turno'");//turno
                
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function CrearLecturaRelojArchivo($id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_iud';
		$this->codigo_procedimiento = "'CA_LEC_REL_ARCH_INS'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_lectura_reloj
		$this->var->add_param("'$codigo_empleado'");//codigo_empleado
		$this->var->add_param("'$fecha'");//fecha
		$this->var->add_param("'$hora'");//hora
		$this->var->add_param("'$tipo_movimiento'");//tipo_movimiento
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("'$turno'");//turno
                
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	function  EliminarLecturaReloj($id_lectura_reloj)
	{

		$this->salida="";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_iud';
		$this->codigo_procedimiento = "'CA_LEC_REL_DEL'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("'$id_lectura_reloj'");
		$this->var->add_param("NULL");//codigo_empleado
		$this->var->add_param("NULL");//fecha
		$this->var->add_param("NULL");//hora
		$this->var->add_param("NULL");//tipo_movimiento
        $this->var->add_param("NULL");//observaciones
        $this->var->add_param("NULL");//turno
        				
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		$this->query = $this->var->query;
	
		return $res;
	}

	function  ModificarLecturaReloj($id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno)
	{
		$this->salida="";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_iud';
		$this->codigo_procedimiento = "'CA_LEC_REL_UPD'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("'$id_lectura_reloj'");//id_lectura_procesada
		$this->var->add_param("'$codigo_empleado'");//codigo_empleado
		$this->var->add_param("'$fecha'");//fecha
		$this->var->add_param("'$hora'");//hora
		$this->var->add_param("'$tipo_movimiento'");//tipo_movimiento
		$this->var->add_param("'$observaciones'");//tipo_movimiento
		$this->var->add_param("'$turno'");//turno
        	    		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		$this->query = $this->var->query;
		return $res;
	}

	/*
**********************************************************
Nombre de la función:	ProcesaArchivo()
Propósito:				Se utiliza esta función para insertar los datos del archivo de texto
Parámetros:				
Valores de Retorno:		 0	-->	Retorna el nombre del archivo	
						-1	--> Indica que se produjo un error y no se pudo subir el archivo al servidor 
**********************************************************
*/
    function  ProcesarArchivo($nombre_archivo)
	{	
		/*$archivo= fopen("../../archivo/$nombre_archivo" , "r"); 
        $cont = 0;
		if ($archivo) 
		{  
			while (!feof($archivo)) 
			{ 					          
				//carga con archivos del sistema fingerprint
				$registro=fgets($archivo); 
				$codigo_empleado= substr($registro,0,16);
				$fecha= substr($registro,20,3).substr($registro,17,3).substr($registro,23,4);
				//$fecha= substr($registro,15,10);
          		$hora= substr($registro,28,8);
          		$tipo_movimiento= substr($registro,42,1);          		
          	    $fecha_ins=trim($fecha);
          	    $hora_ins=trim($hora);
          	    $tipo_movimiento_ins=trim($tipo_movimiento);
          	    $codigo_empleado_ins=trim($codigo_empleado);          	              	    
          	  	$this->CrearLecturaRelojArchivo("NULL",$codigo_empleado_ins,$fecha_ins,$hora_ins,$tipo_movimiento_ins,"","");
          	  	
				   		
			} 
		}*/
		
        //con la nueva carga nfs
		$nombre_archivo="/tmpendesis/".$nombre_archivo;
		$this->salida="";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_iud';
		$this->codigo_procedimiento = "'CA_LEC_REL_ARCH'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_lectura_procesada
		$this->var->add_param("'$nombre_archivo'");//codigo_empleado
		$this->var->add_param("NULL");//fecha
		$this->var->add_param("NULL");//hora
		$this->var->add_param("NULL");//tipo_movimiento
		$this->var->add_param("NULL");//tipo_movimiento
		$this->var->add_param("NULL");//turno
        	    		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		$this->query = $this->var->query;
		
		return $res;
    }

    	/*
**********************************************************
Nombre de la función:	Descuento()
Propósito:				Se utiliza esta función para insertar los datos del archivo de texto
Parámetros:				
Valores de Retorno:		 0	-->	Retorna el nombre del archivo	
						-1	--> Indica que se produjo un error y no se pudo subir el archivo al servidor 
**********************************************************
*/
    function  Descuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin,$tipo_contrato)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_descuento_sel';
		$this->codigo_procedimiento = "'CA_DESC_SEL'";

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
		$this->var->add_param("$id_empleado");//id_empleado
		$this->var->add_param("'$fecha_ini'");//fecha_ini
		$this->var->add_param("'$fecha_fin'");//fecha_fin
		$this->var->add_param("'$tipo_contrato'");//fecha_fin
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('descuento','numeric');

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
		/*echo $this->query;
		exit;*/
		//Retorna el resultado de la ejecución
		return $res;  
    }
    	/*
**********************************************************
Nombre de la función:	ResumenSemanalDescuento()
Propósito:				Se utiliza esta función para insertar los datos del archivo de texto
Parámetros:				
Valores de Retorno:		 0	-->	Retorna el nombre del archivo	
						-1	--> Indica que se produjo un error y no se pudo subir el archivo al servidor 
**********************************************************
*/
    function  ResumenSemanalDescuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin,$tipo_contrato)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_descuento_sel';
		$this->codigo_procedimiento = "'CA_RESU_SEM_DESC'";

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
		$this->var->add_param("$id_empleado");//id_empleado
		$this->var->add_param("'$fecha_ini'");//fecha_ini
		$this->var->add_param("'$fecha_fin'");//fecha_fin
		$this->var->add_param("'$tipo_contrato'");//fecha_fin
		//Carga la definición de columnas con sus tipos de datos
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('sueldo','numeric');
		$this->var->add_def_cols('tiempo_no_trab','interval');
		$this->var->add_def_cols('descuento','numeric');
		$this->var->add_def_cols('observaciones','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	//	echo $this->query;
		//exit;
		return $res; 
    }
      /*
**********************************************************
Nombre de la función:	ResumenMensualDescuento()
Propósito:				Se utiliza esta función para insertar los datos del archivo de texto
Parámetros:				
Valores de Retorno:		 0	-->	Retorna el nombre del archivo	
						-1	--> Indica que se produjo un error y no se pudo subir el archivo al servidor 
**********************************************************
*/
    function  ResumenMensualDescuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin,$tipo_contrato)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_descuento_sel';
		$this->codigo_procedimiento = "'CA_RESU_MES_DESC'";

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
		$this->var->add_param("$id_empleado");//id_empleado
		$this->var->add_param("'$fecha_ini'");//fecha_ini
		$this->var->add_param("'$fecha_fin'");//fecha_fin
		$this->var->add_param("'$tipo_contrato'");//fecha_fin

		//Carga la definición de columnas con sus tipos de datos
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('sueldo','numeric');
		$this->var->add_def_cols('tiempo_no_trab','interval');
		$this->var->add_def_cols('descuento','numeric');
		$this->var->add_def_cols('cantidad_memos','integer');
			
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res; 
    }
	  function  ExisteDescuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin)
	  {	
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_descuento_sel';
		$this->codigo_procedimiento = "'CA_EXIST_DESC'";

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
		$this->var->add_param("$id_empleado");//id_empleado
		$this->var->add_param("'$fecha_ini'");//fecha_ini
		$this->var->add_param("'$fecha_fin'");//fecha_fin
		$this->var->add_param("null");//fecha_fin
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('descuento','integer');

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
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_parametros_generales
	 * @param unknown_type $nombre_atributo
	 * @param unknown_type $valor_atributo
	 * @param unknown_type $descripcion
	 * @return unknown
	 */
	function ValidarLecturaReloj($operacion_sql,$id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno)
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
							
									
				//Validar codigo_empleado - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("codigo_empleado");
				$tipo_dato->set_MaxLength(40);
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_empleado", $codigo_empleado))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar fecha - tipo date
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("fecha");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha", $fecha))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validar hora - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora", $hora))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar tipo_movimiento - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("tipo_movimiento");	
				$tipo_dato->set_MaxLength(30);
				$tipo_dato->set_MinLength(0);
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_movimiento", $tipo_movimiento))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar observaciones - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("observaciones");	
				$tipo_dato->set_MaxLength(30);
				$tipo_dato->set_MinLength(0);
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar turno - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("turno");
				$tipo_dato->set_MaxLength(20);
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "turno", $turno))
				
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
				
					
				//Validar id_lectura_reloj - tipo entero
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_lectura_reloj");	
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);				
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_lectura_reloj", $id_lectura_reloj))					
				//if(!$valid->verifica_dato($this->matriz_validacion[0], "id_parametro_general", $id_parametro_general))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar codigo_empleado - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("codigo_empleado");
				$tipo_dato->set_MaxLength(40);
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_empleado", $codigo_empleado))
				
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar fecha - tipo date
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("fecha");	
								
				if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha", $fecha))				
				//if(!$valid->verifica_dato($this->matriz_validacion[2],"valor_atributo",$valor_atributo))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validar hora - tipo time
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("hora");	
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora", $hora))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar tipo_movimiento - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("tipo_movimiento");	
				$tipo_dato->set_MaxLength(30);
				$tipo_dato->set_MinLength(0);
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_movimiento", $tipo_movimiento))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar observaciones - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("observaciones");	
				$tipo_dato->set_MaxLength(30);
				$tipo_dato->set_MinLength(0);
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))				
				//if(!$valid->verifica_dato($this->matriz_validacion[3],"descripcion",$descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validar turno - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("turno");
				$tipo_dato->set_MaxLength(20);
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "turno", $turno))
				
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
	
/*REPORTE EN ATENCION A CI DE AUDITORIA*/
	
	function  DetalleMarcasPeriodo($id_gestion, $id_periodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_reporte_marcas_mes';
		$this->codigo_procedimiento = "'CA_MARMES_REP'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
	
	
		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($_SESSION["ss_id_usuario"]);//id_empleado
		$this->var->add_param("'CA_MARMES_REP'");//id_empleado
		$this->var->add_param('null');//id_empleado
		
		$this->var->add_param("$id_gestion");//id_empleado
		$this->var->add_param("$id_periodo");//fecha_ini
		
		//Carga la definición de columnas con sus tipos de datos
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('nombre_completo','varchar');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('entrada_am','time');
		$this->var->add_def_cols('salida_am','time');
		$this->var->add_def_cols('entrada_pm','time');
		$this->var->add_def_cols('salida_pm','time');
			
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query_sss();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo '--->'.$this->query; exit;
		return $res;
	}
	
	
	function ProcesarArchivoCsv( $arr_temp0, $fecha,$hora,$marca)
	{
		$this->salida = "";
		$this->nombre_funcion = 'casis.f_tca_lectura_reloj_iud';
		$this->codigo_procedimiento = "'CA_SUBARCH_CSV'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_lectura_procesada
		$this->var->add_param("'$arr_temp0'");//codigo_empleado
		$this->var->add_param("'$fecha'");//fecha
		$this->var->add_param("'$hora'");//hora
		$this->var->add_param("'$marca'");
		$this->var->add_param("null");
		$this->var->add_param("null");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res;
	}

	
	
}
?>