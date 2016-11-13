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
include_once("cls_Arbol.php");
include_once("../../lib/lib_control/cls_manejo_arbol.php");
include_once("../cls_generar_codigo.php");

$CustomSeguridad = new cls_Arbol();
$varGenerador = new cls_generar_codigo('almacenes');

$nombre_archivo = 'ActionGenerarArbol.php';
$lista_arbol = array();
$html = new cls_manejo_arbol('Sistema ENDESIS','bienvenida.php');// PREPARA EL Archivo de menu

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Obtiene la lista de permisos para el id_usuario, si existe caso contrario la funcion devolvera un error
	$res = $CustomSeguridad->ListaPermiso($_SESSION["ss_id_usuario"],$_SESSION["ss_id_rol"],$_SESSION["ss_ip"],$_SESSION["ss_mac"]);


	//echo "res: ".$CustomSeguridad->salida[0][0]." == ";
	if($CustomSeguridad->salida[0][0] != f)
	{
		//echo "ingreso";
		global $lista_arbol;
		$lista_arbol = $CustomSeguridad->salida;
		$abuelo = array();

		$aux = current($lista_arbol);
		listar_arbol($aux, $abuelo);

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

function listar_arbol($chrama, $abuelo)
{
	global $lista_arbol, $html;
	global $varGenerador;
	//$datos_nietos = array();

	$datos_hijo = array();
	$datos_padre = array();
	$datos_abuelo = array();
	$hijos = array();
	$i=0;
	$j=0;

	$datos_abuelo['nombre'] = $abuelo['nombre'];
	$datos_abuelo['nombre_tabla'] = $abuelo['nombre_tabla'];
	$datos_abuelo['ruta_archivo'] = $abuelo['ruta_archivo'];
	$datos_abuelo['num_datos_hijo'] = $abuelo['num_datos_hijo'];

	if(!es_carpeta($chrama)&&es_visible($chrama)){
		//Obtener datos del padre
		$datos_padre['nombre'] = $chrama['nombre'];
		$datos_padre['nombre_tabla'] = $chrama['nombre_tabla'];
		$datos_padre['ruta_archivo'] = $chrama['ruta_archivo'];
		$datos_padre['prefijo'] = $chrama['prefijo'];
		$datos_padre['codigo_base'] = $chrama['codigo_base'];
		$datos_padre['tipo_vista'] = $chrama['tipo_vista'];
		$datos_padre['con_ep'] = $chrama['con_ep'];
		$datos_padre['con_interfaz'] = $chrama['con_interfaz'];
		$datos_padre['num_datos_hijo'] = $chrama['num_datos_hijo'];

		//Litar Hijos
		$hijos = listar_hijos($chrama);

		//Verificar los nietos
		$j=0;
		foreach ($hijos as $h)
		{
			$i=0;
			//Verificamos si es una carpeta
			if(!es_carpeta($h)&&es_visible($h))
			{
				//$nietos = listar_hijos($h);

				/*if($h['con_interfaz']=='si')
				{
				foreach ($nietos as $n)
				{
				$datos_nietos[$i]['nombre']=$n['nombre'];
				$datos_nietos[$i]['ruta']=$n['ruta'];
				$datos_nietos[$i]['codigo_base']=$n['codigo_base'];
				$i++;
				}
				}*/

				//Generar los archivos modelo, control y vista
				$datos_hijo[$j]['nombre'] = $h['nombre'];
				$datos_hijo[$j]['ruta_archivo'] = $h['ruta_archivo'];
				$datos_hijo[$j]['nombre_tabla'] = $h['nombre_tabla'];
				$datos_hijo[$j]['prefijo'] = $h['prefijo'];
				$datos_hijo[$j]['codigo_base'] = $h['codigo_base'];
				$datos_hijo[$j]['tipo_vista'] = $h['tipo_vista'];
				$datos_hijo[$j]['con_ep'] = $h['con_ep'];
				$datos_hijo[$j]['con_interfaz'] = $h['con_interfaz'];
				$datos_hijo[$j]['num_datos_hijo'] = $h['num_datos_hijo'];

				//Aumenta datos del hijo en el vector del padre
				$datos_padre['datos_hijo']= $datos_hijo;
				$datos_padre['datos_abuelo']=$datos_abuelo;

				$j++;
			}
		}
				
		$varGenerador->generar($datos_padre);
		//Llamada a la función de creación de archivos padre e hijos (mandando arrays datos_padre, datos_hijo, datos_nietos

		echo "=========================== ABUELO =========================";
		print("<pre>");
		print_r($datos_abuelo);
		print("</pre>");
		echo "*************************** PADRE *************************";
		//print('Padre');
		print("<pre>");
		print_r($datos_padre);
		print("</pre>");
		echo "*************************** HIJOS *************************";
		//print('<br>Hijos');
		print("<pre>");
		print_r($datos_hijo);
		print("</pre>");


	}
	else
	{
		$hijos = listar_hijos($chrama);
	}

	//Listamos los hijos de cada nodo y los agregamos al arbol
	foreach ($hijos as $h)
	{
		if (es_carpeta($h)||es_visible($h))
		{
			if($nodo["id_metaproceso"] != 1)
			{	//en caso de que sea un nodo que es rama
				$html->add_rama($h["nombre"]);
				listar_arbol($h, $chrama);
				$html->fin_rama();
			}
		}
		else if (!es_rama($h))
		{	//en caso de que sea un nodo que no es rama
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

	foreach ($CustomSeguridad->salida as $r)
	{
		//if ($r["fk_id_metaproceso"] == $id_rama && $r["nivel"] == $nivel_hijo && $r["visible"] == "si"){
		if ($r["fk_id_metaproceso"] == $id_rama && $r["nivel"] == $nivel_hijo && $r["con_interfaz"] == "si")
		{	//echo "<br>hijos: ".$r["nombre"];
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
	return $mp['con_interfaz']== "si" ? true : false;
}

?>