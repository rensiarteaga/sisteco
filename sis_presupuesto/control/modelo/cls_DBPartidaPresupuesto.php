<?php
/**
 * Nombre de la clase:	cls_DBPartidaPresupuesto.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_partida_presupuesto
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-07 17:57:06
 */

 
class cls_DBPartidaPresupuesto
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
	 * Nombre de la función:	ListarDetalleParidaFormulacion
	 * Propósito:				Desplegar los registros de tpr_partida_presupuesto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:06
	 */
	function ListarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_presupuesto_sel';
		$this->codigo_procedimiento = "'PR_DEPRGA_SEL'";

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
		$this->var->add_def_cols('id_partida_presupuesto','int4');
		$this->var->add_def_cols('codigo_formulario','varchar');
		$this->var->add_def_cols('fecha_elaboracion','timestamp');
		$this->var->add_def_cols('id_partida','int4');
		$this->var->add_def_cols('desc_partida','varchar');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','');
		$this->var->add_def_cols('id_partida_detalle','int4');
		$this->var->add_def_cols('mes_01','numeric');
		$this->var->add_def_cols('mes_02','numeric');
		$this->var->add_def_cols('mes_03','numeric');
		$this->var->add_def_cols('mes_04','numeric');
		$this->var->add_def_cols('mes_05','numeric');
		$this->var->add_def_cols('mes_06','numeric');
		$this->var->add_def_cols('mes_07','numeric');
		$this->var->add_def_cols('mes_08','numeric');
		$this->var->add_def_cols('mes_09','numeric');
		$this->var->add_def_cols('mes_10','numeric');
		$this->var->add_def_cols('mes_11','numeric');
		$this->var->add_def_cols('mes_12','numeric');
		$this->var->add_def_cols('id_partida_presupuesto','int4');
		$this->var->add_def_cols('desc_partida_presupuesto','');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDetalleParidaFormulacion
	 * Propósito:				Contar los registros de tpr_partida_presupuesto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:06
	 */
	function ContarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_presupuesto_sel';
		$this->codigo_procedimiento = "'PR_DEPRGA_COUNT'";

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
	 * Nombre de la función:	InsertarDetalleParidaFormulacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_partida_presupuesto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:06
	 */
	function InsertarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_presupuesto_iud';
		$this->codigo_procedimiento = "'PR_DEPRGA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo_formulario'");
		$this->var->add_param("'$fecha_elaboracion'");
		$this->var->add_param($id_partida);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_partida_detalle);
		$this->var->add_param($mes_01);
		$this->var->add_param($mes_02);
		$this->var->add_param($mes_03);
		$this->var->add_param($mes_04);
		$this->var->add_param($mes_05);
		$this->var->add_param($mes_06);
		$this->var->add_param($mes_07);
		$this->var->add_param($mes_08);
		$this->var->add_param($mes_09);
		$this->var->add_param($mes_10);
		$this->var->add_param($mes_11);
		$this->var->add_param($mes_12);
		$this->var->add_param($id_partida_presupuesto);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDetalleParidaFormulacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_partida_presupuesto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:06
	 */
	function ModificarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_presupuesto_iud';
		$this->codigo_procedimiento = "'PR_DEPRGA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_presupuesto);
		$this->var->add_param("'$codigo_formulario'");
		$this->var->add_param("'$fecha_elaboracion'");
		$this->var->add_param($id_partida);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_partida_detalle);
		$this->var->add_param($mes_01);
		$this->var->add_param($mes_02);
		$this->var->add_param($mes_03);
		$this->var->add_param($mes_04);
		$this->var->add_param($mes_05);
		$this->var->add_param($mes_06);
		$this->var->add_param($mes_07);
		$this->var->add_param($mes_08);
		$this->var->add_param($mes_09);
		$this->var->add_param($mes_10);
		$this->var->add_param($mes_11);
		$this->var->add_param($mes_12);
		$this->var->add_param($id_partida_presupuesto);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDetalleParidaFormulacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_partida_presupuesto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:06
	 */
	function EliminarDetalleParidaFormulacion($id_partida_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_presupuesto_iud';
		$this->codigo_procedimiento = "'PR_DEPRGA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_presupuesto);
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

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarDetalleParidaFormulacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_partida_presupuesto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 17:57:06
	 */
	function ValidarDetalleParidaFormulacion($operacion_sql,$id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto)
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
				//Validar id_partida_presupuesto - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_partida_presupuesto");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_presupuesto", $id_partida_presupuesto))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo_formulario - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_formulario");
			$tipo_dato->set_MaxLength(25);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_formulario", $codigo_formulario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_elaboracion - tipo timestamp
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_elaboracion");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fecha_elaboracion", $fecha_elaboracion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida", $id_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_presupuesto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_presupuesto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_presupuesto", $id_presupuesto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida_detalle - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_detalle");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_detalle", $id_partida_detalle))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_01 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_01");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_01", $mes_01))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_02 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_02");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_02", $mes_02))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_03 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_03");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_03", $mes_03))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_04 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_04");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_04", $mes_04))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_05 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_05");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_05", $mes_05))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_06 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_06");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_06", $mes_06))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_07 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_07");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_07", $mes_07))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_08 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_08");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_08", $mes_08))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_09 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_09");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_09", $mes_09))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_10 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_10");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_10", $mes_10))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_11 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_11");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_11", $mes_11))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_12 - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_12");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_12", $mes_12))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida_presupuesto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_presupuesto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_presupuesto", $id_partida_presupuesto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_partida_presupuesto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_presupuesto");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_presupuesto", $id_partida_presupuesto))
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