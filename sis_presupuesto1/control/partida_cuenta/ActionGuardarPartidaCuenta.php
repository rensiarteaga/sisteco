<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPartida.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_partida
Tabla:					tpr_tpr_partida
Parámetros:				$id_partida
						$codigo_partida
						$nombre_partida
						$nivel_partida
						$sw_transaccional
						$tipo_partida
						$id_parametro
						$id_partida_padre
						$tipo_memoria
						$desc_partida

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-07 11:38:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarPartidaCuenta.php";

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
			$id_partida_cuenta= $_GET["id_partida_cuenta_$j"];
			$sw_deha= $_GET["sw_deha_$j"];
			$sw_rega= $_GET["sw_rega_$j"];
			$id_cuenta_debe= $_GET["id_cuenta_debe_$j"];
			$id_cuenta_haber= $_GET["id_cuenta_haber_$j"];
			$id_partida_recurso= $_GET["id_partida_recurso_$j"];
			$id_partida_gasto= $_GET["id_partida_gasto_$j"];
			$id_parametro= $_GET["id_parametro_$j"];
			}
		else
		{
			$id_partida_cuenta= $_POST["id_partida_cuenta_$j"];
			$sw_deha= $_POST["sw_deha_$j"];
			$sw_rega= $_POST["sw_rega_$j"];
			$id_cuenta_debe= $_POST["id_cuenta_debe_$j"];
			$id_cuenta_haber= $_POST["id_cuenta_haber_$j"];
			$id_partida_recurso= $_POST["id_partida_recurso_$j"];
			$id_partida_gasto= $_POST["id_partida_gasto_$j"];
			$id_parametro= $_POST["id_parametro_$j"];

		}
          if($id_cuenta_debe!=""){
              $id_cuenta=$id_cuenta_debe;	
            }
            else{
            	$id_cuenta=$id_cuenta_haber;	
            }
			if($id_partida_recurso!=""){
              $id_partida=$id_partida_recurso;	
            }
            else{
            	$id_partida=$id_partida_gasto;
            }
 
		if ($id_partida_cuenta == "undefined" || $id_partida_cuenta == "")
		{
			////////////////////Inserción/////////////////////
            
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarPartidaCuenta("insert",$id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_partida
			$res = $Custom -> InsertarPartidaCuenta($id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega);

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
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarPartidaCuenta("update",$id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarPartidaCuenta($id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega);

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
	if($sortcol == "") $sortcol = "id_partida_cuenta";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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