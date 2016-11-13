<?php
/**
 * Nombre de la clase:	cls_DBColumna.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_columna
 * Autor:				(autogenerado)
 * Fecha creación:		2010-08-19 10:28:39
 */

 
class cls_DBColumna
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
	 * Nombre de la función:	ListarColumna
	 * Propósito:				Desplegar los registros de tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ListarColumna($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_sel';
		$this->codigo_procedimiento = "'KP_COLUMN_SEL'";

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
		$this->var->add_param($func->iif($id_actividad == '',"'null'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_columna','int4');
		$this->var->add_def_cols('id_tipo_planilla','int4');
		$this->var->add_def_cols('id_columna_tipo','int4');
		$this->var->add_def_cols('desc_tipo_columna','varchar');
		$this->var->add_def_cols('formula','varchar');
		$this->var->add_def_cols('valor_defecto','numeric');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('usuario','varchar');
		$this->var->add_def_cols('def_tipo_columna','varchar');
		$this->var->add_def_cols('formula_original','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('en_reporte','varchar');
		$this->var->add_def_cols('orden_reporte','integer');
		$this->var->add_def_cols('total','varchar');
		
		$this->var->add_def_cols('auxiliar','varchar');
		$this->var->add_def_cols('visible','varchar');
		$this->var->add_def_cols('orden_ejecucion','integer');
		$this->var->add_def_cols('fecha_inicio','date');
		//$this->var->add_def_cols('bb','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		if($_SESSION["ss_id_usuario"]==120){
//		echo $this->query;exit;}
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarColumna
	 * Propósito:				Contar los registros de tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ContarColumna($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_sel';
		$this->codigo_procedimiento = "'KP_COLUMN_COUNT'";

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
	 * Nombre de la función:	InsertarColumna
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function InsertarColumna($id_columna,$id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg, $en_reporte,$orden_reporte,$total,$orden_ejecucion,$fecha_inicio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_iud';
		$this->codigo_procedimiento = "'KP_COLUMN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_planilla);
		$this->var->add_param($id_columna_tipo);
		$this->var->add_param("'$formula'");
		$this->var->add_param($valor_defecto);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$en_reporte'");
		$this->var->add_param($orden_reporte);
		$this->var->add_param("'$total'");
		
		$this->var->add_param($orden_ejecucion);
		$this->var->add_param("'$fecha_inicio'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarColumna
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ModificarColumna($id_columna,$id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg,$en_reporte,$orden_reporte,$total,$orden_ejecucion,$fecha_inicio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_iud';
		$this->codigo_procedimiento = "'KP_COLUMN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_columna);
		$this->var->add_param($id_tipo_planilla);
		$this->var->add_param($id_columna_tipo);
		$this->var->add_param("'$formula'");
		$this->var->add_param($valor_defecto);
		$this->var->add_param("'$estado_reg'");
		
		$this->var->add_param("'$en_reporte'");
		$this->var->add_param($orden_reporte);
		$this->var->add_param("'$total'");
		
		$this->var->add_param($orden_ejecucion);
		$this->var->add_param("'$fecha_inicio'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarColumna
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function EliminarColumna($id_columna)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_iud';
		$this->codigo_procedimiento = "'KP_COLUMN_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_columna);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		
		$this->var->add_param("NULL");//("'$en_reporte'");
		$this->var->add_param("NULL");//("'$orden_reporte'");
		$this->var->add_param("NULL");//("'$total'");
		
		$this->var->add_param($orden_ejecucion);
		$this->var->add_param("'$fecha_inicio'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarColumna
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ValidarColumna($operacion_sql,$id_columna,$id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg)
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
				//Validar id_columna - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_columna");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_columna", $id_columna))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_tipo_planilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_planilla");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_planilla", $id_tipo_planilla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_columna_tipo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_columna_tipo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_columna_tipo", $id_columna_tipo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar formula - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("formula");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "formula", $formula))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar valor_defecto - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("valor_defecto");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "valor_defecto", $valor_defecto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_reg - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_columna - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_columna");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_columna", $id_columna))
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