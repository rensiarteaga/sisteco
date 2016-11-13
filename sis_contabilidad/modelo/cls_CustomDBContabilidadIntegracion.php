<?php
/**
 * Nombre de la Clase:	    CustomDBContabilidad
 * Propósito:				Interfaz del modelo del Sistema de Contabilidad
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		02-10-2007
 * Autor:					Josè A. Mita Huanca
 *
 */
class cls_CustomDBcontabilidadIntegracion
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{			 
  		include_once("cls_DBENDESIS.php");
	}
	
 
	
	function TTSIntegracionRendicionCaja($id_caja,$id_caja_aux,$id_caja_auxiliar)
	{ 
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionRendicionCaja($id_caja,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}
	
	function TTSIntegracionSolicitudFondos($id_avance,$id_caja_aux,$id_caja_auxiliar)
	{ 
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionSolicitudFondos($id_avance,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}
	
	function TTSIntegracionDescargo($id_avance,$id_caja_aux,$id_caja_auxiliar)
	{ 
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionDescargo($id_avance,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}
	
	function TTSIntegracionViatico($id_viatico,$id_caja_aux,$id_caja_auxiliar)
	{ 
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionViatico($id_viatico,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}
	
	function TTSIntegracionViaticoRendicion($id_viatico,$id_caja_aux,$id_caja_auxiliar)
	{ 
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionViaticoRendicion($id_viatico,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}
	
	function TTSIntegracionViaticoFinalizacion($id_viatico,$id_caja_aux,$id_caja_auxiliar)
	{ 
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionViaticoFinalizacion($id_viatico,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}

	function TTSIntegracionValesCaja($id_caja_regis,$id_caja_aux,$id_caja_auxiliar)
	{ 
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionValesCaja($id_caja_regis,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}
	
	function TTSIntegracionDevengarServicios($id_devengado,$id_caja_aux,$id_caja_auxiliar)
	{ 
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionDevengarServicios($id_devengado,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}
	
	function TTSIntegracionPagoDevengado($id_devengado,$id_caja_aux,$id_caja_auxiliar)
	{ 
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionPagoDevengado($id_devengado,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}
}