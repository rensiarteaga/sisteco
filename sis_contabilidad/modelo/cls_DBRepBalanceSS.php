<?php
/**
 * Nombre de la clase:	cls_DBRepBalanceSS.php
 * Propósito:			Permite ejecutar  el listado de los documentos  de un comprobante de la tabla tct_cuenta
 * Autor:				Ana Maria villegas
 * Fecha creación:		2009-06-17 17:13:36
 */

 
class cls_DBRepBalanceSS
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
	 * Nombre de la función:	Listar el Detalle de las cuentas.
	 * Propósito:				Desplegar los registros de tct_cuenta
	 * Autor:				    Ana Maria
	 * Fecha de creación:		2009-06-17 17:13:36
	 */
	function BalanceSSDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$nivel,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_rep_balance_ss_sel';
		$this->codigo_procedimiento = "'CT_RBALSS_SEL'";

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
		$this->var->add_param($id_parametro);//id_parametro
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param($nivel);//nivel
        $this->var->add_param("'$fecha_fin'");//fecha_fin
        
        
    
  		$this->var->add_def_cols('nro_cuenta',' VARCHAR(20)'); 
  		$this->var->add_def_cols('nombre_cuenta',' VARCHAR(100)'); 
  		$this->var->add_def_cols('suma_debe',' INTEGER'); 
  		$this->var->add_def_cols('suma_haber',' INTEGER'); 
  		$this->var->add_def_cols('saldo','INTEGER');
  		$this->var->add_def_cols('sw_transaccional','numeric(1,0)');
  		$this->var->add_def_cols('nivel_cuenta','numeric(1,0)');
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	  /*  echo $this->query;
		exit();*/
		return $res;
	}
	/**
	 * Nombre de la función:	ContarBalanceSSDetalle
	 * Propósito:				Contar los registros del reporte balance
	 *  Autor:				    AVQ
	 * Fecha de creación:		2009-06-18 16:13:36
	 */
	function ContarBalanceSSDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$nivel,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_rep_balance_ss_sel';
		$this->codigo_procedimiento = "'CT_RBALSS_COUNT'";

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
		$this->var->add_param($id_parametro);//id_parametro
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param($nivel);//nivel
        $this->var->add_param("'$fecha_fin'");//fecha_fin
        

		
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

/*	echo $this->query;
		exit();*/		
		//Retorna el resultado de la ejecución
		return $res;
	}

	
	
}?>