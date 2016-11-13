<?php
/**
 * Nombre de la clase:	cls_DBEmpleadoHorario.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_historico_asignacion
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-12 09:24:17
 */

 
class cls_DBEmpleadoHorario
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
	 * Nombre de la función:	ListarEmpleadoHorario
	 * Propósito:				Desplegar los registros de tkp_empleado_horario
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ListarEmpleadoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_horario_sel';
		$this->codigo_procedimiento = "'KP_EMP_HOR_SEL'";

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
		$this->var->add_def_cols('id_empleado_horario','int4');
		$this->var->add_def_cols('id_empleado','integer');
		
        $this->var->add_def_cols('id_turno','integer');
        $this->var->add_def_cols('fecha_reg','date');
        $this->var->add_def_cols('estado_reg','varchar');
        $this->var->add_def_cols('fecha_ini','date');
        $this->var->add_def_cols('fecha_fin','date');
        $this->var->add_def_cols('codigo_turno','varchar');
        $this->var->add_def_cols('horario','text');
        $this->var->add_def_cols('nombre_turno','varchar');
        $this->var->add_def_cols('tipo_turno','varchar');
        $this->var->add_def_cols('variacion','varchar');
        
        //Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEmpleadoHorario
	 * Propósito:				Contar los registros de tkp_empleado_horario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ContarEmpleadoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_horario_sel';
		$this->codigo_procedimiento = "'KP_EMP_HOR_COUNT'";

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
	 * Nombre de la función:	InsertarEmpleadoHorario
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_empleado_horario
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		2010-05-12 09:24:17
	 */
	function InsertarEmpleadoHorario($id_empleado_horario,$id_empleado,$id_turno,$estado_reg,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_horario_iud';
		$this->codigo_procedimiento = "'KP_EMP_HOR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_turno);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$fecha_ini'");
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
	 * Nombre de la función:	ModificarEmpleadoHorario
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_empleado_horario
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		2010-05-12 09:24:17
	 */
	function ModificarEmpleadoHorario($id_empleado_horario,$id_empleado,$id_turno,$estado_reg,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_horario_iud';
		$this->codigo_procedimiento = "'KP_EMP_HOR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_horario);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_turno);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$fecha_ini'");
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
	 * Nombre de la función:	EliminarEmpleadoHorario
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_empleado_horario
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		2010-05-12 09:24:17
	 */
	function EliminarEmpleadoHorario($id_empleado_horario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_empleado_horario_iud';
		$this->codigo_procedimiento = "'KP_EMP_HOR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_empleado_horario);
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
	 * Nombre de la función:	ValidarEmpleadoHorario
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_historico_asignacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ValidarEmpleadoHorario($operacion_sql,$id_empleado_horario,$id_empleado,$id_turno,$estado_reg,$fecha_ini,$fecha_fin)
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
				//Validar id_empleado_horario - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_empleado_horario");
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(),"id_empleado_horario",$id_empleado_horario))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar id_horario - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_horario");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_turno", $id_turno))
			{
				$this->salida = $valid->salida;
				return false;
			}			
							
			//Validar estado_reg - tipo text
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("estado_reg");
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
			//Validar id_empleado_horario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado_horario");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_horario", $id_empleado_horario))
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