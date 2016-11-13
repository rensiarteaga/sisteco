<?php
/**
 * Nombre de la clase:	cls_DBPlanilla.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_planilla
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2010-08-23 11:07:47
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
	 * Nombre de la funci�n:	ListarPlanilla
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function ListarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLASUE_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
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
		$this->var->add_def_cols('estado_obligacion','varchar');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarPlanilla
	 * Prop�sito:				Contar los registros de tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function ContarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_sel';
		$this->codigo_procedimiento = "'KP_PLASUE_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;

		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	InsertarPlanilla
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function InsertarPlanilla($id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones,$fecha_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_iud';
		$this->codigo_procedimiento = "'KP_PLASUE_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_planilla);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$numero'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_planilla'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarPlanilla
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function ModificarPlanilla($id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones,$fecha_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_iud';
		$this->codigo_procedimiento = "'KP_PLASUE_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param($id_tipo_planilla);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$numero'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_planilla'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//echo $this->query; exit;
		return $res;
	}
	
		/**
	 * Nombre de la funci�n:	ModificarPlanilla
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function calcularPlanillaCompleta($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_kp_calcular_planilla';
		$this->codigo_procedimiento = "'KP_CALPLA_IUD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//echo $this->query; exit;
		return $res;
	}
	
	
	
	
	/**
	 * Nombre de la funci�n:	EliminarPlanilla
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function EliminarPlanilla($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_iud';
		$this->codigo_procedimiento = "'KP_PLASUE_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
		/**
	 * Nombre de la funci�n:	ResumenCostosPersonal
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function ResumenCostosPersonal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_costos_rep';
		$this->codigo_procedimiento = "'KP_RESU_COSTOS'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($id_planilla);//id_planilla
		$this->var->add_param("NULL");//fecha_planilla

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('desc_epe','text');
		$this->var->add_def_cols('horas_normales','numeric');
		$this->var->add_def_cols('horas_extra','numeric');
		$this->var->add_def_cols('horas_nocturnas','numeric');
		$this->var->add_def_cols('subtotal','numeric');
		$this->var->add_def_cols('aguin','numeric');
		$this->var->add_def_cols('subsid','numeric');
		$this->var->add_def_cols('inctmp','numeric');
		$this->var->add_def_cols('reintnc','numeric');
		$this->var->add_def_cols('carga_social','numeric');
		$this->var->add_def_cols('indemniz','numeric');
		$this->var->add_def_cols('total_gral','numeric');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
		/**
	 * Nombre de la funci�n:	ResumenCostosPersonalDis
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function ResumenCostosPersonalDis($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_planilla,$fecha_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_costos_rep';
		$this->codigo_procedimiento = "'KP_RESU_COSTOS_DIST'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($id_planilla);//id_planilla
		$this->var->add_param("'$fecha_planilla'");//fecha_planilla

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('desc_epe','text');
		$this->var->add_def_cols('horas_normales','numeric');
		$this->var->add_def_cols('horas_extra','numeric');
		$this->var->add_def_cols('horas_nocturnas','numeric');
		$this->var->add_def_cols('subtotal','numeric');
		$this->var->add_def_cols('aguin','numeric');
		$this->var->add_def_cols('subsid','numeric');
		$this->var->add_def_cols('inctmp','numeric');
		$this->var->add_def_cols('reintnc','numeric');
		$this->var->add_def_cols('carga_social','numeric');
		$this->var->add_def_cols('indemniz','numeric');
		$this->var->add_def_cols('total_gral','numeric');
		$this->var->add_def_cols('id_lugar','integer');
		$this->var->add_def_cols('nombre_lugar','varchar');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
		/**
	 * Nombre de la funci�n:	ResumenCostosPersonalDis
	 * Prop�sito:				Desplegar los registros de tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function ResumenDistritos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_planilla,$fecha_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_costos_rep';
		$this->codigo_procedimiento = "'KP_RESU_COSTOS_DISTRITO'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($id_planilla);//id_planilla
		$this->var->add_param("'$fecha_planilla'");//fecha_planilla

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_lugar','varchar');
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ValidarPlanilla
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2010-08-23 11:07:47
	 */
	function ValidarPlanilla($operacion_sql,$id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validaci�n por el tipo de operaci�n
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

			//Validaci�n exitosa
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
		
			//Validaci�n exitosa
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

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("'$tipo'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//echo $this->query; exit;
		return $res;
	}
	
	
	/**
	 * Nombre de la funci�n:	ClonarPlanilla
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tkp_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		08-11-2010
	 */
	function ClonarPlanilla($id_planilla_padre,$tipo,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones,$fecha_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_planilla_iud';
		$this->codigo_procedimiento = "'KP_PLASUE_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla_padre);
		$this->var->add_param($id_tipo_planilla);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_planilla'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//echo $this->query; exit;
		return $res;
	}
	
	
	function calcularPlanillaAnticipo($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_kp_calcular_planilla';
		$this->codigo_procedimiento = "'KP_CALANT_IUD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function ListarArchivoPago($id_planilla,$id_subsistema,$id_cuenta_bancaria,$codigo)
	
	{
		
		$this->salida = "";
		if($codigo=='BONMES' || $codigo=='PRIMA'){ 
			$this->nombre_funcion = 'kard.f_archivo_pago_prima';
		}else{
		
			$this->nombre_funcion = 'kard.f_archivo_pago';
		}
		$this->codigo_procedimiento = "'KP_CALANT_IUD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		/*$this->var->add_param(181);//($id_planilla);
		$this->var->add_param(5);//($id_subsistema);
		$this->var->add_param(162);//$id_cuenta_bancaria);
		$this->var->add_param("'PRIMA'");//("'$codigo'");	*/
		$this->var->add_param($id_planilla);
		$this->var->add_param($id_subsistema);
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("'$codigo'");	
		//Ejecuta la funci�n
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('id_institucion','integer');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
		$this->var->add_def_cols('periodo','text');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('fecha_pago','date');
		$this->var->add_def_cols('nro_emp','integer');
		
		
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//echo $this->query; exit;
		return $res;
		
		
		
	}
	
	function ListarArchivoDavinci($id_planilla,$codigo,$monto)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_archivo_davinci';
		$this->codigo_procedimiento = "'KP_CALANT_IUD'";
		
		//echo "XXXXXXXXX";exit;

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param($id_planilla);
		
		$this->var->add_param($monto);
		$this->var->add_param("'$codigo'");
		

		//Ejecuta la funci�n
		$this->var->add_def_cols('cadena','varchar');
		$this->var->add_def_cols('ci','varchar');
		
		
		/*$this->var->add_def_cols('nit','numeric');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('periodo','numeric');
		$this->var->add_def_cols('ci','varchar');
		$this->var->add_def_cols('sueldo_neto','numeric');
		$this->var->add_def_cols('notas_fiscales','numeric');
		$this->var->add_def_cols('impuesto_retenido','numeric');
		$this->var->add_def_cols('saldo_mes_sig','numeric');
		*/
		
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
      //   echo $this->query; exit; 
		return $res;
		
		
		
	}
	
	
	function ListarArchivoTrimestral($id_planilla){
		
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_archivo_planilla_trimestral';
		$this->codigo_procedimiento = "'KP_CALANT_IUD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
	

		//Ejecuta la funci�n
		$this->var->add_def_cols('cadena','varchar');
		$this->var->add_def_cols('id_empleado','integer');
		
	
		
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	
	}
	
	function ListarArchivoMin($id_planilla,$codigo)
	
	{
	
		$this->salida = "";
		if($codigo=='BONMES' || $codigo=='PRIMA'){
			$this->nombre_funcion = 'kard.f_archivo_pago_prima';
		}else{
	
			$this->nombre_funcion = 'kard.f_archivo_ministerio';
		}
		$this->codigo_procedimiento = "'KP_CALANT_IUD'";
	
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param($id_planilla);
		$this->var->add_param("'$codigo'");
		//Ejecuta la funci�n
		$this->var->add_def_cols('cadena','text');
		
	
		$res = $this->var->exec_query_sss();
	
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res;
	
	
	
	}
	
	
}?>