<?php
/**
 * Nombre de la clase:	cls_DBPersona.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_persona
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-26 17:06:33
 */

class cls_DBPersona
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
	 * Nombre de la función:	ListarPersona
	 * Propósito:				Desplegar los registros de tsg_persona
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:06:33
	 */
	function ListarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_persona_sel';
		$this->codigo_procedimiento = "'SG_PERSON_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('apellido_paterno','varchar');
		$this->var->add_def_cols('apellido_materno','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('fecha_nacimiento','date');
	 //	$this->var->add_def_cols('foto_persona','bytea');
	 	$this->var->add_def_cols('foto_persona','bytea','numero','extension','../../control/persona/archivo/',true);
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('genero','varchar');
		$this->var->add_def_cols('casilla','varchar');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('celular1','varchar');
		$this->var->add_def_cols('celular2','varchar');
		$this->var->add_def_cols('pag_web','varchar');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('email2','varchar');
		$this->var->add_def_cols('email3','varchar');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('id_tipo_doc_identificacion','int4');
		$this->var->add_def_cols('desc_tipo_doc_identificacion','varchar');
	    $this->var->add_def_cols('desc_per','text');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('nro_registro','varchar');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('nombre_foto','varchar');
		$this->var->add_def_cols('numero','bigint');		//crea el nodo para mostrarlo en el grid	
		$this->var->add_def_cols('extension','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		//print_r($res);
		return $res;
	}
	/**
	 * Nombre de la función:	ListarPersonaFoto
	 * Propósito:				Desplegar los registros de tsg_persona
	 * Autor:				    Ana Maria villegas
	 * Fecha de creación:		2007-10-26 17:06:33
	 */
	function ListarPersonaFoto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_persona_sel';
		$this->codigo_procedimiento = "'SG_PERFOT_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('apellido_paterno','varchar');
		$this->var->add_def_cols('apellido_materno','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('fecha_nacimiento','date');
	 	//$this->var->add_def_cols('foto_persona','bytea');	 	
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('genero','varchar');
		$this->var->add_def_cols('casilla','varchar');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('celular1','varchar');
		$this->var->add_def_cols('celular2','varchar');
		$this->var->add_def_cols('pag_web','varchar');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('email2','varchar');
		$this->var->add_def_cols('email3','varchar');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('id_tipo_doc_identificacion','int4');
		$this->var->add_def_cols('desc_tipo_doc_identificacion','varchar');
	    $this->var->add_def_cols('desc_per','text');
    	$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
	$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
	$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPersona
	 * Propósito:				Contar los registros de tsg_persona
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:06:33
	 */
	function ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_persona_sel';
		$this->codigo_procedimiento = "'SG_PERSON_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
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
	 * Nombre de la función:	InsertarPersona
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_persona
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:06:33
	 */
	function InsertarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$direccion,$nro_registro,$nombre_foto,$numero,$extension)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_persona_iud';
		$this->codigo_procedimiento = "'SG_PERSON_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$apellido_paterno'");
		$this->var->add_param("'$apellido_materno'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$fecha_nacimiento'");
		//$this->var->add_param($foto_persona);
		$this->var->add_archivo($foto_persona);
		$this->var->add_param("'$doc_id'");
		$this->var->add_param("'$genero'");
		$this->var->add_param("'$casilla'");
		$this->var->add_param("'$telefono1'");
		$this->var->add_param("'$telefono2'");
		$this->var->add_param("'$celular1'");
		$this->var->add_param("'$celular2'");
		$this->var->add_param("'$pag_web'");
		$this->var->add_param("'$email1'");
		$this->var->add_param("'$email2'");
		$this->var->add_param("'$email3'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_tipo_doc_identificacion);
		$this->var->add_param("'$direccion'");
		$this->var->add_param("'$nro_registro'");
		$this->var->add_param("'$nombre_foto'");
		$this->var->add_param($numero);		
		$this->var->add_param("'$extension'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPersona
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_persona
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:06:33
	 */
	function ModificarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$direccion,$nro_registro,$nombre_foto,$numero,$extension)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_persona_iud';
		$this->codigo_procedimiento = "'SG_PERSON_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_persona);
		$this->var->add_param("'$apellido_paterno'");
		$this->var->add_param("'$apellido_materno'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$fecha_nacimiento'");
		//$this->var->add_param($foto_persona);
		$this->var->add_archivo($foto_persona);
		$this->var->add_param("'$doc_id'");
		$this->var->add_param("'$genero'");
		$this->var->add_param("'$casilla'");
		$this->var->add_param("'$telefono1'");
		$this->var->add_param("'$telefono2'");
		$this->var->add_param("'$celular1'");
		$this->var->add_param("'$celular2'");
		$this->var->add_param("'$pag_web'");
		$this->var->add_param("'$email1'");
		$this->var->add_param("'$email2'");
		$this->var->add_param("'$email3'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_tipo_doc_identificacion);

		$this->var->add_param("'$direccion'");
		$this->var->add_param("'$nro_registro'");
		$this->var->add_param("'$nombre_foto'");
		$this->var->add_param($numero);		
		$this->var->add_param("'$extension'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Insertar a la persona con una imagen.
	 * @param unknown_type $id_persona
	 * @param unknown_type $apellido_paterno
	 * @param unknown_type $apellido_materno
	 * @param unknown_type $nombre
	 * @param unknown_type $fecha_nacimiento
	 * @param unknown_type $foto_persona
	 * @param unknown_type $doc_id
	 * @param unknown_type $genero
	 * @param unknown_type $casilla
	 * @param unknown_type $telefono1
	 * @param unknown_type $telefono2
	 * @param unknown_type $celular1
	 * @param unknown_type $celular2
	 * @param unknown_type $pag_web
	 * @param unknown_type $email1
	 * @param unknown_type $email2
	 * @param unknown_type $email3
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @param unknown_type $observaciones
	 * @param unknown_type $id_tipo_doc_identificacion
	 * @return unknown
	 * Ana Maria V. Q. 
	 */
	function InsertarPersonaFoto($id_persona, $apellido_paterno, $apellido_materno, $nombre, $fecha_nacimiento,
	                             $foto_persona,$doc_id, $genero, $casilla, $telefono1, $telefono2, $celular1, 
	                             $celular2, $pag_web, $email1, $email2, $email3, $fecha_registro, $hora_registro,
	                             $fecha_ultima_modificacion, $hora_ultima_modificacion, $observaciones, 
	                             $id_tipo_doc_identificacion)
	{
		$nombre_archivo = basename ( $foto_persona['name'] ) ;
        $archivo= fopen("archivo/$nombre_archivo", "rb"); 
		
        $cont = 0;
		//$fp = fopen($tmp_name, "rb");
        $buffer = fread($archivo, filesize("archivo/$nombre_archivo"));
        fclose($archivo);
        $buffer1=pg_escape_bytea($buffer);
            
		//echo "nombre:".$nombre;
		//exit;
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_persona_iud';
		$this->codigo_procedimiento = "'SG_PERSON_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		  
		    $this->var->add_param("NULL");//id_persona
			$this->var->add_param("'$apellido_paterno'");
			$this->var->add_param("'$apellido_materno'");
			$this->var->add_param("'$nombre'");
			$this->var->add_param("'$fecha_nacimiento'");
			$this->var->add_param("'$buffer1'");// foto persona
			//$this->var->add_param("'$doc_id'");
			$this->var->add_param("'$nombre_archivo'");
			$this->var->add_param("'$genero'");
			$this->var->add_param("'$casilla'");
			$this->var->add_param("'$telefono1'");
			$this->var->add_param("'$telefono2'");
			$this->var->add_param("'$celular1'");
			$this->var->add_param("'$celular2'");
			$this->var->add_param("'$pag_web'");
			$this->var->add_param("'$email1'");
			$this->var->add_param("'$email2'");
			$this->var->add_param("'$email3'");
			$this->var->add_param("'12/12/2007'");
			$this->var->add_param("'08:30:00'");
			$this->var->add_param("'12/12/2007'");
			$this->var->add_param("'$hora_ultima_modificacion'");
			$this->var->add_param("'$observaciones'");
			$this->var->add_param($id_tipo_doc_identificacion);
		  
		 
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
	
		return $res;
	}

	/**
	 * Nombre de la función:	EliminarPersona
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_persona
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:06:33
	 */
	function EliminarPersona($id_persona)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_persona_iud';
		$this->codigo_procedimiento = "'SG_PERSON_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_persona);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		
		$this->var->add_param("NULL");//,$direccion,
		$this->var->add_param("NULL");//$nro_registro
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarPersona
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_persona
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 17:06:33
	 */
	function ValidarPersona($operacion_sql,$id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
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
				//Validar id_persona - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_persona");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_persona", $id_persona))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar apellido_paterno - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("apellido_paterno");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "apellido_paterno", $apellido_paterno))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar apellido_materno - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("apellido_materno");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "apellido_materno", $apellido_materno))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_nacimiento - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_nacimiento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_nacimiento", $fecha_nacimiento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar foto_persona - tipo bytea
//			$tipo_dato->_reiniciar_valor();
//			$tipo_dato->set_Columna("foto_persona");
//			$tipo_dato->set_MaxLength(100);
//			$tipo_dato->set_AllowBlank(false);
//			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "foto_persona", $foto_persona))
//			{
//				$this->salida = $valid->salida;
//				return false;
//			}

			//Validar doc_id - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("doc_id");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "doc_id", $doc_id))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar genero - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("genero");
			$tipo_dato->set_MaxLength(6);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "genero", $genero))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar casilla - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("casilla");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "casilla", $casilla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono1");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono1", $telefono1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono2");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono2", $telefono2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular1");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular1", $celular1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular2");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular2", $celular2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar pag_web - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("pag_web");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "pag_web", $pag_web))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar email1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email1");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoEmail(), "email1", $email1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar email2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email2");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoEmail(), "email2", $email2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar email3 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email3");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoEmail(), "email3", $email3))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_registro", $fecha_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_registro - tipo time
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_registro");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_registro", $hora_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar fecha_ultima_modificacion - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ultima_modificacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ultima_modificacion", $fecha_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_ultima_modificacion - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_ultima_modificacion");
			$tipo_dato->set_MaxLength(8);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_ultima_modificacion", $hora_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_doc_identificacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_doc_identificacion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_doc_identificacion", $id_tipo_doc_identificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar genero
			$check = array ("varon","mujer");
			if(!in_array($genero,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'genero': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarPersona";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_persona - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_persona");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_persona", $id_persona))
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