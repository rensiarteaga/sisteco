<?php
/**
 * Nombre de la clase:	cls_DBColumna.php
 * Proposito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_columna
 * Autor:				(autogenerado)
 * Fecha creacion:		2010-08-19 10:28:39
 */
class cls_DBColumnaPartidaEjecucion
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
	 * Nombre de la funcion:	ListarColumna
	 * Proposito:				Desplegar los registros de tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creacion:		2010-08-19 10:28:39
	 */
	function ListarColumnaPartidaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_partida_ejecucion_sel';
		$this->codigo_procedimiento = "'KP_COPAEJ_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecucion de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parametros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parometros especoficos de la estructura programotica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definicion de columnas con sus tipos de datos
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
		//Ejecuta la funcion de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funcion y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamo a la funcion de postgres
		$this->query = $this->var->query;
		
	//	echo $this->query;exit;
		return $res;
	}
	
		/**
	 * Nombre de la funcion:	ListarColumna
	 * Proposito:				Desplegar los registros del columna partida ejecucion
	 * Autor:				    Rensi Arteaga Coapri
	 * Fecha de creacion:		2010-11-15
	 */
	function ListarColumnaPartidaEjecucionObli($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_partida_ejecucion_sel';
		$this->codigo_procedimiento = "'KP_COPAEJOB_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecucion de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parametros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parometros especoficos de la estructura programotica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definicion de columnas con sus tipos de datos
	   $this->var->add_def_cols('id_columna_partida_ejecucion','int4');
       $this->var->add_def_cols('id_planilla_presupuesto','int4');
       $this->var->add_def_cols('id_columna','int4');
       $this->var->add_def_cols('id_partida_ejecucion','int4');
       $this->var->add_def_cols('id_columna_partida_ejecucion_padre','int4');
       $this->var->add_def_cols('id_usuario_reg','int4');
       $this->var->add_def_cols('id_obligacion','int4');
       $this->var->add_def_cols('monto','numeric');
       $this->var->add_def_cols('momento','varchar');
       $this->var->add_def_cols('fecha_reg','date');
       $this->var->add_def_cols('estado_reg','varchar');
       $this->var->add_def_cols('desc_columna','varchar');
       $this->var->add_def_cols('desc_tcolumna','varchar');
       $this->var->add_def_cols('id_partida','int4');
       $this->var->add_def_cols('codigo_partida','varchar');
       $this->var->add_def_cols('desc_partida','varchar');
       
  		
		//Ejecuta la funcion de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la funcion y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamo a la funcion de postgres
		$this->query = $this->var->query;
		
	  //  echo $this->query;exit;
		return $res;
	}
	
	
	/**
	 * Nombre de la funcion:	ContarColumna
	 * Proposito:				Contar los registros de tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creacion:		2010-08-19 10:28:39
	 */
	function ContarColumnaPartidaEjecucionObli($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_partida_ejecucion_sel';
		$this->codigo_procedimiento = "'KP_COPAEJOB_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecucion de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parometros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parometros especoficos de la estructura programotica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
		//Carga la definicion de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funcion de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funcion
		$this->salida = $this->var->salida;

		//Si la ejecucion fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamo a la funcion de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecucion
		return $res;
	}
	
	/**
	 * Nombre de la funcion:	InsertarColumna
	 * Proposito:				Permite ejecutar la funcion de insercion de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creacion:		2010-08-19 10:28:39
	 */
	function InsertarColumnaPartidaEjecucion($id_columna,$id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg, $en_reporte,$orden_reporte,$total)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_iud';
		$this->codigo_procedimiento = "'KP_COLUMN_INS'";

		//Instancia la clase midlle para la ejecucion de la funcion de la BD
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

		//Ejecuta la funcion
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funcion y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamo a la funcion de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funcion:	ModificarColumna
	 * Proposito:				Permite ejecutar la funcion de modificacion de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creacion:		2010-08-19 10:28:39
	 */
	function ModificarColumnaPartidaEjecucion($id_columna,$id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg,$en_reporte,$orden_reporte,$total)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_iud';
		$this->codigo_procedimiento = "'KP_COLUMN_UPD'";

		//Instancia la clase midlle para la ejecucion de la funcion de la BD
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

		//Ejecuta la funcion
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funcion y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamo a la funcion de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funcion:	EliminarColumna
	 * Proposito:				Permite ejecutar la funcion de eliminacion de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creacion:		2010-08-19 10:28:39
	 */
	function EliminarColumnaPartidaEjecucion($id_columna)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_iud';
		$this->codigo_procedimiento = "'KP_COLUMN_DEL'";

		//Instancia la clase midlle para la ejecucion de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_columna);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		
		$this->var->add_param("NULL");//("'$en_reporte'");
		$this->var->add_param("NULL");//("'$orden_reporte'");


		//Ejecuta la funcion
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funcion y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamo a la funcion de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funcion:	ValidarColumna
	 * Proposito:				Permite ejecutar la validacion del lado del servidor de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creacion:		2010-08-19 10:28:39
	 */
	function ValidarColumnaPartidaEjecucion($operacion_sql,$id_columna,$id_tipo_planilla,$id_columna_tipo,$formula,$valor_defecto,$estado_reg)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validacion por el tipo de operacion
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

			//Validacion exitosa
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
		
			//Validacion exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	
	function ListarVistaColParEje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_partida_ejecucion_sel';
		$this->codigo_procedimiento = "'KP_VICOPAEJ_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecucion de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parometros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parometros especoficos de la estructura programotica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definicion de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo_columna','varchar');
		$this->var->add_def_cols('nombre_columna','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('id_ppto','integer');
		$this->var->add_def_cols('id_planilla','integer');
		
		$this->var->add_def_cols('cuenta','text');
		$this->var->add_def_cols('auxiliar','text');
		$this->var->add_def_cols('partida','text');
		$this->var->add_def_cols('tiene_ppto','numeric');
		
		//Ejecuta la funcion de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funcion y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamo a la funcion de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;exit;
		return $res;
	}
	
	
	/**/
	function ContarVistaColParEje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_columna_partida_ejecucion_sel';
		$this->codigo_procedimiento = "'KP_VICOPAEJ_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecucion de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parometros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parometros especoficos de la estructura programotica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
		//Carga la definicion de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funcion de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funcion
		$this->salida = $this->var->salida;

		//Si la ejecucion fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamo a la funcion de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecucion
		return $res;
	}
	
	
	function ListarColumnaPartidaEjecucionArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_columna_partida_ejecucion_sel';
		if($sortdir=='si'){
				$this->codigo_procedimiento = "'KP_COPAEJARBVER_SEL'";
		}else{
			$this->codigo_procedimiento = "'KP_COPAEJARB_SEL'";
		}

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par?metros espec?ficos de la estructura program?tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		//$this->var->add_param("$agrupador");//raiz

		//Carga la definici?n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_columna_partida_ejecucion','int4');
		$this->var->add_def_cols('id_partida_ejecucion','integer');
		$this->var->add_def_cols('id_partida','integer');
		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('momento','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('cuenta','text');
		$this->var->add_def_cols('auxiliar','text');
		$this->var->add_def_cols('partida','text');
		$this->var->add_def_cols('tiene_ppto','varchar');
		$this->var->add_def_cols('id_padre','integer');
		$this->var->add_def_cols('observaciones','text');
		
		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
		//echo "query:".$this->query; exit;
		return $res;
	}

	/**
	 * Nombre de la funci?n:	ContarUnidadOrganizacional
	 * Prop?sito:				Contar los registros de tkp_estructura_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-06 16:27:45
	 */
	function ContarColumnaPartidaEjecucionArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_columna_partida_ejecucion_sel';
		$this->codigo_procedimiento = "'KP_COPAEJARB_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par?metros espec?ficos de la estructura program?tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		//$this->var->add_param("$raiz");//raiz


		//Carga la definici?n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci?n
		$this->salida = $this->var->salida;

		//Si la ejecuci?n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuci?n
		return $res;
	}
	
}?>