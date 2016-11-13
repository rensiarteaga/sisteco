<?php
/**
 * Nombre de la clase:	cls_DBSalidaDetalle.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_salida_detalle
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-25 10:40:32
 */

class cls_DBSalidaDetalle
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
	 * Nombre de la función:	ListarSalidaDetalle
	 * Propósito:				Desplegar los registros de tal_salida_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 10:40:32
	 */
	function ListarSalidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_detalle_sel';
		$this->codigo_procedimiento = "'AL_SALDET_SEL'";

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
		$this->var->add_def_cols('id_salida_detalle','int4');
		$this->var->add_def_cols('costo','numeric');
		$this->var->add_def_cols('costo_unitario','numeric');
		$this->var->add_def_cols('precio_unitario','numeric');
		$this->var->add_def_cols('cant_solicitada','numeric');
		$this->var->add_def_cols('cant_entregada','numeric');
		$this->var->add_def_cols('cant_consolidada','numeric');
		$this->var->add_def_cols('fecha_solicitada','date');
		$this->var->add_def_cols('fecha_entregada','date');
		$this->var->add_def_cols('fecha_consolidada','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('codigo_item','varchar');
		$this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('desc_salida','varchar');		
		$this->var->add_def_cols('id_unidad_constructiva','int4');
		$this->var->add_def_cols('desc_unidad_constructiva','varchar');
		$this->var->add_def_cols('estado_item','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('nombre_supg','varchar');
		$this->var->add_def_cols('nombre_grupo','varchar');
		$this->var->add_def_cols('nombre_subg','varchar');
		$this->var->add_def_cols('nombre_id1','varchar');
		$this->var->add_def_cols('nombre_id2','varchar');
		$this->var->add_def_cols('nombre_id3','varchar');
		$this->var->add_def_cols('emergencia','varchar');
		$this->var->add_def_cols('unidad_medida','varchar');


		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSalidaDetalle
	 * Propósito:				Contar los registros de tal_salida_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 10:40:32
	 */
	function ContarSalidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_detalle_sel';
		$this->codigo_procedimiento = "'AL_SALDET_COUNT'";

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
	 * Nombre de la función:	InsertarSalidaDetalle
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_salida_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 10:40:32
	 */
	function InsertarSalidaDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_detalle_iud';
		$this->codigo_procedimiento = "'AL_SALDET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($costo);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($precio_unitario);
		$this->var->add_param($cant_solicitada);
		$this->var->add_param($cant_entregada);
		$this->var->add_param($cant_consolidada);
		$this->var->add_param("'$fecha_solicitada'");
		$this->var->add_param("'$fecha_entregada'");
		$this->var->add_param("'$fecha_consolidada'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_salida);
		$this->var->add_param($id_unidad_constructiva);
		$this->var->add_param("'$estado_item'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarSalidaDetalle
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_salida_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 10:40:32
	 */
	function ModificarSalidaDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_detalle_iud';
		$this->codigo_procedimiento = "'AL_SALDET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida_detalle);
		$this->var->add_param($costo);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($precio_unitario);
		$this->var->add_param($cant_solicitada);
		$this->var->add_param($cant_entregada);
		$this->var->add_param($cant_consolidada);
		$this->var->add_param("'$fecha_solicitada'");
		$this->var->add_param("'$fecha_entregada'");
		$this->var->add_param("'$fecha_consolidada'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_salida);
		$this->var->add_param($id_unidad_constructiva);
		$this->var->add_param("'$estado_item'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
		
	/**
	 * Nombre de la función:	ModificarSalidaDetalle
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_salida_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 10:40:32
	 */
	function ModificarSalidaDetallePendiente($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_detalle_iud';
		$this->codigo_procedimiento = "'AL_SDEPEN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida_detalle);
		$this->var->add_param($costo);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($precio_unitario);
		$this->var->add_param($cant_solicitada);
		$this->var->add_param($cant_entregada);
		$this->var->add_param($cant_consolidada);
		$this->var->add_param("'$fecha_solicitada'");
		$this->var->add_param("'$fecha_entregada'");
		$this->var->add_param("'$fecha_consolidada'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_salida);
		$this->var->add_param($id_unidad_constructiva);
		$this->var->add_param("'$estado_item'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
		/**
	 * Nombre de la función:	ModificarSalidaDetalleConsolidada
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_salida_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 10:40:32
	 */
	function ModificarSalidaDetalleConsolidada($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_detalle_iud';
		$this->codigo_procedimiento = "'AL_SDECON_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida_detalle);
		$this->var->add_param($costo);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($precio_unitario);
		$this->var->add_param($cant_solicitada);
		$this->var->add_param($cant_entregada);
		$this->var->add_param($cant_consolidada);
		$this->var->add_param("'$fecha_solicitada'");
		$this->var->add_param("'$fecha_entregada'");
		$this->var->add_param("'$fecha_consolidada'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_salida);
		$this->var->add_param($id_unidad_constructiva);
		$this->var->add_param("'$estado_item'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	EliminarSalidaDetalle
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 10:40:32
	 */
	function EliminarSalidaDetalle($id_salida_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_detalle_iud';
		$this->codigo_procedimiento = "'AL_SALDET_DEL'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida_detalle);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarSalidaDetalle
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_salida_detalle
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 10:40:32
	 */
	function ValidarSalidaDetalle($operacion_sql,$id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
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
				//Validar id_salida_detalle - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_salida_detalle");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida_detalle", $id_salida_detalle))
				{
					$this->salida = $valid->salida;
					return false;
				}
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

			//Validar costo_unitario - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_unitario");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_unitario", $costo_unitario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar precio_unitario - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_unitario");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_unitario", $precio_unitario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cant_solicitada - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cant_solicitada");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cant_solicitada", $cant_solicitada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cant_entregada - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cant_entregada");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cant_entregada", $cant_entregada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cant_consolidada - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cant_consolidada");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cant_consolidada", $cant_consolidada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_solicitada - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_solicitada");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_solicitada", $fecha_solicitada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_entregada - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_entregada");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_entregada", $fecha_entregada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_consolidada - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_consolidada");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_consolidada", $fecha_consolidada))
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

			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_salida - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_salida");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida", $id_salida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_constructiva - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_constructiva");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_constructiva", $id_unidad_constructiva))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_salida_detalle - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_salida_detalle");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida_detalle", $id_salida_detalle))
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