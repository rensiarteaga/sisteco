<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarColumnaPartidaEjecucionArb.php
Prop?sito:				Permite realizar el listado en tkp_columna_partida_ejecucion
Tabla:					tkp_columna_partida_ejecucion
Par?metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci?n:		28/10/10
Versi?n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarColumnaPartidaEjecucionArb.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	//Par?metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'nombre';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har? o no la decodificaci?n(s?lo pregunta en caso del GET)
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
	//echo $criterio_filtro;
	//exit;

	//$criterio_filtro = '('.$criterio_filtro .') AND estado!=\'\'inactivo\'\'';

	if($id_planilla>0 ){ 
		if($node=='id'){
		    $criterio_filtro=$criterio_filtro ." AND vc.id_planilla=$id_planilla and plap.id_presupuesto=$id_ppto and cpe.id_planilla_presupuesto=$id_planilla_ppto";
		}else{
			$criterio_filtro=$criterio_filtro ." AND cpe.id_planilla_presupuesto=$id_planilla_ppto";
		}
	}
	else{
		$criterio_filtro=$criterio_filtro ." AND vc.id_planilla=0 and plap.id_presupuesto=0";
	} 
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ColumnaPartidaEjecucionArb');
	$sortcol = $crit_sort->get_criterio_sort();
	
	
		
				$nodos['totalCount']=0;
				if($node=='id'){
						$criterio_filtro = $criterio_filtro ." AND cpe.id_columna_partida_ejecucion_padre is null ";
						//Obtiene el conjunto de datos de la consulta
						
						$res = $Custom->ListarColumnaPartidaEjecucionArb($cant,$puntero,'id_columna_partida_ejecucion desc',$verificar,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

						if($res){
							foreach ($Custom->salida as $f)
							{
								$tmp['text'] = '<FONT SIZE="2"><b>'.utf8_encode($f["nombre"]).'</b></FONT>'."  -->   [ Bs.". utf8_encode($f["importe"])."] - [".utf8_encode($f["partida"])."]";
								$tmp['id'] = utf8_encode($f["id_columna_partida_ejecucion"]);
								$tmp['cls']	= 'folder';
								$tmp['leaf'] = false;
								$tmp['allowDelete']	= true;
								$tmp['allowDrag']	= true;
								$tmp['allowDrop']	= true;
								$tmp['allowEdit']	= true;
								$tmp['tipo']	= "empresa";
								$tmp['momento'] = utf8_encode($f["momento"]);
								
								if($tmp['momento']=='comprometido'){
								     $tmp['icon'] = "../../../lib/imagenes/ok.png";
								}
								$tmp['tiene_ppto'] = utf8_encode($f["tiene_ppto"]);
								if($verificar=='si'){
									if($momento=='no'){
										if($tmp['momento']=='estimado'){
										
											if($tmp['tiene_ppto']==0){
												$tmp['text']=$tmp['text'].'<FONT SIZE="2" COLOR="red"><b>*</b></FONT>';
											}else{
												$tmp['text']=$tmp['text'].'<FONT SIZE="2"><b>*</b></FONT>';
											}
										}
									}
								}
								//}
								$tmp['importe'] = utf8_encode($f["importe"]);
								$tmp['partida'] = utf8_encode($f["partida"]);
								$tmp['auxiliar'] = utf8_encode($f["auxiliar"]);
								$tmp['id_partida_ejecucion'] = utf8_encode($f["id_partida_ejecucion"]);
								$tmp['id_presupuesto'] = utf8_encode($f["id_presupuesto"]);
								$tmp['id_cuenta'] = utf8_encode($f["id_cuenta"]);
								$tmp['id_auxiliar'] = utf8_encode($f["id_auxiliar"]);
								
								$tmp['qtip'] = "Cuenta: ".utf8_encode($f['cuenta'])." <br \/>Auxiliar: ".$tmp['auxiliar'];
								$tmp['qtipTitle']="Momento: ".$tmp["momento"];
								$tmp['observaciones']=$tmp["observaciones"];
								$nodes[] = $tmp;
							}
			
							if(sizeof($nodes)>0){
								echo json_encode($nodes);
							}
							else {
								echo '{}';
							}
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
						//Obtiene el conjunto de datos de la consulta
					//$criterio_filtro=$criterio_filtro ." AND cpe.id_planilla_presupuesto=$id_planilla_ppto";
						$criterio_filtro = $criterio_filtro ." AND cpe.id_columna_partida_ejecucion_padre=$node ";
						$res = $Custom->ListarColumnaPartidaEjecucionArb($cant,$puntero,'id_unidad_organizacional desc','desc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
			
						if($res)
						{
							foreach ($Custom->salida as $f)
							{ 
			
								
								$tmp['text'] = utf8_encode($f["nombre"]);
								$tmp['id'] = utf8_encode($f["id_columna_partida_ejecucion"]);
								$tmp['id_p'] = utf8_encode($f["id_columna_partida_ejecucion_padre"]);
								$tmp['cls']	= 'folder';
								$tmp['leaf'] = false;
								$tmp['allowDelete']	= true;
								$tmp['allowEdit']	= true;
								$tmp['allowDrag']	= true;
								$tmp['allowDrop']	= true;
								$tmp['momento'] = utf8_encode($f["momento"]);
								$tmp['importe'] = utf8_encode($f["importe"]);
								$tmp['partida'] = utf8_encode($f["partida"]);
								$tmp['id_partida_ejecucion'] = utf8_encode($f["id_partida_ejecucion"]);
								$tmp['id_presupuesto'] = utf8_encode($f["id_presupuesto"]);
								$tmp['id_cuenta'] = utf8_encode($f["id_cuenta"]);
								$tmp['id_auxiliar'] = utf8_encode($f["id_auxiliar"]);
								$tmp['tiene_ppto'] = utf8_encode($f["tiene_ppto"]);
								$tmp['qtip'] = "Cuenta: ".utf8_encode($f['cuenta'])." <br \/>Auxiliar: ".$tmp["auxiliar"];
								$tmp['observaciones']=utf8_encode($f["observaciones"]);
								if($tmp['momento']=='estimado'){
									$tmp['text']=$tmp['text'].'  <FONT SIZE="+1"><b>*</b></FONT>';
								}
								else{
									$tmp['text']=$tmp['text'].' ('.$f["momento"].')';
									if($tmp['momento']=='pagado'){
										$tmp['text']=$tmp['observaciones'] .' ('.$f["momento"].')'.'--> Bs.'.$tmp['importe'];
									}
								}
								
								if($tmp['momento']=='comprometido'){
								     $tmp['icon'] = "../../../lib/imagenes/ok.png";
								}
								
								$nodes[] = $tmp;
							}
			
							if(sizeof($nodes)>0){
								echo json_encode($nodes);
							}
							else {
								echo '{}';
							}
			
			
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

}



function asignar ($json, $f){

	//$json='id:'.$f["id_unidad_organizacional"];

	
	if($f["resaltar"]=='si'){
		
		$text = $f["nombre_unidad"].'  <FONT SIZE="+1"><b>*</b></FONT>';
		//$expanded='false';
		$expanded='true';
	//$text = $f["nombre_unidad"];
		
	}
	else{
		
		$text = $f["nombre_unidad"];
		$expanded='true';
	}
	
	
	$json = 'text:\''.$text.'\',
			 id:\''.$f["id_unidad_organizacional"].'\',
			 id_p:\''.$f["id_padre"].'\',
			 cls:\'folder\',
             leaf:false,
			 allowDelete:true,
			 allowEdit:true,
			 allowDrag:true,
			 allowDrop:true,
			 expanded:'.$expanded.',
			 centro:\''.$f["centro"].'\',
			 nombre_unidad:\''.$f["nombre_unidad"].'\',
			 nombre_cargo:\''.$f["nombre_cargo"].'\',
			 cargo_individual:\''.$f["cargo_individual"].'\',
			 descripcion:\''.$f["descripcion"].'\',
			 relacion:\''.$f["relacion"].'\',
			 observaciones:\''.$f["observaciones"].'\',
			 estado_reg:\''.$f["estado_reg"].'\',
			 id_nivel_organizacional:'.$f["id_nivel_organizacional"].',
			 numero_nivel:'.$f["numero_nivel"].',
	         nombre_nivel:\''.$f["nombre_nivel"].'\',';
					if($f['numero_nivel']==1){
						
						$json =$json.'icon:\'../../../lib/imagenes/user_gg.png\',
						              tipo:\'general\',';
					}
					elseif ($f['numero_nivel']==2){
						
						$json =$json.'icon:\'../../../lib/imagenes/user_ga.png\',
						              tipo:\'area\',';
				
					}
					elseif ($f['numero_nivel']==3){
						
						$json =$json.'icon:\'../../../lib/imagenes/user_dep.png\',
						              tipo:\'departamento\',';
				
					}
					elseif ($f['numero_nivel']==4){
						
						$json =$json.'icon:\'../../../lib/imagenes/user_div.png\',
						              tipo:\'division\',';
					
					}
					elseif ($f['numero_nivel']==5){
							$json =$json.'icon:\'../../../lib/imagenes/user_unidad.png\',
						              tipo:\'unidad\',';
					
					}
					elseif ($f['numero_nivel']==6){
							$json =$json.'icon:\'../../../lib/imagenes/user_base.png\',
						              tipo:\'base\',';
						
					}
					else{
						$json =$json.'icon:\'../../../lib/imagenes/user_otro.png\',
						              tipo:\'otro\',';
					
					
					}
					
					if(!isset($f["importe_max_apro"])){
						
						$v_ima = 'undefined';
					}
					else{
						$v_ima = $f["importe_max_apro"];
						
					}
					
					
					if(!isset($f["importe_max_pre"])){
						
						$v_imp='undefined';
					}else{
						$v_imp=$f["importe_max_pre"];
						
					}
					
					
					
					$json =$json.'qtip:\'Funcionario: '.$f['funcionarios'].' <br \/>Cargo: '.$f["nombre_cargo"].'\',
					              qtipTitle:\'Nivel:'.$f["nombre_nivel"].'\',
					              importe_max_apro:'.$v_ima.',
					              importe_max_pre:'.$v_imp;
	



	return $json;
}


?>