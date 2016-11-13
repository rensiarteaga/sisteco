<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarEmpleadoPlanilla.php
Prop�sito:				Permite realizar el listado en tkp_empleado_planilla
Tabla:					tkp_tkp_empleado_planilla
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2010-08-23 11:07:48
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarEmpleadoPlanillaDinamica.php';

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

	if($sort == '') $sortcol = 'id_empleado_planilla';
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
	

	$cc = explode(',',substr($defStore, 1, -1));
	
	//echo $defStore; exit;
	//$cc = json_decode($defStore) ;
	
	//echo var_dump($cc);
	//exit;
	//echo $defStore; exit;
	//$cc = json_decode($defStore) ;
		
	
	


	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	
	//$cond->add_criterio_extra("id_planilla",$id_planilla);
	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'EmpleadoPlanilla');
	//$sortcol = $crit_sort->get_criterio_sort();
	if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		for($i=0;$i<$nro_columnas;$i++){
			$datosCabecera['valor'][$i]=$_GET["valor_$i"];
			$datosCabecera['columna'][$i]=$_GET["columna_$i"];
			$datosCabecera['align'][$i]=$_GET["align_$i"];
			$datosCabecera['width'][$i]=$_GET["width_$i"];		
		}	
		
		//$cond->add_criterio_extra("COLUMNA.id_tipo_planilla",$id_tipo_planilla);
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte($titulo_reporte_excel);
		//echo $titulo_reporte_excel; exit();
		$Excel->SetHoja("Hoja 1 Datos");
		$Excel->SetFila(3);
		$cant=100000000;
		$puntero=0;
		//$sortcol='id_columna';
		// if($_SESSION["ss_id_usuario"]==120){ echo "llega".$desc_periodo; exit; }
		$Excel->SetTitulo('Planilla de Sueldos '.$desc_periodo.'/'.$gestion ,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		
		$res = $Custom->ListarEmpleadoPlanillaDinamica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_planilla,$id_tipo_planilla,$cc);
															
		 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
	}else{

			//Obtiene el total de los registros
			$res = $Custom -> ContarEmpleadoPlanillaDinamica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_planilla,$id_tipo_planilla,$cc);
		
			if($res) $total_registros= $Custom->salida;
		
				//Obtiene el conjunto de datos de la consulta
				$res = $Custom->ListarEmpleadoPlanillaDinamica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_planilla,$id_tipo_planilla,$cc);
				//print_r($Custom->salida); exit;
				if($res)
				{ 
					$xml = new cls_manejo_xml('ROOT');
					$xml->add_nodo('TotalCount',$total_registros);
			
					foreach ($Custom->salida as $f)
					{
						$xml->add_rama('ROWS');
						$xml->add_nodo('id_empleado_planilla',$f["id_empleado_planilla"]);
					//	$xml->add_nodo('id_empleado',$f["id_empleado"]);
						$xml->add_nodo('nombre_completo',$f["nombre_completo"]);
						
						
							for ($i=2 ; $i< count($cc); $i++){
								
						    	$xml->add_nodo($cc[$i],$f[$cc[$i]]);
								$xml->add_nodo('visible_'.$cc[$i],$f["visible_".$cc[$i]]);
							}
					//	visible_id_1
			
			
						$xml->fin_rama();
					}
					/*if($_SESSION['ss_id_usuario']==120){
						var_dump($xml); exit;
					}*/
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