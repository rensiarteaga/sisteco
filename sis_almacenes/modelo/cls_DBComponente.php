<?php
/**
 * Nombre de la clase:	cls_DBComponente.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_componente
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-07 16:22:43
 */

class cls_DBComponente
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
	 * Nombre de la función:	ListarComponente
	 * Propósito:				Desplegar los registros de tal_componente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 16:22:43
	 */
	function ListarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_componente_sel';
		$this->codigo_procedimiento = "'AL_COMP_SEL'";

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
		$this->var->add_def_cols('id_componente','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('cosiderar_repeticion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('codigo_item','varchar');
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('desc_tipo_unidad_constructiva','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarComponente
	 * Propósito:				Contar los registros de tal_componente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 16:22:43
	 */
	function ContarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_componente_sel';
		$this->codigo_procedimiento = "'AL_COMP_COUNT'";

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
	 * Nombre de la función:	InsertarComponente
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_componente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 16:22:43
	 */
	function InsertarComponente($id_componente,$cantidad,$estado_registro,$cosiderar_repeticion,$fecha_reg,$descripcion,$id_item,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_componente_iud';
		$this->codigo_procedimiento = "'AL_COMP_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad);
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$cosiderar_repeticion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_tipo_unidad_constructiva);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarComponente
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_componente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 16:22:43
	 */
	function ModificarComponente($id_componente,$cantidad,$estado_registro,$cosiderar_repeticion,$fecha_reg,$descripcion,$id_item,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_componente_iud';
		$this->codigo_procedimiento = "'AL_COMP_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_componente);
		$this->var->add_param($cantidad);
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$cosiderar_repeticion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_tipo_unidad_constructiva);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarComponente
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_componente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 16:22:43
	 */
	function EliminarComponente($id_componente)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_componente_iud';
		$this->codigo_procedimiento = "'AL_COMP_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_componente);
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
	 * Nombre de la función:	EliminarComponente
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_componente
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2007-11-07 16:22:43
	 */
	function EliminarComponenteItemTUC($id_tipo_unidad_constructiva,$id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_componente_iud';
		$this->codigo_procedimiento = "'AL_COMP_ITEM_ARB_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_item);
		$this->var->add_param($id_tipo_unidad_constructiva);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarComponente
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_componente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 16:22:43
	 */
	function ValidarComponente($operacion_sql,$id_componente,$cantidad,$estado_registro,$cosiderar_repeticion,$fecha_reg,$descripcion,$id_item,$id_tipo_unidad_constructiva)
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
				//Validar id_componente - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_componente");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_componente", $id_componente))
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

			//Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cosiderar_repeticion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cosiderar_repeticion");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cosiderar_repeticion", $cosiderar_repeticion))
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

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
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

			//Validar id_tipo_unidad_constructiva - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_unidad_constructiva");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_unidad_constructiva", $id_tipo_unidad_constructiva))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado_registro
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado_registro,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_registro': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarComponente";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar cosiderar_repeticion
			$check = array ("si","no");
			if(!in_array($cosiderar_repeticion,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'cosiderar_repeticion': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarComponente";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_componente - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_componente");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_componente", $id_componente))
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