<?php
/**
**********************************************************
Nombre de archivo:	ActionListaPermiso.php
Propósito:			Recorrer y obetner informacion recursivamente de la tabla tsg_metaproceso para generar codigo automaticamente
Tabla:				tsg_metaproceso
Parámetros:			$nodo  --> A partir del cual se obtine la informacion

Valores de Retorno:    	Array con informacion del 'nodo', su nodo padre, y los hijos del 'nodo'
Fecha de Creación:		04 - 10 - 07
Versión:				2.0.0
Autor:					Enzo Rojas					
**********************************************************
*/
session_start();

include_once("../cls_generar_codigo.php");
include_once("../../lib/lib_control/cls_manejo_arbol.php");
include_once("cls_Arbol.php");

$varArbol = new cls_Arbol();
$cont_padres=0;
$cont_hijos=0;

//$nodoInicio = strtolower($nodoInicio);
echo "Nodo inicio: ".$nodoInicio."<br>";
echo "Id Subsistema: ".$idSubSistema."<br>";
$varGenerador = new cls_generar_codigo();
$nombre_archivo = 'ActionGenerarArbol.php';
$lista_arbol = array();
/*$html = new cls_manejo_arbol('Sistema ENDESIS','bienvenida.php');*/



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado'] != "SINO"){
	//Obtiene la lista de nodos del arbol
	$res = $varArbol->ListarNodos($_SESSION["ss_id_usuario"],$_SESSION["ss_id_rol"],$_SESSION["ss_ip"],$_SESSION["ss_mac"]);
	//$res = $varArbol->ListarHijos($nodoInicio,$idSubSistema);

	if($varArbol->salida[0][0] != f){
		global $lista_arbol;
		$lista_arbol = $varArbol->salida;
		$abuelo = array();
		$auxNodoInicio = ubicar_nodo($lista_arbol);
		//Se llama a la funcion que recorre el arbol a partir del NodoInicio
		listar_arbol($auxNodoInicio, $abuelo);
		
		echo "********************************************<br>";
		echo "TOTAL NODOS PADRE: ".$cont_padres."<br>";
		echo "TOTAL NODOS HIJO: ".$cont_hijos."<br>";

		/*echo $html->cadena_html();*/
	}else{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, " 406");
		$resp->mensaje_error = $varArbol->salida[1];
		$resp->origen = $varArbol->salida[2];
		$resp->proc = $varArbol->salida[3];
		$resp->nivel = $varArbol->salida[4];
		$resp->query = $varArbol->salida[4];
		echo $resp->get_mensaje();
		exit;
	}
 
}
else
{
	echo "<b>ERROR: Sesion no iniciada.</b>";
}

function listar_arbol($chrama, $abuelo){
	global $lista_arbol, $html;
	global $varGenerador;
	global $cont_hijos;
	global $cont_padres;

	$datos_padre = array();
	$datos_hijo = array();
	$datos_abuelo = array();
	$hijos = array();
	$i=0;
	$j=0;

	$datos_abuelo['nombre'] = $abuelo['nombre'];
	$datos_abuelo['nombre_tabla'] = $abuelo['nombre_tabla'];
	$datos_abuelo['ruta_archivo'] = $abuelo['ruta_archivo'];
	$datos_abuelo['num_datos_hijo'] = $abuelo['num_datos_hijo'];
	$datos_abuelo['prefijo'] = $abuelo['prefijo'];
	$datos_abuelo['codigo_base'] = $abuelo['codigo_base'];

	if(!es_carpeta($chrama) && es_visible($chrama)){
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

		//Listar Hijos
		$hijos = listar_hijos($chrama);
		$j=0;

		//Obtenemos informacion de los hijos
		foreach ($hijos as $h){
			$i=0;
			//Verificamos si es una carpeta
			if(!es_carpeta($h)&&es_visible($h)){
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
				$datos_padre['datos_hijos']= $datos_hijo;
				

				$j++;
			}
		}
		$datos_padre['datos_abuelo']=$datos_abuelo;
		if($j > 0){
			echo "NODO PADRE:".$datos_padre['nombre']."     HIJOS: ".$j;
			$cont_hijos++;
		}

		//Llamada a la función de creación de archivos padre e hijos (mandando arrays datos_padre, su padre(abuelo) y datos_hijo
		$varGenerador->generar($datos_padre);
		$cont_padres++;		

		/*echo "=========================== ABUELO =========================";
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
		print("</pre>");*/
	}
	else
	{
		$hijos = listar_hijos($chrama);
	}
	/*echo "<pre>";
	print_r($hijos);
	echo "</pre>";*/

	//Listamos los hijos de cada nodo y los agregamos al arbol
	foreach ($hijos as $h)
	{
		if (es_carpeta($h)||es_visible($h))
		{
			if($nodo["id_metaproceso"] != 1){
				//en caso de que sea un nodo que tenga hijos se llama denuevo a listar_arbol
				/*$html->add_rama($h["nombre"]);*/
				listar_arbol($h, $chrama);
				/*$html->fin_rama();*/
			}
		}
		/*else if (!es_carpeta($h))
		{	//en caso de que sea un nodo que no es rama
		$html->add_nodo($h["nombre"],$h["ruta_archivo"],"ex");
		}*/
	}
}

function listar_hijos($rama){
	global $varArbol;
	$id_rama = $rama['id_metaproceso'];
	$nivel_hijo = $rama['nivel']+1;
	$nodos_hijo = array();

	//echo "<br>papa: <b>".$rama["nombre"]."</b>  id: <b>".$id_rama."</b>";
	reset($varArbol->salida);

	foreach ($varArbol->salida as $r){
		//if ($r["fk_id_metaproceso"] == $id_rama && $r["nivel"] == $nivel_hijo && $r["visible"] == "si"){
		if ($r["fk_id_metaproceso"] == $id_rama && $r["nivel"] == $nivel_hijo /*&& $r["con_interfaz"] == "si"*/){
			echo "<br>hijos: ".$r["nombre"];
			array_push($nodos_hijo,$r);
		}
	}

	return $nodos_hijo;
}

function ubicar_nodo($arbol){
	global $idSubSistema;
	global $nodoInicio;
	$nodo = array();

	foreach ($arbol as $a){
		if ($a["id_subsistema"] == $idSubSistema && $a["nombre"] == $nodoInicio ){
			$nodo = $a;
		}
	}

	return $nodo;
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