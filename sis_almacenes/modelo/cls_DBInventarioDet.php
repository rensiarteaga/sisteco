<?php
/**
 * Nombre de la clase:	cls_DBInventarioDet.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_inventario_det
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-31 16:32:59
 */
class cls_DBInventarioDet
{	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	
	function __construct()
	{	$this->decodificar=$decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarInventarioDet
	 * Propósito:				Desplegar los registros de tal_inventario_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 16:32:59
	 */
	function ListarInventarioDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_inventario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_det_sel';
		$this->codigo_procedimiento = "'AL_INVDET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
        $this->var->add_param("'$id_inventario'");//id_actividad
		//Carga la definición de columnas con sus tipos de datos
		//$this->var->add_def_cols('id_inventario_det','integer');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('fecha_conteo','date');
		$this->var->add_def_cols('id_inventario','int4');
		$this->var->add_def_cols('id_supergrupo','int4');
		$this->var->add_def_cols('desc_supergrupo','varchar');
		$this->var->add_def_cols('id_grupo','int4');
		$this->var->add_def_cols('desc_grupo','varchar');
		$this->var->add_def_cols('id_subgrupo','int4');
		$this->var->add_def_cols('desc_subgrupo','varchar');
		$this->var->add_def_cols('id_id1','int4');
		$this->var->add_def_cols('desc_id1','varchar');
		$this->var->add_def_cols('id_id2','int4');
		$this->var->add_def_cols('desc_id2','varchar');
		$this->var->add_def_cols('id_id3','int4');
		$this->var->add_def_cols('desc_id3','varchar');
		$this->var->add_def_cols('desc_unidad_medida_base','varchar');
		$this->var->add_def_cols('nuevo','numeric');
		$this->var->add_def_cols('usado','numeric');
		$this->var->add_def_cols('total','numeric');
		$this->var->add_def_cols('cantidad_contada_nuevo','numeric');
		$this->var->add_def_cols('cantidad_contada_usado','numeric');
		$this->var->add_def_cols('cantidad_contada_total','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	/**
	 * Nombre de la función:	ContarInventarioDet
	 * Propósito:				Contar los registros de tal_inventario_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 16:32:59
	 */
	function ContarInventarioDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_inventario)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_det_sel';
		$this->codigo_procedimiento = "'AL_INVDET_COUNT'";
		$func = new cls_funciones();//Instancia de las funciones generales
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("$id_inventario");//id_actividad

		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{	$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarInventarioDet
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_inventario_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 16:32:59
	 */
	function InsertarInventarioDet($id_inventario_det,$cantidad_estimada,$cantidad_contada,$fecha_conteo,$estado_item,$id_item,$id_inventario,$id_supergrupo,$id_grupo,$id_subgrupo,$id_id1,$id_id2,$id_id3,$cantidad_contada_nuevo,$cantidad_contada_usado)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_det_iud';
		$this->codigo_procedimiento = "'AL_INVDET_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad_estimada);
		$this->var->add_param($cantidad_contada);
		$this->var->add_param("'$fecha_conteo'");
		$this->var->add_param("'$estado_item'");
		$this->var->add_param("'$id_item'");
		$this->var->add_param($id_inventario);
		$this->var->add_param("'$id_supergrupo'");
		$this->var->add_param("'$id_grupo'");
		$this->var->add_param("'$id_subgrupo'");
		$this->var->add_param("'$id_id1'");
		$this->var->add_param("'$id_id2'");
		$this->var->add_param("'$id_id3'");
		$this->var->add_param($cantidad_contada_nuevo);
		$this->var->add_param($cantidad_contada_usado);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	/**
	 * Nombre de la función:	ModificarInventarioDet
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_inventario_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 16:32:59
	 */
	function ModificarInventarioDet($id_inventario_det,$cantidad_estimada,$cantidad_contada,$fecha_conteo,$estado_item,$id_item,$id_inventario,$id_supergrupo,$id_grupo,$id_subgrupo,$id_id1,$id_id2,$id_id3,$cantidad_contada_nuevo,$cantidad_contada_usado)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_det_iud';
		$this->codigo_procedimiento = "'AL_INVDET_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("");
		$this->var->add_param("");
		$this->var->add_param("");
		$this->var->add_param("");
		$this->var->add_param("'$id_item'");
		$this->var->add_param($id_inventario);
		$this->var->add_param("");
		$this->var->add_param("");
		$this->var->add_param("");
		$this->var->add_param("");
		$this->var->add_param("");
		$this->var->add_param("");
		$this->var->add_param($cantidad_contada_nuevo);
		$this->var->add_param($cantidad_contada_usado);
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	EliminarInventarioDet
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_inventario_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 16:32:59
	 */
	function EliminarInventarioDet($id_item,$id_inventario)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_det_iud';
		$this->codigo_procedimiento = "'AL_INVDET_DEL'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$id_item'");
		$this->var->add_param($id_inventario);//
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");
		
			//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarInventarioDet
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_inventario_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 16:32:59
	 */
	function ValidarInventarioDet($operacion_sql,$id_inventario_det,$cantidad_estimada,$cantidad_contada,$fecha_conteo,$id_item,$id_inventario)
	{	$this->salida = "";
		$valid = new cls_validacion_serv();
		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{  //Validar cantidad_estimada - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad_estimada");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad_estimada", $cantidad_estimada))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validar cantidad_contada - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad_contada");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad_contada", $cantidad_contada))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validar fecha_conteo - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_conteo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_conteo", $fecha_conteo))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validar estado_item - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_item");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_item", $estado_item))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validar id_inventario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_inventario");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_inventario", $id_inventario))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validación de reglas de datos
			//Validar estado_item
			//$check = array ("Nuevo","Obsoleto","Usado");
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_supergrupo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_supergrupo", $id_supergrupo))
			{	$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_grupo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo", $id_grupo))
			{	$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subgrupo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subgrupo", $id_subgrupo))
			{	$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_id1");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_id1", $id_id1))
			{	$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_id2");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_id2", $id_id2))
			{	$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_id3");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_id3", $id_id3))
			{	$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{//Validar id_inventario_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_inventario_det");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_inventario_det", $id_inventario_det))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
}?>