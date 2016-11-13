<?php
/**
 * Nombre de la Clase:	    CustomDBFlujo
 * Propósito:				Interfaz del modelo del Sistema de Flujo
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		22-12-2010
 * Autor:					Jaime Rivera Rojas
 *
 */
class cls_CustomDBFlujo
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{	
		/*Aca se incluyen los modelos ejemplo:
		
		include_once("cls_DBDeclaracion.php");
		*/
		include_once("cls_DBTipoFormulario.php");
		include_once("cls_DBAtributo.php");
		include_once("cls_DBTipoProceso.php");
		include_once("cls_DBTipoNodo.php");
		include_once("cls_DBTipoAccion.php");
		include_once("cls_DBTipoCircuito.php");
		include_once("cls_DBTipoProcesoDepto.php");
		include_once("cls_DBAccion.php");
		include_once("cls_DBTipoNodoEmpleado.php");
		include_once("cls_DBAtributoTipoNodo.php");
		include_once("cls_DBFormGen.php");
		include_once("cls_DBValor.php");
		include_once("cls_DBProceso.php");
		include_once("cls_DBFormulario.php");
		include_once("cls_DBAnexo.php");
		include_once("cls_DBAuxiliar.php");
		include_once("cls_DBFuncionesFormulario.php");	
		include_once("cls_DBAdjunto.php");
		include_once("cls_DBCorrespondencia.php");
		include_once("cls_DBNodo.php");
		include_once("cls_DBCircuito.php");
		include_once("cls_DBHojaRuta.php");
			include_once("cls_DBCorrespondenciaArb.php");
	}
	
	/*Aca se definene las funciones ejemplo:
	
	function ListarGTOANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarGTOANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	*/
	
	//------------------------tfl_tipo_formulario-------------------------\\
	
	function ListarTipoFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_tipo_formulario)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoFormulario($this->decodificar);
		$res = $dbflujo -> ListarTipoFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_tipo_formulario);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarTipoFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoFormulario($this->decodificar);
		$res = $dbflujo -> ContarTipoFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function InsertarTipoFormulario($id_tipo_proceso,$id_documento,$codigo,$nombre,$prioridad)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoFormulario($this->decodificar);
		$res = $dbflujo -> InsertarTipoFormulario($id_tipo_proceso,$id_documento,$codigo,$nombre,$prioridad);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarTipoFormulario($id_tipo_formulario,$id_tipo_proceso,$id_documento,$codigo,$nombre,$prioridad)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoFormulario($this->decodificar);
		$res = $dbflujo -> ModificarTipoFormulario($id_tipo_formulario,$id_tipo_proceso,$id_documento,$codigo,$nombre,$prioridad);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function EliminarTipoFormulario($id_tipo_formulario)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoFormulario($this->decodificar);
		$res = $dbflujo -> EliminarTipoFormulario($id_tipo_formulario);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ValidarTipoFormulario($operacion_sql,$id_tipo_formulario,$id_tipo_proceso,$id_documento,$codigo,$nombre,$prioridad)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoFormulario($this->decodificar);
		$res = $dbflujo -> ValidarTipoFormulario($operacion_sql,$id_tipo_formulario,$id_tipo_proceso,$id_documento,$codigo,$nombre,$prioridad);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	//------------------------tfl_tipo_proceso-------------------------\\
	function ListarTipoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFlujo= new cls_DBTipoProceso($this->decodificar);
		$res = $dbFlujo  ->ListarTipoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFlujo ->salida;
		$this->query = $dbFlujo ->query;
		return $res;
	}
	function ContarTipoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFlujo= new cls_DBTipoProceso($this->decodificar);
		$res = $dbFlujo  ->ContarTipoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFlujo ->salida;
		$this->query = $dbFlujo ->query;
		return $res;
	}
	function InsertarTipoProceso($codigo,$nombre_proceso)
	{
		$this->salida = "";
		$dbFlujo= new cls_DBTipoProceso($this->decodificar);
		$res = $dbFlujo  ->InsertarTipoProceso($codigo,$nombre_proceso);
		$this->salida = $dbFlujo ->salida;
		$this->query = $dbFlujo ->query;
		return $res;
	}
	function ModificarTipoProceso($id_tipo_proceso,$codigo,$nombre_proceso,$estado,$id_nodo_inicio,$id_formulario_inicio)
	{
		$this->salida = "";
		$dbFlujo= new cls_DBTipoProceso($this->decodificar);
		$res = $dbFlujo  ->ModificarTipoProceso($id_tipo_proceso,$codigo,$nombre_proceso,$estado,$id_nodo_inicio,$id_formulario_inicio);
		$this->salida = $dbFlujo ->salida;
		$this->query = $dbFlujo ->query;
		return $res;
	}
	function EliminarTipoProceso($id_tipo_proceso)
	{
		$this->salida = "";
		$dbFlujo= new cls_DBTipoProceso($this->decodificar);
		$res = $dbFlujo  ->EliminarTipoProceso($id_tipo_proceso);
		$this->salida = $dbFlujo ->salida;
		$this->query = $dbFlujo ->query;
		return $res;
	}
	
	function ValidarTipoProceso($operacion_sql,$id_tipo_proceso,$codigo,$nombre_proceso,$estado)
	{
		$this->salida = "";
		$dbFlujo= new cls_DBTipoProceso($this->decodificar);
		$res = $dbFlujo  ->ValidarTipoProceso($operacion_sql,$id_tipo_proceso,$codigo,$nombre_proceso,$estado);
		$this->salida = $dbFlujo ->salida;
		$this->query = $dbFlujo ->query;
		return $res;
	}
	
	//-------------------fin de la tabla tfl_tipo_proceso-------------------\\
	//-------------------tabla tfl_proceso_depto-------------------\\
	
	function ListarTipoProcesoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		
		$this->salida="";
		$dbFlujo=new cls_DBTipoProcesoDepto($this->decodificar);
		$res=$dbFlujo->ListarTipoProcesoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida=$dbFlujo->salida;
		$this->query=$dbFlujo->query;
		return $res;
	}
	function ContarTipoProcesoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$dbFlujo=new cls_DBTipoProcesoDepto($this->decodificar);
		$res=$dbFlujo->ContarTipoProcesoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida=$dbFlujo->salida;
		$this->query=$dbFlujo->query;
		return $res;	
	}
	function InsertarTipoProcesoDepto($id_tipo_proceso,$id_depto)
	{
		$this->salida="";
		$dbFlujo=new cls_DBTipoProcesoDepto($this->decodificar);
		$res=$dbFlujo->InsertarTipoProcesoDepto($id_tipo_proceso,$id_depto);
		$this->salida=$dbFlujo->salida;
		$this->query=$dbFlujo->query;
		return $res;
	}
	function ModificarTipoProcesoDepto($id_proceso_depto,$id_tipo_proceso,$id_depto)
	{
		$this->salida="";
		$dbFlujo=new cls_DBTipoProcesoDepto($this->decodificar);
		$res=$dbFlujo->ModificarTipoProcesoDepto($id_proceso_depto,$id_tipo_proceso,$id_depto);
		$this->salida=$dbFlujo->salida;
		$this->query=$dbFlujo->query;
		return $res;
	}
	function EliminarTipoProcesoDepto($id_proceso_depto)
	{
		$this->salida="";
		$dbFlujo=new cls_DBTipoProcesoDepto($this->decodificar);
		$res=$dbFlujo->EliminarTipoProcesoDepto($id_proceso_depto);
		$this->salida=$dbFlujo->salida;
		$this->query=$dbFlujo->query;
		return $res;
	}
	function ValidarTipoProcesoDepto($operacion_sql,$id_proceso_depto,$id_tipo_proceso,$id_depto)
	{
		$this->salida="";
		$dbFlujo=new cls_DBTipoProcesoDepto($this->decodificar);
		$res=$dbFlujo->ValidarTipoProcesoDepto($operacion_sql,$id_proceso_depto,$id_tipo_proceso,$id_depto);
		$this->salida=$dbFlujo->salida;
		$this->query=$dbFlujo->query;
		return $res;
	}
	
	//--------------------------fin de la tfl_proceso_depto--------------------------------\\	
	//--------------------------tfl_tipo_nodo--------------------------------\\
	function ListarTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodo($this->decodificar);
		$res = $dbflujo -> ListarTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodo($this->decodificar);
		$res = $dbflujo -> ContarTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function InsertarTipoNodo($nombre,$codigo,$id_tipo_proceso,$ini_emp_list,$posx,$posy)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodo($this->decodificar);
		$res = $dbflujo -> InsertarTipoNodo($nombre,$codigo,$id_tipo_proceso,$ini_emp_list,$posx,$posy);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarTipoNodo($id_tipo_nodo,$nombre,$codigo,$id_tipo_proceso, $ini_emp_list,$posx,$posy)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodo($this->decodificar);
		$res = $dbflujo -> ModificarTipoNodo($id_tipo_nodo,$nombre,$codigo,$id_tipo_proceso,$ini_emp_list,$posx,$posy);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function EliminarTipoNodo($id_tipo_nodo)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodo($this->decodificar);
		$res = $dbflujo -> EliminarTipoNodo($id_tipo_nodo);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ValidarTipoNodo($operacion_sql,$id_tipo_nodo,$nombre,$codigo,$id_tipo_proceso,$ini_emp_list,$posx,$posy)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodo($this->decodificar);
		$res = $dbflujo -> ValidarTipoNodo($operacion_sql,$id_tipo_nodo,$nombre,$codigo,$id_tipo_proceso,$ini_emp_list,$posx,$posy);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	//--------------------------tfl_tipo_accion--------------------------------\\
	function ListarTipoAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoAccion($this->decodificar);
		$res = $dbflujo -> ListarTipoAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarTipoAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoAccion($this->decodificar);
		$res = $dbflujo -> ContarTipoAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function InsertarTipoAccion($codigo, $nombre, $empleado_sel, $criterio, $tipo_aplicacion)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoAccion($this->decodificar);
		$res = $dbflujo -> InsertarTipoAccion($codigo,$nombre,$empleado_sel, $criterio, $tipo_aplicacion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarTipoAccion($id_tipo_accion,$codigo,$nombre, $empleado_sel, $criterio, $tipo_aplicacion)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoAccion($this->decodificar);
		$res = $dbflujo -> ModificarTipoAccion($id_tipo_accion,$codigo,$nombre, $empleado_sel, $criterio, $tipo_aplicacion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function EliminarTipoAccion($id_tipo_accion)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoAccion($this->decodificar);
		$res = $dbflujo -> EliminarTipoAccion($id_tipo_accion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ValidarTipoAccion($operacion_sql,$id_tipo_accion,$codigo, $nombre, $empleado_sel, $criterio, $tipo_aplicacion)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoAccion($this->decodificar);
		$res = $dbflujo -> ValidarTipoAccion($operacion_sql,$id_tipo_accion,$codigo, $nombre, $empleado_sel, $criterio, $tipo_aplicacion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	//--------------------------FIN---tfl_tipo_accion--------------------------------\\
	
	//------------------------------tfl_tipo_circuito--------------------------------\\
	function ListarTipoCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoCircuito($this->decodificar);
		$res = $dbflujo -> ListarTipoCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarTipoCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoCircuito($this->decodificar);
		$res = $dbflujo -> ContarTipoCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function InsertarTipoCircuito($id_tipo_nodo_inicio,$id_tipo_nodo_fin,$tipo)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoCircuito($this->decodificar);
		$res = $dbflujo -> InsertarTipoCircuito($id_tipo_nodo_inicio,$id_tipo_nodo_fin,$tipo);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ModificarTipoCircuito($id_tipo_circuito,$id_tipo_nodo_inicio,$id_tipo_nodo_fin,$tipo)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoCircuito($this->decodificar);
		$res = $dbflujo -> ModificarTipoCircuito($id_tipo_circuito,$id_tipo_nodo_inicio,$id_tipo_nodo_fin,$tipo);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function EliminarTipoCircuito($id_tipo_circuito)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoCircuito($this->decodificar);
		$res = $dbflujo -> EliminarTipoCircuito($id_tipo_circuito);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ValidarTipoCircuito($operacion_sql,$id_tipo_circuito,$id_tipo_nodo_inicio,$id_tipo_nodo_fin,$tipo)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoCircuito($this->decodificar);
		$res = $dbflujo -> ValidarTipoCircuito($operacion_sql,$id_tipo_circuito,$id_tipo_nodo_inicio,$id_tipo_nodo_fin,$tipo);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	//------------------------------tfl_atributo--------------------------------\\
	
	function ListarAtributo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributo($this->decodificar);
		$res = $dbflujo -> ListarAtributo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarAtributo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributo($this->decodificar);
		$res = $dbflujo -> ContarAtributo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function InsertarAtributo($id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display,$id_tipo_proceso)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributo($this->decodificar);
		$res = $dbflujo -> InsertarAtributo($id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display,$id_tipo_proceso);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ModificarAtributo($id_atributo,$id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributo($this->decodificar);
		$res = $dbflujo -> ModificarAtributo($id_atributo,$id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function EliminarAtributo($id_atributo)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributo($this->decodificar);
		$res = $dbflujo -> EliminarAtributo($id_atributo);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ValidarAtributo($operacion_sql,$id_atributo,$id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributo($this->decodificar);
		$res = $dbflujo -> ValidarAtributo($operacion_sql,$id_atributo,$id_tipo_formulario,$tipo_field,$tipo_datos,$nombre,$label,$opcional,$remoto,$valor_defecto,$id_action,$valores_combo,$valor,$display);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}

	//--------------------------FIN---tfl_atributo--------------------------------\\
	
	//-----------------------------tfl_accion--------------------------------\\	
	
	function ListarAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAccion($this->decodificar);
		$res = $dbflujo -> ListarAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		
		$this->salida = "";
		$dbflujo = new cls_DBAccion($this->decodificar);
		$res = $dbflujo -> ContarAccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function InsertarAccion($id_tipo_accion, $id_tipo_circuito,$detalle_accion)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAccion($this->decodificar);
		$res = $dbflujo -> InsertarAccion($id_tipo_accion, $id_tipo_circuito,$detalle_accion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ModificarAccion($id_accion,$id_tipo_accion, $id_tipo_circuito,$detalle_accion)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAccion($this->decodificar);
		$res = $dbflujo -> ModificarAccion($id_accion,$id_tipo_accion, $id_tipo_circuito,$detalle_accion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function EliminarAccion($id_accion)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAccion($this->decodificar);
		$res = $dbflujo -> EliminarAccion($id_accion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ValidarAccion($operacion_sql,$id_accion,$id_tipo_accion, $id_tipo_circuito)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAccion($this->decodificar);
		$res = $dbflujo -> ValidarAccion($operacion_sql,$id_accion,$id_tipo_accion, $id_tipo_circuito);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	//--------------------------FIN---tfl_accion--------------------------------\\
	
	//---------------------------tfl_tipo_nodo_empleado-------------------------\\
	function ListarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodoEmpleado($this->decodificar);
		$res = $dbflujo -> ListarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}

	function ContarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodoEmpleado($this->decodificar);
		$res = $dbflujo -> ContarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function InsertarTipoNodoEmpleado($id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodoEmpleado($this->decodificar);
		$res = $dbflujo -> InsertarTipoNodoEmpleado($id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ModificarTipoNodoEmpleado($id_tipo_nodo_empleado,$id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodoEmpleado($this->decodificar);
		$res = $dbflujo -> ModificarTipoNodoEmpleado($id_tipo_nodo_empleado,$id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
		
	function EliminarTipoNodoEmpleado($id_tipo_nodo_empleado)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodoEmpleado($this->decodificar);
		$res = $dbflujo -> EliminarTipoNodoEmpleado($id_tipo_nodo_empleado);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ValidarTipoNodoEmpleado($operacion_sql,$id_tipo_nodo_empleado,$id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad)
	{
		$this->salida = "";
		$dbflujo = new cls_DBTipoNodoEmpleado($this->decodificar);
		$res = $dbflujo -> ValidarTipoNodoEmpleado($operacion_sql,$id_tipo_nodo_empleado,$id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	
	
	//--------------------------tfl_atributo_tipo_nodo--------------------------------\\
	function ListarAtributoTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributoTipoNodo($this->decodificar);
		$res = $dbflujo -> ListarAtributoTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarAtributoTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributoTipoNodo($this->decodificar);
		$res = $dbflujo -> ContarAtributoTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	/*
	function InsertarAtributoTipoNodo($id_atributo,$id_tipo_nodo,$visible,$editable,$orden)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributoTipoNodo($this->decodificar);
		$res = $dbflujo -> InsertarAtributoTipoNodo($id_atributo,$id_tipo_nodo,$visible,$editable,$orden);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}*/
	
	function ModificarAtributoTipoNodo($id_atributo_tipo_nodo,$visible,$editable,$orden)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributoTipoNodo($this->decodificar);
		$res = $dbflujo -> ModificarAtributoTipoNodo($id_atributo_tipo_nodo,$visible,$editable,$orden);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	/*
	function EliminarAtributoTipoNodo($id_atributo_tipo_nodo)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributoTipoNodo($this->decodificar);
		$res = $dbflujo -> EliminarAtributoTipoNodo($id_atributo_tipo_nodo);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	*/
	function ValidarAtributoTipoNodo($operacion_sql,$id_atributo_tipo_nodo,$id_atributo,$id_tipo_nodo,$orden)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAtributoTipoNodo($this->decodificar);
		$res = $dbflujo -> ValidarAtributoTipoNodo($operacion_sql,$id_atributo_tipo_nodo,$id_atributo,$id_tipo_nodo,$orden);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}

	//--------------------------------- FIN ATRIBUTO_TIPO_NODO
	
	//--------------------------FORM GEN--------------------------------\\
	function ListarAtributoTipoNodoForm($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBFormGen($this->decodificar);
		$res = $dbflujo -> ListarAtributoTipoNodoForm($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	function ContarAtributoTipoNodoForm($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBFormGen($this->decodificar);
		$res = $dbflujo -> ContarAtributoTipoNodoForm($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	//---------------------------------FIN FORM GEN
	
	
	//------------------------------- tfl_valor -------------------------------------\\
	function ListarValorDinamico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_tipo_proceso,$id_empleado,$id_tipo_formulario,$c_names)
	{
		$this->salida = "";
		$dbflujo = new cls_DBValor($this->decodificar);
		$res = $dbflujo -> ListarValorDinamico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_tipo_proceso,$id_empleado,$id_tipo_formulario,$c_names);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarValorDinamico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_tipo_proceso,$id_empleado,$id_tipo_formulario,$c_names)
	{
		$this->salida = "";
		$dbflujo = new cls_DBValor($this->decodificar);
		$res = $dbflujo -> ContarValorDinamico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_tipo_proceso,$id_empleado,$id_tipo_formulario,$c_names);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function InsertarValor($id_formulario,$id_atributo,$id_nodo,$valor_text)
	{
		$this->salida = "";
		$dbflujo = new cls_DBValor($this->decodificar);
		$res = $dbflujo -> InsertarValor($id_formulario,$id_atributo,$id_nodo,$valor_text);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarValor($id_valor,$id_formulario,$id_atributo,$id_nodo,$valor_text)
	{
		$this->salida = "";
		$dbflujo = new cls_DBValor($this->decodificar);
		$res = $dbflujo -> ModificarValor($id_valor,$id_formulario,$id_atributo,$id_nodo,$valor_text);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function EliminarValor($id_valor)
	{
		$this->salida = "";
		$dbflujo = new cls_DBValor($this->decodificar);
		$res = $dbflujo -> EliminarValor($id_valor);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ValidarValor($operacion_sql,$id_valor,$id_formulario,$id_atributo,$id_nodo)
	{
		$this->salida = "";
		$dbflujo = new cls_DBValor($this->decodificar);
		$res = $dbflujo -> ValidarValor($operacion_sql,$id_valor,$id_formulario,$id_atributo,$id_nodo);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	//----------------------------------------- fin_Valor
	
	//----------------------------------------- tfl_formulario
	function ListarFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBFormulario($this->decodificar);
		$res = $dbflujo -> ListarFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ContarFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBFormulario($this->decodificar);
		$res = $dbflujo -> ContarFormulario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function InsertarFormulario($id_tipo_formulario,$id_proceso,$id_depto,$numero_sis)
	{
		$this->salida = "";
		$dbflujo = new cls_DBFormulario($this->decodificar);
		$res = $dbflujo -> InsertarFormulario($id_tipo_formulario,$id_proceso,$id_depto,$numero_sis);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ModificarFormulario($id_id_formulario,$id_tipo_formulario,$id_proceso,$id_depto,$numero_sis)
	{
		$this->salida = "";
		$dbflujo = new cls_DBFormulario($this->decodificar);
		$res = $dbflujo -> ModificarFormulario($id_id_formulario,$id_tipo_formulario,$id_proceso,$id_depto,$numero_sis);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function EliminarFormulario($id_formulario)
	{
		$this->salida = "";
		$dbflujo = new cls_DBFormulario($this->decodificar);
		$res = $dbflujo -> EliminarFormulario($id_formulario);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ValidarFormulario($operacion_sql,$id_formulario,$id_tipo_formulario,$id_proceso)
	{
		$this->salida = "";
		$dbflujo = new cls_DBFormulario($this->decodificar);
		$res = $dbflujo -> ValidarFormulario($operacion_sql,$id_formulario,$id_tipo_formulario,$id_proceso);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	//------------------------------------- fin formulario
	
	//----------------------------------------- tfl_anexo
	
	function ListarAnexo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_anexo)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAnexo($this->decodificar);
		$res = $dbflujo -> ListarAnexo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_anexo);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;		
		return $res;
	}
	
	function ContarAnexo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAnexo($this->decodificar);
		$res = $dbflujo -> ContarAnexo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function InsertarArchivoBD($id_anexo,$nombre)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAnexo($this->decodificar);
		$res = $dbflujo -> InsertarArchivoBD($id_anexo,$nombre);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	//------------------------------------- fin anexo
	
	//------------------------------- tabla tfl_proceso
	function ListarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBProceso($this->decodificar);
		$res = $dbflujo -> ListarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ContarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBProceso($this->decodificar);
		$res = $dbflujo -> ContarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function InsertarProceso($id_tipo_proceso,$fecha_proceso)
	{
		$this->salida = "";
		$dbflujo = new cls_DBProceso($this->decodificar);
		$res = $dbflujo -> InsertarProceso($id_tipo_proceso,$fecha_proceso);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ModificarProceso($id_proceso,$id_tipo_proceso,$fecha_proceso)
	{
		$this->salida = "";
		$dbflujo = new cls_DBProceso($this->decodificar);
		$res = $dbflujo -> ModificarProceso($id_proceso,$id_tipo_proceso,$fecha_proceso);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function EliminarProceso($id_proceso)
	{
		$this->salida = "";
		$dbflujo = new cls_DBProceso($this->decodificar);
		$res = $dbflujo -> EliminarProceso($id_proceso);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	
	function ValidarProceso($operacion_sql,$id_proceso,$id_tipo_proceso)
	{
		$this->salida = "";
		$dbflujo = new cls_DBProceso($this->decodificar);
		$res = $dbflujo -> ValidarProceso($operacion_sql,$id_proceso,$id_tipo_proceso);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	//------------------------tfl_auxiliar-------------------------\\
	
	function ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbflujo -> ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbflujo -> ContarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function InsertarAuxiliar($id_auxiliar,$id_uo,$id_usuario)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbflujo -> InsertarAuxiliar($id_auxiliar,$id_uo,$id_usuario);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarAuxiliar($id_auxiliar,$id_uo,$id_usuario)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbflujo -> ModificarAuxiliar($id_auxiliar,$id_uo,$id_usuario);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function EliminarAuxiliar($id_auxiliar)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbflujo -> EliminarAuxiliar($id_auxiliar);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ValidarAuxiliar($operacion_sql,$id_auxiliar,$id_uo,$id_usuario)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbflujo -> ValidarAuxiliar($operacion_sql,$id_auxiliar,$id_uo,$id_usuario);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	//------------------------tfl_auxiliar-------------------------\\
	
	//------------------------ tfl_Funciones_Formulario -----------\\
	function ObtenerIdEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBFuncionesFormulario($this->decodificar);
		$res = $dbflujo -> ObtenerIdEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	//------------------- fin tfl_funciones_formulario ------------------\\
	
//------------------- fin tfl_Adjunto ------------------\\
	
	function ListarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto,$id_correspondencia)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ListarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto,$id_correspondencia);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ContarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function InsertarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$desc_persona,$tamano_adjunto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> InsertarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$desc_persona,$tamano_adjunto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$tamano_adjunto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ModificarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$tamano_adjunto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarAdjuntoGrilla($id_adjunto,$nombre_doc,$observacion,$id_correspondencia)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ModificarAdjuntoGrilla($id_adjunto,$nombre_doc,$observacion,$id_correspondencia);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function EliminarAdjunto($id_adjunto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> EliminarAdjunto($id_adjunto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ValidarAdjunto($operacion_sql,$id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension)	
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ValidarAdjunto($operacion_sql,$id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function SelIdAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> SelIdAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	/// --------------------- tfl_correspondencia --------------------- ///
	function SubirArchivoCorrespondencia($id_correspondencia,$url_archivo,$extension){
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->SubirArchivoCorrespondencia($id_correspondencia,$url_archivo,$extension);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ListarCorrespondenciaEnviada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ListarCorrespondenciaEnviada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ListarCorrespondenciaRecibida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ListarCorrespondenciaRecibida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ListarDocumentoEnviado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ListarDocumentoEnviado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ListarDocumentoRecibido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ListarDocumentoRecibido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ListarCorrespondenciaCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ListarCorrespondenciaCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ContarCorrespondenciaCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ContarCorrespondenciaCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	
	
	function ListarCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ListarCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
		
	function ContarCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ContarCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ListarCorrespondenciaMail($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->  ListarCorrespondenciaMail($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	/*JRR: 060611
	function InsertarCorrespondencia($id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->InsertarCorrespondencia($id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ModificarCorrespondencia($id_correspondencia,$id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ModificarCorrespondencia($id_correspondencia,$id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	*/
	function InsertarCorrespondencia($id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite,$aso,$id_nivel_seguridad)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->InsertarCorrespondencia($id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite,$aso,$id_nivel_seguridad);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ModificarCorrespondencia($id_correspondencia,$id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite,$id_nivel_seguridad,$nivel_prioridad,$fecha_max_res,$aso)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ModificarCorrespondencia($id_correspondencia,$id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite,$id_nivel_seguridad,$nivel_prioridad,$fecha_max_res,$aso);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	function EliminarCorrespondencia($id_correspondencia)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia -> EliminarCorrespondencia($id_correspondencia);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function MarcarResponsable($id_correspondencia)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia -> MarcarResponsable($id_correspondencia);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function ValidarCorrespondencia($operacion_sql,$id_correspondencia,$id_depto,$id_documento,$id_empleado_origen,$id_uo_origen,$id_institucion,$id_persona,$referencia,$fecha_origen,$hora_origen,$fecha_destino,$hora_destino,$observaciones,$observaciones_estado,$mensaje)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia ->ValidarCorrespondencia($operacion_sql,$id_correspondencia,$id_depto,$id_documento,$id_empleado_origen,$id_uo_origen,$id_institucion,$id_persona,$referencia,$fecha_origen,$hora_origen,$fecha_destino,$hora_destino,$observaciones,$observaciones_estado,$mensaje);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function PlanillaCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia,$var)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia -> PlanillaCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia,$var);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function CargoEmpleadoRem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia -> CargoEmpleadoRem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function AccionesCorr($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia -> AccionesCorr($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	function TipoDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_documento)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res = $dbCorrespondencia -> TipoDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_documento);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
	
	
	//-----------------Correspondencia PDF
		function ListarCorrespondenciaPDF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_correspondencia)
	{
		$this->salida = "";
		$dbCorrespondencia = new cls_DBCorrespondencia($this->decodificar);
		$res_detalle = $dbCorrespondencia ->ListarCorrespondenciaPDF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_correspondencia);
		$this->salida = $dbCorrespondencia ->salida;
		$this->query = $dbCorrespondencia ->query;
		return $res;
	}
		
	
	//----------------------------- tfl_nodo
	function ListarNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBNodo($this->decodificar);
		$res = $dbflujo -> ListarNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBNodo($this->decodificar);
		$res = $dbflujo -> ContarNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function InsertarNodo($id_empleado, $id_tipo_nodo, $id_proceso,$id_tipo_accion_documento,$estado,$mensaje_predecesor)
	{
		$this->salida = "";
		$dbflujo = new cls_DBNodo($this->decodificar);
		$res = $dbflujo -> InsertarNodo($id_empleado, $id_tipo_nodo, $id_proceso,$id_tipo_accion_documento,$estado,$mensaje_predecesor);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarNodo($id_nodo,$id_empleado, $id_tipo_nodo, $id_proceso,$id_tipo_accion_documento,$estado,$mensaje_predecesor)
	{
		$this->salida = "";
		$dbflujo = new cls_DBNodo($this->decodificar);
		$res = $dbflujo -> ModificarNodo($id_nodo,$id_empleado, $id_tipo_nodo, $id_proceso,$id_tipo_accion_documento,$estado,$mensaje_predecesor);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function EliminarNodo($id_nodo)
	{
		$this->salida = "";
		$dbflujo = new cls_DBNodo($this->decodificar);
		$res = $dbflujo -> EliminarNodo($id_nodo);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ValidarNodo($operacion_sql,$id_nodo,$id_empleado,$id_tipo_nodo,$id_proceso)	
	{
		$this->salida = "";
		$dbflujo = new cls_DBNodo($this->decodificar);
		$res = $dbflujo -> ValidarNodo($operacion_sql,$id_nodo,$id_empleado,$id_tipo_nodo,$id_proceso);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	//------------------------ fin tfl_nodo
	
	//--------------------------- tfl_circuito
	function ListarCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBCircuito($this->decodificar);
		$res = $dbflujo -> ListarCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbflujo = new cls_DBCircuito($this->decodificar);
		$res = $dbflujo -> ContarCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function InsertarCircuito($id_nodo_origen, $id_nodo_destino, $id_accion)
	{
		$this->salida = "";
		$dbflujo = new cls_DBCircuito($this->decodificar);
		$res = $dbflujo -> InsertarCircuito($id_nodo_origen, $id_nodo_destino, $id_accion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarCircuito($id_circuito,$id_nodo_origen,$id_nodo_destino,$id_accion)
	{
		$this->salida = "";
		$dbflujo = new cls_DBCircuito($this->decodificar);
		$res = $dbflujo -> ModificarCircuito($id_circuito,$id_nodo_origen,$id_nodo_origen,$id_nodo_destino,$id_accion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function EliminarCircuito($id_circuito)
	{
		$this->salida = "";
		$dbflujo = new cls_DBCircuito($this->decodificar);
		$res = $dbflujo -> EliminarNodo($id_circuito);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ValidarCircuito($operacion_sql,$id_circuito,$id_nodo_origen,$id_nodo_destino,$id_accion)	
	{
		$this->salida = "";
		$dbflujo = new cls_DBCircuito($this->decodificar);
		$res = $dbflujo -> ValidarCircuito($operacion_sql,$id_circuito,$id_nodo_origen,$id_nodo_destino,$id_accion);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	//--------------------------- fin tfl_circuito
	
	//  Hoja de ruta
	function ListarReporteHojaRuta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbHojaRuta = new cls_DBHojaRuta($this->decodificar);
		$res = $dbHojaRuta -> ListarReporteHojaRuta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbHojaRuta ->salida;
		$this->query = $dbHojaRuta ->query;
		return $res;	
	}
	
	function ListarReporteHojaRutaFlujo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbHojaRuta = new cls_DBHojaRuta($this->decodificar);
		$res = $dbHojaRuta -> ListarReporteHojaRutaFlujo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbHojaRuta ->salida;
		$this->query = $dbHojaRuta ->query;
		return $res;	
	}
	function ListarReporteHojaRutaDerivada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbHojaRuta = new cls_DBHojaRuta($this->decodificar);
		$res = $dbHojaRuta -> ListarReporteHojaRutaDerivada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbHojaRuta ->salida;
		$this->query = $dbHojaRuta ->query;
		return $res;	
	}
	
	function ListarReporteHojaRutaFlujoDerivada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbHojaRuta = new cls_DBHojaRuta($this->decodificar);
		$res = $dbHojaRuta -> ListarReporteHojaRutaFlujoDerivada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbHojaRuta ->salida;
		$this->query = $dbHojaRuta ->query;
		return $res;	
	}
	// Fin hoja de ruta
	
	
		//  Correspondencia arb //
	//  Correspondencia arb //
	
	function ListarCorrespondenciaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBCorrespondenciaArb($this->decodificar);
		$res = $dbDocumento -> ListarCorrespondenciaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_ini,$fecha_fin);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;	
	}
	
	function ListarCorrespondenciaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBCorrespondenciaArb($this->decodificar);
		$res = $dbDocumento -> ListarCorrespondenciaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$fecha_ini,$fecha_fin);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;	
	}
	
	
	function FiltrarCorrespondeciaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$v_id,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBCorrespondenciaArb($this->decodificar);
		$res = $dbDocumento -> FiltrarCorrespondeciaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$v_id,$fecha_ini,$fecha_fin);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;	
	}
	
	
	
}?>