<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarEmpleadoTpmFrppa.php
Propósito:				Permite realizar el listado en tkp_empleado_tpm_frppa
Tabla:					t_tkp_empleado_tpm_frppa
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-10-18 09:44:23
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarEmpleadoTpmFrppa .php';

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

	if($sort == '') $sortcol = 'id_empleado_frppa';
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
	
	if($id_categoria_adq>0){//para que los RPA's que ya estan asignados a una EP  y a una categoria especifica no sean listados 
	   $criterio_filtro=$criterio_filtro." AND EMPLEP.id_empleado_frppa not in (select id_empleado_frppa from compro.tad_rpa where id_categoria_adq=$id_categoria_adq)";
	    
	}
	
	
	if($id_usuario>0){//para listar los solicitantes de la misma EP que el usuario que vendrá a ser transcriptor en Sistema de Adquiisciones para solicitud de compra
		
	  $criterio_filtro=$criterio_filtro. " AND EMPLEP.id_fina_regi_prog_proy_acti in (select asig_ep.id_fina_regi_prog_proy_acti from sss.tsg_usuario_asignacion usuasi
                                                                         inner join tsg_asignacion_estructura asiest on asiest.id_asignacion_estructura=usuasi.id_asignacion_estructura
                                                                         inner join tsg_asignacion_estructura_tpm_frppa asig_ep on asig_ep.id_asignacion_estructura=asiest.id_asignacion_estructura
                                                                         where usuasi.id_usuario=$id_usuario)";
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'EmpleadoTpmFrppa');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarEmpleadoTpmFrppa($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	/*echo $criterio_filtro;
	exit;	*/
	
	if($res) $total_registros= $Custom->salida;
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarEmpleadoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_empleado_frppa',$f["id_empleado_frppa"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
			$xml->add_nodo('fecha_registro',$f["fecha_registro"]);
			$xml->add_nodo('hora_ingreso',$f["hora_ingreso"]);
			$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);
			$xml->add_nodo('desc_financiador',$f["desc_financiador"]);
			$xml->add_nodo('desc_regional',$f["desc_regional"]);
			$xml->add_nodo('desc_programa',$f["desc_programa"]);
			$xml->add_nodo('desc_proyecto',$f["desc_proyecto"]);
			$xml->add_nodo('desc_actividad',$f["desc_actividad"]);
			$xml->add_nodo('desc_nombrecompleto', $f["desc_nombrecompleto"]);
			$xml->add_nodo('ci', $f["ci"]);
            $xml->add_nodo('email', $f["email"]);
             $xml->add_nodo('desc_frppa', $f["desc_frppa"]);
             $xml->add_nodo('codigo_frppa', $f["codigo_frppa"]);
             $xml->add_nodo('id_frppa', $f["id_frppa"]);
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