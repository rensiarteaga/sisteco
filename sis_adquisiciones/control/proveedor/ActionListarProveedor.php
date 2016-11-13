<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarProveedor.php
Propósito:				Permite realizar el listado en tad_proveedor
Tabla:					t_tad_proveedor
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-10-17 10:31:05
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarProveedor .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_proveedor';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Proveedor');
	$sortcol = $crit_sort->get_criterio_sort();

	if($tipo_adq =='Bien'){//where id_item in (select distinct id_item from compro.tad_solicitud_compra_det where id_solicitud_compra in (select distinct id_solicitud_compra from compro.tad_solicitud_proceso_compra where id_proceso_compra=$id_proceso_compra)))
	    //AND PROVEE.id_proveedor in (SELECT id_proveedor from compro.tad_item_proveedor) 
	   //$criterio_filtro=$criterio_filtro." AND PROVEE.id_proveedor not in (select id_proveedor from compro.tad_cotizacion where id_proceso_compra=$id_proceso_compra and estado_vigente!=''anulado'')";  
	}
	if($tipo_adq=='Servicio'){//where id_servicio in  (select distinct id_servicio from compro.tad_solicitud_compra_det where id_solicitud_compra in (select distinct id_solicitud_compra from compro.tad_solicitud_proceso_compra where id_proceso_compra=$id_proceso_compra)))
	    // AND PROVEE.id_proveedor in (SELECT id_proveedor from compro.tad_servicio_proveedor)
		//$criterio_filtro=$criterio_filtro." AND PROVEE.id_proveedor not in (select id_proveedor from compro.tad_cotizacion where id_proceso_compra=$id_proceso_compra and estado_vigente!=''anulado'')";//AND PROVEE.id_cuenta>0
	}
	
	if($id_proveedor>0){// para el maestro en servicio-item/proveedor
		$criterio_filtro=$criterio_filtro." AND PROVEE.id_proveedor=$id_proveedor";
	}
	//Obtiene el total de los registros
	if($codigo_proveedor!=''){
	    $criterio_filtro=$criterio_filtro." AND lower(PROVEE.codigo) = lower(''$codigo_proveedor'')";
	}
	
	$res = $Custom -> ContarProveedor($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
        if($oc == 'si'){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_proveedor', '%');
			$xml->add_nodo('codigo','Todos');
			$xml->add_nodo('observaciones','Todos');
			$xml->add_nodo('fecha_reg','Todos');
			$xml->add_nodo('id_institucion','Todos');
			$xml->add_nodo('desc_institucion','Todos');
			$xml->add_nodo('id_persona','Todos');
			$xml->add_nodo('desc_persona','Todos');
			$xml->add_nodo('nombre_pago','Todos');
			$xml->add_nodo('nombre_proveedor','Todos');
			$xml->add_nodo('usuario','Todos');	
			$xml->add_nodo('contrasena','Todos');
			$xml->add_nodo('confirmado','Todos');
			$xml->add_nodo('direccion_proveedor','Todos');
			$xml->add_nodo('mail_proveedor','Todos');
			$xml->add_nodo('telefono1_proveedor','Todos');
			$xml->add_nodo('telefono2_proveedor','Todos');
			$xml->add_nodo('fax_proveedor','Todos');
			$xml->add_nodo('id_cuenta','Todos');
			$xml->add_nodo('nombre_cuenta','Todos');
			$xml->add_nodo('id_auxiliar','Todos');
			$xml->add_nodo('nombre_auxiliar','Todos');
			$xml->add_nodo('casilla_proveedor','Todos');
			$xml->add_nodo('celular1_proveedor','Todos');
			$xml->add_nodo('celular2_proveedor','Todos');
			$xml->add_nodo('email2_proveedor','Todos');
			$xml->add_nodo('pag_web_proveedor','Todos');
			$xml->add_nodo('nombre_contacto','Todos');
			$xml->add_nodo('direccion_contacto','Todos');
			$xml->add_nodo('telefono_contacto','Todos');
			$xml->add_nodo('email_contacto','Todos');
			$xml->add_nodo('tipo_contacto','Todos');
			$xml->add_nodo('id_contacto','Todos');
			$xml->add_nodo('con_contacto','Todos');			
			$xml->add_nodo('desc_insti_per','Todos');
			$xml->fin_rama();
		}
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_proveedor',$f["id_proveedor"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_institucion',$f["id_institucion"]);
			$xml->add_nodo('desc_institucion',$f["desc_institucion"]);
			$xml->add_nodo('id_persona',$f["id_persona"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);
			$xml->add_nodo('nombre_pago',$f["nombre_pago"]);
			$xml->add_nodo('nombre_proveedor',$f["nombre_proveedor"]);
			$xml->add_nodo('usuario',$f["usuario"]);	
			$xml->add_nodo('contrasena',$f["contrasena"]);
			$xml->add_nodo('confirmado',$f["confirmado"]);
			$xml->add_nodo('direccion_proveedor',$f["direccion_proveedor"]);
			$xml->add_nodo('mail_proveedor',$f["mail_proveedor"]);
			$xml->add_nodo('telefono1_proveedor',$f["telefono1_proveedor"]);
			$xml->add_nodo('telefono2_proveedor',$f["telefono2_proveedor"]);
			$xml->add_nodo('fax_proveedor',$f["fax_proveedor"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
			$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
			$xml->add_nodo('nombre_auxiliar',$f["nombre_auxiliar"]);
			
			$xml->add_nodo('casilla_proveedor',$f["casilla_proveedor"]);
			$xml->add_nodo('celular1_proveedor',$f["celular1_proveedor"]);
			$xml->add_nodo('celular2_proveedor',$f["celular2_proveedor"]);
			$xml->add_nodo('email2_proveedor',$f["email2_proveedor"]);
			$xml->add_nodo('pag_web_proveedor',$f["pag_web_proveedor"]);
			$xml->add_nodo('nombre_contacto',$f["nombre_contacto"]);
			$xml->add_nodo('direccion_contacto',$f["direccion_contacto"]);
			$xml->add_nodo('telefono_contacto',$f["telefono_contacto"]);
			$xml->add_nodo('email_contacto',$f["email_contacto"]);
			$xml->add_nodo('tipo_contacto',$f["tipo_contacto"]);
			$xml->add_nodo('id_contacto',$f["id_contacto"]);
			$xml->add_nodo('con_contacto',$f["con_contacto"]);
			
			$xml->add_nodo('desc_insti_per',$f["desc_institucion"].$f["desc_persona"]);
			
			$xml->add_nodo('id_depto',$f["id_lugar"]);
			$xml->add_nodo('ciudad',$f["ciudad"]);
			$xml->add_nodo('pais',$f["pais"]);
			$xml->add_nodo('rubro',$f["rubro"]);
			$xml->add_nodo('rubro1',$f["rubro1"]);
			$xml->add_nodo('rubro2',$f["rubro2"]);
			$xml->add_nodo('tipo_doc_identificacion',$f["tipo_doc_identificacion"]);
			$xml->add_nodo('doc_id',$f["doc_id"]);
			$xml->add_nodo('paterno',$f["paterno"]);
			$xml->add_nodo('materno',$f["materno"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('id_tipo_doc_institucion',$f["id_tipo_doc_institucion"]);
			$xml->add_nodo('id_tipo_doc_identificacion',$f["id_tipo_doc_identificacion"]);
			$xml->add_nodo('id',$f["id"]);
			$xml->add_nodo('desc_institucion',$f["desc_institucion"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);
			
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>