<?php
/**
 * Nombre de la clase:	cls_DBObservacionesVarias.php
 * PropÃ³sito:			Permite ejecutar toda la funcionalidad de la tabla taf_observaciones_varias
 * Autor:				unknow
 * Fecha creaciÃ³n:		28082015
 */

 
class cls_DBObservacionesVarias
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
	 * Nombre de la funciÃ³n:	ListarObservacionesVarias
	 * PropÃ³sito:				Desplegar los registros de taf_observaciones_varias
	 * Autor:				    
	 * Fecha de creaciÃ³n:		
	 */
	function ListarObservacionesVarias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_observaciones_varias_sel';
		$this->codigo_procedimiento = "'AF_OBSVAR_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuciÃ³n de la funciÃ³n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parÃ¡metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		$id_financiador="'$id_financiador'";
		//Carga los parÃ¡metros especÃ­ficos de la estructura programÃ¡tica
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definiciÃ³n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_observaciones_varias','integer');
		$this->var->add_def_cols('desc_observacion','text');
		$this->var->add_def_cols('fecha_reg','text');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('desc_activo','text');
		
		$this->var->add_def_cols('id_usuario_reg','integer');
		$this->var->add_def_cols('desc_persona','text');

		//Ejecuta la funciÃ³n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciÃ³n y retorna el resultado de la ejecuciÃ³n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamÃ³ a la funciÃ³n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la funciÃ³n:	ContarObservacionesVarias
	 * PropÃ³sito:				Contar el total de registros desplegados en funciÃ³n de los parÃ¡metros de filtro
	 * Autor:				
	 * Fecha de creaciÃ³n:		
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
	function ContarObservacionesVarias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_observaciones_varias_sel';
		$this->codigo_procedimiento = "'AF_OBSVAR_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuciÃ³n de la funciÃ³n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parÃ¡metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parÃ¡metros especÃ­ficos de la estructura programÃ¡tica
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definiciÃ³n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funciÃ³n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciÃ³n
		$this->salida = $this->var->salida;


		//Si la ejecuciÃ³n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];

		}

		//Obtiene la cadena con que se llamÃ³ a la funciÃ³n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		//Retorna el resultado de la ejecuciÃ³n
		return $res;
	}	
	/**
	 * Nombre de la funciÃ³n:	InsertarObservacionesVarias
	 * Autor:					UNKNOW
	 * Fecha de creaciÃ³n:		31082015
	 *
	 * @param unknown_type $id_reparacion
	 * @param unknown_type $fecha_desde
	 * @param unknown_type $fecha_hasta
	 * @param unknown_type $problema
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $observaciones
	 * @param unknown_type $estado
	 * @param unknown_type $id_institucion
	 * @param unknown_type $id_persona
	 * @param unknown_type $id_activo_fijo
	 * @return unknown
	 */
	function InsertarObservacionesVarias($id_obs_var,$id_activo,$txt_observaciones, $txt_estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_observaciones_varias_iud';
		$this->codigo_procedimiento = "'AF_OBSVAR_INS'";

		//Instancia la clase midlle para la ejecuciÃ³n de la funciÃ³n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//af_id_observaciones_varias
		$this->var->add_param($id_activo);//af_id_activo_fijo
		$this->var->add_param("'$txt_observaciones'");//desc_observacion
		$this->var->add_param("'$txt_estado'");//estado
		

      //  $this->var->add_param("'$servicio'");
       //Ejecuta la funciÃ³n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciÃ³n y retorna el resultado de la ejecuciÃ³n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamÃ³ a la funciÃ³n de postgres
		$this->query = $this->var->query;
      
		return $res;
		
		
	}
	
	/**
	 * Nombre de la funciÃ³n:	ModificarObservacionesVarias
	 * PropÃ³sito:				Permite ejecutar la función de modificación de la tabla 
	 * 							taf_observaciones_varias
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		28082015
	 */
	function ModificarObservacionesVarias($id_obs_var, $id_activo, $txt_observaciones, $txt_estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_observaciones_varias_iud';
		$this->codigo_procedimiento = "'AF_OBSVAR_UPD'";

		//Instancia la clase midlle para la ejecuciÃ³n de la funciÃ³n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_obs_var");//af_id_observaciones_varias
		$this->var->add_param("$id_activo");//af_id_activo_fijo
		$this->var->add_param("'$txt_observaciones'");//af_desc_observaciones
		$this->var->add_param("'$txt_estado'");//af_estado

		//Ejecuta la funciÃ³n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciÃ³n y retorna el resultado de la ejecuciÃ³n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamÃ³ a la funciÃ³n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funciÃ³n:	EliminarObservacionesVarias
	 * PropÃ³sito:				Permite ejecutar la funciÃ³n de eliminaciÃ³n de la tabla taf_observaciones_varias
	 * Autor:				    UNKNOW
	 * Fecha de creaciÃ³n:		31082015
	 */
	function EliminarObservacionesVarias($id_observacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_observaciones_varias_iud';
		$this->codigo_procedimiento = "'AF_OBSVAR_DEL'";

		//Instancia la clase midlle para la ejecuciÃ³n de la funciÃ³n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_observacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		//Ejecuta la funciÃ³n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciÃ³n y retorna el resultado de la ejecuciÃ³n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamÃ³ a la funciÃ³n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ValidarObservacionesVarias($operacion_sql, $id_obs_var, $txt_observaciones, $txt_estado)
	{
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
				$tipo_dato->set_Columna("id_observaciones_varias");
		
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_observaciones_varias", $id_obs_var)) {
					$this->salida = $valid->salida;
					return false;
				} 
			}
		    // Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("desc_observacion");
			$tipo_dato->set_MaxLength(700);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "desc_observacion", $txt_observaciones)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $txt_estado)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} 
	    else {
			return false;
		}
	}
	
	function ContarControlObservacionesVarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_observaciones_varias_sel';
		 
		$this->codigo_procedimiento = "'AF_CONTROLOBS_COUNT'";
		
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
	
	function ListarControlObservacionesVarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_observaciones_varias_sel';
		
		//cambio de codigo_procedimiento si filtro_item -> solicitud de salida
		$this->codigo_procedimiento = "'AF_CONTROLOBS_SEL'";
		
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
		$this->var->add_def_cols('id_rol', 'integer');
		$this->var->add_def_cols('id_usuario', 'integer');
	

		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
}?>