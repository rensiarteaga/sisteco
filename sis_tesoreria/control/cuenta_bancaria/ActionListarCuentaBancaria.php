<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCuentaBancaria.php
Propï¿½sito:				Permite realizar el listado en tts_cuenta_bancaria
Tabla:					tts_tts_cuenta_bancaria
Parï¿½metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaciï¿½n:		2008-10-16 11:07:13
Versiï¿½n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarCuentaBancaria .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parï¿½metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_cuenta_bancaria';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se harï¿½ o no la decodificaciï¿½n(sï¿½lo pregunta en caso del GET)
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
		
	if ($m_vista_cheque=='registro_cheque_conta' && $m_id_cuenta && $m_id_auxiliar  ){
		
		//$criterio_filtro=$criterio_filtro." and CUEBAN.id_cuenta = $m_id_cuenta and CUEBAN.id_auxiliar =$m_id_auxiliar";		
		$criterio_filtro=$criterio_filtro." and (1 in (select 1 from tesoro.tts_cuenta_bancaria
		 											  where id_cuenta=$m_id_cuenta
		 											  and id_auxiliar=$m_id_auxiliar)
		 										  OR 1 in (select 1 from tesoro.tts_cuenta_bancaria_cuenta
		 											  where id_cuenta=$m_id_cuenta
		 											  and id_auxiliar=$m_id_auxiliar)) and parama.estado_gestion = 1 ";		
	}
	if ($m_estado_cuenta==1){
		
		//$criterio_filtro=$criterio_filtro." and CUEBAN.id_cuenta = $m_id_cuenta and CUEBAN.id_auxiliar =$m_id_auxiliar";		
		$criterio_filtro=$criterio_filtro." and estado_cuenta=1 and parama.estado_gestion = 1 ";		
	}	
	if ($m_sw_combo=='combo'  ){
		//$criterio_filtro=$criterio_filtro." and CUEBAN.id_cuenta = $m_id_cuenta and CUEBAN.id_auxiliar =$m_id_auxiliar";		
		$criterio_filtro=$criterio_filtro." and CUEBAN.estado_cuenta=1 and parama.estado_gestion = 1 ";		
	}
		
	if($tipo_vista=='rep_libreta_bancaria'){
		$criterio_filtro=$criterio_filtro." and gestion.id_gestion= ".$id_gestion;
	}
 	//AVQ. Para SIET 
    //Fecha de modificación 1 de septiembre del 2016
	if($tipo_vista=='extracto_bancario'){
	   $criterio_filtro=$criterio_filtro." and (gestion.id_gestion= ".$id_gestion." and  CUENTA.id_cuenta in (select id_cuenta from sci.tct_cuenta where sw_siet=''si'')) or id_cuenta_bancaria=1";
	}
	
	
	if($tipo_vista=='tkp_obligacion'){//Mzambrana: 21feb11 -> para filtro de cuentas_bancarias por gestion relacionada al pago de la obligacion
		$criterio_filtro=$criterio_filtro." and gestion.gestion= ".$gestion;	
	}
	
	if($m_id_gestion){
	  	if($m_id_gestion == -2){ //02/01/2013:MZM se adiciona OR CUEBAN.estdo_cuenta=1 debido a que al cambio de gestion existen cheques por imprimir de la gestion q acaba de terminar ==> para que solo liste de la ultima gestion se tendrá q inactivar las cuentas de la gestion q termina
	  		$criterio_filtro=$criterio_filtro." AND (GESTION.id_gestion IN (Select max(id_gestion) from tesoro.tts_parametro) OR CUEBAN.estado_cuenta=1 ) ";	
	  	}
	  	else {
	  		$criterio_filtro=$criterio_filtro." AND GESTION.id_gestion=".$m_id_gestion;	
	  	}
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CuentaBancaria');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarCuentaBancaria($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	 
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('id_institucion',$f["id_institucion"]);
			$xml->add_nodo('desc_institucion',$f["desc_institucion"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
			$xml->add_nodo('desc_auxiliar',$f["desc_auxiliar"]);
			$xml->add_nodo('nro_cheque',$f["nro_cheque"]);
			$xml->add_nodo('estado_cuenta',$f["estado_cuenta"]);
			$xml->add_nodo('nro_cuenta_banco',$f["nro_cuenta_banco"]);
            $xml->add_nodo('id_moneda',$f["id_moneda"]);
            $xml->add_nodo('nombre_moneda',$f["nombre_moneda"]);
            $xml->add_nodo('gestion',$f["gestion"]);
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