<?php
/**
* Nombre de archivo:	    ActionListarPersona.php
* Propósito:				Permite desplegar los registros de los Subtipos de Activos
* Tabla:					tsg_persona
* Parámetros:
* Valores de Retorno:   	Listado de las Personas, y el total de registros listados
* Autor:					Mercedes Zambrana Meneses
* Fecha de Creación:		28-08-2007
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarPersona.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Parámetros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'apellido_paterno';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)¡¡
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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	//Obtiene el total de los registros
	$res = $Custom->ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPersonaFoto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		
		//Verifica si el xml será para llenar un combo o no
		$i=0;
        $directorio_destino="../../control/persona/archivo_base/";
        $nombre_archivo="imagen1.gif";
		foreach ($Custom->salida as $f)
		{   
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_persona', $f["id_persona"]);
			$xml->add_nodo('apellido_paterno', $f["apellido_paterno"]);
			$xml->add_nodo('apellido_materno', $f["apellido_materno"]);
			$xml->add_nodo('nombre', $f["nombre"]);
			$xml->add_nodo('fecha_nacimiento', $f["fecha_nacimiento"]);
			//$xml->add_nodo('foto_persona', $f["foto_persona"]);
			$xml->add_nodo('doc_id', $f["doc_id"]);
			$xml->add_nodo('genero', $f["genero"]);
			$xml->add_nodo('casilla', $f["casilla"]);
			$xml->add_nodo('telefono1', $f["telefono1"]);
			$xml->add_nodo('telefono2', $f["telefono2"]);
			$xml->add_nodo('celular1', $f["celular1"]);
			$xml->add_nodo('celular2', $f["celular2"]);
			$xml->add_nodo('pag_web', $f["pag_web"]);
			$xml->add_nodo('email1', $f["email1"]);
			$xml->add_nodo('email2', $f["email2"]);
			$xml->add_nodo('email3', $f["email3"]);
			$xml->add_nodo('fecha_registro', $f["fecha_registro"]);
			$xml->add_nodo('hora_registro', $f["hora_registro"]);
			$xml->add_nodo('fecha_ultima_modificacion', $f["fecha_ultima_modificacion"]);
			$xml->add_nodo('hora_ultima_modificacion', $f["hora_ultima_modificacion"]);
			$xml->add_nodo('observaciones', $f["observaciones"]);
			$xml->add_nodo('id_tipo_doc_identificacion', $f["id_tipo_doc_identificacion"]);
			
			$xml->add_nodo('desc_tipo_doc_identificacion', $f["desc_tipo_doc_identificacion"]);
			
			$xml->add_nodo('desc_completonombre', $f["desc_completonombre"]);
			$xml->add_nodo('nombre_tipo_documento', $f["nombre_tipo_documento"]);
			$i=$i+1;
			if (substr($f["foto_persona"],0,1)==""){
			            $xml->add_nodo('foto_persona','no existe foto');
			}else{
				//echo "entra aqui?";
		       $im = imagecreatefromstring(pg_unescape_bytea($f["foto_persona"]));
        		if ($im !== false) {
            		header('Content-Type: image/gif');
            		imagegif($im,'archivo/imagen'.$f["id_persona"].'.gif');
            		$xml->add_nodo('foto_persona','existe foto');
                    $xml->add_nodo('url','imagen'.$f["id_persona"].'.gif');
             
        		}
       			else {
          			echo 'Ocurrio un error';
       			}		
			}
		  $xml->fin_rama();
			
		}
		$xml->mostrar_xml();
		//header('HTTP/1.0 200 OK');
		//header('Content-Type:text/xml');
		//echo $xml -> cadena_xml();
		//exit;
		
		
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,"406");
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
		
	}
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}


?>