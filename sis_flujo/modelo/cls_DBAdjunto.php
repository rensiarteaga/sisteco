<?php
/*
* Nombre de archivo:	    cls_DBAdjunto.php
* Propósito:				
* Fecha de Creación:		2010-12-27
* Autor:					Marcos A. Flores Valda
*/
 
class cls_DBAdjunto
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
	 * Nombre de la función:	ListarColumna
	 * Propósito:				Desplegar los registros de tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ListarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto,$id_correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_adjunto_sel';
		$this->codigo_procedimiento = "'FL_ADJUNT_SEL'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";		
		$this->var->add_param($id_correspondencia);

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_adjunto','int4');
		$this->var->add_def_cols('nombre_doc','varchar');
		$this->var->add_def_cols('observacion','text');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('id_usuario_reg','int4');	
		$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('tipo_adjunto','varchar');
		$this->var->add_def_cols('nombre_arch','varchar');
		$this->var->add_def_cols('extension','varchar');
		$this->var->add_def_cols('nombre_original','varchar');
		$this->var->add_def_cols('desc_persona','varchar');
		$this->var->add_def_cols('tamano_adjunto','varchar');
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "llega". $this->query; exit;

		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarColumna
	 * Propósito:				Contar los registros de tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ContarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_adjunto_sel';
		$this->codigo_procedimiento = "'FL_ADJUNT_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		$this->var->add_param($id_correspondencia);
				
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
		
		//echo $this->query; exit;

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarColumna
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function InsertarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$desc_persona,$tamano_adjunto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_adjunto_iud';
		$this->codigo_procedimiento = "'FL_ADJUNT_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_adjunto);
		$this->var->add_param("'$nombre_doc'");
		$this->var->add_param("'$observacion'");		
		$this->var->add_param($id_correspondencia);	
		$this->var->add_param("'$tipo_adjunto'");		
		$this->var->add_param("'$nombre_arch'");	
		$this->var->add_param("'$extension'");	
		$this->var->add_param("'$nombre_original'");	
		$this->var->add_param("'$desc_persona'");	
		$this->var->add_param("'$tamano_adjunto'");	
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;		

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarColumna
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ModificarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$tamano_adjunto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_adjunto_iud';
		$this->codigo_procedimiento = "'FL_ADJUNT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_adjunto);
		$this->var->add_param("'$nombre_doc'");
		$this->var->add_param("'$observacion'");		
		$this->var->add_param($id_correspondencia);
		$this->var->add_param("'$tipo_adjunto'");
		$this->var->add_param("'$nombre_arch'");	
		$this->var->add_param("'$extension'");
		$this->var->add_param("'$nombre_original'");
		$this->var->add_param("'$desc_persona'");
		$this->var->add_param("'$tamano_adjunto'");	
								
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
		
	/**
	 * Nombre de la función:	EliminarColumna
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function EliminarAdjunto($id_adjunto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_adjunto_iud';
		$this->codigo_procedimiento = "'FL_ADJUNT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_adjunto);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarColumna
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ValidarAdjunto($operacion_sql,$id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension)	
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
			//Validar id_columna - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_adjunto");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_adjunto", $id_adjunto))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar valor_defecto - tipo numeric
			$tipo_dato ->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_doc");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_doc", $nombre_doc))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observacion");
			$tipo_dato->set_MaxLength(400);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observacion", $observacion))
			{
				$this->salida = $valid->salida;
				return false;
			}			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_correspondencia");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_correspondencia", $id_correspondencia))
			{
				$this->salida = $valid->salida;
				return false;
			}
									
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_arch");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_arch", $nombre_arch))
			{
				$this->salida = $valid->salida;
				return false;
			}	
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("extension");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "extension", $extension))
			{
				$this->salida = $valid->salida;
				return false;
			}
						
			//Validación exitosa
			return true;
		}
		
		elseif ($operacion_sql=='delete')
		{
			//Validar id_columna - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_adjunto");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_adjunto", $id_adjunto))
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
	
	
	function ListarAdjuntoENDE($id_correspondencia)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_fl_webservices_ende_cadeb_sel';
		$this->codigo_procedimiento = "'FL_ADJUN_ARCHIVADA_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->add_param($this->codigo_procedimiento);
		$this->var->add_param("'$id_correspondencia'");
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_adjunto','int4');
		$this->var->add_def_cols('nombre_doc','varchar');
		$this->var->add_def_cols('observacion','text');
				$this->var->add_def_cols('fecha_reg','date');
				$this->var->add_def_cols('estado_reg','varchar');
				$this->var->add_def_cols('id_usuario_reg','int4');
				$this->var->add_def_cols('id_correspondencia','int4');
				$this->var->add_def_cols('tipo_adjunto','varchar');
				$this->var->add_def_cols('nombre_arch','varchar');
				$this->var->add_def_cols('extension','varchar');
				$this->var->add_def_cols('nombre_original','varchar');
				$this->var->add_def_cols('desc_persona','varchar');
				$this->var->add_def_cols('tamano_adjunto','varchar');
	
				//Ejecuta la función de consulta
				$res = $this->var->exec_query_sss();
	
				//Obtiene el array de salida de la función y retorna el resultado de la ejecución
				$this->salida = $this->var->salida;
	
				//Obtiene la cadena con que se llamó a la función de postgres
				$this->query = $this->var->query;
				//echo "llega". $this->query; exit;
	
	
				return $res;
	}
	
	
}?>