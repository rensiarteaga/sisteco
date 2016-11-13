<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPartidaCuenta.php
Prop�sito:				Permite realizar el listado en tpr_partida_cuenta
Tabla:					tpr_tpr_partida_cuenta
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2008-07-07 11:38:59
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarCuentaPartida.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_partida_cuenta';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	if($_POST['CantFiltros']=='') $_POST['CantFiltros'] = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$_POST['CantFiltros'];$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
 
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	 //echo $_POST['CantFiltros']; exit();
	if ($sw_reg_columna_valor=='si'){
	  	$criterio_filtro=$criterio_filtro."and ((id_partida in (select id_partida from presto.tpr_partida_presupuesto where id_presupuesto=$m_id_presupuesto) and (select tipo_pres!=0  from presto.tpr_presupuesto where id_presupuesto =$m_id_presupuesto))
	  											or (id_partida in (select id_partida from presto.tpr_partida where sw_movimiento=2 and  id_parametro in (select id_parametro from presto.tpr_presupuesto where id_presupuesto=$m_id_presupuesto))
	  												and (select tipo_pres=0  from presto.tpr_presupuesto where id_presupuesto =$m_id_presupuesto)
	  											))";
	}else {
		if($m_sw_partida_cuenta=='si'){  
				$criterio_filtro=$criterio_filtro." and PARCUE.id_parametro in (select id_parametro from presto.tpr_parametro where id_gestion=".$m_id_gestion.")";
		}	
			
		if ($m_momneto==0){
			$criterio_filtro=$criterio_filtro." AND id_partida is null 	and id_gestion in (	select id_gestion from presto.tpr_parametro
                                                  						  					where id_parametro in (select id_parametro from presto.tpr_presupuesto where id_presupuesto=$m_id_presupuesto)) ";//
		}else{  //cuando el momento es diferente de 0
			if($sw_reg_comp=='si'&&$m_id_presupuesto){
				$criterio_filtro=$criterio_filtro." AND  (id_partida in (select id_partida from presto.tpr_partida par inner join presto.tpr_presupuesto pre on pre.id_parametro=par.id_parametro
																		  where pre.id_presupuesto=$m_id_presupuesto  and par.sw_movimiento=2  and par.sw_transaccional=1 
																		  and COALESCE ( (  select TRUE from presto.tpr_presupuesto_ids pi
																							left join param.tpm_depto_conta  dc on dc.id_presupuesto=pi.id_presupuesto_uno
																							left join param.tpm_depto_conta  dc2 on dc2.id_presupuesto=pi.id_presupuesto_dos               
																							where id_presupuesto_uno=$m_id_presupuesto or id_presupuesto_dos=$m_id_presupuesto or dc.id_presupuesto=$m_id_presupuesto or dc2.id_presupuesto=$m_id_presupuesto
																							LIMIT 1), FALSE ) 
																		 union 
																		 select id_partida from presto.tpr_partida_presupuesto where id_presupuesto =$m_id_presupuesto ) 
													 OR (id_partida is null and COALESCE (( select TRUE from presto.tpr_presupuesto_ids pi
																							 left join param.tpm_depto_conta  dc on dc.id_presupuesto=pi.id_presupuesto_uno
																							 left join param.tpm_depto_conta  dc2 on dc2.id_presupuesto=pi.id_presupuesto_dos               
																							 where id_presupuesto_uno=$m_id_presupuesto or id_presupuesto_dos=$m_id_presupuesto or dc.id_presupuesto=$m_id_presupuesto or dc2.id_presupuesto=$m_id_presupuesto
																							 LIMIT 1), FALSE) 
															and id_gestion in (select id_gestion from presto.tpr_parametro par
																			   	inner join presto.tpr_presupuesto pr on pr.id_parametro=par.id_parametro
																				where pr.id_presupuesto =$m_id_presupuesto )
														))   ";
			}	
				 
			if ($m_id_partida){
					$criterio_filtro=$criterio_filtro." AND  id_partida= (COALESCE((select id_partida from presto.tpr_partida where id_partida=$m_id_partida and sw_movimiento=1), id_partida))";
			}
		}
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PartidaCuenta');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarCuentaPartida($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	//echo  $Custom->query;
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_partida_cuenta',$f["id_partida_cuenta"]*1000000000+$f["id_cuenta"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('partida_cuenta',$f["partida_cuenta"]);
			$xml->add_nodo('sw_deha',$f["sw_deha"]);
			$xml->add_nodo('sw_rega',$f["sw_rega"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
			$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
			$xml->add_nodo('codigo_partida',$f["codigo_partida"]);
			$xml->add_nodo('nombre_partida',$f["nombre_partida"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('sw_movimiento',$f["sw_movimiento"]);
			
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