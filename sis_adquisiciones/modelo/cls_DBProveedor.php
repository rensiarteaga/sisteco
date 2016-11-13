<?php
/**
 * Nombre de la clase:	cls_DBProveedor.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_proveedor
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-17 10:31:03
 */

class cls_DBProveedor
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
	 * Nombre de la función:	ListarProveedor
	 * Propósito:				Desplegar los registros de tad_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 10:31:03
	 */
	function ListarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_sel';
		$this->codigo_procedimiento = "'AD_PROVEE_SEL'";

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
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_institucion','int4');
		//$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_persona','int4');
		//$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('nombre_pago','varchar');
		$this->var->add_def_cols('nombre_proveedor','text');
		$this->var->add_def_cols('usuario','varchar');
		$this->var->add_def_cols('contrasena','varchar');
		$this->var->add_def_cols('confirmado','varchar');
		$this->var->add_def_cols('direccion_proveedor','varchar');
		$this->var->add_def_cols('mail_proveedor','varchar');
		$this->var->add_def_cols('telefono1_proveedor','varchar');
		$this->var->add_def_cols('telefono2_proveedor','varchar');
		$this->var->add_def_cols('fax_proveedor','varchar');
		$this->var->add_def_cols('casilla_proveedor','varchar');
		$this->var->add_def_cols('celular1_proveedor','varchar');
		$this->var->add_def_cols('celular2_proveedor','varchar');
		$this->var->add_def_cols('email2_proveedor','varchar');
		$this->var->add_def_cols('pag_web_proveedor','varchar');
		$this->var->add_def_cols('nombre_contacto','varchar');
		$this->var->add_def_cols('direccion_contacto','varchar');
		$this->var->add_def_cols('telefono_contacto','varchar');
		$this->var->add_def_cols('email_contacto','varchar');
		$this->var->add_def_cols('tipo_contacto','varchar');
		$this->var->add_def_cols('id_contacto','int4');
		$this->var->add_def_cols('con_contacto','varchar');
		
		$this->var->add_def_cols('id_lugar','integer');
		$this->var->add_def_cols('ciudad','varchar');
		$this->var->add_def_cols('pais','varchar');
		$this->var->add_def_cols('rubro','text');
		$this->var->add_def_cols('rubro1','text');
		$this->var->add_def_cols('rubro2','text');
		$this->var->add_def_cols('tipo_doc_identificacion','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('paterno','varchar');
		$this->var->add_def_cols('materno','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('id_tipo_doc_institucion','integer');
		$this->var->add_def_cols('id_tipo_doc_identificacion','integer');
		$this->var->add_def_cols('id','integer');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('desc_persona','text');
		/*$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('nombre_pago','varchar');
		$this->var->add_def_cols('nombre_proveedor','varchar');
		$this->var->add_def_cols('usuario','varchar');
		$this->var->add_def_cols('contrasena','varchar');
		$this->var->add_def_cols('confirmado','varchar');
		
		$this->var->add_def_cols('direccion_proveedor','varchar');
		$this->var->add_def_cols('mail_proveedor','varchar');
		$this->var->add_def_cols('telefono1_proveedor','varchar');
		$this->var->add_def_cols('telefono2_proveedor','varchar');
		$this->var->add_def_cols('fax_proveedor','varchar');
		
		
		
		$this->var->add_def_cols('casilla_proveedor','varchar');
		$this->var->add_def_cols('celular1_proveedor','varchar');
		$this->var->add_def_cols('celular2_proveedor','varchar');
		$this->var->add_def_cols('email2_proveedor','varchar');
		$this->var->add_def_cols('pag_web_proveedor','varchar');
		$this->var->add_def_cols('nombre_contacto','text');
		$this->var->add_def_cols('direccion_contacto','varchar');
		$this->var->add_def_cols('telefono_contacto','varchar');
		$this->var->add_def_cols('email_contacto','varchar');
		$this->var->add_def_cols('tipo_contacto','varchar');
		$this->var->add_def_cols('id_contacto','int4');
		$this->var->add_def_cols('con_contacto','text');
		
		$this->var->add_def_cols('id_lugar','integer');
		$this->var->add_def_cols('ciudad','varchar');
		$this->var->add_def_cols('pais','varchar');
		$this->var->add_def_cols('rubro','text');
		$this->var->add_def_cols('rubro1','text');
		$this->var->add_def_cols('rubro2','text');
		
		
		$this->var->add_def_cols('tipo_doc_identificacion','varchar');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('paterno','varchar');
		$this->var->add_def_cols('materno','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('id_tipo_doc_institucion','integer');
		$this->var->add_def_cols('id_tipo_doc_identificacion','integer');
		$this->var->add_def_cols('id','integer');*/
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarProveedor
	 * Propósito:				Contar los registros de tad_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 10:31:03
	 */
	function ContarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_sel';
		$this->codigo_procedimiento = "'AD_PROVEE_COUNT'";

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
	 * Nombre de la función:	InsertarProveedor
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 10:31:03
	 */
	function InsertarProveedor($id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona,$nombre_pago,
							$usuario,$contrasena,$confirmado,$id_cuenta,$id_auxiliar,$nombre_pago,$direccion_proveedor,$telefono1_proveedor,$telefono2_proveedor,
							$mail_proveedor,$fax_proveedor,$casilla_proveedor,$celular1_proveedor,$celular2_proveedor,$email2_proveedor,$pag_web_proveedor,
    						$nombre_contacto,$direccion_contacto,$telefono_contacto,$email_contacto,$tipo_contacto,$id_contacto,$con_contacto,$id_depto,
    						$rubro,$rubro1,$rubro2,$tipo,$paterno,$materno,$nombre,$id_rubro,$id_documento,$doc_id,$nombre_institucion
	)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_iud';
		$this->codigo_procedimiento = "'AD_PROVEE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_persona);
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param("'$direccion_proveedor'");
		$this->var->add_param("'$telefono1_proveedor'");
		$this->var->add_param("'$telefono2_proveedor'");
		$this->var->add_param("'$mail_proveedor'");
		$this->var->add_param("'$fax_proveedor'");
		$this->var->add_param("'$casilla_proveedor'");
		$this->var->add_param("'$celular1_proveedor'");
		$this->var->add_param("'$celular2_proveedor'");
		$this->var->add_param("'$email2_proveedor'");
		$this->var->add_param("'$pag_web_proveedor'");
		$this->var->add_param("'$nombre_contacto'");
		$this->var->add_param("'$direccion_contacto'");
		$this->var->add_param("'$telefono_contacto'");
		$this->var->add_param("'$email_contacto'");
		$this->var->add_param("'$tipo_contacto'");
		$this->var->add_param($id_contacto);
		$this->var->add_param("'$con_contacto'");
		$this->var->add_param("$id_depto");
		$this->var->add_param("'$rubro'");
		$this->var->add_param("'$rubro1'");
		$this->var->add_param("'$rubro2'");
		
		
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$paterno'");
		$this->var->add_param("'$materno'");
		$this->var->add_param("'$nombre'");
		
		$this->var->add_param("'$id_rubro'");
		$this->var->add_param($id_documento);
		$this->var->add_param("'$doc_id'");
		$this->var->add_param("'$nombre_institucion'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ModificarProveedor
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 10:31:03
	 */
	
function ModificarProveedor($id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona,$nombre_pago,
							$usuario,$contrasena,$confirmado,$id_cuenta,$id_auxiliar,$nombre_pago,$direccion_proveedor,$telefono1_proveedor,$telefono2_proveedor,
							$mail_proveedor,$fax_proveedor,$casilla_proveedor,$celular1_proveedor,$celular2_proveedor,$email2_proveedor,$pag_web_proveedor,
    						$nombre_contacto,$direccion_contacto,$telefono_contacto,$email_contacto,$tipo_contacto,$id_contacto,$con_contacto,$id_depto,
    						$rubro,$rubro1,$rubro2,$tipo,$paterno,$materno,$nombre,$id_rubro,$id_documento,$doc_id,$nombre_institucion
	)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_iud';
		$this->codigo_procedimiento = "'AD_PROVEE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proveedor);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_persona);
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param("'$usuario'");
		$this->var->add_param("'$contrasena'");
		$this->var->add_param("'$confirmado'");
		$this->var->add_param("$id_cuenta");
		$this->var->add_param("$id_auxiliar");
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param("'$direccion_proveedor'");
		$this->var->add_param("'$telefono1_proveedor'");
		$this->var->add_param("'$telefono2_proveedor'");
		$this->var->add_param("'$mail_proveedor'");
		$this->var->add_param("'$fax_proveedor'");
		$this->var->add_param("'$casilla_proveedor'");
		$this->var->add_param("'$celular1_proveedor'");
		$this->var->add_param("'$celular2_proveedor'");
		$this->var->add_param("'$email2_proveedor'");
		$this->var->add_param("'$pag_web_proveedor'");
		$this->var->add_param("'$nombre_contacto'");
		$this->var->add_param("'$direccion_contacto'");
		$this->var->add_param("'$telefono_contacto'");
		$this->var->add_param("'$email_contacto'");
		$this->var->add_param("'$tipo_contacto'");
		$this->var->add_param($id_contacto);
		$this->var->add_param("'$con_contacto'");
		$this->var->add_param("$id_depto");
		$this->var->add_param("'$rubro'");
		$this->var->add_param("'$rubro1'");
		$this->var->add_param("'$rubro2'");
		
		
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$paterno'");
		$this->var->add_param("'$materno'");
		$this->var->add_param("'$nombre'");
		
		$this->var->add_param("'$id_rubro'");
		$this->var->add_param($id_documento);
		$this->var->add_param("'$doc_id'");
		$this->var->add_param("'$nombre_institucion'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	
	/**
	 * Nombre de la función:	EliminarProveedor
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 10:31:03
	 */
		function EliminarProveedor($id_proveedor)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_iud';
		$this->codigo_procedimiento = "'AD_PROVEE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proveedor);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_cuenta
		$this->var->add_param("NULL");//id_auxiliar
		
		
		$this->var->add_param("NULL");//("'$txt_nombre_pago'");
		$this->var->add_param("NULL");//("'$txt_direccion_proveedor'");
		$this->var->add_param("NULL");//("'$txt_telefono1_proveedor'");
		$this->var->add_param("NULL");//("'$txt_telefono2_proveedor'");
		$this->var->add_param("NULL");//("'$txt_mail_proveedor'");
		$this->var->add_param("NULL");//("'$txt_fax_proveedor'");
		$this->var->add_param("NULL");//("'$txt_casilla_proveedor'");
		$this->var->add_param("NULL");//("'$txt_celular1_proveedor'");
		$this->var->add_param("NULL");//("'$txt_celular2_proveedor'");
		$this->var->add_param("NULL");//("'$txt_email2_proveedor'");
		$this->var->add_param("NULL");//("'$txt_pag_web_proveedor'");
		$this->var->add_param("NULL");//("'$txt_nombre_contacto'");
		$this->var->add_param("NULL");//("'$txt_direccion_contacto'");
		$this->var->add_param("NULL");//("'$txt_telefono_contacto'");
		$this->var->add_param("NULL");//("'$txt_email_contacto'");
		$this->var->add_param("NULL");//("'$txt_tipo_contacto'");
		$this->var->add_param("NULL");//($txt_id_contacto);
		$this->var->add_param("NULL");//("'$txt_con_contacto'");
		
		$this->var->add_param("NULL");//id_depto
		$this->var->add_param("NULL");//rubro
		$this->var->add_param("NULL");//rubor1
		$this->var->add_param("NULL");//rubro2

		
		$this->var->add_param("NULL");//$this->var->add_param("'$tipo'");
		$this->var->add_param("NULL");//$this->var->add_param("'$paterno'");
		$this->var->add_param("NULL");//$this->var->add_param("'$materno'");
		$this->var->add_param("NULL");//$this->var->add_param("'$nombre'");
		
		$this->var->add_param("NULL");//$this->var->add_param($id_rubro);
		$this->var->add_param("NULL");//$this->var->add_param($id_documento);
		$this->var->add_param("NULL");//$this->var->add_param("'$doc_id'");
		$this->var->add_param("NULL");//$this->var->add_param("'$nombre_institucion'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarNuevoProveedor
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-15 12:05:58
	 */
/*	function InsertarNuevoProveedor($codigo,$observaciones,$nombre_pago,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$id_tipo_doc_institucion,$apellido_paterno,$apellido_materno,$nombre_p,$doc_id_p,$casilla_p,$telefono1_p,$telefono2_p,$celular1_p,$celular2_p,$pag_web_p,$email1_p,$email2_p,$id_tipo_doc_identificacion,$tipo_contacto,$apellido_paterno_c,$apellido_materno_c,$nombre_c,$telefono1_c,$celular1_c,$celular2_c,$email1_c,$email2_c,$tipo_proveedor,$con_contacto,$id_cuenta,$id_auxiliar,$direccion_ins,$direccion_p,$direccion_c,$id_depto,$rubro,$rubro1,$rubro2)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_nuevo_proveedor_iud';
		$this->codigo_procedimiento = "'AD_WIZPRO_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param("'$doc_id'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$casilla'");
		$this->var->add_param("'$telefono1'");
		$this->var->add_param("'$telefono2'");
		$this->var->add_param("'$celular1'");
		$this->var->add_param("'$celular2'");
		$this->var->add_param("'$fax'");
		$this->var->add_param("'$email1'");
		$this->var->add_param("'$email2'");
		$this->var->add_param("'$pag_web'");
		$this->var->add_param($id_tipo_doc_institucion);
		$this->var->add_param("'$apellido_paterno'");
		$this->var->add_param("'$apellido_materno'");
		$this->var->add_param("'$nombre_p'");
		$this->var->add_param("'$doc_id_p'");
		$this->var->add_param("'$casilla_p'");
		$this->var->add_param("'$telefono1_p'");
		$this->var->add_param("'$telefono2'");
		$this->var->add_param("'$celular1_p'");
		$this->var->add_param("'$celular2_p'");
		$this->var->add_param("'$pag_web_p'");
		$this->var->add_param("'$email1_p'");
		$this->var->add_param("'$email2_p'");
		$this->var->add_param($id_tipo_doc_identificacion);
		$this->var->add_param("'$tipo_contacto'");
		$this->var->add_param("'$apellido_paterno_c'");
		$this->var->add_param("'$apellido_materno_c'");
		$this->var->add_param("'$nombre_c'");
		$this->var->add_param("'$telefono1_c'");
		$this->var->add_param("'$celular1_c'");
		$this->var->add_param("'$celular2_c'");
		$this->var->add_param("'$email1_c'");
		$this->var->add_param("'$email2_c'");
		$this->var->add_param("'$tipo_proveedor'");
		$this->var->add_param("'$con_contacto'");
		$this->var->add_param("$id_cuenta");
		$this->var->add_param("$id_auxiliar");
		$this->var->add_param("'$direccion_ins'");
        $this->var->add_param("'$direccion_p'");
        $this->var->add_param("'$direccion_c'");
        
        $this->var->add_param("$id_depto");
		$this->var->add_param("'$rubro'");
        $this->var->add_param("'$rubro1'");
        $this->var->add_param("'$rubro2'");
        //Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	*/
	
	
	function InsertarNuevoProveedor($tipo_proveedor,$id_depto,	$id_rubro,$nombre_ins,$direccion_ins,$id_tipo_doc_institucion,
	$doc_id,$con_contacto,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$rubro1,$rubro2,$tipo,$apellido_paterno,
	$apellido_materno,$nombre_p,$id_tipo_doc_identificacion,$doc_id_p,$direccion_p,$apellido_paterno_c,$apellido_materno_c,$nombre_c,
	$telefono1_c,$celular1_c,$email1_c,$tipo_contacto,$direccion_c
	,$nombre_pago,$codigo
	)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_nuevo_proveedor_iud_new';
		$this->codigo_procedimiento = "'AD_WIZPRO_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		$this->var->add_param("'$tipo_proveedor'");		
		
		$this->var->add_param($id_depto);		
		$this->var->add_param($id_rubro);		
		$this->var->add_param("'$nombre_ins'");		
		$this->var->add_param("'$direccion_ins'");		
		$this->var->add_param($id_tipo_doc_institucion);		
		$this->var->add_param("'$doc_id'");		
		$this->var->add_param("'$con_contacto'");		
		$this->var->add_param("'$telefono1'");		
		$this->var->add_param("'$telefono2'");		
		$this->var->add_param("'$celular1'");		
		$this->var->add_param("'$celular2'");		
		$this->var->add_param("'$fax'");		
		$this->var->add_param("'$email1'");		
		$this->var->add_param("'$email2'");		
		$this->var->add_param("'$pag_web'");		
		$this->var->add_param("'$rubro1'");		
		$this->var->add_param("'$rubro2'");		
		$this->var->add_param("'$tipo'");		
		$this->var->add_param("'$apellido_paterno'");		
		$this->var->add_param("'$apellido_materno'");		
		$this->var->add_param("'$nombre_p'");
		$this->var->add_param($id_tipo_doc_identificacion);
		$this->var->add_param("'$doc_id_p'");
		$this->var->add_param("'$direccion_p'");
		$this->var->add_param("'$apellido_paterno_c'");
		$this->var->add_param("'$apellido_materno_c'");
		$this->var->add_param("'$nombre_c'");
		$this->var->add_param("'$telefono1_c'");
		$this->var->add_param("'$celular1_c'");
		$this->var->add_param("'$email1_c'");
		$this->var->add_param("'$tipo_contacto'");
		$this->var->add_param("'$direccion_c'");
	
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param("'$codigo'");
		
//		$this->var->add_param("'$codigo'");
//		$this->var->add_param("'$observaciones'");
//		$this->var->add_param("'$nombre_pago'");
//		$this->var->add_param("'$doc_id'");
//		$this->var->add_param("'$nombre'");
//		$this->var->add_param("'$casilla'");
//		$this->var->add_param("'$telefono1'");
//		$this->var->add_param("'$telefono2'");
//		$this->var->add_param("'$celular1'");
//		$this->var->add_param("'$celular2'");
//		$this->var->add_param("'$fax'");
//		$this->var->add_param("'$email1'");
//		$this->var->add_param("'$email2'");
//		$this->var->add_param("'$pag_web'");
//		$this->var->add_param($id_tipo_doc_institucion);
//		$this->var->add_param("'$apellido_paterno'");
//		$this->var->add_param("'$apellido_materno'");
//		$this->var->add_param("'$nombre_p'");
//		$this->var->add_param("'$doc_id_p'");
//		$this->var->add_param("'$casilla_p'");
//		$this->var->add_param("'$telefono1_p'");
//		$this->var->add_param("'$telefono2'");
//		$this->var->add_param("'$celular1_p'");
//		$this->var->add_param("'$celular2_p'");
//		$this->var->add_param("'$pag_web_p'");
//		$this->var->add_param("'$email1_p'");
//		$this->var->add_param("'$email2_p'");
//		$this->var->add_param($id_tipo_doc_identificacion);
//		$this->var->add_param("'$tipo_contacto'");
//		$this->var->add_param("'$apellido_paterno_c'");
//		$this->var->add_param("'$apellido_materno_c'");
//		$this->var->add_param("'$nombre_c'");
//		$this->var->add_param("'$telefono1_c'");
//		$this->var->add_param("'$celular1_c'");
//		$this->var->add_param("'$celular2_c'");
//		$this->var->add_param("'$email1_c'");
//		$this->var->add_param("'$email2_c'");
//		$this->var->add_param("'$tipo_proveedor'");
//		$this->var->add_param("'$con_contacto'");
//		$this->var->add_param("$id_cuenta");
//		$this->var->add_param("$id_auxiliar");
//		$this->var->add_param("'$direccion_ins'");
//        $this->var->add_param("'$direccion_p'");
//        $this->var->add_param("'$direccion_c'");
//        
//        $this->var->add_param("$id_depto");
//		$this->var->add_param("'$rubro'");
//        $this->var->add_param("'$rubro1'");
//        $this->var->add_param("'$rubro2'");
        //Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
		/**
	 * Nombre de la función:	ListarProveedorVista
	 * Propósito:				Desplegar los registros de vad_proveedor
	 * Autor:				    RCM
	 * Fecha de creación:		21/10/2008
	 */
	function ListarProveedorVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_sel';
		$this->codigo_procedimiento = "'AD_PROVIS_SEL'";

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
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('usuario','varchar');
		$this->var->add_def_cols('contrasena','varchar');
		$this->var->add_def_cols('confirmado','varchar');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('nombre_pago','varchar');
		//$this->var->add_def_cols('id_auxiliar','int4');
		//$this->var->add_def_cols('id_cuenta','int4');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarProveedorVista
	 * Propósito:				Contar los registros de vad_proveedor
	 * Autor:				    RCM
	 * Fecha de creación:		21/10/2008
	 */
	function ContarProveedorVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_sel';
		$this->codigo_procedimiento = "'AD_PROVIS_COUNT'";

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
	 * Nombre de la función:	ValidarProveedor
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 10:31:03
	 */
	function ValidarProveedor($operacion_sql,$id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona)
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
				//Validar id_proveedor - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_proveedor");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
//			$tipo_dato->_reiniciar_valor();
//			$tipo_dato->set_Columna("codigo");
//			$tipo_dato->set_MaxLength(20);
//			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
//			{
//				$this->salida = $valid->salida;
//				return false;
//			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
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

			//Validar id_persona - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_persona");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_persona", $id_persona))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
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
	

	function ValidarNuevoProveedor($operacion_sql,$codigo,$observaciones,$nombre_pago,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$id_tipo_doc_institucion,$apellido_paterno,$apellido_materno,$nombre_p,$doc_id_p,$casilla_p,$telefono1_p,$telefono2_p,$celular1_p,$celular2_p,$pag_web_p,$email1_p,$email2_p,$id_tipo_doc_identificacion,$tipo_contacto,$apellido_paterno_c,$apellido_materno_c,$nombre_c,$telefono1_c,$celular1_c,$celular2_c,$email1_c,$email2_c)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert')
		{
			//Validar codigo - tipo varchar
//			$tipo_dato->_reiniciar_valor();
//			$tipo_dato->set_MaxLength(20);
//			$tipo_dato->set_Columna("codigo");
//			$tipo_dato->set_AllowBlank(true);
//			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
//			{
//				$this->salida = $valid->salida;
//				return false;
//			}
			
			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(200);
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_pago - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_pago");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_pago", $nombre_pago))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar doc_id - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("doc_id");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "doc_id", $doc_id))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar casilla - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("casilla");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "casilla", $casilla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono1");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono1", $telefono1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono2");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono2", $telefono2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular1");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular1", $celular1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular2");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular2", $celular2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fax - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fax");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fax", $fax))
			{
				$this->salida = $valid->salida;
				return false;
			}
/*
			//Validar email1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email1");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "email1", $email1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar email2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email2");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "email2", $email2))
			{
				$this->salida = $valid->salida;
				return false;
			}
*/
			//Validar pag_web - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("pag_web");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "pag_web", $pag_web))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_doc_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_doc_institucion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_doc_institucion", $id_tipo_doc_institucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar apellido_paterno - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("apellido_paterno");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "apellido_paterno", $apellido_paterno))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar apellido_materno - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("apellido_materno");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "apellido_materno", $apellido_materno))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_p");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_p", $nombre_p))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar doc_id - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("doc_id_p");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "doc_id_p", $doc_id_p))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar casilla - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("casilla_p");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "casilla_p", $casilla_p))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono1_p");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono1_p", $telefono1_p))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono2_p");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono2_p", $telefono2_p))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular1_p");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular1_p", $celular1_p))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular2_p");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular2_p", $celular2_p))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar pag_web - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("pag_web_p");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "pag_web_p", $pag_web_p))
			{
				$this->salida = $valid->salida;
				return false;
			}
/*
			//Validar email1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email1_p");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "email1_p", $email1_p))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar email2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email2_p");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "email2_p", $email2_p))
			{
				$this->salida = $valid->salida;
				return false;
			}
*/
			//Validar id_tipo_doc_identificacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_doc_identificacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_doc_identificacion", $id_tipo_doc_identificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_contacto - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_contacto");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_contacto", $tipo_contacto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar apellido_paterno - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("apellido_paterno_c");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "apellido_paterno_c", $apellido_paterno_c))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar apellido_materno - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("apellido_materno_c");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "apellido_materno_c", $apellido_materno_c))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_c");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_c", $nombre_c))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono1_c");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono1_c", $telefono1_c))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular1_c");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular1_c", $celular1_c))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular2_c");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular2_c", $celular2_c))
			{
				$this->salida = $valid->salida;
				return false;
			}

/*			//Validar email1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email1_c");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "email1_c", $email1_c))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar email2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email2_c");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "email2_c", $email2_c))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function ModificarProveedorCuenta($id_proveedor,$id_cuenta,$id_auxiliar){
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_iud';
		$this->codigo_procedimiento = "'AD_PROCUE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proveedor);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_cuenta");
		$this->var->add_param("$id_auxiliar");
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
		
		$this->var->add_param("NULL");//id_depto
		$this->var->add_param("NULL");//rubro
		$this->var->add_param("NULL");//rubor1
		$this->var->add_param("NULL");//rubro2
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	//----------------------------------------02Jun10----------------------------------------------------
	function ListarRubros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_sel';
		$this->codigo_procedimiento = "'AD_RUBROS_SEL'";

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
		$this->var->add_def_cols('id_tipo_servicio','int4');
		$this->var->add_def_cols('id_supergrupo','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('tipo','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	
	function ContarRubros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_sel';
		$this->codigo_procedimiento = "'AD_RUBROS_COUNT'";

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
	 * Nombre de la función:	ListarProveedorVista
	 * Propósito:				Desplegar los registros de vad_proveedor
	 * Autor:				    RCM
	 * Fecha de creación:		24-08-2011
	 */
	function ListarProveedorVista2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_sel';
		$this->codigo_procedimiento = "'AD_PROVIS2_SEL'";

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
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('usuario','varchar');
		$this->var->add_def_cols('contrasena','varchar');
		$this->var->add_def_cols('confirmado','varchar');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('nombre_pago','varchar');
		//$this->var->add_def_cols('id_auxiliar','int4');
		//$this->var->add_def_cols('id_cuenta','int4');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarProveedorVista
	 * Propósito:				Contar los registros de vad_proveedor
	 * Autor:				    RCM
	 * Fecha de creación:		24-08-2011
	 */
	function ContarProveedorVista2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proveedor_sel';
		$this->codigo_procedimiento = "'AD_PROVIS2_COUNT'";

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
}
?>