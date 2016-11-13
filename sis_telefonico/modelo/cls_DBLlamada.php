<?php
class cls_DBLlamada
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

	var $nombre_archivo = "cls_DBLlamada.php";

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
	function ListarLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_llamada_sel';
		$this->codigo_procedimiento = "'ST_LLAMAD_SEL'";

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
		$this->var->add_def_cols('id_llamada','integer');
		$this->var->add_def_cols('fecha_llamada','date');
		$this->var->add_def_cols('hora_llamada','time');
		$this->var->add_def_cols('numero_interno','varchar');
		$this->var->add_def_cols('numero_marcado','varchar');
		$this->var->add_def_cols('duracion_llamada','time');
		$this->var->add_def_cols('saliente','varchar');
		$this->var->add_def_cols('transferido','varchar');
		$this->var->add_def_cols('origen_transferencia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fk_id_llamada','integer');
		$this->var->add_def_cols('desc_origen','varchar');
		$this->var->add_def_cols('id_linea','integer');
		$this->var->add_def_cols('puerto_linea','varchar');
		$this->var->add_def_cols('id_tipo_llamada','integer');
		$this->var->add_def_cols('desc_tipo_llamada','varchar');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('id_persona','integer');
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
	function ContarLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_llamada_sel';
		$this->codigo_procedimiento = "'ST_LLAMAD_COUNT'";

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
function ListarNumero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_llamada_sel';
		$this->codigo_procedimiento = "'ST_LLANUM_SEL'";

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
		$this->var->add_def_cols('numero_marcado','varchar');
			
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
function ContarNumero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
    {
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_llamada_sel';
		$this->codigo_procedimiento = "'ST_LLANUM_COUNT'";

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
	function ListarNombreLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$linea)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_nombre_llamada_sel';
		$this->codigo_procedimiento = "'ST_NOMLLA_SEL'";

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
        $this->var->add_param("'$linea'");//linea
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_tipo_llamada','varchar');
			
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida[0][0];
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function InsertarLlamada($id_llamada,$fecha_llamada,$hora_llamada,$numero_interno,$numero_marcado,$duracion_llamada,$transferido,$saliente,$linea,$pwd_usuario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_llamada_iud';
		$this->codigo_procedimiento = "'ST_LLAMAD_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_llamada'");
		$this->var->add_param("'$hora_llamada'");
		$this->var->add_param("'$numero_interno'");
		$this->var->add_param("'$numero_marcado'");
		$this->var->add_param("'$duracion_llamada'");
		$this->var->add_param("'$transferido'");
		$this->var->add_param("'$saliente'");
		$this->var->add_param("'$linea'");
		$this->var->add_param("'$pwd_usuario'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
      	return $res;
	}
	function ModificarLlamada($id_llamada,$fecha_llamada,$hora_llamada,$numero_interno,$numero_marcado,$duracion_llamada,$transferido,$saliente,$linea,$pwd_usuario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_llamada_iud';
		$this->codigo_procedimiento = "'ST_LLAMAD_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_llamada);
		$this->var->add_param("'$fecha_llamada'");
		$this->var->add_param("'$hora_llamada'");
		$this->var->add_param("'$numero_interno'");
		$this->var->add_param("'$numero_marcado'");
		$this->var->add_param("'$duracion_llamada'");
		$this->var->add_param("'$transferido'");
		$this->var->add_param("'$saliente'");
		$this->var->add_param("'$linea'");
		$this->var->add_param("'$pwd_usuario'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
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
    function  ProcesarArchivo($archivo_nombre)
	{	$archivo= fopen("../../archivo/$archivo_nombre","r"); 
        $cont = 0;
		if ($archivo) 
		{  
			while (!feof($archivo)) 
			{   $registro=fgets($archivo); 
				$aux=substr($registro,0,8);
				$aux1=substr($registro,11,4);
                if ($aux=="--------"){
                	$anio=substr($registro,17,2);
                	$anios=2000;
                	$anio_ins=$anios+(int)$anio; 
					$fecha_llamada=substr($registro,11,6).$anio_ins;
					$hora_llamada=substr($registro,22,8);
					$linea=substr($registro,40,4);
					$numero_interno=substr($registro,53,4);
                    }
                if ($aux1=="OUTG" || $aux1=="INCO" || $aux1=="FROM"){
                	$saliente=$aux1;
                	}
                if ($aux1=="REST"){
                	$pwd_usuario=substr($registro,33,2);
                	}
                if ($aux1=="DIGI"){
                	$numero_marcado=substr($registro,27,25);
                	$numero_marcado_ins=trim($numero_marcado);
                	}
                  if ($aux1=="CALL" || $aux1=="TRAN"){
                  	$duracion_llamada=$aux;
                  	$transferido=$aux1;
                 	$res=$this->InsertarLlamada("NULL",$fecha_llamada,$hora_llamada,$numero_interno,$numero_marcado_ins,$duracion_llamada,$transferido,$saliente,$linea,$pwd_usuario);
                   	$fecha_llamada="";
                 	$hora_llamada="";
                 	$numero_interno="";
                 	$numero_marcado_ins="";
                 	$duracion_llamada="";
                 	$transferido="";
                 	$saliente="";
                 	$linea="";
                 	$pwd_usuario="";
                    }
			}				
		} 
    }
}
?>