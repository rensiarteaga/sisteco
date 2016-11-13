<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSaldosBancariosPeriodo.php
Propósito:				Permite realizar el listado en 
Fecha de Creación:		2011-05-31 08:54:29
Versión:				1.0.0
Autor:					José Mita
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');
//include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarSaldosBancariosPeriodo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'periodo';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
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
	if (sizeof($_GET) > 0){
	 
		$CantFiltros=$_GET["CantFiltros"];
		$nro_columnas=$_GET["nro_columnas"];		
		$titulo_reporte_excel=$_GET["titulo_reporte_excel"];		
		$get=true;
	}
	if (sizeof($_POST) > 0){
		$CantFiltros=$_POST["CantFiltros"];
		$nro_columnas=$_POST["nro_columnas"];	
		$titulo_reporte_excel=$_POST["titulo_reporte_excel"];		
		$get=false;
	}
	
	for($i=0;$i<$CantFiltros;$i++){ 		
		$cond->add_condicion_filtro($_GET["filterCol_$i"], $_GET["filterValue_$i"], $_GET["filterAvanzado_$i"]);
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	
	 /*if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		for($i=0;$i<$nro_columnas;$i++){
			$datosCabecera['valor'][$i]=$_GET["valor_$i"];
			$datosCabecera['columna'][$i]=$_GET["columna_$i"];
			$datosCabecera['align'][$i]=$_GET["align_$i"];
			$datosCabecera['width'][$i]=$_GET["width_$i"];		
		}	
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte($titulo_reporte_excel);
		//echo $titulo_reporte_excel; exit();
		$Excel->SetHoja("Hoja 1 Datos");
		$Excel->SetFila(3);
		$cant=100000000;
		$puntero=0;
	 
		$Excel->SetTitulo($titulo_reporte_excel,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		 
		$res = $Custom->ListarSaldosBancariosPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_GET['ids_depto'],$_GET['id_moneda'],$_GET['ct_fecha'],$_GET['id_reporte_eeff'], $_GET['id_parametro'],$_GET['nivel'],$_GET['ids_periodo'],$_GET['sw_actualizacion']);
		 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
		}*/
//	else { 

			if ($_POST['ids_ctaban']=='') $_POST['ids_ctaban']=0;
			if ($_POST['ids_periodo']=='') $_POST['ids_periodo']=0;
				 //Obtiene el total de los registros
				 $res = $Custom -> ContarSaldosBancariosPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_POST['ids_ctaban'],$_POST['id_moneda'],$_POST['ct_fecha'],$_POST['id_reporte_eeff'], $_POST['id_parametro'],$_POST['nivel'],$_POST['ids_periodo'],$_POST['sw_actualizacion']);
				  //echo  $Custom->query; exit(); 
				 	//$res=true;
					if($res) $total_registros= $Custom->salida;
				//echo $total_registros;exit;
					/*echo $ids_fuente_financiamiento;
					exit();*/
			//Obtiene el conjunto de datos de la consulta
					$res = $Custom->ListarSaldosBancariosPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_POST['ids_ctaban'],$_POST['id_moneda'],$_POST['ct_fecha'],$_POST['id_reporte_eeff'], $_POST['id_parametro'],$_POST['nivel'],$_POST['ids_periodo'],$_POST['sw_actualizacion']);
					//echo  $Custom->query; exit();
					if($res)
					{	$contador=0;
						$xml = new cls_manejo_xml('ROOT');
						$xml->add_nodo('TotalCount',$total_registros);
						 
						foreach ($Custom->salida as $f)
						{
							$xml->add_rama('ROWS');
						if ($f["periodo"]==1){$f["periodo"]= 'ENERO';}
						if ($f["periodo"]==2){$f["periodo"]= 'FEBRERO';}
						if ($f["periodo"]==3){$f["periodo"]= 'MARZO';}
						if ($f["periodo"]==4){$f["periodo"]= 'ABRIL';}
						if ($f["periodo"]==5){$f["periodo"]= 'MAYO';}
						if ($f["periodo"]==6){$f["periodo"]= 'JUNIO';}
						if ($f["periodo"]==7){$f["periodo"]= 'JULIO';}
						if ($f["periodo"]==8){$f["periodo"]= 'AGOSTO';}
						if ($f["periodo"]==9){$f["periodo"]= 'SEPTIEMBRE';}
						if ($f["periodo"]==10){$f["periodo"]= 'OCTUBRE';}
						if ($f["periodo"]==11){$f["periodo"]= 'NOVIEMBRE';}
						if ($f["periodo"]==12){$f["periodo"]= 'DICIEMBRE';}
								$xml->add_nodo('id_reporte',$f["id_reporte"]);
								$xml->add_nodo('nombre_auxiliar',$f["nombre_auxiliar"]);
								$xml->add_nodo('periodo',$f["periodo"]);
								$xml->add_nodo('ingreso',$f["ingreso"]);
								$xml->add_nodo('egreso',$f["egreso"]);
								$xml->add_nodo('saldo',$f["saldo"]);
								$xml->add_nodo('saldo_acumulado',$f["saldo_acumulado"]);
								$xml->fin_rama();
						$contador++;
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
	//}
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
