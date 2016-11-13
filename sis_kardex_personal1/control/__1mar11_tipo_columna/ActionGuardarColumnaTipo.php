<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarColumnaTipo.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_tipo_columna
Tabla:					tkp_tkp_tipo_columna
Parámetros:				$id_columna_tipo
						$id_parametro_kardex
						$id_partida
						$nombre
						$valor
						$tipo_dato
						$id_moneda
						$tipo_aporte
						$estado_reg
						$fecha_reg
						$cotizable
						$descripcion
						$descuento_incremento
						$observacion
						$basica

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-10 17:59:45
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarColumnaTipo.php";

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
			$id_columna_tipo= $_GET["id_columna_tipo_$j"];
			$id_parametro_kardex= $_GET["id_parametro_kardex_$j"];
			$id_partida= $_GET["id_partida_$j"];
			$nombre= $_GET["nombre_$j"];
			$valor= $_GET["valor_$j"];
			$tipo_dato= $_GET["tipo_dato_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$tipo_aporte= $_GET["tipo_aporte_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$cotizable= $_GET["cotizable_$j"];
			$descripcion= $_GET["descripcion_$j"];
			$descuento_incremento= $_GET["descuento_incremento_$j"];
			$observacion= $_GET["observacion_$j"];			
			$formula= $_GET["formula_$j"];
			
			$id_tipo_descuento_bono= $_GET["id_tipo_descuento_bono_$j"];
			$codigo= $_GET["codigo_$j"];
			
			$id_cuenta_pasivo=$_GET["id_cuenta_pasivo_$j"];
			$id_auxiliar_pasivo=$_GET["id_auxiliar_pasivo_$j"];
			$compromete=$_GET["compromete_$j"];
			$id_tipo_columna_base=$_GET["id_tipo_columna_base_$j"];
			$id_tipo_obligacion=$_GET["id_tipo_obligacion_$j"];
			
			$movimiento_contable=$_GET["movimiento_contable_$j"];
			$prorrateo=$_GET["prorratea_$j"];
		}
		else
		{
			$id_columna_tipo=$_POST["id_columna_tipo_$j"];
			$id_parametro_kardex=$_POST["id_parametro_kardex_$j"];
			$id_partida=$_POST["id_partida_$j"];
			$nombre=$_POST["nombre_$j"];
			$valor=$_POST["valor_$j"];
			$tipo_dato=$_POST["tipo_dato_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$tipo_aporte=$_POST["tipo_aporte_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$cotizable=$_POST["cotizable_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$descuento_incremento=$_POST["descuento_incremento_$j"];
			$observacion=$_POST["observacion_$j"];
			$formula=$_POST["formula_$j"];
			
			$id_tipo_descuento_bono=$_POST["id_tipo_descuento_bono_$j"];
			$codigo=$_POST["codigo_$j"];
			
			
			
			$id_cuenta_pasivo=$_POST["id_cuenta_pasivo_$j"];
			$id_auxiliar_pasivo=$_POST["id_auxiliar_pasivo_$j"];
			$compromete=$_POST["compromete_$j"];
			$id_tipo_columna_base=$_POST["id_tipo_columna_base_$j"];
			$id_tipo_obligacion=$_POST["id_tipo_obligacion_$j"];
			
			$movimiento_contable=$_POST["movimiento_contable_$j"];
			$prorrateo=$_POST["prorratea_$j"];
		}

		if ($id_columna_tipo == "undefined" || $id_columna_tipo == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarColumnaTipo("insert",$id_columna_tipo,$id_parametro_kardex,$id_partida,$nombre,$valor,$tipo_dato,$id_moneda,$tipo_aporte,$estado_reg,$fecha_reg,$cotizable,$descripcion,$descuento_incremento,$observacion,$formula);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_tipo_columna
			$res = $Custom -> InsertarColumnaTipo($id_columna_tipo,$id_parametro_kardex,$id_partida,$nombre,$valor,$tipo_dato,$id_moneda,$tipo_aporte,$estado_reg,$fecha_reg,$cotizable,$descripcion,$descuento_incremento,$observacion,$formula,$id_tipo_descuento_bono,$codigo,$id_cuenta_pasivo,$id_auxiliar_pasivo,$compromete,$id_tipo_obligacion,$movimiento_contable,$prorrateo);

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
			$res = $Custom->ValidarColumnaTipo("update",$id_columna_tipo,$id_parametro_kardex,$id_partida,$nombre,$valor,$tipo_dato,$id_moneda,$tipo_aporte,$estado_reg,$fecha_reg,$cotizable,$descripcion,$descuento_incremento,$observacion,$formula,$movimiento_contable,$prorrateo);

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

			
		
			
			
			$res = $Custom->ModificarColumnaTipo($id_columna_tipo,$id_parametro_kardex,$id_partida,$nombre,$valor,$tipo_dato,$id_moneda,$tipo_aporte,$estado_reg,$fecha_reg,$cotizable,$descripcion,$descuento_incremento,$observacion,$formula,$id_tipo_descuento_bono,$codigo,$id_cuenta_pasivo,$id_auxiliar_pasivo,$compromete,$id_tipo_obligacion,$movimiento_contable,$prorrateo);

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
	if($sortcol == "") $sortcol = "id_columna_tipo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarColumnaTipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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