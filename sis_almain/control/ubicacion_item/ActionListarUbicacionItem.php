<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUbicacionArb.php
Prop?sito:				Lista el arbol de las entidades financieras y sucursales para la asignacion de Funcionarios.
Tabla:					tcb_ubicacion, tcb_almacen

Fecha de Creaci?n:		
Versi?n:				1.0.0
Autor:					 
**********************************************************
*/
session_start();
include_once ('../LibModeloAlma.php');
$nombre_archivo = 'ActionListarUbicacionArb.php';

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = 'NO';
}
if ($_SESSION['autentificado'] == 'SI') {
	
	// Par?metros del filtro
	if ($limit == '')
		$cant = 15;
	else
		$cant = $limit;
	
	if ($start == '')
		$puntero = 0;
	else
		$puntero = $start;
	
	if ($sort == '')
		$sortcol = 'ub.codigo';
	else
		$sortcol = $sort;
	
	if ($dir == '')
		$sortdir = 'asc';
	else
		$sortdir = $dir;
		
		// Verifica si se har? o no la decodificaci?n(s?lo pregunta en caso del GET)
		// valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod) {
		case 'si' :
			$decodificar = true;
			break;
		case 'no' :
			$decodificar = false;
			break;
		default :
			$decodificar = true;
			break;
	}
	
	// Verifica si se manda la cantidad de filtros
	if ($CantFiltros == '')
		$CantFiltros = 0;
		
		// Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i = 0; $i < $CantFiltros; $i ++) {
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	

	$Custom = new cls_CustomDBAlma();
	
	if(isset($id_almacen) && isset($id_item))
	{
		if($node =='id')//listar las raices del arbol
		{
			$criterio_filtro = "0=0";
			$id_alma=$id_almacen;
			$nodo = $node;
	
			$res = $Custom->ListarUbicacionItemRaices($cant, $puntero, $sortcol, $sortdir, $criterio_filtro,$hidden_id_financiadora,$hidden_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad,$id_alma,$nodo,$id_item);
		
			if ($res) 
			{
				foreach ( $Custom->salida as $f ) 
				{
					
					$tmp['id'] = utf8_encode($f["id_ubicacion"]);
					$tmp['cls'] = 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete'] = true;
					$tmp['allowDrag'] = false;
					$tmp['allowDrop'] = false;
					$tmp['allowEdit'] = true;
					
					$tmp['tipo'] = "raiz";
						
					$tmp['icon'] = "../../../lib/images/almacenes/ubicacion_raiz.png";
					$tmp['qtip'] = $tipo_nodo;
					$tmp['qtipTitle'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"]);
					
					if ($f["checked"]=="f")
					{
						$tmp['checked']=false;
						$tmp['text'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"]);
					}
					else 
					{
						$tmp['text'] = "<span style=color:blue>".utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"])."</span>";  
						$tmp['checked']=true;
					}
					$tmp['id_ubicacion'] = utf8_encode($f["id_ubicacion"]);
					$tmp['id_ubicacion_fk'] = utf8_encode($f["id_ubicacion_fk"]);
					$tmp['id_almacen'] = utf8_encode($f["id_almacen"]);
					$tmp['codigo'] = utf8_encode($f["codigo"]);
					$tmp['nombre'] = utf8_encode($f["nombre"]);
					$tmp['estado'] = utf8_encode($f["estado"]);
					$tmp['tipo'] =  utf8_encode($f["tipo_ubicacion"]);
					
					$nodes[]= $tmp;
		
				}
				header("Content-Type:text/json; charset=" . $_SESSION["CODIFICACION_HEADER"]);
				if (sizeof($nodes) > 0) {
					echo json_encode($nodes);
				} else {
					echo '{}';
				}
			}
		}
		else
		{
			$cond->add_criterio_extra("ub.id_ubicacion_fk", $node);
			$criterio_filtro = $cond->obtener_criterio_filtro();
			$id_alma=$id_almacen;
			$nodo = $node;
	
			$res = $Custom->ListarUbicacionItemRamaNodo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro,$hidden_id_financiadora,$hidden_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad,$id_alma,$nodo,$id_item);
	
			if($res)
			{
				foreach ($Custom->salida as $f)
				{
					//$tmp['text'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"]);
					$tmp['id'] = utf8_encode($f["id_ubicacion"]);
					
					$tmp['leaf'] = false;
					$tmp['allowDelete'] = true;
					$tmp['allowDrag'] = false;
					$tmp['allowDrop'] = false;
					$tmp['allowEdit'] = true;
					
					
					if($f["tipo_ubicacion"]=='rama')
						$tmp['icon'] = "../../../lib/images/almacenes/ubicacion_rama.png";
					else 
						$tmp['icon'] = "../../../lib/images/almacenes/nodo.png";
					
					
					if($f["checked"]== 'f')
					{
						$tmp['checked']=false;
						$tmp['text'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"]);
					}
					else 
					{	
						$tmp['checked']=true;
						if($f["tipo_ubicacion"]=='rama')
						{
							$tmp['text'] = "<span style=color:blue>".utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"])."</span>";
						}
						else
							$tmp['text'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"]);
						
					}
					
					//$tmp['icon'] = "../../../lib/imagenes/ubicacion.png";
					$tmp['cls'] = 'folder';
					
					$tmp['qtip'] = $tipo_nodo;
					$tmp['qtipTitle'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"]);
					
					
					$tmp['id_ubicacion'] = utf8_encode($f["id_ubicacion"]);
					$tmp['id_ubicacion_fk'] = utf8_encode($f["id_ubicacion_fk"]);
					$tmp['id_almacen'] = utf8_encode($f["id_almacen"]);
					$tmp['codigo'] = utf8_encode($f["codigo"]);
					$tmp['nombre'] = utf8_encode($f["nombre"]);
					$tmp['estado'] = utf8_encode($f["estado"]);
					$tmp['tipo'] =  utf8_encode($f["tipo_ubicacion"]);
					
					$nodes[]= $tmp;
				}
				header("Content-Type:text/json; charset=" . $_SESSION["CODIFICACION_HEADER"]);
				if (sizeof($nodes) > 0) {
					echo json_encode($nodes);
				} else {
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
		echo '{}';
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
	exit();
}

?>