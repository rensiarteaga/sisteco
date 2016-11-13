<?php
/**
 * Nombre de la Clase:	cls_DBClasificacion
 * Propï¿½sito:			Permite ejecutar la funcionalidad de la tabla tal_clasificacion
 * Autor:				Ariel Ayavir Omonte
 * Fecha creaciï¿½n:		20-08-2013
 *
 */
class cls_DBClasificacion {
	var $salida;
	var $query;
	// Variables para la ejecuciï¿½n de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la funciï¿½n a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBClasificacion.php";
	
	// Matriz de parï¿½metros de validaciï¿½n de todas las columnas
	var $matriz_validacion = array ();
	
	// Bandera que indica si los datos se decodificarï¿½n o no
	var $decodificar = false;
	function __construct() {
		// Carga los parï¿½metro de validaciï¿½n de todas las columnas
		// $this->cargar_param_valid();
		
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	function ListarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_clasificacion_sel';
		$this->codigo_procedimiento = "'AL_CLASIF_SEL'";
		
		$func = new cls_funciones();
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'"; 
		
		// Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('id_clasificacion', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('codigo_largo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('id_clasificacion_fk', 'integer');
		$this->var->add_def_cols('sw_demasia', 'varchar');
		$this->var->add_def_cols('tipo_rama', 'varchar'); 
		$this->var->add_def_cols('orden', 'integer'); 
		
		// Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;exit;
		return $res;
	}
	function ContarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_clasificacion_sel';
		$this->codigo_procedimiento = "'AL_CLASIF_COUNT'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		
		// Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;
		
		// Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		// Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	function InsertarClasificacion($id_clasificacion_fk, $codigo, $nombre, $estado,$demasia,$orden) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_clasificacion_iud';
		$this->codigo_procedimiento = "'AL_CLASIF_INS'";
		
		$demasia_aux='';
		
		 if($id_clasificacion_fk == '' || $id_clasificacion_fk == null )
		{
			if($demasia)$demasia_aux='si';
			else $demasia_aux='no';
		}
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param("NULL");
		$this->var->add_param($id_clasificacion_fk);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$estado'");
		
		$this->var->add_param("'$demasia_aux'");//demasia
		$this->var->add_param($orden);//al_orden
		
		// Ejecuta la funcion
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funcion y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida; 
		
		// Obtiene la cadena con que se llama la funcion de postgres
		$this->query = $this->var->query;
		 
		return $res;
	}
	function ModificarClasificacion($id_clasificacion, $id_clasificacion_fk, $codigo, $nombre, $estado,$demasia,$orden) {
		
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_clasificacion_iud';
		$this->codigo_procedimiento = "'AL_CLASIF_UPD'";
		
		$demasia_aux='';
		
		if($id_clasificacion_fk == '' || $id_clasificacion_fk == null )
		{
			if($demasia)$demasia_aux='si';
			else $demasia_aux='no';
		}
		
		// Instancia la clase midlle para la ejecucion de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_clasificacion);
		$this->var->add_param($id_clasificacion_fk);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$estado'");
		
		$this->var->add_param("'$demasia_aux'");//demasia
		$this->var->add_param($orden);//al_orden
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function EliminarClasificacion($id_clasificacion) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_clasificacion_iud';
		$this->codigo_procedimiento = "'AL_CLASIF_DEL'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)
		$this->var->add_param($id_clasificacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//demasia
		
		$this->var->add_param($orden);//al_orden
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	//añadido 21-11-2014
	
	function ListarClasificacionUC($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_clasificacion_sel';
		$this->codigo_procedimiento = "'AL_CLASIF_SEL_UC'";
		
		$func = new cls_funciones();
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$id_financiador = (string) $hidden_ep_id_financiador;
		
		// Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param("'$hidden_ep_id_financiador'"); // id_financiador
		//$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('id_clasificacion', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('codigo_largo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('id_clasificacion_fk', 'integer');
		$this->var->add_def_cols('sw_demasia', 'varchar');
		$this->var->add_def_cols('ref_uc','integer'); 
		
		// Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		echo $this->query;exit;
		
		return $res;
	}
	
	
	function ValidarClasificacion($operacion_sql, $id_clasificacion, $id_clasificacion_fk, $codigo, $nombre, $estado) {
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		// Ejecuta la validación por el tipo de operaciï¿½n
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_clasificacion");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clasificacion", $id_clasificacion)) {
					$this->salida = $valid->salida;
					return false;
				}
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_clasificacion_fk");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clasificacion_fk", $id_clasificacion_fk)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(5);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} elseif ($operacion_sql == 'delete') {
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_clasificacion");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clasificacion", $id_clasificacion)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}
}
?>
