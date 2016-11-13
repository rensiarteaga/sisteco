<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCorrespondencia.php
Propósito:				Permite realizar el listado en tfl_correspondencia
Tabla:					tfl_tfl_correspondencia
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2011-02-11 10:52:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once(dirname(__FILE__).'../../../modelo/cls_DBCorrespondencia.php');
include_once(dirname(__FILE__).'../../../modelo/cls_DBAdjunto.php');

include_once("../../lib/lib_general/cls_funciones.php");
include_once("../../lib/lib_modelo/cls_middle.php");
include_once("../../lib/lib_modelo/cls_conexion.php");
include_once("../../lib/lib_control/cls_manejo_xml.php");
include_once("../../lib/lib_control/cls_manejo_mensajes.php");
include_once("../../lib/lib_control/cls_criterio_filtro.php");
include_once("../../lib/lib_control/cls_criterio_sort.php");

$Custom = new cls_DBCorrespondencia();
$Custom1 = new cls_DBAdjunto();
$nombre_archivo = 'ActionListarCorrespondenciaENDE.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}

if($_SESSION['autentificado']=='SI')
{
	if (sizeof($_GET) > 0){
		$get=true; $post=false;
	}
	elseif(sizeof($_POST) > 0){
		$get=false; $post=true;
	
	}
	else{
		$get=false; $post=false;
	}
	
	
	if($get){
		$fecha_ini=$_GET["fecha_ini"];
		$fecha_fin=$_GET["fecha_fin"];
		$id_archivada=1;
	
	}elseif($post){
		$fecha_ini=$_POST["fecha_ini"];
		$fecha_fin=$_POST["fecha_fin"];
		$id_archivada=1;
	} else{
		$id_archivada=0;
	}
	
	
	$cond = new cls_criterio_filtro(true);
	
	if(isset($id_archivada) && $id_archivada!=0){
		$criterio_filtro.=" and to_date(corre.fecha_reg,''YYYY-mm-dd'') >= ''$fecha_ini'' and to_date(corre.fecha_reg,''YYYY-mm-dd'') <=''$fecha_fin'' and corre.archivo_externo is null ";
	}else {
		$criterio_filtro.=" and 0=0";
	}
	
	
	
	if($_POST["id_archivada"]==235){
		$criterio_filtro=' and CORRE.id_correspondencia_fk=215 ';
	}
	
	$res = $Custom->ListarCorrespondenciaENDE($criterio_filtro);
		
		if($res)
		{
			$xml = new cls_manejo_xml('ROOT');
			//$xml->add_nodo('TotalCount',1);
	
			foreach ($Custom->salida as $f)
			{
				$xml->add_rama('CorrespondenciaEnde');
				$xml->add_nodo('CodigoCorrespondencia',$f["codigo"]);
				$xml->add_nodo('NumeroCorrespondencia',$f["numero_correspondencia"]);
				$xml->add_nodo('CodigoTipoDocumento',$f["codigo_tipo_documento"]);
				$xml->add_nodo('DescripcionTipoDocumento',$f["descripcion_tipo_documento"]);
				$xml->add_nodo('TipoCorrespondencia',$f["tipo_correspondencia"]);
				$xml->add_nodo('NombreTipoCorrespondencia',$f["nombre_tipo_correspondencia"]);
				$xml->add_nodo('CodigoInstitucion',$f["codigo_institucion"]);
				$xml->add_nodo('NombreInstitucion',$f["nombre_institucion"]);
				$xml->add_nodo('Referencia',$f["referencia"]);
				$xml->add_nodo('Descripcion',$f["descripcion|"]);
				$xml->add_nodo('Emisor',$f["emisor"]);
				$xml->add_nodo('NombreEmisor',$f["nombre_emisor"]);
				$xml->add_nodo('Receptor',$f["receptor"]);
				$xml->add_nodo('NombreReceptor',$f["nombre_receptor"]);
				$xml->add_nodo('FechaRecepcion',$f["fecha_recepcion"]);
				$xml->add_nodo('CantidadHojas',$f["cantidad_hojas"]);
				$xml->add_nodo('NombreArchivo',$f["nombre_archivo"]);
				if($f["tiene_adj"]==1){
					$res1 = $Custom1 -> ListarAdjuntoENDE($f["codigo"]);

							if($res1){
							//$xml1 = new cls_manejo_xml('ROOT');
							$xml->add_rama('Adjunto');
							foreach ($Custom1->salida as $f1){// echo $f1["nombre_doc"]; exit;
								$xml->add_rama('AdjuntoItem');
								$xml->add_nodo('DescripcionAdjunto',$f1["nombre_doc"]);
								$xml->add_nodo('UrlAdjunto',$f1["nombre_arch"]);
								$xml->fin_rama();
							}
							}else{$xml->add_rama('Adjunto');
								$xml->add_rama('AdjuntoItem');
								$xml->add_nodo('DescripcionAdjunto',"");
								$xml->add_nodo('UrlAdjunto',"");
								$xml->fin_rama();
								$xml->fin_rama();
							//$xml->mostrar_xml();
						}
						$xml->fin_rama();
				}else{$xml->add_rama('Adjunto');
					$xml->add_rama('AdjuntoItem');
					$xml->add_nodo('DescripcionAdjunto',"");
					$xml->add_nodo('UrlAdjunto',"");
					$xml->fin_rama();
					$xml->fin_rama();
			}
			
				
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
		else
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true,'406');
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