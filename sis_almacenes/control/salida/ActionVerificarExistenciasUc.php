<?php
/**
**********************************************************
Nombre de archivo:	   ActionVerificarExistenciasUc.php
Propósito:				Permite revisar si los materiales necesarios para crear el TUC esta disponibles en el elmacen especificado
Tabla:					tal_tal_tipo_unidad_constructiva
Parámetros:				$hidden_id_tipo_unidad_constructiva
						$txt_codigo
						$txt_nombre
						$txt_tipo
						$txt_descripcion
						$txt_observaciones
						$txt_fecha_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-01-28 15:46:18
Versión:				1.0.0
Autor:					Rensi Arteraga Copari
**********************************************************
*/
session_start();
include_once("../rcm_LibModeloAlmacenes.php");

$Custom_tuc = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarPedidoDetalleUcArb.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{

	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($node=='id')
	{
		if($sort == '') $sortcol = 'OSUCDE.id_tipo_unidad_constructiva,OSUCDE.descripcion,OSUCDE.id_unidad_constructiva,OSUCDE.id_item';
		else $sortcol = $sort;
	}
	else
	{
		$sortcol = 'TIPOUC.id_tipo_unidad_constructiva';
	}

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'

	switch ($cod){
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


	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	$criterio_filtro = $cond -> obtener_criterio_filtro();



	$decodificado = stripslashes($_REQUEST['datos']);
	$proceso=stripslashes($_REQUEST['proc']);
	$nodo = json_decode($decodificado,true);

	//$res = $Custom ->insertarTucTpmPedido($nodo["id_reg"],$descripcion,$observaciones,$nodo['id'],$id_salida,$id_unidad_constructiva,$nodo['cantidad'],$repeticion,$id_almacen_logico);


	//Vacia la tabla intermedia
	$resp = $Custom_tuc -> EliminarOrdenSalidaUCDetalleInt($id_salida);

	if($resp){
		$mensaje='true';

		//Lista todos los elementos del pedido, TUC y/o items en base al id de la salida
		$res = $Custom_tuc->ListarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,"OSUCDE.id_salida=$id_salida",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
		$llave=false;
		if($res){
			foreach ($Custom_tuc->salida as $f){
				$llave=true;
				//Forma la cadena de la cantidad solicitada
				$cantidad=" [".utf8_encode($f["cantidad"]."]");

				if($f['id_item'] != ""){
					//Si es Item, inserta el item con su cantidad en la tabla temporal tal_pedido_tuc_int
					$resp4 = $Custom_tuc -> insertarItemIntPedido($f["id_orden_salida_uc_detalle"],$f["id_item"],$id_salida,$f["cantidad"],$f["repeticion"],$id_almacen_logico);
					if(!$resp4){

						$resp4 = new cls_manejo_mensajes(true, "406");
						$resp4->mensaje_error = $Custom_tuc->salida[1] ;
						$resp4->origen = $Custom_tuc->salida[2];
						$resp4->proc = $Custom_tuc->salida[3];
						$resp4->nivel = $Custom_tuc->salida[4];
						$resp4->query = $Custom_tuc->query;
						echo $resp4->get_mensaje();
						$resp = $Custom_tuc -> EliminarOrdenSalidaUCDetalleInt($id_salida);
						exit;
					}
				}
				else{
					//Llama a la función recursiva para obtener todas sus ramas y llegar a los items
					$var = insertaMaterialesArb ($f["id_tipo_unidad_constructiva"],$f["id_orden_salida_uc_detalle"],$f["cantidad"],$id_salida,$id_almacen_logico,$f["repeticion"]);
					if($mensaje!='false'){
						$mensaje=$var;

					}
				}
			}
		}

		//VERIFICA LAS EXISTENCIA de los elemntos insertados el la tabla intermedia
		//para la generacion de reportes de faltantes y de materiales necesarios
		if($llave){
			$resp0 = $Custom_tuc->verificarPedidoTucInt($id_salida,$id_almacen_logico);
			if($resp0){

				$mensaje_verificacion = $Custom_tuc->salida[2];
				//SI la verificacion tiene exito se modifica el tipo de entrega de null a verificado
				$respu = $Custom_tuc -> modificarSalidaTipoEntrega($id_salida,'Verificado');
				if($respu){


					$tmp['success'] = 'true';
					$tmp['mensaje'] = $mensaje_verificacion;
					echo json_encode($tmp);
					exit;
				}
				else{

					$respu = new cls_manejo_mensajes(true, "406");
					$respu->mensaje_error = $Custom_tuc->salida[1] ;
					$respu->origen = $Custom_tuc->salida[2];
					$respu->proc = $Custom_tuc->salida[3];
					$respu->nivel = $Custom_tuc->salida[4];
					$respu->query = $Custom_tuc->query;
					echo $respu->get_mensaje();
					exit;
				}
			}
			else{

				$resp0 = new cls_manejo_mensajes(true, "406");
				$resp0->mensaje_error = $Custom_tuc->salida[1] ;
				$resp0->origen = $Custom_tuc->salida[2];
				$resp0->proc = $Custom_tuc->salida[3];
				$resp0->nivel = $Custom_tuc->salida[4];
				$resp0->query = $Custom_tuc->query;
				echo $resp0->get_mensaje();
				exit;

			}

		}else
		{
			$resp0 = new cls_manejo_mensajes(true, "406");
			$resp0->mensaje_error = 'No existen elementos en el detalle del pedido para verificar';
			$resp0->origen = 'ActionVerificaExistenciasUC.php';
			$resp0->proc = 'ActionVerificaExistenciasUC.php';
			$resp0->nivel=2;
			echo $resp0->get_mensaje();
			exit;


		}

	}
	else {

		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $Custom_tuc->salida[1] ;
		$resp->origen = $Custom_tuc->salida[2];
		$resp->proc = $Custom_tuc->salida[3];
		$resp->nivel = $Custom_tuc->salida[4];
		$resp->query = $Custom_tuc->query;
		echo $resp->get_mensaje();
		exit;
	}





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

function insertaMaterialesArb ($id_tuc,$id_reg,$cantidad,$id_salida,$id_almacen_logico,$repeticion){


	$Custom = new cls_CustomDBAlmacenes();

	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_tipo_unidad_constructiva asc';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	$criterio_filtro='0=0';

	//Obtiene las ramas del TUC (no items, solo las ramas si es que tuviera)
	$resp = $Custom->ListarOrdenSalidaUCDetalleRamas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tuc,$id_reg);
	$mensaje='true';

	if($resp){
		foreach ($Custom->salida as $f){
			//Llamada recursiva
			$mensaje=insertaMaterialesArb ($f["id_tipo_unidad_constructiva"],$id_reg,$cantidad * $f["cantidad"],$id_salida,$id_almacen_logico,$repeticion);
		}

		//Obtiene todos los componentes (items) del TUC y los inserta en la tabla temporal (tal_pedido_tuc_int)
		$resp2 = $Custom ->insertarTucIntPedido($id_reg,$id_tuc,$id_salida,$cantidad,$repeticion,$id_almacen_logico);

		if(!$resp2){

			$resp3 = $Custom -> EliminarOrdenSalidaUCDetalleInt($id_salida);
			$resp2 = new cls_manejo_mensajes(true,'406');
			$resp2->mensaje_error = $Custom->salida[1];
			$resp2->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp2->nivel = $Custom->salida[4];
			$resp2->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}else
		{
			if($mensaje=='false'){
				return 'false';
			}
			else{

				return $Custom->salida[2];
			}


		}

	}
	else{
		$resp3 = $Custom -> EliminarOrdenSalidaUCDetalleInt($id_salida);
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
?>
