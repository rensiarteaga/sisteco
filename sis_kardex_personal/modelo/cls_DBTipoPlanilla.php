<?php
/**
 * Nombre de la clase:	cls_DBTipoPlanilla.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_tipo_planilla
 * Autor:				(autogenerado)
 * Fecha creación:		2010-08-19 11:11:04
 */

 
class cls_DBTipoPlanilla
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
	 * Nombre de la función:	ListarTipoPlanilla
	 * Propósito:				Desplegar los registros de tkp_tipo_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 11:11:04
	 */
	function ListarTipoPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_planilla_sel';
		$this->codigo_procedimiento = "'KP_TIPPLA_SEL'";

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
		$this->var->add_def_cols('id_tipo_planilla','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('usuario','varchar');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('basica','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoPlanilla
	 * Propósito:				Contar los registros de tkp_tipo_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 11:11:04
	 */
	function ContarTipoPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_planilla_sel';
		$this->codigo_procedimiento = "'KP_TIPPLA_COUNT'";

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
	 * Nombre de la función:	InsertarTipoPlanilla
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_tipo_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 11:11:04
	 */
	function InsertarTipoPlanilla($id_tipo_planilla,$nombre,$descripcion,$estado_reg,$id_depto,$tipo,$basica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_planilla_iud';
		$this->codigo_procedimiento = "'KP_TIPPLA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("$id_depto");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$basica'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoPlanilla
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_tipo_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 11:11:04
	 */
	function ModificarTipoPlanilla($id_tipo_planilla,$nombre,$descripcion,$estado_reg,$id_depto,$tipo,$basica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_planilla_iud';
		$this->codigo_procedimiento = "'KP_TIPPLA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_planilla);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("$id_depto");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$basica'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoPlanilla
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_tipo_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 11:11:04
	 */
	function EliminarTipoPlanilla($id_tipo_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_planilla_iud';
		$this->codigo_procedimiento = "'KP_TIPPLA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_planilla);
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
	 * Nombre de la función:	ValidarTipoPlanilla
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_tipo_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 11:11:04
	 */
	function ValidarTipoPlanilla($operacion_sql,$id_tipo_planilla,$nombre,$descripcion,$estado_reg)
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
				//Validar id_tipo_planilla - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_planilla");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_planilla", $id_tipo_planilla))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
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
			//Validar id_tipo_planilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_planilla");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_planilla", $id_tipo_planilla))
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