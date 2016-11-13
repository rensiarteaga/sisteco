<?php
/**
 * Nombre de la clase:	cls_DBItem.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_item
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-04 15:51:04
 */

class cls_DBItem
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
	 * Nombre de la función:	ListarItem
	 * Propósito:				Desplegar los registros de tal_item
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-04 15:51:04
	 */
	function ListarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITEM_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('precio_venta_almacen','numeric');
		$this->var->add_def_cols('costo_estimado','numeric');
		$this->var->add_def_cols('costo_almacen','numeric');
		$this->var->add_def_cols('stock_min','numeric');
		$this->var->add_def_cols('stock_total','numeric');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('nivel_convertido','varchar');
		$this->var->add_def_cols('estado_item','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_unidad_medida_base','int4');
		$this->var->add_def_cols('id_id3','int4');
		$this->var->add_def_cols('id_id2','int4');
		$this->var->add_def_cols('id_id1','int4');
		$this->var->add_def_cols('id_subgrupo','int4');
		$this->var->add_def_cols('id_grupo','int4');
		$this->var->add_def_cols('id_supergrupo','int4');
		$this->var->add_def_cols('nombre','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarItem
	 * Propósito:				Contar los registros de tal_item
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-04 15:51:04
	 */
	function ContarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_sel';
		$this->codigo_procedimiento = "'AL_ITEM_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		
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
	 * Nombre de la función:	InsertarItem
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_item
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-04 15:51:04
	 */
	function InsertarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_iud';
		$this->codigo_procedimiento = "'AL_ITEM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($precio_venta_almacen);
		$this->var->add_param($costo_estimado);
		$this->var->add_param($costo_almacen);
		$this->var->add_param($stock_min);
		$this->var->add_param($stock_total);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$nivel_convertido'");
		$this->var->add_param("'$estado_item'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_unidad_medida_base);
		$this->var->add_param($id_id3);
		$this->var->add_param($id_id2);
		$this->var->add_param($id_id1);
		$this->var->add_param($id_subgrupo);
		$this->var->add_param($id_grupo);
		$this->var->add_param($id_supergrupo);
		$this->var->add_param("'$nombre'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarItem
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_item
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-04 15:51:04
	 */
	function ModificarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_iud';
		$this->codigo_procedimiento = "'AL_ITEM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_item);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($precio_venta_almacen);
		$this->var->add_param($costo_estimado);
		$this->var->add_param($costo_almacen);
		$this->var->add_param($stock_min);
		$this->var->add_param($stock_total);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$nivel_convertido'");
		$this->var->add_param("'$estado_item'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_unidad_medida_base);
		$this->var->add_param($id_id3);
		$this->var->add_param($id_id2);
		$this->var->add_param($id_id1);
		$this->var->add_param($id_subgrupo);
		$this->var->add_param($id_grupo);
		$this->var->add_param($id_supergrupo);
		$this->var->add_param("'$nombre'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarItem
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_item
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-04 15:51:04
	 */
	function EliminarItem($id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_iud';
		$this->codigo_procedimiento = "'AL_ITEM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_item);
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
	 * Nombre de la función:	ValidarItem
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_item
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-04 15:51:04
	 */
	function ValidarItem($operacion_sql,$id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validad el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_item - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_item");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar precio_venta_almacen - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_venta_almacen");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_venta_almacen", $precio_venta_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_estimado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_estimado");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_estimado", $costo_estimado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_almacen - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_almacen");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_almacen", $costo_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar stock_min - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("stock_min");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "stock_min", $stock_min))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar stock_total - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("stock_total");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "stock_total", $stock_total))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nivel_convertido - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nivel_convertido");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nivel_convertido", $nivel_convertido))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_item - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_item");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_item", $estado_item))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_registro");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_medida_base - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_medida_base");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_medida_base", $id_unidad_medida_base))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_id3 - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_id3");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_id3", $id_id3))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_id2 - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_id2");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_id2", $id_id2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_id1 - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_id1");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_id1", $id_id1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_subgrupo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subgrupo");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subgrupo", $id_subgrupo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_grupo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_grupo");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo", $id_grupo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_supergrupo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_supergrupo");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_supergrupo", $id_supergrupo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar nivel_convertido
			$check = array ("1","2","3","4");
			if(!in_array($nivel_convertido,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'nivel_convertido': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarItem";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar estado_item
			$check = array ("Nuevo","Obsoleto","Usado");
			if(!in_array($estado_item,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_item': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarItem";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar estado_registro
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado_registro,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_registro': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarItem";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
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