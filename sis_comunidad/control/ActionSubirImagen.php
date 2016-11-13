<?php 
	if(($extension_imagen=='jpg') || ($extension_imagen=='png') || ($extension_imagen=='gif') || ($extension_imagen==''))
	{
		move_uploaded_file(($txt_imagen),$directorio_imagen.$ruta_imagen);
	}
	else{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "Si sube una imagen debe hacerlo con extension (jpg, png o gif). No es necesario subir imagenes para publicaciones";
		$resp->origen = $nombre_archivo;
		echo $resp->get_mensaje();
		exit;
	}


?>