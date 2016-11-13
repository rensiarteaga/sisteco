<?php
session_start();
include_once('../LibModeloTesoreria.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionPDFEstadoCuenta.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
/*echo "down down".utf8_decode($_GET['fecha_desde']);
exit; */
if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;  
	$sortcol = 'CUEDOC.fecha_sol, CUEDOC.nro_documento';	
	$sortdir = 'desc';
				
	$id_depto=$_SESSION['id_depto']=utf8_decode($_GET['id_depto']);
	$_SESSION['desc_depto']=utf8_decode($_GET['desc_depto']);
	$id_empleado=$_SESSION['id_empleado']=utf8_decode($_GET['id_empleado']);	
	$estado=$_SESSION['estado']=utf8_decode($_GET['estado']);	
	$estado=$_SESSION['estado']=utf8_decode($_GET['estado']);
	$_SESSION['fecha_desde']=utf8_decode($_GET['fecha_desde']);
	$_SESSION['fecha_hasta']=utf8_decode($_GET['fecha_hasta']);
	$tipo_reporte=$_GET['tipo_reporte'];
	$fecha_ini= substr( $_SESSION['fecha_desde'],3,2)."/".substr($_SESSION['fecha_desde'],0,2)."/".substr( $_SESSION['fecha_desde'],6,4);
	$fecha_fin= substr( $_SESSION['fecha_hasta'],3,2)."/".substr($_SESSION['fecha_hasta'],0,2)."/".substr( $_SESSION['fecha_hasta'],6,4);
	
	/*$this->var->add_def_cols('tipo','text');
	$this->var->add_def_cols('fecha_doc','text');
	$this->var->add_def_cols('nro_documento','varchar');
	$this->var->add_def_cols('solicitante','text');
	$this->var->add_def_cols('concepto','varchar');
	$this->var->add_def_cols('estado','varchar');
	
	$this->var->add_def_cols('importe_entregado','numeric');
	$this->var->add_def_cols('numero_rendicion','varchar');
	$this->var->add_def_cols('estado_rendicion','varchar');
	$this->var->add_def_cols('importe_rendicion','numeric');
	$this->var->add_def_cols('id_comprobante_rendicion','integer');
	
	$this->var->add_def_cols('saldo_empleado','numeric');
	$this->var->add_def_cols('saldo_ende','numeric');
	*/
	
	$datosCabecera['valor'][0]='tipo';
	$datosCabecera['valor'][1]='fecha_doc';
	$datosCabecera['valor'][2]='nro_documento';
	$datosCabecera['valor'][3]='solicitante';
	$datosCabecera['valor'][4]='concepto';
	$datosCabecera['valor'][5]='estado';
	$datosCabecera['valor'][6]='importe_entregado';
	$datosCabecera['valor'][7]='numero_rendicion';
	$datosCabecera['valor'][8]='estado_rendicion';
	$datosCabecera['valor'][9]='importe_rendicion';
	$datosCabecera['valor'][10]='id_comprobante_rendicion';
	$datosCabecera['valor'][11]='saldo_empleado';
	$datosCabecera['valor'][12]='saldo_ende';
	
	$datosCabecera['columna'][0]='TIPO';
	$datosCabecera['columna'][1]='FECHA DOCUMENTO';
	$datosCabecera['columna'][2]='Nro DOCUMENTO';
	$datosCabecera['columna'][3]='SOLICITANTE';
	$datosCabecera['columna'][4]='CONCEPTO';
	$datosCabecera['columna'][5]='ESTADO';
	$datosCabecera['columna'][6]='IMP. ENTREGADO';
	$datosCabecera['columna'][7]='NRO. RENDICION';
	$datosCabecera['columna'][8]='ESTADO RENDICION';
	$datosCabecera['columna'][9]='IMP. RENDICION';
	$datosCabecera['columna'][10]='COMPROBANTE RENDICION';
	$datosCabecera['columna'][11]='SALDO EMPLEADO';
	$datosCabecera['columna'][12]='SALDO ENDE';
	//$datosCabecera['columna'][8]='AFP';
	
	$datosCabecera['width'][0]=50;
	$datosCabecera['width'][1]=90;
	$datosCabecera['width'][2]=200;
	$datosCabecera['width'][3]=360;
	$datosCabecera['width'][4]=360;
	$datosCabecera['width'][5]=90;
	$datosCabecera['width'][6]=90;
	$datosCabecera['width'][7]=120;
	$datosCabecera['width'][8]=90;
	$datosCabecera['width'][9]=90;
	$datosCabecera['width'][10]=90;
	$datosCabecera['width'][11]=90;
	$datosCabecera['width'][12]=90;
	
	if ($tipo_reporte=='2'){ 
		if($_GET['dep_emp']=='2'){//empleado
			$id_depto=0;
		}
		
		
		$datosCabecera['columna'][13]='ID cbte Reposicion';
		$datosCabecera['width'][13]=90;
		$datosCabecera['valor'][13]='id_cbte_reposicion';
		$datosCabecera['columna'][14]='Fecha Cbte Reposicion';
		$datosCabecera['width'][14]=90;
		$datosCabecera['valor'][14]='fecha_cbte_reposicion';
		
		$datosCabecera['columna'][15]='Fecha Cbte Rendicion';
		$datosCabecera['width'][15]=90;
		$datosCabecera['valor'][15]='fecha_cbte_rendicion';
		
		$datosCabecera['columna'][16]='Tipo Pago';
		$datosCabecera['width'][16]=90;
		$datosCabecera['valor'][16]='tipo_pago';
		
		$datosCabecera['columna'][17]='Tipo Solicitud';
		$datosCabecera['width'][17]=90;
		$datosCabecera['valor'][17]='tipo_cuenta_doc';
		
		$datosCabecera['columna'][18]='Cbte Pago y Cheque';
		$datosCabecera['width'][18]=90;
		$datosCabecera['valor'][18]='cbte_pago_cheque';
		
		$datosCabecera['columna'][19]='Depto Contable';
		$datosCabecera['width'][19]=90;
		$datosCabecera['valor'][19]='nombre_depto';
		
		$datosCabecera['columna'][20]='Días (Fecha sol - Fecha Rendicion)';
		$datosCabecera['width'][20]=90;
		$datosCabecera['valor'][20]='tiempo_dias';
		
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte('DETALLE DEL ESTADO DE CUENTAS');
		$Excel->SetHoja('Cuentas');
		$Excel->SetFila(1);
		$Excel->SetTitulo('DETALLE DEL ESTADO DE CUENTAS',0,1,8); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		
		$datos_cuenta = $Custom->ListarReporteEstadoCuentaExcel(2500,$puntero,$sortcol,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_depto,0,$fecha_ini,$fecha_fin,$estado);
		$v_datos_cuenta=$Custom->salida;
		
		$Excel->setDetalle($v_datos_cuenta);
		
		
		$Excel->setFin();
	}else { 
		if ($id_depto == "undefined" || $id_depto == "" || $id_depto == 'null'){		 
			$id_empleado = $Custom-> ListarReporteEstadoCuenta(1500,$puntero,$sortcol,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_depto,$id_empleado,$fecha_ini,$fecha_fin,$estado);
			                    
			$_SESSION['PDF_estado_cuenta']=$Custom->salida;
				
			header("location:PDFEstadoCuentaEmpleado.php");	
		}else{
			//AQUI ESTARA EL CODIGO PARA EL REPORTE POR DEPARTAMENTO CONTABLE			
			$_SESSION['fecha_desde']=$fecha_ini;
			$_SESSION['fecha_hasta']=$fecha_fin;
			$_SESSION['id_depto']=$id_depto;
	
			header("location: PDFEstadoCuentaDepartamento.php");			
		}
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