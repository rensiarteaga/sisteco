<?php
/**
**********************************************************
Nombre de archivo:	    ActionFinalizarTipoProceso.php
Propósito:				Finalizar el proceso para que este pueda ser utilizado en un formulario distinto

Tabla:					tfl_tipo_proceso
Parámetros:				$id_tipo_proceso
						$codigo
					    $nombre_proceso
						$estado_reg
						$id_usuario_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2011-02-23 17:44:40
Versión:				1.0.0
Autor:					Ariel Ayaviri Omonte
**********************************************************
*/
session_start();
include_once("../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionFinalizarTipoProceso.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	if(isset($m_id_tipo_proceso)){
		
		// PRIMERO SE OBTIENEN LOS CAMPOS NECESARIOS PARA UN UPDATE DE ESE PROCESO
		$res = $Custom->ListarTipoProceso(1,0,'id_tipo_proceso asc','asc'," TIPPRO.id_tipo_proceso = $m_id_tipo_proceso",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		if($res){
			foreach($Custom->salida as $f){
				$codigo	= $f['codigo'];
				$nombre_proceso=$f['nombre_proceso'];
				$estado = $f['estado'];
				$id_nodo_inicio = $f['id_nodo_inicio'];
				$id_formulario_inicio = $f['id_formulario_inicio'];
			}
			
			// SI NO HA SIDO ASIGNADO UN NODO COMO INICIO
			if($id_nodo_inicio == -1){
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = "MENSAJE ERROR = Debe asignar un nodo como nodo inicial.";
				$resp->origen = "ORIGEN = ";
				$resp->proc = "PROC = ";
				$resp->nivel = "NIVEL = 4";
				echo $resp->get_mensaje();
				exit;
			}
			
			// SI NO HA SIDO ASIGNADO UN FORMULARIO COMO INICIO
			if($id_formulario_inicio == -1){
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = "MENSAJE ERROR = Debe asignar un formulario como formulario inicial.";
				$resp->origen = "ORIGEN = ";
				$resp->proc = "PROC = ";
				$resp->nivel = "NIVEL = 4";
				echo $resp->get_mensaje();
				exit;
			}
			
			// SE OBTIENE LA CANTIDAD TOTAL DE NODOS DE ESTE PROCESO
			$resNod = $Custom->ContarTipoNodo(1000,0,'id_tipo_nodo asc','asc'," TIPNOD.id_tipo_proceso = $m_id_tipo_proceso");
			if($resNod){
				$totalNodos = $Custom->salida;
			}
			else{
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

			// ARMO UN ARRAY AUXILIAR CON LOS ID DE LOS NODOS DE LISTAR CIRCUITO
			$auxNod = array();
			$resNod = $Custom->ListarTipoCircuito(1000,0,'id_tipo_circuito asc','asc'," TIPNOD.id_tipo_proceso = $m_id_tipo_proceso");
			if($resNod){
				$i=0;
				foreach ($Custom->salida as $n){
					$auxNod[$i] = $n['id_tipo_nodo_inicio'];
					$i++;
					$auxNod[$i]= $n['id_tipo_nodo_fin'];
					$i++;
				}
				// QUITO LOS REPETIDOS
				$auxNod = array_values(array_unique($auxNod));
				// COMPARO LA CANTIDAD DE NODOS DEL PROCESO Y DE LO QUE SE ECUENTRAN ENLAZADOS UNOS CON OTROS
				if(count($auxNod)!=$totalNodos){
					// ERROR SI LAS CANTIDADES NO COINCIDEN
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = "MENSAJE ERROR = Existen nodos sin aristas en el proceso.";
					$resp->origen = "ORIGEN = ";
					$resp->proc = "PROC = ";
					$resp->nivel = "NIVEL = 4";
					echo $resp->get_mensaje();
					exit;
				}
				else{
					// SI LAS CANTIDADES SON LAS MISMAS, NO HAY NINGUN NODO SUELTO.
					//Realizamos la modificación del estado de pendiente a estado finalizado
					$res = $Custom->ModificarTipoProceso($m_id_tipo_proceso,$codigo,$nombre_proceso,'finalizado',$id_nodo_inicio,$id_formulario_inicio);
					if(!$res)
					{
						//Se produjo un error
						$resp = new cls_manejo_mensajes(true, "406");
						$resp->mensaje_error = $Custom->salida[1];
						$resp->origen = $Custom->salida[2];
						$resp->proc = $Custom->salida[3];
						$resp->nivel = $Custom->salida[4];
						$resp->query = $Custom->query;
						echo $resp->get_mensaje();
						exit;
					}
				}
			}
		}
		else{
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
	else{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = El id_tipo_proceso es nulo.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", 1);
	$resp->add_nodo("mensaje", 'Finalización correcta del proceso');
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>