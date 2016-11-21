<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarItem.php
Propósito:				Permite desplegar datos de los Items
Tabla:					tal_item
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		29-09-2007
Versión:				1.0.0
Autor:					Rensi arteaga Copari
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionListarItemArb.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	//sonsulta con filtro sincrona se construye el arbol
	if($node=='id' && $filtrar=='true'){
		



		$res = $Custom-> ListarItemFiltrado($filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		if($res)
		{


			//llaves
			$sw=false;
			$sw_spg=false;
			$sw_g=false;
			$sw_sbg=false;
			$sw_id1=false;
			$sw_id2=false;
			$sw_id3=false;
			$sw_item=false;
			$t_spg ='';
			$t_g ='';
			$t_sbg ='';
			$t_id1 ='';
			$t_id2 ='';
			$t_id3 ='';
			$t_item ='';
			$id_spg=0;
			$id_g=0;
			$id_sbg=0;
			$id_id1=0;
			$id_id2=0;
			$id_id3=0;
			
			
			$cont=0;
			
			foreach ($Custom->salida as $f){
				$cont++;
				//echo 'ENTRO AQUI  22222222222';
			//preguntamos si el super grupo es uno nuevo
				
			 //SUPER GRUPO   si lo es creamos u nuevo nodo
				if($id_spg!=$f["id_supergrupo"]){

					//detecto que existe un id_3 nuevo -> guardo el anterior
					//si no es la primera iteracion
					if($sw){
						
						
						
						$t_spg= $t_spg.',"children":['.$t_g.',"children":['.$t_sbg.',"children":['.$t_id1.',"children":['.$t_id2.',"children":['.$t_id3.',"children":['.$t_item.']}]}]}]}]}]}';
						$sw_item=false;				
						$sw_id3=false;
						$sw_id2=false;
						$sw_id1=false;
						$sw_sbg=false;
						$sw_g=false;
						
						
						//$_spg["children"]=$t_spg;
						

					}
					/*
					$_spg['text'] = utf8_encode($f["nombre_supg"]);
					$_spg['id'] = $f["id_supergrupo"];
					$_spg['cls']	= 'folder';
					$_spg['leaf'] = false;
					$_spg['allowDelete']	= false;
					$_spg['allowEdit']	= false;
					$_spg['allowDrag']	= false;
					$_spg['tipo']='supgrupo';*/
					
					$tx_spg='"text":"'.$f["nombre_supg"].'",
							 "id":'.$f["id_supergrupo"].',
							 "cld":"folder",
							 "leaf":false,
							 "allowDelete":false,
							 "allowEdit":false,
							 "allowDrag":false,
							 "tipo":"supgrupo"';
							 
					
					
					if(!$sw_spg){
						//$t_spg='[{'.json_encode($_spg);
						$t_spg='{'.utf8_encode($tx_spg);
						$sw_spg=true;
					}
					else{
						//$t_spg=$t_spg.'},{'.json_encode($_spg);
						$t_spg=$t_spg.'},{'.utf8_encode($tx_spg);
					}
					
					
				}
				
					//GRUPO
				if($id_g!=$f["id_grupo"]){

					//detecto que existe un id_3 nuevo -> guardo el anterior
					//si no es la primera iteracion
					if($sw){
						//$_spg['children'][]=$_g;
						
						$t_g= $t_g.',"children":['.$t_sbg.',"children":['.$t_id1.',"children":['.$t_id2.',"children":['.$t_id3.',"children":['.$t_item.']}]}]}]}]';
						$sw_item=false;
						$sw_id3=false;
						$sw_id2=false;
						$sw_id1=false;
						$sw_sbg=false;

					}
/*
					$_g['text'] = utf8_encode($f["nombre_grupo"]);
					$_g['id'] = $f["id_grupo"];
					$_g['cls']	= 'folder';
					$_g['leaf'] = false;
					$_g['allowDelete']	= false;
					$_g['allowEdit']	= false;
					$_g['allowDrag']	= false;
					$_g['tipo']='grupo';*/
					
					$tx_g='"text":"'.$f["nombre_grupo"].'",
							 "id":'.$f["id_grupo"].',
							 "cld":"folder",
							 "leaf":false,
							 "allowDelete":false,
							 "allowEdit":false,
							 "allowDrag":false,
							 "tipo":"grupo"';
					
					
					
					if(!$sw_g){
						$t_g='{'.utf8_encode($tx_g);
						$sw_g=true;
					}
					else{
						$t_g=$t_g.'},{'.utf8_encode($tx_g);
					}
					
				}
				
			 
				//SubGRUPO
				if($id_sbg!=$f["id_subgrupo"]){
					//detecto que existe un id_3 nuevo -> guardo el anterior
					//si no es la primera iteracion
					if($sw){
						//$_g['children'][]=$_sbg;
					
						$t_sbg= $t_sbg.',"children":['.$t_id1.',"children":['.$t_id2.',"children":['.$t_id3.',"children":['.$t_item.']}]}]}]';
						$sw_item=false;
						$sw_id3=false;
						$sw_id2=false;
						$sw_id1=false;

					}/*

					$_sbg['text'] = utf8_encode($f["nombre_subg"]);
					$_sbg['id'] = $f["id_subgrupo"];
					$_sbg['cls']	= 'folder';
					$_sbg['leaf'] = false;
					$_sbg['allowDelete']	= false;
					$_sbg['allowEdit']	= false;
					$_sbg['allowDrag']	= false;
					$_sbg['tipo']='subgrupo';*/
					
					$tx_sbg='"text":"'.$f["nombre_subg"].'",
							 "id":'.$f["id_subgrupo"].',
							 "cld":"folder",
							 "leaf":false,
							 "allowDelete":false,
							 "allowEdit":false,
							 "allowDrag":false,
							 "tipo":"subgrupo"';
					
					
					if(!$sw_sbg){
						$t_sbg='{'.utf8_encode($tx_sbg);
						$sw_sbg=true;
					}
					else{
						$t_sbg=$t_sbg.'},{'.utf8_encode($tx_sbg);
					}
					
					
				}
			
			
			
				
				
				
				//ID1
				if($id_id1!=$f["id_id1"]){
					//detecto que existe un id_3 nuevo -> guardo el anterior
					//si no es la primera iteracion
					if($sw){
						
						//$_sbg['children'][]=$_id1;
						$t_id1= $t_id1.',"children":['.$t_id2.',"children":['.$t_id3.',"children":['.$t_item.']}]}]';
						$sw_item=false;
						$sw_id3=false;
						$sw_id2=false;

					}

					/*
					$_id1['text'] = utf8_encode($f["nombre_id1"]);
					$_id1['id'] = $f["id_id1"];
					$_id1['cls']	= 'folder';
					$_id1['leaf'] = false;
					$_id1['allowDelete']	= false;
					$_id1['allowEdit']	= false;
					$_id1['allowDrag']	= false;
					$_id1['tipo']='id1';
					*/
					
					$tx_id1='"text":"'.$f["nombre_id1"].'",
							 "id":'.$f["id_id1"].',
							 "cld":"folder",
							 "leaf":false,
							 "allowDelete":false,
							 "allowEdit":false,
							 "allowDrag":false,
							 "tipo":"id1"';

					if(!$sw_id1){
						$t_id1='{'.utf8_encode($tx_id1);
						$sw_id1=true;
						
						
					}
					else{
						$t_id1=$t_id1.'},{'.utf8_encode($tx_id1);
					}
				}
				
				
				


			//ID2
				if($id_id2!=$f["id_id2"] ){

					//detecto que existe un id_3 nuevo -> guardo el anterior
					//si no es la primera iteracion
					if($sw){
						//$_id1['children'][]=$_id2;

						//echo "<br>  ID 2            ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ  ".$f["id_id2"];
						
						$t_id2= $t_id2.',"children":['.$t_id3.',"children":['.$t_item.']}]';
						$sw_item=false;
						$sw_id3=false;


					}
					/*
					$_id2['text'] = utf8_encode($f["nombre_id2"]);
					$_id2['id'] = $f["id_id2"];
					$_id2['cls']	= 'folder';
					$_id2['leaf'] = false;
					$_id2['allowDelete']	= false;
					$_id2['allowEdit']	= false;
					$_id2['allowDrag']	= false;
					$_id2['tipo']='id2';
					*/
					
					$tx_id2='"text":"'.$f["nombre_id2"].'",
							 "id":'.$f["id_id2"].',
							 "cld":"folder",
							 "leaf":false,
							 "allowDelete":false,
							 "allowEdit":false,
							 "allowDrag":false,
							 "tipo":"id2"';
					

					if(!$sw_id2){
						$t_id2='{'.utf8_encode($tx_id2);
						$sw_id2=true;
					}
					else{
						$t_id2=$t_id2.'},{'.utf8_encode($tx_id2);
					}





				}
				
							//ID3
				if  ($id_id3!=$f["id_id3"] ){
						if($sw){
						$t_id3= $t_id3.',"children":['.$t_item.']';
						$sw_item=false;
					}

					/*
					$_id3['text'] = utf8_encode($f["nombre_id3"]);
					$_id3['id'] = $f["id_id3"];
					$_id3['cls']	= 'folder';
					$_id3['leaf'] = false;
					$_id3['allowDelete']	= false;
					$_id3['allowEdit']	= false;
					$_id3['allowDrag']	= false;
					$_id3['tipo']='id3';
					*/
					
					$tx_id3='"text":"'.$f["nombre_id3"].'",
							 "id":'.$f["id_id3"].',
							 "cld":"folder",
							 "leaf":false,
							 "allowDelete":false,
							 "allowEdit":false,
							 "allowDrag":false,
							 "tipo":"id3"';

					if(!$sw_id3){
						$t_id3='{'.utf8_encode($tx_id3);
						$sw_id3=true;
					}
					else{
						$t_id3=$t_id3.'},{'.utf8_encode($tx_id3);
					}




				}
				
		
 //item

				$_item['text'] = utf8_encode($f["nombre"]);
				$_item['id'] = $f["id_item"];
				$_item['cls']	= 'folder';
				$_item['icon'] = "../../../lib/imagenes/item.png";
				$_item['leaf'] = true;
				$_item['allowDelete']	= false;
				$_item['allowEdit']	= false;
				$_item['allowDrag']	= true;
				$_item['tipo']='item';
				//$tmp['id_p'] = $f["id_tipo_unidad_constructiva"];
				$_item['codigo'] = utf8_encode($f["codigo"]);
				$_item['nombre'] = utf8_encode($f["nombre"]);
				$_item['descripcion'] = utf8_encode($f["descripcion"]);
				$_item['observaciones'] = '';
				$_item['cantidad'] = '1';
				$_item['opcional'] = 'false';
				$_item['qtip'] = utf8_encode("Nombre: ".$_item['nombre']." <br\/>Descripcion: ".$_item["descripcion"]);
				$_item['qtipTitle']=utf8_encode("Codigo: ".$f["codigo"]);
				//guardo el item dentro del id_3


				//$_id3['children'][]=$_item;
				//$_item= new ArrayObject();
				
			

				if(!$sw_item){
					$t_item=json_encode($_item);
					$sw_item=true;					
				}
				else{
					$t_item= $t_item.','.json_encode($_item);			
					
				}
			
		      
				
				
				//echo "<BR>  XXXXXXXXXXXXXXX     $cont      XXXXXXXXXXXXXXXXX<br>";








				//$nodes[] = $tmp;





				//reiniciamos varialbles para que tengan el valor de los anteriores registros

				$id_spg=$f["id_supergrupo"];
				$id_g=$f["id_grupo"];
				$id_sbg=$f["id_subgrupo"];
				$id_id1=$f["id_id1"];
				$id_id2=$f["id_id2"];
				$id_id3=$f["id_id3"];
				$sw=true;


			}
			//guardamos los ultimos nodos
			
			if($sw_item){
			/*$t_id3= $t_id3.',"children":['.$t_item.']}';			
			$t_id2= $t_id2.',"children":['.$t_id3.']}';
			$t_id1= $t_id1.',"children":['.$t_id2.']}';
			$t_sbg= $t_sbg.',"children":['.$t_id1.']}';
			$t_g= $t_g.',"children":['.$t_sbg.']}';
			$t_spg= $t_spg .',"children":['.$t_g.']}';*/
			
			$t_spg= $t_spg.',"children":[
											'.$t_g.',"children":[
																	'.$t_sbg.',"children":[
																							'.$t_id1.',"children":[
																													'.$t_id2.',"children":[
																																			'.$t_id3.',"children":['.$t_item.']}
																																		]}
																													]}
																							]}
																]}
										]}';
						
			}
			
			echo "[$t_spg]";
			exit;
			
			

			/*$_id2['children'][]=$_id3;
			$_id1['children'][]=$_id2;
			$_sbg['children'][]=$_id1;
			$_g['children'][]=$_sbg;
			$_spg['children'][]=$_g;
			$nodes[]=$_spg;
*/
/*

			if(sizeof($nodes)>0){
				echo json_encode($nodes);

			}
			else {
				echo '{}';

			}*/


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

		//Consulta clacisa Asyncrona sin filtrado ...
		if($node=='id'){
			//Obtiene el conjunto de datos de la consulta$
			//arma el filtro

			if($filtrar=='true'){
				$param_filtro="lower(supgru.codigo) LIKE lower(\'%$filtro%\') OR lower(supgru.nombre) LIKE lower(\'%$filtro%\') OR lower(supgru.descripcion) LIKE lower(\'%$filtro%\')  OR lower(supgru.observaciones) LIKE lower(\'%$filtro%\')" ;

			}else{
				$param_filtro='0=0';

			}

			$res = $Custom->ListarSuperGrupo("NULL",0,'nombre','asc',$param_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			if($res)
			{
				foreach ($Custom->salida as $f)
				{


					$tmp['text'] = utf8_encode($f["nombre"]);
					$tmp['id'] = $f["id_supergrupo"];
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowEdit']	= false;
					$tmp['allowDrag']	= false;
					$tmp['tipo']='supgrupo';
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

		}elseif($tipo=='supgrupo')
		{

			$cond = new cls_criterio_filtro($decodificar);
			$cond->add_criterio_extra("g.id_supergrupo","''$node''");
			if($filtrar=='true'){

				$cond->add_condicion_filtro("g.codigo#g.nombre#g.descripcion#g.observaciones","'$filtro'",false);


			}



			$res = $Custom->ListarGrupo("NULL",0,'nombre','asc',$cond->obtener_criterio_filtro(),$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			if($res)
			{
				foreach ($Custom->salida as $f)
				{


					$tmp['text'] = utf8_encode($f["nombre"]);
					$tmp['id'] = $f["id_grupo"];
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowEdit']	= false;
					$tmp['allowDrag']	= false;
					$tmp['tipo']='grupo';
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
		elseif($tipo=='grupo')
		{

			$cond = new cls_criterio_filtro($decodificar);
			$cond->add_criterio_extra("sub.id_grupo","''$node''");
			if($filtrar=='true'){


				$cond->add_criterio_extra("sub.codigo","''$filtro''");
				$cond->add_criterio_extra("sub.nombre","''$filtro''");
				$cond->add_criterio_extra("sub.descripcion","''$filtro''");
				$cond->add_criterio_extra("sub.observaciones","''$filtro''");


			}
			$res = $Custom->ListarSubGrupo("NULL",0,'nombre','asc',$cond->obtener_criterio_filtro(),$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			if($res)
			{
				foreach ($Custom->salida as $f)
				{


					$tmp['text'] = utf8_encode($f["nombre"]);
					$tmp['id'] = $f["id_subgrupo"];
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowEdit']	= false;
					$tmp['allowDrag']	= false;
					$tmp['tipo']='subgrupo';
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
		elseif($tipo=='subgrupo')
		{

			$cond = new cls_criterio_filtro($decodificar);
			$cond->add_criterio_extra("id1.id_subgrupo","''$node''");
			if($filtrar=='true'){


				$cond->add_criterio_extra("id1.codigo","''$filtro''");
				$cond->add_criterio_extra("id1.nombre","''$filtro''");
				$cond->add_criterio_extra("id1.descripcion","''$filtro''");
				$cond->add_criterio_extra("id1.observaciones","''$filtro''");


			}
			$res = $Custom->ListarId1("NULL",0,'nombre','asc',$cond->obtener_criterio_filtro(),$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			if($res)
			{
				foreach ($Custom->salida as $f)
				{


					$tmp['text'] = utf8_encode($f["nombre"]);
					$tmp['id'] = $f["id_id1"];
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowEdit']	= false;
					$tmp['allowDrag']	= false;
					$tmp['tipo']='id1';
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
		elseif($tipo=='id1')
		{

			$cond = new cls_criterio_filtro($decodificar);
			$cond->add_criterio_extra("id2.id_id1","''$node''");
			if($filtrar=='true'){


				$cond->add_criterio_extra("id2.codigo","''$filtro''");
				$cond->add_criterio_extra("id2.nombre","''$filtro''");
				$cond->add_criterio_extra("id2.descripcion","''$filtro''");
				$cond->add_criterio_extra("id2.observaciones","''$filtro''");


			}
			$res = $Custom->ListarId2("NULL",0,'nombre','asc',$cond->obtener_criterio_filtro(),$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			if($res)
			{
				foreach ($Custom->salida as $f)
				{


					$tmp['text'] = utf8_encode($f["nombre"]);
					$tmp['id'] = $f["id_id2"];
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowEdit']	= false;
					$tmp['allowDrag']	= false;
					$tmp['tipo']='id2';
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
		elseif($tipo=='id2')
		{

			$cond = new cls_criterio_filtro($decodificar);
			$cond->add_criterio_extra("id3.id_id2","''$node''");
			if($filtrar=='true'){


				$cond->add_criterio_extra("id3.codigo","''$filtro''");
				$cond->add_criterio_extra("id3.nombre","''$filtro''");
				$cond->add_criterio_extra("id3.descripcion","''$filtro''");
				$cond->add_criterio_extra("id3.observaciones","''$filtro''");


			}
			$res = $Custom->ListarId3("NULL",0,'nombre','asc',$cond->obtener_criterio_filtro(),$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			if($res)
			{
				foreach ($Custom->salida as $f)
				{


					$tmp['text'] = utf8_encode($f["nombre"]);
					$tmp['id'] = $f["id_id3"];
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowEdit']	= false;
					$tmp['allowDrag']	= false;
					$tmp['tipo']='id3';
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
		elseif($tipo=='id3')
		{

			$cond = new cls_criterio_filtro($decodificar);
			$cond->add_criterio_extra("ite.id_id3","''$node''");
			if($filtrar=='true'){


				$cond->add_criterio_extra("ite.codigo","''$filtro''");
				$cond->add_criterio_extra("ite.nombre","''$filtro''");
				$cond->add_criterio_extra("ite.descripcion","''$filtro''");
				$cond->add_criterio_extra("ite.observaciones","''$filtro''");


			}
			$res = $Custom->ListarItem("NULL",0,'nombre','asc',$cond->obtener_criterio_filtro(),$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			if($res)
			{
				foreach ($Custom->salida as $f)
				{


					$tmp['text'] = utf8_encode($f["nombre"]);
					$tmp['id'] = $f["id_item"];
					$tmp['cls']	= 'folder';
					$tmp['icon'] = "../../../lib/imagenes/item.png";
					$tmp['leaf'] = true;
					$tmp['allowDelete']	= false;
					$tmp['allowEdit']	= false;
					$tmp['allowDrag']	= true;
					$tmp['tipo']='item';
					//$tmp['id_p'] = $f["id_tipo_unidad_constructiva"];
					$tmp['codigo'] = utf8_encode($f["codigo"]);
					$tmp['nombre'] = utf8_encode($f["nombre"]);
					$tmp['descripcion'] = utf8_encode($f["descripcion"]);
					$tmp['observaciones'] = '';
					$tmp['cantidad'] = '1';
					$tmp['opcional'] = 'false';
					$tmp['qtip'] = utf8_encode("Nombre: ".$tmp['nombre']." <br \/>Descripcion: ".$f["descripcion"]);
					$tmp['qtipTitle']=utf8_encode("Codigo: ".$f["codigo"]);
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

function BusquedaRecursiva($id,$tipo){
	$sw=false;


	$res = $Custom->ListarSuperGrupo("NULL",0,'id_supergrupo','asc',$param_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);






}

?>