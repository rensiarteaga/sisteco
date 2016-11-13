<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCorrespondencia.php
Propósito:				Permite insertar y modificar datos en la tabla tfl_correspondencia
Tabla:					tfl_tfl_correspondencia
Parámetros:				$id_correspondencia
						$id_depto
						$id_documento
						$id_empleado_origen
						$id_uo_origen
						$id_institucion
						$id_persona
						$referencia
						$fecha_origen
						$hora_origen
						$fecha_destino
						$hora_destino
						$accion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2011-02-11 10:52:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionGuardarCorrespondencia.php";

$carpeta_destino = '../../control/correspondencia/arch_adjuntos/';

/*
 * TAMAÑO MAXIMO DEL ARCHIVO
 */
$tMax = 105857600;
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

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		
			if ($get)
			{
				$id_correspondencia= $_GET["id_correspondencia_$j"];
				$id_depto= $_GET["id_depto_$j"];
				$id_documento= $_GET["id_documento_$j"];
				$id_empleado= $_GET["id_empleado_$j"];
				$id_uo= $_GET["id_uo_$j"];
				$id_institucion= $_GET["id_institucion_$j"];
				$id_persona= $_GET["id_persona_$j"];
				$referencia= $_GET["referencia_$j"];
				$fecha_origen= $_GET["fecha_origen_$j"];
				$fecha_destino= $_GET["fecha_destino_$j"];
				$hora_destino= $_GET["hora_destino_$j"];
				$id_tipo_accion= $_GET["id_tipo_accion_$j"];
				$empleados= $_GET["empleados_$j"];
				$tipo= $_GET["tipo_$j"];
				$nuevo= $_GET["nuevo_$j"];
				$mensaje= $_GET["mensaje_$j"];
				$accion_proceso= $_GET["accion_proceso_$j"];
				$archivo=$_GET["archivo"];
				$id_correspondencia_fk=$_GET["id_correspondencia_fk_$j"];
				$acciones=$_GET["acciones_$j"];
				$observaciones=$_GET["observaciones_$j"];
				$observaciones_estado=$_GET["observaciones_estado_$j"];
				$cite=$_GET["cite_$j"];
				$id_nivel_seguridad=$_GET["id_nivel_seguridad_$j"];
				$nivel_prioridad=$_GET["nivel_prioridad_$j"];
				$fecha_max_res=$_GET["fecha_max_res_$j"];
				$id_correspondencia_asociada=$_GET["id_correspondencia_asociada_$j"];
				
				
	
	
			}
			else
			{
				$id_correspondencia=$_POST["id_correspondencia_$j"];
				$id_depto=$_POST["id_depto_$j"];
				$id_documento=$_POST["id_documento_$j"];
				$id_empleado=$_POST["id_empleado_$j"];
				$id_uo=$_POST["id_uo_$j"];
				$id_institucion=$_POST["id_institucion_$j"];
				$id_persona=$_POST["id_persona_$j"];
				$referencia=$_POST["referencia_$j"];
				$fecha_origen=$_POST["fecha_origen_$j"];
				$fecha_destino=$_POST["fecha_destino_$j"];
				$hora_destino=$_POST["hora_destino_$j"];
				$id_tipo_accion=$_POST["id_tipo_accion_$j"];
				$empleados= $_POST["empleados_$j"];
				$tipo= $_POST["tipo_$j"];
				$nuevo= $_POST["nuevo_$j"];
				$mensaje= $_POST["mensaje_$j"];
				$accion_proceso= $_POST["accion_proceso_$j"];
				$archivo=$_GET["archivo"];
				$id_correspondencia_fk=$_POST["id_correspondencia_fk_$j"];
				$acciones=$_POST["acciones_$j"];
				$observaciones=$_POST["observaciones_$j"];
				$observaciones_estado=$_POST["observaciones_estado_$j"];
				$cite=$_POST["cite_$j"];
				$id_nivel_seguridad=$_POST["id_nivel_seguridad_$j"];
				$nivel_prioridad=$_POST["nivel_prioridad_$j"];
				$fecha_max_res=$_POST["fecha_max_res_$j"];
				$id_correspondencia_asociada=$_POST["id_correspondencia_asociada_$j"];
			}
			
			
		$url_archivo='';
		$archivo = $_POST["archivo"];
		
		/*
		 * EN ALGÚN LUGAR SE ESTÁ DECODIFICANDO LA CADENA A UTF8
		 */
		
		if ($id_correspondencia == "undefined" || $id_correspondencia == "")
		{
			////////////////////Inserción/////////////////////
			
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCorrespondencia("insert",$id_correspondencia,$id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$hora_origen,$fecha_destino,$hora_destino,$observaciones,$observaciones_estado,$mensaje);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
			
			//valida tamaño de archivo 
			
			if($_FILES["archivo"]["size"] < $tMax  && ($_FILES["archivo"]["error"] ==0 || $_FILES["archivo"]["error"] == 7 ||
			/*si no subio arhivo debe seguir*/$_FILES["archivo"]["error"] == 4))
		    {		  
		    	
		    		$nombre_original = $_FILES["archivo"]["name"];	
		    		
		    		$ext = explode(".",$_FILES["archivo"]["name"]); //obtiene cadena despues del .
					
					$tamaño = count($ext);
							
					$extension = $ext[$tamaño - 1]; // se obtiene la extension = ultimo indice del vector
				    
					//Modificación Aayaviri 12/04/2011 - 23:45
					$extension = strtolower($extension);
					
					if($extension=='pdf' || $extension=='PDF' || $extension=='' || $extension=='doc' || $extension=='DOC' ||$extension=='docx' || $extension=='DOCX' ){
						    $nombre_arch = 'corres_';	
							
							$nombre_original = $_FILES["archivo"]["name"];
							
							//validamos si el archivo se subio
							$sw_subir_archivo = true;
							
							if($_FILES["archivo"]["size"] ==0){
								
							  $nombre_arch=null;	
							  $sw_subir_archivo = false;
								
							}
							//RAC: 26/05/2011
							//$id_correspondencia_asociada
							//convierte en vector la cadena
							if(isset($id_correspondencia_asociada)){
								$vec=explode(',',$id_correspondencia_asociada);
								//elimina los calores repetidos
								$vec=array_unique($vec);								
						    }
							
				   	    
							//Validación satisfactoria, se ejecuta la inserción en la tabla tfl_correspondencia
							$res = $Custom -> InsertarCorrespondencia($id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$nombre_arch,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite,$vec,$id_nivel_seguridad);
							
							if(!$res){
										//Se produjo un error
										$resp = new cls_manejo_mensajes(true, "406");
										$resp->mensaje_error = $Custom->salida[1]."(iteración $cont)";
										$resp->origen = $Custom->salida[2];
										$resp->proc = $Custom->salida[3];
										$resp->nivel = $Custom->salida[4];
										//$resp->query = $Custom->query;
										echo $resp->get_mensaje();
										exit;
							}
							else{
							  if($sw_subir_archivo){
							  	
		                          //subre el archivo
								  //si no hay error al inserta moves el archivo 
								move_uploaded_file($_FILES["archivo"]["tmp_name"],$carpeta_destino.$Custom->salida[2]);	
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
				 else{
				 	  $mensaje_error= 'El tamaño sobrepasa lo permitido, maximo '.$tMax.' Kb y su archivo tiene='.$_FILES["archivo"]["size"]."Kb";  
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
		}
		else
		{	///////////////////////Modificación////////////////////
			
			
		  //Validación de datos (del lado del servidor)
		  $res=$Custom->ValidarCorrespondencia("update",$id_correspondencia,$id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$hora_origen,$fecha_destino,$hora_destino,$observaciones,$observaciones_estado,$mensaje);
			
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
			
		
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
					  if($extension=='pdf' || $extension=='PDF' || $extension=='' || $extension=='doc' || $extension=='DOC' ||$extension=='docx' || $extension=='DOCX' ){
							  $nombre_arch = 'corres_';	
			
							  $nombre_original = $_FILES["archivo"]["name"];
							  //validamos si el archivo se subio
							  $sw_subir_archivo = true;
							   if($_FILES["archivo"]["size"]==0){
							   	// no está entrando aquí.
							   			$nombre_arch=null;	
										$sw_subir_archivo = false;
							   }
							   
							   
								   //RAC: 26/05/2011
									//$id_correspondencia_asociada
									//convierte en vector la cadena
									if(isset($id_correspondencia_asociada)){
										$vec=explode(',',$id_correspondencia_asociada);
										//elimina los calores repetidos
										$vec=array_unique($vec);								
								    }
							   
								$res = $Custom->ModificarCorrespondencia($id_correspondencia,$id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$nombre_arch,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite,$id_nivel_seguridad,$nivel_prioridad,$fecha_max_res,$vec);
					
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
					 else{
					 	  $mensaje_error= 'El tamaño sobrepasa lo permitido, maximo '.$tMax.' Kb y su archivo tiene='.$_FILES["archivo"]["size"]."Kb";  
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
		
		  
	   }

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_correspondencia";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = " 0=0 ";

	
	if(isset($id_correspondencia_fk)&&($vista =="detalle")){
		$criterio_filtro.=" and CORRE.id_correspondencia_fk=$id_correspondencia_fk ";
	}
	
	$res = $Custom->ContarCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
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