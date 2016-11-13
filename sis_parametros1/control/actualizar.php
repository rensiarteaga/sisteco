<?php 
if ($gestor = opendir('control')) {
	// Abre un gestor de directorios
	
	$i=0;
	while (false !== ($archivo = readdir($gestor))) {
		//readdir: Lee un elemento del directorio
		//$gestor abierto previamente
		//con opendir y desplaza el puntero al elemento siguiente
		echo $archivo; exit;
		if ($archivo != "." and $archivo != "..") {
			//checa que no sea subdirectorio
			$extension = strtolower(substr($archivo, -4));
			//strlower pasa a minuscula una cadena en este caso
			//los 4 últimos caracteres
			//de la cadena
			if (($extension == '.jpg') or ($extension == '.gif')
			or ($extension == '.png')) {
				if ($i==4) {// Cuatro imagenes por renglón
					$i=0;
					
				}
				$i++;
				
			}
			}
			}
			
	closedir($gestor); //Cierra el gestor
}

?>