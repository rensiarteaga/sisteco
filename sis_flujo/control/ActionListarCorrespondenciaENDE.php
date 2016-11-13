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
include_once('../LibModeloFlujo.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarCorrespondencia .php';

	$res = $Custom->ListarCorrespondenciaENDE($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$vista);
		
		if($res)
		{
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);
	
			foreach ($Custom->salida as $f)
			{
				$xml->add_rama('ROWS');
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
	

?>