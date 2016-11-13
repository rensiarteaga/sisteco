<?php
/**
 * Nombre de la clase:	cls_DBTransferenciaDet.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_transferencia_det
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-21 08:51:17
 */

class cls_DBTransferenciaDet
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
	 * Nombre de la función:	ListarTransferenciaDet
	 * Propósito:				Desplegar los registros de tal_transferencia_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-21 08:51:17
	 */
	function ListarTransferenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_transferencia_det_sel';
		$this->codigo_procedimiento = "'AL_TLODET_SEL'";

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
		$this->var->add_def_cols('id_transferencia_det','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('estado_item','varchar');
		$this->var->add_def_cols('costo','numeric');
		$this->var->add_def_cols('costo_unitario','numeric');
		$this->var->add_def_cols('precio_unitario','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('id_transferencia','int4');
		$this->var->add_def_cols('desc_transferencia','varchar');
		$this->var->add_def_cols('id_unidad_constructiva','int4');
		$this->var->add_def_cols('desc_unidad_constructiva','varchar');
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
	 * Nombre de la función:	ContarTransferenciaDet
	 * Propósito:				Contar los registros de tal_transferencia_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-21 08:51:17
	 */
	function ContarTransferenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_transferencia_det_sel';
		$this->codigo_procedimiento = "'AL_TLODET_COUNT'";

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
	 * Nombre de la función:	InsertarTransferenciaDet
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_transferencia_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-21 08:51:17
	 */
	function InsertarTransferenciaDet($id_transferencia_det,$cantidad,$estado_item,$costo,$costo_unitario,$precio_unitario,$fecha_reg,$id_item,$id_transferencia,$id_unidad_constructiva)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_transferencia_det_iud';
		$this->codigo_procedimiento = "'AL_TLODET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad);
		$this->var->add_param("'$estado_item'");
		$this->var->add_param($costo);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($precio_unitario);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_transferencia);
		$this->var->add_param($id_unidad_constructiva);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTransferenciaDet
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_transferencia_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-21 08:51:17
	 */
	function ModificarTransferenciaDet($id_transferencia_det,$cantidad,$estado_item,$costo,$costo_unitario,$precio_unitario,$fecha_reg,$id_item,$id_transferencia,$id_unidad_constructiva)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_transferencia_det_iud';
		$this->codigo_procedimiento = "'AL_TLODET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_transferencia_det);
		$this->var->add_param($cantidad);
		$this->var->add_param("'$estado_item'");
		$this->var->add_param($costo);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($precio_unitario);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_transferencia);
		$this->var->add_param($id_unidad_constructiva);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTransferenciaDet
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_transferencia_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-21 08:51:17
	 */
	function EliminarTransferenciaDet($id_transferencia_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_transferencia_det_iud';
		$this->codigo_procedimiento = "'AL_TLODET_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_transferencia_det);
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
	 * Nombre de la función:	ValidarTransferenciaDet
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_transferencia_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-21 08:51:17
	 */
	function ValidarTransferenciaDet($operacion_sql,$id_transferencia_det,$cantidad,$estado_item,$costo,$costo_unitario,$precio_unitario,$fecha_reg,$id_item,$id_transferencia,$id_unidad_constructiva)
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
				//Validar id_transferencia_det - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_transferencia_det");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_transferencia_det", $id_transferencia_det))
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

			//Validar estado_item - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_item");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_item", $estado_item))
			{
				$this->salida = $valid->salida;
				return false;
			}

			/*//Validar costo - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo", $costo))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			/*//Validar costo_unitario - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_unitario");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_unitario", $costo_unitario))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			/*//Validar precio_unitario - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_unitario");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_unitario", $precio_unitario))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			/*//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_transferencia - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_transferencia");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_transferencia", $id_transferencia))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_constructiva - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_constructiva");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_constructiva", $id_unidad_constructiva))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado_item
			$check = array ("Nuevo","Usado");
			if(!in_array($estado_item,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_item': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarTransferenciaDet";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_transferencia_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_transferencia_det");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_transferencia_det", $id_transferencia_det))
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