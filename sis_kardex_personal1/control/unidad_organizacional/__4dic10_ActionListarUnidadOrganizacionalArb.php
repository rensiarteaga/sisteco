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
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarUnidadOrganizacionalArb.php';

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


	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'UnidadOrganizacionalArb');
	$sortcol = $crit_sort->get_criterio_sort();

	$nodos['totalCount']=0;
	$nodos['totalCount']=0;
	if($node=='id' && $filtrar=='true')
	{
		$count=0;
		$pri=1;

		$json='';

		$count_temporal =0;



		$criterio_filtro = " (LOWER(nombre_unidad) LIKE LOWER(''%$valor_filtro%'')  OR  LOWER(funcionarios) LIKE LOWER(''%$valor_filtro%'')) ";

		//$criterio_filtro = " (METAPR.nombre LIKE ''%Comp%''   )";

		$res = $Custom->FiltrarOrganigramaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,'1');
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

			echo utf8_encode($json);
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
			$res = $Custom->ListarUnidadOrganizacionalRaiz($cant,$puntero,'id_unidad_organizacional desc','desc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

			if($res)
			{
				foreach ($Custom->salida as $f)
				{
					$tmp['text'] = utf8_encode($f["nombre_unidad"]);
					$tmp['id'] = utf8_encode($f["id_unidad_organizacional"]);
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= true;
					$tmp['allowDrag']	= true;
					$tmp['allowDrop']	= true;
					$tmp['allowEdit']	= true;
					$tmp['tipo']	= "empresa";
					$tmp['icon'] = "../../../lib/imagenes/org.png";
					$tmp['centro'] = utf8_encode($f["centro"]);
					$tmp['nombre_unidad'] = utf8_encode($f["nombre_unidad"]);
					$tmp['nombre_cargo'] = utf8_encode($f["nombre_cargo"]);
					$tmp['cargo_individual'] = utf8_encode($f["cargo_individual"]);
					$tmp['descripcion'] = utf8_encode($f["descripcion"]);
					$tmp['id_nivel_organizacional'] = utf8_encode($f["id_nivel_organizacional"]);
					$tmp['numero_nivel'] = utf8_encode($f["numero_nivel"]);
					$tmp['nombre_nivel'] = utf8_encode($f["nombre_nivel"]);
					$tmp['estado_reg'] = utf8_encode($f["estado_reg"]);
					$tmp['qtip'] = "Funcionario: ".utf8_encode($f['funcionarios'])." <br \/>Cargo: ".$tmp["nombre_cargo"];
					$tmp['qtipTitle']="Nivel: ".$tmp["nombre_nivel"];

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
			$res = $Custom->ListarUnidadOrganizacionalArb($cant,$puntero,'id_unidad_organizacional desc','desc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);

			if($res)
			{
				foreach ($Custom->salida as $f)
				{

					$tmp['text'] = utf8_encode($f["nombre_unidad"]);
					$tmp['id'] = utf8_encode($f["id_unidad_organizacional"]);
					$tmp['id_p'] = utf8_encode($f["id_padre"]);
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= true;
					$tmp['allowEdit']	= true;
					$tmp['allowDrag']	= true;
					$tmp['allowDrop']	= true;
					$tmp['centro'] = utf8_encode($f["centro"]);
					$tmp['nombre_unidad'] = utf8_encode($f["nombre_unidad"]);
					$tmp['nombre_cargo'] = utf8_encode($f["nombre_cargo"]);
					$tmp['cargo_individual'] = utf8_encode($f["cargo_individual"]);
					$tmp['descripcion'] = utf8_encode($f["descripcion"]);
					$tmp['relacion'] = utf8_encode($f["relacion"]);
					$tmp['observaciones'] = utf8_encode($f["observaciones"]);
					$tmp['estado_reg'] = utf8_encode($f["estado_reg"]);
					$tmp['id_nivel_organizacional'] = utf8_encode($f["id_nivel_organizacional"]);
					$tmp['numero_nivel'] = utf8_encode($f["numero_nivel"]);
					$tmp['nombre_nivel'] = utf8_encode($f["nombre_nivel"]);
					if($tmp['numero_nivel']==1){
						$tmp['icon'] = "../../../lib/imagenes/user_gg.png";
						$tmp['tipo']	= "general";
					}
					elseif ($tmp['numero_nivel']==2){
						$tmp['icon'] = "../../../lib/imagenes/user_ga.png";
						$tmp['tipo']	= "area";
					}
					elseif ($tmp['numero_nivel']==3){
						$tmp['icon'] = "../../../lib/imagenes/user_dep.png";
						$tmp['tipo']	= "departamento";
					}
					elseif ($tmp['numero_nivel']==4){
						$tmp['icon'] = "../../../lib/imagenes/user_div.png";
						$tmp['tipo']	= "division";
					}
					elseif ($tmp['numero_nivel']==5){
						$tmp['icon'] = "../../../lib/imagenes/user_unidad.png";
						$tmp['tipo']	= "unidad";
					}
					elseif ($tmp['numero_nivel']==6){
						$tmp['icon'] = "../../../lib/imagenes/user_base.png";
						$tmp['tipo']	= "base";
					}
					else{
						$tmp['icon'] = "../../../lib/imagenes/user_otro.png";
						$tmp['tipo']	= "otro";
					}
					$tmp['qtip'] = "Funcionario: ".utf8_encode($f['funcionarios'])." <br \/>Cargo: ".utf8_encode($tmp["nombre_cargo"]);
					$tmp['qtipTitle']="Nivel: ".$tmp["nombre_nivel"];
					$tmp['importe_max_apro'] = utf8_encode($f["importe_max_apro"]);
					$tmp['importe_max_pre'] = utf8_encode($f["importe_max_pre"]);
					$tmp['sw_presto'] = utf8_encode($f["sw_presto"]);

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