<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarUbicaiconItem.php
Valores de Retorno:    	Número de registros
Fecha de Creación:		
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/

session_start();
include_once ('../LibModeloAlma.php');

$nombre_archivo = "ActionEliminarUbicaiconItem.php";
$Custom = new cls_CustomDBAlma();

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}

if($_SESSION["autentificado"]=="SI")
{
	

	$decodificado = stripslashes($_REQUEST['datos']);
	$proceso=stripslashes($_REQUEST['proc']);

	$nodo = json_decode($decodificado,true);
	
	
	if ($nodo['tipo'] == 'raiz' AND $proceso == 'del')
	{
		$res = $Custom->EliminarUbicacionItemRaiz($nodo['id_ubicacion'],$nodo['id_item'],$nodo['id_almacen']);
		if(!$res)
		{
			$tmp['success']='false';
			echo json_encode($tmp);
			exit;
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] ;
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		
		}else{
			$tmp['success'] = 'true';
			echo json_encode($tmp);
			exit;
		}
	}
	else 
	{
		if($nodo['tipo'] == 'nodo' AND $proceso == 'del')
		{
			$res = $Custom->EliminarUbicacionItemNodo($nodo['id_ubicacion'],$nodo['id_item'],$nodo['id_almacen']);
			
			if(!$res)
			{
				$tmp['success']='false';
				echo json_encode($tmp);
				exit;
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];  
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			
			}else{
				$tmp['success'] = 'true';
				echo json_encode($tmp);
				exit;
			}
		}
		else 
		{
			$res = $Custom->EliminarUbicacionItemRama($nodo['id_ubicacion'],$nodo['id_item'],$nodo['id_almacen']);
				
			if(!$res)
			{
				$tmp['success']='false';
				echo json_encode($tmp);
				exit;
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
					
			}else{
				$tmp['success'] = 'true';
				echo json_encode($tmp);
				exit;
			}
		}
	}
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>