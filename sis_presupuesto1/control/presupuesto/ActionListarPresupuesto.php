<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarFormulacionPresupuesto.php
Prop�sito:				Permite realizar el listado en tpr_presupuesto
Tabla:					tpr_tpr_presupuesto
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2008-07-10 09:08:14
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

/*echo 'llega';
exit();*/

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarPresupuesto.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}

if($_SESSION['autentificado']=='SI')
{
	//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 10;
	else $puntero = $start;

	if($sort == '') $sortcol = 'nombre_unidad';
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
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	//Aumentado para filtrar por id_presupuesto
	$cond->add_criterio_extra("PRESUP.id_presupuesto",$id_presupuesto);
	
	if($sw_reporte_ejecucion!='si')
	{		
		//$cond->add_criterio_extra("PRESUP.tipo_pres",$tipo_pres);	
	}	
		
	if($estado_pres!=1)
	{
		$cond->add_criterio_extra("PRESUP.estado_pres",$estado_pres);}
		//$cond->add_criterio_extra("PRESUP.estado_gral",$estado_gral);

		if ($sw_reg_comp=='si'&& $m_id_fuente_financiamiento&& $m_id_unidad_organizacional&& $m_id_epe)
		{
		 	$cond->add_criterio_extra("PRESUP.id_fuente_financiamiento",$m_id_fuente_financiamiento);
		 	$cond->add_criterio_extra("PRESUP.id_unidad_organizacional",$m_id_unidad_organizacional);
		 	$cond->add_criterio_extra("PRESUP.id_fina_regi_prog_proy_acti",$m_id_epe);
		 	$cond->add_criterio_extra("PRESUP.id_gestion",$m_id_gestion);
		 	
		 	if ($m_sw_ingreso=='si')		 
		 	{
		 		$cond->add_criterio_extra("PRESUP.tipo_press",1);//1
		 	}	 	
		}
		
		
		if ($sw_traspaso=='si')//&& $m_id_parametro && $m_tipo_pres
		{		 	
		 	$cond->add_criterio_extra("PRESUP.id_parametro",$m_id_parametro);
		 	$cond->add_criterio_extra("PRESUP.id_unidad_organizacional",$m_id_unidad_organizacional);
		 			 	
		 	if($m_tipo_pres)
			{
		 		$cond->add_criterio_extra("PRESUP.tipo_press",$m_tipo_pres);	
		 	}		 		 	
		}	

		/**** Reporte  de ejecucion de Presupuesto ****/
		if ($sw_reporte_ejecucion=='si')//&& $m_id_parametro && $m_tipo_pres
		{		/*echo 'muestra algo dfkshd?'.$m_id_tipo_pres;
		        exit;*/ 	
		 	$cond->add_criterio_extra("PRESUP.id_parametro",$m_id_parametro);
		 	$cond->add_criterio_extra("PRESUP.id_unidad_organizacional",$m_id_unidad_organizacional);
		 	$cond->add_criterio_extra("PRESUP.tipo_press",$m_id_tipo_pres);		 		 	
		}	
		/**** fin de REP **/
			
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();	
	
	//filtramos por gestion
	if($m_id_gestion)
	{
	    $criterio_filtro=$criterio_filtro." AND PRESUP.id_gestion=".$m_id_gestion;	
	}
	else 
	{
		if($m_id_parametro or $id_parametro_ei or $m_id_parametro_g)
		{
			$criterio_filtro=$criterio_filtro;
		}
		else
		{
			$criterio_filtro=$criterio_filtro." AND PRESUP.gestion_pres=(select max(PARAMP.gestion_pres) from presto.tpr_parametro PARAMP) ";	
		}
	}
	
	//Si la llamada 
	if($vista=='solicitud_viaticos')
	{
		$cond->add_criterio_extra("PRESUP.id_parametro",$m_id_parametro);	
		$criterio_filtro=$criterio_filtro."  and PRESUP.id_fina_regi_prog_proy_acti in ( Select DEPEP.id_ep From param.tpm_depto_ep DEPEP Where DEPEP.id_depto=".$m_id_depto." ) ";
	}
	
	if($estado_pres==1)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.estado_pres in(1,2) ";
	}
	
	if($m_sw_ingreso=='no')
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.tipo_press in(3,2) ";
	}	
	
	//if ($sw_colectivo==-1){ $criterio_filtro=$criterio_filtro." and PRESUP.id_concepto_colectivo is null";}
	
	if($sw_colectivo==1&&$sw_colectivo==1)
	{	
		$criterio_filtro=$criterio_filtro." and CONCOL.id_concepto_colectivo in( select id_concepto_colectivo from presto.tpr_concepto_colectivo where id_usuario=".$_SESSION["ss_id_usuario"].") ";
	}
	else
	{
		if ($sw_colectivo==1){$criterio_filtro=$criterio_filtro." and PRESUP.id_concepto_colectivo >0"; }
		if ($sw_usuario==1){$criterio_filtro=$criterio_filtro." and PRESUP.id_unidad_organizacional in (
                            select id_unidad_organizacional from presto.tpr_usuario_autorizado where id_usuario=".$_SESSION["ss_id_usuario"].")   "; }
	}	
	
	/****
	 * a)
	 adici�n para el reporte de ejecuci�n institucional avq ******/ 	
	$id_usuario=$_SESSION["ss_id_usuario"];
	if ($vista=='ejecucion_institucional')
	{
		$criterio_filtro= $criterio_filtro." AND presup.tipo_press  in ($m_id_tipo_pres) AND presup.id_parametro=$id_parametro_ei and presup.id_fina_regi_prog_proy_acti in (select aep.id_fina_regi_prog_proy_acti from sss.tsg_usuario_asignacion usa
																																inner join sss.tsg_asignacion_estructura ase
                                      																								  on usa.id_asignacion_estructura=ase.id_asignacion_estructura
																																inner join sss.tsg_asignacion_estructura_tpm_frppa aep
                                       																								 on aep.id_asignacion_estructura=ase.id_asignacion_estructura
																																where usa.id_usuario=$id_usuario) ";
	}
	//adq
	//a�adir para el reporte procesos en curso
	if ($vista=='rep_procesos_en_curso')
	{
		$criterio_filtro=$criterio_filtro." and  presup.tipo_press  in ($m_id_tipo_pres) AND presup.id_parametro in (select id_parametro from presto.tpr_parametro param where param.id_gestion=$m_id_gestion)   and presup.id_fina_regi_prog_proy_acti in (select aep.id_fina_regi_prog_proy_acti from sss.tsg_usuario_asignacion usa
																																inner join sss.tsg_asignacion_estructura ase
                                      																								  on usa.id_asignacion_estructura=ase.id_asignacion_estructura
																																inner join sss.tsg_asignacion_estructura_tpm_frppa aep
                                       																								 on aep.id_asignacion_estructura=ase.id_asignacion_estructura
																																where usa.id_usuario=$id_usuario) ";
	}
	/******* fin adq ***/
	
	if($vista=='rep_formulacion_ejecucion')
	{
		$criterio_filtro= $criterio_filtro." and  PRESUP.id_parametro=$m_id_parametro_g and tipo_press in ($m_tipo_pres_g)
                                 and (SELECT
                                    sum(mes_01)as Enero

                                   from presto.tpr_partida_detalle parde
                                   where parde.id_partida_presupuesto in (select id_partida_presupuesto
                                                             from presto.tpr_partida_presupuesto parpre
                                                             where parpre.id_presupuesto in (select id_presupuesto
                                                                                            from presto.tpr_presupuesto
                                                                                            where
                                                                                            tipo_pres in ($m_tipo_pres_g) and
                                                                                            id_parametro=$m_id_parametro_g and
                                                                                            id_presupuesto like (presup.id_presupuesto))
                                                               ) )>0";
	}

	/******* fin a) ***/
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Presupuesto');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//--jgl inicio
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
	
		$res = $Custom->ListarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad); 
	 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
	}
	else 
	{		
		//Obtiene el total de los registros
		$res = $Custom -> ContarFormulacionPresupuesto($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		if($res) $total_registros= $Custom->salida;

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		if($res)
		{
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);
			/**
			 * b) avq
			 * para que se a�ada el todos a los combos que asi lo deseen y adici�n de campos
			 */
			 if($oc=="si")
			 {
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_presupuesto','%');
				$xml->add_nodo('tipo_pres','Todos');
				$xml->add_nodo('estado_pres','Todos');
				$xml->add_nodo('id_fina_regi_prog_proy_acti','%');
				$xml->add_nodo('desc_fina_regi_prog_proy_acti','Todos');
				$xml->add_nodo('id_unidad_organizacional','%');
				$xml->add_nodo('desc_unidad_organizacional','Todos');
				$xml->add_nodo('id_fuente_financiamiento','%');
				$xml->add_nodo('denominacion','Todos');
				$xml->add_nodo('id_parametro','Todos');
				$xml->add_nodo('desc_parametro','Todos');
				$xml->add_nodo('id_financiador','%');
				$xml->add_nodo('id_regional','%');
				$xml->add_nodo('id_programa','%');
				$xml->add_nodo('id_proyecto','%');
				$xml->add_nodo('id_actividad','%');
				$xml->add_nodo('nombre_financiador','Todos');
				$xml->add_nodo('nombre_regional','Todos');
				$xml->add_nodo('nombre_programa','Todos');
				$xml->add_nodo('nombre_proyecto','Todos');
				$xml->add_nodo('nombre_actividad','Todos');
				$xml->add_nodo('codigo_financiador','Todos');
				$xml->add_nodo('codigo_regional','Todos');
				$xml->add_nodo('codigo_programa','Todos');
				$xml->add_nodo('codigo_proyecto','Todos');
				$xml->add_nodo('codigo_actividad','Todos');
				$xml->add_nodo('id_concepto_colectivo','Todos');
				$xml->add_nodo('desc_colectivo','Todos');	
				$xml->add_nodo('sigla','Todos');
				$xml->add_nodo('desc_presupuesto','Todos');	
				$xml->add_nodo('sigla','Todos');
				$xml->add_nodo('cod_prg','Todos');		
				$xml->add_nodo('cod_proy','Todos');
				$xml->add_nodo('cod_act','Todos');
				$xml->add_nodo('cod_org_fin','Todos');
				$xml->add_nodo('cod_fue_fin','Todos');
				$xml->add_nodo('id_categoria_prog','%');
				$xml->add_nodo('cod_categoria_prog','Todos');
				$xml->add_nodo('desc_usr_reg','Todos');
				$xml->add_nodo('fecha_reg','Todos');			

				$xml->add_nodo('cp_cod_programa','Todos');		
				$xml->add_nodo('cp_cod_proyecto','Todos');
				$xml->add_nodo('cp_cod_actividad','Todos');
				$xml->add_nodo('cp_cod_organismo_fin','Todos');
				$xml->add_nodo('cp_cod_fuente_financiamiento','Todos');
				$xml->add_nodo('codigo_sisin','Todos');
			 
				$xml->fin_rama();
			 }
        
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
				$xml->add_nodo('sigla',$f["sigla"]);	
				$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);	
				$xml->add_nodo('cod_prg',$f["cod_prg"]);		
				$xml->add_nodo('cod_proy',$f["cod_proy"]);
				$xml->add_nodo('cod_act',$f["cod_act"]);
				$xml->add_nodo('cod_org_fin',$f["cod_org_fin"]);
				$xml->add_nodo('cod_fue_fin',$f["cod_fue_fin"]);
				$xml->add_nodo('id_categoria_prog',$f["id_categoria_prog"]);
				$xml->add_nodo('cod_categoria_prog',$f["cod_categoria_prog"]);
				$xml->add_nodo('desc_usr_reg',$f["desc_usr_reg"]);
				$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
				
				$xml->add_nodo('cp_cod_programa',$f["cp_cod_programa"]);		
				$xml->add_nodo('cp_cod_proyecto',$f["cp_cod_proyecto"]);
				$xml->add_nodo('cp_cod_actividad',$f["cp_cod_actividad"]);
				$xml->add_nodo('cp_cod_organismo_fin',$f["cp_cod_organismo_fin"]);
				$xml->add_nodo('cp_cod_fuente_financiamiento',$f["cp_cod_fuente_financiamiento"]);
				$xml->add_nodo('codigo_sisin',$f["codigo_sisin"]);				
				//jun2015
				$xml->add_nodo('obliga_ot',$f["obliga_ot"]);
				$xml->fin_rama();
			}
			 /*** fin b) **/
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