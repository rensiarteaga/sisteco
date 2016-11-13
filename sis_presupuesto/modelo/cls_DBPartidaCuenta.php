<?php
/**
 * Nombre de la clase:	cls_DBPartidaCuenta.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_partida_cuenta
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-07 11:38:59
 */
 
class cls_DBPartidaCuenta
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
	 * Nombre de la función:	ListarPartidaCuenta
	 * Propósito:				Desplegar los registros de tpr_partida_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ListarCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_cuenta_sel';
		$this->codigo_procedimiento = "'PR_CUENTAPARTIDA_SEL'";

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
		$this->var->add_def_cols('id_partida_cuenta','int4');
		$this->var->add_def_cols('id_cuenta','integer');
 		$this->var->add_def_cols('id_partida','integer');
		$this->var->add_def_cols('partida_cuenta','TEXT');
 		$this->var->add_def_cols('sw_deha','numeric');
		$this->var->add_def_cols('sw_rega','numeric');
		$this->var->add_def_cols('id_parametro','integer');
        $this->var->add_def_cols('desc_parametro','numeric');
        $this->var->add_def_cols('nro_cuenta','varchar');
        $this->var->add_def_cols('nombre_cuenta','varchar');
        $this->var->add_def_cols('codigo_partida','varchar');
        $this->var->add_def_cols('nombre_partida','varchar');
        $this->var->add_def_cols('id_gestion','integer');
        $this->var->add_def_cols('id_moneda','integer');
        $this->var->add_def_cols('desc_moneda','varchar');
        $this->var->add_def_cols('sw_movimiento','numeric');	 
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*if($_SESSION["ss_id_usuario"]==120){
		echo $this->query;	exit;	
		}*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPartidaCuenta
	 * Propósito:				Contar los registros de tpr_partida_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ContarCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_cuenta_sel';
		$this->codigo_procedimiento = "'PR_CUENTAPARTIDA_COUNT'";

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
	 * Nombre de la función:	ListarPartidaCuenta
	 * Propósito:				Desplegar los registros de tpr_partida_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ListarPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_cuenta_sel';
		$this->codigo_procedimiento = "'PR_PARCUE_SEL'";

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
		$this->var->add_def_cols('id_partida_cuenta','int4');
		$this->var->add_def_cols('id_debe','integer');
		$this->var->add_def_cols('debe','text');
		$this->var->add_def_cols('id_haber','integer');
		$this->var->add_def_cols('haber','text');
		$this->var->add_def_cols('id_recurso','integer');
		$this->var->add_def_cols('recurso','text');
		$this->var->add_def_cols('id_gasto','integer');
		$this->var->add_def_cols('gasto','text');
		$this->var->add_def_cols('sw_deha','numeric');
		$this->var->add_def_cols('sw_rega','numeric');
        $this->var->add_def_cols('id_parametro','integer');
        $this->var->add_def_cols('desc_parametro','numeric');
        $this->var->add_def_cols('nro_cuenta','varchar');
        $this->var->add_def_cols('nombre_cuenta','varchar');
        $this->var->add_def_cols('codigo_partida','varchar');
        $this->var->add_def_cols('nombre_partida','varchar');
        $this->var->add_def_cols('id_moneda','integer');
        $this->var->add_def_cols('desc_moneda','varchar');
        	
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
	 * Nombre de la función:	ContarPartidaCuenta
	 * Propósito:				Contar los registros de tpr_partida_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ContarPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_cuenta_sel';
		$this->codigo_procedimiento = "'PR_PARCUE_COUNT'";

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
	 * Nombre de la función:	InsertarPartidaCuenta
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_partida_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function InsertarPartidaCuenta($id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_cuenta_iud';
		$this->codigo_procedimiento = "'PR_PARCUE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$sw_deha");
		$this->var->add_param("$id_partida");
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_parametro);
		$this->var->add_param($sw_rega);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPartidaCuenta
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_partida_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ModificarPartidaCuenta($id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_cuenta_iud';
		$this->codigo_procedimiento = "'PR_PARCUE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_cuenta);
		$this->var->add_param("$sw_deha");
		$this->var->add_param("$id_partida");
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_parametro);
		$this->var->add_param($sw_rega);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPartidaCuenta
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_partida_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function EliminarPartidaCuenta($id_partida_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_cuenta_iud';
		$this->codigo_procedimiento = "'PR_PARCUE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_cuenta);
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
	 * Nombre de la función:	ValidarPartidaCuenta
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_partida_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-07 11:38:59
	 */
	function ValidarPartidaCuenta($operacion_sql,$id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega)
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
				//Validar id_partida - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_partida_cuenta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_cuenta", $id_partida_cuenta))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo_partida - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_deha");
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "sw_deha", $sw_deha))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_partida - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida");
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida", $id_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nivel_partida - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta");
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar sw_transaccional - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro");
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_partida - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_rega");
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "sw_rega", $sw_rega))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_partida - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_cuenta");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_cuenta", $id_partida_cuenta))
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