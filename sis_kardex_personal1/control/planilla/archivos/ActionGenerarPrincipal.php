<?php  
class GenerarPrincipal
{
	
	function GenerarPrincipal($id_planilla,$id_subsistema,$nombre,$codigo){
		
		$Custom = new cls_CustomDBKardexPersonal();
		$nombre_archivo = 'ActionGenerarRPrincipal.php';
		$bandera='no';
		
		$res=$Custom -> ListarArchivoPago(61,4);
		$id_subsistema=4;
		if ($res){
			
			if($id_subsistema==4){
					$fp=fopen("../../control/planilla/archivos/consultores/".$nombre, "w+");
			    
			}
			
			foreach ($Custom->salida as $f){
				$bandera=$f["id_cuenta_bancaria"];
				
				
				
				if($id_subsistema==5){
			  	   if($bandera!=$f["id_cuenta_bancaria"]){
			  	   	   $fp=fopen("../pago_".$f["id_cuenta_bancaria"].".txt", "w+");
			  	   }
				 
			    }
				
				fwrite($fp,$f["nro_cuenta"]);
				fwrite($fp,"\r\n");
			}
			
			
		}
		
		
		fclose($fp);
		
	   return '<a href="'+ direccion+"../../../interface/ruta_principal_"+val+'.txt">'+'Ruta Principal'+'</a>';
	  // return $res;	
	  
	
	   
	}
	
	
	
} 
?>