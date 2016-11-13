<?php
/**
 * Nombre de la clase:	cls_DBDeptoConta.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_depto_conta
 * Autor:				avq
 * Fecha creación:		2009-06-16 18:30:13
 */

 
class cls_DBCierreApertura
{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	
	function construct()
	{
		$this->decodificar=$decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarDepartamentoConta
	 * Propósito:				Desplegar los registros de tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-16 18:32:13
	 */
	function ListarCierreApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_volcar,$siguiente_gestion,$cta_dif,$sw_act,$dpto_conta,$g_actual,$g_nueva,$moneda,$eeff)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cierre_apertura_sel';
		$this->codigo_procedimiento = "'CT_CIEAPER_SEL'";

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
		
		
		//Carga de parametros de la vista
		$this->var->add_param($func->iif($sw_volcar == '',"'%'","'$sw_volcar'"));//sw_volcar
		$this->var->add_param($func->iif($siguiente_gestion == '',"'%'","'$siguiente_gestion'"));//sgte gestion
		$this->var->add_param($func->iif($cta_dif == '',"'%'","'$cta_dif'"));//cuenta diferencia
		$this->var->add_param($func->iif($sw_act == '',"'%'","'$sw_act'"));//actualizacion
		$this->var->add_param($func->iif($dpto_conta == '',"'%'","'$dpto_conta'"));//departamento contable
		$this->var->add_param($func->iif($g_actual == '',"'%'","'$g_actual'"));//gestion actual
		$this->var->add_param($func->iif($g_nueva == '',"'%'","'$g_nueva'"));//gestion nueva
		$this->var->add_param($func->iif($moneda == '',"'%'","'$moneda'"));//moneda
		$this->var->add_param($func->iif($eeff == '',"'%'","'$eeff'"));//estado financiero
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cierre_apertura','integer');
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('nro_cbte','integer');
		$this->var->add_def_cols('id_gestion_actual','integer');
		$this->var->add_def_cols('gestion_actual','NUMERIC');
		$this->var->add_def_cols('id_gestion_nueva','integer');
		$this->var->add_def_cols('gestion_nueva','NUMERIC');
		$this->var->add_def_cols('sw_volcar','VARCHAR');
		$this->var->add_def_cols('sw_siguiente_gestion','VARCHAR');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nombre','VARCHAR');
		$this->var->add_def_cols('sw_actualizacion','VARCHAR');
		$this->var->add_def_cols('sw_estado','VARCHAR');
		$this->var->add_def_cols('id_reporte_eeff','INTEGER');
		$this->var->add_def_cols('nombre_eeff','VARCHAR');
		$this->var->add_def_cols('id_cuenta_diferencia','INTEGER');
		$this->var->add_def_cols('cuenta','TEXT');
		$this->var->add_def_cols('id_depto_conta','INTEGER');
		 
        
 
        
        
        //$this->var->add_def_cols('id_cuenta_diferencia','int4');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDepartamento
	 * Propósito:				Contar los registros de tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ContarCierreApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_volcar,$siguiente_gestion,$cta_dif,$sw_act,$dpto_conta,$g_actual,$g_nueva,$moneda,$eeff)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cierre_apertura_sel';
		$this->codigo_procedimiento = "'CT_CIEAPER_COUNT'";

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
		
		//Carga de parametros de la vista
		$this->var->add_param($func->iif($sw_volcar == '',"'%'","'$sw_volcar'"));//sw_volcar
		$this->var->add_param($func->iif($siguiente_gestion == '',"'%'","'$siguiente_gestion'"));//sgte gestion
		$this->var->add_param($func->iif($cta_dif == '',"'%'","'$cta_dif'"));//cuenta diferencia
		$this->var->add_param($func->iif($sw_act == '',"'%'","'$sw_act'"));//actualizacion
		$this->var->add_param($func->iif($dpto_conta == '',"'%'","'$dpto_conta'"));//departamento contable
		$this->var->add_param($func->iif($g_actual == '',"'%'","'$g_actual'"));//gestion actual
		$this->var->add_param($func->iif($g_nueva == '',"'%'","'$g_nueva'"));//gestion nueva
		$this->var->add_param($func->iif($moneda == '',"'%'","'$moneda'"));//moneda
		$this->var->add_param($func->iif($eeff == '',"'%'","'$eeff'"));//estado financiero
		
		
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
	 * Nombre de la función:	InsertarActualizacion
	 * Propósito:				Permite ejecutar la función de generar comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function GenerarCbteCierreApertura($id_cierre_apertura )
	{
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_i_ct_gestionar_generacion_comprobantes_sci';
		$this->codigo_procedimiento = "'CT_CONTCIERREAPERTURA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cierre_apertura");
		//echo '$id_actualizacion'.$id_actualizacion; exit();
	 
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
        //echo $this->query;
        //exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarDepartamentoContabilidad
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-17 8:58:13
	 */
	function InsertarCierreApertura(
	$ct_id_cierre_apertura,
	$ct_id_comprobante,
	$ct_descripcion,
	$ct_nro_cbte,
	$ct_id_reporte_eeff,
	$ct_sw_volcar,
	$ct_sw_siguiente_gestion,
	$ct_id_cuenta_diferencia,
	$ct_sw_actualizacion,
	$ct_id_depto_conta,
	$ct_id_gestion_actual,
	$ct_id_gestion_nueva,
	$ct_sw_estado,
	$ct_id_moneda)
	{	
		
		//$ct_id_comprobante=(int)$ct_id_comprobante;
      //$ct_nro_cbte=(int)$ct_nro_cbte;
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cierre_apertura_iud';
		$this->codigo_procedimiento = "'CT_CIEAPER_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($ct_id_comprobante);
		$this->var->add_param("'$ct_descripcion'");
		$this->var->add_param($ct_nro_cbte);
		$this->var->add_param($ct_id_reporte_eeff);
		$this->var->add_param("'$ct_sw_volcar'");
		$this->var->add_param("'$ct_sw_siguiente_gestion'");
		$this->var->add_param($ct_id_cuenta_diferencia);
		$this->var->add_param("'$ct_sw_actualizacion'");
        $this->var->add_param($ct_id_depto_conta);
        $this->var->add_param($ct_id_gestion_actual);
        $this->var->add_param($ct_id_gestion_nueva);
        $this->var->add_param("'$ct_sw_estado'");
        $this->var->add_param($ct_id_moneda);
        
        
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
       /* echo $this->query;
        exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDepartamentoConta
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-18 9:10:13
	 */
					 
	function ModificarCierreApertura($ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cierre_apertura_iud';
		$this->codigo_procedimiento = "'CT_CIEAPER_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($ct_id_cierre_apertura);
		$this->var->add_param($ct_id_comprobante);
		$this->var->add_param("'$ct_descripcion'");
		$this->var->add_param($ct_nro_cbte);
		$this->var->add_param($ct_id_reporte_eeff);
		$this->var->add_param("'$ct_sw_volcar'");
		$this->var->add_param("'$ct_sw_siguiente_gestion'");
		$this->var->add_param($ct_id_cuenta_diferencia);
		$this->var->add_param("'$ct_sw_actualizacion'");
        $this->var->add_param($ct_id_depto_conta);
        $this->var->add_param($ct_id_gestion_actual);
        $this->var->add_param($ct_id_gestion_nueva);
        $this->var->add_param("'$ct_sw_estado'");
        $this->var->add_param($ct_id_moneda);
        
        
        
        // agregado en fecha 02 feb 2011
       
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
        exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDepartamentoConta
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-18 9:19:13
	 */
	function EliminarCierreApertura($id_cierre_apertura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_cierre_apertura_iud';
		$this->codigo_procedimiento = "'CT_CIEAPER_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cierre_apertura);
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
	 * Nombre de la función:	ValidarDepartamentoConta
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-17 9:20:13
	 */
	function ValidarCierreApertura($operacion_sql,$ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda)
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
				//Validar id_depto - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cierre_apertura");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cierre_apertura", $ct_id_cierre_apertura))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
		
		 
		
			
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_depto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cierre_apertura");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cierre_apertura", $ct_id_cierre_apertura))
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