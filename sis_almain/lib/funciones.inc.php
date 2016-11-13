<?php
class funciones
{
	
/*
**********************************************************
Nombre de la función:	copiar_archivo_servidor($archivo_temporal,$carpeta_destino)
Propósito:				Se utiliza esta función para copiar 
						srchivos al servidor
Parámetros:				$archivo_temporal	-->	Aquí se almacena el nombre del archivo temporal
						$carpeta_destino  --> Aquí se guarda el nombre de la carpeta destino
Valores de Retorno:		$nombre_archivo 	-->	Retorna el nombre del archivo	
						-1	--> Indica que se produjo un error y no se pudo subir el archivo al servidor 
**********************************************************
*/
 
function carga_archivo ( $archivo, $directorio_destino)
{
	// Revisa si el archivo es de mas de 5 megabytes.
	if ( $archivo['size'] < 60000000 )//5512000
	{
		$nombre_archivo = basename ( $archivo['name'] ) ;
	    $nombre_archivo = $this -> limpiar($nombre_archivo);
	    
		if ( file_exists ( $directorio_destino."/".$nombre_archivo ) )
		{
			$nombre_archivo = $this -> renombra_archivo ($nombre_archivo, $directorio_destino) ;
		}

		$archivo_destino = $directorio_destino . $nombre_archivo ;
		
		if ( move_uploaded_file ($archivo['tmp_name'], $archivo_destino) )
		{
			chmod($archivo_destino,0777);
			return $nombre_archivo ;
		}
		else
		{  
			echo 'error al subir el archivo, verifique los permisos en el directorio destino y el archivo php.';exit;
			return -1 ;
		}
	}
	else
	{
		return -2 ;
	}
}

/*
 * funcion que retorna la ruta donde se almacenan los archivos subidos por un usuario
 * 
 *
 */
	 function public_base_directory()
	{
		static $directorio = '/sis_almain/archivos_proyectos/';
		//get public directory structure eg "/top/second/third"
		$public_directory = dirname($_SERVER['PHP_SELF']);
		//place each directory into array
		$directory_array = explode('/', $public_directory);
		//get highest or top level in array of directory strings
		$public_base = max($directory_array);
		
		$dir_root=split('/',$_SERVER['PHP_SELF']);
		return  $_SERVER['DOCUMENT_ROOT'].'/'.$dir_root[1].$directorio;
	}

/*
**********************************************************
Nombre de la función:	copiar_archivo_servidor($archivo_temporal,$carpeta_destino)
Propósito:				Se utiliza esta función para copiar 
						srchivos al servidor
Parámetros:				$archivo_temporal	-->	Aquí se almacena el nombre del archivo temporal
						$carpeta_destino  --> Aquí se guarda el nombre de la carpeta destino
Valores de Retorno:		$nombre_archivo 	-->	Retorna el nombre del archivo	
						-1	--> Indica que se produjo un error y no se pudo subir el archivo al servidor 
**********************************************************
*/



function carga_archivo_texto ( $archivo, $directorio_destino, $nombre_archivo )
{
	// Revisa si el archivo es de mas de 50 megabytes.
	if ( $archivo['size'] <= 60000000)
	{
		//$nombre_archivo = basename ( $archivo['name'] ) ;
	

		if ( file_exists ( $directorio_destino+$nombre_archivo ) )
		{
			$nombre_archivo = renombra_archivo ($nombre_archivo, $directorio_destino) ;
			
		}

		$archivo_destino = $directorio_destino . $nombre_archivo ;

		if ( move_uploaded_file ($archivo['tmp_name'], $archivo_destino) )
		{
			return $nombre_archivo ;
		}
		else
		{
			return -1 ;
		}
	}
	else
	{
		return -2 ;
	}
}
/*
**********************************************************
Nombre de la función:	renombrar ( $archivo,$carpeta_archivo )
Propósito:				Se utiliza esta función para copiar 
						srchivos al servidor
Parámetros:				$archivo	-->	Aquí se almacena el nombre del archivo ha ser cambiado
						$carpeta_archivo  --> Aquí se guarda el nombre de la carpeta destino
Valores de Retorno:		$nuevo_nombre	-->	El nuevo nombre del archivo	 
Observación:			-----
Fecha de Creación:		16 - 05 - 05
Versión:				1.0.0
**********************************************************
*/
function renombrar ( $archivo, $carpeta_archivo )
{
	$ruta = pathinfo($archivo);
	$nombre_completo = $ruta["basename"];
	$extension = $ruta["extension"];

	if ( isset($extension) && !empty($extension)) 
	{
		$extension = "." . $extension;

		// obtener la posicion de la extension
		$position = strpos($nombre_completo, $extension);

		// sacar el nombre del archivo sin extension
		$nombre_sin_extension = substr($archivo, 0, $position);
	}
	else
	{
		$nombre_sin_extension = $nombre_completo;
	}

	$n = 0;
	$copia = "";

	while ( file_exists ( $carpeta_archivo . $nombre_sin_extension . $copia . $extension) )
	{
		if ($n<=9)
			$n = "00" . $n;
			
		if ($n<=99 && $n>=10)
			$n = "0" . $n;

		if ($n<=999 && $n>=100)
			$n = "" . $n;

		$copia = "_" . $n;
		$n++;
	}

	return $nombre_sin_extension . $copia . $extension;
}


function limpiar ($archivo)
{
	$ruta = pathinfo($archivo);
	$nombre_completo = $ruta["basename"];
	$extension = $ruta["extension"];

	if ( isset($extension) && !empty($extension)) 
	{
		$extension = "." . $extension;

		// obtener la posicion de la extension
		$position = strpos($nombre_completo, $extension);

		// sacar el nombre del archivo sin extension
		$nombre_sin_extension = substr($archivo, 0, $position);
	}
	else
	{
		$nombre_sin_extension = $nombre_completo;
	}
   $len = strlen($nombre_sin_extension);
   $cadena = '';
   
   for($i = 0; $i < $len; $i++)
   {    $str = substr($nombre_sin_extension,$i,1);
   		if($str!=' ' && $str!='ñ' && $str!='á' && $str!='é' && $str!='í' && $str!='ó' && $str!='ú'&& $str!='Á' && $str!='É' && $str!='Í' && $str!='Ó' && $str!='Ú')
   		{
   			$cadena = $cadena.$str;
   		}
   		
   }
   

	return $cadena.$extension;
}


///////////////////////////////////////////////////////////////////////////////////////////
//	Funciones Veimar (Fin)
///////////////////////////////////////////////////////////////////////////////////////////


/*
**********************************************************
Nombre de la función:	renombrar ( $archivo,$carpeta_archivo )
Propósito:				Se utiliza esta función para copiar 
						srchivos al servidor
Parámetros:				$archivo	-->	Aquí se almacena el nombre del archivo ha ser cambiado
						$carpeta_archivo  --> Aquí se guarda el nombre de la carpeta destino
Valores de Retorno:		$nuevo_nombre	-->	El nuevo nombre del archivo	 
Observación:			-----
Fecha de Creación:		16 - 05 - 05
Versión:				1.0.0
**********************************************************
*/
function renombra_archivo ( $archivo, $carpeta_archivo )
{
	$ruta = pathinfo($archivo);
	$nombre_completo = $ruta["basename"];
	$extension = $ruta["extension"];

	if ( isset($extension) && !empty($extension)) 
	{
		$extension = "." . $extension;

		// obtener la posicion de la extension
		$position = strpos($nombre_completo, $extension);

		// sacar el nombre del archivo sin extension
		$nombre_sin_extension = substr($archivo, 0, $position);
	}
	else
	{
		$nombre_sin_extension = $nombre_completo;
	}

	$n = 0;
	$copia = "";

	while ( file_exists ( $carpeta_archivo . $nombre_sin_extension . $copia . $extension) )
	{
		if ($n<=9)
			$n = "00" . $n;
			
		if ($n<=99 && $n>=10)
			$n = "0" . $n;

		if ($n<=999 && $n>=100)
			$n = "" . $n;

		$copia = "_" . $n;
		$n++;
	}

	return $nombre_sin_extension . $copia . $extension;
}


  
   
   function PreguntaExtencion($archivo)
   {
   	$ext = '';
   	
   	$vari= explode(".",$archivo) ;
    $ext = $vari[1]; 
   	return $ext;
   }



   
   
 
   

   
    
}?>