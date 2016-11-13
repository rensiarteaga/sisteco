<?php
/**
 * Nombre de la clase:	cls_DBDetalleBeneficiario.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfv_tfv_detalle_beneficiario
 * Autor:				José Mita
 * Fecha creación:		2011-06-14 10:51:07
 */

 
class cls_DBDetalleBeneficiario
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
	 * Nombre de la función:	ListarDetalleBeneficiarioRep
	 * Propósito:				Desplegar los registros de tfv_detalle_beneficiario y cliente
	 * Autor:				    AVQ
	 * Fecha de creación:		24/08/2011
	*/
	function ListarDetalleBeneficiariosSumRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_detalle_beneficiario_sel';
		$this->codigo_procedimiento = "'FV_DETBENSUM_REP'";

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

        $this->var->add_def_cols('regional',' VARCHAR(50)');
 		$this->var->add_def_cols('cant_direc',' BIGINT');
 		$this->var->add_def_cols('cant_indirec',' BIGINT');
	    $this->var->add_def_cols('cant_bene',' BIGINT');
 		$this->var->add_def_cols('sum_direc',' NUMERIC');
  		$this->var->add_def_cols('sum_indirec',' NUMERIC');
  		$this->var->add_def_cols('sum_total','NUMERIC');

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
	 * Nombre de la función:	ListarDetalleBeneficiarioRep
	 * Propósito:				Desplegar los registros de tfv_detalle_datos generales
	 * Autor:				    AVQ
	 * Fecha de creación:		24/08/2011
	*/
	function ListarDatosGeneralesBeneficiarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_detalle_beneficiario_sel';
		$this->codigo_procedimiento = "'FV_DAGEBEN_REP'";

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
		
		$this->var->add_def_cols('id_empresa','INTEGER');
        $this->var->add_def_cols('denominacion',' VARCHAR(30)');
        $this->var->add_def_cols('nro_nit','NUMERIC(15,0)');
        $this->var->add_def_cols('cantidad_valor_solicitado','INTEGER');
        $this->var->add_def_cols('fecha_envio','text');
        $this->var->add_def_cols('numero_orden','bigint');
        $this->var->add_def_cols('codigo_form','INTEGER');
        $this->var->add_def_cols('mes_per_fiscal','INTEGER');
        $this->var->add_def_cols('anio_per_fiscal','INTEGER');
        $this->var->add_def_cols('nro_factura',' INTEGER');
        $this->var->add_def_cols('nro_autoriza',' NUMERIC(15,0)');
        $this->var->add_def_cols('importe_factura','NUMERIC(16,2)');
        $this->var->add_def_cols('fecha_emision','text');
        $this->var->add_def_cols('cod_control',' VARCHAR(14)');
        
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
	 * Nombre de la función:	ListarDetalleBeneficiarioRep
	 * Propósito:				Desplegar los registros de tfv_detalle_beneficiario y cliente
	 * Autor:				    AVQ
	 * Fecha de creación:		31/08/2011
	*/
	function ListarDetalleBeneficiariosSCIRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_detalle_beneficiario_sel';
		$this->codigo_procedimiento = "'FV_DETBENSCI_REP'";

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
		$this->var->add_def_cols('numero_factura_ben','int4');
		$this->var->add_def_cols('numero_autorizacion_fecha_ben','numeric');
   		$this->var->add_def_cols('beneficiario','varchar');
		$this->var->add_def_cols('tipo_identificacion','varchar');
     	$this->var->add_def_cols('numero_ident','varchar');
      	$this->var->add_def_cols('fecha_nacimiento','text');
		$this->var->add_def_cols('consumo','int4');
        $this->var->add_def_cols('importe_des_direc','numeric');
		$this->var->add_def_cols('importe_des_indirec','numeric');
		$this->var->add_def_cols('importe_facturado','numeric');
        $this->var->add_def_cols('codigo_control_factura_ben','varchar');
        $this->var->add_def_cols('estado','integer');
	 	
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
}?>