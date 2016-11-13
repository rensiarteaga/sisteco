<?php
/**
 * Nombre de la clase:	cls_DBLinea.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tst_tst_linea
 * Autor:				(autogenerado)
 * Fecha creación:		2008-01-18 19:44:10
 */

class cls_DBLinea
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
	 * Nombre de la función:	ListarLinea
	 * Propósito:				Desplegar los registros de tst_linea
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ListarLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_linea_sel';
		$this->codigo_procedimiento = "'ST_LINEA_SEL'";

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
		$this->var->add_def_cols('id_linea','int4');
		$this->var->add_def_cols('empresa','varchar');
		$this->var->add_def_cols('puerto_linea','varchar');
		$this->var->add_def_cols('numero_telefono','varchar');
		$this->var->add_def_cols('costo_segundo','numeric');
		$this->var->add_def_cols('tiempo_espera','integer');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_tipo_llamada','int4');
		$this->var->add_def_cols('desc_tipo_llamada','varchar');
		//mayo2016
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		
		$this->var->add_def_cols('sim_card','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarLinea
	 * Propósito:				Contar los registros de tst_linea
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ContarLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_linea_sel';
		$this->codigo_procedimiento = "'ST_LINEA_COUNT'";

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
	 * Nombre de la función:	ListarLineaDis
	 * Propósito:				Desplegar los registros de tst_linea
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ListarLineaDis($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_linea_sel';
		$this->codigo_procedimiento = "'ST_LINEA_DIS_SEL'";

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
		$this->var->add_def_cols('puerto_linea','varchar');
		$this->var->add_def_cols('empresa','varchar');
		$this->var->add_def_cols('numero_telefono','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarLinea
	 * Propósito:				Contar los registros de tst_linea
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ContarLineaDis($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_linea_sel';
		$this->codigo_procedimiento = "'ST_LINEA_DIS_COUNT'";

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
	 * Nombre de la función:	InsertarLinea
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tst_linea
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function InsertarLinea($id_linea,$empresa,$puerto_linea,$numero_telefono,$id_tipo_llamada,$costo_segundo,$tiempo_espera,$observaciones,$estado_reg,$fecha_ini,$fecha_fin
			,$sim_card
			)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_linea_iud';
		$this->codigo_procedimiento = "'ST_LINEA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$empresa'");
		$this->var->add_param("'$puerto_linea'");
		$this->var->add_param("'$numero_telefono'");
		$this->var->add_param($id_tipo_llamada);
        $this->var->add_param($costo_segundo);
        $this->var->add_param($tiempo_espera);
        $this->var->add_param("'$observaciones'");
        $this->var->add_param("'$estado_reg'");
        $this->var->add_param("'$fecha_ini'");
        $this->var->add_param("'$fecha_fin'");
        
        $this->var->add_param("'$sim_card'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarLinea
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tst_linea
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ModificarLinea($id_linea,$empresa,$puerto_linea,$numero_telefono,$id_tipo_llamada,$costo_segundo,$tiempo_espera,$observaciones,$estado_reg,$fecha_ini,$fecha_fin
			,$sim_card
			)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_linea_iud';
		$this->codigo_procedimiento = "'ST_LINEA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_linea);
		$this->var->add_param("'$empresa'");
		$this->var->add_param("'$puerto_linea'");
		$this->var->add_param("'$numero_telefono'");
		$this->var->add_param($id_tipo_llamada);
        $this->var->add_param($costo_segundo);
          $this->var->add_param($tiempo_espera);
        $this->var->add_param("'$observaciones'");
        $this->var->add_param("'$estado_reg'");
        $this->var->add_param("'$fecha_ini'");
        $this->var->add_param("'$fecha_fin'");
        $this->var->add_param("'$sim_card'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarLinea
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tst_linea
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function EliminarLinea($id_linea)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_linea_iud';
		$this->codigo_procedimiento = "'ST_LINEA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_linea);
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
	 * Nombre de la función:	ValidarLinea
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tst_linea
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ValidarLinea($operacion_sql,$id_linea,$empresa,$puerto_linea,$numero_telefono,$id_tipo_llamada,$costo_segundo,$tiempo_espera,$observaciones)
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
				//Validar id_linea - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_linea");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_linea", $id_linea))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar empresa - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("empresa");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "empresa", $empresa))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar puerto_linea - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("puerto_linea");
			$tipo_dato->set_MaxLength(4);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "puerto_linea", $puerto_linea))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar numero_telefono - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("numero_telefono");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "numero_telefono", $numero_telefono))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_llamada - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_llamada");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_llamada", $id_tipo_llamada))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			//Validar costo_segundo - tipo numeric
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_segundo");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_segundo", $costo_segundo))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(150);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar tiempo_espera - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tiempo_espera");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "tiempo_espera", $tiempo_espera))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_linea - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_linea");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_linea", $id_linea))
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