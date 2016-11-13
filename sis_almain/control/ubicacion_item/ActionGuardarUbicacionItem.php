<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarUbicacionItem.php
Prop�sito:				Permite insertar y modificar datos en la tabla
Tabla:					
Parametros:				
						
						

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once ('../LibModeloAlma.php');

$nombre_archivo = "ActionGuardarUbicaiconItem.php";
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
	
	 
	if($nodo['tipo']== 'raiz')
	{
		if($proceso=='add')
		{
			$res = $Custom->InsertarUbicacionItemRaiz($nodo['id_ubicacion'],$nodo['id_item'],$nodo['id_almacen']);
			
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
			}
			else
			{
				$tmp['success'] = 'true';
				echo json_encode($tmp);
				exit;
			}
			
		}
	}
	elseif ($nodo['tipo']=='rama')
	{
		if($proceso =='add') 
		{
			$res = $Custom->InsertarUbicacionItemRama($nodo['id_ubicacion'],$nodo['id_item'],$nodo['id_almacen']);
			
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
			}
			else
			{
				$tmp['success'] = 'true';
				echo json_encode($tmp);
				exit;
			}
		}
	}
	elseif ($nodo['tipo']=='nodo')
	{
		if($proceso =='add')
		{
			$res = $Custom->InsertarUbicacionItemNodo($nodo['id_ubicacion'],$nodo['id_item'],$nodo['id_almacen']);
				
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
			}
			else
			{
				$tmp['success'] = 'true';
				echo json_encode($tmp);
				exit;
			}
		}
	} 
}

?>