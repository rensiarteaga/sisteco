<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarAtributo.php
Propósito:				Permite guardar registros en la tabla tfl_atributo
Tabla:					tfl_atributo
Parámetros:				

Valores de Retorno:    	
Fecha de Creación:		2010-12-22
Versión:				1.0.0
Autor:					Marcos A. Flores Valda
**********************************************************
MODIFICACIONES:
Fecha:					2011-01-31
Autor:					Ariel Ayaviri Omonte
Descripción:			Aumento de funcionalidad de este control. Al momento de Insertarse un nuevo Atributo
						se deben crear sus respectivas atributo_tipo_nodo para cada nodo del proceso asociado al tfl_formulario.
* 
*/
session_start();
include_once("../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionGuardarAtributo.php";

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
			$id_atributo = $_GET["id_atributo_$j"];
			$id_tipo_formulario = $_GET["id_tipo_formulario_$j"];
			$tipo_field = $_GET["tipo_field_$j"];
			$tipo_datos = $_GET["tipo_datos_$j"];
			$nombre = $_GET["nombre_$j"];		
			$label = $_GET["label_$j"];
			$opcional = $_GET["opcional_$j"];			
			$remoto = $_GET["remoto_$j"];
			$valor_defecto = $_GET["valor_defecto_$j"];
			$id_action = $_GET["id_action_$j"];
			$valores_combo = $_GET["valores_combo_$j"];
			$valor = $_GET["valor_$j"];
			$display = $_GET["display_$j"];
			$id_tipo_proceso = $_GET["id_tipo_proceso_$j"];
		}
		else
		{
			$id_atributo = $_POST["id_atributo_$j"];
			$id_tipo_formulario = $_POST["id_tipo_formulario_$j"];
			$tipo_field = $_POST["tipo_field_$j"];
			$tipo_datos = $_POST["tipo_datos_$j"];
			$nombre = $_POST["nombre_$j"];
			$label = $_POST["label_$j"];
			$opcional = $_POST["opcional_$j"];
			$remoto = $_POST["remoto_$j"];
			$valor_defecto = $_POST["valor_defecto_$j"];
			$id_action = $_POST["id_action_$j"];
			$valores_combo = $_POST["valores_combo_$j"];
			$valor = $_POST["valor_$j"];
			$display = $_POST["display_$j"];
			$id_tipo_proceso = $_POST["id_tipo_proceso_$j"];
		}
		
		if ($id_atributo == "undefined" || $id_atributo == "")
		{	
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom -> ValidarAtributo("insert",$id_atributo,$id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display,$id_tipo_proceso);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_Formulario
			$res = $Custom -> InsertarAtributo($id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display,$id_tipo_proceso);

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
			$res = $Custom -> ValidarAtributo("update",$id_atributo,$id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display,$id_tipo_proceso);

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

			$res = $Custom -> ModificarAtributo($id_atributo,$id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display);

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
	if($sortcol == "") $sortcol = "id_atributo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = " 0=0 ";
	
	if(isset($m_id_tipo_formulario)) $criterio_filtro.="  and TIPATR.id_tipo_formulario = $m_id_tipo_formulario";
	
	$res = $Custom -> ContarAtributo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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