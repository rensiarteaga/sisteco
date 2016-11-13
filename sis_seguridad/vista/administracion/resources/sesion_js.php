<?php session_start(); ?>
//<script>

variable_tiempo = setInterval("verificar_sesion()",1201000);//se verifica la session cada 20 minutos y un segundo (1201000)

function verificar_sesion(){
	
	<?php
		// Primero miramos si la sesión es válida 
	 	if (isset($_SESSION["ID_SESSION"])) {  			
 			// Si lleva más de 20 minutos (1200 segundos) 
 			$antes = $_SESSION["SESION_TIME"];
 			
 			if (time()-$antes > 1200) {
 			 	$estado = 'sesion_caducada'; 
		 	}else {
		 		$estado = 'sesion_activa'; 
		 	}
	 	}
 		//echo "alert('aquiiiiii: $antes')"; 
 	?>	
	if ('<?php echo $estado ?>' == 'sesion_caducada'){
 		alert("Sesion caducada");
 		Docs.autenticarUsuario();//docs3_js.php
 	}else{
 		//Docs.mostrarAlerta();
 		//alert("Sesion caducada"); 		
 	} 	
}
