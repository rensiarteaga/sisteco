<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarLibroMayorPartida.php
Propósito:				Permite realizar el listado en tct_comprobante
Tabla:					tct_tct_comprobante
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2009-06-15 17:55:38
Versión:				1.0.0
Autor:					AVQ
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarLibroMayorPartida.php';


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

	if($sort == '') $sortcol = 'id_comprobante';
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
	
	//--jgl inicio
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
	
	//--jgl fin
	

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
   $criterio_filtro = $cond -> obtener_criterio_filtro();
	
	
	$id_usuario=$_SESSION["ss_id_usuario"];
	
	function cambiar_a_postgres($fecha){
    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[3];
    return $lafecha;
    }
    $fecha_inicio_b=cambiar_a_postgres($fecha_inicio);
    $fecha_fin_b=cambiar_a_postgres($fecha_fin);
    /*echo "muestra algo".$id_partida;
    exit;*/
	//$criterio_filtro_dos=" COMPROB.fecha_cbte >=''$fecha_inicio_b'' and COMPROB.fecha_cbte <= ''$fecha_fin_b''";
	($ids_financiador) == ""? $ids_financiador="NULL": $ids_financiador;
		(($ids_regional) == "")? $ids_regional="NULL": $ids_regional;
		(($ids_programa) == "")? $ids_programa="NULL": $ids_programa;
		(($ids_proyecto) == "")? $ids_proyecto="NULL": $ids_proyecto;
		(($ids_actividad) == "")? $ids_actividad="NULL": $ids_actividad;
		(($id_presupuesto) == "")? $id_presupuesto="NULL": $id_presupuesto;
		
		 /*AND presup.id_fina_regi_prog_proy_acti  in (select id_ep from param.tpm_depto_ep where id_depto=$id_depto and estado=''activo'') and presup.id_fina_regi_prog_proy_acti in (select aep.id_fina_regi_prog_proy_acti from sss.tsg_usuario_asignacion usa
										inner join sss.tsg_asignacion_estructura ase
                                        on usa.id_asignacion_estructura=ase.id_asignacion_estructura
										inner join sss.tsg_asignacion_estructura_tpm_frppa aep
                                        on aep.id_asignacion_estructura=ase.id_asignacion_estructura
										where usa.id_usuario=$id_usuario)*/
		if($id_presupuesto=='%'){
		$criterio_filtro=$criterio_filtro." AND COMPROB.id_depto like ''$id_depto'' 
											AND COMPROB.id_comprobante IN (select tranpar.id_comprobante 
																		   from tt_tct_transaccion_partida tranpar 
																		   where tranpar.id_fina_regi_prog_proy_acti in (select depep.id_ep 
																														 from param.tpm_depto_ep depep 
																														 where depep.id_depto like ''$id_depto'' 
																														       and depep.estado=''activo'')
										 								  and tranpar.id_fina_regi_prog_proy_acti in (select aep.id_fina_regi_prog_proy_acti 
										 								                                              from sss.tsg_usuario_asignacion usa
																													  inner join sss.tsg_asignacion_estructura ase
                                        																					on usa.id_asignacion_estructura=ase.id_asignacion_estructura
																													  inner join sss.tsg_asignacion_estructura_tpm_frppa aep
                                        																					on aep.id_asignacion_estructura=ase.id_asignacion_estructura
																													  where usa.id_usuario=$id_usuario)) ";
		}else{
			
			$criterio_filtro=$criterio_filtro." AND COMPROB.id_depto like ''$id_depto''  AND COMPROB.id_comprobante IN (select tranpar.id_comprobante from tt_tct_transaccion_partida tranpar where tranpar.id_presupuesto like ''$id_presupuesto'') ";
		}
		
			
		//--jgl inicio
 if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		for($i=0;$i<$nro_columnas;$i++){
			$datosCabecera['valor'][$i]=$_GET["valor_$i"];
			$datosCabecera['columna'][$i]=$_GET["columna_$i"];
			$datosCabecera['align'][$i]=$_GET["align_$i"];
			$datosCabecera['width'][$i]=$_GET["width_$i"];		
		}	
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte($titulo_reporte_excel);
		
		$Excel->SetHoja("Hoja 1 Datos");
		$Excel->SetFila(3);
		$cant=100000000;
		$puntero=0;
		 
		$Excel->SetTitulo($titulo_reporte_excel,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		//$_GET['id_partida'],$_GET['id_moneda'],$_GET['fecha_inicio_b'],$_GET['id_presupuesto']
	//	echo $_GET["id_partida"]." m=".$_GET["id_moneda"]." f=".$fecha_inicio_b." p=".$id_presupuesto."get=".$_GET['fecha_inicio_b'];exit;
//		$res = $Custom->LibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$_GET['id_partida'],$_GET['id_moneda'],$_GET['fecha_inicio_b'],$_GET['id_presupuesto']); 
		$res = $Custom->LibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio_b,$fecha_fin_b,$id_presupuesto);
	 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
		}
	else {
//--jgl fin
		
		
		/*echo 'id_presupuesto'.($id_presupuesto);
	exit;*/
	//Obtiene el total de los registros
	$res = $Custom -> ContarLibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio_b,$fecha_fin_b,$id_presupuesto);
	if($res) $total_registros= $Custom->salida;
//$total_registros=10000;
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->LibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio_b,$fecha_fin_b,$id_presupuesto);
	
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('fecha_cbte',$f["fecha_cbte"]);
			$xml->add_nodo('prefijo',$f["prefijo"]);
			$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
			$xml->add_nodo('concepto_cbte',$f["concepto_cbte"]);
			$xml->add_nodo('tipo_cambio',$f["tipo_cambio"]);
			$xml->add_nodo('importe_gasto',$f["importe_gasto"]);
			$xml->add_nodo('importe_recurso',$f["importe_recurso"]);
			$xml->add_nodo('saldo',$f["saldo"]);
			
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
	//--jgl inicio 
   }
	//--jgl fin
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