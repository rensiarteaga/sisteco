<?php
/**
**********************************************************
Nombre de archivo:	ActionListaPermiso.php
Propósito:			Permite desplegar los permisos asignados a un usuario
Tabla:				tsg_metaproceso
Parámetros:			$cant
					$puntero
					$sortcol
					$sortdir
					$criterio_filtro
					$id_usuario_asignacion

Valores de Retorno:    	Listado de Permisos para el usuario
Fecha de Creación:		08 - 06 - 07
Versión:				2.0.0
Autor:					Enzo Rojas					
**********************************************************
**/
session_start();
include_once("../../control/LibModeloSeguridad.php");
$CustomSeguridad = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListaPermiso.php';
$lista_arbol = array();
$html = new cls_manejo_arbol('Sistema ENDESIS','bienvenida.php');// PREPARA EL Archivo de menu

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Obtiene la lista de permisos para el id_usuario, si existe caso contrario la funcion devolvera un error
	//echo "Variables: ".$_SESSION["ss_id_usuario"]."    ip: ".$_SESSION["ss_ip"]."   mac: ".$_SESSION["ss_mac"];
//	$res = $CustomSeguridad->ListaPermiso($_SESSION["ss_id_usuario"],$_SESSION["ss_ip"],$_SESSION["ss_mac"]);
	$res = $CustomSeguridad->ListaPermiso($_SESSION["ss_id_usuario"],$_SESSION["ss_id_rol"],$_SESSION["ss_ip"],$_SESSION["ss_mac"]);	
	
	//echo "res: ".$CustomSeguridad->salida[0][0]." == ";
	if($CustomSeguridad->salida[0][0] != f)
	{ 
		//echo "ingreso";
		global $lista_arbol;
		$lista_arbol = $CustomSeguridad->salida;
		$aux = current($lista_arbol);		
		listar_arbol($aux);		
		
		echo $html->cadena_html();
	}
	else
	{			
		//Se produjo un error		
		$resp = new cls_manejo_mensajes(true, " 406");
		$resp->mensaje_error = $CustomSeguridad->salida[1];
		$resp->origen = $CustomSeguridad->salida[2];
		$resp->proc = $CustomSeguridad->salida[3];
		$resp->nivel = $CustomSeguridad->salida[4];
		$resp->query = $CustomSeguridad->salida[4];
		echo $resp->get_mensaje();
		exit;
	}
	
}
else
{
	$resp = new cls_manejo_mensajes(true, " 401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}

function listar_arbol($chrama){
	global $lista_arbol, $html;
	$hijos = listar_hijos($chrama);
	$nodo;
	
	//listamos los hijos de cada nodo y los agregamos al arbol
	foreach ($hijos as $h){
		$nodo = $h;				
		if (es_rama($nodo)){//en caso de que sea un nodo que es rama
			if($nodo["id_metaproceso"] != 1) {
				$html->add_rama($nodo["nombre"]);
				listar_arbol($nodo);	
				$html->fin_rama();	
			}
		}else if (!es_rama($nodo)){//en caso de que sea un nodo que no es rama
			$html->add_nodo($nodo["nombre"],$nodo["ruta_archivo"],"ex");
		}
	}		
	
	
/*
	//VERSION ANTERIOR
	unset($srama);
   	unset($snodo);	
	//guardamos en el arreglo $srama los nodos rama y en $snodo los nodos que no son rama.
	foreach ($hijos as $h){
		if(es_rama($h)){
			$srama[] = $h;
			//echo "rama: ".$h["nombre"];			
		}else if (!es_rama($h)){
			$snodo[] = $h;
			//echo " nodo: ".$h["nombre"];
		}		
	}
	
	//listamos los nodos ramas
	if(is_array($srama)) {
		sort($srama);
		reset($srama);
						
		foreach ($srama as $y){
			if($y["id_metaproceso"] != 1){
				$html->add_rama($y["nombre"]);
				listar_arbol($y);	
				$html->fin_rama();
			}			
		}
	}
	
	//listamos los nodos que no son rama
	if(is_array($snodo)) {
		//sort($snodo,SORT_LOCALE_STRING);
		reset($snodo);
				
		foreach ($snodo as $y){			
			$html->add_nodo($y["nombre"],$y["ruta_archivo"],"ex");			
		}		
	}	*/
}

function listar_hijos($rama){
	global $CustomSeguridad;
	$id_rama = $rama['id_metaproceso'];	
	$nivel_hijo = $rama['nivel']+1;	
	$vector = array();	
	//echo "<br><b>papa: ".$rama["nombre"]." id: ".$id_rama."</b>";
	reset($CustomSeguridad->salida);		
	foreach ($CustomSeguridad->salida as $r){		
		if ($r["fk_id_metaproceso"] == $id_rama && $r["nivel"] == $nivel_hijo && $r["visible"] == "si"){
			//echo "<br>hijo: ".$r["nombre"];			
			array_push($vector,$r);
		}
	}	
	return $vector;
}

function ordenar_logicamente($matriz){
	next($matriz);
//	echo "::::".$matriz["orden_logico"];
}
function es_rama($mp){	
	return $mp['nombre_achivo']== "" ? true : false;
}


?>