<?php
	session_start();
	include_once('../../LibModeloPresupuesto.php');
	$Custom = new cls_CustomDBPresupuesto();
	$nombre_archivo = 'ActionPDF_Repeje_Consolida_Jasper.php';
	
	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	  		$id_parametro = $_POST['id_parametro'];
	  		$fecha_ini = $_POST['fecha_ini'];
	  		$fecha_fin = $_POST['fecha_fin'];
	  		$id_tipo_pres = $_POST['id_tipo_pres'];
	  		$id_moneda = $_POST['id_moneda'];
	  		$desc_moneda = $_POST['desc_moneda'];
	  		$desc_gestion = $_POST['desc_gestion'];
	  		$desc_tipo_pres = $_POST['desc_tipo_pres'];
			$sw_nivel = $_POST['sw_nivel'];
			$sw_filtro = $_POST['sw_filtro'];
			$sw_eplis = $_POST['sw_eplis'];
			$sw_cplis = $_POST['sw_cplis'];
				
			$sw_ppto = $_POST['sw_ppto'];
			$sw_cprog = $_POST['sw_cprog'];
			$sw_ep_fina = $_POST['sw_ep_fina'];
			$sw_ep_regi = $_POST['sw_ep_regi'];
			$sw_ep_prog = $_POST['sw_ep_prog'];
			$sw_ep_proy = $_POST['sw_ep_proy'];
			$sw_ep_acti = $_POST['sw_ep_acti'];
			$sw_ep_uo = $_POST['sw_ep_uo'];
			$sw_cp_prog = $_POST['sw_cp_prog'];
			$sw_cp_proy = $_POST['sw_cp_proy'];
			$sw_cp_acti = $_POST['sw_cp_acti'];
			$sw_cp_fuen = $_POST['sw_cp_fuen'];
			$sw_cp_orga = $_POST['sw_cp_orga'];
			
			$ids_ppto = $_POST['ids_ppto'];
			$ids_cprog = $_POST['ids_cprog'];
			$ids_ep_fina = $_POST['ids_ep_fina'];
			$ids_ep_regi = $_POST['ids_ep_regi'];
			$ids_ep_prog = $_POST['ids_ep_prog'];
			$ids_ep_proy = $_POST['ids_ep_proy'];
			$ids_ep_acti = $_POST['ids_ep_acti'];
			$ids_ep_uo = $_POST['ids_ep_uo'];
			$ids_cp_prog = $_POST['ids_cp_prog'];
			$ids_cp_proy = $_POST['ids_cp_proy'];
			$ids_cp_acti = $_POST['ids_cp_acti'];
			$ids_cp_fuen = $_POST['ids_cp_fuen'];
			$ids_cp_orga = $_POST['ids_cp_orga'];
			
			$tipo_reporte = $_POST['tipo_reporte'];
			$sw_vista = $_POST['sw_vista'];
			$sw_ejecuta = $_POST['sw_ejecuta'];
			$sw_impre = $_POST['sw_impre'];
			$sw_mes = $_POST['sw_mes'];
			$sw_trim = $_POST['sw_trim'];
			$id_partida = $_POST['id_partida'];
			$desc_partida = $_POST['desc_partida'];
		} else {
			$id_parametro = $_GET['id_parametro'];
	  		$fecha_ini = $_GET['fecha_ini'];
	  		$fecha_fin = $_GET['fecha_fin'];
	  		$id_tipo_pres = $_GET['id_tipo_pres'];
	  		$id_moneda = $_GET['id_moneda'];
	  		$desc_moneda = $_GET['desc_moneda'];
	  		$desc_gestion = $_GET['desc_gestion'];
	  		$desc_tipo_pres = $_GET['desc_tipo_pres'];
			$sw_nivel = $_GET['sw_nivel'];
			$sw_filtro = $_GET['sw_filtro'];
			$sw_eplis = $_GET['sw_eplis'];
			$sw_cplis = $_GET['sw_cplis'];
			
			$sw_ppto = $_GET['sw_ppto'];
			$sw_cprog = $_GET['sw_cprog'];
			$sw_ep_fina = $_GET['sw_ep_fina'];
			$sw_ep_regi = $_GET['sw_ep_regi'];
			$sw_ep_prog = $_GET['sw_ep_prog'];
			$sw_ep_proy = $_GET['sw_ep_proy'];
			$sw_ep_acti = $_GET['sw_ep_acti'];
			$sw_ep_uo = $_GET['sw_ep_uo'];
			$sw_cp_prog = $_GET['sw_cp_prog'];
			$sw_cp_proy = $_GET['sw_cp_proy'];
			$sw_cp_acti = $_GET['sw_cp_acti'];
			$sw_cp_fuen = $_GET['sw_cp_fuen'];
			$sw_cp_orga = $_GET['sw_cp_orga'];
			
			$ids_ppto = $_GET['ids_ppto'];
			$ids_cprog = $_GET['ids_cprog'];
			$ids_ep_fina = $_GET['ids_ep_fina'];
			$ids_ep_regi = $_GET['ids_ep_regi'];
			$ids_ep_prog = $_GET['ids_ep_prog'];
			$ids_ep_proy = $_GET['ids_ep_proy'];
			$ids_ep_acti = $_GET['ids_ep_acti'];
			$ids_ep_uo = $_GET['ids_ep_uo'];
			$ids_cp_prog = $_GET['ids_cp_prog'];
			$ids_cp_proy = $_GET['ids_cp_proy'];
			$ids_cp_acti = $_GET['ids_cp_acti'];
			$ids_cp_fuen = $_GET['ids_cp_fuen'];
			$ids_cp_orga = $_GET['ids_cp_orga'];
			
			$tipo_reporte = $_GET['tipo_reporte'];
			$sw_vista = $_GET['sw_vista'];
			$sw_ejecuta = $_GET['sw_ejecuta'];
			$sw_impre = $_GET['sw_impre'];
			$sw_mes = $_GET['sw_mes'];
			$sw_trim = $_GET['sw_trim'];
			$id_partida = $_GET['id_partida'];
			$desc_partida = $_GET['desc_partida'];
	  	}
	  	
	  	$sw_admi = 'SI';
	  	if($sw_vista=='fasignar'){$sw_vista = 'formular'; $sw_admi = 'NO';}
	  	if($sw_vista=='easignar'){$sw_vista = 'ejecutar'; $sw_admi = 'NO';}
	  	
	  	if($sw_filtro == '1'){$sw_sql = 'PP';}
	  	if($sw_filtro == '2'){$sw_sql = 'CP';}
	  	if($sw_filtro == '3'){$sw_sql = $sw_eplis;}
	  	if($sw_filtro == '4'){$sw_sql = $sw_cplis;}
	  	if(($sw_ejecuta=='5' || $sw_ejecuta=='8') && $tipo_reporte=='xls' && $sw_eplis=='EP'){$sw_sql = 'EPX';}
	  	
		//Clase necesaria para la generación de reporte 
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		if($tipo_reporte=='xls'){
			if($sw_vista=='formular'){$reporte=new ReportDriver('repejec_ConsFormu_xls.jasper','sci',$tipo_reporte);}
			if($sw_vista=='ejecutar'){
				if($sw_ejecuta=='1'){$reporte=new ReportDriver('repejec_ConsAFech_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='2'){$reporte=new ReportDriver('repejec_ConsEFech_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='3'){$reporte=new ReportDriver('repejec_ConsPFech_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='4'){$reporte=new ReportDriver('repejec_ConsPFech_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='5' && $sw_eplis!='EP'){$reporte=new ReportDriver('repejec_ConsGes_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='5' && $sw_eplis=='EP'){$reporte=new ReportDriver('repejec_ConsGesP_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='6'){$reporte=new ReportDriver('repejec_ConsTrim_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='7'){$reporte=new ReportDriver('repejec_ConsMes_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='8' && $sw_eplis!='EP'){$reporte=new ReportDriver('repejec_ConsGes_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='8' && $sw_eplis=='EP'){$reporte=new ReportDriver('repejec_ConsGesP_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='9'){$reporte=new ReportDriver('repejec_ConsParAFec_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='10'){$reporte=new ReportDriver('repejec_ConsParGes_xls.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='11'){$reporte=new ReportDriver('repejec_ConsParEFec_xls.jasper','sci',$tipo_reporte);}
			}
		}else{
			$sw_det = $tipo_reporte;
			$tipo_reporte = 'pdf';
			if($sw_vista=='formular'){$reporte=new ReportDriver('repejec_ConsFormu.jasper','sci',$tipo_reporte);}
			if($sw_vista=='ejecutar'){
				if($sw_ejecuta=='1' && $id_tipo_pres!='1'){$reporte=new ReportDriver('repejec_ConsAFech.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='1' && $id_tipo_pres=='1'){$reporte=new ReportDriver('repejec_ConsAFech_rec.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='2' && $id_tipo_pres!='1'){$reporte=new ReportDriver('repejec_ConsEFech.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='2' && $id_tipo_pres=='1'){$reporte=new ReportDriver('repejec_ConsEFech_rec.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='3' && $id_tipo_pres!='1'){$reporte=new ReportDriver('repejec_ConsPFech.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='3' && $id_tipo_pres=='1'){$reporte=new ReportDriver('repejec_ConsPFech_rec.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='4' && $id_tipo_pres!='1'){$reporte=new ReportDriver('repejec_ConsPFech.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='4' && $id_tipo_pres=='1'){$reporte=new ReportDriver('repejec_ConsPFech_rec.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='5' && $sw_eplis!='EP'){$reporte=new ReportDriver('repejec_ConsGes.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='5' && $sw_eplis=='EP'){$reporte=new ReportDriver('repejec_ConsGesP.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='6'){$reporte=new ReportDriver('repejec_ConsTrim.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='7'){$reporte=new ReportDriver('repejec_ConsMes.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='8' && $sw_eplis!='EP'){$reporte=new ReportDriver('repejec_ConsGes.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='8' && $sw_eplis=='EP'){$reporte=new ReportDriver('repejec_ConsGesP.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='9' && $id_tipo_pres!='1'){$reporte=new ReportDriver('repejec_ConsParAFec.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='9' && $id_tipo_pres=='1'){$reporte=new ReportDriver('repejec_ConsParAFec_rec.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='10'){$reporte=new ReportDriver('repejec_ConsParGes.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='11' && $id_tipo_pres!='1'){$reporte=new ReportDriver('repejec_ConsParEFec.jasper','sci',$tipo_reporte);}
				if($sw_ejecuta=='11' && $id_tipo_pres=='1'){$reporte=new ReportDriver('repejec_ConsParEFec_rec.jasper','sci',$tipo_reporte);}
			}
			$reporte->addParametro('imagen_ende','../../../lib/images/logo_reporte_corp.jpg');
		}
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
		$reporte->addParametro('ip_origen',$_SESSION['ss_ip']);
		$reporte->addParametro('mac_maquina',$_SESSION['ss_mac']);
		$reporte->addParametro('sw_admi',$sw_admi);
		
		if($sw_vista=='ejecutar'){
			if($sw_ejecuta=='3'){$reporte->addParametro('id_codproc','PR_EJEPFEC_SEL');}
			if($sw_ejecuta=='4'){$reporte->addParametro('id_codproc','PR_EJEMFEC_SEL');}
			if($sw_ejecuta=='5'){$reporte->addParametro('id_codproc','PR_EJEGES_SEL');}
			if($sw_ejecuta=='8'){$reporte->addParametro('id_codproc','PR_EJEAMES_SEL');}
			if($sw_ejecuta=='5' || $sw_ejecuta=='6' || $sw_ejecuta=='7' || $sw_ejecuta=='8'){$reporte->addParametro('sw_sql',$sw_sql);}
			if($sw_ejecuta=='9'){$reporte->addParametro('id_partida',$id_partida);$reporte->addParametro('desc_partida',$desc_partida);}
			if($sw_ejecuta=='11'){$reporte->addParametro('id_partida',$id_partida);$reporte->addParametro('desc_partida',$desc_partida);}
			$reporte->addParametro('fecha_ini',$fecha_ini);
			$reporte->addParametro('fecha_fin',$fecha_fin);
			$reporte->addParametro('sw_mes',$sw_mes);
			$reporte->addParametro('sw_trim',$sw_trim);
			$reporte->addParametro('sw_impre',$sw_impre);
		}
		
		$reporte->addParametro('id_parametro',$id_parametro,'Integer');
		$reporte->addParametro('id_tipo_pres',$id_tipo_pres);
		$reporte->addParametro('id_moneda',$id_moneda,'Integer');
		$reporte->addParametro('sw_nivel',$sw_nivel);
		
		$reporte->addParametro('sw_ppto',$sw_ppto);
		$reporte->addParametro('sw_cprog',$sw_cprog);
		$reporte->addParametro('sw_ep_fina',$sw_ep_fina);
		$reporte->addParametro('sw_ep_regi',$sw_ep_regi);
		$reporte->addParametro('sw_ep_prog',$sw_ep_prog);
		$reporte->addParametro('sw_ep_proy',$sw_ep_proy);
		$reporte->addParametro('sw_ep_acti',$sw_ep_acti);
		$reporte->addParametro('sw_ep_uo',$sw_ep_uo);
		$reporte->addParametro('sw_cp_prog',$sw_cp_prog);
		$reporte->addParametro('sw_cp_proy',$sw_cp_proy);
		$reporte->addParametro('sw_cp_acti',$sw_cp_acti);
		$reporte->addParametro('sw_cp_fuen',$sw_cp_fuen);
		$reporte->addParametro('sw_cp_orga',$sw_cp_orga);
			
		$reporte->addParametro('ids_ppto',$ids_ppto);
		$reporte->addParametro('ids_cprog',$ids_cprog);
		$reporte->addParametro('ids_ep_fina',$ids_ep_fina);
		$reporte->addParametro('ids_ep_regi',$ids_ep_regi);
		$reporte->addParametro('ids_ep_prog',$ids_ep_prog);
		$reporte->addParametro('ids_ep_proy',$ids_ep_proy);
		$reporte->addParametro('ids_ep_acti',$ids_ep_acti);
		$reporte->addParametro('ids_ep_uo',$ids_ep_uo);
		$reporte->addParametro('ids_cp_prog',$ids_cp_prog);
		$reporte->addParametro('ids_cp_proy',$ids_cp_proy);
		$reporte->addParametro('ids_cp_acti',$ids_cp_acti);
		$reporte->addParametro('ids_cp_fuen',$ids_cp_fuen);
		$reporte->addParametro('ids_cp_orga',$ids_cp_orga);
		
		$reporte->addParametro('desc_moneda',$desc_moneda);
		$reporte->addParametro('desc_gestion',$desc_gestion);
		$reporte->addParametro('desc_tipo_pres',$desc_tipo_pres);
		$reporte->addParametro('desc_usuario',$_SESSION['ss_nombre_usuario']);
		if($tipo_reporte=='pdf'){
			$reporte->addParametro('sw_det',$sw_det);
		}
		$reporte->runReporte();
	}
?>
