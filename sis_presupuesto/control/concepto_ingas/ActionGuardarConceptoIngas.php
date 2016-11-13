<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarConceptoIngas.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_concepto_ingas
Tabla:					tpr_tpr_concepto_ingas
Parámetros:				$id_concepto_ingas
						$desc_ingas
						$id_moneda
						$id_partida

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-07 15:19:34
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarConceptoIngas.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_concepto_ingas= $_GET["id_concepto_ingas_$j"];
			$desc_ingas= $_GET["desc_ingas_$j"];
			$id_partida= $_GET["id_partida_$j"];
            $id_item= $_GET["id_item_$j"];
            $id_servicio= $_GET["id_servicio_$j"];
            $sw_tesoro= $_GET["sw_tesoro_$j"];
            $id_oec= $_GET["id_oec_$j"];
            $estado= $_GET["estado_$j"];
		}
		else
		{
			$id_concepto_ingas=$_POST["id_concepto_ingas_$j"];
			$desc_ingas=$_POST["desc_ingas_$j"];
			$id_partida=$_POST["id_partida_$j"];
			$id_item= $_POST["id_item_$j"];
            $id_servicio= $_POST["id_servicio_$j"];
            $sw_tesoro= $_POST["sw_tesoro_$j"];
            $id_oec= $_POST["id_oec_$j"];
            $estado= $_POST["estado_$j"];
       }
        if($id_item=="undefined" || $id_item==""){
        	$id_item="NULL";
        }
        if($id_servicio=="undefined" || $id_servicio==""){
        	$id_servicio="NULL";
        }
        /*if( $id_oec=="undefined" ||  $id_oec==""){
        	echo " El campo OEC  no puede estar vacio";exit();
        }*/
		if ($id_concepto_ingas == "undefined" || $id_concepto_ingas == "")
		{
			////////////////////Inserción/////////////////////

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_concepto_ingas
			
			$res = $Custom -> InsertarConceptoIngas($id_concepto_ingas, $desc_ingas,$id_partida,$id_item,$id_servicio,$sw_tesoro,$id_oec,$estado);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificación////////////////////
			
			$res = $Custom->ModificarConceptoIngas($id_concepto_ingas, $desc_ingas,$id_partida,$id_item,$id_servicio,$sw_tesoro,$id_oec,$estado);

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

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_concepto_ingas";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == ""){ 
	if ($m_id_partida!=""){
		$criterio_filtro = "PARTID.id_partida=''$m_id_partida''";
	}
	else{
		$criterio_filtro="0=0";
	}
	}

	$res = $Custom->ContarConceptoIngas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
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