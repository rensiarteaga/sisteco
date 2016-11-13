<?php
session_start();
include_once("../LibModeloControlAsistencia.php");

$Custom = new cls_CustomDBControlAsistencia();
$nombre_archivo = "ActionSubirCsvDatoValor.php";

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
 
 /*$id_gestion = $_POST['id_gestion'];
 $id_filial = $_POST['id_filial']; 
 $id_gestion_periodo = $_POST['id_gestion_periodo'];
 $momento = $_POST['momento'];*/
 

 //echo $_FILES['txt_archivo']['name']; exit;
 
 
 $txt_tmp_name = $_FILES['txt_archivo']['tmp_name'];
 $txt_name = $_FILES['txt_archivo']['name'];
 $extension = explode(".",$_FILES['txt_archivo']['name']);
 
 $error = 0;
 $mensaje = '';
 if(isset($_FILES['txt_archivo']) && is_uploaded_file($_FILES['txt_archivo']['tmp_name'])){
  if ($extension[1] != 'csv' && $extension[1] != 'CSV') {
   echo "La extensión del archivo no es csv";
   $error = 1;
  }  
       //upload directory  
     $upload_dir = "/tmp/";  
     //create file name  
     $file_path = $upload_dir . $txt_name;  
    
     //move uploaded file to upload dir  
     if (!move_uploaded_file($txt_tmp_name, $file_path)) {   
         //error moving upload file  
         echo "Error moviendo el archivo subido";
   $error = 1;   
     }  
 } else {
	  echo "Error al subir al archivo";
	  $error = 1;
 }
 
 if ($error == 0 ) {
  $lines = file($file_path);
  foreach ($lines as $line_num => $line) {
   $arr_temp = explode(',', $line);
   
   
  //print_r($arr_temp); exit;
  // $arr_temp=str_replace(',','.',$arr_temp);
  //echo split($arr_temp[1],0,9);
  $fecha=substr($arr_temp[1],0,10);
  $hora=substr($arr_temp[1],11);
  $tipo_marca=trim($arr_temp[2]);// substr($arr_temp[2],2);
  
 
   if(count($arr_temp) ==3){
   	
   	
   		    $res = $Custom->ProcesarArchivoCsv($arr_temp[0], $fecha, $hora ,$tipo_marca);
			    if(!$res) {
			     $error = 2;
			     $mensaje .= $Custom->salida[1] . "\n";
			    }
			 
   }/*else{ 
   	$res = $Custom->ModificarDatoValorCsv($id_filial, $id_gestion,$id_gestion_periodo,$momento, $arr_temp[0], $arr_temp[1],0, 0, 0,0, 0, 0,0, 0,0 ,0,0);
     	if(!$res) {
   		$error = 2;
   		$mensaje .= $Custom->salida[1] . "\n";
   	}
   }*/
  }
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