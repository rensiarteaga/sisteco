<?php
/**
 * Nombre de la Clase:	ActionGenerarArquicivosSigma.php
 * Propósito:			crea archivos entregables SIGMA
 * Autor:				Rensi Arteaga Copari
 * Fecha creación:		16-06-2010
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarGestionarRegistroTransacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;


	///////////////////GENERA RACCAB/////////////

	$res = $Custom->ListarRECCAB(0,0,'','','0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$fp=fopen("../../sigma/reccab.txt","w");

		foreach ($Custom->salida as $f)
		{

			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["mes"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["nro_comp"]."|");
			fwrite($fp,$f["devengado"]."|");
			fwrite($fp,$f["percibido"]."|");
			fwrite($fp,$f["operacion"]."|");
			fwrite($fp,$f["comp_orig"]."|");
			fwrite($fp,date("dmY",strtotime($f["fecha_aprobacion"]))."|");


			fwrite($fp,"\r\n");
		}


		fclose($fp);


		$date = new DateTime();
		echo "RECCAB ...      ".$date->format("D\, d M Y H:i:s O")."<br>";
		
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

	///////////////////GENERA GTOCAB/////////////


	$res = $Custom->ListarGTOCAB(0,0,'','','0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$fp=fopen("../../sigma/gtocab.txt","w");

		foreach ($Custom->salida as $f)
		{

			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["mes"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["nro_comp"]."|");
			fwrite($fp,$f["compromiso"]."|");
			fwrite($fp,$f["devengado"]."|");
			fwrite($fp,$f["pago"]."|");
			fwrite($fp,$f["operacion"]."|");
			fwrite($fp,$f["comp_orig"]."|");
			fwrite($fp,$f["tipo_mov"]."|");
			fwrite($fp,$f["tipo_pago"]."|");
			fwrite($fp,date("dmY",strtotime($f["fecha_aprobacion"]))."|");






			fwrite($fp,"\r\n");
		}


		fclose($fp);


		$date = new DateTime();
		echo "GTOCAB ...      ".$date->format("D\, d M Y H:i:s O")."<br>";

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
	
	
	///////////////////GENERA RECDET/////////////


	$res = $Custom->ListarRECDET(0,0,'','','0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$fp=fopen("../../sigma/recdet.txt","w");

		foreach ($Custom->salida as $f)
		{

			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["mes"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["nro_comp"]."|");			
			fwrite($fp,$f["fuente"]."|");
			fwrite($fp,$f["organismo"]."|");
			fwrite($fp,$f["rubro"]."|");
			fwrite($fp,$f["ent_trf"]."|");
			fwrite($fp,$f["oec"]."|");
			fwrite($fp,$f["banco"]."|");
			fwrite($fp,$f["cuenta"]."|");
			fwrite($fp,$f["libreta"]."|");
			fwrite($fp,$f["importe"]."|");
		    
			fwrite($fp,"\r\n");
		}


		fclose($fp);


		$date = new DateTime();
		echo "RECDET ...      ".$date->format("D\, d M Y H:i:s O")."<br>";

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
	
	
		///////////////////GENERA RECANX/////////////


	$res = $Custom->ListarRECANX(0,0,'','','0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$fp=fopen("../../sigma/recanx.txt","w");

		foreach ($Custom->salida as $f)
		{

			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["mes"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["nro_comp"]."|");						
			fwrite($fp,$f["tipo_dato"]."|");
			fwrite($fp,$f["rub_cta"]."|");
			fwrite($fp,$f["importe"]."|");
		
			fwrite($fp,"\r\n");
			
		}

		fclose($fp);

		$date = new DateTime();
		
		echo "RECANX ...      ".$date->format("D\, d M Y H:i:s O")."<br>";

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
	

	
	//////////////////GENERA GTODET/////////////

	


	$res = $Custom->ListarGTODET(0,0,'','','0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$fp=fopen("../../sigma/gtodet.txt","w");

		foreach ($Custom->salida as $f)
		{

			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["mes"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["nro_comp"]."|");	
			fwrite($fp,$f["programa"]."|");
			fwrite($fp,$f["proyecto"]."|");
			fwrite($fp,$f["actividad"]."|");		
			fwrite($fp,$f["fuente"]."|");
			fwrite($fp,$f["organismo"]."|");
			fwrite($fp,$f["objeto"]."|");
			fwrite($fp,$f["ent_trf"]."|");
			fwrite($fp,$f["oec"]."|");
			fwrite($fp,$f["banco"]."|");
			fwrite($fp,$f["cuenta"]."|");
			fwrite($fp,$f["libreta"]."|");
			fwrite($fp,$f["importe"]."|");
		    
			fwrite($fp,"\r\n");
			
			
		}


		fclose($fp);


		$date = new DateTime();
		echo "GTODET ...      ".$date->format("D\, d M Y H:i:s O")."<br>";

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
	
	
	///////////////////GENERA GTOANX/////////////


	$res = $Custom->ListarGTOANX(0,0,'','','0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$fp=fopen("../../sigma/gtoanx.txt","w");

		foreach ($Custom->salida as $f)
		{

			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["mes"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["nro_comp"]."|");						
			fwrite($fp,$f["tipo_dato"]."|");
			fwrite($fp,$f["obj_cta"]."|");
			fwrite($fp,$f["importe"]."|");
		
			fwrite($fp,"\r\n");
			
		}

		fclose($fp);

		$date = new DateTime();
		
		echo "GTOANX ...      ".$date->format("D\, d M Y H:i:s O")."<br>";

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