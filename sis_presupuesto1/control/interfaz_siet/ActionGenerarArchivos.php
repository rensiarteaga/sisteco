<?php
/**
 * Nombre de la Clase:	ActionGenerarArchivos.php
 * Propósito:			crea archivos entregables SIET
 * Autor:				avq
 * Fecha creación:		01/01/2015
*/
session_start();
include_once('../LibModeloPresupuesto.php');
$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionGenerarArchivos.php';

//Variables para creación y nombramiento de los archivos
$ruta='../archivos/';
$nomArch=array();
$gestion='';
$mes='';
$entidad='';
$sw=0;


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	//Parï¿½metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;
	
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	$cond->add_criterio_extra("c.id_declaracion",$m_id_declaracion);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
		///////////////////GENERA GTOCAB/////////////

	$res = $Custom->ListarSietDeclaraRepTxt(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_siet_declara);

	if($res)
	{
		//Forma el nombre del archivo
		$nomArch[1]=$ruta."gtocab.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[1],"w");

		foreach ($Custom->salida as $f)
		{
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["mes"]."|");
			fwrite($fp,$f["tipo"]."|");
			fwrite($fp,$f["nro_documento"]."|");
			fwrite($fp,$f["fecha"]."|");
			fwrite($fp,$f["partida"]."|");
			fwrite($fp,$f["oec"]."|");
			fwrite($fp,$f["glosa"]."|");
			fwrite($fp,$f["cuenta_bancaria"]."|");
			fwrite($fp,$f["auxiliar"]."|");
			fwrite($fp,$f["cheque"]."|");
			fwrite($fp,$f["importe"]."|");
			fwrite($fp,"\r\n");
		}


		fclose($fp);


	}
	else
	{
		//Se produjo un error
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',1);
		$xml->add_rama('ROWS');
		$xml->add_nodo('error',1);
		$xml->add_nodo('mensaje_error',$Custom->salida[1]);
		$xml->add_nodo('origen',$Custom->salida[2]);
		$xml->add_nodo('proc',$Custom->salida[3]);
		$xml->add_nodo('nivel',$Custom->salida[4]);
		$xml->add_nodo('query',$Custom->query);
		$xml->fin_rama();
		$xml->mostrar_xml();
		exit;
	}
	
		
	//Comprime los archivos en un solo archivo
	//$date = new DateTime();
	$arch_comp='../archivos/'.$m_id_declaracion.'-ejecucion_presup.tar';
	$comprimir="tar cf $arch_comp";
	foreach ($nomArch as $row) {
		$comprimir.=' '.$row;
	}
	
	$del="rm -f";
	foreach ($nomArch as $row) {
		$del.=' '.$row;
	}
	
	//echo 'comprimir:'.$comprimir.'->'.'del:'.$del;exit;
	
	//Elimina el archivo comprimido si existiera
	exec("rm -f $arch_comp");
	//Comprime
	exec($comprimir);
	//Eimina los archivos
	exec($del);
	
	
	//Respuesta
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('error',0);
	$xml->add_nodo('mensaje','Archivos generados.');
	$xml->fin_rama();
	$xml->mostrar_xml();
	
	

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