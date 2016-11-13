<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUnidadOrganizacional.php
Propósito:				Permite realizar el listado en tkp_unidad_organizacional
Tabla:					t_tkp_unidad_organizacional
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-12 09:24:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionListarUnidadOrganizacional .php';

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

	if($sort == '') $sortcol = 'id_unidad_organizacional';
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
	
	
	//$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Verifica si se manda la cantidad de filtros
	
	
	$res = $Custom->ListarUnidadOrganizacionalCentro($id_empleado);
	
	if($res)
	{ 
	   if($Custom->salida!='' && $Custom->salida!= null){  
	   $total_registros=1;
	  
	   //llamada para obtencion de fecha_bd 
	   $var = new cls_middle("f_pm_get_fecha_bd","");
	   $var->exec_function();
	   $salida = $var->salida;
	   $fecha = $salida[0][0];//devuelve yyyy-mm-dd
	   $fecha_sep = explode('-',$fecha);
	   $fecha = $fecha_sep[2]."/".$fecha_sep[1]."/".$fecha_sep[0];
	   
	  
		    
	}else{
	   	$total_registros=0;
	}

	 include_once('../../../sis_adquisiciones/control/LibModeloAdquisiciones.php');
     $CustomAdq= new cls_CustomDBAdquisiciones();
	        $xml = new cls_manejo_xml('ROOT');
		    $xml->add_nodo('TotalCount',$total_registros);
 			$var1= split('###',$Custom->salida);
 			$xml->add_rama('ROWS');
			$xml->add_nodo('centro',$var1[0]);
			$xml->add_nodo('id_unidad_organizacional',$var1[1]);
			$xml->add_nodo('id_uo_gerencia',$var1[2]);
			$xml->add_nodo('fecha', $fecha);
			
			
			$criterio_filtro=" lower(TIPADQ.tipo_adq)=''bien''";
	        $res_item= $CustomAdq->ListarTipoAdq(1,0,'id_tipo_adq','asc',$criterio_filtro,null,null,null,null,null);
	         if($res_item){
	          foreach ($CustomAdq->salida as $f){
	                     
			     $xml->add_nodo('nombre',$f["nombre"]);
			     $xml->add_nodo('id_tipo_adq',$f["id_tipo_adq"]);
		      }
		  }

            $separa = explode('/',$fecha);
            $gestion= $separa[2];



		   $var_adq = new cls_middle("f_tad_obtener_gestion_adq"," " );
	   	   $var_adq->add_param($_SESSION["ss_id_empresa"]);//id_empresa
	       $var_adq->add_param($gestion);
	       $var_adq->exec_function();
	       $salida_adq = $var_adq->salida;
	     
	   	   $cad_adq = $salida_adq[0][0];//devuelve yyyy-mm-dd
	       $cadena_adq=split('###',$cad_adq);
		   $fecha_sep_adq = explode('-',$cadena_adq[1]);
	       $fecha_adq = $fecha_sep_adq[2]."/".$fecha_sep_adq[1]."/".$fecha_sep_adq[0];
	       $fecha_ini_sep_adq= explode('-',$cadena_adq[3]);
	       $fecha_ini_adq=$fecha_ini_sep_adq[2]."/".$fecha_ini_sep_adq[1]."/".$fecha_ini_sep_adq[0];
		
	       $fecha_fin_sep_adq= explode('-',$cadena_adq[4]);
	       $fecha_fin_adq=$fecha_fin_sep_adq[2]."/".$fecha_fin_sep_adq[1]."/".$fecha_fin_sep_adq[0];
	       $total_adq=0;
		      
		
		if($fecha_adq!=''){
		    if($salida_adq[0][0]=='00/00/00'){
		      $total_adq=0;
		    }else{
		      $total_adq=1;
		    }
		}
		
		if($cadena_adq[2]=='congelado'){
			$hora='08:30:00';    
		}else{
			$var_hora = new cls_middle("f_pm_get_hora_bd","");
	        $var_hora->exec_function();
	        $salida_hora = $var_hora->salida;
	        $hora = $salida_hora[0][0];
	        $fecha_sep = explode('.',$hora);
	        $hora= $fecha_sep[0];
        }
		
       
        
		     $xml->add_nodo('total_adq', $total_adq);
		     $xml->add_nodo('gestion', $cadena_adq[0]);
		     $xml->add_nodo('fecha', $fecha_adq);
		     $xml->add_nodo('estado', $cadena_adq[2]);
		     $xml->add_nodo('fecha_fin', $fecha_fin_adq);
		     $xml->add_nodo('fecha_ini', $fecha_ini_adq);
		     $xml->add_nodo('id_moneda',$cadena_adq[5]);
		     $xml->add_nodo('nombre_moneda',$cadena_adq[6]);
		     $xml->add_nodo('id_parametro_adq',$cadena_adq[7]);
			 $xml->add_nodo('hora',$hora);
			$xml->fin_rama();
		
		$xml->mostrar_xml();;	
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