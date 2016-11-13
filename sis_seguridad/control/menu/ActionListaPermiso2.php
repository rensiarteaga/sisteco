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
*/
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

function listar_arbol($chrama){//
	global $lista_arbol, $html;
	$datos_nietos = array();
	$datos_hijo = array();
	$datos_padre = array();
	$hijos = array();
	$i=0;
	$j=0;

	if(!es_carpeta($chrama)&&es_visible($h)){
		//Obtener datos del padre
		$datos_padre['nombre'] = $chrama['nombre'];
		$datos_padre['nombre_tabla'] = $chrama['nombre_tabla'];
		$datos_padre['prefijo'] = $chrama['prefijo'];

		//Litar Hijos
		$hijos = listar_hijos($chrama);

		//Verificar los nietos
		foreach ($hijos as $h)
		{
			//Verificamos si es una carpeta
			if(!es_carpeta($h)&&es_visible($h))
			{
				$nietos = listar_hijos($h);
				$i=0;
				$j=0;

				if($h['con_interfaz']=='si')
				{
					foreach ($nietos as $n)
					{
						$datos_nietos[$i]['nombre']=$n['nombre'];
						$datos_nietos[$i]['ruta']=$n['ruta'];
						$datos_nietos[$i]['codigo_base']=$n['codigo_base'];
						$i++;
					}
				}

				//Generar los archivos modelo, control y vista
				$datos_hijo[$j]['nombre'] = $h['nombre'];
				$datos_hijo[$j]['ruta'] = $h['ruta'];
				$datos_hijo[$j]['nombre_tabla'] = $h['nombre_tabla'];
				$datos_hijo[$j]['prefijo'] = $h['prefijo'];
				$datos_hijo[$j]['codigo_base'] = $h['codigo_base'];
				$datos_hijo[$j]['tipo_vista'] = $h['tipo_vista'];
				$datos_hijo[$j]['con_ep'] = $h['con_ep'];
				$datos_hijo[$j]['con_vista'] = $h['con_vista'];
				$datos_hijo[$j]['num_datos_hijo'] = $h['num_datos_hijo'];
			}
		}
		
		//Llamada a la función de creación de archivos padre e hijos (mandando arrays datos_padre, datos_hijo, datos_nietos
		
		
	}else{
		$hijos = listar_hijos($chrama);
	}

	//Listamos los hijos de cada nodo y los agregamos al arbol
	foreach ($hijos as $h){
		if (es_carpeta($h)||es_visible($h)){
			if($nodo["id_metaproceso"] != 1) {//en caso de que sea un nodo que es rama
				$html->add_rama($h["nombre"]);
				listar_arbol($h);
				$html->fin_rama();
			}
		}else if (!es_rama($h)){//en caso de que sea un nodo que no es rama
			$html->add_nodo($h["nombre"],$h["ruta_archivo"],"ex");
		}
	}
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
function es_carpeta($mp)
{
	return $mp['nombre_achivo']== "" ? true : false;
}

function es_visible($mp)
{
	return $mp['visible']== "si" ? true : false;
}

?>