<?php
/**
 * Nombre de la clase:	cls_DBItemReemplazo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_item_reemplazo
 * Autor:				Susana Castro Guaman
 * Fecha creación:		2007-10-03 
 */

class cls_DBItemReemplazo
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
	 * Nombre de la función:	ListarItemReemplazo
	 * Propósito:				Desplegar los registros de tal_item_reemplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 21:10:27
	 */
	function ListarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_reemplazo_sel';
		$this->codigo_procedimiento = "'AL_ITEMRE_SEL'";

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
		$this->var->add_def_cols('id_item_reemplazo','int4');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('id_item_reemplazante','int4');
        $this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('desc_item_reemplazante','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarItemReemplazo
	 * Propósito:				Contar los registros de tal_item_reemplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 21:10:27
	 */
	function ContarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_reemplazo_sel';
		$this->codigo_procedimiento = "'AL_ITEMRE_COUNT'";

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
	 * Nombre de la función:	InsertarItemReemplazo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_item_reemplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 21:10:27
	 */
	function InsertarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_reemplazo_iud';
		$this->codigo_procedimiento = "'AL_ITEMRE_INS'";
		//echo "ffff".$id_item_reemplazante."rrr".$id_item_reemplazo;

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_item_reemplazante);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarItemReemplazo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_item_reemplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 21:10:27
	 */
	function ModificarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_reemplazo_iud';
		$this->codigo_procedimiento = "'AL_ITEMRE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_item_reemplazo);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_item_reemplazante);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarItemReemplazo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_item_reemplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 21:10:27
	 */
	function EliminarItemReemplazo($id_item_reemplazo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_item_reemplazo_iud';
		$this->codigo_procedimiento = "'AL_ITEMRE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_item_reemplazo);
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
	 * Nombre de la función:	ValidarItemReemplazo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_item_reemplazo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-03 21:10:27
	 */
	function ValidarItemReemplazo($operacion_sql,$id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante)
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
				//Validar id_item_reemplazo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_item_reemplazo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item_reemplazo", $id_item_reemplazo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
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

			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_item_reemplazante - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item_reemplazante");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item_reemplazante", $id_item_reemplazante))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{	//Validar id_item_reemplazo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item_reemplazo");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item_reemplazo", $id_item_reemplazo))
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