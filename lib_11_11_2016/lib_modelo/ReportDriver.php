<?php
session_start();

class ReportDriver
{
	var $tipo_reporte;
	var $nombre_archivo;
	var $reporte;
	var $dir;
	function __construct($reporte,$sistema='no',$tipo_reporte='pdf',$logo='si',$usuario='si')
	{
		
		$this->dir=getcwd()."/";
		
		if(file_exists($reporte)){
		
			require_once("http://localhost:8087/JavaBridge/java/Java.inc");
			
			$this->reporte = new java("ReportDriver");
			if($logo!='no'){
				
				$this->addParametro('imagen_ende',$_SESSION['logo']);	
			}
			
			if($usuario=='si'){
				$this->addParametro('usuario',$_SESSION['ss_usuario']);
			}
			
			if($sistema!='no'){
				$this->addParametro('sistema',$sistema);
			}
			
			$this->addParametro('id_usuario',$_SESSION["ss_id_usuario"],'Integer');
			$this->addParametro('ip_cliente',$_SESSION["ss_ip"]);
			$this->crearReporte($reporte);
			$this->crearConexion();
			$this->tipo_reporte=$tipo_reporte;
		}
		else{
			echo "La dirección del reporte no se encuentra bien definida";
		}
	}
	
	function crearReporte($reporte){
		$this->nombre_archivo=uniqid(rand(), true);
		$this->nombre_archivo.=".".$this->tipo_reporte;
		//Le mando el nombre del archivo que tiene que generar y el nombre del archivo .jasper
		$this->reporte->setDatosReporte($this->nombre_archivo,$this->dir.$reporte);
	}
	
	function crearConexion(){
		$jdbc="jdbc:postgresql://".$_SESSION["HOST"]."/".$_SESSION["BASE_DATOS"];
		$this->reporte->crearConexion($jdbc,addslashes(htmlentities($_SESSION["BASE_DATOS"],ENT_QUOTES))."_".addslashes(htmlentities($_SESSION["ss_usuario"],ENT_QUOTES)), trim(addslashes(htmlentities($_SESSION["ss_contrasenia"],ENT_QUOTES))));
	}
	
	function addParametro($nombre,$valor,$tipo='',$formato=''){
		if($tipo==''){
			$this->reporte->addParametro($nombre,$valor);
		}
		else{
			$this->reporte->addParametro($nombre,$valor,$tipo,$formato);
		}
	}
	
	function addParametroURL($nombre,$valor){
		$this->reporte->addParametro($nombre,$this->dir.$valor);
	}
	
	function runReporte(){
		$this->reporte->runReporte($this->tipo_reporte);
		if(file_exists("/tmp/".$this->nombre_archivo)){
			header('Content-type: application/'.$this->tipo_reporte);
	
			// Se llamará documento.pdf
			header('Content-Disposition: inline; filename="documento.'.$this->tipo_reporte.'"');
			
			readfile("/tmp/".$this->nombre_archivo);
			unlink("/tmp/".$this->nombre_archivo);
		}
		else{
			echo "Ha ocurrido un error al generar el reporte.";
		}
	}
		
		
		
}
	
	
	
	
	
	
?>
