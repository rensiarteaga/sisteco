<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUnidadOrganizacionalArb.php
Prop?sito:				Permite realizar el listado en tkp_unidad_organizacional
Tabla:					tkp_unidad_organizacional, tkp_estructura_organizacional
Par?metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci?n:		2007-11-07 15:46:18
Versi?n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarCorrespondenciaArb.php';

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

	if($sort == '') $sortcol = 'nombre_unidad';
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


	
	

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	

	if(isset($tipo) and $tipo != 'null' ){
		
		if ($node=='id'){	
		  $criterio_filtro.=" and CORRE.tipo = ''$tipo''";
		}
		else{
		  $criterio_filtro.=" and 0=0";
		}
	}
	
	//echo $criterio_filtro;
	//exit;
	

	//$criterio_filtro = 
	
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CorrespondenciaArb');
	$sortcol = $crit_sort->get_criterio_sort();

	$nodos['totalCount']=0;
	$nodos['totalCount']=0;
	if($node=='id' && $filtrar=='true')
	{
		$count=0;
		$pri=1;
		$json='';
		$count_temporal=0;
		
		if($filtrar=='true'){
			$cond = new cls_criterio_filtro($decodificar);
			
				if($valor_filtro != ''){
					$cond->add_condicion_filtro($filterCol,$valor_filtro,'false');
				}
				
				if($valor_filtro1 != ''){
				$cond->add_condicion_filtro($filterCol1,$valor_filtro1,'false');
				}
			
			
			$criterio_filtro = $cond -> obtener_criterio_filtro().$criterio_filtro;
	
        }

            //echo $criterio_filtro ;exit;

		//$criterio_filtro = " (LOWER(CORRE.numero) LIKE LOWER(''%$valor_filtro%'')  OR  LOWER(CORRE.referencia) LIKE LOWER(''%$valor_filtro%'')) ";

		//$criterio_filtro = " (METAPR.nombre LIKE ''%Comp%''   )";

		$res = $Custom->FiltrarCorrespondeciaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,'1',$fecha_ini,$fecha_fin);
		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				//var_dump($f);
				if($pri==1){

					//guardo el nivel
					$niveles[$count]=$f["niveles"];
					//suponemos que el nivel inicial no tiene hijos
					$hijos[$count]=0;
					$pri=0;
					//prepara nodo
					$json= '[{';
					$json=$json.asignar($json,$f);
				}
				else{
					//este nodo es hijo del anterior nodo??
					//$posicion = strpos($f["niveles"],$niveles[$count].'_');
					$posicion = strpos($f["niveles"],$niveles[$count]);
					//var_dump($posicion);
					//var_dump($f["niveles"]);
					if($posicion !== false ){

						//echo "ENTRA";
						//var_dump($posicion);

						//pregunta mos si este el primer hijo del nivel padre
						if($hijos[$count]==0){


							//si es el primero iniciamos las llaves
							$json =$json.',children:[{' ;
						}
						else {
							//si no es el primero cerramos el hijo anterior y preparamos sllavez para el siguiente
							$json =$json.'},{' ;
						}
						//llenamos el nodo
						$json=$json.asignar($json,$f);


						//si el primer hijo incrementamos el nivel
						if($hijos[$count]==0){
							//se incrementa el nivel
							$count++;
							//suponemos que este nuevo nivel no tiene hijos
							$hijos[$count]=0;
						}
						//se incrementa un hijo en el anterior nivel
						$hijos[$count-1]++;
						//almacena el identificador del actual nivel
						$niveles[$count]=$f["niveles"];
					}
					else{
						//si el nodo no es hijo del anterio nivel
						//buscamos mas arriba hasta encontrar un padre o la raiz
						//en el camino vamos cerrando llavez
						$sw_tmp=0; // sw temporal
						$count_temporal =0;
						while ($sw_tmp==0){

							$hijos[$count]=0;
							$count--;

							$count_temporal++;
							if($count_temporal==1){

								//$json =$json.' * ('.$count.')';

							}
							else{
								$json =$json.'}]';
							}

							//$posicion = strpos($f["niveles"],$niveles[$count].'_');
							$posicion = strpos($f["niveles"],$niveles[$count]);
							if ($posicion !== false){

								$sw_tmp =1;
							}
							else {

								//si revisamos el ultimo nivel
								if($count<=-1){
									$sw_tmp =1;
								}
							}
						}
						$json = $json.'},{';
						$json =$json.asignar($json,$f);

						//se incrementa un hijo en el anterior nivel
						$hijos[$count]++;
						//almacena el identificador del actual nivel
						$count ++;
						$niveles[$count]=$f["niveles"];

					}
				}
			}

			while ($count>0){

				$count--;
				$json =$json.'}]';


			}
			if($pri==0){
				$json =$json.'}]';
			}
			else{
				$json =$json.'[]';

			}
			header("Content-Type:text/json; charset=".$_SESSION["CODIFICACION_HEADER"]);
            echo $json;
			exit;

		}
		else{


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
	else{


		if($node=='id'){

			//Obtiene el conjunto de datos de la consulta

			$res = $Custom->ListarCorrespondenciaRaiz($cant,$puntero,'CORRE.id_correspondencia  desc','desc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$fecha_ini,$fecha_fin);

			if($res)
			{
				foreach ($Custom->salida as $f)
				{
					
					$text = ''; 
					$remitente = ''; 
					
					
					
					if($tipo =='interna'){
						
						$remitente = utf8_encode($f["desc_empleado"])." \n ".$f["desc_uo"];
						$text=utf8_encode($f["desc_empleado"]);
						
					}
					
					if($tipo =='externa'){
						
						$remitente = utf8_encode($f["desc_persona"])." \n ".$f["desc_institucion"];
						$text=$f["desc_institucion"]." ".$f["desc_persona"];
						/*if($f["desc_persona"] != ''){
						  $text=utf8_encode($f["desc_persona"]);	
						}
						else{
						 $text=utf8_encode($f["desc_institucion"]);
						}*/
						
					}
					
					if($tipo =='emitida'){
						
						$remitente = utf8_encode($f["desc_empleado"])." \n ".$f["desc_uo"];
						$text=utf8_encode($f["desc_empleado"]);
						
					}
					
				//	if($f["empleado_remitente"] != "" and $f["empleado_remitente"] != null){
					
					//	$remitente = utf8_encode($f["desc_persona"])."  ".utf8_encode($f["desc_persona"]);
						
						
					//}
					//else{
						
					//	$remitente = utf8_encode($f["desc_institucion"])."  :".utf8_encode($f["desc_persona"]);
					//}
					
						
						
						
						
						
					$tmp['remitente'] = $remitente;
					$tmp['destinatario'] = '... ';
					
					$tmp['text'] = utf8_encode("<b>".$f["numero"].":</b>  ".$text."");
					$tmp['id'] = utf8_encode($f["id_correspondencia"]);
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowDrag']	=false;
					$tmp['allowDrop']	=false;
					$tmp['allowEdit']	=false;
					$tmp['tipo']	= "raiz";
					$tmp['icon'] = "../../../lib/imagenes/corre.png";
					
					$tmp['qtipTitle']  = "<p>Num: ".$f["numero"]."</p>";
					$tmp['qtip']="Ref: ".utf8_encode($f["referencia"])." <br>Documento: ".$f["desc_documento"];
					
					
					
					
					$tmp['id_depto'] = utf8_encode($f["id_depto"]);
					$tmp['desc_depto'] = utf8_encode($f["desc_depto"]);
					$tmp['numero'] = utf8_encode($f["numero"]);
					$tmp['id_documento'] = utf8_encode($f["id_documento"]);
					$tmp['desc_documento'] = utf8_encode($f["desc_documento"]);
					$tmp['id_empleado'] = utf8_encode($f["id_empleado"]);
					
					$tmp['desc_empleado'] = utf8_encode($f["desc_empleado"]);
					$tmp['id_uo'] = utf8_encode($f["id_uo"]);
					$tmp['desc_uo'] = utf8_encode($f["desc_uo"]);
					$tmp['id_institucion'] = utf8_encode($f["id_institucion"]);
					$tmp['desc_institucion'] = utf8_encode($f["desc_institucion"]);
					$tmp['id_persona'] = utf8_encode($f["id_persona"]);
					$tmp['desc_persona'] = utf8_encode($f["desc_persona"]);
					$tmp['referencia'] = utf8_encode($f["referencia"]);
					
					
					$tmp['fecha_origen'] = utf8_encode($f["fecha_origen"]);
					$tmp['hora_origen'] = utf8_encode($f["hora_origen"]);
					$tmp['fecha_destino'] = utf8_encode($f["fecha_destino"]);
					$tmp['hora_destino'] = utf8_encode($f["hora_destino"]);
					$tmp['desc_usuario'] = utf8_encode($f["desc_usuario"]);
					$tmp['acciones'] = utf8_encode($f["acciones"]);
					$tmp['tipo'] = utf8_encode($f["tipo"]);
					
					
					
					$tmp['url_archivo'] = utf8_encode($f["url_archivo"]);
					$tmp['empleado_remitente'] = utf8_encode($f["empleado_remitente"]);
					$tmp['id_correspondencia'] = utf8_encode($f["id_correspondencia"]);
					$tmp['id_correspondencia_fk'] = utf8_encode($f["id_correspondencia_fk"]);
					$tmp['estado'] = utf8_encode($f["estado"]);
					
					$tmp['padre'] = utf8_encode($f["padre"]);					
					$tmp['mensaje'] = utf8_encode($f["mensaje"]);
					$tmp['fecha_derivado'] = utf8_encode($f["fecha_derivado"]);
					$tmp['fecha_reg'] = utf8_encode($f["fecha_reg"]);
					$tmp['derivado'] = utf8_encode($f["derivado"]);
					$tmp['uo_remitente'] = utf8_encode($f["uo_remitente"]);
					
					$tmp['desc_nivel_seguridad'] = utf8_encode($f["desc_nivel_seguridad"]);
					$tmp['cite'] = utf8_encode($f["cite"]);
					$tmp['nivel_prioridad'] = utf8_encode($f["nivel_prioridad"]);
					$tmp['fecha_max_res'] = utf8_encode($f["fecha_max_res"]);
					
					
					$tmp['id_correspondencia_asociada'] = utf8_encode($f["id_correspondencia_asociada"]);
					$tmp['asociadas'] = utf8_encode($f["asociadas"]);
				
					
					
					
					
	
					$nodes[] = $tmp;
	
					
					
				}
				
			header("Content-Type:text/json; charset=".$_SESSION["CODIFICACION_HEADER"]);
          

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
			$res = $Custom->ListarCorrespondenciaArb($cant,$puntero,'CORRE.id_correspondencia  desc','desc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node,$id_gestion,$fecha_ini,$fecha_fin);

			if($res)
			{
				foreach ($Custom->salida as $f)
				{
					
					
					$remitente = ''; 
					$text='';
					
					if($f["desc_empleado"] != "" and $f["desc_empleado"] != null){
					
						$text = utf8_encode($f["desc_empleado"]);
						
						
					}
					else{
						
						$text = utf8_encode($f["desc_institucion"])."  :".utf8_encode($f["desc_persona"]);
					}
					
					
				
					
					$tmp['text'] = utf8_encode("<b>".$f["numero"]."</b>  ".$text."");
					$tmp['id'] = utf8_encode($f["id_correspondencia"]);
					$tmp['id_p'] = utf8_encode($f["id_correspondencia_fk"]);
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowDrag']	=false;
					$tmp['allowDrop']	=false;
					$tmp['allowEdit']	=false;
					$tmp['tipo']	= "area";
					$tmp['icon'] = "../../../lib/imagenes/corre2.png";
					
					$tmp['qtipTitle']  = "<p>Num: ".$f["numero"]."</p>";
					$tmp['qtip']="Ref: ".utf8_encode($f["referencia"])." <br>Documento: ".$f["desc_documento"];
					
					
					
					$tmp['id_depto'] = utf8_encode($f["id_depto"]);
					$tmp['desc_depto'] = utf8_encode($f["desc_depto"]);
					$tmp['numero'] = utf8_encode($f["numero"]);
					$tmp['id_documento'] = utf8_encode($f["id_documento"]);
					$tmp['desc_documento'] = utf8_encode($f["desc_documento"]);
					$tmp['id_empleado'] = utf8_encode($f["id_empleado"]);
					
					$tmp['desc_empleado'] = utf8_encode($f["desc_empleado"]);
					$tmp['id_uo'] = utf8_encode($f["id_uo"]);
					$tmp['desc_uo'] = utf8_encode($f["desc_uo"]);
					$tmp['id_institucion'] = utf8_encode($f["id_institucion"]);
					$tmp['desc_institucion'] = utf8_encode($f["desc_institucion"]);
					$tmp['id_persona'] = utf8_encode($f["id_persona"]);
					$tmp['desc_persona'] = utf8_encode($f["desc_persona"]);
					$tmp['referencia'] = utf8_encode($f["referencia"]);
					
					
					$tmp['fecha_origen'] = utf8_encode($f["fecha_origen"]);
					$tmp['hora_origen'] = utf8_encode($f["hora_origen"]);
					$tmp['fecha_destino'] = utf8_encode($f["fecha_destino"]);
					$tmp['hora_destino'] = utf8_encode($f["hora_destino"]);
					$tmp['desc_usuario'] = utf8_encode($f["desc_usuario"]);
					$tmp['acciones'] = utf8_encode($f["acciones"]);
					$tmp['tipo'] = utf8_encode($f["tipo"]);
					$tmp['estado'] = utf8_encode($f["estado"]);
					
					$tmp['padre'] = utf8_encode($f["padre"]);					
					$tmp['mensaje'] = utf8_encode($f["mensaje"]);
					$tmp['fecha_derivado'] = utf8_encode($f["fecha_derivado"]);
					$tmp['dias_derivado'] = utf8_encode($f["dias_derivado"]);
					$tmp['derivado'] = utf8_encode($f["derivado"]);
					$tmp['url_archivo'] = utf8_encode($f["url_archivo"]);
					$tmp['empleado_remitente'] = utf8_encode($f["empleado_remitente"]);
					$tmp['id_correspondencia'] = utf8_encode($f["id_correspondencia"]);
					$tmp['id_correspondencia_fk'] = utf8_encode($f["id_correspondencia_fk"]);
					$tmp['padre'] = utf8_encode($f["padre"]);					
					$tmp['mensaje'] = utf8_encode($f["mensaje"]);
					$tmp['fecha_derivado'] = utf8_encode($f["fecha_derivado"]);
					$tmp['fecha_reg'] = utf8_encode($f["fecha_reg"]);
					$tmp['derivado'] = utf8_encode($f["derivado"]);
					$tmp['uo_remitente'] = utf8_encode($f["uo_remitente"]);
					
					$tmp['desc_nivel_seguridad'] = utf8_encode($f["desc_nivel_seguridad"]);
					$tmp['cite'] = utf8_encode($f["cite"]);
					$tmp['nivel_prioridad'] = utf8_encode($f["nivel_prioridad"]);
					$tmp['fecha_max_res'] = utf8_encode($f["fecha_max_res"]);
					
					
					$f["id_correspondencia_asociada"]=str_replace("{","",$f["id_correspondencia_asociada"]);
			        $f["id_correspondencia_asociada"]=str_replace("}","",$f["id_correspondencia_asociada"]);
					
			        $tmp['id_correspondencia_asociada'] = utf8_encode($f["id_correspondencia_asociada"]);
					$tmp['asociadas'] = utf8_encode($f["asociadas"]);
					$tmp['remitente']='';
					$tmp['destinatario']='';
					
					
					
					
					
						if($tmp['empleado_remitente']!=''){
			              $tmp['remitente'] = $tmp['empleado_remitente']." \n".$tmp['uo_remitente'];
						}
						else{ 
							if($tmp['desc_institucion']!=''){
			                    $tmp['remitente'] = $tmp['desc_institucion']." \n";
							}
		                   if ($tmp['desc_persona']!=''){
			                    $tmp['remitente'].=$tmp['desc_persona'];
		                    }
		                }
		                
		                
		             if($tmp['desc_empleado']!=''){
			              $tmp['destinatario']=$tmp['desc_empleado']." \n".$tmp['desc_uo'];
						}
						else{ 
							if($tmp['desc_institucion']!=''){
			                    $tmp['destinatario']=$tmp['desc_institucion']." \n";
							}
		                   if ($tmp['desc_persona']!=''){
			                    $tmp['destinatario'].=$tmp['desc_persona'];
		                    }
		                    
		                   
		                }  
		                
		                // $tmp['destinatario']+=' yyyyyyyyyyyy'; 
		                
		
		            // $tmp['destinatario'] = $tmp['desc_empleado']." \n".$tmp['desc_uo'];
					
					//$tmp['remitente']= $remitente;
					
				
					
					$nodes[] = $tmp;
				}

			header("Content-Type:text/json; charset=".$_SESSION["CODIFICACION_HEADER"]);
          
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


	
	$remitente = ''; 
	$destinatario = '';
					$text='';
					
					if($f["desc_empleado"] != "" and $f["desc_empleado"] != null){					
						$text = ($f["desc_empleado"]);		
					}
					else{
						$text = ($f["desc_institucion"])."  :".($f["desc_persona"]);
					}
					
					$text = $text.("<b>".$f["numero"]."</b>  ".$text."");

					
	if($f["resaltar"]=='si'){		
		$text = $text.'  <FONT SIZE="+1"><b>*</b></FONT>';
		$expanded='false';
	}else{
		if($f["resaltar"]=='sii'){		
		    $text = $text.'  <FONT SIZE="+1"><b>**</b></FONT>';
		}
		
	      $expanded='true';			
		
	}

	
	
	
				if($f['empleado_remitente']!=''){
			             $remitente = $f['empleado_remitente']." \\n".$f['uo_remitente'];
			              
			             // $remitente = $f['empleado_remitente']." ".$f['uo_remitente'];
						}
						else{ 
							if($f['desc_institucion']!=''){
			                   $remitente= $f['desc_institucion']." \\n";
			                   // $remitente= $f['desc_institucion']." n";
							}
		                   if ($f['desc_persona']!=''){
			                    $remitente.=$f['desc_persona'];
		                    }
		                }
		                
		                
		             if($f['desc_empleado']!=''){
			              $destinatario=$f['desc_empleado']." \\n".$f['desc_uo'];
			              //$destinatario=$f['desc_empleado']." n".$f['desc_uo'];
						}
						else{ 
							if($f['desc_institucion']!=''){
			                   $destinatario=$f['desc_institucion']." \\n";
			                    // $destinatario=$f['desc_institucion']." n";
							}
		                   if ($tmp['desc_persona']!=''){
			                    $destinatario.=$f['desc_persona'];
		                    }
		                    
		                   
		                }  
	
	

	
	$json = 'text:\''.$text.'\',id:\''.$f["id_correspondencia"].'\',id_p:\''.$f["id_correspondencia_fk"].'\',cls:\'folder\',leaf:false,
			 allowDelete:false,allowEdit:false,allowDrag:false,allowDrop:false,
			 expanded:'.$expanded.',
			 icon:\'../../../lib/imagenes/corre2.png\',
			 id_depto:\''.($f["id_depto"]).'\',desc_depto:\''.($f["desc_depto"]).'\',numero:\''.($f["numero"]).'\',id_documento:\''.($f["id_documento"]).'\',desc_documento:\''.$f["desc_documento"].'\',
			 id_empleado:\''.($f["id_empleado"]).'\',desc_empleado:\''.($f["desc_empleado"]).'\',id_uo:\''.($f["id_uo"]).'\',
			 desc_uo:\''.($f["desc_uo"]).'\',id_institucion:\''.($f["id_institucion"]).'\',desc_institucion:\''.($f["desc_institucion"]).'\',
			 id_persona:\''.($f["id_persona"]).'\',desc_persona:\''.($f["desc_persona"]).'\',referencia:\''.($f["referencia"]).'\',
			 fecha_origen:\''.($f["fecha_origen"]).'\',hora_origen:\''.($f["hora_origen"]).'\',fecha_destino:\''.($f["fecha_destino"]).'\',
			 hora_destino:\''.($f["hora_destino"]).'\',desc_usuario:\''.($f["desc_usuario"]).'\',acciones:\''.($f["acciones"]).'\',
			 tipo:\''.($f["tipo"]).'\',estado:\''.($f["estado"]).'\',padre:\''.($f["padre"]).'\',					
			 mensaje:\''.($f["mensaje"]).'\',fecha_derivado:\''.($f["fecha_derivado"]).'\',
			 dias_derivado:\''.($f["dias_derivado"]).'\', derivado:\''.($f["derivado"]).'\',
			 url_archivo:\''.($f["url_archivo"]).'\',empleado_remitente:\''.($f["empleado_remitente"]).'\',
			 id_correspondencia:\''.($f["id_correspondencia"]).'\',
			 id_correspondencia_fk:\''.($f["id_correspondencia_fk"]).'\',
			 padre:\''.($f["padre"]).'\',
			 mensaje:\''.($f["mensaje"]).'\',
			 fecha_derivado:\''.($f["fecha_derivado"]).'\',
			 fecha_reg:\''.($f["fecha_reg"]).'\',
			 derivado:\''.($f["derivado"]).'\',
			 uo_remitente:\''.($f["uo_remitente"]).'\',
			 remitente:\''.($remitente).'\',
			 destinatario:\''.($destinatario).'\',
			 
			 fecha_max_res:\''.($f["fecha_max_res"]).'\',
			 cite:\''.($f["cite"]).'\',
			 nivel_prioridad:\''.($f["nivel_prioridad"]).'\',
			 desc_nivel_seguridad:\''.($f["desc_nivel_seguridad"]).'\',
			 asociadas:\''.($f["asociadas"]).'\',';
	
		
	
	$json =$json.'qtip:\'Ref: '.($f["referencia"]).' <br>Documento: '.($f["desc_documento"]).'\',
				  qtipTitle:\'<p>Num: '.$f["numero"].'</p>\'';
	
	$json=str_replace(chr(13),'',$json);
	$json=str_replace(chr(9),'',$json);
	$json=str_replace(chr(10),'',$json);
	
	
/*
     v_sub_part1 = replace(trim(v_partes[v_i]),"char"(13),'');
       v_sub_part3 = replace(trim(v_sub_part1),"char"(9),'');
       v_correo = trim(replace(v_sub_part3,"char"(10),''));*/
   
	return $json;
}




?>

