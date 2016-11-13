<?php
/**
**********************************************************
estado_reg de archivo:	    ActionActionGuardarSubTipoActivoCuenta.php
Propósito:				Permite insertar y modificar datos en la tabla tad_servicio
Tabla:					taf_sub_tipo_ativo_cuenta
Parámetros:				$id_sub_tipo_activo_cuenta
						$estado_reg
						$fecha_reg
						$id_usuario_reg
						$id_cuenta

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-24 14:58:49
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionGuardarSubTipoActivoCuenta.php';

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
			$id_sub_tipo_activo_cuenta= $_GET["id_sub_tipo_activo_cuenta_$j"];
			$id_sub_tipo_activo= $_GET["id_sub_tipo_activo_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			
			$id_usuario_reg= $_GET["id_usuario_reg_$j"];
			$id_cuenta= $_GET["id_cuenta_$j"];
            $id_auxiliar= $_GET["id_auxiliar_$j"];
            $id_proceso= $_GET["id_proceso_$j"];
            $id_gestion= $_GET["id_gestion_$j"];
            $id_presupuesto=$_GET["id_presupuesto_$j"];
            $id_fina_regi_prog_proy_acti= $_GET["id_fina_regi_prog_proy_acti_$j"];
            $id_unidad_organizacional= $_GET["id_unidad_organizacional_$j"];
            
             $id_cuenta2= $_GET["id_cuenta2_$j"];
             $id_auxiliar2= $_GET["id_auxiliar2_$j"];
             $id_tipo_activo=$_GET["id_tipo_activo_$j"];
             $nivel=$_GET["nivel_$j"];
		}
		else
		{
			$id_sub_tipo_activo_cuenta=$_POST["id_sub_tipo_activo_cuenta_$j"];
			$id_sub_tipo_activo= $_POST["id_sub_tipo_activo_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$id_usuario_reg=$_POST["id_usuario_reg_$j"];
			$id_cuenta=$_POST["id_cuenta_$j"];
			$id_auxiliar=$_POST["id_auxiliar_$j"];
			$id_proceso= $_POST["id_proceso_$j"];
			$id_gestion= $_POST["id_gestion_$j"];
	   	    $id_fina_regi_prog_proy_acti= $_POST["id_fina_regi_prog_proy_acti_$j"];
	        $id_unidad_organizacional= $_POST["id_unidad_organizacional_$j"];
			$id_presupuesto=$_POST["id_presupuesto_$j"];

			$id_cuenta2= $_POST["id_cuenta2_$j"];
            $id_auxiliar2= $_POST["id_auxiliar2_$j"];
            
             $id_tipo_activo=$_POST["id_tipo_activo_$j"];
             $nivel=$_POST["nivel_$j"];
			
		}
		$id_usuario_reg=$_SESSION["ss_id_usuario"];

	if ($id_sub_tipo_activo_cuenta == "undefined" || $id_sub_tipo_activo_cuenta == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarSubTipoActivoCuenta("insert",$id_sub_tipo_activo_cuenta, $id_sub_tipo_activo,$estado_reg,$fecha_reg,$id_usuario_reg,$id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_servicio
			$res = $Custom -> InsertarSubTipoActivoCuenta($id_sub_tipo_activo_cuenta, $id_sub_tipo_activo, $estado_reg,$fecha_reg, $id_usuario_reg,  $id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto,$id_cuenta2,$id_auxiliar2,$id_tipo_activo,$nivel);

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
			$res = $Custom->ValidarSubTipoActivoCuenta("update",$id_sub_tipo_activo_cuenta, $id_sub_tipo_activo, $estado_reg,$fecha_reg,  $id_usuario_reg, $id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto);

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

			$res = $Custom->ModificarSubTipoActivoCuenta($id_sub_tipo_activo_cuenta, $id_sub_tipo_activo,$estado_reg,$fecha_reg, $id_usuario_reg,  $id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto,$id_cuenta2,$id_auxiliar2,$id_tipo_activo,$nivel);

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
	if($sortcol == "") $sortcol = "id_sub_tipo_activo_cuenta";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$//res = $Custom->ContarSubTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$res = $Custom -> ContarSubTipoActivoCuenta($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	
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
	$resp->origen = "ORIGEN = $estado_reg_archivo";
	$resp->proc = "PROC = $estado_reg_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>