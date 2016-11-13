<?php
ob_start('limpiar');
function limpiar($buffer) {return trim($buffer);}
?>

<?php
/**
 * **********************************************************
 * Nombre de archivo: 		ActionGuardarDetalleUnidadConstructiva.php
 * Propósito:				Permite insertar y modificar datos en alma.tal_detalle_unidad_constructiva
 * Tabla:					tal_detalle_unidad_constructiva
 * Parámetros:				$id_detalle_unidad_constructiva
 * $id_detalle_unidad_constructiva
 * $id_dunidad_constructiva
 * $id_item
 * $cantidad
 * Valores de Retorno: 		Número de registros guardados
 * Fecha de Creación:		14-08-2014
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarItem.php";
if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") {
	// Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0) {
		$get = true;
		$cont = 1;
		
		// Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		// valores permitidos de $cod -> "si", "no"
		switch ($cod) {
			case "si" :
				$decodificar = true;
				break;
			case "no" :
				$decodificar = false;
				break;
			default :
				$decodificar = true;
				break;
		}
	} elseif (sizeof($_POST) > 0) {
		$get = false;
		$cont = $_POST["cantidad_ids"];
		
		// Por Post siempre se decodifica
		$decodificar = true;
	} else {
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit();
	}
	// Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;
	// Realiza el bucle por todos los ids mandados
	//$id_unidad_constructiva = $_SESSION['id_unidad_const'];
	if(isset($_SESSION['id_unidad_const']))
		$id_unidad_constructiva = $_SESSION['id_unidad_const'];
	else $id_unidad_constructiva= -1;
	
	for($j = 0; $j < $cont; $j ++) 
	{
		if ($get) 
		{
			$seleccionado = $_GET["chk_seleccionado_$j"];
			$id_item = $_GET["hidden_id_item_$j"];
			$cantidad = $_GET["txt_cantidad_$j"];
			
			$codigo =$_GET["codigo_$j"];
			$nombre = $_GET["nombre_$j"];
		} 
		else 
		{
			$seleccionado = $_POST["chk_seleccionado_$j"];
			$id_item = $_POST["hidden_id_item_$j"];
			$cantidad = $_POST["txt_cantidad_$j"];
			
			$codigo =$_POST["codigo_$j"];
			$nombre = $_POST["nombre_$j"];

		}
		
		if($seleccionado==1 || $seleccionado)
		{
			if($cantidad == 'undefined' || $cantidad == '' || $cantidad <= 0)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = 'El campo cantidad del item seleccionado: "'.$codigo.' - '.$nombre.'" no puede ser 0';
				$resp->origen = 'Registro';
				$resp->proc = 'AL_DETUNICONS_INS';
				$resp->nivel = 4;
				echo $resp->get_mensaje();
				exit();
			}
			else 
			{	
				$res = $Custom->InsertarDetalleUnidadConstructivaItem($id_unidad_constructiva,$id_item,$cantidad);
				
				if (! $res) 
				{
					// Se produjo un error
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					$resp->query = $Custom->query;
					echo $resp->get_mensaje();
					exit();
				}
			}
		}
		else
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = 'El item '.$codigo.' - '.$nombre.' debe ser seleccionado para su registrado';
			$resp->origen = 'Registro';
			$resp->proc = 'AL_DETUNICONS_INS';
			$resp->nivel = 4;
			echo $resp->get_mensaje();
			exit();
		}
	} // END FOR
	  
	// Guarda el mensaje de éxito de la operación realizada
	if ($cont > 1)
		$mensaje_exito = "Se guardaron todos los datos.";
	else
		$mensaje_exito = $Custom->salida[1];
		
		// Obtiene el total de los registros. Parámetros del filtro
	if ($cant == "")
		$cant = 100;
	if ($puntero == "") 
		$puntero = 0;
	if ($sortcol == "")
		$sortcol = "detunic.id_unidad_constructiva";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
		$criterio_filtro = '0=0';

	$res = $Custom->CountDetalleUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res)
		$total_registros = $Custom->salida;
		
		// Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit();
} else {
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit();
}
?>
<?php ob_end_flush();?>