<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardar.php
Propósito:				
Tabla:					

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2012-05-04 18:52:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionSubirArchivo.php";

$carpeta_destino = '../../control/unidad_organizacional/file_descripcion_cargos/';

/*
 * TAMAÑO MAXIMO DEL ARCHIVO
 */
$tMax = 105857600; //100 megas limite
if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
		
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		
		if($_POST["subearchivo"] == 'si')
			$cont =  1;
		else
			$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

		//$url_archivo
		
		$url_archivo='';

		///////////////////////Modificación////////////////////
		//valida tamaño de archivo 
			if($_FILES["archivo"]["size"] < $tMax  && ($_FILES["archivo"]["error"] ==0 || $_FILES["archivo"]["error"] == 7||
			/*si no subio arhivo debe seguir*/$_FILES["archivo"]["error"] == 4))
				{   
			    	  $nombre_original = $_FILES["archivo"]["name"];	
					  $ext = explode(".",$_FILES["archivo"]["name"]); //obtiene cadena despues del .
					  $tamaño = count($ext);
					  $extension = $ext[$tamaño - 1]; // se obtiene la extension = ultimo indice del vector
					  //MODIFICACIÓN aayaviri 12/04/2011 - 23:46
					  
					  $extension = strtolower($extension);
					  
					  
					  if($extension=='pdf' || $extension=='PDF' || $extension=='' || $extension=='doc' || $extension=='DOC' ||$extension=='docx' || $extension=='DOCX' || $extension=='mp4' ){
							  $nombre_arch = 'corres_';	
			
							  $nombre_original = $_FILES["archivo"]["name"];
							  //validamos si el archivo se subio
							  $sw_subir_archivo = true;
							   if($_FILES["archivo"]["size"]==0){
							   	// no está entrando aquí.
							   			$nombre_arch=null;	
										$sw_subir_archivo = false;
							   } 
							   
							  // echo $id_unidad_organizacional.'nombre->'.$nombre_arch.'ext->'.$extension.'nom->'.$nombre_original; exit;
								$res = $Custom->SubirArchivo($id_unidad_organizacional,$nombre_arch,$extension);
					
								if(!$res){
									
								
									//Se produjo un error
									$resp = new cls_manejo_mensajes(true, "406");
									$resp->mensaje_error = $Custom->salida[1];
									$resp->origen = $Custom->salida[2];
									$resp->proc = $Custom->salida[3];
									$resp->nivel = $Custom->salida[4];
									$resp->query = '';
									echo $resp->get_mensaje();
									exit;
								}
								else{
									
								  if($sw_subir_archivo){
								    //eliminamos el archivo viejo
								    if($Custom->salida[2]!='null')
								    //valida si existe el archivo antes de eliminar
								    
								    if (file_exists($carpeta_destino.$Custom->salida[2])){ 
								    	unlink($carpeta_destino.$Custom->salida[2]);
								    }
									//subimos el nuevo archivo
									move_uploaded_file($_FILES["archivo"]["tmp_name"],$carpeta_destino.$Custom->salida[3]);
								   }
								}
					  }
					  else{
						$resp = new cls_manejo_mensajes(true, "406");
						$resp->mensaje_error = "Solo es posible subir archivos en formato PDF";
						$resp->origen = "control";
						$resp->proc = 'subida de archivo';
						$resp->nivel = "0";
						$resp->query = "";
						echo $resp->get_mensaje();
						exit;
						
					}
			    }
			    else{ 
		    	//error en el archivo

			    	if($_FILES["archivo"]["error"] != 0)
					{
								if($_FILES["archivo"]["error"] == 3)
								{
									$mensaje_error= 'El archivo subido fue sólo parcialmente cargado.';
								}
								
								/*if($_FILES["archivo"]["error"] == 4)
								{
									$mensaje_error= 'Ningún archivo fue subido.';  
								}*/
															
								if($_FILES["archivo"]["error"] == 6)
								{
									$mensaje_error= 'Falta la carpeta temporal.';  
								}
								
							
					 }					 			 					 		
					 
					 else
					 {
					 	$mensaje_error= 'El tamaño sobrepasa lo permitido, maximo '.$tMax.' Kb (100 Mb) y su archivo tiene = '.$_FILES["archivo"]["size"]." Kb";  
					 	
					 	echo "<script languaje='javascript' type='text/javascript'>alert('El tamaño sobrepasa lo permitido, máximo 100 Mb');</script>"; exit;
					 }
				 	//Se produjo un error
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $mensaje_error;
					$resp->origen = "control";
					$resp->proc = 'subida de archivo';
					$resp->nivel = "0";
					$resp->query = "";
					echo $resp->get_mensaje();
					exit;
			 }
		

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];
	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", 1);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;
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