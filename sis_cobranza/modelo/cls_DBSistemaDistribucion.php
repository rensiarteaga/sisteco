<?php
/**
 * Nombre de la Clase:	cls_DBSistemaDistribucion 
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tct_actualizacion
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		13/12/2010
 */
class cls_DBSistemaDistribucion
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
	 * Nombre de la función:	InsertarSistemadistribucion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function InsertarSistemadistribucion($id_sistema,$id_sistema_distribucion,$fecha_separacion ,$id_depto,$conexion,$nombre_sistema_distribucion,$id_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_sistema_distribucion_iud';
		$this->codigo_procedimiento = "'CT_SISDIS_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$id_sistema_distribucion'");
		$this->var->add_param("'$nombre_sistema_distribucion'");
		$this->var->add_param("$id_depto");
		$this->var->add_param("'$conexion'");
		$this->var->add_param("'$fecha_separacion'");
		$this->var->add_param("$id_gestion");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarAuxiliar
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ModificarSistemadistribucion($id_sistema,$id_sistema_distribucion,$fecha_separacion ,$id_depto,$conexion,$nombre_sistema_distribucion,$id_gestion)
	{
		 
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_sistema_distribucion_iud';
		$this->codigo_procedimiento = "'CT_SISDIS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_sistema");
		$this->var->add_param("'$id_sistema_distribucion'");
		$this->var->add_param("'$nombre_sistema_distribucion'");
		$this->var->add_param("$id_depto");
		$this->var->add_param("'$conexion'");
		$this->var->add_param("'$fecha_separacion'");
		$this->var->add_param("$id_gestion");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarAuxiliar
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function EliminarSistemadistribucion($id_sistema)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_sistema_distribucion_iud';
		$this->codigo_procedimiento = "'CT_SISDIS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_sistema);
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
	 * Nombre de la función:	ListarSistemaDistribucion
	 * Propósito:				Desplegar los registros de tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		
	 */
	function ListarSistemaDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_sistema_distribucion_sel';
		$this->codigo_procedimiento = "'CB_SISDIS_SEL'";

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
		$this->var->add_def_cols('id_sistema','integer');
		$this->var->add_def_cols('id_sistema_distribucion','varchar');
		$this->var->add_def_cols('nombre_sistema_distribucion','varchar');
		$this->var->add_def_cols('id_depto_conta','integer');
		$this->var->add_def_cols('nombre_depto','varchar(200)');
		$this->var->add_def_cols('conexion','varchar');
		$this->var->add_def_cols('fecha_separacion','date');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('fecha_reg','timestamp');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('gestion','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarActualizacion
	 * Propósito:				Contar los registros de tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ContarSistemaDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_sistema_distribucion_sel';
		$this->codigo_procedimiento = "'CB_SISDIS_COUNT'";

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
	
	
}?>