<?php
/**
 * Nombre de la clase:	cls_DBSietCbte.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsi_siet_cbte
 * Autor:				A.V.Q.
 * Fecha creación:		2015-11-12
 */

 
class cls_DBSietCbte
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
	 * Nombre de la función:	ListarSietCbte
	 * Propósito:				Desplegar los registros de tsi_siet_cbte
	 * Autor:				    a.v.q.
	 * Fecha de creación:		2015-11-12
	 */
	function ListarSietCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_sel';
		$this->codigo_procedimiento = "'PR_SIECBT_SEL'";

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
		$this->var->add_param("'$tipo_declara'");//id_actividad
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('nro_cbte','varchar');
		$this->var->add_def_cols('fecha_salida_cb','DATE');
		$this->var->add_def_cols('concepto_cbte','VARCHAR');
		$this->var->add_def_cols('nombre_largo','TEXT');
		$this->var->add_def_cols('id_siet_cbte','integer');
		$this->var->add_def_cols('id_siet_declara','bigint');
		$this->var->add_def_cols('id_subsistema','integer');
        $this->var->add_def_cols('periodo_lite','varchar');
	    $this->var->add_def_cols('sw_ingresa_declaracion','varchar');
        $this->var->add_def_cols('id_extracto_bancario','integer');
        $this->var->add_def_cols('id_periodo_dec','integer');
	    $this->var->add_def_cols('tipo_declara','varchar');
        $this->var->add_def_cols('id_cuenta_bancaria','integer');
        $this->var->add_def_cols('nro_cuenta_banco','varchar');
        $this->var->add_def_cols('importe','numeric');
        $this->var->add_def_cols('sw_fa','varchar');
        $this->var->add_def_cols('estado','varchar'); 
              $this->var->add_def_cols('id_cbte_ant_rev','integer');
              $this->var->add_def_cols('id_siet_cbte_rec','integer');
              $this->var->add_def_cols('sw_reversion','varchar');
              $this->var->add_def_cols('id_cuenta_doc','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		 /*echo $this->query;
		 exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSietCbte
	 * Propósito:				Contar los registros de tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ContarSietCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_sel';
		$this->codigo_procedimiento = "'PR_SIECBT_COUNT'";

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
		$this->var->add_param("'$tipo_declara'");//id_actividad
		
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
	 * Nombre de la función:	InsertarSietCbte
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function InsertarSietCbte($id_siet_cbte,$id_siet_declara,$id_extracto_bancario,$sw_ingresa_declaracion,$sw_fa,$importe)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_iud';
		$this->codigo_procedimiento = "'PR_SIECBT_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param($id_siet_declara);
		$this->var->add_param($id_extracto_bancario);
        $this->var->add_param("'$sw_ingresa_declaracion'");
        $this->var->add_param("'$sw_fa'");
        $this->var->add_param("'NULL'");
        $this->var->add_param("$importe");
      //Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
              exit;*/
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarSietCbte
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ValidarSiNo($id_siet_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_iud';
		$this->codigo_procedimiento = "'PR_VALSINO_UPD'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_siet_declara);
		$this->var->add_param("NULL");
		$this->var->add_param("'NULL'"); //sw_ingresa_declaracion
		$this->var->add_param("'NULL'"); //sw_ingresa_declaracion
		$this->var->add_param("'NULL'");
		$this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/
		return $res;
	}
	/**
	 * Nombre de la función:	ModificarSietCbte
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ModificarSietCbte($id_siet_cbte,$id_siet_declara,$id_extracto_bancario,$sw_ingresa_declaracion,$sw_fa)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_iud';
		$this->codigo_procedimiento = "'PR_SIECBT_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param($id_siet_declara);
		$this->var->add_param($id_extracto_bancario);
        $this->var->add_param("'$sw_ingresa_declaracion'");
        $this->var->add_param("'$sw_fa'");
        $this->var->add_param("'NULL'");
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
	 * Nombre de la función:	EliminarSietCbte
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsi_siet_cbte
	 * Autor:				    avq
	 * Fecha de creación:		01/11/2015
	 */
	function EliminarSietCbte($id_siet_cbte)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_iud';
		$this->codigo_procedimiento = "'PR_SIECBT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL"); //descripcion
		$this->var->add_param("NULL"); //descripcion
		$this->var->add_param("'NULL'");
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
	 * Nombre de la función:	ValidarSietCbte
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ValidarSietCbte($operacion_sql,$id_siet_cbte,$id_cbte,$id_subsistema)
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
				//Validar id_cobertura - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_siet_cbte");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_siet_cbte", $id_siet_cbte))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cobertura - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_siet_cbte");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_siet_cbte", $id_siet_cbte))
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
	/**
	 * Nombre de la función:	ListarRegistroComprobante
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ListarComprobantesFaltantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_sel';
		$this->codigo_procedimiento = "'PR_CBTEFA_SEL'";
	
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
		$this->var->add_param("'$tipo_declara'");//id_actividad
	
		
		 
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_siet_cbte','integer');
		$this->var->add_def_cols('id_cbte','integer');
		$this->var->add_def_cols('nro_cbte','varchar');
		$this->var->add_def_cols('concepto_cbte','varchar');
		$this->var->add_def_cols('glosa_cbte','varchar');
		$this->var->add_def_cols('acreedor','varchar');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('desc_clases','varchar');
		$this->var->add_def_cols('desc_subsistema','varchar');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
		$this->var->add_def_cols('tipo_declara','varchar');
		$this->var->add_def_cols('id_periodo_dec','integer');
		$this->var->add_def_cols('importe','numeric');
        $this->var->add_def_cols('nro_cuenta_banco','varchar');
        $this->var->add_def_cols('fecha_cbte','date');
        $this->var->add_def_cols('sw_ingresa_declaracion','varchar');
        $this->var->add_def_cols('nro_doc','varchar');
        
        
        
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		// echo $this->query;exit();
		/*if ($_SESSION["ss_id_usuario"]==131){
		 echo $this->query;
		exit;
		} */
		return $res;
	}
	/**
	 * Nombre de la función:	ContarSietCbte
	 * Propósito:				Contar los registros de tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ContarComprobantesFaltantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_sel';
		$this->codigo_procedimiento = "'PR_CBTEFA_COUNT'";
	
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
		$this->var->add_param("'$tipo_declara'");//id_actividad
	
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
	 * Nombre de la función:	ExtraerFAdeFR
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ExtraerFAdeFR($id_siet_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_iud';
		$this->codigo_procedimiento = "'PR_EXFAFR_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_siet_declara);
		$this->var->add_param("NULL");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		 exit;*/
		return $res;
	}
	/**
	 * Nombre de la función:	ExtraerFAdeFR
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function UnirFAenFR($id_siet_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_iud';
		$this->codigo_procedimiento = "'PR_UNFAFR_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_siet_declara);
		$this->var->add_param("NULL");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		 exit;*/
		return $res;
	}
	/**
	 * Nombre de la función:	ModificarSietCbteReversion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function InsertarSietCbteReversion($id_siet_cbte,$id_siet_declara,$id_extracto_bancario,$sw_ingresa_declaracion,$sw_fa,$sw_reversion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_iud';
		$this->codigo_procedimiento = "'PR_SIECBTREV_UPD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param($id_siet_declara);
		$this->var->add_param($id_extracto_bancario);
		$this->var->add_param("'$sw_ingresa_declaracion'");
		$this->var->add_param("'$sw_fa'");
		$this->var->add_param("'$sw_reversion'");
		$this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	        /*echo "$this->query";
               exit;*/
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarSietCbteIdCbteRep
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function InsertarSietCbteIdCbteRep($id_siet_cbte,$id_siet_declara,$id_cbte_ant_rev)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_iud';
		$this->codigo_procedimiento = "'PR_IDCBTEREP_UPD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param($id_siet_declara);
		$this->var->add_param($id_cbte_ant_rev);
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
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
	 * Nombre de la función:	InsertarSietCbteNuevo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	         
	function InsertarSietCbteNuevo($id_siet_declara,$id_siet_cbte,$importe,$id_cuenta_bancaria,$glosa,$id_cuenta_doc,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_recurso_iud';
		$this->codigo_procedimiento = "'PR_SIECBTREC_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_declara);
		$this->var->add_param($id_siet_cbte);
	    $this->var->add_param("$importe");//id_extracto_bancario
		$this->var->add_param("$id_cuenta_bancaria");//sw_ingresa_declaracion
		$this->var->add_param("'$glosa'");//sw_fa
		$this->var->add_param("$id_cuenta_doc");
		$this->var->add_param("'$estado'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		 exit;*/
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarSietCbteNuevo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	
	function ModificarSietCbteNuevo($id_siet_declara,$id_siet_cbte,$importe,$id_cuenta_bancaria,$glosa,$id_cuenta_doc,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_recurso_iud';
		$this->codigo_procedimiento = "'PR_SIECBTREC_UPD'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_declara);
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param("$importe");//id_extracto_bancario
		$this->var->add_param("$id_cuenta_bancaria");//sw_ingresa_declaracion
		$this->var->add_param("'$glosa'");//sw_fa
		$this->var->add_param("$id_cuenta_doc");
		$this->var->add_param("'$estado'");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		 exit;*/
		return $res;
	}
	/**
	 * Nombre de la función:	ListarSietCbte
	 * Propósito:				Desplegar los registros de tpr_siet_cbte
	 * Autor:				    a.v.q.
	 * Fecha de creación:		2015-11-12
	 */
	function ListarSietCbteNuevo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_recurso_sel';
		$this->codigo_procedimiento = "'PR_SIECBTREC_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtroPR_SIECBTREC_SEL
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
		$this->var->add_param("'$tipo_declara'");//id_actividad
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('nro_cbte','varchar');
		$this->var->add_def_cols('fecha_salida_cb','DATE');
		$this->var->add_def_cols('concepto_cbte','TEXT');
		$this->var->add_def_cols('nombre_largo','TEXT');
		$this->var->add_def_cols('id_siet_cbte','integer');
		$this->var->add_def_cols('id_siet_declara','bigint');
		$this->var->add_def_cols('id_subsistema','integer');
		$this->var->add_def_cols('periodo_lite','varchar');
		$this->var->add_def_cols('sw_ingresa_declaracion','varchar');
		$this->var->add_def_cols('id_extracto_bancario','integer');
		$this->var->add_def_cols('id_periodo_dec','integer');
		$this->var->add_def_cols('tipo_declara','varchar');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
		$this->var->add_def_cols('nro_cuenta_banco','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('sw_fa','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_cbte_ant_rev','integer');
		$this->var->add_def_cols('id_siet_cbte_rec','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		 exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSietCbte
	 * Propósito:				Contar los registros de tsi_siet_cbte
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ContarSietCbteNuevo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_recurso_sel';
		$this->codigo_procedimiento = "'PR_SIECBTREC_COUNT'";
	
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
		$this->var->add_param("'$tipo_declara'");//id_actividad
	
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
	 * Nombre de la función:	InsertarSietCbteReversion
	 * Propósito:				Permite ejecutar la función de reversion de la tabla tpr_siet_cbte para revertir comprobantes
	 * Autor:				    a.v.q
	 * Fecha de creación:		09/09/2016
	 */
	
	function InsertarSietCbteReversionExcel($id_siet_cbte)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_iud';
		$this->codigo_procedimiento = "'PR_CBTREVEXCEL_UPD'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("NULL");
		
			//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
}?>