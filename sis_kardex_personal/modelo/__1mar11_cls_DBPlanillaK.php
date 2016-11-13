<?php
/**
 * Nombre de la clase:	cls_DBPlanilla.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_planilla
 * Autor:				(autogenerado)
 * Fecha creación:		2010-08-23 11:07:47
 */

 
class cls_DBPlanillaK
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
	 * Nombre de la función:	ListarPlanilla
	 * Propósito:				Desplegar los registros de tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:47
	 */
	function ListarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLASUE_SEL'";

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
		$this->var->add_def_cols('id_planilla','int4');
		$this->var->add_def_cols('id_tipo_planilla','int4');
		$this->var->add_def_cols('desc_tipo_planilla','varchar');
		$this->var->add_def_cols('id_periodo','int4');
		$this->var->add_def_cols('desc_periodo','numeric');
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('usuario','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('numero','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('fecha_planilla','date');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('periodo_lite','varchar');
		$this->var->add_def_cols('fk_id_planilla','int4');
		
		$this->var->add_def_cols('estado_anticipo','varchar');
		$this->var->add_def_cols('recalcular','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPlanilla
	 * Propósito:				Contar los registros de tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:47
	 */
	function ContarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLASUE_COUNT'";

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
	 * Nombre de la función:	InsertarPlanilla
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:47
	 */
	function InsertarPlanilla($id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones,$fecha_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_iud';
		$this->codigo_procedimiento = "'KP_PLASUE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_planilla);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$numero'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_planilla'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPlanilla
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:47
	 */
	function ModificarPlanilla($id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones,$fecha_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_iud';
		$this->codigo_procedimiento = "'KP_PLASUE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param($id_tipo_planilla);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$numero'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_planilla'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
		/**
	 * Nombre de la función:	ModificarPlanilla
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:47
	 */
	function calcularPlanillaCompleta($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_kp_calcular_planilla';
		$this->codigo_procedimiento = "'KP_CALPLA_IUD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	
	/**
	 * Nombre de la función:	EliminarPlanilla
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:47
	 */
	function EliminarPlanilla($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_iud';
		$this->codigo_procedimiento = "'KP_PLASUE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
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
	 * Nombre de la función:	ValidarPlanilla
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-23 11:07:47
	 */
	function ValidarPlanilla($operacion_sql,$id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones)
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
				//Validar id_planilla - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_planilla");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_planilla", $id_planilla))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_tipo_planilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_planilla");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_planilla", $id_tipo_planilla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_periodo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_periodo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_periodo", $id_periodo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(700);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_planilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_planilla");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_planilla", $id_planilla))
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
	
	function generarPlanilla($id_planilla,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_kp_generar_planilla';
		$this->codigo_procedimiento = "'KP_GENPLA_IUD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("'$tipo'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	/**
	 * Nombre de la funciï¿½n:	ClonarPlanilla
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de modificaciï¿½n de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		08-11-2010
	 */
	function ClonarPlanilla($id_planilla_padre,$tipo,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones,$fecha_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_iud';
		$this->codigo_procedimiento = "'KP_PLASUE_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla_padre);
		$this->var->add_param($id_tipo_planilla);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_planilla'");

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query; exit;
		return $res;
	}
	
	
	function calcularPlanillaAnticipo($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_kp_calcular_planilla';
		$this->codigo_procedimiento = "'KP_CALANT_IUD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
}?>