<?php
/**
 * Nombre de la clase:	cls_DBGrupoSpDet.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_grupo_sp_det
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-20 17:42:54
 */

 
class cls_DBGrupoSpDet
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
	 * Nombre de la función:	ListarGrupoProcComMul
	 * Propósito:				Desplegar los registros de tad_grupo_sp_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:54
	 */
	function ListarGrupoProcComMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_grupo_sp_det_sel';
		$this->codigo_procedimiento = "'AD_GRUPCMDET_SEL'";

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
		$this->var->add_def_cols('id_grupo_sp_det','int4');
		$this->var->add_def_cols('id_proceso_compra_det','int4');
		$this->var->add_def_cols('desc_proceso_compra_det','numeric');
		$this->var->add_def_cols('id_solicitud_compra_det','int4');
		$this->var->add_def_cols('desc_solicitud_compra_det','numeric');
		$this->var->add_def_cols('desc_cotizacion_det','numeric');
		$this->var->add_def_cols('estado_reg','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarGrupoProcComMul
	 * Propósito:				Contar los registros de tad_grupo_sp_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:54
	 */
	function ContarGrupoProcComMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_grupo_sp_det_sel';
		$this->codigo_procedimiento = "'AD_GRUPCMDET_COUNT'";

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
	 * Nombre de la función:	ListarGrupoProcComMul
	 * Propósito:				Desplegar los registros de tad_grupo_sp_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:54
	 */
	function ListarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio){
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_grupo_sp_det_sel';
		$this->codigo_procedimiento = "'AD_GRUPO_SEL'";

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
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param($id_item);
		$this->var->add_param($id_servicio);

		
		
		$this->var->add_def_cols('id_grupo_sp_det','int4');
		$this->var->add_def_cols('id_proceso_compra','int4');
        $this->var->add_def_cols('id_proceso_compra_det','int4');
		$this->var->add_def_cols('id_solicitud_compra_det','int4');
        $this->var->add_def_cols('cantidad_proc','numeric');
		$this->var->add_def_cols('cantidad_sol','numeric');
        $this->var->add_def_cols('precio_referencial_estimado','numeric');
		$this->var->add_def_cols('id_item','int4');
        $this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('estado_reg' ,'varchar');
		$this->var->add_def_cols('num_solicitud' ,'int4');
		$this->var->add_def_cols('num_solicitud_sis' ,'int4');
		$this->var->add_def_cols('periodo' ,'int4');
		$this->var->add_def_cols('solicitante' ,'text');
        $this->var->add_def_cols('cantidad_adjudicada' ,'numeric');
	
		
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	/**
	 * Nombre de la función:	ListarGrupoProcComMul
	 * Propósito:				Desplegar los registros de tad_grupo_sp_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:54
	 */
	
	function ContarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_grupo_sp_det_sel';
		$this->codigo_procedimiento = "'AD_GRUPO_COUNT'";

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
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param($id_item);
		$this->var->add_param($id_servicio);

		
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
	 * Nombre de la función:	InsertarGrupoProcComMul
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_grupo_sp_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:54
	 */
	function InsertarGrupoProcComMul($id_grupo_sp_det,$id_proceso_compra_det,$id_solicitud_compra_det,$cantidad_adjudicada,$id_cotizacion_det,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_grupo_sp_det_iud';
		$this->codigo_procedimiento = "'AD_GRUPCMDET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_proceso_compra_det);
		$this->var->add_param($id_solicitud_compra_det);
		$this->var->add_param($cantidad_adjudicada);
		$this->var->add_param($id_cotizacion_det);
		$this->var->add_param("'$estado_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarGrupoProcComMul
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_grupo_sp_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:54
	 */
	function ModificarGrupoProcComMul($id_grupo_sp_det,$id_proceso_compra_det,$id_solicitud_compra_det,$cantidad_adjudicada,$id_cotizacion_det,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_grupo_sp_det_iud';
		$this->codigo_procedimiento = "'AD_GRUPCMDET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_grupo_sp_det);
		$this->var->add_param($id_proceso_compra_det);
		$this->var->add_param($id_solicitud_compra_det);
		$this->var->add_param($cantidad_adjudicada);
		$this->var->add_param($id_cotizacion_det);
		$this->var->add_param("'$estado_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarGrupoProcComMul
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_grupo_sp_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:54
	 */
	function EliminarGrupoProcComMul($id_grupo_sp_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_grupo_sp_det_iud';
		$this->codigo_procedimiento = "'AD_GRUPCMDET_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_grupo_sp_det);
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
	 * Nombre de la función:	ValidarGrupoProcComMul
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_grupo_sp_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:54
	 */
	function ValidarGrupoProcComMul($operacion_sql,$id_grupo_sp_det,$id_proceso_compra_det,$id_solicitud_compra_det,$cantidad_adjudicada,$id_cotizacion_det,$estado_reg)
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
				//Validar id_grupo_sp_det - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_grupo_sp_det");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo_sp_det", $id_grupo_sp_det))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_proceso_compra_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proceso_compra_det");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_compra_det", $id_proceso_compra_det))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_solicitud_compra_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_solicitud_compra_det");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_solicitud_compra_det", $id_solicitud_compra_det))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cantidad_adjudicada - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad_adjudicada");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "cantidad_adjudicada", $cantidad_adjudicada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cotizacion_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cotizacion_det");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cotizacion_det", $id_cotizacion_det))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_reg - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_grupo_sp_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_grupo_sp_det");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo_sp_det", $id_grupo_sp_det))
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