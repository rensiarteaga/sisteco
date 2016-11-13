<?php
	session_start();
	include_once('../../LibModeloPresupuesto.php');
	$Custom = new cls_CustomDBPresupuesto();
	$nombre_archivo = 'ActionPDF_Repeje_Inversion_Jasper.php';
	
	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	  		$id_parametro = $_POST['id_parametro'];
	  		$fecha_fin = $_POST['fecha_fin'];
	  		$id_moneda = $_POST['id_moneda'];
	  		$desc_moneda = $_POST['desc_moneda'];
	  		$desc_gestion = $_POST['desc_gestion'];

			$sw_filtro = $_POST['sw_filtro'];
				
			$sw_ppto = $_POST['sw_ppto'];
			$sw_ep_fina = $_POST['sw_ep_fina'];
			$sw_ep_prog = $_POST['sw_ep_prog'];
			$sw_ep_proy = $_POST['sw_ep_proy'];
			$sw_ep_acti = $_POST['sw_ep_acti'];
			$sw_ep_uo = $_POST['sw_ep_uo'];
			
			$ids_ppto = $_POST['ids_ppto'];
			$ids_ep_fina = $_POST['ids_ep_fina'];
			$ids_ep_prog = $_POST['ids_ep_prog'];
			$ids_ep_proy = $_POST['ids_ep_proy'];
			$ids_ep_acti = $_POST['ids_ep_acti'];
			$ids_ep_uo = $_POST['ids_ep_uo'];
			
			$tipo_reporte = $_POST['tipo_reporte'];
			$sw_vista = $_POST['sw_vista'];
			$sw_ejecuta = $_POST['sw_ejecuta'];
		} else {
			$id_parametro = $_GET['id_parametro'];
	  		$fecha_fin = $_GET['fecha_fin'];
	  		$id_moneda = $_GET['id_moneda'];
	  		$desc_moneda = $_GET['desc_moneda'];
	  		$desc_gestion = $_GET['desc_gestion'];
			
			$sw_filtro = $_GET['sw_filtro'];
			
			$sw_ppto = $_GET['sw_ppto'];
			$sw_ep_fina = $_GET['sw_ep_fina'];
			$sw_ep_prog = $_GET['sw_ep_prog'];
			$sw_ep_proy = $_GET['sw_ep_proy'];
			$sw_ep_acti = $_GET['sw_ep_acti'];
			$sw_ep_uo = $_GET['sw_ep_uo'];
			
			$ids_ppto = $_GET['ids_ppto'];
			$ids_ep_fina = $_GET['ids_ep_fina'];
			$ids_ep_prog = $_GET['ids_ep_prog'];
			$ids_ep_proy = $_GET['ids_ep_proy'];
			$ids_ep_acti = $_GET['ids_ep_acti'];
			$ids_ep_uo = $_GET['ids_ep_uo'];
			
			$tipo_reporte = $_GET['tipo_reporte'];
			$sw_vista = $_GET['sw_vista'];
			$sw_ejecuta = $_GET['sw_ejecuta'];
	  	}
	  	
	  	$sw_admi = 'IN'; $sw_sql = 'PP';
	  	
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		if($tipo_reporte=='xls'){
		}else{
			$sw_det = $tipo_reporte;
			$tipo_reporte = 'pdf';
			if($sw_ejecuta=='1'){$reporte=new ReportDriver('repejec_InvGral.jasper','sci',$tipo_reporte);}
			if($sw_ejecuta=='2'){$reporte=new ReportDriver('repejec_InvGvig.jasper','sci',$tipo_reporte);}
			if($sw_ejecuta=='3'){$reporte=new ReportDriver('repejec_InvMesD.jasper','sci',$tipo_reporte);}
			if($sw_ejecuta=='4'){$reporte=new ReportDriver('repejec_InvMesS.jasper','sci',$tipo_reporte);}
			if($sw_ejecuta=='5'){$reporte=new ReportDriver('repejec_InvMesD.jasper','sci',$tipo_reporte);}
			if($sw_ejecuta=='6'){$reporte=new ReportDriver('repejec_InvMesS.jasper','sci',$tipo_reporte);}
			if($sw_ejecuta=='7'){$reporte=new ReportDriver('repejec_InvMesR.jasper','sci',$tipo_reporte);}
			if($sw_ejecuta=='8'){$reporte=new ReportDriver('repejec_InvMesT.jasper','sci',$tipo_reporte);}
			if($sw_ejecuta=='9'){$reporte=new ReportDriver('repejec_InvMesX.jasper','sci',$tipo_reporte);}
			
			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
		}
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		$reporte->addParametro('ip_origen',$_SESSION['ss_ip']);
		$reporte->addParametro('mac_maquina',$_SESSION['ss_mac']);
		$reporte->addParametro('sw_admi',$sw_admi);
		
		if($sw_ejecuta=='1'){$reporte->addParametro('id_codproc','PR_INVGRAL_SEL');}
		if($sw_ejecuta=='2'){$reporte->addParametro('id_codproc','PR_INVGVIG_SEL');}
		if($sw_ejecuta=='3'){$reporte->addParametro('id_codproc','PR_INVMESD_SEL');}
		if($sw_ejecuta=='4'){$reporte->addParametro('id_codproc','PR_INVMESD_SEL');}
		if($sw_ejecuta=='5'){$reporte->addParametro('id_codproc','PR_INVMESS_SEL');}
		if($sw_ejecuta=='6'){$reporte->addParametro('id_codproc','PR_INVMESS_SEL');}
		if($sw_ejecuta=='7'){$reporte->addParametro('id_codproc','PR_INVMESR_SEL');}
		if($sw_ejecuta=='8'){$reporte->addParametro('id_codproc','PR_INVMESR_SEL');}
		if($sw_ejecuta=='9'){$reporte->addParametro('id_codproc','PR_INVMEST_SEL');}

		$reporte->addParametro('fecha_fin',$fecha_fin);
		
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		
		$reporte->addParametro('sw_ppto',$sw_ppto);
		$reporte->addParametro('sw_ep_fina',$sw_ep_fina);
		$reporte->addParametro('sw_ep_prog',$sw_ep_prog);
		$reporte->addParametro('sw_ep_proy',$sw_ep_proy);
		$reporte->addParametro('sw_ep_acti',$sw_ep_acti);
		$reporte->addParametro('sw_ep_uo',$sw_ep_uo);
		
		$reporte->addParametro('ids_ppto',$ids_ppto);
		$reporte->addParametro('ids_ep_fina',$ids_ep_fina);
		$reporte->addParametro('ids_ep_prog',$ids_ep_prog);
		$reporte->addParametro('ids_ep_proy',$ids_ep_proy);
		$reporte->addParametro('ids_ep_acti',$ids_ep_acti);
		$reporte->addParametro('ids_ep_uo',$ids_ep_uo);
		
		if($tipo_reporte=='pdf'){
			$reporte->addParametro('desc_moneda',$desc_moneda);
			$reporte->addParametro('desc_gestion',$desc_gestion);
			$reporte->addParametro('desc_tipo_pres',$desc_tipo_pres);
			$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
			$reporte->addParametro('sw_det',$sw_det);
		}
		$reporte->runReporte();
	}
?>
