<?php
/**
 * Nombre de la clase:	cls_DBOrdenIngresoAprobDet.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_ingreso_detalle
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-17 12:32:39
 */

class cls_DBOrdenIngresoAprobDet
{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	
	function __construct()
	{
		$this->decodificar=$decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarOrdenIngresoAprobDet
	 * Propósito:				Desplegar los registros de tal_ingreso_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 12:32:39
	 */
	function ListarOrdenIngresoAprobDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_detalle_sel';
		$this->codigo_procedimiento = "'AL_OISDET_SEL'";

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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_ingreso_detalle','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('costo','numeric');
		$this->var->add_def_cols('precio_venta','numeric');
		$this->var->add_def_cols('costo_unitario','numeric');
		$this->var->add_def_cols('precio_venta_unitario','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_ingreso','int4');
		$this->var->add_def_cols('desc_ingreso','varchar');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('estado_item','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('nombre_supg','varchar');
		$this->var->add_def_cols('nombre_grupo','varchar');
		$this->var->add_def_cols('nombre_subg','varchar');
		$this->var->add_def_cols('nombre_id1','varchar');
		$this->var->add_def_cols('nombre_id2','varchar');
		$this->var->add_def_cols('nombre_id3','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarOrdenIngresoAprobDet
	 * Propósito:				Contar los registros de tal_ingreso_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 12:32:39
	 */
	function ContarOrdenIngresoAprobDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_detalle_sel';
		$this->codigo_procedimiento = "'AL_INGDET_COUNT'";

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

		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarOrdenIngresoAprobDet
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_ingreso_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 12:32:39
	 */
	function InsertarOrdenIngresoAprobDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_detalle_iud';
		$this->codigo_procedimiento = "'AL_OISDET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad);
		$this->var->add_param($costo);
		$this->var->add_param($precio_venta);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($precio_venta_unitario);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_ingreso);
		$this->var->add_param($id_item);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarOrdenIngresoAprobDet
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_ingreso_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 12:32:39
	 */
	function ModificarOrdenIngresoAprobDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_detalle_iud';
		$this->codigo_procedimiento = "'AL_OISDET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ingreso_detalle);
		$this->var->add_param($cantidad);
		$this->var->add_param($costo);
		$this->var->add_param($precio_venta);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($precio_venta_unitario);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_ingreso);
		$this->var->add_param($id_item);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarOrdenIngresoAprobDet
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_ingreso_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 12:32:39
	 */
	function EliminarOrdenIngresoAprobDet($id_ingreso_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_detalle_iud';
		$this->codigo_procedimiento = "'AL_INGDET_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ingreso_detalle);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarOrdenIngresoAprobDet
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_ingreso_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-17 12:32:39
	 */
	function ValidarOrdenIngresoAprobDet($operacion_sql,$id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_ingreso_detalle - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_ingreso_detalle");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso_detalle", $id_ingreso_detalle))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar cantidad - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad", $cantidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo", $costo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar precio_venta - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_venta");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_venta", $precio_venta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_unitario - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_unitario");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_unitario", $costo_unitario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar precio_venta_unitario - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_venta_unitario");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_venta_unitario", $precio_venta_unitario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_ingreso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ingreso");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso", $id_ingreso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_ingreso_detalle - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ingreso_detalle");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso_detalle", $id_ingreso_detalle))
			{
				$this->salida = $valid->salida;
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