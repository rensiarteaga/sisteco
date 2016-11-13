<?php
/**
 * Nombre de la clase:	cls_DBProyecto.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_proyecto
 * Autor:				Grover Velasquez Colque
 * Fecha creación:		2008-07-15 10:55:06
 */
class cls_DBProyecto {
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	function __construct() {
		$this->decodificar = $decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarProyecto
	 * Propósito:				Desplegar los registros de tpr_proyecto
	 * Autor: Grover Velasquez Colque
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function ListarProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_proyecto_sel';
		$this->codigo_procedimiento = "'PR_PROYEC_SEL'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '', "'%'", "'$id_financiador'")); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", "'$id_regional'")); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", "'$id_programa'")); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", "'$id_proyecto'")); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", "'$id_actividad'")); // id_actividad
		                                                                                
		// Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proyecto', 'int4');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('sigla', 'varchar');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'timestamp');
		$this->var->add_def_cols('codigo_sisin', 'varchar');
		$this->var->add_def_cols('sector_economico', 'numeric');
		$this->var->add_def_cols('subsector_economico', 'numeric');
		$this->var->add_def_cols('activ_eco', 'numeric');
		$this->var->add_def_cols('departamento', 'numeric');
		$this->var->add_def_cols('provincia', 'numeric');
		$this->var->add_def_cols('seccion_mun', 'numeric');
		$this->var->add_def_cols('sisin', 'varchar');
		$this->var->add_def_cols('pnd', 'varchar');
		$this->var->add_def_cols('cant_proyectos', 'bigint');
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		// echo($this->query = $this->var->query);
		// exit();
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarProyecto
	 * Propósito:				Contar los registros de tpr_proyecto
	 * Autor: (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function ContarProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_proyecto_sel';
		$this->codigo_procedimiento = "'PR_PROYEC_COUNT'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '', "'%'", "'$id_financiador'")); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", "'$id_regional'")); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", "'$id_programa'")); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", "'$id_proyecto'")); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", "'$id_actividad'")); // id_actividad
		                                                                                
		// Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		
		// Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		// Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarProyecto
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_proyecto
	 * Autor: (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function InsertarProyecto($id_proyecto, $codigo, $descripcion, $sigla, $codigo_sisin, $sector_economico, $subsector_economico, $activ_eco, $departamento, $provincia, $seccion_mun, $sisin, $pnd) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_proyecto_iud';
		$this->codigo_procedimiento = "'PR_PROYEC_INS'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$sigla'");
		$this->var->add_param("'$codigo_sisin'");
		$this->var->add_param($sector_economico);
		$this->var->add_param($subsector_economico);
		$this->var->add_param($activ_eco);
		$this->var->add_param($departamento);
		$this->var->add_param($provincia);
		$this->var->add_param($seccion_mun);
		$this->var->add_param("'$sisin'");
		$this->var->add_param("'$pnd'");
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarProyecto
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_proyecto
	 * Autor: (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function ModificarProyecto($id_proyecto, $codigo, $descripcion, $sigla, $codigo_sisin, $sector_economico, $subsector_economico, $activ_eco, $departamento, $provincia, $seccion_mun, $sisin, $pnd) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_proyecto_iud';
		$this->codigo_procedimiento = "'PR_PROYEC_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_proyecto);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$sigla'");
		$this->var->add_param("'$codigo_sisin'");
		$this->var->add_param($sector_economico);
		$this->var->add_param($subsector_economico);
		$this->var->add_param($activ_eco);
		$this->var->add_param($departamento);
		$this->var->add_param($provincia);
		$this->var->add_param($seccion_mun);
		$this->var->add_param("'$sisin'");
		$this->var->add_param("'$pnd'");
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarProyecto
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_proyecto
	 * Autor: (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function EliminarProyecto($id_proyecto) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_proyecto_iud';
		$this->codigo_procedimiento = "'PR_PROYEC_DEL'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_proyecto);
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
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarProyecto
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_actvidad
	 * Autor: (autogenerado)
	 * Fecha de creación:		2008-07-15 10:55:06
	 */
	function ValidarProyecto($operacion_sql, $id_proyecto, $codigo, $descripcion, $sigla, $sector_economico, $subsector_economico, $activ_eco, $departamento, $provincia, $seccion_mun, $sisin, $pnd) {
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		// Ejecuta la validación por el tipo de operación
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				// Validar id_proyecto - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_proyecto");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proyecto", $id_proyecto)) {
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			// Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(4);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(1000);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar sigla - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sigla");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "sigla", $sigla)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sector_economico");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "sector_economico", $sector_economico)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("subsector_economico");
			$tipo_dato->set_MaxLength(1);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "subsector_economico", $subsector_economico)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("activ_eco");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "activ_eco", $activ_eco)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("departamento");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "departamento", $departamento)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("provincia");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "provincia", $provincia)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("seccion_mun");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "seccion_mun", $seccion_mun)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sisin");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "sisin", $sisin)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("pnd");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "pnd", $pnd)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validación exitosa
			return true;
		} elseif ($operacion_sql == 'delete') {
			// Validar id_proyecto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proyecto");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proyecto", $id_proyecto)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validación exitosa
			return true;
		} else {
			return false;
		}
	}
}
?>