<?php
/**
 * Nombre de la clase:	cls_DBOIngresoProy.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_ingreso
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		02-04-2008 11:43
 */

class cls_DBIngresoProy
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
	 * Nombre de la función:	ListarIngreso
	 * Propósito:				Desplegar los registros de tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ListarIngresoProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_sel';
		$this->codigo_procedimiento = "'AL_INGRPR_SEL'";

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
		$this->var->add_def_cols('id_ingreso','int4');
		$this->var->add_def_cols('correlativo_ord_ing','varchar');
		$this->var->add_def_cols('correlativo_ing','text');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('costo_total','numeric');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_ingreso','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('cod_inf_tec','varchar');//10
		$this->var->add_def_cols('resumen_inf_tec','varchar');
		$this->var->add_def_cols('fecha_borrador','date');
		$this->var->add_def_cols('fecha_pendiente','date');
		$this->var->add_def_cols('fecha_aprobado_rechazado','date');
		$this->var->add_def_cols('fecha_ing_fisico','date');
		$this->var->add_def_cols('fecha_ing_valorado','date');
		$this->var->add_def_cols('fecha_finalizado_cancelado','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('desc_responsable_almacen','varchar');//20
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('desc_proveedor','varchar');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','varchar');//30
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_motivo_ingreso_cuenta','int4');
		$this->var->add_def_cols('desc_motivo_ingreso_cuenta','varchar');
		$this->var->add_def_cols('nombre_proveedor','varchar');
		$this->var->add_def_cols('nombre_contratista','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('desc_motivo_ingreso','varchar');
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('nombre_financiador','varchar');//40
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('id_financiador','int4');
		$this->var->add_def_cols('id_regional','int4');
		$this->var->add_def_cols('id_programa','int4');
		$this->var->add_def_cols('id_proyecto','int4');
		$this->var->add_def_cols('id_actividad','int4');
		$this->var->add_def_cols('codigo_financiador','varchar');//50
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		$this->var->add_def_cols('orden_compra','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('contabilizar_tipo_almacen','varchar');
		$this->var->add_def_cols('num_factura','varchar');
		$this->var->add_def_cols('fecha_factura','date');//60
		$this->var->add_def_cols('responsable','varchar');
		$this->var->add_def_cols('importacion','numeric');
		$this->var->add_def_cols('flete','numeric');
		$this->var->add_def_cols('seguro','numeric');
		$this->var->add_def_cols('gastos_alm','numeric');
		$this->var->add_def_cols('gastos_aduana','numeric');
		$this->var->add_def_cols('iva','numeric');
		$this->var->add_def_cols('rep_form','numeric');
		$this->var->add_def_cols('peso_neto','numeric');
		$this->var->add_def_cols('tot_importacion','numeric');//70
		$this->var->add_def_cols('tot_nacionaliz','numeric');
		$this->var->add_def_cols('id_moneda_import','integer');
		$this->var->add_def_cols('id_moneda_nacionaliz','integer');
		$this->var->add_def_cols('desc_moneda_import','varchar');
		$this->var->add_def_cols('desc_moneda_nacionaliz','varchar');
		$this->var->add_def_cols('dui','varchar');
		$this->var->add_def_cols('monto_tot_factura','numeric');
		$this->var->add_def_cols('codigo_mot_ing','varchar');//80
		$this->var->add_def_cols('gestion','varchar');
		$this->var->add_def_cols('id_motivo_ingreso','integer');
		$this->var->add_def_cols('id_almacen','integer');
		$this->var->add_def_cols('tipo_costeo','varchar');
		
		$this->var->add_def_cols('nro_pedido_compra','varchar');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		/*echo "sql:".$this->query;
		exit;*/

		return $res;
	}

	/**
	 * Nombre de la función:	ContarIngreso
	 * Propósito:				Contar los registros de tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ContarIngresoProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_sel';
		$this->codigo_procedimiento = "'AL_INGRPR_COUNT'";

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
	 * Nombre de la función:	FinalizarOrdenIngresoSol
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 18:11:11
	 */
	function FinalizarIngresoProy($id_ingreso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_INFIPR_FIN'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ingreso);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//40
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
        $this->var->add_param("NULL"); //tipo_costeo		
		$this->var->add_param("NULL"); //nro_predido_compr
		
		//echo "query: ".$this->var->get_query();
		//exit;

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		

		return $res;
	}

	/**
	 * Nombre de la función:	ListarIngreso
	 * Propósito:				Desplegar los registros de tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function NotaIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_sel';
		$this->codigo_procedimiento = "'AL_INGREP_SEL'";

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
		$this->var->add_def_cols('nombre_almacen','varchar');//0
		$this->var->add_def_cols('correlativo_ing','text');//1
		$this->var->add_def_cols('almacen_log','varchar');
		$this->var->add_def_cols('motivo_ing','varchar');		
		$this->var->add_def_cols('num_factura','varchar');//2
		$this->var->add_def_cols('fecha_factura','text');//3
		$this->var->add_def_cols('fecha_finalizado_cancelado','text');//4
		$this->var->add_def_cols('origen','varchar');//5
		$this->var->add_def_cols('descripcion','varchar');//6
		$this->var->add_def_cols('responsable','varchar');//7		
		$this->var->add_def_cols('almacenero','text');//8
		$this->var->add_def_cols('doc_almacenero','varchar');
		$this->var->add_def_cols('jefe_almacen','text');//9
		$this->var->add_def_cols('doc_jefe_almacen','varchar');		
		$this->var->add_def_cols('fecha_reg','text');//10
		$this->var->add_def_cols('observaciones','varchar');//11		
	    $this->var->add_def_cols('orden_compra','varchar');	    
	    $this->var->add_def_cols('nro_pedido_compra','varchar');
	    
		/*$this->var->add_def_cols('contratista','varchar');//3
		$this->var->add_def_cols('empleado','varchar');//3f
		$this->var->add_def_cols('institucion','varchar');//3*/

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "sql:".$this->query;

		return $res;
	}

	/**
	 * Nombre de la función:	FinalizarOrdenIngresoSol
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 18:11:11
	 */
	function ValoracionIngreso($id_ingreso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_VALORA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ingreso);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//40
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
        $this->var->add_param("NULL"); //tipo_costeo		
		$this->var->add_param("NULL"); //nro_predido_compr 
		
		//echo "query: ".$this->var->get_query();
		//exit;

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarValoracionIngreso
	 * Propósito:				Introducción de datos de valoración
	 * Fecha de creación:		17/10/2008
	 */
	function InsertarValoracionIngreso($id_ingreso,$importacion,$flete,$seguro,$gastos_alm,$gastos_aduana,$iva,$rep_form,$peso_neto,$id_moneda_import,$id_moneda_nacionaliz,$dui, $monto_tot_factura, $tipo_costeo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_INGVAL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ingreso);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("$importacion");
		$this->var->add_param("$flete");
		$this->var->add_param("$seguro");
		$this->var->add_param("$gastos_alm");
		$this->var->add_param("$gastos_aduana");
		$this->var->add_param("$iva");
		$this->var->add_param("$rep_form");
		$this->var->add_param("$peso_neto");
		$this->var->add_param("$id_moneda_import");//40
		$this->var->add_param("$id_moneda_nacionaliz");
		$this->var->add_param("'$dui'");
		$this->var->add_param("$monto_tot_factura");
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo_costeo'"); //rac 15 12 2016
		$this->var->add_param("NULL"); //nro_predido_compr
		
		//echo "query: ".$this->var->get_query();
		//exit;

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

/************************************************************
 * 
 *   Autor 		Rensi Arteaga Copari
 *   Fecha		22/12/2016	
 *   Desc		subida de archivo de ingreso detalle con PDO
 * 
 ***************************************************************/

    //function ImportarDetalleIngreso($id_ingreso, $txt_foto_persona, $nombre_foto, $numero, $extension, $id_empleado, $vista_per)
	function ImportarDetalleIngreso($id_ingreso, $ingreso_detalle, $nombre_archivo,  $extension)
	{
				
		//Abre conexion con PDO
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_detalle_iud';
		$this->codigo_procedimiento = "'AL_IMPDET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$cone = new cls_conexion();        
        $link = $cone->conectarpdo();
        $copiado = false;  
		$temporal = true;         
        try {
            	
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     
            $link->beginTransaction();	
			
			//Instancia la clase midlle para la ejecución de la función de la BD
			$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
			
			//echo 'Extension:... '.$extension;
			//echo 'nombre_archivo:... '.$nombre_archivo;
			//echo 'ingreso_detalle:... '.$ingreso_detalle;
			$chk_ext = explode(".",$nombre_archivo);
	         
	         if(strtolower(end($chk_ext)) == "csv")
	         {
	             //si es correcto, entonces damos permisos de lectura para subir
	             $filename = $ingreso_detalle;
	             $handle = fopen($filename, "r");
	        
	             while (($data = fgetcsv($handle, 1000, "|")) !== FALSE)
	             {
		               //Insertamos los datos con los valores...
		              
		                $codigo_item=$data[1];
		                $costo_unitario=$data[5];
		                $cantidad=$data[4];
		                $costo = $cantidad*$costo_unitario;
	                
	               		
						$this->var->reset();
						
					   						
						$this->var->add_param("NULL");
						$this->var->add_param($cantidad);
						$this->var->add_param($costo);
						$this->var->add_param("NULL");
						$this->var->add_param($costo_unitario);
						$this->var->add_param("NULL");
						$this->var->add_param("NULL");
						$this->var->add_param($id_ingreso);
						$this->var->add_param("NULL");
						$this->var->add_param("'$codigo_item'");
						$this->var->add_param("NULL");
										
						//Ejecuta la función
			            $res = $this->var->exec_non_query_pdo($link);
						//Obtiene la cadena con que se llamó a la función de postgres
						$this->query = $this->var->query;					
						
						//echo '<br>consulta '. $this->query ;
						
						$stmt = $link->prepare($this->query);          
				        $stmt->execute();
				        $res = $stmt->fetch(PDO::FETCH_ASSOC); 
						
						$temporal = $this->var->analizarRespuesta($res['f_tal_ingreso_detalle_iud']);
						
						//Obtiene el array de salida de la función y retorna el resultado de la ejecución
						$this->salida = $this->var->salida;
				
						
	             }
	             //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
	             fclose($handle);
	             
	             
	         }
	         else
	         {
	            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para             //ver si esta separado por " , "
	             throw new Exception("Archivo invalido", 3); 
	         }
			
			
			
		    //si todo va bien confirmamos y regresamos el resultado
            $link->commit();
           return $temporal;
				
            
        } 
        catch (Exception $e) {          
                $link->rollBack();
				
				$this->salida = "";
				$this->salida[0] = "f";
				$this->salida[1] = $e->getMessage();
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = DBIngresoProy.php";
				$this->salida[4] = "NIVEL = 3";
				
				//echo "entra ".$this->salida[1] ;
				
				return false;
           
                
                
        } 	
			
		
	}





	/**
	 * Nombre de la función:	ValidarIngreso
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ValidarOrdenIngresoSol($operacion_sql,$tipo_orden_ingreso,$id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones)


	{
		//orden_tipo_ingreso: (Compra Local, Importacion, etc.)

		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();

		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_ingreso - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_ingreso");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso", $id_ingreso))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_total - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_total");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_total", $costo_total))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_contratista - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_contratista");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_contratista", $id_contratista))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_institucion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion", $id_institucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_almacen_logico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_logico");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_logico", $id_almacen_logico))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_motivo_ingreso_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_motivo_ingreso_cuenta");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_motivo_ingreso_cuenta", $id_motivo_ingreso_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar orden_compra - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("orden_compra");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "orden_compra", $orden_compra))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//DEPENDIENDO DEL TIPO DE INGRESO; VERIFICA QUE SU ORIGEN ESTÉ PRESENTE

			if($tipo_orden_ingreso=='Compra local')
			{
				if($id_empleado=="" && $id_proveedor=="")
				{
					$this->salida[0] = "f";
					$this->salida[1] = "Error de validación: Debe introducirse el Origen de la Orden de Ingreso";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
			}
			elseif($tipo_orden_ingreso=='Importacion')
			{
				if($id_empleado=="" && $id_proveedor=="")
				{
					$this->salida[0] = "f";
					$this->salida[1] = "Error de validación: Debe introducirse el Origen de la Orden de Ingreso";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
			}
			elseif($tipo_orden_ingreso=='Extraordinario')
			{
				if($id_institucion=="")
				{
					$this->salida[0] = "f";
					$this->salida[1] = "Error de validación: Debe introducirse el Origen de la Orden de Ingreso";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
			}
			elseif($tipo_orden_ingreso=='Devolucion')
			{
				if($id_empleado=="" && $id_contratista=="")
				{
					$this->salida[0] = "f";
					$this->salida[1] = "Error de validación: Debe introducirse el Origen de la Orden de Ingreso";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
			}
			elseif($tipo_orden_ingreso=='General')
			{
				//Es el caso de que sea la vista de orden de compra general
			}
			else
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación: El Tipo de Orden Ingreso no es válido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}


			//Validación de reglas de datos

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_ingreso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ingreso");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso", $id_ingreso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='fin')
		{
			//Validar id_ingreso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ingreso");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso", $id_ingreso))
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