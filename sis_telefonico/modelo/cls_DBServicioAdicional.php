<?php
/**
 * Nombre de la clase:	cls_DBServicioAdicional.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tst_tst_servicio_adicional
 * Autor:				(autogenerado)
 * Fecha creación:		2016-04-29 19:44:10
 */

class cls_DBServicioAdicional
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
	 * Nombre de la función:	ListarServicioAdicional
	 * Propósito:				Desplegar los registros de tst_servicio_adicional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ListarServicioAdicional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_servicio_adicional_sel';
		$this->codigo_procedimiento = "'ST_SERVAD_SEL'";

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
		$this->var->add_def_cols('id_servicio_adicional','int4');
		$this->var->add_def_cols('id_asignacion_equipo','int4');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('importe_servicio','numeric');
		$this->var->add_def_cols('detalle','varchar');
		$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('desc_correspondencia','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarServicioAdicional
	 * Propósito:				Contar los registros de tst_servicio_adicional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ContarServicioAdicional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_servicio_adicional_sel';
		$this->codigo_procedimiento = "'ST_SERVAD_COUNT'";

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
//echo '...'.$this->query; exit;
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarServicioAdicional
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tst_servicio_adicional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function InsertarServicioAdicional($id_servicio_adicional,$id_asignacion_equipo , $fecha_ini ,$estado_reg , $importe_servicio , $detalle ,  $id_correspondencia ,  $fecha_fin )
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_servicio_adicional_iud';
		$this->codigo_procedimiento = "'ST_SERVAD_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_asignacion_equipo);
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param($importe_servicio);
        $this->var->add_param("'$detalle'");
        $this->var->add_param($id_correspondencia);
        $this->var->add_param("'$fecha_fin'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarServicioAdicional
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tst_servicio_adicional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ModificarServicioAdicional($id_servicio_adicional,$id_asignacion_equipo , $fecha_ini ,$estado_reg , $importe_servicio , $detalle ,  $id_correspondencia ,  $fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_servicio_adicional_iud';
		$this->codigo_procedimiento = "'ST_SERVAD_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_servicio_adicional);
		$this->var->add_param($id_asignacion_equipo);
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param($importe_servicio);
        $this->var->add_param("'$detalle'");
        $this->var->add_param($id_correspondencia);
        $this->var->add_param("'$fecha_fin'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarServicioAdicional
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tst_servicio_adicional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function EliminarServicioAdicional($id_servicio_adicional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'gestel.f_tst_servicio_adicional_iud';
		$this->codigo_procedimiento = "'ST_SERVAD_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_servicio_adicional);
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
	 * Nombre de la función:	ValidarServicioAdicional
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tst_servicio_adicional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-01-18 19:44:10
	 */
	function ValidarServicioAdicional($operacion_sql,$id_servicio_adicional,$id_asignacion_equipo , $fecha_ini ,$estado_reg , $importe_servicio , $detalle ,  $id_correspondencia ,  $fecha_fin)
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
				//Validar id_servicio_adicional - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_servicio_adicional");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_servicio_adicional", $id_servicio_adicional))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_asignacion_equipo");
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_asignacion_equipo", $id_asignacion_equipo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			

			//Validar empresa - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("detalle");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "detalle", $detalle))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			//Validar costo_segundo - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_servicio");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_servicio", $importe_servicio))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_servicio_adicional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_servicio_adicional");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_servicio_adicional", $id_servicio_adicional))
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