<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCaracteristicaItem.php
Propósito:				Permite Listar las carcteristicas asociadas a item's en la forma ATRIBUTO: VALOR
Tabla:					almin.tal_caracteristica_item
Parámetros:				$id_item
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-28 17:32:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom =  new  cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionListarCaracteristicaItem.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{ 
	//Verifica si los datos vienen por POST o GET
	//Verifica si los datos vienen por POST o GET
	
	if($id_item>0){
	    $res = $Custom->ContarCaracteristicaItem(15,0,'id_item','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_item);
	    
	    if($res){
	        $json['TotalCount']= $Custom->salida;
	           $res = $Custom->ListarCaracteristicaItem(15,0,'id_item','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_item);
        	  	if($res)
        		{ 
        		    foreach ($Custom->salida as $f){   
        		        $tmp['nombre'] = utf8_encode($f["nombre"]);
        			    $tmp['valor'] = $f["valor"];
        				$tmp['unidad_medida']	= $f["unidad_medida"];
        	            
        				$fecha_sep = explode('-',$f["ultima_fecha"]);
	                    $fecha = $fecha_sep[2]."/".$fecha_sep[1]."/".$fecha_sep[0];
        			    $tmp['ultima_fecha']	= $fecha;
        				$nodes[] = $tmp ;
        			}
        			
        			$json['ROWS']=$nodes;
        			
              	    if(sizeof($nodes)>0){
        			    echo json_encode($json);
        			}
        			else {
        			    $tmp['nombre'] = '';
        				$tmp['valor'] ='';
        				$tmp['unidad_medida']	= '';
        			     
        				$nodes[] = $tmp ;
        				$json['ROWS']=$nodes;
        				echo json_encode($json);
        			}
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
	echo $resp-> get_mensaje();
	exit;
}
?>