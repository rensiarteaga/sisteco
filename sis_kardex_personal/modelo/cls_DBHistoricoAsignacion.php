<?php
/**
 * Nombre de la clase:	cls_DBHistoricoAsignacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_historico_asignacion
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-12 09:24:17
 */

 
class cls_DBHistoricoAsignacion
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
	 * Nombre de la función:	ListarHistoricoAsignacion
	 * Propósito:				Desplegar los registros de tkp_historico_asignacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ListarHistoricoAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_historico_asignacion_sel';
		$this->codigo_procedimiento = "'KP_HISASIG_SEL'";

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
		$this->var->add_def_cols('id_historico_asignacion','int4');
		$this->var->add_def_cols('fecha_asignacion','date');
		$this->var->add_def_cols('estado','varchar');
        $this->var->add_def_cols('id_unidad_organizacional','integer');
        $this->var->add_def_cols('id_empleado','integer');
        $this->var->add_def_cols('fecha_finalizacion','date');
        $this->var->add_def_cols('fecha_registro','date');
        $this->var->add_def_cols('nombre_unidad','varchar');
        $this->var->add_def_cols('nombre_cargo','varchar');
        $this->var->add_def_cols('id_persona','integer');
        $this->var->add_def_cols('desc_persona','text');
        $this->var->add_def_cols('id_empleado_suplente','integer');
        $this->var->add_def_cols('suplente','text');
        
        $this->var->add_def_cols('id_lugar','integer');
        $this->var->add_def_cols('desc_lugar','varchar');
        
        
        $this->var->add_def_cols('usuario_reg','text');
        $this->var->add_def_cols('usuario_mod','text');
        $this->var->add_def_cols('fecha_ultima_mod','timestamp');
        
        $this->var->add_def_cols('id_cargo','integer');
        $this->var->add_def_cols('id_tipo_contrato','integer');
        $this->var->add_def_cols('desc_cargo','text');
        $this->var->add_def_cols('desc_tipo_contrato','varchar');
        $this->var->add_def_cols('tipo_registro','varchar');
        $this->var->add_def_cols('sw_impuesto','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarHistoricoAsignacion
	 * Propósito:				Contar los registros de tkp_historico_asignacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ContarHistoricoAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_historico_asignacion_sel';
		$this->codigo_procedimiento = "'KP_HISASIG_COUNT'";

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
	 * Nombre de la función:	InsertarHistoricoAsignacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_historico_asignacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
function InsertarHistoricoAsignacion($id_historico_asignacion,$fecha_asignacion,$estado,$id_unidad_organizacional,$id_empleado,$fecha_finalizacion,$id_empleado_suplente
	,$id_lugar
	//19.05.2014
	,$id_cargo,$id_tipo_contrato,$tipo_registro
		//abril2016
		,$sw_impuesto
	)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_historico_asignacion_iud';
		$this->codigo_procedimiento = "'KP_HISASIG_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_asignacion'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("$id_unidad_organizacional");
		$this->var->add_param("$id_empleado");
		$this->var->add_param("'$fecha_finalizacion'");
		$this->var->add_param($id_empleado_suplente);
		$this->var->add_param($id_lugar);
		$this->var->add_param($id_cargo);
		//19.05.2014
		$this->var->add_param($id_tipo_contrato);
		$this->var->add_param("'$tipo_registro'");
		//abril2016
		$this->var->add_param("'$sw_impuesto'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	ModificarHistoricoAsignacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_historico_asignacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
function ModificarHistoricoAsignacion($id_historico_asignacion,$fecha_asignacion,$estado,$id_unidad_organizacional,$id_empleado,$fecha_finalizacion,$id_empleado_suplente
	,$id_lugar
	//19.05.2014
	,$id_cargo,$id_tipo_contrato,$tipo_registro
		//abril2016
		,$sw_impuesto
	)
	{// echo $fecha_asignacion; exit;
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_historico_asignacion_iud';
		$this->codigo_procedimiento = "'KP_HISASIG_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_historico_asignacion");
		$this->var->add_param("'$fecha_asignacion'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("$id_unidad_organizacional");
		$this->var->add_param("$id_empleado");
		$this->var->add_param("'$fecha_finalizacion'");
		$this->var->add_param($id_empleado_suplente);
		$this->var->add_param($id_lugar);
		//19.05.2014
		$this->var->add_param($id_cargo);
		$this->var->add_param($id_tipo_contrato);
		$this->var->add_param("'$tipo_registro'");
		//abril2016
		$this->var->add_param("'$sw_impuesto'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarHistoricoAsignacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_historico_asignacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
function EliminarHistoricoAsignacion($id_historico_asignacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_historico_asignacion_iud';
		$this->codigo_procedimiento = "'KP_HISASIG_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_historico_asignacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_empleado_suplente
		$this->var->add_param("NULL");
		//19.05.2014
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//abril2016
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
	 * Nombre de la función:	ValidarHistoricoAsignacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_historico_asignacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ValidarHistoricoAsignacion($operacion_sql,$id_historico_asignacion,$fecha_asignacion,$estado,$id_unidad_organizacional,$id_empleado,$fecha_finalizacion)
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
				//Validar id_historico_asignacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_historico_asignacion");
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_historico_asignacion", $id_historico_asignacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			//Validar fecha_asignacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_asignacion");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_asignacion", $fecha_asignacion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar estado - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}			
			//Validar id_unidad_organizacional - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_unidad_organizacional");
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
				{
					$this->salida = $valid->salida;
					return false;
				}				
			//Validar id_empleado - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_empleado");
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
				{
					$this->salida = $valid->salida;
					return false;
				}
			//Validar fecha_finalizacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_finalizacion");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_finalizacion", $fecha_finalizacion))
			{
				$this->salida = $valid->salida;
				return false;
			}	
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_historico_asignacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_historico_asignacion");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_historico_asignacion", $id_historico_asignacion))
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