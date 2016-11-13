<?php
/**
 * Nombre de la clase:	cls_DBProcesoCompraDet.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_proceso_compra_det
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-20 17:42:41
 */

 
class cls_DBProcesoCompraDet
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
	 * Nombre de la función:	ListarProcesoCompraMulDet
	 * Propósito:				Desplegar los registros de tad_proceso_compra_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function ListarProcesoCompraMulDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_sel';
		$this->codigo_procedimiento = "'AD_PRCOMULDET_SEL'";

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
		$this->var->add_def_cols('id_proceso_compra_det','int4');
		$this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('desc_servicio','varchar');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('precio_referencial_total','numeric');
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('desc_proceso_compra','text');
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
	 * Nombre de la función:	ListarProcesoCompraMulDet
	 * Propósito:				Desplegar los registros de tipo item en tad_proceso_compra_det de proceso de compra especificaco
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function ListarProcesoCompraMulIteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_sel';
		$this->codigo_procedimiento = "'AD_PRCOMULITDET_SEL'";

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
		$this->var->add_def_cols('id_proceso_compra_det','int4');
		$this->var->add_def_cols('id_proceso_compra','int4');
        $this->var->add_def_cols('cantidad','numeric');
        $this->var->add_def_cols('precio_referencial_total','numeric');
        $this->var->add_def_cols('estado_reg','varchar');
        $this->var->add_def_cols('id_item','int4');
        $this->var->add_def_cols('id_unidad_medida_base','int4');
		$this->var->add_def_cols('codigo_item','varchar');
        $this->var->add_def_cols('nombre_item','varchar');
		$this->var->add_def_cols('nombre_id3','varchar');
        $this->var->add_def_cols('nombre_id2','varchar');
        $this->var->add_def_cols('nombre_id1','varchar');
        $this->var->add_def_cols('nombre_subg','varchar');
		$this->var->add_def_cols('nombre_grupo','varchar');
        $this->var->add_def_cols('nombre_supg','varchar');
        $this->var->add_def_cols('nombre_unid_base','varchar');
        $this->var->add_def_cols('precio_total_moneda_seleccionada','numeric');
        $this->var->add_def_cols('descripcion','varchar');  
        $this->var->add_def_cols('especificaciones_tecnicas','text');                      
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*	if ($_SESSION['ss_id_usuario']==131){
		 echo $this->query;
		 exit;   
		}*/
		return $res;
	}
	/**
	 * Nombre de la función:	ListarProcesoCompraMulDet
	 * Propósito:				Desplegar los registros de tipo servicio en tad_proceso_compra_det de proceso de compra especificaco
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function ListarProcesoCompraMulSerDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_sel';
		$this->codigo_procedimiento = "'AD_PRCOMULSEDET_SEL'";

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
		$this->var->add_def_cols('id_proceso_compra_det','int4');
		$this->var->add_def_cols('id_proceso_compra','int4');
        $this->var->add_def_cols('cantidad','numeric');
        $this->var->add_def_cols('precio_referencial_total','numeric');
        $this->var->add_def_cols('estado_reg','varchar');
        $this->var->add_def_cols('id_servicio','int4');
        $this->var->add_def_cols('nombre_servicio','varchar');
        $this->var->add_def_cols('nombre_tipo_servicio','varchar');
   		$this->var->add_def_cols('precio_total_moneda_seleccionada','numeric');
   		$this->var->add_def_cols('especificaciones_tecnicas','text');
   	    $this->var->add_def_cols('id_unidad_medida_base_serv','int4');    
        $this->var->add_def_cols('nombre_unid_base_serv','varchar');
        //jun2015
        $this->var->add_def_cols('id_item','integer');
        $this->var->add_def_cols('nombre_item','varchar');
        $this->var->add_def_cols('codigo_item','varchar');
         
        
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
	 * Nombre de la función:	ContarProcesoCompraMulDet
	 * Propósito:				Contar los registros de tad_proceso_compra_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function ContarProcesoCompraMulDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_sel';
		$this->codigo_procedimiento = "'AD_PRCOMULDET_COUNT'";

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
	 * Nombre de la función:	ContarProcesoCompraMulDet
	 * Propósito:				Contar los registros de items en tad_proceso_compra_det
	 * Autor:				    Rensi Artega Copari
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function ContarProcesoCompraMulIteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_sel';
		$this->codigo_procedimiento = "'AD_PRCOMULITDET_COUNT'";

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
	 * Nombre de la función:	ContarProcesoCompraMulDet
	 * Propósito:				Contar los registros de servicios en tad_proceso_compra_det
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function ContarProcesoCompraMulSerDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_sel';
		$this->codigo_procedimiento = "'AD_PRCOMULSEDET_COUNT'";

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
		//echo $this->query;
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarProcesoCompraMulDet
	 * Propósito:				Verifica las condiciones para la insercion del detalle de una solicitud
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function VerificarInsertarProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_iud';
		$this->codigo_procedimiento = "'AD_PRCOMULDET_INS'";
		//$this->codigo_procedimiento = "'AD_PRCODET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_servicio);
		$this->var->add_param($id_item);
		$this->var->add_param($cantidad);
		$this->var->add_param($precio_referencial_total);
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param($id_solicitud_compra_det);
		
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
		
	/**
	 * Nombre de la función:	InsertarProcesoCompraMulDet
	 * Propósito:				Agrupa un detalle de solicitud
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-06-2 17:42:41
	 */
	function AgrupaProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_iud';
		$this->codigo_procedimiento = "'AD_PRCODET_AGR'";
		//$this->codigo_procedimiento = "'AD_PRCODET_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra_det);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_solicitud_compra_det);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
		/**
	 * Nombre de la función:	InsertarProcesoCompraMulDet
	 * Propósito:				Agrupa un detalle de solicitud
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-06-2 17:42:41
	 */
	function InsertaProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_iud';
		$this->codigo_procedimiento = "'AD_PRCODET_INS'";
		//$this->codigo_procedimiento = "'AD_PRCODET_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("NULL");
		$this->var->add_param($id_solicitud_compra_det);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ModificarProcesoCompraMulDet
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_proceso_compra_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function ModificarProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_iud';
		$this->codigo_procedimiento = "'AD_PRCOMULDET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra_det);
		$this->var->add_param($id_servicio);
		$this->var->add_param($id_item);
		$this->var->add_param($cantidad);
		$this->var->add_param($precio_referencial_total);
		$this->var->add_param($id_proceso_compra);
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
	 * Nombre de la función:	EliminarProcesoCompraMulDet
	 * Propósito:				Elima el grupo de una solicitud_det y cambia o elimina proceso_det
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function EliminarProcesoCompraMulDet($id_solicitud_compra_det,$id_proceso_compra)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_det_iud';
		$this->codigo_procedimiento = "'AD_PRCOMULDET_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("NULL");	
		$this->var->add_param($id_solicitud_compra_det);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarProcesoCompraMulDet
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_proceso_compra_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-20 17:42:41
	 */
	function ValidarProcesoCompraMulDet($operacion_sql,$id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg)
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
				//Validar id_proceso_compra_det - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_proceso_compra_det");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_compra_det", $id_proceso_compra_det))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_servicio - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_servicio");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_servicio", $id_servicio))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cantidad - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad", $cantidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar precio_referencial_total - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_referencial_total");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_referencial_total", $precio_referencial_total))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proceso_compra - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proceso_compra");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_compra", $id_proceso_compra))
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
			//Validar id_proceso_compra_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proceso_compra_det");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_compra_det", $id_proceso_compra_det))
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