<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSubsistema.php
Propósito:				Permite realizar el listado en tsg_subsistema
Tabla:					t_tsg_subsistema
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-10-26 16:42:22
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../rac_LibModeloSeguridad.php');

$Custom = new rac_cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarProcedimiento_db.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{

	if($node!='id'){
		$criterio_filtro=" SUBSIS.id_subsistema=$node ";
		if($filtrar=='true'){
			$criterio_filtro.= " AND  lower(SUBSIS.nombre_largo) LIKE lower(\'%$filtro%\') OR lower(PROCDB.codigo_procedimiento) LIKE lower(\'%$filtro%\') OR lower(PROCDB.nombre_funcion) LIKE lower(\'%$filtro%\') OR lower(PROCDB.descripcion) LIKE lower(\'%$filtro%\')";
		}
	}
	else
	{
		if($filtrar=='true'){
			$criterio_filtro.= " lower(SUBSIS.nombre_largo) LIKE lower(\'%$filtro%\') OR lower(PROCDB.codigo_procedimiento) LIKE lower(\'%$filtro%\') OR lower(PROCDB.nombre_funcion) LIKE lower(\'%$filtro%\') OR lower(PROCDB.descripcion) LIKE lower(\'%$filtro%\')";
		}
		else{
			$criterio_filtro=" 0=0 ";

		}



	}



	
	$res = $Custom->ListarProcedimiento_db("NULL",0,'id_subsistema,nombre_funcion','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res)
	{
			//llaves
			$sw=false;
			$sw_subsis=false;
			$sw_fun=false;
			$sw_pdb=false;
			$t_subsis ='';
			$t_fun='';
			$t_pdb='';
			$id_subsis=0;
			$id_fun='';
			
			
			$cont=0;
			
			foreach ($Custom->salida as $f){				
				
				if($id_subsis!=$f["id_subsistema"]){
					if($sw){
					    $t_subsis= $t_subsis.',"children":['.$t_fun.',"children":['.$t_pdb.']}]';
					    $sw_fun=false;					
						$sw_pdb=false;					
					}
								
					$tx_subsis='"text":"'.$f["nombre_largo"].'",
							 "id":'.$f["id_subsistema"].',
							 "cld":"folder",
							 "leaf":false,
							 "allowDelete":false,
							 "allowEdit":false,
							 "allowDrag":false,
							 "tipo":"sistema"';
							 
					
					
					if(!$sw_subsis){
						
						$t_subsis='{'.$tx_subsis;
						$sw_subsis=true;
					}
					else{						
						$t_subsis=$t_subsis.'},{'.$tx_subsis;
					}
					
					
				}
				
				if($id_fun!=$f["nombre_funcion"]){
					if($sw){
					    $t_fun= $t_fun.',"children":['.$t_pdb.']';
						$sw_pdb=false;					
					}
								
					$tx_fun='"text":"'.$f["nombre_funcion"].'",
							 "id":"'.$f["nombre_funcion"].'",
							 "cld":"folder",
							 "leaf":false,
							 "allowDelete":false,
							 "allowEdit":false,
							 "allowDrag":false,
							 "tipo":"funcion"';
							 
					
					
					if(!$sw_fun){
						
						$t_fun='{'.$tx_fun;
						$sw_fun=true;
					}
					else{						
						$t_fun=$t_fun.'},{'.$tx_fun;
					}
					
					
				}
				
				
				$_pdb['text'] = utf8_encode($f["codigo_procedimiento"]);
				$_pdb['id'] = utf8_encode($f["codigo_procedimiento"]);
				$_pdb['icon'] = "../../../lib/imagenes/page_white_gear.png";
				$_pdb['leaf'] = true;
				$_pdb['allowDelete']	= false;
				$_pdb['allowEdit']	= false;
				$_pdb['allowDrag']	= true;
				$_pdb['tipo']='item';
				$_pdb['codigo_procedimiento'] = $_pdb['id'];
				$_pdb['nombre_funcion'] = $f["nombre_funcion"];
				$_pdb['descripcion'] = $f["descripcion"];
				$_pdb['qtip'] = utf8_encode("Funcion: ".$_pdb['nombre_funcion']." <br>Descripcion: ".$_pdb["descripcion"]);
				$_pdb['qtipTitle']= utf8_encode("Codigo: ".$_pdb['id']);
				//guardo el item dentro del id_3


				if(!$sw_pdb){
					$t_pdb=json_encode($_pdb);
					$sw_pdb=true;					
				}
				else{
					$t_pdb= $t_pdb.','.json_encode($_pdb);			
					
				}
			
	
				//reiniciamos varialbles para que tengan el valor de los anteriores registros

				$id_subsis=$f["id_subsistema"];
				$id_fun=$f["nombre_funcion"];
				$sw=true;

				
			
			
			}
			if($sw_pdb){
			
			$t_subsis= $t_subsis.',"children":[
												'.$t_fun.',"children":['.$t_pdb.'
												 						
																	  ]}
																	  
											  ]}';
						
			}
			
			echo "[$t_subsis]";
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




