<?php
/**
 * Nombre de la Clase:	    CustomDBControlAsistencia
 * Propósito:				es la interfaz del modelo del Sistema de Control de Asistencia
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		20-08-2007
 * Autor:					Fernando Prudencio Cardona
 *
 */
class cls_CustomDBControlAsistencia
{
	//variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida = "";

	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query = "";

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBFeriados.php");
		include_once("cls_DBFeriado.php");
		include_once("cls_DBHistoricoLectura.php");
		include_once("cls_DBLecturaProcesada.php");
		include_once("cls_DBLecturaReloj.php");
		include_once("cls_DBLecturaDepurada.php");
        include_once("cls_DBSueldo.php");		
        include_once("cls_DBDescuento.php");		
        include_once("cls_DBResumenMarcasDia.php");
		
	}

	/////////////// FERIADO /////////////////////

	function ListarFeriado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriados($this->decodificar);
		$res = $dbFeriado ->ListarFeriado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function ContarListaFeriado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFeriado= new cls_DBFeriados($this->decodificar);
		$res = $dbFeriado ->ContarListaFeriado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function CrearFeriado($id_feriados,$fecha,$motivo)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriados($this->decodificar);
		$res = $dbFeriado ->CrearFeriado($id_feriados,$fecha,$motivo);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function EliminarFeriado($id_feriados)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriados($this->decodificar);
		$res = $dbFeriado -> EliminarFeriado($id_feriados);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function ModificarFeriado($id_feriados,$fecha,$motivo)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriados($this->decodificar);
		$res = $dbFeriado ->ModificarFeriado($id_feriados,$fecha,$motivo);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function ValidarFeriado($operacion_sql,$id_feriados,$fecha,$motivo)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriados($this->decodificar);
		$res = $dbFeriado ->ValidarFeriado($operacion_sql,$id_feriados,$fecha,$motivo);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}

	/////////////   FIN  FERIADO /////////////////////////////

/////////////// FERIADO /////////////////////

	function ListarFeriado_($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriado($this->decodificar);
		$res = $dbFeriado ->ListarFeriado_($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function ContarListaFeriado_($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFeriado= new cls_DBFeriado($this->decodificar);
		$res = $dbFeriado ->ContarListaFeriado_($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function CrearFeriado_($id_feriado,$fecha_feriado,$motivo,$feriado_nacional,$id_lugar)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriado($this->decodificar);
		$res = $dbFeriado ->CrearFeriado_($id_feriado,$fecha_feriado,$motivo,$feriado_nacional,$id_lugar);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function EliminarFeriado_($id_feriado)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriado($this->decodificar);
		$res = $dbFeriado -> EliminarFeriado_($id_feriado);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function ModificarFeriado_($id_feriado,$fecha_feriado,$motivo,$feriado_nacional,$id_lugar)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriado($this->decodificar);
		$res = $dbFeriado ->ModificarFeriado_($id_feriado,$fecha_feriado,$motivo,$feriado_nacional,$id_lugar);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}
	function ValidarFeriado_($operacion_sql,$id_feriado,$fecha_feriado,$motivo,$feriado_nacional,$id_lugar)
	{
		$this->salida = "";
		$dbFeriado = new cls_DBFeriado($this->decodificar);
		$res = $dbFeriado ->ValidarFeriado_($operacion_sql,$id_feriado,$fecha_feriado,$motivo,$feriado_nacional,$id_lugar);
		$this->salida = $dbFeriado->salida;
		$this->query = $dbFeriado->query;
		return $res;
	}

	/////////////   FIN  FERIADO /////////////////////////////

/////////////// HISTORICO LECTURA /////////////////////

	function ListarHistoricoLectura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbHistoricoLectura = new cls_DBHistoricoLectura($this->decodificar);
		$res = $dbHistoricoLectura ->ListarHistoricoLectura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHistoricoLectura->salida;
		$this->query = $dbHistoricoLectura->query;
		return $res;
	}
	function ContarListaHistoricoLectura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbHistoricoLectura= new cls_DBHistoricoLectura($this->decodificar);
		$res = $dbHistoricoLectura ->ContarListaHistoricoLectura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHistoricoLectura->salida;
		$this->query = $dbHistoricoLectura->query;
		return $res;
	}
	function CrearHistoricoLectura($id_historico_lectura,$hora,$tipo_movimiento,$id_lectura_procesada)
	{
		$this->salida = "";
		$this->query = "";
		$dbHistoricoLectura = new cls_DBHistoricoLectura($this->decodificar);
		$res = $dbHistoricoLectura ->CrearHistoricoLectura($id_historico_lectura,$hora,$tipo_movimiento,$id_lectura_procesada);
		$this->salida = $dbHistoricoLectura->salida;
		$this->query = $dbHistoricoLectura->query;
		return $res;
	}
	function EliminarHistoricoLectura($id_historico_lectura)
	{
		$this->salida = "";
		$this->query = "";
		$dbHistoricoLectura = new cls_DBHistoricoLectura($this->decodificar);
		$res = $dbHistoricoLectura -> EliminarHistoricoLectura($id_historico_lectura);
		$this->salida = $dbHistoricoLectura->salida;
		$this->query = $dbHistoricoLectura->query;
		return $res;
	}
	function ModificarHistoricoLectura($id_historico_lectura,$hora,$tipo_movimiento,$id_lectura_procesada)
	{
		$this->salida = "";
		$this->query = "";
		$dbHistoricoLectura = new cls_DBHistoricoLectura($this->decodificar);
		$res = $dbHistoricoLectura ->ModificarHistoricoLectura($id_historico_lectura,$hora,$tipo_movimiento,$id_lectura_procesada);
		$this->salida = $dbHistoricoLectura->salida;
		$this->query = $dbHistoricoLectura->query;
		return $res;
	}
	function ValidarHistoricoLectura($operacion_sql,$id_historico_lectura,$hora,$tipo_movimiento,$id_lectura_procesada)
	{
		$this->salida = "";
		$this->query = "";
		$dbHistoricoLectura = new cls_DBHistoricoLectura($this->decodificar);
		$res = $dbHistoricoLectura ->ValidarHistoricoLectura($operacion_sql,$id_historico_lectura,$hora,$tipo_movimiento,$id_lectura_procesada);
		$this->salida = $dbHistoricoLectura->salida;
		$this->query = $dbHistoricoLectura->query;
		return $res;
	}

	/////////////   FIN  HISTORICO LECTURA /////////////////////////////

	
	/////////////// LECTURA PROCESADA /////////////////////

	function ListarLecturaProcesada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaProcesada = new cls_DBLecturaProcesada($this->decodificar);
		$res = $dbLecturaProcesada ->ListarLecturaProcesada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaProcesada->salida;
		$this->query = $dbLecturaProcesada->query;
		return $res;
	}
	function ContarListaLecturaProcesada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaProcesada= new cls_DBLecturaProcesada($this->decodificar);
		$res = $dbLecturaProcesada ->ContarListaLecturaProcesada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaProcesada->salida;
		$this->query = $dbLecturaProcesada->query;
		return $res;
	}
	function CrearLecturaProcesada($id_lectura_procesada,$fecha,$horas_trabajadas,$horas_no_trab_con_permiso,$horas_no_trab_sin_permiso,$horas_extras,$tipo_permiso,$aprobado,$especial,$total_horas_trabajadas,$observaciones,$id_empleado)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaProcesada = new cls_DBLecturaProcesada($this->decodificar);
		$res = $dbLecturaProcesada ->CrearLecturaProcesada($id_lectura_procesada,$fecha,$horas_trabajadas,$horas_no_trab_con_permiso,$horas_no_trab_sin_permiso,$horas_extras,$tipo_permiso,$aprobado,$especial,$total_horas_trabajadas,$observaciones,$id_empleado);
		$this->salida = $dbLecturaProcesada->salida;
		$this->query = $dbLecturaProcesada->query;
		return $res;
	}
	function EliminarLecturaProcesada($id_lectura_procesada)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaProcesada = new cls_DBLecturaProcesada($this->decodificar);
		$res = $dbLecturaProcesada -> EliminarLecturaProcesada($id_lectura_procesada);
		$this->salida = $dbLecturaProcesada->salida;
		$this->query = $dbLecturaProcesada->query;
		return $res;
	}
	function ModificarLecturaProcesada($id_lectura_procesada,$fecha,$horas_trabajadas,$horas_no_trab_con_permiso,$horas_no_trab_sin_permiso,$horas_extras,$tipo_permiso,$aprobado,$especial,$total_horas_trabajadas,$observaciones,$id_empleado)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaProcesada = new cls_DBLecturaProcesada($this->decodificar);
		$res = $dbLecturaProcesada ->ModificarLecturaProcesada($id_lectura_procesada,$fecha,$horas_trabajadas,$horas_no_trab_con_permiso,$horas_no_trab_sin_permiso,$horas_extras,$tipo_permiso,$aprobado,$especial,$total_horas_trabajadas,$observaciones,$id_empleado);
		$this->salida = $dbLecturaProcesada->salida;
		$this->query = $dbLecturaProcesada->query;
		return $res;
	}
	function ValidarLecturaProcesada($operacion_sql,$id_lectura_procesada,$fecha,$horas_trabajadas,$horas_no_trab_con_permiso,$horas_no_trab_sin_permiso,$horas_extras,$tipo_permiso,$aprobado,$especial,$total_horas_trabajadas,$observaciones,$id_empleado)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaProcesada = new cls_DBLecturaProcesada($this->decodificar);
		$res = $dbLecturaProcesada ->ValidarLecturaProcesada($operacion_sql,$id_lectura_procesada,$fecha,$horas_trabajadas,$horas_no_trab_con_permiso,$horas_no_trab_sin_permiso,$horas_extras,$tipo_permiso,$aprobado,$especial,$total_horas_trabajadas,$observaciones,$id_empleado);
		$this->salida = $dbLecturaProcesada->salida;
		$this->query = $dbLecturaProcesada->query;
		return $res;

	}

	/////////////   FIN LECTURA PROCESADA /////////////////////////////


	///////////////  LECTURA RELOJ /////////////////////

	function ListarLecturaReloj($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj = new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj ->ListarLecturaReloj($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	function ListarLecturaRelojOrig($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj = new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj ->ListarLecturaRelojOrig($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	function ListarDistintoLecturaReloj($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj = new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj ->ListarDistintoLecturaReloj($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	
	function ContarListaLecturaReloj($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->ContarListaLecturaReloj($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	function ContarListaLecturaRelojDistinto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->ContarListaLecturaRelojDistinto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	
	function ProcesarArchivo($nombre_archivo)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->ProcesarArchivo($nombre_archivo);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	function CrearLecturaReloj($id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj = new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->CrearLecturaReloj($id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	
	function EliminarLecturaReloj($id_lectura_reloj)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj = new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj -> EliminarLecturaReloj($id_lectura_reloj);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	
	function ModificarLecturaReloj($id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj ->ModificarLecturaReloj($id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
	
		return $res;
	}
	function ValidarLecturaReloj($operacion_sql,$id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->ValidarLecturaReloj($operacion_sql,$id_lectura_reloj,$codigo_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	
	function  Descuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin,$tipo_contrato)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->Descuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin,$tipo_contrato);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	function  ResumenSemanalDescuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin,$tipo_contrato)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->ResumenSemanalDescuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin,$tipo_contrato);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	function  ResumenMensualDescuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin,$tipo_contrato)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->ResumenMensualDescuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin,$tipo_contrato);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	function  ExisteDescuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->ExisteDescuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini,$fecha_fin);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	
	//05.2015
	function ProcesarArchivoCsv($arr_temp0, $fecha,$hora, $marca)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->ProcesarArchivoCsv($arr_temp0, $fecha,$hora, $marca);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	
	/////////////   FIN LECTURA RELOJ /////////////////////////////
	
	/////////////   SUELDO  /////////////////////////////

	function ListarSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo -> ListarSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSueldo->salida;
		$this->query = $dbSueldo->query;
		return $res;
	}
	function ContarListaSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo->ContarListaSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSueldo->salida;
		$this->query = $dbSueldo->query;
		return $res;
	}
	function CrearSueldo($id_sueldo,$codigo_empleado,$sueldo,$tipo_contrato)
	{
		$this->salida="";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo ->CrearSueldo($id_sueldo,$codigo_empleado,$sueldo,$tipo_contrato);
		$this->salida = $dbSueldo ->salida ;
		$this->query = $dbSueldo->query;
		return $res;
	}
	function EliminarSueldo($id_sueldo)
	{
		$this->salida= "";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo ->EliminarSueldo($id_sueldo);
		$this->salida = $dbSueldo ->salida;
		$this->query = $dbSueldo->query;
		return $res;
	}
	function ModificarSueldo($id_sueldo,$codigo_empleado,$sueldo,$tipo_contrato)
	{
		$this->salida="";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo ->ModificarSueldo($id_sueldo,$codigo_empleado,$sueldo,$tipo_contrato);
		$this->salida = $dbSueldo->salida;
		$this->query = $dbSueldo->query;
		return $res;
	}
	function ValidarSueldo($operacion_sql,$id_sueldo,$id_empleado,$sueldo)
	{
		$this->salida = "";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo ->ValidarSueldo($operacion_sql,$id_sueldo,$id_empleado,$sueldo);
		$this->salida = $dbSueldo->salida;
		$this->query = $dbSueldo->query;
		return $res;
	}
	function ListarSueldoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_sueldo)
    {
		$this->salida = "";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo ->ListarSueldoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_sueldo);
		$this->salida = $dbSueldo->salida;
		$this->query = $dbSueldo->query;
		return $res;
	}
	
	function ListarEmpleadoSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_sueldo)
    {
		$this->salida = "";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo ->ListarEmpleadoSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_sueldo);
		$this->salida = $dbSueldo->salida;
		$this->query = $dbSueldo->query;
		return $res;
	}
	function MaximoSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
	    $this->salida = "";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo ->MaximoSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSueldo->salida;
		$this->query = $dbSueldo->query;
		return $res;	
		
	}
	function ListarEmpleadoDistinto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
	    $this->salida = "";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo ->ListarEmpleadoDistinto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSueldo->salida;
		$this->query = $dbSueldo->query;
		return $res;	
		
	}
	function ContarListaEmpleadoDistinto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$this->query = "";
		$dbSueldo = new cls_DBSueldo($this->decodificar);
		$res = $dbSueldo->ContarListaEmpleadoDistinto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSueldo->salida;
		$this->query = $dbSueldo->query;
		return $res;
	}
	
	/////////////// FIN SUELDO  /////////////////////
	
	
   /////////////   DESCUENTO  /////////////////////////////

	function CrearDescuento($id_descuento,$id_empleado,$sueldo,$fecha_inicio,$fecha_fin,$tiempo_no_trab,$descuento,$observaciones)
	{
		$this->salida="";
		$this->query = "";
		$dbDescuento = new cls_DBDescuento($this->decodificar);
		$res = $dbDescuento ->CrearDescuento($id_descuento,$id_empleado,$sueldo,$fecha_inicio,$fecha_fin,$tiempo_no_trab,$descuento,$observaciones);
		$this->salida = $dbDescuento ->salida ;
		$this->query = $dbDescuento->query;
		return $res;
	}
	
	function EliminarRepetidos()
	{
		$this->salida="";
		$this->query = "";
		$dbDescuento = new cls_DBDescuento($this->decodificar);
		$res = $dbDescuento ->EliminarRepetidos();
		$this->salida = $dbDescuento ->salida ;
		$this->query = $dbDescuento->query;
		return $res;
	}
   function EliminarDescuento($txt_fecha_ini)
	{
		$this->salida="";
		$this->query = "";
		$dbDescuento = new cls_DBDescuento($this->decodificar);
		$res = $dbDescuento ->EliminarDescuento($txt_fecha_ini);
		$this->salida = $dbDescuento ->salida ;
		$this->query = $dbDescuento->query;
		return $res;
	}
	
	function DiferenciaDias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$txt_fecha_fin)
	{
		$this->salida="";
		$this->query = "";
		$dbDescuento = new cls_DBDescuento($this->decodificar);
		$res = $dbDescuento ->DiferenciaDias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$txt_fecha_fin);
		$this->salida = $dbDescuento ->salida ;
		$this->query = $dbDescuento->query;
		return $res;
	}
	
	function SumaDiasFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$txt_fecha_fin)
	{
		$this->salida="";
		$this->query = "";
		$dbDescuento = new cls_DBDescuento($this->decodificar);
		$res = $dbDescuento ->SumaDiasFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$txt_fecha_fin);
		$this->salida = $dbDescuento ->salida ;
		$this->query = $dbDescuento->query;
		return $res;
	}
	
	function SumaDiasInicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$txt_fecha_fin)
	{
		$this->salida="";
		$this->query = "";
		$dbDescuento = new cls_DBDescuento($this->decodificar);
		$res = $dbDescuento ->SumaDiasInicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$txt_fecha_fin);
		$this->salida = $dbDescuento ->salida ;
		$this->query = $dbDescuento->query;
		return $res;
	}
	/////////////// FIN DESCUENTO  /////////////////////
	///////////////  LECTURA DEPURADA /////////////////////

	function ListarLecturaDepurada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ListarLecturaDepurada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	
	function ContarListaLecturaDepurada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada= new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada->ContarListaLecturaDepurada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function ListarLecturaDepuradaAprobado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ListarLecturaDepuradaAprobado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	
	function ContarListaLecturaDepuradaAprobado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada= new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada->ContarListaLecturaDepuradaAprobado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function ListarLecturaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ListarLecturaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	
	function ContarListaLecturaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada= new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada->ContarListaLecturaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function InsertarLecturaDepurada($id_lectura_depurada,$id_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno,$aprobado)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada->InsertarLecturaDepurada($id_lectura_depurada,$id_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno,$aprobado);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	
	function EliminarLecturaDepurada($id_lectura_depurada,$id_empleado,$fecha)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada -> EliminarLecturaDepurada($id_lectura_depurada,$id_empleado,$fecha);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function ModificarLecturaDepurada($id_lectura_depurada,$id_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno,$aprobado)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada= new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ModificarLecturaDepurada($id_lectura_depurada,$id_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno,$aprobado);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;	
		return $res;
	}
	function ValidarLecturaDepurada($operacion_sql,$id_lectura_depurada,$id_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno,$aprobado)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada= new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada->ValidarLecturaDepurada($operacion_sql,$id_lectura_depurada,$id_empleado,$fecha,$hora,$tipo_movimiento,$observaciones,$turno,$aprobado);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function ListarDetalleMarcas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ListarDetalleMarcas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function ListarDetalleNoTrab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ListarDetalleNoTrab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function ListarTiempoNoTrab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ListarTiempoNoTrab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function ListarDetalleExtra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ListarDetalleExtra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function ListarTiempoExtra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ListarTiempoExtra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	function ListarDetalleMarcadasDepuradas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaDepurada = new cls_DBLecturaDepurada($this->decodificar);
		$res = $dbLecturaDepurada ->ListarDetalleMarcadasDepuradas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLecturaDepurada->salida;
		$this->query = $dbLecturaDepurada->query;
		return $res;
	}
	/////////////   FIN LECTURA DEPURADA /////////////////////////////
		/////////////// RESUMEN MARCAS DIA /////////////////////

	function ListarResumenMarcasDia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbResumenMarcasDia = new cls_DBResumenMarcasDia($this->decodificar);
		$res = $dbResumenMarcasDia ->ListarResumenMarcasDia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbResumenMarcasDia->salida;
		$this->query = $dbResumenMarcasDia->query;
		return $res;
	}
	function ContarListaResumenMarcasDia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbResumenMarcasDia= new cls_DBResumenMarcasDia($this->decodificar);
		$res = $dbResumenMarcasDia ->ContarListaResumenMarcasDia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbResumenMarcasDia->salida;
		$this->query = $dbResumenMarcasDia->query;
		return $res;
	}
	function InsertarResumenMarcasDiaManual($id_resumen_marcas_dia,$id_empleado,$fecha_resumen)
	{
		$this->salida = "";
		$dbResumenMarcasDia = new cls_DBResumenMarcasDia($this->decodificar);
		$res = $dbResumenMarcasDia ->InsertarResumenMarcasDiaManual($id_resumen_marcas_dia,$id_empleado,$fecha_resumen);
		$this->salida = $dbResumenMarcasDia->salida;
		$this->query = $dbResumenMarcasDia->query;
		return $res;
	}
	function InsertarResumenMarcasDia($id_resumen_marcas_dia,$fecha_desde,$fecha_hasta)
	{
		$this->salida = "";
		$dbResumenMarcasDia = new cls_DBResumenMarcasDia($this->decodificar);
		$res = $dbResumenMarcasDia ->InsertarResumenMarcasDia($id_resumen_marcas_dia,$fecha_desde,$fecha_hasta);
		$this->salida = $dbResumenMarcasDia->salida;
		$this->query = $dbResumenMarcasDia->query;
		return $res;
	}
	function EliminarResumenMarcasDia($id_resumen_marcas_dia)
	{
		$this->salida = "";
		$dbResumenMarcasDia = new cls_DBResumenMarcasDia($this->decodificar);
		$res = $dbResumenMarcasDia -> EliminarResumenMarcasDia($id_resumen_marcas_dia);
		$this->salida = $dbResumenMarcasDia->salida;
		$this->query = $dbResumenMarcasDia->query;
		return $res;
	}
	function ModificarResumenMarcasDia($id_resumen_marcas_dia,$id_empleado,$fecha_resumen)
	{
		$this->salida = "";
		$dbResumenMarcasDia = new cls_DBResumenMarcasDia($this->decodificar);
		$res = $dbResumenMarcasDia ->ModificarResumenMarcasDia($id_resumen_marcas_dia,$id_empleado,$fecha_resumen);
		$this->salida = $dbResumenMarcasDia->salida;
		$this->query = $dbResumenMarcasDia->query;
		return $res;
	}
	function DesaprobarResumenMarcasDia($id_resumen_marcas_dia,$id_empleado,$fecha_resumen)
	{
		$this->salida = "";
		$dbResumenMarcasDia = new cls_DBResumenMarcasDia($this->decodificar);
		$res = $dbResumenMarcasDia ->DesaprobarResumenMarcasDia($id_resumen_marcas_dia,$id_empleado,$fecha_resumen);
		$this->salida = $dbResumenMarcasDia->salida;
		$this->query = $dbResumenMarcasDia->query;
		return $res;
	}
	function ValidarResumenMarcasDia($operacion_sql,$id_resumen_marcas_dia,$id_empleado,$fecha_resumen,$fecha_desde,$fecha_hasta)
	{
		$this->salida = "";
		$dbResumenMarcasDia = new cls_DBResumenMarcasDia($this->decodificar);
		$res = $dbResumenMarcasDia ->ValidarResumenMarcasDia($operacion_sql,$id_resumen_marcas_dia,$id_empleado,$fecha_resumen,$fecha_desde,$fecha_hasta);
		$this->salida = $dbResumenMarcasDia->salida;
		$this->query = $dbResumenMarcasDia->query;
		return $res;
	}

	/////////////   FIN  FERIADO /////////////////////////////

	
	function  DetalleMarcasPeriodo($id_gestion, $id_periodo)
	{
		$this->salida = "";
		$this->query = "";
		$dbLecturaReloj= new cls_DBLecturaReloj($this->decodificar);
		$res = $dbLecturaReloj->DetalleMarcasPeriodo($id_gestion,$id_periodo);
		$this->salida = $dbLecturaReloj->salida;
		$this->query = $dbLecturaReloj->query;
		return $res;
	}
	

}?>