<?php
/**
 * Nombre de la Clase:	cls_DBPlanCuentas
 * Propï¿½sito:			Permite ejecutar la funcionalidad de la tabla tal_plan_cuentas
 * Autor:				UNKNOW
 * Fecha creaciï¿½n:		12-05-2015
 *
 */
class cls_DBPlanCuentas
{
	// Variable que contiene la salida de la ejecuciï¿½n de la funciï¿½n
	// si la funciï¿½n tuvo error (false), salida contendrï¿½ el mensaje de error
	// si la funciï¿½n no tuvo error (true), salida contendrï¿½ el resultado, ya sea un conjunto de datos o un mensaje de confirmaciï¿½n
	var $salida;
	
	// Variable que contedrï¿½ la cadena de llamada a las funciones postgres
	var $query;
	
	// Variables para la ejecuciï¿½n de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la funciï¿½n a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBPlanCuentas.php";
	
	// Matriz de parï¿½metros de validaciï¿½n de todas las columnas
	var $matriz_validacion = array ();
	
	// Bandera que indica si los datos se decodificarï¿½n o no
	var $decodificar = false;
	function __construct() {
		// Carga los parï¿½metro de validaciï¿½n de todas las columnas
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	/**
	 * Nombre de la funciï¿½n:	ListarPlanCuentasArb
	 * Propï¿½sito:				Desplegar los registros de tal_almacen en funciï¿½n de los parï¿½metros del filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaciï¿½n:		09-08-2013
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
	function ListarPlanCuentasArb($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_plan_cuentas_sel';
		$this->codigo_procedimiento = "'AF_PLANCTAS_SEL'";
		
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
		$this->var->add_param($func->iif($id_financiador == '', "'%'", "'$id_financiador'")); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
                                                                         
		// Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_plan_cuentas','integer');
		$this->var->add_def_cols('id_plan_cuentas_fk','integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('id_tipo_activo', 'integer');
		$this->var->add_def_cols('id_gestion', 'integer');
		$this->var->add_def_cols('gestion', 'numeric');
		$this->var->add_def_cols('id_cta_activo', 'integer');
		$this->var->add_def_cols('desc_cta_activo', 'text');
		$this->var->add_def_cols('id_aux_activo', 'integer');
		$this->var->add_def_cols('desc_aux_activo', 'text');
		$this->var->add_def_cols('id_cta_dep_acumulada', 'integer');
		$this->var->add_def_cols('desc_cta_depacum', 'text');
		$this->var->add_def_cols('id_aux_depacum', 'integer');
		$this->var->add_def_cols('desc_aux_depacum', 'text');
		$this->var->add_def_cols('id_cta_gasto', 'integer');
		$this->var->add_def_cols('desc_cta_gasto', 'text');
		$this->var->add_def_cols('id_aux_cta_gasto', 'integer');
		$this->var->add_def_cols('desc_aux_gasto', 'text');
		$this->var->add_def_cols('nodo', 'varchar');
		$this->var->add_def_cols('desc_tipo_activo', 'text');
		
		$this->var->add_def_cols('nivel', 'integer');
		$this->var->add_def_cols('programa', 'varchar');
		$this->var->add_def_cols('tension', 'varchar');
		$this->var->add_def_cols('tipo_bien', 'varchar');
				
		// Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;	
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	EliminarPlanCuentas
	 * Propï¿½sito:				Eliminar registros de la tabla tal_plan_cuentas mediante filtros
	 * Autor:					UNKNOW
	 * Fecha de creaciï¿½n:		12-05-2015
	 */
	function EliminarPlanCuentas($id_plan_cuentas)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_plan_cuentas_iud';
		$this->codigo_procedimiento = "'AF_PLANCTAS_DEL'"; 
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)
		$this->var->add_param("$id_plan_cuentas");//af_id_plan_cuentas
		$this->var->add_param("NULL");//af_iid_plan_cuentas_fk
		$this->var->add_param("NULL");//af_codigo
		$this->var->add_param("NULL");//af_descripcion
		$this->var->add_param("NULL");//af_id_gestion
		$this->var->add_param("NULL");//af_id_tipo_activo
		$this->var->add_param("NULL");//af_id_cta_activo	
		$this->var->add_param("NULL");//af_id_cta_activo_aux
		$this->var->add_param("NULL");//af_id_cta_dep_acum
		$this->var->add_param("NULL");//af_id_cta_dep_acum_aux
		$this->var->add_param("NULL");//af_id_cta_gasto
		$this->var->add_param("NULL");//af_id_cta_gasto_auxiliar 
		$this->var->add_param("NULL");//af_estado
		$this->var->add_param("NULL");//af_nivel
		
		$this->var->add_param("NULL");//af_programa
		$this->var->add_param("NULL");//af_tension
		$this->var->add_param("NULL");//af_tipo_bien
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function InsertarPlanCuentas($id_plan_ctas,$id_plan_ctas_fk,$codigo,$descripcion,$estado,$id_tipo,$id_cta_activo,$id_aux_activo,$id_depacum,$id_aux_depacum,$id_gasto,$id_aux_gasto,$id_gestion,$nivel,$programa,$tension,$tipo_bien)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_plan_cuentas_iud';
		$this->codigo_procedimiento = "'AF_PLANCTAS_INS'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//af_id_plan_cuentas
		$this->var->add_param("$id_plan_ctas_fk");//af_id_plan_cuentas_fk
		$this->var->add_param("'$codigo'");//af_codigo
		$this->var->add_param("'$descripcion'");//af_descripcion
		$this->var->add_param("$id_gestion");//af_id_gestion
		$this->var->add_param("$id_tipo");//af_id_tipo_activo
		$this->var->add_param("$id_cta_activo");//af_id_cta_activo	
		$this->var->add_param("$id_aux_activo");//af_id_cta_activo_aux
		$this->var->add_param("$id_depacum");//af_id_cta_dep_acum
		$this->var->add_param("$id_aux_depacum");//af_id_cta_dep_acum_aux
		$this->var->add_param("$id_gasto");//af_id_cta_gasto
		$this->var->add_param("$id_aux_gasto");//af_id_cta_gasto_auxiliar 
		$this->var->add_param("'$estado'");//af_estado
		$this->var->add_param("$nivel");//af_nivel
		
		$this->var->add_param("'$programa'");//af_programa
		$this->var->add_param("'$tension'");//af_tension
		$this->var->add_param("'$tipo_bien'");//af_tipo_bien
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ModificarPlanCuentas($id_plan_ctas,$id_plan_ctas_fk,$codigo,$descripcion,$estado,$id_tipo,$id_cta_activo,$id_aux_activo,$id_depacum,$id_aux_depacum,$id_gasto,$id_aux_gasto,$id_gestion,$nivel,$programa,$tension,$tipo_bien)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_plan_cuentas_iud';
		$this->codigo_procedimiento = "'AF_PLANCTAS_UPD'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param("$id_plan_ctas");//af_id_plan_cuentas
		$this->var->add_param($id_plan_ctas_fk);//af_iid_plan_cuentas_fk
		$this->var->add_param("'$codigo'");//af_codigo
		$this->var->add_param("'$descripcion'");//af_descripcion
		$this->var->add_param("$id_gestion");//af_id_gestion
		$this->var->add_param("$id_tipo");//af_id_tipo_activo
		$this->var->add_param("$id_cta_activo");//af_id_cta_activo	
		$this->var->add_param("$id_aux_activo");//af_id_cta_activo_aux
		$this->var->add_param("$id_depacum");//af_id_cta_dep_acum
		$this->var->add_param("$id_aux_depacum");//af_id_cta_dep_acum_aux
		$this->var->add_param("$id_gasto");//af_id_cta_gasto
		$this->var->add_param("$id_aux_gasto");//af_id_cta_gasto_auxiliar 
		$this->var->add_param("'$estado'");//af_estado
		$this->var->add_param("$nivel");//af_nivel
		$this->var->add_param("'$programa'");//af_programa
		$this->var->add_param("'$tension'");//af_tension
		$this->var->add_param("'$tipo_bien'");//af_tipo_bien
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		echo $this->query;exit;
		return $res;
	}
	function ValidarUbicacionArb($operacion_sql, $id_ubicacion, $id_almacen, $id_ubicacion_fk, $codigo, $nombre, $estado) {
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		// Ejecuta la validaciï¿½n por el tipo de operaciï¿½n
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				// Validar id_persona - tipo int8
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_ubicacion");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ubicacion", $id_ubicacionion)) {
					$this->salida = $valid->salida;
					return false;
				}
			}
			// Validar id_almacen - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar id_ubicacion_fk - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ubicacion_fk");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ubicacion_fk", $id_ubicacion_fk)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado)) {
				$this->salida = $valid->salida;
				return false;
			}
			return true;
		} elseif ($operacion_sql == 'delete') {
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ubicacion");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ubicacion", $id_ubicacion)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}
	
	
	function ReportePlanCuentas($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_plan_cuentas_sel';
		$this->codigo_procedimiento = "'AF_REP_PLANCTAS'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
			
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('desc_tipo_af', 'text');
		$this->var->add_def_cols('programa', 'varchar');
		$this->var->add_def_cols('tension', 'text');
		$this->var->add_def_cols('tipo_bien', 'text');
		
		$this->var->add_def_cols('id_tipo_activo', 'integer');
		$this->var->add_def_cols('desc_tipo_activo', 'varchar');
		$this->var->add_def_cols('cta_activo', 'varchar');
		$this->var->add_def_cols('nombre_cta_activo', 'varchar');
		$this->var->add_def_cols('cta_dep_acum', 'varchar');
		$this->var->add_def_cols('nombre_cta_depacum', 'varchar');
		$this->var->add_def_cols('cta_gasto', 'varchar');
		$this->var->add_def_cols('nombre_cta_gasto', 'varchar');
		$this->var->add_def_cols('nivel', 'integer');
		$this->var->add_def_cols('gestion', 'numeric');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
}
?>
