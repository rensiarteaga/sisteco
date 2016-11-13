<?php
/**
 * Nombre de la clase:	cls_DBDevengadoDetalle.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_devengado_detalle
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-21 15:43:28
 */


class cls_DBDevengadoDetalle
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
	 * Nombre de la función:	ListarDevengadoDetalle
	 * Propósito:				Desplegar los registros de tts_devengado_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ListarDevengadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_detalle_sel';
		$this->codigo_procedimiento = "'TS_DETDEV_SEL'";

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
		$this->var->add_def_cols('id_devengado_detalle','int4');
		$this->var->add_def_cols('id_devengado','int4');
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','int4');
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('porcentaje_devengado','numeric');
		$this->var->add_def_cols('importe_devengado','numeric');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('aprobado','numeric');
		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('disponibilidad','varchar');
		$this->var->add_def_cols('id_partida_ejecucion','integer');
		$this->var->add_def_cols('estado_devengado','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/* if($_SESSION['ss_id_usuario']==131){
		 echo $this->query;
		exit;
		}*/
		return $res;
	}

	/**
	 * Nombre de la función:	ContarDevengadoDetalle
	 * Propósito:				Contar los registros de tts_devengado_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ContarDevengadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_detalle_sel';
		$this->codigo_procedimiento = "'TS_DETDEV_COUNT'";

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
	 * Nombre de la función:	InsertarDevengadoDetalle
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_devengado_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function InsertarDevengadoDetalle($id_devengado_detalle,$id_devengado,$id_presupuesto,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_detalle_iud';
		$this->codigo_procedimiento = "'TS_DETDEV_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_devengado);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($porcentaje_devengado);
		$this->var->add_param($importe_devengado);
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_usuario");
 

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "query: ".$this->query;
		//exit;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarDevengadoDetalle
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_devengado_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ModificarDevengadoDetalle($id_devengado_detalle,$id_devengado,$id_presupuesto,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_detalle_iud';
		$this->codigo_procedimiento = "'TS_DETDEV_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado_detalle);
		$this->var->add_param($id_devengado);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($porcentaje_devengado);
		$this->var->add_param($importe_devengado);
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_usuario");
 

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarDevengadoDetalle
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function EliminarDevengadoDetalle($id_devengado_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_detalle_iud';
		$this->codigo_procedimiento = "'TS_DETDEV_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado_detalle);
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

		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	AjustarDevengadoDetalle
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado_detalle
	 * Autor:				    RCM
	 * Fecha de creación:		27/10/2008
	 */
	function AjustarDevengadoDetalle($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_detalle_iud';
		$this->codigo_procedimiento = "'TS_DETDEV_AJU'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_devengado);
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

		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	AprobarDevengadoDetalle
	 * Propósito:				Aprobación de Devengado Detalle
	 * Autor:				    RCM
	 * Fecha de creación:		10/03/2009
	 */
	function AprobarDevengadoDetalle($id_devengado_detalle,$aprobacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_detalle_iud';
		$this->codigo_procedimiento = "'TS_DETDEV_APR'";
		
		//echo "modelo aprobacion: ".$aprobacion;
		//exit;

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_devengado_detalle");
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
		$this->var->add_param("$aprobacion");
		$this->var->add_param("NULL");
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "query:".$this->query;
		//exit;

		return $res;
	}

	/**
	 * Nombre de la función:	ValidarDevengadoDetalle
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_devengado_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:28
	 */
	function ValidarDevengadoDetalle($operacion_sql,$id_devengado_detalle,$id_devengado,$id_presupuesto,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$porc_monto)
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
				//Validar id_devengado_detalle - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_devengado_detalle");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado_detalle", $id_devengado_detalle))
				{
					$this->salida = $valid->salida;
					return false;
				}

			}

			//Validar id_devengado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_devengado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado", $id_devengado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_financiador - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_financiador");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_financiador", $id_financiador))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_regional - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_regional");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_regional", $id_regional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_programa - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_programa");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_programa", $id_programa))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proyecto - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proyecto");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proyecto", $id_proyecto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_actividad - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_actividad");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_actividad", $id_actividad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_organizacional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar porcentaje_devengado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("porcentaje_devengado");
			$tipo_dato->set_MaxLength(393218);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "porcentaje_devengado", $porcentaje_devengado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_devengado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_devengado");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_devengado", $importe_devengado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_devengado_detalle - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_devengado_detalle");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado_detalle", $id_devengado_detalle))
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