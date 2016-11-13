<?php 
	//if(($extension_archivo=='pdf') || ($extension_archivo=='png') || ($extension_archivo=='gif') || ($extension_archivo=='jpg'))
//	{   
      /*  echo 'verificar'.$txt_archivo;
        echo 'verificar'.$directorio_archivo;
        echo 'verificar'.$ruta_archivo;
        exit;*/
		move_uploaded_file(($txt_archivo),$directorio_archivo.$ruta_archivo);
	//}
	/*else{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error ="Debe subir un archivo, con extension (pdf o imagen)";
		$resp->origen = $nombre_archivo;
		echo $resp->get_mensaje();
		exit;
	}
*/
?>