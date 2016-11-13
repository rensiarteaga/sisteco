<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFEmpleadosDescAtrasos.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30000000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;
//para el ordenamiento
	if($sort == '') $sortcol = ' hisasi.id_lugar,nombre_lugar, contra.tipo_contrato,vemp.nombre_completo,vemp.codigo_empleado
     ';
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
	$puntero=$id_planilla;
	if ($_GET["reporte"]=='desc')
	 { 
	  
                 $criterio_filtro=' 0=0';
                 $sortcol="$fecha_ini";
              	 $res = $Custom->DescuentosEmpleadosHoras($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		  	     $_SESSION["PDF_empleados_descuentos_detalle"]=$Custom->salida;
	
	             if($res) $total_registros= $Custom->salida;
	             if($res)
	                { 
					 header("location:../../vista/_reportes/descuento/PDFEmpleadoDescAtraso.php");
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
		else{
		        $res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir," planil.id_planilla=".$id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				$_SESSION["PDF_cab_rep_planilla"]=$Custom->salida;   
	        	$res = $Custom->DatosEmpleadosAreas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				$_SESSION["PDF_datos_empleados"]=$Custom->salida;
		       if ($formato_reporte=='excel'){
			     /*$datosCabecera ['valor'] =array("nro_gral","nro_esp","nro_gral","nro_esp","nro_gral",
				                                 "nro_esp","nro_gral","nro_esp","nro_gral","nro_esp","nro_gral","nro_esp","nro_gral","nro_esp","nro_gral","nro_esp",);*/
			     $datosCabecera['valor'][0]='nro_gral';
				 $datosCabecera['valor'][1]='nro_esp';
				 $datosCabecera['valor'][2]='codigo_empleado';
				 $datosCabecera['valor'][3]='nombre_completo';
				 $datosCabecera['valor'][4]='doc_id';
				 $datosCabecera['valor'][5]='expedicion';
				 $datosCabecera['valor'][6]='fecha_nacimiento';
				 $datosCabecera['valor'][7]='nombre_cargo';
				 $datosCabecera['valor'][8]='cod_uniorg';
				 $datosCabecera['valor'][9]='cod_uniorg';
				 $datosCabecera['valor'][10]='distrito';
				 $datosCabecera['valor'][11]='piso';
				 $datosCabecera['valor'][12]='ofi';
				 $datosCabecera['valor'][13]='jerarquia';
				 $datosCabecera['valor'][14]='fecha_asignacion';
				 $datosCabecera['valor'][15]='fecha_finalizacion';
				 $datosCabecera['valor'][16]='valor';
	
				//$datosCabecera['valor'][8]='nombre_afp';
	
				 $datosCabecera['columna'][0]='Nº Gral.';
				 $datosCabecera['columna'][1]='Nº Esp.';
				 $datosCabecera['columna'][2]='CODIGO';
				 $datosCabecera['columna'][3]='APELLIDOS Y NOMBRES';
				 $datosCabecera['columna'][4]='C.I.';
				 $datosCabecera['columna'][5]='EXP.';
				 $datosCabecera['columna'][6]='F. DE NACIM';
				 $datosCabecera['columna'][7]='CARGO';
				$datosCabecera['columna'][8]='DEP.';
				$datosCabecera['columna'][9]='GER.';
				$datosCabecera['columna'][10]='DISTRITO';
				$datosCabecera['columna'][11]='PISO';
				$datosCabecera['columna'][12]='OFI.';
				$datosCabecera['columna'][13]='JERARQUIA';
				$datosCabecera['columna'][14]='INICIO';
				$datosCabecera['columna'][15]='CONCLUSION';
				$datosCabecera['columna'][16]='REMUN MES';
			
				$datosCabecera['width'][0]=120;
				$datosCabecera['width'][1]=120;
				$datosCabecera['width'][2]=120;
				$datosCabecera['width'][3]=120;
				$datosCabecera['width'][4]=120;
				$datosCabecera['width'][5]=120;
				$datosCabecera['width'][6]=120;
				$datosCabecera['width'][7]=120;
				$datosCabecera['width'][8]=200;
				$datosCabecera['width'][9]=120;
				$datosCabecera['width'][10]=120;
				$datosCabecera['width'][11]=120;
				$datosCabecera['width'][12]=120;
				$datosCabecera['width'][13]=120;
				$datosCabecera['width'][14]=120;
				$datosCabecera['width'][15]=120;
				$datosCabecera['width'][16]=120;
	
				$Excel = new GestionarExcel();
				$Excel->SetNombreReporte('Personal Planilla ');
				 $Excel->SetHoja('planilla');  
		        $Excel->SetFila(1);
		        $Excel->SetTitulo('DETALLE PERSONAL DE PLANTA EMPRESA NACIONAL DE ELECTRICIDAD E.N.D.E ',0,1,8); //Colocamos el titulo al reporte
		        $Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
				
	             $Excel->setDetalle($_SESSION["PDF_datos_empleados"]);
		         $Excel->setFin();	    
		
			   }else{
				$res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir," planil.id_planilla=".$id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				$_SESSION["PDF_cab_rep_planilla"]=$Custom->salida;   
	        	/*$res = $Custom->DatosEmpleadosAreas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				$_SESSION["PDF_datos_empleados"]=$Custom->salida;*/
				if($res) $total_registros= $Custom->salida;
				if($res)
				{ 
					header("location:../../vista/_reportes/empleado/PDFEmpleadosAreas.php");
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
			   
		}
	 
}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}
?>