<?php
/**
 * Nombre de la Clase:	cls_DBSalidaUnidadConstructiva
 * Prop�sito:			Permite ejecutar la funcionalidad de la tabla tal_salida_uc
 * Autor:				UNKNOW
 * Fecha creaci�n:		23-12-2014
 *
 */
class cls_DBSalidaUnidadConstructiva
{
	// Variable que contiene la salida de la ejecuci�n de la funci�n
	// si la funci�n tuvo error (false), salida contendr� el mensaje de error
	// si la funci�n no tuvo error (true), salida contendr� el resultado, ya sea un conjunto de datos o un mensaje de confirmaci�n
	var $salida;
	
	// Variable que contedr� la cadena de llamada a las funciones postgres
	var $query;
	
	// Variables para la ejecuci�n de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la funci�n a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBSalidaUnidadConstructiva.php";
	
	// Matriz de par�metros de validaci�n de todas las columnas
	var $matriz_validacion = array ();
	
	// Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;
	function __construct() {
		// Carga los par�metro de validaci�n de todas las columnas
		// $this->cargar_param_valid();
		
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	
	/**
	 * Nombre de la funci�n:	ListarSalidaUnidadesConstructivas
	 * Prop�sito:				Desplegar los registros de tal_salida_uc en funci�n de los par�metros del filtro
	 * Autor:					UNKNOW
	 * Fecha de creaci�n:		23-12-2014
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
	function ListarSalidaUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_sel';
		$this->codigo_procedimiento = "'AL_SALUC_SEL'";
		
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
		$this->var->add_def_cols('id_salida_uc', 'integer');
		$this->var->add_def_cols('id_almacen', 'integer');
		$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('id_contratista', 'integer');
		$this->var->add_def_cols('desc_contratista', 'text'); 
		$this->var->add_def_cols('id_proveedor', 'integer');
		$this->var->add_def_cols('desc_proveedor', 'text');
		$this->var->add_def_cols('id_empleado', 'integer');
		$this->var->add_def_cols('desc_empleado', 'text');
		$this->var->add_def_cols('id_institucion', 'integer');
		$this->var->add_def_cols('desc_institucion', 'varchar');
		$this->var->add_def_cols('id_fase', 'integer');
		$this->var->add_def_cols('desc_fase', 'text');
		$this->var->add_def_cols('id_tramo', 'integer');
		$this->var->add_def_cols('desc_tramo', 'text');
		$this->var->add_def_cols('id_unidad_constructiva', 'integer');
		$this->var->add_def_cols('desc_uc', 'text');
		$this->var->add_def_cols('nro_contrato', 'varchar');
		$this->var->add_def_cols('fecha_salida', 'text'); 
		$this->var->add_def_cols('concepto_salida', 'varchar');
		$this->var->add_def_cols('observaciones', 'varchar');
		$this->var->add_def_cols('supervisor', 'varchar');
		$this->var->add_def_cols('ci_supervisor', 'varchar');
		$this->var->add_def_cols('receptor', 'varchar');
		$this->var->add_def_cols('ci_receptor', 'varchar');
		$this->var->add_def_cols('solicitante', 'varchar');
		$this->var->add_def_cols('ci_solicitante', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('origen_salida', 'varchar');
		
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('codigo', 'varchar');

		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ContarSalidaUnidadConstructiva
	 * Prop�sito:				Contar el total de registros desplegados en funci�n de los par�metros de filtro
	 * Autor:					UNKNOW
	 * Fecha de creaci�n:		23-12-2014
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
	function ContarSalidaUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_sel';
		$this->codigo_procedimiento = "'AL_SALUC_COUNT'";
		
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
		$this->var->add_def_cols('total', 'bigint');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		
		// Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	
		// Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarSalidaUC
	 * Prop�sito:				Eliminar registros de la tabla tal_salida_uc mediante filtros
	 * Autor:					UNKNOW
	 * Fecha de creaci�n:		26-12-2014
	 */
	function EliminarSalidaUC($id_salida_uc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_iud';
		$this->codigo_procedimiento = "'AL_SALUC_DEL'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		$this->var->add_param($id_salida_uc);//al_id_salida_uc
		$this->var->add_param("NULL");//al_id_almacen
		$this->var->add_param("NULL");//al_origen_salida
		$this->var->add_param("NULL");//al_id_contratista
		$this->var->add_param("NULL");//al_id_proveedor
		$this->var->add_param("NULL");//al_id_empleado
		$this->var->add_param("NULL");//al_id_institucion
		
		$this->var->add_param("NULL");//al_nro_contrato
		$this->var->add_param("NULL");//al_fecha_salida
		$this->var->add_param("NULL");//al_concepto_salida
		$this->var->add_param("NULL");//al_observaciones
		$this->var->add_param("NULL");//al_id_fase
		$this->var->add_param("NULL");//al_id_tramo
		$this->var->add_param("NULL");//al_id_unidad_constructiva
		$this->var->add_param("NULL");//al_supervisor
		$this->var->add_param("NULL");//al_ci_supervisor
		$this->var->add_param("NULL");//al_receptor 
		$this->var->add_param("NULL");//al_ci_receptor
		$this->var->add_param("NULL");//al_solicitante
		$this->var->add_param("NULL");//al_ci_solicitante
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function InsertarSalidaUC($id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal, $observaciones,$origen_sal,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_iud';
		$this->codigo_procedimiento = "'AL_SALUC_INS'";
	
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//al_id_salida_uc
		$this->var->add_param($id_almacen);//al_id_almacen
		$this->var->add_param("'$origen_sal'");//al_origen_salida
		$this->var->add_param($id_contratista);//al_id_contratista
		$this->var->add_param($id_proveedor);//al_id_proveedor
		$this->var->add_param($id_empleado);//al_id_empleado
		$this->var->add_param($id_institucion);//al_id_institucion
		
		$this->var->add_param("'$num_contrato'");//al_nro_contrato
		$this->var->add_param("'$fecha_sal'");//al_fecha_salida
		$this->var->add_param("'$concepto_sal'");//al_concepto_salida
		$this->var->add_param("'$observaciones'");//al_observaciones
		$this->var->add_param($id_fase);//al_id_fase
		$this->var->add_param($id_tramo);//al_id_tramo
		$this->var->add_param($id_uc);//al_id_unidad_constructiva
		$this->var->add_param("'$supervisor'");//al_supervisor
		$this->var->add_param("'$ci_supervisor'");//al_ci_supervisor
		$this->var->add_param("'$receptor'");//al_receptor
		$this->var->add_param("'$ci_receptor'");//al_ci_receptor
		$this->var->add_param("'$solicitante'");//al_solicitante
		$this->var->add_param("'$ci_solicitante'");//al_ci_solicitante

		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ModificarSalidaUC($id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal, $observaciones,$origen_sal,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_iud';
		$this->codigo_procedimiento = "'AL_SALUC_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
	
		$this->var->add_param($id_salida_uc);//al_id_salida_uc
		$this->var->add_param($id_almacen);//al_id_almacen
		$this->var->add_param("'$origen_sal'");//al_origen_salida
		$this->var->add_param($id_contratista);//al_id_contratista
		$this->var->add_param($id_proveedor);//al_id_proveedor
		$this->var->add_param($id_empleado);//al_id_empleado
		$this->var->add_param($id_institucion);//al_id_institucion
		
		$this->var->add_param("'$num_contrato'");//al_nro_contrato
		$this->var->add_param("'$fecha_sal'");//al_fecha_salida
		$this->var->add_param("'$concepto_sal'");//al_concepto_salida
		$this->var->add_param("'$observaciones'");//al_observaciones
		$this->var->add_param($id_fase);//al_id_fase
		$this->var->add_param($id_tramo);//al_id_tramo
		$this->var->add_param($id_uc);//al_id_unidad_constructiva
		$this->var->add_param("'$supervisor'");//al_supervisor
		$this->var->add_param("'$ci_supervisor'");//al_ci_supervisor
		$this->var->add_param("'$receptor'");//al_receptor
		$this->var->add_param("'$ci_receptor'");//al_ci_receptor
		$this->var->add_param("'$solicitante'");//al_solicitante
		$this->var->add_param("'$ci_solicitante'");//al_ci_solicitante
		
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	function ValidarSalidaUC($sql, $id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal,$observaciones,$origen_sal,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		// Ejecuta la validaci�n por el tipo de operaci�n
		if ($sql == 'insert' || $sql == 'update') 
		{
			if ($sql == 'update') 
			{
				// Validar id_persona - tipo int8
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_salida_uc");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida_uc", $id_salida_uc)) 
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			// Validar id_almacen - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			$tipo_dato->set_MinLength(1);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar nro_contrato - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_contrato");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_contrato", $num_contrato)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar $concepto_sal - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("concepto_salida");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "concepto_salida", $concepto_sal)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar $observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(250);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar $supervisor - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("supervisor");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "supervisor", $supervisor)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar $ci_supervisor - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("ci_supervisor");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "ci_supervisor", $ci_supervisor)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar $receptor - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("receptor");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "receptor", $receptor)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar $ci_supervisor - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("ci_receptor");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "ci_receptor", $ci_receptor)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar $solicitante - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("solicitante");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "solicitante", $solicitante)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar $solicitante - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("ci_solicitante");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "ci_solicitante", $ci_solicitante)) {
				$this->salida = $valid->salida;
				return false;
			}
			
		
			return true;
		} 
		elseif ($operacion_sql == 'delete') 
		{
			// Validar id_reclamo - tipo int8
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_salida_uc");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida_uc", $id_salida_uc)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} 
		else {
			return false;
		}
	}

	function ProcesarMovimientoSalidaProyecto($id_salida_uc,$accion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_iud';
		
		if($accion == 'finalizar_mov')
			$this->codigo_procedimiento = "'AL_FIN_SALUC'";
		elseif ($accion == 'corregir_mov') 
			$this->codigo_procedimiento = "'AL_CORREG_SALUC'";
	
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_salida_uc);//al_id_salida_uc
		$this->var->add_param("NULL");//al_id_almacen
		$this->var->add_param("NULL");//al_origen_salida
		$this->var->add_param("NULL");//al_id_contratista
		$this->var->add_param("NULL");//al_id_proveedor
		$this->var->add_param("NULL");//al_id_empleado
		$this->var->add_param("NULL");//al_id_institucion
		
		$this->var->add_param("NULL");//al_nro_contrato
		$this->var->add_param("NULL");//al_fecha_salida
		$this->var->add_param("NULL");//al_concepto_salida
		$this->var->add_param("NULL");//al_observaciones
		$this->var->add_param("NULL");//al_id_fase
		$this->var->add_param("NULL");//al_id_tramo
		$this->var->add_param("NULL");//al_id_unidad_constructiva
		$this->var->add_param("NULL");//al_supervisor
		$this->var->add_param("NULL");//al_ci_supervisor
		$this->var->add_param("NULL");//al_receptor
		$this->var->add_param("NULL");//al_ci_receptor
		$this->var->add_param("NULL");//al_solicitante
		$this->var->add_param("NULL");//al_ci_solicitante

		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
}
?>
