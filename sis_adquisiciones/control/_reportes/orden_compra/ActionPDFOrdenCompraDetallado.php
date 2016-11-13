<?php
/**
**********************************************************
Nombre de archivo:	    ActionPDFListadoProcesos.php
Propósito:				Permite realizar el reporte de prestacion de servicios
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:	    15/03/2010
Versión:				1.0.0
Autor:					Ana Maria villegas
**********************************************************
*/
session_start();
include_once("../../LibModeloAdquisiciones.php");
include_once("../../../../lib/lib_control/GestionarExcel.php");
$Custom = new cls_CustomDBAdquisiciones();


$nombre_archivo = 'ActionPDFOrdenCompraDetallado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{ 
/*parametros para el formato excel
*/
 	/*$this->var->add_def_cols('id_cotizacion','integer');
       	$this->var->add_def_cols('numero_orden','text');
       	$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('fecha_orden_compra','text');
		$this->var->add_def_cols('categoria','varchar');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('nombre_proveedor','text');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('precio_unitario','numeric');
		$this->var->add_def_cols('total_bs','numeric');
		$this->var->add_def_cols('saldo_pagar','numeric');
		$this->var->add_def_cols('fecha_orden','date');*/
    $datosCabecera['valor'][0]='numero_orden';
	$datosCabecera['valor'][1]='descripción';
	$datosCabecera['valor'][2]='fecha_orden_compra';
	$datosCabecera['valor'][3]='categoria';
	$datosCabecera['valor'][4]='estado_vigente';
	$datosCabecera['valor'][5]='codigo_proceso';
	$datosCabecera['valor'][6]='nombre_proveedor';
	$datosCabecera['valor'][7]='observaciones';
	$datosCabecera['valor'][8]='cantidad';
	$datosCabecera['valor'][9]='precio_unitario';
	$datosCabecera['valor'][10]='total_bs';
	$datosCabecera['valor'][11]='saldo_pagar';
	//$datosCabecera['valor'][12]='fecha_orden';
	
	
	
	$datosCabecera['columna'][0]='Nro. OC.';
	$datosCabecera['columna'][1]='Descripción';
	$datosCabecera['columna'][2]='Fecha';
	$datosCabecera['columna'][3]='Categoria Compra';
	$datosCabecera['columna'][4]='Estado Proceso';
	$datosCabecera['columna'][5]='Codigo Proceso';
	$datosCabecera['columna'][6]='Proveedor';
	$datosCabecera['columna'][7]='Observaciones';
	$datosCabecera['columna'][8]='Cantidad';
	$datosCabecera['columna'][9]='Importe Unitario';
	$datosCabecera['columna'][10]='Importe Total';
	$datosCabecera['columna'][11]='Saldo a Pagar';
	
	$datosCabecera['width'][0]=50;
	$datosCabecera['width'][1]=150;
	$datosCabecera['width'][2]=50;
	$datosCabecera['width'][3]=100;
	$datosCabecera['width'][4]=80;
	$datosCabecera['width'][5]=80;
	$datosCabecera['width'][6]=150;
	$datosCabecera['width'][7]=150;
	$datosCabecera['width'][8]=50;
	$datosCabecera['width'][9]=90;
	$datosCabecera['width'][10]=90;
	
//Parámetros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id';
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
	//$cond = new cls_criterio_filtro($decodificar);
	$tipo_adq=$tipo_adquisicion;
    $id_proveedor=$proveedor;
    $fecha_inicio=$fecha_ini;
    $fecha_fin=$fecha_fin;
    $id_depto=$departamento;
    $id_ep=$id_ep;
    $id_uo=$id_unidad_organizacional;
    
    //////
    $id_ges=$id_gestion;
    $rango=$rango_monto;
    $valor=$importe;
    $id_parti=$id_partida;
    $ges=$gestion;
    
   // echo $valor.'---'; exit;
    /*********************/
  
	   
	    $sortdir='asc';	    
	    if($tipo_reporte!=4){
	    
	       $criterio_filtro="COT.fecha_orden_compra>= ''$fecha_inicio''";
	       $criterio_filtro=$criterio_filtro."  AND COT.fecha_orden_compra<= ''$fecha_fin''";
	        	
	    }else{
	    	$criterio_filtro=" 0=0";
	    	
	    	
	    }
	    $sortcol="COT.fecha_orden_compra,PERIOD.periodo || '' / '' || COT.num_orden_compra";
	    $criterio_filtro=$criterio_filtro." AND PROCOM.id_depto=".$id_depto;
	    if($id_proveedor!='%'){
	     	$criterio_filtro=$criterio_filtro.'  AND COT.id_proveedor='.$id_proveedor;
	    }
	    if($id_ep!='%'){
	    	$criterio_filtro=$criterio_filtro.'  AND PROCOM.id_proceso_compra IN (SELECT PROCOM.id_proceso_compra
                                                                                  FROM compro.tad_proceso_compra PROCOM
                                                                                  INNER JOIN compro.tad_solicitud_proceso_compra SOLPRO
                                                                                  ON SOLPRO.id_proceso_compra=PROCOM.id_proceso_compra
                                                                                  INNER JOIN compro.tad_solicitud_compra SOLCOM
                                                                                  ON SOLCOM.id_solicitud_compra=SOLPRO.id_solicitud_compra
                                                                                  WHERE SOLCOM.id_fina_regi_prog_proy_acti='.$id_ep.')';
	    }
	    if($id_uo!='%'){
	    	$criterio_filtro=$criterio_filtro.'  AND PROCOM.id_proceso_compra IN (SELECT PROCOM.id_proceso_compra
                                                                                  FROM compro.tad_proceso_compra PROCOM
                                                                                  INNER JOIN compro.tad_solicitud_proceso_compra SOLPRO
                                                                                  ON SOLPRO.id_proceso_compra=PROCOM.id_proceso_compra
                                                                                  INNER JOIN compro.tad_solicitud_compra SOLCOM
                                                                                  ON SOLCOM.id_solicitud_compra=SOLPRO.id_solicitud_compra
                                                                                  WHERE SOLCOM.id_unidad_organizacional='.$id_uo.')';
	    }
	    
	   
	    	if($tipo_adq=='Bien'){
	    		$criterio_filtro=$criterio_filtro."  AND COTDET1.id_item_aprobado IS NOT NULL ";
	    		
	    		if($id_item!=''){
	    		    $criterio_filtro=$criterio_filtro." AND COTDET1.id_item_aprobado like ''$id_item'' ";
				}
	    	}
		    elseif ($tipo_adq=='Servicio'){
	    		$criterio_filtro=$criterio_filtro."  AND COTDET1.id_servicio IS NOT NULL ";
	    		
	    		if($id_item!=''){
	    		    $criterio_filtro=$criterio_filtro." AND COTDET1.id_servicio like ''$id_servicio'' ";
				}
	    		
	    	}
	   
	    
	 
    //Obtiene el conjunto de datos de la consulta
   
	 $_SESSION["PDF_unidad_organizacional"]=$unidad_organizacional;
     $_SESSION["PDF_departamento"]=$nombre_departamento;
     $_SESSION["PDF_desc_ep"]=$desc_ep;
     $_SESSION["PDF_nombre_proveedor"]=$nombre_proveedor;
     $_SESSION["PDF_rep_fecha_inicio"]=$rep_fecha_ini;
     $_SESSION["PDF_rep_fecha_fin"]=$rep_fecha_fin;
     $_SESSION["PDF_tipo_adq"]=$tipo_adq;
     
     
     //31Oct11: para reporte Detalle General de OC
     $_SESSION["PDF_id_gestion"]=$id_ges;
     $_SESSION["PDF_gestion"]=$ges;
     if(isset($id_parti) && $id_parti!=''){
        if($id_parti!='%'){
     	      $criterio_filtro=$criterio_filtro.'  AND partid.id_partida='.$id_parti;
	    }
     }
     
	    
	 if(isset($ges) && $ges!=''){
	 	$criterio_filtro=$criterio_filtro. " and PROCOM.gestion=$ges";
	 }
	    
	    
     $_SESSION["PDF_id_partida"]=$id_parti;
     if($rango=='mayores'){
        $criterio_filtro=$criterio_filtro. ' AND COT.precio_total >='. $valor;}
        elseif ($rango=='menores'){
        	$criterio_filtro=$criterio_filtro. ' AND COT.precio_total <'. $valor;}
        
     	
     $_SESSION["PDF_filtro"]=$rango;
     $_SESSION["PDF_importe"]=$valor;
     if($_SESSION["ss_id_usuario"]==120){
     	echo $criterio_filtro; exit;
     }
    
     if ($tipo_reporte==2){
	     
  	     if ($tip_rep=='EXCEL')
        	{
			  $res=$Custom->ListarListaOCDetallado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	          $data=$Custom->salida;
			  //foreach ($data as $row){
			  $Excel = new GestionarExcel();
		      $Excel->SetNombreReporte('Detalle Ordenes Compra');
              $Excel->SetHoja('Primera');  
		      $Excel->SetFila(1);
		      $Excel->SetTitulo(' LISTA DE ORDENES DE COMPRA A DETALLE ',0,1,8); //Colocamos el titulo al reporte
		      $Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
			  $Excel->setDetalle($data);
			  $Excel->setFin();		
			
            }
         else{
		 

   			$res=$Custom->ListarListaOCDetallado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	        $_SESSION["PDF_ordenes_compra"]=$Custom->salida;
   
   
			if($res) $total_registros= $Custom->salida;
			if($res){
				header("location: ../../../vista/_reportes/orden_compra/PDFListaOrdenCompraDetallado.php");
	
			}
			else{
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
    }else {  /************************* Inicio reporte iReport**********************/
    	if ($tipo_reporte==3){
    		
    		  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  					$tipo_adq=$_POST['tipo_adquisicion'];
  					$id_proveedor=$_POST['proveedor'];
		  			$id_depto=$_POST['departamento'];
		  			$id_ep=$_POST['id_ep'];
		  			$id_uo=$_POST['id_unidad_organizacional'];
		 		    $desc_ep=$_POST['desc_ep'];
		  			$nombre_proveedor=$_POST['nombre_proveedor'];
		  			$nombre_departamento=$_POST['nombre_departamento'];
		  			$tipo_rep=$_POST['tipo_rep'];
		  			$unidad_organizacional=$_POST['unidad_organizacional'];
			  } else {
  					$tipo_adq=$_GET['tipo_adquisicion'];
		  			$id_proveedor=$_GET['proveedor'];
		  			$id_depto=$_GET['departamento'];
		  			$id_ep=$_GET['id_ep'];
		  			$id_uo=$_GET['id_unidad_organizacional'];
		  			$tipo_rep=$_GET['tipo_rep'];
		  			$desc_ep=$_GET['desc_ep'];
		  			$unidad_organizacional=$_GET['unidad_organizacional'];
		  			$nombre_proveedor=$_GET['nombre_proveedor']; 
		  			$nombre_departamento=$_GET['nombre_departamento'];
		
		  	  }
	    		$cant=15;
			    $puntero=0;
			    $sortcol="COT.fecha_orden_compra,PERIOD.periodo || '' / '' || COT.num_orden_compra";
			    $sortdir='asc';	    
			    $criterio_filtro="COT.fecha_orden_compra>= '$fecha_inicio'";
			    $criterio_filtro=$criterio_filtro."  AND COT.fecha_orden_compra<= '$fecha_fin'";
			    $criterio_filtro=$criterio_filtro." AND PROCOM.id_depto=".$id_depto;
		    	
		    	if($id_proveedor!='%'){
	     			$criterio_filtro=$criterio_filtro.'  AND COT.id_proveedor='.$id_proveedor;
	    		}
	    		if($id_ep!='%'){
	    			$criterio_filtro=$criterio_filtro.'  AND PROCOM.id_proceso_compra IN (SELECT PROCOM.id_proceso_compra
                                                                                  FROM compro.tad_proceso_compra PROCOM
                                                                                  INNER JOIN compro.tad_solicitud_proceso_compra SOLPRO
                                                                                  ON SOLPRO.id_proceso_compra=PROCOM.id_proceso_compra
                                                                                  INNER JOIN compro.tad_solicitud_compra SOLCOM
                                                                                  ON SOLCOM.id_solicitud_compra=SOLPRO.id_solicitud_compra
                                                                                  WHERE SOLCOM.id_fina_regi_prog_proy_acti='.$id_ep.')';
	    }
	    		if($id_uo!='%'){
	    			$criterio_filtro=$criterio_filtro.'  AND PROCOM.id_proceso_compra IN (SELECT PROCOM.id_proceso_compra
                                                                                  FROM compro.tad_proceso_compra PROCOM
                                                                                  INNER JOIN compro.tad_solicitud_proceso_compra SOLPRO
                                                                                  ON SOLPRO.id_proceso_compra=PROCOM.id_proceso_compra
                                                                                  INNER JOIN compro.tad_solicitud_compra SOLCOM
                                                                                  ON SOLCOM.id_solicitud_compra=SOLPRO.id_solicitud_compra
                                                                                  WHERE SOLCOM.id_unidad_organizacional='.$id_uo.')';
	    		}
	    		if($tipo_adq=='Bien'){
	    			$criterio_filtro=$criterio_filtro.'  AND COTDET1.id_item_aprobado IS NOT NULL';
	    		}
	    		elseif ($tipo_adq=='Servicio'){
	    			$criterio_filtro=$criterio_filtro.'  AND COTDET1.id_servicio IS NOT NULL';
	    		}
  			
  				require_once('../../../../lib/lib_modelo/ReportDriver.php');
					switch ($tipo_rep) {
    					case 'PDF'://pdf
       						$reporte=new ReportDriver('reporte_orden_compra_audi.jasper','COMPRO','pdf');
       					break;
    					case 'WORD'://word
       						$reporte=new ReportDriver('reporte_orden_compra_audi.jasper','COMPRO','rtf');
       					break;
    					case 'EXCEL'://excel
     						$reporte=new ReportDriver('reporte_orden_compra_audi.jasper','COMPRO','xls');
       			
      					break;	
					}
      				$reporte->addParametro('fecha_inicio',$fecha_inicio,'Date','MM/dd/yyyy');
					$reporte->addParametro('fecha_fin',$fecha_fin,'Date','MM/dd/yyyy');
					$reporte->addParametro('nombre_usuario',utf8_decode($nombre_usuario));
					$reporte->addParametro('codigo_procedimiento',$codigo_procedimiento_cons);
					
					$reporte->addParametro('tipo_adq',$tipo_adq);
					$reporte->addParametro('ep',$desc_ep);
					$reporte->addParametro('uo',$unidad_organizacional);
					$reporte->addParametro('departamento',$nombre_departamento);
					$reporte->addParametro('proveedor',$nombre_proveedor);
					$reporte->addParametro('criterio_filtro',$criterio_filtro);
				
					$reporte->runReporte();
				
    	}/***********************fin del reporte***********************/
    	else{
    		
    		if($tipo_reporte==4){
    			//echo $criterio_filtro; exit;
    			
    			     $res=$Custom->ListarDetalleGeneralOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	 				 $_SESSION["PDF_ordenes_compra_general"]=$Custom->salida;
   
   
					if($res) $total_registros= $Custom->salida;
					if($res){
						header("location: ../../../vista/_reportes/orden_compra/PDFListaGeneralOrdenCompra.php");
					}
					else{
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
    			
    			
    		}else{
    		 		$tipo_adq=$tipo_adquisicion;
		    		$id_proveedor=$proveedor;
		    		$fecha_inicio=$fecha_ini;
		    		$fecha_fin=$fecha_fin;
		    		$id_depto=$departamento;
		    		$id_ep=$id_ep;
		    		$id_uo=$id_unidad_organizacional;
					header("location: ../../../vista/_reportes/orden_compra/PDFListaOrdenCompra.php?tipo_adq=".$tipo_adq."&id_proveedor=".$id_proveedor."&fecha_inicio=".$fecha_inicio."&fecha_fin=".$fecha_fin."&id_depto=".$id_depto."&id_ep=".$id_ep."&id_uo=".$id_uo);
    		}
			
    	}
    	    	
    
    }
    
}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}?>