<?php
/**
 * Nombre de la clase:	cls_DBViaPasaje.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_cuenta_doc_det
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-21 15:43:28
 */

class cls_DBViaPasaje
{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;

	function __construct(){
		$this->decodificar=$decodificar;
	}

	/**
	 * Nombre de la función:	ListarViaPasaje
	 * Propósito:				Desplegar los registros de tts_cuenta_doc_det
	 * Autor:				    TSL
	 * Fecha de creación:		2009.11.12
	 */
	function ListarViaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_via_pasaje_sel';
		$this->codigo_procedimiento = "'TS_VIAPAS_SEL'";

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
		$this->var->add_def_cols('id_cuenta_doc_det','int4');
		$this->var->add_def_cols('sw_confirma','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('fecha_ini', 'date' );
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('importe_ant','numeric');
		$this->var->add_def_cols('pasaje_cobrar','numeric');
		$this->var->add_def_cols('pasaje_credito','numeric');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('pasaje_orden','numeric');
		$this->var->add_def_cols('nota_debito','varchar');
		$this->var->add_def_cols('no_utilizado','varchar');
		$this->var->add_def_cols('recorrido','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('desc_concepto_ingas','text');
		$this->var->add_def_cols('partida','text');
		$this->var->add_def_cols('solicitante','text');
		$this->var->add_def_cols('fecha_sol', 'date' );
		$this->var->add_def_cols('fecha_fin', 'date' );
		$this->var->add_def_cols('importe_actual','numeric');
		$this->var->add_def_cols('id_devengado','integer');
		$this->var->add_def_cols('pasaje_nro','varchar');
		$this->var->add_def_cols('pasaje_fecha', 'date' );
		$this->var->add_def_cols('responsable','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*if($_SESSION["ss_id_usuario"]==120){
		echo "query:".$this->query;
	exit;
		}*/
		return $res;
	}

	/**
	 * Nombre de la función:	ContarViaPasaje
	 * Propósito:				Contar los registros de tts_cuenta_doc_det
	 * Autor:				    TSL
	 * Fecha de creación:		2009.11.12
	 */
	function ContarViaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_via_pasaje_sel';
		$this->codigo_procedimiento = "'TS_VIAPAS_COUNT'";

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

		//Si la ejecución fue satisfactoria modifica la salida para que solo Viauelva el total de la consulta
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
	 * Nombre de la función:	ModificarViaPasaje
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_Via_pasaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ModificarViaPasaje($id_cuenta_doc_det,$importe_nuevo,$nota_debito,$pasaje_utilizado,$pasaje_nro,$pasaje_fecha,$id_presupuesto,$tipo,$pasaje_credito,$pasaje_cobar,$pasaje_orden)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_via_pasaje_iud';
		if($tipo=='utilizado')
			$this->codigo_procedimiento = "'TS_PASUTI_UPD'";
		else 
			if($tipo=='presupuesto')
				$this->codigo_procedimiento = "'TS_PASPPTO_UPD'";
			else
				if($tipo=='cancela')
					$this->codigo_procedimiento = "'TS_PASDEL_UPD'";
				else
					if($tipo=='edita')
						$this->codigo_procedimiento = "'TS_PASEDI_UPD'";
					else
						if($tipo=='utipasaje')
							$this->codigo_procedimiento = "'TS_UTIPAS_UPD'";
						else
							if($tipo=='finaliza')//oct2015
								$this->codigo_procedimiento = "'TS_PASFIN_UPD'";//oct2015
							else
								$this->codigo_procedimiento = "'TS_VIAPAS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_doc_det);
		$this->var->add_param($importe_nuevo);
		$this->var->add_param("'$nota_debito'");
		$this->var->add_param("'$pasaje_utilizado'");
		$this->var->add_param("'$pasaje_nro'");
		$this->var->add_param("'$pasaje_fecha'");
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($pasaje_credito);
		$this->var->add_param($pasaje_cobar);
		$this->var->add_param($pasaje_orden);
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
	 * Nombre de la función:	ValidarViaPasaje
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_Via_pasaje
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ValidarViaPasaje($operacion_sql,$id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones)
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
				//Validar id_Via_pasaje - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cuenta_doc_det");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_doc_det", $id_Via_pasaje))
				{
					$this->salida = $valid->salida;
					return false;
				}

			}

			//Validar importe_Viaengado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_select");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "sw_select", $importe_Viaengado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_Via_pasaje - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_doc_det");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_doc_det", $id_Via_pasaje))
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