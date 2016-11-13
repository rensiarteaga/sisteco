<?php
/*
 **********************************************************
 Nombre de archivo:	    ActionGuardarValores.php
 Propósito:				Permite guardar registros en la tabla tfl_atributo
 Tabla:					tfl_atributo, tfl_formulario, tfl_proceso
 Parámetros:

 Valores de Retorno:
 Fecha de Creación:		2011-02-03
 Versión:				1.0.0
 Autor:					Ariel Ayaviri Omonte
 **********************************************************
*/
session_start();
include_once("../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionGuardarValor.php";

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
	for($j=0;$j<$cont;$j++){ //$j me controla la cantidad de Records de la grilla que son modificados o insertados
		$valor_text = array();
		$id_atributo = array();
		$i = 0;	// me controla los valores por separado. Una fila de la grilla puede tener muchos valores o sea muchos $i
		$encontrado = true;
		
		//Priemero obetenemos los parámetros del get o del post y se los inserta al array valor_text e id_atributo 
		while($encontrado){
			if($get){
				if(isset($_GET["valor_".$i."_$j"])&&isset($_GET["id_atributo_".$i."_$j"])){
					$valor_text[$i] = $_GET["valor_".$i."_$j"];
					$id_atributo[$i] = $_GET["id_atributo_".$i."_$j"];
					$ids_adicional[$i] = $_GET["ids_adicional_".$i."_$j"];
				}
				else{
					$encontrado = false;
				}
			}
			else{
				if(isset($_POST["valor_".$i."_$j"])&&isset($_POST["id_atributo_".$i."_$j"])){
					$valor_text[$i] = $_POST["valor_".$i."_$j"];
					$id_atributo[$i] = $_POST["id_atributo_".$i."_$j"];
					$ids_adicional[$i] = $_POST["ids_adicional_".$i."_$j"];
				}
				else{
					$encontrado = false;
				}
			}
			$i++;
		}

		if($get){
			$id_formulario = $_GET["id_formulario_$j"];
		}
		else{
			$id_formulario = $_POST["id_formulario_$j"];
		}

		if(sizeof($id_atributo)>0){
			
			if(($id_formulario=="undefined")||($id_formulario=="")){
				//creamos un nuevo Proceso
				$res = $Custom->ValidarProceso("insert","null",$m_id_tipo_proceso,"NULL");
				if(!$res){
					//Error de validación
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}
				$res = $Custom->InsertarProceso($m_id_tipo_proceso,"NULL");
				if($res){
					$id_proceso = $Custom->salida[2];
				}
				else{
					//Error de inserción
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}
				$id_tipo_formulario = $m_id_tipo_formulario;
				//creamos un nuevo Formulario
				$res = $Custom->ValidarProceso("insert","null",$id_tipo_formulario,$id_proceso);
				if(!$res){
					//Error de validación
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}
				$res = $Custom->InsertarFormulario($id_tipo_formulario,$id_proceso,"NULL",0);
				if($res){
					$id_formulario = $Custom->salida[2];
				}
				else{
					//Error de Inserción
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}
				
				//Si se crea un nuevo proceso-formulario entonces se crea tambien un nuevo nodo
				//y se devuelve el id_nodo
				
				$res = $Custom->InsertarNodo($m_id_empleado, $m_id_tipo_nodo, $id_proceso,"NULL","borrador","NULL");
				if($res){
					$id_nodo = $Custom->salida[2];
				}
				else{
					//Error de validación
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}
			}
			
			//obtenemos por separado los ids adicionales, en este caso,
			//el id_valor y el id_atributo seperados por #
			
			for($i=0;$i<sizeof($id_atributo);$i++){
				
				$ids_adicional_aux= explode("@#@",$ids_adicional[$i]);
				
				if ($ids_adicional[$i] == "undefined" || $ids_adicional[$i] == "")
				{
					////////////////////Inserción///////////////////
					//Validación de datos (del lado del servidor) //
					////////////////////////////////////////////////
					$res = $Custom -> ValidarValor("insert",intval($ids_adicional_aux[0]),$id_formulario,intval($id_atributo[$i]),intval($id_nodo));
					
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
					$res = $Custom -> InsertarValor($id_formulario,intval($id_atributo[$i]),intval($id_nodo),$valor_text[$i]);
					if(!$res)
					{
						//Se proejo un error
						$resp = new cls_manejo_mensajes(true, "406");
						$resp->mensaje_error = $Custom->salida[1] . " (iteración $i)";
						$resp->origen = $Custom->salida[2];
						$resp->proc = $Custom->salida[3];
						$resp->nivel = $Custom->salida[4];
						$resp->query = $Custom->query;
						echo $resp->get_mensaje();
						exit;
					}
				}
				else
				{	///////////////////////Modificación//////////////
					// Validación de datos (del lado del servidor) //
					/////////////////////////////////////////////////
					$res = $Custom -> ValidarValor("update",intval($ids_adicional_aux[0]),$id_formulario,intval($id_atributo[$i]),intval($ids_adicional_aux[1]));
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
					
					$res = $Custom -> ModificarValor(intval($ids_adicional_aux[0]),$id_formulario,intval($id_atributo[$i]),intval($ids_adicional_aux[1]),$valor_text[$i]);
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
			//Arma el xml para desplegar el mensaje
			$resp = new cls_manejo_mensajes(false);
			$resp->add_nodo("TotalCount", $total_registros);
			$resp->add_nodo("mensaje", "No se ha insertado ningun registro");
			$resp->add_nodo("tiempo_resp", "200");
			echo $resp->get_mensaje();
			exit;
		}
		unset($valor_text);
		unset($id_atributo);
	}
	
	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_valor";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = " 0=0 ";
	
	$criterio_filtro=$criterio_filtro." and FORMUL.id_tipo_formulario = ".$m_id_tipo_formulario;
	$res = $Custom -> ContarFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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