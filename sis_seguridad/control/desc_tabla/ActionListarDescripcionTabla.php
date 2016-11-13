<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarAsignacionEstructuraTpmFrppa.php
Propósito:				Permite desplegar Hist Clave
Tabla:					tsg_asignacion_estructura_tpm_frppa
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_finar_regi_prog_proy_acti_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		31-08-2007
Versión:				1.0.0
Autor:					Grover Velasquez Colque
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarDescripciónTabla.php';
$desc_tabla="";

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

	if($sort == "") $sortcol = 'a.attname';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;

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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond->obtener_criterio_filtro();

	
	

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDescCol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tabla);
	
	if($res)
	{	$propiedades=array();
		$total_registros=count($Custom->salida)-1;
		$desc_tabla=$Custom->salida[0]['descripcion'];
		$desc_tabla_mejorado=str_replace("&","##",$desc_tabla);
		$desc_tabla_mejorado=str_replace("=","||",$desc_tabla_mejorado);
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			if($f["nombre"]!=$tabla){
				$propiedades=getPropiedades($f["descripcion"],$desc_tabla,$f["nombre"]);
				$xml->add_rama('ROWS');
				$xml->add_nodo('nombre', $f["nombre"]);
				$xml->add_nodo('label', $propiedades[0]);
				$xml->add_nodo('grid_visible', $propiedades[1]);
				$xml->add_nodo('grid_editable', $propiedades[2]);
				$xml->add_nodo('form', $propiedades[3]);
				$xml->add_nodo('disabled', $propiedades[4]);
				$xml->add_nodo('width_grid', $propiedades[5]);
				$xml->add_nodo('width', $propiedades[6]);
				$xml->add_nodo('grid_indice', $propiedades[7]);
				$xml->add_nodo('filtro', $propiedades[8]);
				$xml->add_nodo('defecto', $propiedades[9]);
				$xml->add_nodo('dt', $propiedades[10]);
				$xml->add_nodo('desc', $propiedades[11]);
				$xml->add_nodo('habilitado', $propiedades[12]);
				$xml->add_nodo('prefijo', $prefijo);
				$xml->add_nodo('tabla', $tabla);
				$xml->add_nodo('desc_tabla', $desc_tabla_mejorado);
				$xml->fin_rama();
			}
			
			
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
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
function getPropiedades($desc,$desc_t,$atri){
	$prop=array();
	$split=split("&",$desc);
	$split2=split("&",$desc_t);
	array_push($prop,existe($split,'label'));//
	array_push($prop,existe($split,'grid_visible'));
	array_push($prop,existe($split,'grid_editable'));
	array_push($prop,existe($split,'form'));
	array_push($prop,existe($split,'disable'));
	array_push($prop,existe($split,'width_grid'));//
	array_push($prop,existe($split,'width'));//
	array_push($prop,existe($split,'grid_indice'));//
	array_push($prop,existe($split,'filtro'));
	array_push($prop,existe($split,'defecto'));//
	array_push($prop,descriptivo($desc_t,$atri));
	array_push($prop,existe($split,'desc'));//
	array_push($prop,existe($split,'habilitado'));
	
	
	return $prop;
	
}
function existe($arreglo,$propiedad){
	if($propiedad=='label'||$propiedad=='width_grid'||$propiedad=='width'||$propiedad=='grid_indice'||$propiedad=='defecto'||$propiedad=='desc'){
		$res="";
	}
	elseif($propiedad=="disable"){
		$res="false";
	}
	else{
		if($propiedad=='grid_editable'){
			$res="false";
		}
		else{
			$res="true";
		}
	}
	foreach($arreglo as $a){
		
		if(strpos($a,$propiedad)>-1){
			$split=split("=",$a);
			
			$res=$split[1];
			if($res=='si'){
				$res="true";
			}
			else if($res=='no'){
				$res="false";
			}
			
		
		}
	}
	return $res;
}
function descriptivo($descri,$campo_busca){
		$res="false";
		
		$campo_busca=trim($campo_busca);
		
		$split=split("&",$descri);
		foreach($split as $s){
			if(strpos($s,$campo_busca)>-1){
				
				$split1=split("=",$s);
				
				if(strpos($split1[0],"dt_")>-1 && strpos($split1[1],$campo_busca)>-1){
					
					$res="true";
				}

			}
		}
		return $res;	
}

?>
