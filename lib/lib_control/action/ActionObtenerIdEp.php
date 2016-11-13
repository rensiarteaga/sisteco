<?php
/**
 * Nombre del archivo:	ActionObtenerIdEp.php
 * Propósito:			Devolver el id_ep en funcion a id_fina, regi, prog, proy, acti
 * Valores de Retorno:	Id de la ep
 * Autor:				
 * Fecha creación:		
 */
session_start();

include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionObtenerIdEp.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	$var = new cls_middle("f_pm_get_id_ep","");
	$var->add_param($id_financiador);
	$var->add_param($id_regional);
	$var->add_param($id_programa);
	$var->add_param($id_proyecto);
	$var->add_param($id_actividad);
	//Ejecuta la función
	/*$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
	$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
	$this->query = $this->var->query;
 
	return $res;
	*/
	$var->exec_function();
	$salida = $var->salida;
	$id_ep = $salida[0][0];//devuelve id_ep
	
	
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('id_ep', $id_ep);
	$xml->fin_rama();
	$xml->mostrar_xml();

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
