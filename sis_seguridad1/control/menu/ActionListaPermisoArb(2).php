<?php
/**
**********************************************************
Nombre de archivo:	ActionListaPermiso.php
Propósito:			Permite desplegar los permisos asignados a un usuario
Tabla:				tsg_metaproceso
Parámetros:			$cant
					$puntero
					$sortcol
					$sortdir
					$criterio_filtro
					$id_usuario_asignacion

Valores de Retorno:    	Listado de Permisos para el usuario
Fecha de Creación:		08 - 06 - 07
Versión:				2.0.0
Autor:					Enzo Rojas					
**********************************************************
*/
session_start();
include_once("../../control/LibModeloSeguridad.php");
$CustomSeguridad = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListaPermiso.php';
$lista_arbol = array();
$html = new cls_manejo_arbol('Sistema ENDESIS','bienvenida.php');// PREPARA EL Archivo de menu

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI"){

	if($node=='id'){
		//Obtiene la lista de permisos para el id_usuario, si existe caso contrario la funcion devolvera un error
		//echo "Variables: ".$_SESSION["ss_id_usuario"]."      rol: ".$_SESSION["ss_id_rol"]."    ip: ".$_SESSION["ss_ip"]."   mac: ".$_SESSION["ss_mac"];
		$resp = $CustomSeguridad->ListaPermisoArb($_SESSION["ss_id_usuario"],$_SESSION["ss_id_rol"],$_SESSION["ss_ip"],$_SESSION["ss_mac"],'1','%');
		
		if($resp){
			foreach ($CustomSeguridad->salida as $f){
				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['nombre'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_metaproceso"];
				$tmp['ruta']=$f["ruta_archivo"];
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= false;
				$tmp['allowEdit']	= false;
				$tmp['allowDrag']	= false;
				if($f["icono"]==''){
					$tmp['cls']	= 'folder';
				}
				else{
					$tmp['icon']="../../../lib/imagenes/".$f["icono"];
				}
				if($tmp['ruta']!=''){
					$tmp['tipo']='hoja';
					$tmp['leaf']=true;
				}
				else{
					$tmp['tipo']='raiz';
					$tmp['leaf'] = false;

				}
				$nodes[] = $tmp;
				$tmp=null;

			}

			//para salir
			$tmp['text']="Salir";
			$tmp['nombre']="Salir";
			$tmp['id']='salir';
			$tmp['ruta']='../../control/auten/cerrar.php';
			$tmp['leaf'] = false;
			$tmp['allowDelete']	= false;
			$tmp['allowEdit']	= false;
			$tmp['allowDrag']	= false;
			$tmp['icon']="../../../lib/imagenes/lock.png";
			$tmp['tipo']='hoja';
			$tmp['leaf']=true;
			$nodes[] = $tmp;
			$tmp=null;
			if(sizeof($nodes)>0){
				echo json_encode($nodes);
			}
			else{
				echo '{}';
			}


		}
		else{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true, " 406");
			$resp->mensaje_error = $CustomSeguridad->salida[1];
			$resp->origen = $CustomSeguridad->salida[2];
			$resp->proc = $CustomSeguridad->salida[3];
			$resp->nivel = $CustomSeguridad->salida[4];
			$resp->query = $CustomSeguridad->salida[4];
			echo $resp->get_mensaje();
			exit;
		}
	}
	elseif ($node!='id'){
		$resp = $CustomSeguridad->ListaPermisoArb($_SESSION["ss_id_usuario"],$_SESSION["ss_id_rol"],$_SESSION["ss_ip"],$_SESSION["ss_mac"],'%',$node);
		if($resp){
			foreach ($CustomSeguridad->salida as $f){
				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['nombre'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_metaproceso"];
				$tmp['ruta']=$f["ruta_archivo"];
				$tmp['allowDelete']	= false;
				$tmp['allowEdit']	= false;
				$tmp['allowDrag']	= false;


				if($tmp['ruta']==null || $tmp['ruta']==''){

					$tmp['tipo']='rama';
					$tmp['leaf'] = false;


				}
				else{
					$tmp['tipo']='hoja';
					$tmp['leaf']=true;
				}
				if($f["icono"]=='' || $f["icono"]==null){
					
					if(!$tmp['leaf']){
						$tmp['cls']	= 'folder';
					}
					else{
						$tmp['icon']="../../../lib/imagenes/a_form.png";				
					
					}
					
					
				}
				else{
					$tmp['icon']="../../../lib/imagenes/".$f["icono"];
				}

				$nodes[] = $tmp;
				$tmp=null;
			}



			if(sizeof($nodes)>0){
				echo json_encode($nodes);
			}
			else {
				echo '{}';
			}
		}
	}

}
else{
	$resp = new cls_manejo_mensajes(true, " 401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}
?>