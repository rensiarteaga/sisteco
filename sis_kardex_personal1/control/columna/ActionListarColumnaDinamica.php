<?php
/**
 **********************************************************
 Nombre de archivo:	    ActionListarColumna.php
 Propósito:				Permite realizar el listado en tkp_columna
 Tabla:					t_tkp_columna
 Parámetros:				$cant
 $puntero
 $sortcol
 $sortdir
 $criterio_filtro

 Valores de Retorno:    	Listado de Procesos y total de registros listados
 Fecha de Creación:		2010-08-19 10:28:40
 Versión:				1.0.0
 Autor:					Generado Automaticamente
 **********************************************************
 */
session_start();
include_once('../LibModeloKardexPersonal.php');
$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarColumna .php';

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

	if($sort == '') $sortcol = 'id_columna';
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
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	$cond->add_criterio_extra("COLUMNA.id_tipo_planilla",$id_tipo_planilla);
	
	$cond->add_criterio_extra("COLUMNA.auxiliar","''no''");

	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$criterio_filtro=$criterio_filtro."  AND COLTIP.id_parametro_kardex =(select id_parametro_kardex from kard.tkp_planilla where id_planilla=$id_planilla)
							";
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ColumnaPla_123');
	
	
	$sortcol = $crit_sort->get_criterio_sort();

	
	//Obtiene el total de los registros
	//$res = $Custom -> ContarColumna($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	//if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarColumna(150,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$id_planilla);

				
			if($res)
			{
						$JSON="[{
							   validacion:{
									   labelSeparator:'',
									   name: 'id_empleado_planilla',
									   inputType:'hidden',
									   grid_visible:false, 
									   grid_editable:false
								
								},
								tipo: 'Field',
								form: false,
								filtro_0:false			
							},
							 {
							   validacion:{
									   name: 'nombre_completo',
									   fieldLabel:'Empleado',
									   grid_visible:true, 
									   width_grid:300,
									   grid_editable:false,
									   locked:true
								},
								tipo: 'Field',
								form: false,
								filtro_0:true
						    }";
						
						$defStore="['id_empleado_planilla','nombre_completo'";
						
						
						
						
						
						
						foreach ($Custom->salida as $f)
							{
								$color;
								if($f["en_reporte"]=='PS'){ 
									$color= '<span style="color:red;font-size:8pt">' + $f["en_reporte"] + '</span>';
									//echo "lelga y es PS..".$color; exit;
								}else{if($f["en_reporte"]=='PN'){
									$color= '<span style="color:blue;font-size:8pt">' + $f["en_reporte"] + '</span>';
								}else{
									$color= '<span style="color:orange;font-size:8pt">' + $f["en_reporte"] + '</span>';
								}
								
								//echo $color; exit;
							
								
													}
													
								
								$JSON =$JSON .",{
							        validacion:{
									   fieldLabel:'"."[".$f["en_reporte"]."-".$f["def_tipo_columna"]."]".$f["desc_tipo_columna"]."',
									   name: 'id_".$f['id_columna']."',
									   grid_visible:true, 
									   hidden:'".$f['visible']."',
									   grid_editable:true,
									   selectOnFocus:true,
									   sortable: false  ,
									   width_grid:160
								},
								tipo: 'NumberField',
								form: false,
								filtro_0:false    
						    	}";
								
								$defStore=$defStore.	",'id_".$f['id_columna']."'";
								
								//'".$f['visible_id_columna']."',
								
								
							}
								
							$JSON =$JSON.']';
							$defStore=$defStore."]";
							
							$JSON="{Atributos:$JSON, defStore:$defStore}";
							
							echo $JSON;
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