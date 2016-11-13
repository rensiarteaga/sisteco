<?php
session_start();
$nombre_archivo = "ActionGuardarDescripcionTabla.php";

include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();

		
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
	$concatenado_tabla=array();
	$concatenado_tabla="";
	$concatenado_campo=array();
	$contador=1;
	
	if($get){        
	    $tabla= trim($_GET["txt_tabla_0"]);
		$prefijo=trim($_GET["txt_prefijo_0"]);
	}
	else {
		$tabla= trim($_POST["txt_tabla_0"]);
		$prefijo=trim($_POST["txt_prefijo_0"]);
	}
	$nombre_tabla=trim($tabla);
	
	for($j = 0;$j < $cont; $j++)
	{ $concatenado_campo="";
		if ($get)
		{
			$nombre= trim($_GET["txt_nombre_$j"]);
			$label= trim($_GET["txt_label_$j"]);
			$grid_visible= trim($_GET["txt_grid_visible_$j"]);
			$grid_editable= trim($_GET["txt_grid_editable_$j"]);
			
			$disabled= trim($_GET["txt_disabled_$j"]);
			$width_grid= trim($_GET["txt_width_grid_$j"]);
			$width= trim($_GET["txt_width_$j"]);
			
			$filtro= trim($_GET["txt_filtro_$j"]);
			$defecto= trim($_GET["txt_defecto_$j"]);
			$dt= trim($_GET["txt_dt_$j"]);
			$desc= trim($_GET["txt_desc_$j"]);
			$desc= trim($_GET["txt_desc_$j"]);
			$desc_tabla= trim($_GET["txt_desc_tabla_$j"]);
			
		}
		else
		{
			$nombre= trim($_POST["txt_nombre_$j"]);
			$label= trim($_POST["txt_label_$j"]);
			$grid_visible= trim($_POST["txt_grid_visible_$j"]);
			$grid_editable= trim($_POST["txt_grid_editable_$j"]);
			
			$disabled= trim($_POST["txt_disabled_$j"]);
			$width_grid= trim($_POST["txt_width_grid_$j"]);
			$width= trim($_POST["txt_width_$j"]);
			
			$filtro= trim($_POST["txt_filtro_$j"]);
			$defecto= trim($_POST["txt_defecto_$j"]);
			$dt= trim($_POST["txt_dt_$j"]);
			$desc= trim($_POST["txt_desc_$j"]);
			$desc_tabla= trim($_POST["txt_desc_tabla_$j"]);
			
			
		}
		
		if($dt=='true'){	//verificacion para campos descriptivos que iran en la descripcion de la tabla	
		   $concatenado_tabla=$concatenado_tabla."&dt_".$contador."=".$nombre;
		   $contador=$contador+1;
		}
		
		if($grid_visible=='true'){
			$concatenado_campo=$concatenado_campo."nombre=".$nombre."&label=".$label."&grid_visible=".$grid_visible."&grid_editable=".$grid_editable."&disabled=".$disabled."&width_grid=".$width_grid."&width=".$width."&filtro=".$filtro."&defecto=".$defecto;
		}
		else{
			$concatenado_campo=$concatenado_campo."nombre=".$nombre."&label=".$label."&grid_visible=".$grid_visible."&grid_editable=".$grid_editable."&disabled=".$disabled."&width_grid=".$width_grid."&width=".$width."&filtro=".$filtro."&defecto=".$defecto;
		}
		if(strlen($desc)>0){
			$concatenado_campo=$concatenado_campo."&desc=".$desc;
		}
		
		$concatenado_campo= str_replace('true','si',$concatenado_campo);
		$concatenado_campo=str_replace('false','no',$concatenado_campo);
		
		
		
		//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_metaproceso
			$res = $Custom -> InsertarDescCol($nombre_tabla,$nombre,$concatenado_campo);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		

	}//END FOR
	
	$desc_tabla=str_replace('##','&',$desc_tabla);
	$desc_tabla=str_replace('||','=',$desc_tabla);
	
	
	$ini=strpos($desc_tabla,'num_dt=');
	if($ini>-1){
		
		$fin=strpos($desc_tabla,'&',$ini+1);
		$cadena=substr($desc_tabla,$ini,$fin-$ini+1);
		$desc_tabla=str_replace($cadena,'',$desc_tabla);
		while(strpos($desc_tabla,'&dt_')>-1){
			
			$ini=strpos($desc_tabla,'&dt_');
			$fin=strlen($desc_tabla)-1;
			if(strpos($desc_tabla,'&',$ini+1)>-1)
			{	$fin=strpos($desc_tabla,'&',$ini+1);
			}
			
			$cadena=substr($desc_tabla,$ini,$fin-$ini);
			$desc_tabla=str_replace($cadena,'',$desc_tabla);
			
		}
		
		
	}
	
	if(trim(strlen($concatenado_tabla))>0){
	  $concatenado_tabla="&num_dt=".($contador-1).$concatenado_tabla;
	}
	
	$desc_tabla=$desc_tabla.$concatenado_tabla;
	
		$res=$Custom->InsertarDescTabla($nombre_tabla,$desc_tabla);
		
		if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
	
	
	/****///-------------

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 0) {$mensaje_exito = $Custom->salida[1];
		$resp = new cls_manejo_mensajes(false);
		$resp->add_nodo("mensaje",$mensaje_exito);
		$resp->add_nodo("tiempo_resp", "200");
		$resp->add_nodo("TotalCount", "0");
		echo $resp->get_mensaje();
		exit;}

	
	
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