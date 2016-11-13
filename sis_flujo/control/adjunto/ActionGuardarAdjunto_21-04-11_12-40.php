<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarAdjunto.php
Propósito:				Permite guardar registros en la tabla tfl_adjunto
Tabla:					tfl_adjunto
Parámetros:				

Valores de Retorno:    	
Fecha de Creación:		2011-02-10
Versión:				1.0.0
Autor:					Marcos A. Flores Valda
*/



session_start();
include_once("../LibModeloFlujo.php");
			
$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionGuardarAdjunto.php";

$carpeta_destino = '../../control/adjunto/arch_adjuntos/';

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
	
	$Custom->decodificar = $decodificar;
	
	/*
	 * TAMAÑO MAXIMO DEL ARCHIVO
	 */
	$tMax = 52428800;
	
	for($j = 0; $j < $cont; $j++)
	{
		if($_POST["subearchivo"] != 'si')
		{
			if ($get)
			{
				$id_adjunto	= $_GET["id_adjunto_$j"];
				$nombre_doc = $_GET["nombre_doc_$j"];
				$observacion = $_GET["observacion_$j"];
				$id_correspondencia = $_GET["id_correspondencia_$j"];
				$archivo_adjunto = $_GET["archivo_adjunto_$j"];
				$nombre_original = $_GET["nombre_original_$j"];
				$extension = $_GET["extension_$j"];
				$desc_persona = $_GET["desc_persona_$j"];
			}
			else
			{
				$id_adjunto	= $_POST["id_adjunto_$j"];
				$nombre_doc = $_POST["nombre_doc_$j"];
				$observacion = $_POST["observacion_$j"];
				$id_correspondencia = $_POST["id_correspondencia_$j"];
				$archivo_adjunto = $_POST["archivo_adjunto_$j"];
				$nombre_original = $_POST["nombre_original_$j"];
				$desc_persona = $_POST["desc_persona_$j"];
			}
			
			$var_grilla = 1;
		}
		
		else 
		{
			if ($get)
			{
				$id_adjunto	= $_GET["id_adjunto"];
				$nombre_doc = $_GET["nombre_doc"];
				$observacion = $_GET["observacion"];
				$id_correspondencia = $_GET["id_correspondencia"];
				$archivo_adjunto = $_GET["archivo_adjunto"];
				$nombre_original = $_GET["nombre_original"];
				$extension = $_GET["extension"];
				$desc_persona = $_GET["desc_persona"];
			}
			else
			{
				$id_adjunto	= $_POST["id_adjunto"];
				$nombre_doc = $_POST["nombre_doc"];
				$observacion = $_POST["observacion"];
				$id_correspondencia = $_POST["id_correspondencia"];
				$archivo_adjunto = $_POST["archivo_adjunto"];
				$nombre_original = $_POST["nombre_original"];
				$extension = $_POST["extension"];
				$desc_persona = $_POST["desc_persona"];
			}	
			
			$var_form = 1;	
		}			
			
		if ($id_adjunto == "undefined" || $id_adjunto == "")
		{		    			
			$tamaño_arch = $_FILES["archivo_adjunto"]["size"];
			
		    //////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAdjunto("insert",$id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension);

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
								
			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_Formulario		    
		    //var_dump($Custom); //para ver el contenido de cualquier objeto						
			
		    if($_FILES["archivo_adjunto"]["size"] < $tMax)
		    {		    
		    	if($_FILES["archivo_adjunto"]["size"] != 0)
		    	{
		    		$nombre_original = $_FILES["archivo_adjunto"]["name"];	
		    		
		    		$ext = explode(".",$_FILES["archivo_adjunto"]["name"]); //obtiene cadena despues del .
					
					$tamaño = count($ext);
							
					$extension = $ext[$tamaño - 1]; // se obtiene la extension = ultimo indice del vector
				    
				    $nombre_arch = 'adjunto_';	
					
					$nombre_original = $_FILES["archivo_adjunto"]["name"];		    					
						
					$res = $Custom -> InsertarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension,$nombre_original,$desc_persona);											
					
					//echo var_dump($Custom); exit;
					
					if($Custom->salida[1] == 'Registro exitoso en flujo.tfl_adjunto')
					{	
						move_uploaded_file($_FILES["archivo_adjunto"]["tmp_name"],$carpeta_destino.$Custom->salida[3]);	
											
						if($_FILES["archivo_adjunto"]["error"] == 0)
						{
							//subió con exito el archivo al servidor													
						}
						
						else //errores de subida de archivo
						{
							if($_FILES["archivo_adjunto"]["error"] == 3)
							{
								//Se produjo un error
								$resp = new cls_manejo_mensajes(true, "3");
								$resp->mensaje_error =  'El archivo subido fue sólo parcialmente cargado.';
								$resp->origen = $Custom->salida[2];
								$resp->proc = $Custom->salida[3];
								$resp->nivel = $Custom->salida[4];
								$resp->query = $Custom->query;
								echo $resp->get_mensaje();
								exit;  
							}
							
							if($_FILES["archivo_adjunto"]["error"] == 4)
							{
								//Se produjo un error
								$resp = new cls_manejo_mensajes(true, "4");
								$resp->mensaje_error = 'Ningún archivo fue subido.';  
								$resp->origen = $Custom->salida[2];
								$resp->proc = $Custom->salida[3];
								$resp->nivel = $Custom->salida[4];
								$resp->query = $Custom->query;
								echo $resp->get_mensaje();
								exit;  
							}
														
							if($_FILES["archivo_adjunto"]["error"] == 6)
							{
								//Se produjo un error
								$resp = new cls_manejo_mensajes(true, "6");
								$resp->mensaje_error = 'Falta la carpeta temporal.';  
								$resp->origen = $Custom->salida[2];
								$resp->proc = $Custom->salida[3];
								$resp->nivel = $Custom->salida[4];
								$resp->query = $Custom->query;
								echo $resp->get_mensaje();
								exit;  
							}
							
							if($_FILES["archivo_adjunto"]["error"] == 7)
							{
								//Se produjo un error
								$resp = new cls_manejo_mensajes(true, "7");
								$resp->mensaje_error = 'No se pudo escribir el archivo en el disco.';  
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
			    		//Se produjo un error
						$resp = new cls_manejo_mensajes(true, "406");
						$resp->mensaje_error = 'No seleccionó ningún archivo para ser subido al servidor.';
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
		    	//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = 'ARCHIVO DEMASIADO GRANDE';
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;	    	
		    }		    	  	 				
		}	
		
		else
		{	///////////////////////Modificación////////////////////
					
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAdjunto("update",$id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension);

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
			
			if($_FILES["archivo_adjunto"]["size"] < $tMax)
			{	
				if($var_form == 1) // se modifica desde el formulario 
				{
					if($_FILES["archivo_adjunto"]["size"] == 0) // no se envía ningún archivo para ser subido al servidor cuando se edita
					{
						$nombre_arch = 'vacio';
						
						$res = $Custom -> ModificarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension,$nombre_original);
												
						if(!$res)
						{
							//Se produjo un error
							$resp = new cls_manejo_mensajes(true, "406");
							$resp->mensaje_error = $Custom->salida[1];
							$resp->origen = $Custom->salida[2];
							$resp->proc = $Custom->salida[3];
							$resp->nivel = $Custom->salida[4];
							$resp->query = $Custom->query;
							echo $resp->get_mensaje();
							exit;
						}	
					}
					
					if($_FILES["archivo_adjunto"]["size"] != 0) // no se envía ningún archivo para ser subido al servidor cuando se edita
					{
						$nombre_original = $_FILES["archivo_adjunto"]["name"];
			
						$ext = explode(".",$_FILES["archivo_adjunto"]["name"]); //obtiene cadena despues del .
					    					
					    $tamaño = count($ext);
						
						$extension = $ext[$tamaño - 1]; // se obtiene la extension = penultimo indice del vector
						
						$nombre_arch = 'adjunto_';
						
						$res = $Custom ->ModificarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension,$nombre_original);
						
						if(!$res)
						{
							//Se produjo un error
							$resp = new cls_manejo_mensajes(true, "406");
							$resp->mensaje_error = $Custom->salida[1];
							$resp->origen = $Custom->salida[2];
							$resp->proc = $Custom->salida[3];
							$resp->nivel = $Custom->salida[4];
							$resp->query = $Custom->query;
							echo $resp->get_mensaje();
							exit;
						}			
												
						if($Custom->salida[1] == 'Modificación exitosa en flujo.tfl_adjunto')
						{  	
							$extension = $Custom->salida[3];
													
							$adjunto = $nombre_arch.$Custom->salida[2].'.'.$extension;	
												
							unlink('../../control/adjunto/arch_adjuntos/'.$adjunto);	
								
							$ext1 = explode(".",$_FILES["archivo_adjunto"]["name"]); //obtiene cadena despues del .
							    					
							$tamaño1 = count($ext1);
								    
							$extension1 = $ext1[$tamaño - 1]; // se obtiene la extension = ultimo indice del vector
									
							$nombre_arch = 'adjunto_';	
									
							$adjunto1 = $nombre_arch.$Custom->salida[2].'.'.$extension1;						
									
							move_uploaded_file($_FILES["archivo_adjunto"]["tmp_name"], $carpeta_destino.$adjunto1);
							/*
							 * MODIFICACIÓN 02-04-2011 AAYAVIRI
							 * MOTIVO: ESTE MENSAJE ESTÁ DEMÁS Y PROVOCA QUE NO SE CIERRE EL FORMULARIO
							 * 			DE EDITAR Y POR TANTO QUE NO SE ACTUALIZE LA GRILLA
							if($_FILES["archivo_adjunto"]["error"] == 0)
							{
								//upload correcto
								$resp = new cls_manejo_mensajes(true, "0");
								$resp->mensaje_error =  "El archivo $nombre_original se subió correctamente.";
								$resp->origen = $Custom->salida[2];
								$resp->proc = $Custom->salida[3];
								$resp->nivel = $Custom->salida[4];
								$resp->query = $Custom->query;
								echo $resp->get_mensaje();
								exit; 
							}
							*/
								if($_FILES["archivo_adjunto"]["error"] == 3)
								{
									//Se produjo un error
									$resp = new cls_manejo_mensajes(true, "406");
									$resp->mensaje_error =  'El archivo subido fue sólo parcialmente cargado.';
									$resp->origen = $Custom->salida[2];
									$resp->proc = $Custom->salida[3];
									$resp->nivel = $Custom->salida[4];
									$resp->query = $Custom->query;
									echo $resp->get_mensaje();
									exit; 
								}
								
								if($_FILES["archivo_adjunto"]["error"] == 4)
								{
									//Se produjo un error
									$resp = new cls_manejo_mensajes(true, "406");
									$resp->mensaje_error = 'Ningún archivo fue subido.';  
									$resp->origen = $Custom->salida[2];
									$resp->proc = $Custom->salida[3];
									$resp->nivel = $Custom->salida[4];
									$resp->query = $Custom->query;
									echo $resp->get_mensaje();
									exit; 
								}
															
								if($_FILES["archivo_adjunto"]["error"] == 6)
								{
									//Se produjo un error
									$resp = new cls_manejo_mensajes(true, "406");
									$resp->mensaje_error = 'Falta la carpeta temporal.';  
									$resp->origen = $Custom->salida[2];
									$resp->proc = $Custom->salida[3];
									$resp->nivel = $Custom->salida[4];
									$resp->query = $Custom->query;
									echo $resp->get_mensaje();
									exit; 
								}
								
								if($_FILES["archivo_adjunto"]["error"] == 7)
								{
									//Se produjo un error
									$resp = new cls_manejo_mensajes(true, "406");
									$resp->mensaje_error = 'No se pudo escribir el archivo en el disco.';  
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
				
				
				if($var_grilla == 1)
				{
					$nombre_arch = 'vacio';
						
					$res = $Custom ->ModificarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension,$nombre_original);
						
					if(!$res)
					{
						//Se produjo un error
						$resp = new cls_manejo_mensajes(true, "406");
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
		    	//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = 'ARCHIVO DEMASIADO GRANDE';
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;	    	
		    }			    
		}
	}
	
	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) 
		$mensaje_exito = "Se guardaron todos los datos.";
	
	else 
		$mensaje_exito = $Custom->salida[1];	

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_adjunto";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = " 0=0 ";
	
	//if(isset($id_correspondencia))
	//	$criterio_filtro = $id_correspondencia;
	$criterio_filtro.=" and ADJUNT.id_correspondencia=$id_correspondencia";
		
	$res = $Custom -> ContarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);
	
	if($res) 
		$total_registros = $Custom->salida;

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