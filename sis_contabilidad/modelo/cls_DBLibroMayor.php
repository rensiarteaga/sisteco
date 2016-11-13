<?php
/**
 * Nombre de la clase:	cls_DBLibroMayor.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_comprobante
 * Autor:				Ana Maria
 * Fecha creación:		2009-06-15 17:55:36
 */

 
class cls_DBLibroMayor
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
	 * Nombre de la función:	Reporte para Libro Mayor x Partidas la cabecera 
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    JGL
	 * Fecha de creación:		11/08/2010
	 * */
	 
	function ListarMayorComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_mayor_uo_epe_ot_cta_aux_sel';
		$this->codigo_procedimiento = "'CT_MAY_UO_EPE_OT_CTA_AUX_SEL'";

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
		
		$this->var->add_param($id_gestion);//ct_id_gestion
        $this->var->add_param($id_depto);//ct_id_depto
        $this->var->add_param("'$fecha_inicio'");//ct_fecha_inicio
        $this->var->add_param("'$fecha_final'");//ct_fecha_final
        $this->var->add_param("'$sw_cuenta'");//ct_sw_cuenta
        $this->var->add_param("'$sw_auxiliar'");//ct_sw_auxiliar
        $this->var->add_param("'$sw_epe'");//ct_sw_epe
        $this->var->add_param("'$sw_uo'");//ct_sw_uo
        $this->var->add_param("'$sw_ot'");//ct_sw_ot
        $this->var->add_param($id_cuenta_inicial);//ct_id_cuenta_inicial
        $this->var->add_param($id_cuenta_final);//ct_id_cuenta_final
        $this->var->add_param($id_auxiliar_inicial);//ct_id_auxiliar_inicial
        $this->var->add_param($id_auxiliar_final);//ct_id_auxiliar_final
        $this->var->add_param($id_epe_inicial);//ct_id_epe_inicial
        $this->var->add_param($id_epe_final);//ct_id_epe_final
        $this->var->add_param($id_uo_inicial);//ct_id_uo_inicial
        $this->var->add_param($id_uo_final);//ct_id_uo_final
        $this->var->add_param($id_ot_inicial);//ct_id_ot_inicial
        $this->var->add_param($id_ot_final);//ct_id_ot_final
        $this->var->add_param($sw_estado_cbte);//ct_sw_estado_cbte
        $this->var->add_param("'$sw_listado'");//ct_sw_listado
        $this->var->add_param($id_moneda);//ct_id_moneda
        $this->var->add_param("'$sw_actualizacion'");//$sw_actualizacion
 
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_uo_epe_ot_cta_aux','INTEGER');
		$this->var->add_def_cols('codigo','TEXT');
		$this->var->add_def_cols('nombre','TEXT');
		
	 	//$this->var->add_def_cols('nombre_auxiliar','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo  $this->query;exit;
		
	return $res;
	} 
	/**
	 * Nombre de la función:	Reporte para Libro Mayor x Partidas la cabecera 
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    JGL
	 * Fecha de creación:		11/08/2010
	 * */
	function ContarMayorComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_mayor_uo_epe_ot_cta_aux_sel';
		$this->codigo_procedimiento = "'CT_MAY_UO_EPE_OT_CTA_AUX_COUNT'";

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
		
		
		$this->var->add_param($id_gestion);//ct_id_gestion
        $this->var->add_param($id_depto);//ct_id_depto
        $this->var->add_param("'$fecha_inicio'");//ct_fecha_inicio
        $this->var->add_param("'$fecha_final'");//ct_fecha_final
        $this->var->add_param("'$sw_cuenta'");//ct_sw_cuenta
        $this->var->add_param("'$sw_auxiliar'");//ct_sw_auxiliar
        $this->var->add_param("'$sw_epe'");//ct_sw_epe
        $this->var->add_param("'$sw_uo'");//ct_sw_uo
        $this->var->add_param("'$sw_ot'");//ct_sw_ot
        $this->var->add_param($id_cuenta_inicial);//ct_id_cuenta_inicial
        $this->var->add_param($id_cuenta_final);//ct_id_cuenta_final
        $this->var->add_param($id_auxiliar_inicial);//ct_id_auxiliar_inicial
        $this->var->add_param($id_auxiliar_final);//ct_id_auxiliar_final
        $this->var->add_param($id_epe_inicial);//ct_id_epe_inicial
        $this->var->add_param($id_epe_final);//ct_id_epe_final
        $this->var->add_param($id_uo_inicial);//ct_id_uo_inicial
        $this->var->add_param($id_uo_final);//ct_id_uo_final
        $this->var->add_param($id_ot_inicial);//ct_id_ot_inicial
        $this->var->add_param($id_ot_final);//ct_id_ot_final
        $this->var->add_param($sw_estado_cbte);//ct_sw_estado_cbte
        $this->var->add_param("'$sw_listado'");//ct_sw_listado
        $this->var->add_param($id_moneda);//ct_id_moneda
        $this->var->add_param("'$sw_actualizacion'");//$sw_actualizacion
        
       
	
		
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

	    //echo $this->query;
		//exit();  //Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	Reporte para Libro Mayor x Partidas la cabecera 
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    JGL
	 * Fecha de creación:		11/08/2010
	 * */
	 
	function ListarMayorEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_mayor_uo_epe_ot_cta_aux_sel';
		$this->codigo_procedimiento = "'CT_CABECERA_UO_EPE_OT_CTA_AUX_SEL'";

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
		
		$this->var->add_param($id_gestion);//ct_id_gestion
        $this->var->add_param($id_depto);//ct_id_depto
        $this->var->add_param("'$fecha_inicio'");//ct_fecha_inicio
        $this->var->add_param("'$fecha_final'");//ct_fecha_final
        $this->var->add_param("'$sw_cuenta'");//ct_sw_cuenta
        $this->var->add_param("'$sw_auxiliar'");//ct_sw_auxiliar
        $this->var->add_param("'$sw_epe'");//ct_sw_epe
        $this->var->add_param("'$sw_uo'");//ct_sw_uo
        $this->var->add_param("'$sw_ot'");//ct_sw_ot
        $this->var->add_param($id_cuenta_inicial);//ct_id_cuenta_inicial
        $this->var->add_param($id_cuenta_final);//ct_id_cuenta_final
        $this->var->add_param($id_auxiliar_inicial);//ct_id_auxiliar_inicial
        $this->var->add_param($id_auxiliar_final);//ct_id_auxiliar_final
        $this->var->add_param($id_epe_inicial);//ct_id_epe_inicial
        $this->var->add_param($id_epe_final);//ct_id_epe_final
        $this->var->add_param($id_uo_inicial);//ct_id_uo_inicial
        $this->var->add_param($id_uo_final);//ct_id_uo_final
        $this->var->add_param($id_ot_inicial);//ct_id_ot_inicial
        $this->var->add_param($id_ot_final);//ct_id_ot_final
        $this->var->add_param($sw_estado_cbte);//ct_sw_estado_cbte
        $this->var->add_param("'$sw_listado'");//ct_sw_listado
        $this->var->add_param($id_moneda);//ct_id_moneda
        $this->var->add_param("'$sw_actualizacion'");//ct_id_moneda
 
                                                                             
        
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tt_tct_reporte_uo_epe_ot_cta_aux','INTEGER');
		$this->var->add_def_cols('id_reporte','integer');
		$this->var->add_def_cols('id_transaccion','INTEGER');
		$this->var->add_def_cols('fecha_cbte','text');
		$this->var->add_def_cols('nro_cbte','TEXT');
		$this->var->add_def_cols('concepto_cbte','TEXT');
		$this->var->add_def_cols('desc_componentes','TEXT');
		$this->var->add_def_cols('importe_debe','NUMERIC');
		$this->var->add_def_cols('importe_haber','NUMERIC');
		$this->var->add_def_cols('saldo','NUMERIC');
		
		
	 	//$this->var->add_def_cols('nombre_auxiliar','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo  $this->query;exit;
		/* if($_SESSION["ss_id_usuario"]==131){
	      echo $this->query;
	      exit;
	     } */
		
		
	return $res;
	} 
	/**
	 * Nombre de la función:	Reporte para Libro Mayor x Partidas la cabecera 
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    JGL
	 * Fecha de creación:		11/08/2010
	 * */
	function ContarMayorEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_mayor_uo_epe_ot_cta_aux_sel';
		$this->codigo_procedimiento = "'CT_CABECERA_UO_EPE_OT_CTA_AUX_COUNT'";

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
		
		
		$this->var->add_param($id_gestion);//ct_id_gestion
        $this->var->add_param($id_depto);//ct_id_depto
        $this->var->add_param("'$fecha_inicio'");//ct_fecha_inicio
        $this->var->add_param("'$fecha_final'");//ct_fecha_final
        $this->var->add_param("'$sw_cuenta'");//ct_sw_cuenta
        $this->var->add_param("'$sw_auxiliar'");//ct_sw_auxiliar
        $this->var->add_param("'$sw_epe'");//ct_sw_epe
        $this->var->add_param("'$sw_uo'");//ct_sw_uo
        $this->var->add_param("'$sw_ot'");//ct_sw_ot
        $this->var->add_param($id_cuenta_inicial);//ct_id_cuenta_inicial
        $this->var->add_param($id_cuenta_final);//ct_id_cuenta_final
        $this->var->add_param($id_auxiliar_inicial);//ct_id_auxiliar_inicial
        $this->var->add_param($id_auxiliar_final);//ct_id_auxiliar_final
        $this->var->add_param($id_epe_inicial);//ct_id_epe_inicial
        $this->var->add_param($id_epe_final);//ct_id_epe_final
        $this->var->add_param($id_uo_inicial);//ct_id_uo_inicial
        $this->var->add_param($id_uo_final);//ct_id_uo_final
        $this->var->add_param($id_ot_inicial);//ct_id_ot_inicial
        $this->var->add_param($id_ot_final);//ct_id_ot_final
        $this->var->add_param($sw_estado_cbte);//ct_sw_estado_cbte
        $this->var->add_param("'$sw_listado'");//ct_sw_listado
        $this->var->add_param($id_moneda);//ct_id_moneda
        $this->var->add_param("'$sw_actualizacion'");//ct_id_moneda
        
        
       
	
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		//echo $this->var->query; exit();
		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*if($_SESSION["ss_id_usuario"]==131){
			echo $this->query;
			exit;
		}*/
		
		
		
	    //echo $this->query;
		//exit();  //Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	Reporte para Libro Mayor x Partidas la cabecera 
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    JGL
	 * Fecha de creación:		11/08/2010
	 * */
	 
	function ListarEstadoEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_mayor_uo_epe_ot_cta_aux_sel';
		$this->codigo_procedimiento = "'CT_ESTADO_UO_EPE_OT_CTA_AUX_SEL'";

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
		
		$this->var->add_param($id_gestion);//ct_id_gestion
        $this->var->add_param($id_depto);//ct_id_depto
        $this->var->add_param("'$fecha_inicio'");//ct_fecha_inicio
        $this->var->add_param("'$fecha_final'");//ct_fecha_final
        $this->var->add_param("'$sw_cuenta'");//ct_sw_cuenta
        $this->var->add_param("'$sw_auxiliar'");//ct_sw_auxiliar
        $this->var->add_param("'$sw_epe'");//ct_sw_epe
        $this->var->add_param("'$sw_uo'");//ct_sw_uo
        $this->var->add_param("'$sw_ot'");//ct_sw_ot
        $this->var->add_param($id_cuenta_inicial);//ct_id_cuenta_inicial
        $this->var->add_param($id_cuenta_final);//ct_id_cuenta_final
        $this->var->add_param($id_auxiliar_inicial);//ct_id_auxiliar_inicial
        $this->var->add_param($id_auxiliar_final);//ct_id_auxiliar_final
        $this->var->add_param($id_epe_inicial);//ct_id_epe_inicial
        $this->var->add_param($id_epe_final);//ct_id_epe_final
        $this->var->add_param($id_uo_inicial);//ct_id_uo_inicial
        $this->var->add_param($id_uo_final);//ct_id_uo_final
        $this->var->add_param($id_ot_inicial);//ct_id_ot_inicial
        $this->var->add_param($id_ot_final);//ct_id_ot_final
        $this->var->add_param($sw_estado_cbte);//ct_sw_estado_cbte
        $this->var->add_param("'$sw_listado'");//ct_sw_listado
        $this->var->add_param($id_moneda);//ct_id_moneda
		$this->var->add_param("'$sw_actualizacion'");//ct_id_moneda 
                                                                             
        
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tt_tct_reporte_uo_epe_ot_cta_aux','INTEGER');
		$this->var->add_def_cols('id_reporte','integer');
		$this->var->add_def_cols('id_transaccion','INTEGER');
		$this->var->add_def_cols('fecha_cbte','text');
		$this->var->add_def_cols('nro_cbte','INTEGER');
		$this->var->add_def_cols('concepto_cbte','TEXT');
		$this->var->add_def_cols('desc_componentes','TEXT');
		$this->var->add_def_cols('importe_debe','NUMERIC');
		$this->var->add_def_cols('importe_haber','NUMERIC');
		$this->var->add_def_cols('saldo','NUMERIC');
		
		
	 	//$this->var->add_def_cols('nombre_auxiliar','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo  $this->query;exit;
		
	return $res;
	} 
	/**
	 * Nombre de la función:	Reporte para Libro Mayor x Partidas la cabecera 
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    JGL
	 * Fecha de creación:		11/08/2010
	 * */
	function ContarEstadoEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_mayor_uo_epe_ot_cta_aux_sel';
		$this->codigo_procedimiento = "'CT_ESTADO_UO_EPE_OT_CTA_AUX_COUNT'";

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
		
		
		$this->var->add_param($id_gestion);//ct_id_gestion
        $this->var->add_param($id_depto);//ct_id_depto
        $this->var->add_param("'$fecha_inicio'");//ct_fecha_inicio
        $this->var->add_param("'$fecha_final'");//ct_fecha_final
        $this->var->add_param("'$sw_cuenta'");//ct_sw_cuenta
        $this->var->add_param("'$sw_auxiliar'");//ct_sw_auxiliar
        $this->var->add_param("'$sw_epe'");//ct_sw_epe
        $this->var->add_param("'$sw_uo'");//ct_sw_uo
        $this->var->add_param("'$sw_ot'");//ct_sw_ot
        $this->var->add_param($id_cuenta_inicial);//ct_id_cuenta_inicial
        $this->var->add_param($id_cuenta_final);//ct_id_cuenta_final
        $this->var->add_param($id_auxiliar_inicial);//ct_id_auxiliar_inicial
        $this->var->add_param($id_auxiliar_final);//ct_id_auxiliar_final
        $this->var->add_param($id_epe_inicial);//ct_id_epe_inicial
        $this->var->add_param($id_epe_final);//ct_id_epe_final
        $this->var->add_param($id_uo_inicial);//ct_id_uo_inicial
        $this->var->add_param($id_uo_final);//ct_id_uo_final
        $this->var->add_param($id_ot_inicial);//ct_id_ot_inicial
        $this->var->add_param($id_ot_final);//ct_id_ot_final
        $this->var->add_param($sw_estado_cbte);//ct_sw_estado_cbte
        $this->var->add_param("'$sw_listado'");//ct_sw_listado
        $this->var->add_param($id_moneda);//ct_id_moneda
        $this->var->add_param("'$sw_actualizacion'");//ct_id_moneda
        
       
	
		
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

	    //echo $this->query;
		//exit();  //Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	Reporte para Libro Mayor x Partidas la cabecera 
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    ana maria
	 * Fecha de creación:		2009-06-15 8:36:36
	 * 
	 */
	function LibroMayorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_partida_sel';
		$this->codigo_procedimiento = "'CT_ELIMAPA_SEL'";

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
		$this->var->add_param($id_partida);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
      	$this->var->add_param("'$id_presupuesto'");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo_partida','varchar');
		$this->var->add_def_cols('nombre_partida','varchar');
		$this->var->add_def_cols('desc_partida','varchar');
	 	//$this->var->add_def_cols('nombre_auxiliar','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo  $this->query;
		exit;*/
		
	return $res;
	}
	
	
	/**
	 * Nombre de la función:	ReporteLibroMayor Detalle
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    Ana Maria Villegas Quispe
	 * Fecha de creación:		05/02/2010
	 */
	function LibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_partida_sel';
		$this->codigo_procedimiento = "'CT_LMPADE_SEL'";

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
		$this->var->add_param($id_partida);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
        $this->var->add_param("'$id_presupuesto'");
      
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_cbte','date');//0
		$this->var->add_def_cols('prefijo','varchar');//1
		$this->var->add_def_cols('nro_cbte','integer');//2
		$this->var->add_def_cols('concepto_cbte','varchar');//3
		//$this->var->add_def_cols('tipo_cambio','numeric');//4
		$this->var->add_def_cols('importe_recurso','numeric');//5
		$this->var->add_def_cols('importe_gasto','numeric');//6
		$this->var->add_def_cols('saldo','numeric');//7
		$this->var->add_def_cols('depto','text');//7
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	/**
	 * Nombre de la función:	ContarRegistroLibroMayor
	 * Propósito:				Contar los registros de libro mayor
	 * Autor:				    amvq
	 * Fecha de creación:		2008-12-8 17:55:36
	 */
	function ContarLibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_partida_sel';
		$this->codigo_procedimiento = "'CT_LMPADE_COUNT'";

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
		$this->var->add_param($id_partida);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
        $this->var->add_param("'$id_presupuesto'");
       
	
		
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

	  /* echo $this->query;
		exit();*/
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	ReporteLibroMayorDetalleAuxiliares
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    avq
	 * Fecha de creación:		30/03/2010
	 */
	function ReporteLibroMayorDetalleAuxiliares($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_auxiliares_sel';
		$this->codigo_procedimiento = "'CT_LIMADEAUX_SEL'";

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
		$this->var->add_param($id_cuenta);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
       // $this->var->add_param($id_auxiliar);
        $this->var->add_param($id_depto);
        $this->var->add_param("'$cuenta_ini'");
        $this->var->add_param("'$cuenta_fin'");
        $this->var->add_param("'$por_rango'");
        $this->var->add_param($id_gestion);
        
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_cbte','text');
		$this->var->add_def_cols('prefijo','varchar');
		$this->var->add_def_cols('nro_cbte','integer');
		$this->var->add_def_cols('concepto_cbte','varchar');
		$this->var->add_def_cols('tipo_cambio','numeric');
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
		$this->var->add_def_cols('saldo','numeric');
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('desc_cuenta','text');
		$this->var->add_def_cols('desc_auxiliar','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	function ReporteLibroMayorOT($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_ot_sel';
		$this->codigo_procedimiento = "'CT_LIMAOT_SEL'";

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
		$this->var->add_param($id_cuenta);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
        $this->var->add_param($id_depto);
        $this->var->add_param("'$cuenta_ini'");
        $this->var->add_param("'$cuenta_fin'");
        $this->var->add_param("'$por_rango'");
        $this->var->add_param($id_gestion);
        
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('prefijo','varchar');
		$this->var->add_def_cols('nro_cbte','integer');
		$this->var->add_def_cols('concepto_cbte','varchar');
		$this->var->add_def_cols('tipo_cambio','numeric');
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
		$this->var->add_def_cols('saldo','numeric');
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('id_orden_trabajo','integer');
		$this->var->add_def_cols('desc_cuenta','text');
		$this->var->add_def_cols('desc_auxiliar','text');
		$this->var->add_def_cols('desc_ot','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	/**
	 * Nombre de la función:	ReporteLibroMayorDetalleAuxiliares
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    avq
	 * Fecha de creación:		24/05/2010
	 */
	function ReporteValidacionLibroMayorBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_depto,$id_moneda,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_val_libban_libmay_sel';
		$this->codigo_procedimiento = "'CT_LIBAMA_SEL'";

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
	    $this->var->add_param($id_depto);
		$this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");

		//Carga la definición de columnas con sus tipos de datos
    	 	 $this->var->add_def_cols('id_comprobante','INTEGER'); 
  		  	$this->var->add_def_cols('fecha_cbte',' TEXT'); 
  		  	$this->var->add_def_cols('nro_cbte',' INTEGER'); 
  		  	$this->var->add_def_cols('cuenta',' TEXT'); 
  			$this->var->add_def_cols('auxiliar','VARCHAR'); 
  			$this->var->add_def_cols('concepto_cbte',' VARCHAR'); 
  			$this->var->add_def_cols('importe_debe',' NUMERIC'); 
  			$this->var->add_def_cols('importe_haber',' NUMERIC'); 
  			$this->var->add_def_cols('fecha_cheque','TEXT');
  			$this->var->add_def_cols('codigo_auxiliar_cheque','VARCHAR'); 
  			//$this->var->add_def_cols('nombre_cheque',' VARCHAR'); 
  			$this->var->add_def_cols('nombre_cheque','VARCHAR');
  			$this->var->add_def_cols('importe_cheque','numeric');
  			$this->var->add_def_cols('estado_cheque',' NUMERIC'); 
  			$this->var->add_def_cols('est_cheque',' TEXT');
  			
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/ 
		return $res;
	}
	
	function ListarMayDat($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,
	$sw_cuenta,$sw_auxiliar,$sw_partida,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_partida_inicial,$id_partida_final,
	$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion,$sw_orden)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_maydat_sel';
		$this->codigo_procedimiento = "'CT_MAYDAT_SEL'";

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
		
		$this->var->add_param($id_gestion);//ct_id_gestion
        $this->var->add_param($id_depto);//ct_id_depto
        $this->var->add_param("'$fecha_inicio'");//ct_fecha_inicio
        $this->var->add_param("'$fecha_final'");//ct_fecha_final
        $this->var->add_param("'$sw_cuenta'");//ct_sw_cuenta
        $this->var->add_param("'$sw_auxiliar'");//ct_sw_auxiliar
        $this->var->add_param("'$sw_partida'");//ct_sw_partida
        $this->var->add_param("'$sw_epe'");//ct_sw_epe
        $this->var->add_param("'$sw_uo'");//ct_sw_uo
        $this->var->add_param("'$sw_ot'");//ct_sw_ot
        $this->var->add_param($id_cuenta_inicial);//ct_id_cuenta_inicial
        $this->var->add_param($id_cuenta_final);//ct_id_cuenta_final
        $this->var->add_param($id_auxiliar_inicial);//ct_id_auxiliar_inicial
        $this->var->add_param($id_auxiliar_final);//ct_id_auxiliar_final
        $this->var->add_param($id_partida_inicial);//ct_id_partida_inicial
        $this->var->add_param($id_partida_final);//ct_id_partida_final
        $this->var->add_param($id_epe_inicial);//ct_id_epe_inicial
        $this->var->add_param($id_epe_final);//ct_id_epe_final
        $this->var->add_param($id_uo_inicial);//ct_id_uo_inicial
        $this->var->add_param($id_uo_final);//ct_id_uo_final
        $this->var->add_param($id_ot_inicial);//ct_id_ot_inicial
        $this->var->add_param($id_ot_final);//ct_id_ot_final
        $this->var->add_param($sw_estado_cbte);//ct_sw_estado_cbte
        $this->var->add_param("'$sw_listado'");//ct_sw_listado
        $this->var->add_param($id_moneda);//ct_id_moneda
        $this->var->add_param("'$sw_actualizacion'");//$sw_actualizacion
        $this->var->add_param("'$sw_orden'");//ct_sw_orden
 
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_maydat','INTEGER');
		$this->var->add_def_cols('codigo','VARCHAR');
		$this->var->add_def_cols('nombre','VARCHAR');
		
	 	//$this->var->add_def_cols('nombre_auxiliar','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*if($_SESSION["ss_id_usuario"]==120){
		echo  $this->query;exit;
		}*/
		
	return $res;
	} 
	
	function ContarMayDat($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,
	$sw_cuenta,$sw_auxiliar,$sw_partida,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_partida_inicial,$id_partida_final,
	$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion,$sw_orden)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_maydat_sel';
		$this->codigo_procedimiento = "'CT_MAYDAT_COUNT'";

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
		
		$this->var->add_param($id_gestion);//ct_id_gestion
        $this->var->add_param($id_depto);//ct_id_depto
        $this->var->add_param("'$fecha_inicio'");//ct_fecha_inicio
        $this->var->add_param("'$fecha_final'");//ct_fecha_final
        $this->var->add_param("'$sw_cuenta'");//ct_sw_cuenta
        $this->var->add_param("'$sw_auxiliar'");//ct_sw_auxiliar
        $this->var->add_param("'$sw_partida'");//ct_sw_partida
        $this->var->add_param("'$sw_epe'");//ct_sw_epe
        $this->var->add_param("'$sw_uo'");//ct_sw_uo
        $this->var->add_param("'$sw_ot'");//ct_sw_ot
        $this->var->add_param($id_cuenta_inicial);//ct_id_cuenta_inicial
        $this->var->add_param($id_cuenta_final);//ct_id_cuenta_final
        $this->var->add_param($id_auxiliar_inicial);//ct_id_auxiliar_inicial
        $this->var->add_param($id_auxiliar_final);//ct_id_auxiliar_final
        $this->var->add_param($id_partida_inicial);//ct_id_partida_inicial
        $this->var->add_param($id_partida_final);//ct_id_partida_final
        $this->var->add_param($id_epe_inicial);//ct_id_epe_inicial
        $this->var->add_param($id_epe_final);//ct_id_epe_final
        $this->var->add_param($id_uo_inicial);//ct_id_uo_inicial
        $this->var->add_param($id_uo_final);//ct_id_uo_final
        $this->var->add_param($id_ot_inicial);//ct_id_ot_inicial
        $this->var->add_param($id_ot_final);//ct_id_ot_final
        $this->var->add_param($sw_estado_cbte);//ct_sw_estado_cbte
        $this->var->add_param("'$sw_listado'");//ct_sw_listado
        $this->var->add_param($id_moneda);//ct_id_moneda
        $this->var->add_param("'$sw_actualizacion'");//$sw_actualizacion
        $this->var->add_param("'$sw_orden'");//ct_sw_orden
        
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

	    //echo $this->query;
		//exit();  //Retorna el resultado de la ejecución
		return $res;
	}
		
}?>