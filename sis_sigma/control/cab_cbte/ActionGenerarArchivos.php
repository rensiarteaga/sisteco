<?php
/**
 * Nombre de la Clase:	ActionGenerarArchivos.php
 * Propósito:			crea archivos entregables SIGMA
 * Autor:				Rensi Arteaga Copari
 * Fecha creación:		16-06-2010
*/
session_start();
include_once('../LibModeloSigma.php');

$Custom = new cls_CustomDBSigma();
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
	
	///////////////////GENERA RECCAB/////////////
	$res = $Custom->ListarRECCAB(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Carga los valores para la creaciï¿½n de los archivos
		$gestion=substr($Custom->salida[0]['gestion'],2,2);
		$mes=$Custom->salida[0]['mes_cadena'];
		$entidad=$Custom->salida[0]['entidad'];
		
		//echo 'mes->'.$mes;exit;
		
		//Concatena todos los valores para el prefijo del nombre de los arhivos
		$ruta.=$gestion.$mes.'_0'.$entidad.'_';
		
		//Forma el nombre del archivo
		$nomArch[0]=$ruta."reccab.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[0],"w");

		foreach ($Custom->salida as $f){
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
	}else{
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

	///////////////////GENERA GTOCAB/////////////
	$res = $Custom->ListarGTOCAB(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[1]=$ruta."gtocab.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[1],"w");

		foreach ($Custom->salida as $f){
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
	}else{
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
	
	///////////////////GENERA RECDET/////////////
	$res = $Custom->ListarRECDET(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[2]=$ruta."recdet.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[2],"w");

		foreach ($Custom->salida as $f){
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
	}else{
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
	
	///////////////////GENERA RECANX/////////////
	$res = $Custom->ListarRECANX(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[3]=$ruta."recanx.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[3],"w");
		
		foreach ($Custom->salida as $f){
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
	}else{
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
		
	//////////////////GENERA GTODET/////////////
	$res = $Custom->ListarGTODET(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[4]=$ruta."gtodet.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[4],"w");
		
		foreach ($Custom->salida as $f){
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
	}else{
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
	
	///////////////////GENERA GTOANX/////////////
	$res = $Custom->ListarGTOANX(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[5]=$ruta."gtoanx.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[5],"w");
		
		foreach ($Custom->salida as $f){
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
	}else{
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
	
	///////////////////GENERA MODCAB/////////////
	$res = $Custom->ListarMODCAB(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[6]=$ruta."modcab.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[6],"w");

		foreach ($Custom->salida as $f){
			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["mes"]."|");
			fwrite($fp,$f["entidad"]."|"); 
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["docmod_nro"]."|");
			fwrite($fp,$f["docmod_tipo"]."|");
			fwrite($fp,$f["docmod_fecha"]."|");
			fwrite($fp,$f["docdis_tipo"]."|");
			fwrite($fp,$f["docdis_nro"]."|");
			fwrite($fp,$f["docdis_fecha"]."|");
			fwrite($fp,"\r\n");
		}
		fclose($fp);	
	}else{
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
	
	//////////////////GENERA MODDET/////////////
	$res = $Custom->ListarMODDET(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[7]=$ruta."moddet.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[7],"w");
		
		foreach ($Custom->salida as $f){
			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["mes"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["docmod_nro"]."|");
			fwrite($fp,$f["tipo_reg"]."|");	
			fwrite($fp,$f["programa"]."|");
			fwrite($fp,$f["proyecto"]."|");
			fwrite($fp,$f["actividad"]."|");		
			fwrite($fp,$f["fuente"]."|");
			fwrite($fp,$f["organismo"]."|");
			fwrite($fp,$f["objeto"]."|");
			fwrite($fp,$f["ent_trf"]."|");
			fwrite($fp,$f["finalidad"]."|");
			fwrite($fp,$f["tipo_inv"]."|");
			fwrite($fp,$f["importe"]."|");
		    
			fwrite($fp,"\r\n");
		}
		fclose($fp);
	}else{
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
	
	//////////////////GENERA PPTINI/////////////
	$res = $Custom->ListarPPTINI(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[8]=$ruta."pptini.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[8],"w");
		
		foreach ($Custom->salida as $f){
			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["tipo_reg"]."|");	
			fwrite($fp,$f["programa"]."|");
			fwrite($fp,$f["proyecto"]."|");
			fwrite($fp,$f["actividad"]."|");		
			fwrite($fp,$f["fuente"]."|");
			fwrite($fp,$f["organismo"]."|");
			fwrite($fp,$f["objeto"]."|");
			fwrite($fp,$f["ent_trf"]."|");
			fwrite($fp,$f["finalidad"]."|");
			fwrite($fp,$f["tipo_inv"]."|");
			fwrite($fp,$f["importe"]."|");
		    
			fwrite($fp,"\r\n");
		}
		fclose($fp);
	}else{
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
	
	//////////////////GENERA DIRADM/////////////
	$res = $Custom->ListarDIRADM(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[9]=$ruta."diradm.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[9],"w");
		
		foreach ($Custom->salida as $f){
			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["finalidad"]."|");	
		    
			fwrite($fp,"\r\n");
		}
		fclose($fp);
	}else{
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
	
	//////////////////GENERA PPTINI/////////////
	$res = $Custom->ListarAPEPRO(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[10]=$ruta."apepro.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[10],"w");
		
		foreach ($Custom->salida as $f){
			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["dir_adm"]."|");
			fwrite($fp,$f["programa"]."|");
			fwrite($fp,$f["proyecto"]."|");
			fwrite($fp,$f["actividad"]."|");		
			fwrite($fp,$f["descripcion"]."|");
			fwrite($fp,$f["sector_economico"]."|");
			fwrite($fp,$f["subsector_economico"]."|");
			fwrite($fp,$f["activ_eco"]."|");
			fwrite($fp,$f["departamento"]."|");
			fwrite($fp,$f["provincia"]."|");
			fwrite($fp,$f["seccion_mun"]."|");
		    fwrite($fp,$f["codigo_sisin"]."|");	
		    fwrite($fp,$f["pnd"]."|");	
		    
			fwrite($fp,"\r\n");
		}
		fclose($fp);
	}else{
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
	
	//////////////////GENERA CONTRL/////////////
	$res = $Custom->ListarCONTRL(0,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		//Forma el nombre del archivo
		$nomArch[11]=$ruta."contrl.txt";

		//Abre el archivo en modo de escritura
		$fp=fopen($nomArch[11],"w");
		
		foreach ($Custom->salida as $f){
			fwrite($fp,$f["gestion"]."|");
			fwrite($fp,$f["entidad"]."|");
			fwrite($fp,$f["periodo"]."|");	
			fwrite($fp,$f["archivo"]."|");	
			fwrite($fp,$f["nroreg"]."|");	
		    
			fwrite($fp,"\r\n");
		}
		fclose($fp);
	}else{
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
}else{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}
?>