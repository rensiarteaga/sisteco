<?php
/**
**********************************************************
Nombre de archivo:	    ActionEnviaCorreo.php
Propósito:				Permite realizar el listado en 
Tabla:					tkp_empleado
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Envio de correo para avisar la modificacion a la informacion al asignar a una persona a su cargo
Fecha de Creación:		2011-11-04
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$correo = new cls_correo();
$nombre_archivo = 'ActionEnviaCorreo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'e.id_empleado';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	
	
	if(isset($id_empleado)){
		if($estado!='baja'){
		   $criterio_filtro.=" and ha.id_empleado=$id_empleado and ha.estado=''activo'' ";
		}
	}
	
	if(isset($estado)){
	   if($estado=='alta'){
	   	$referencia='ALTA DE FUNCIONARIO';
	   }elseif ($estado=='baja'){
	   	$referencia='BAJA DE FUNCIONARIO';
	   	 if(isset($id_ha)){
	   	 	$criterio_filtro.=" and ha.id_historico_asignacion=$id_ha";
	   	 }
	   }else{
	   	$referencia='MODIFICACION DE FUNCIONARIO';
	   }
	}
	
	
	//Obtiene el criterio de orden de columnas
//	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Empleado');
	//$sortcol = $crit_sort->get_criterio_sort();
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarInformacionEmpleadoMail($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res){
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f){
			var_dump($f);
			$mensaje= '<p>
						Se ha realizado modificaciones a la información de <h4><b>'.
			             $f["nivel_academico"].' '.$f["empleado"].'</b></h4>
			             <p>con codigo de funcionario:  <b>'.$f["codigo_empleado"].' </b></p>
			             <p>correo:<b> '.$f["email1"].'</b></p>
			             </br>
			             <b><p>DATOS ASIGNACIÓN: </p></b>
			             <p><h5>Unidad:<i>         '.$f["nombre_unidad"].'</i></p>
			             <p>Cargo:<i>          '.$f["nombre_cargo"].'</i></p>
			             <p>Lugar:<i>          '.$f["lugar"].'</i></p>
			             <p>Fecha Asignacion:<i>  '.$f["fecha_asignacion"].'</i></p>
			             <p>Fecha Modificación:<i>'.$f["fecha_ultima_mod"].'</i></p>
			             <p>Resp. Modificación:<i>'.$f["usario_mod"].'</i></p>
			             <p>Fecha Registro:<i>    '.$f["fecha_registro"].'</i></p>
			             <p>Resp. Registro:<i>    '.$f["usuario_reg"].'</i></p>
			             <p>Dependencia:<i>       '.$f["dependencia"].'</i></h5></p>
			             ';
			             if($estado=='baja'){
			             	$mensaje.='<p><h5>Fecha finalizacion:<i>'.$f["fecha_finalizacion"].'</i></h5></p>';
			             }
			             if($estado=='baja'){
			             	$mensaje.='<p><h5>Estado: <i>INACTIVO</i></h5></p>';
			             }else{
			             	$mensaje.='<p><h5>Estado:<i> ACTIVO</i></h5></p>';
			             }
			             
			      $mensaje.='</br><p><b>INF. CONTRATO:</b></p>';       
			      

			if($f["id_contrato"]>0){
				$mensaje.='
				<p><h5>Nº Contrato:<i>'.$f["nro_contrato"].'</i></p>
				<p>Tipo: <i>'.$f["tipo_contrato"].'</i></p>
				<p>Fecha Ingreso:<i>'.$f["fecha_ini"].'</i></h5></p>
				<p>Fecha Finalizacion:<i>'.$f["fecha_fin"].'</i></h5></p>';
				if($f["eventual"]=='si' || $f["tiene_quincena"]=='si' || $f["socio_cooperativa"]=='si'){
				     $mensaje.='<p><b><h4>OBSERVACIONES:</h4></b></p>';
				}
				if($f["eventual"]=='si'){
					$mensaje.='<i><p><h5>Personal Eventual</h5></p></i>';
				}
				$mensaje.='<p><h5> Quincena:<i>'.$f["tiene_quincena"].'</i></p>
				<p> Socio CACSEL:<i>'.$f["socio_cooperativa"].'</h5></i></p>';
			
			}else{
				
				$mensaje.='<p><i>sin información contractual</i></p>';
			}
		//falta desde aqui hacer los cambios	
				
			
			$var_cor = $correo ->EnviarCorreodeFlujo('endesis@ende.bo','abm.cuentas@ende.bo','KARD: '.$referencia,$mensaje,'ENDESIS PROD - SISTEMA DE KARDEX DE PERSONAL', 'INFORMACION FUNCIONARIOS');
			//$var_cor = $correo ->EnviarCorreodeFlujo('endesis@ende.bo','mercedes.zambrana@ende.bo','KARD: '.$referencia,$mensaje,'ENDESIS - SISTEMA DE KARDEX DE PERSONAL', 'INFORMACION FUNCIONARIOS');
		}
			//Arma el xml para desplegar el mensaje
			$resp = new cls_manejo_mensajes(false);
		    $resp->add_nodo("mensaje", 'Correo enviado satisfactoriamente');
			$resp->add_nodo("tiempo_resp", "200");
			echo $resp->get_mensaje();
			exit;
		
	}
	else
	{
		//Se produjo un error
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
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>