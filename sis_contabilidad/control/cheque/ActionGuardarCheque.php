<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCheque.php
Propósito:				Permite insertar y modificar datos en la tabla tct_cheque
Tabla:					tct_tct_cheque
Parámetros:				$id_cheque
						$id_transaccion
						$nro_cheque
						$nro_deposito
						$nro_deposito
						$fecha_cheque
						$nombre_cheque
						$estado_cheque
						$id_cuenta_bancaria

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-17 11:24:35
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarCheque.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados	
			$id_cheque;
			$id_transaccion;
			$nro_cheque;
			$nro_deposito;
			$nro_deposito;
			$fecha_cheque;
			$nombre_cheque;
			$estado_cheque;
			$id_cuenta_bancaria;
            $nombre_tabla;
			$nombre_campo;
			$id_tabla;
			$id_moneda;
			$importe_cheque;
			$cambio_estado;
			$tipo_cheque;		
		if ($id_cheque == "undefined" || $id_cheque == "")
		{
			////////////////////Inserción/////////////////////
            /*echo "LLEGAAAA";
            echo "Cheque: ".$id_cheque."<br>";
		    echo "cuenta: ".$id_cuenta_bancaria."<br>";
		    echo "moneda: ".$id_moneda."<br>";
            echo "tabla: ".$id_tabla."<br>";
            echo "importe: ".$importe_cheque."<br>";
            echo "campo: ".$nombre_campo."<br>";
            echo "cheque: ".$nombre_cheque."<br>";
            echo "nombre tabla: ".$nombre_tabla."<br>";
            exit;*/
			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_cheque
			$res = $Custom -> InsertarCheque($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$estado_cheque,$id_cuenta_bancaria,$nombre_tabla,$nombre_campo,$id_tabla,$id_moneda,$importe_cheque,$cambio_estado,$tipo_cheque);

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


	//Guarda el mensaje de éxito de la operación realizada
	$mensaje_exito = "Se guardaron todos los datos.";
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("mensaje",$mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	$resp->add_nodo("id_cheque", $Custom->salida[2]);
	
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