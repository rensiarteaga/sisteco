<?php
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionSubirExcelArchivo.php";

if (!isset($_SESSION["autentificado"]))
{
 $_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
 
 //Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
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
 
 
 
 
 $txt_tmp_name = $_FILES['txt_archivo']['tmp_name'];
 $txt_name = $_FILES['txt_archivo']['name'];
 $extension = explode(".",$_FILES['txt_archivo']['name']);
 
/* echo $txt_tmp_name;
 exit;*/
 $error = 0;
 $mensaje = '';
 if(isset($_FILES['txt_archivo']) && is_uploaded_file($_FILES['txt_archivo']['tmp_name'])){
  if ($extension[1] != 'xls' && $extension[1] != 'XLS') {
   echo "La extensión del archivo no es correcta, Se requiere que sea un archivo Excel";
   exit;
   $error = 1;
  }  
       //upload directory 
      if ($subida=='extracto_bancario'){
      	$upload_dir = "../extracto_bancario/archivos/";
      } else{
      	$upload_dir = "archivos/";
      }
    
     //create file name  
     $file_path = $upload_dir . $txt_name; 
     /* echo $file_path;
      exit;*/
    
     //move uploaded file to upload dir  
     if (!move_uploaded_file($txt_tmp_name, $file_path)) {   
         //error moving upload file  
         echo "Error moviendo el archivo subido";
         exit;
              $error = 1;   
     }  
 } else {
	  echo "Error al subir al archivo";
	  exit;
	  $error = 1;
 }
 
 
 if($error == 0 || $error == 2)
 {
  $resp = new cls_manejo_mensajes(false);
 
 
 
  //Exito
  $resp = new cls_manejo_mensajes(false, "200");
  if ($error == 0)
   $resp->add_nodo("mensaje", "Se guardaron exitosamente todos los valores");   
  else
   $resp->add_nodo("mensaje", "No se proceso: \n" . $mensaje);
      
  $resp->add_nodo("tiempo_resp", "200");
  echo $resp->get_mensaje();
  exit; 
 } else {
   
  //Se produjo un error
  $resp = new cls_manejo_mensajes(true, "406");
  $resp->mensaje_error = $mensaje;
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
 $resp = new cls_manejo_mensajes(true, "401");
 $resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
 $resp->origen = "ORIGEN = $nombre_archivo";
 $resp->proc = "PROC = $nombre_archivo";
 $resp->nivel = "NIVEL = 1";
 echo $resp->get_mensaje();
 exit;
}
?>