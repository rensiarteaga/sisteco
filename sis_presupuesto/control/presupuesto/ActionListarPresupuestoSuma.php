<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarFormulacionPresupuesto.php
Propósito:				Permite realizar el listado en tpr_presupuesto
Tabla:					tpr_tpr_presupuesto
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-10 09:08:14
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/

session_start();
include_once('../LibModeloPresupuesto.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarPresupuestoSuma.php';

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

	if($sort == '') $sortcol = 'nombre_unidad';
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
	if (sizeof($_GET) > 0)
	{
	 
		$CantFiltros=$_GET["CantFiltros"];
		$nro_columnas=$_GET["nro_columnas"];		
		$titulo_reporte_excel=$_GET["titulo_reporte_excel"];		
		$get=true;
	}
	if (sizeof($_POST) > 0)
	{
		$CantFiltros=$_POST["CantFiltros"];
		$nro_columnas=$_POST["nro_columnas"];	
		$titulo_reporte_excel=$_POST["titulo_reporte_excel"];		
		$get=false;
	}
	
	for($i=0;$i<$CantFiltros;$i++)
	{ 		
		$cond->add_condicion_filtro($_GET["filterCol_$i"], $_GET["filterValue_$i"], $_GET["filterAvanzado_$i"]);
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}	
	//--jgl fin	
	
	
	
	/*if($m_id_gestion)
	{		
		$cond->add_criterio_extra("PARAMP.id_gestion",$m_id_gestion);
	}*/
	
		
	if($estado_pres==2){
		$cond->add_criterio_extra("PRESUP.estado_pres",$estado_pres);
	}
	

		if ($sw_reg_comp=='si'&& $m_id_fuente_financiamiento&& $m_id_unidad_organizacional&& $m_id_epe)
		{
		 	$cond->add_criterio_extra("PRESUP.id_fuente_financiamiento",$m_id_fuente_financiamiento);
		 	$cond->add_criterio_extra("PRESUP.id_unidad_organizacional",$m_id_unidad_organizacional);
		 	$cond->add_criterio_extra("PRESUP.id_fina_regi_prog_proy_acti",$m_id_epe);
		 	$cond->add_criterio_extra("PARAMP.id_gestion",$m_id_gestion);
		 	
		 	if ($m_sw_ingreso=='si')		 
		 	{
		 		$cond->add_criterio_extra("PRESUP.tipo_pres",1);//1
		 	}	 	
		}		
		
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();	
	
	//filtramos por gestion
	if($m_id_gestion)
	{
	    $criterio_filtro=$criterio_filtro." AND PARAMP.id_gestion=".$m_id_gestion;	
	}
	else 
	{
	    $criterio_filtro=$criterio_filtro." AND PARAMP.gestion_pres=(select max(PARAMP.gestion_pres) from presto.tpr_parametro PARAMP) ";	
	}
	
	//filtramos por tipo de presupuesto
	if($s_tipo_pres==1)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.tipo_pres in(1,4) ";		
	}
	
	if($s_tipo_pres==2)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.tipo_pres in(2,5) ";		
	}
	
	if($s_tipo_pres==3)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.tipo_pres in(3,6) ";		
	}
	
	//Fitramos por estado de presupuesto
	if($estado_pres==1)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.estado_pres in(1,2) ";		
	}
	
	if($estado_pres==3)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.estado_pres in(1,2,3,4,5) ";		
	}
	
	if($estado_pres==4)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.estado_pres in(3,4) ";		
	}
	
	if($m_sw_ingreso=='no')
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.tipo_pres in(3,2) ";		
	}	
	
	/*if ($sw_colectivo==-1)
	{ 
		$criterio_filtro=$criterio_filtro." and PRESUP.id_concepto_colectivo is null";		
	}*/
	
	if($sw_colectivo==1&&$sw_colectivo==1)
	{	
		$criterio_filtro=$criterio_filtro." and CONCOL.id_concepto_colectivo in( select id_concepto_colectivo from presto.tpr_concepto_colectivo where id_usuario=".$_SESSION["ss_id_usuario"].") ";
		
	}
	else
	{
		if ($sw_colectivo==1)
		{
			$criterio_filtro=$criterio_filtro." and PRESUP.id_concepto_colectivo >0";			
		}
		if ($sw_usuario==1)
		{
			$criterio_filtro=$criterio_filtro." and UNIORG.id_unidad_organizacional in (
                            select id_unidad_organizacional from presto.tpr_usuario_autorizado where estado=''Activo'' and id_usuario=".$_SESSION["ss_id_usuario"].")   "; 
		}
	}
		
	$criterio_filtro2=$criterio_filtro;
	$criterio_filtro=$criterio_filtro."  and COALESCE(PARDET.id_moneda,".$id_moneda.")=".$id_moneda." ";
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Presupuesto');
	$sortcol = $crit_sort->get_criterio_sort();
	
	

	
	//--Grover Excel inicio
	if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		for($i=0;$i<$nro_columnas;$i++)
		{
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
	
		$res = $Custom->ListarPresupuestoSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
	}
	else 
	{	

				//Obtiene el total de los registros
				//$res = $Custom -> ContarFormulacionPresupuesto($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro2,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
				$res = $Custom -> ContarPresupuestoSuma($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro2,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

				if($res) $total_registros= $Custom->salida;

				//Obtiene el conjunto de datos de la consulta
				$res = $Custom->ListarPresupuestoSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
				
				//echo var_dump($Custom); exit;
				
				if($res)
				{
					$xml = new cls_manejo_xml('ROOT');
					$xml->add_nodo('TotalCount',$total_registros);

					foreach ($Custom->salida as $f)
					{
						$xml->add_rama('ROWS');
						$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
						$xml->add_nodo('tipo_pres',$f["tipo_pres"]);
						$xml->add_nodo('estado_pres',$f["estado_pres"]);
						$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
						$xml->add_nodo('desc_fina_regi_prog_proy_acti',$f["desc_fina_regi_prog_proy_acti"]);
						$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
						$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
						$xml->add_nodo('id_fuente_financiamiento',$f["id_fuente_financiamiento"]);
						$xml->add_nodo('denominacion',$f["denominacion"]);
						$xml->add_nodo('id_parametro',$f["id_parametro"]);
						$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
						$xml->add_nodo('id_financiador',$f["id_financiador"]);
						$xml->add_nodo('id_regional',$f["id_regional"]);
						$xml->add_nodo('id_programa',$f["id_programa"]);
						$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
						$xml->add_nodo('id_actividad',$f["id_actividad"]);
						$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
						$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
						$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
						$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
						$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
						$xml->add_nodo('codigo_financiador',$f["codigo_financiador"]);
						$xml->add_nodo('codigo_regional',$f["codigo_regional"]);
						$xml->add_nodo('codigo_programa',$f["codigo_programa"]);
						$xml->add_nodo('codigo_proyecto',$f["codigo_proyecto"]);
						$xml->add_nodo('codigo_actividad',$f["codigo_actividad"]);
						$xml->add_nodo('id_concepto_colectivo',$f["id_concepto_colectivo"]);
						$xml->add_nodo('desc_colectivo',$f["desc_colectivo"]);
						//$xml->add_nodo('total',$f["total"]);
						$xml->add_nodo('total',number_format($f["total"],0,'','.'));	
						$xml->add_nodo('id_moneda',$f["id_moneda"]);
						$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
						
						$xml->add_nodo('cod_programa',$f["cod_programa"]);
						$xml->add_nodo('cod_proyecto',$f["cod_proyecto"]);
						$xml->add_nodo('cod_actividad',$f["cod_actividad"]);
						$xml->add_nodo('cod_organismo_financiador',$f["cod_organismo_financiador"]);
						$xml->add_nodo('cod_fuente_financiamiento',$f["cod_fuente_financiamiento"]); 
						$xml->add_nodo('cod_categoria_prog',$f["cod_categoria_prog"]);
					
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
				
				
	}  //Grover Excel Fin
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