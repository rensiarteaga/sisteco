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

function carga_archivo ( $archivo, $directorio_destino )
{
	// Revisa si el archivo es de mas de 5 megabytes.
	if ( $archivo['size'] < 5512000 )
	{
		$nombre_archivo = basename ( $archivo['name'] ) ;
	    $nombre_archivo = $this -> limpiar($nombre_archivo);
		
		$archivo_destino = $directorio_destino . $nombre_archivo;

		if ( move_uploaded_file ($archivo['tmp_name'], $archivo_destino) )
		{
		    //""move_uploaded_file"" funcion que no funciona en este servidor
		    rename($archivo_destino,$directorio_destino."fv_lec_proce.txt" );
			return $nombre_archivo;
			chmod($directorio_destino."fv_lec_proce.txt",0777);
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
   
   function eliminarespeciales($variable)
	{
		$res=str_replace("\'","'",$variable);
		return $res;
		
	}
	
	/*///////////////////////////////////////////////////
//Convierte fecha de mysql a normal
////////////////////////////////////////////////////*/
/*///////////////////////////////////////////////////
//Convierte fecha de postgre a normal
////////////////////////////////////////////////////*/
function fecha_normal($fecha){
    ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[2]."/".$mifecha[1]."/".$mifecha[3];
    if ($lafecha=="//" || $lafecha=="00/00/0000")
    {
    	$lafecha="";
    }    
    return $lafecha;    
}

function fecha_normal2($fecha){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    if ($lafecha=="//" || $lafecha=="00/00/0000")
    {
    	$lafecha="";
    }    
    return $lafecha;    
}


////////////////////////////////////////////////////
//Convierte fecha de normal a mysql
////////////////////////////////////////////////////

function fecha_mysql($fecha){
    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
} 
function fecha_pgsql($fecha){
    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}
function fecha_jpgraph($fecha){
	
	setlocale(LC_TIME, 'es_ES');
	setlocale(LC_TIME, 'es_MX');

	return strftime('%d de %B del %Y',strtotime($fecha));
}


}?>