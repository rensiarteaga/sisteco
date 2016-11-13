<?php
/**
**********************************************************
Nombre de archivo:	    ActionMandarCorrespondencia.php
Prop�sito:				Permite realizar el listado en tfl_correspondencia
Tabla:					tfl_tfl_correspondencia
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Envio de correo para avisar la 
Fecha de Creaci�n:		2011-02-27 10:52:59
Versi�n:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();

$correo = new cls_correo();


$nombre_archivo = 'ActionListarCorrespondencia .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_correspondencia';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if(isset($id_correspondencia)){
		$criterio_filtro.=" and CORREDES.id_correspondencia_fk=$id_correspondencia ";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Correspondencia');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCorrespondenciaMail($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	$direccion = "\http://endesis.ende.bo/sis_flujo/control/correspondencia/arch_adjuntos/";
	
 	if($res){
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f){
// 			var_dump($f);
			$mensaje= '<p>
						Estimado '.$f["desc_empleado_des"].', le comunicamos 
						que tiene un nuevo documento  pendiente de lectura</p> 
						<p>del tipo: <b>"'.$f["desc_documento"].'"</b> con el numero <b> 
						<a href="'.$direccion.$f["url_archivo"].'\">'.$f["numero"].'</a></b>
						y la accion: <b>'.$f["nombre_accion"].'</b><p>
						<br/>
						<p>'.$f["mensaje"].'</p>
						<br/>
						<p>Originado por:</p>';
			
			if($f['tipo']=='interna'){
				$mensaje.= '<p>'.$f["desc_empleado"].'<p>
						<p> de la UO'.$f["desc_uo_origen"].'<p>
			           </p>';
			}else{
				if(strlen($f["desc_empleado"])>1){
					$mensaje.= '<p>'.$f["desc_empleado"].' de la UO: '.$f["desc_uo_origen"].'</p>';
				}
				if(strlen($f["desc_persona"])>1){
					$mensaje.= '<p>'.$f["desc_persona"].'</p>';
				}
				if(strlen($f["desc_institucion"]>1)){
					$mensaje.= '<p>'.$f["desc_institucion"].'</p>';	
				}
				if($f["sw_responsable"]=='si'){
					$mensaje.='<br/>
						<p>Usted ha sido asignado(a) como responsable para esta correspondencia</p>';
					
				}
				if(strlen($f["prioridad"])>1){
					$mensaje.='<br/>
						<p>Importancia: '.$f["prioridad"].'</p>';
					
				}
				if(strlen($f["fecha_max_res"])>1){
					$mensaje.='<br/>
						<p>Fecha limite para responder: '.$f["fecha_max_res"].'</p>';
				}
				
			}
			$var_cor = $correo ->EnviarCorreodeFlujo('endesis@ende.bo',$f["email1"],'FLUJO: '.$f["referencia"],$mensaje,'ENDESIS - SISTEMA DE CORRESPONDENCIA','Tiene nueva correspondencia!');
		}
			//Arma el xml para desplegar el mensaje
			$resp = new cls_manejo_mensajes(false);
		    $resp->add_nodo("mensaje", 'Correo enviado satisfactoriamente');
			$resp->add_nodo("tiempo_resp", "200");
			echo $resp->get_mensaje();
			exit;
		
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

}?>