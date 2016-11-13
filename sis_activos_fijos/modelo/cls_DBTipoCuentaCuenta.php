<?php
/**
 * Nombre de la clase:	cls_DBTipoCuentaCuenta.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla taf_taf_tipo_cuenta_cuenta
 * Autor:				jrivera
 * Fecha creación:		2010-11-08 18:08:55
 */

 
class cls_DBTipoCuentaCuenta
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
	 * Nombre de la función:	ListarTipoCuenta
	 * Propósito:				Desplegar los registros de taf_tipo_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-11-08 18:08:55
	 */
	function ListarTipoCuentaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_p,$id_tipo_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_cuenta_cuenta_sel';
		$this->codigo_procedimiento = "'AF_TIPCUCU_SEL'";

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
		
		$this->var->add_param($id_gestion);
		if($id_p=='id')
			$this->var->add_param("NULL");
		else 
			$this->var->add_param($id_p);
		$this->var->add_param($id_tipo_cuenta);

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_cuenta','int4');
		$this->var->add_def_cols('id_tipo_cuenta_cuenta','int4');
		$this->var->add_def_cols('id','int4');
		$this->var->add_def_cols('id_p','int4');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('id_tipo_activo','int4');
		$this->var->add_def_cols('id_sub_tipo_activo','int4');
		
		$this->var->add_def_cols('text','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('leaf','varchar');
		$this->var->add_def_cols('allowDelete','varchar');
		$this->var->add_def_cols('allowEdit','varchar');
		$this->var->add_def_cols('allowDrag','varchar');
		$this->var->add_def_cols('qtip','varchar');
		$this->var->add_def_cols('xxxx','varchar');
		
		$this->var->add_def_cols('id_cuenta','int4');
		$this->var->add_def_cols('id_auxiliar','int4');
			
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('codigo_cuenta','varchar');
		$this->var->add_def_cols('nombre_auxiliar','varchar');
		$this->var->add_def_cols('desc_presupuesto','varchar');
		$this->var->add_def_cols('desc_tipo_activo','varchar');
		$this->var->add_def_cols('desc_sub_tipo_activo','varchar');


		//Ejecuta la función de consulta
		$res = $this->var->exec_query('*','asoc');

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarTipoCuenta
	 * Propósito:				Permite ejecutar la función de inserción de la tabla taf_tipo_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-11-08 18:08:55
	 */
	function InsertarTipoCuentaCuenta($id_p,$id_tipo_cuenta,$id_gestion,$id_presupuesto,$id_tipo_activo,$id_sub_tipo_activo,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_cuenta_cuenta_iud';
		$this->codigo_procedimiento = "'AF_TIPCUCU_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_p);
		$this->var->add_param($id_tipo_cuenta);
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_tipo_activo);
		$this->var->add_param($id_sub_tipo_activo);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoCuenta
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_tipo_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-11-08 18:08:55
	 */
	function ModificarTipoCuentaCuenta($id,$id_tipo_cuenta,$id_gestion,$id_presupuesto,$id_tipo_activo,$id_sub_tipo_activo,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_cuenta_cuenta_iud';
		$this->codigo_procedimiento = "'AF_TIPCUCU_MOD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
		$this->var->add_param($id_tipo_cuenta);
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_tipo_activo);
		$this->var->add_param($id_sub_tipo_activo);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoCuenta
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_tipo_cuenta
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-11-08 18:08:55
	 */
	function EliminarTipoCuentaCuenta($id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_tipo_cuenta_cuenta_iud';
		$this->codigo_procedimiento = "'AF_TIPCUCU_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
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
	
	
}?>