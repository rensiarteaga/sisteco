<?php
/**
 * Nombre de la clase:	cls_DBCuentaArb.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla sci.tct_cuenta
 * Autor:				Fernando Prudencio
 * Fecha creación:		2007-11-07 15:46:18
 */
class cls_DBCuentaArb{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;

	function __construct(){
		$this->decodificar=$decodificar;
	}
	/**
	 * ***********************************************************
	 * Para el Mannejo de Árboles
	 * 
	 * 
	 ************************************************************* 
	 */

	/**
	 * Nombre de la función:	ListarCuentaRaiz
	 * Propósito:				Desplegar los registros de tct_cuenta
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarCuentaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_tct_cuenta_arb_sel';
		$this->codigo_procedimiento = "'CT_CUENTA_RAIZ_SEL'";

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
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("$gestion");//gestion

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta','int4');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('desc_cuenta','varchar');
		$this->var->add_def_cols('nivel_cuenta','numeric');
		$this->var->add_def_cols('tipo_cuenta','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('cantidad_nivel','numeric');
		$this->var->add_def_cols('estado_gestion','numeric');
		$this->var->add_def_cols('gestion_conta','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('dig_nivel','numeric');
		
		$this->var->add_def_cols('sw_oec','numeric');
		$this->var->add_def_cols('sw_aux','numeric');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('cuenta_sigma','varchar');	
		$this->var->add_def_cols('sw_sigma','varchar');	
		$this->var->add_def_cols('id_cuenta_actualizacion','integer');	
		$this->var->add_def_cols('nombre_cuenta_actualizacion','varchar');
		$this->var->add_def_cols('id_auxiliar_actualizacion','integer');	
		$this->var->add_def_cols('nombre_auxiliar_actualizacion','varchar');	
		$this->var->add_def_cols('sw_sistema_actualizacion','varchar');	
		$this->var->add_def_cols('id_cuenta_dif','integer');	
		$this->var->add_def_cols('nombre_cuenta_dif','varchar');
		$this->var->add_def_cols('id_auxiliar_dif','integer');	
		$this->var->add_def_cols('nombre_auxiliar_dif','varchar');
		$this->var->add_def_cols('cuenta_flujo_sigma','varchar');
		$this->var->add_def_cols('nota_eeff','numeric');
		$this->var->add_def_cols('id_cuenta_sigma','integer');
		$this->var->add_def_cols('desc_sigma','text');
		$this->var->add_def_cols('id_partida_flu_debe','integer');
		$this->var->add_def_cols('id_partida_flu_haber','integer');
		$this->var->add_def_cols('desc_partida_debe','text');
		$this->var->add_def_cols('desc_partida_haber','text');
		$this->var->add_def_cols('sw_caif','varchar');
		$this->var->add_def_cols('sw_siet','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}	
	/**
	 * Nombre de la función:	ListarCuentaArb
	 * Propósito:				Desplegar los registros de tct_cuenta
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_tct_cuenta_arb_sel';
		$this->codigo_procedimiento = "'CT_CUENTA_SEL'";

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
		$this->var->add_param("$agrupador");//raiz
		$this->var->add_param("$gestion");//gestion

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta','int4');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('desc_cuenta','varchar');
		$this->var->add_def_cols('nivel_cuenta','numeric');
		$this->var->add_def_cols('tipo_cuenta','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('id_cuenta_padre','integer');
		$this->var->add_def_cols('nombre_padre','varchar');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('cantidad_nivel','numeric');
		$this->var->add_def_cols('estado_gestion','numeric');
		$this->var->add_def_cols('gestion_conta','numeric');	
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('dig_nivel','numeric');
		$this->var->add_def_cols('sw_oec','numeric');
		$this->var->add_def_cols('sw_aux','numeric');
		$this->var->add_def_cols('descripcion','varchar');	
		$this->var->add_def_cols('cuenta_sigma','varchar');	
		$this->var->add_def_cols('sw_sigma','varchar');	
		$this->var->add_def_cols('id_cuenta_actualizacion','integer');	
		$this->var->add_def_cols('nombre_cuenta_actualizacion','varchar');
		$this->var->add_def_cols('id_auxiliar_actualizacion','integer');	
		$this->var->add_def_cols('nombre_auxiliar_actualizacion','varchar');	
		$this->var->add_def_cols('sw_sistema_actualizacion','varchar');	
		$this->var->add_def_cols('id_cuenta_dif','integer');	
		$this->var->add_def_cols('nombre_cuenta_dif','varchar');
		$this->var->add_def_cols('id_auxiliar_dif','integer');	
		$this->var->add_def_cols('nombre_auxiliar_dif','varchar');
		$this->var->add_def_cols('cuenta_flujo_sigma','varchar');
		$this->var->add_def_cols('nota_eeff','numeric');
		$this->var->add_def_cols('id_cuenta_sigma','integer');
		$this->var->add_def_cols('desc_sigma','text');
		$this->var->add_def_cols('id_partida_flu_debe','integer');
		$this->var->add_def_cols('id_partida_flu_haber','integer');
		$this->var->add_def_cols('desc_partida_debe','text');
		$this->var->add_def_cols('desc_partida_haber','text');
		$this->var->add_def_cols('sw_caif','varchar');
		$this->var->add_def_cols('sw_siet','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo "query:".$this->query;
		exit;*/
		return $res;
	}

	/**
	 * Nombre de la función:	ContarCuentaArb
	 * Propósito:				Contar los registros de tct_cuenta
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function ContarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_tct_cuenta_arb_sel';
		$this->codigo_procedimiento = "'CT_CUENTA_COUNT'";
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
		$this->var->add_param("$raiz");//raiz
		$this->var->add_param("$gestion");//gestion
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res){
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarCuentaRaiz
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_cuenta
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarCuentaRaiz($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda,$sw_oec,$sw_aux,$cuenta_sigma,$sw_sigma,$id_cuenta_actualizacion,$id_auxiliar_actualizacion,$sw_sistema_actualizacion,$id_cuenta_dif,$id_auxiliar_dif,$cuenta_flujo_sigma,$nota_eeff,$id_cuenta_sigma)
	{
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_tct_cuenta_arb_iud';
		$this->codigo_procedimiento = "'CT_CUENRAIZ_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nro_cuenta'");
		$this->var->add_param("'$nombre_cuenta'");
		$this->var->add_param("'$desc_cuenta'");
		$this->var->add_param("$nivel_cuental");
		$this->var->add_param("$tipo_cuenta");
		$this->var->add_param("$sw_transaccional");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_parametro");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$sw_aux'");
		$this->var->add_param("'$cuenta_sigma'");
		$this->var->add_param("'$sw_sigma'");
		$this->var->add_param("$id_cuenta_actualizacion");
		$this->var->add_param("$id_auxiliar_actualizacion");
		$this->var->add_param("'$sw_sistema_actualizacion'");
		$this->var->add_param("$id_cuenta_dif");
		$this->var->add_param("$id_auxiliar_dif");	
        $this->var->add_param("'$cuenta_flujo_sigma'");
        $this->var->add_param("$nota_eeff");
        $this->var->add_param("$id_cuenta_sigma");
        
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	InsertarCuentaArb
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_cuenta
	 * Autor:				    Fernando Prudencio	
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarCuentaArb($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,
			                   $id_cuenta_padre,$id_parametro,$id_moneda,$sw_oec,$sw_aux,$cuenta_sigma,$sw_sigma,$id_cuenta_actualizacion,$id_auxiliar_actualizacion,$sw_sistema_actualizacion,
			                   $id_cuenta_dif,$id_auxiliar_dif,$cuenta_flujo_sigma,$nota_eeff,$id_cuenta_sigma,$id_partida_flu_debe,$id_partida_flu_haber,$sw_caif,$sw_siet)
	{
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_tct_cuenta_arb_iud';
		$this->codigo_procedimiento = "'CT_CUENTA_INS'";
			
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nro_cuenta'");
		$this->var->add_param("'$nombre_cuenta'");
		$this->var->add_param("'$desc_cuenta'");
		$this->var->add_param("$nivel_cuental");
		$this->var->add_param("$tipo_cuenta");
		$this->var->add_param("$sw_transaccional");
		$this->var->add_param("$id_cuenta_padre");
		$this->var->add_param("$id_parametro");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$sw_oec");
		$this->var->add_param("'$sw_aux'");
		$this->var->add_param("'$cuenta_sigma'");
		$this->var->add_param("'$sw_sigma'");
		$this->var->add_param("$id_cuenta_actualizacion");
		$this->var->add_param("$id_auxiliar_actualizacion");
		$this->var->add_param("'$sw_sistema_actualizacion'");
		$this->var->add_param("$id_cuenta_dif");
		$this->var->add_param("$id_auxiliar_dif");	
        $this->var->add_param("'$cuenta_flujo_sigma'");	
        $this->var->add_param("$nota_eeff");
        $this->var->add_param("$id_cuenta_sigma");
        $this->var->add_param("$id_partida_flu_debe");
        $this->var->add_param("$id_partida_flu_haber");
        $this->var->add_param("'$sw_caif'");
        $this->var->add_param("'$sw_siet'");
        
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarCuentaArb
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_cuenta
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ModificarCuentaArb($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda,$sw_oec,$sw_aux,
			                    $cuenta_sigma,$sw_sigma,$id_cuenta_actualizacion,$id_auxiliar_actualizacion,$sw_sistema_actualizacion,$id_cuenta_dif,$id_auxiliar_dif,$cuenta_flujo_sigma,
			                    $nota_eeff,$id_cuenta_sigma,$id_partida_flu_debe,$id_partida_flu_haber,$sw_caif,$sw_siet)
	{
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_tct_cuenta_arb_iud';
		$this->codigo_procedimiento = "'CT_CUENTA_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cuenta");
		$this->var->add_param("'$nro_cuenta'");
		$this->var->add_param("'$nombre_cuenta'");
		$this->var->add_param("'$desc_cuenta'");
		$this->var->add_param("$nivel_cuental");
		$this->var->add_param("$tipo_cuenta");
		$this->var->add_param("$sw_transaccional");
		$this->var->add_param("$id_cuenta_padre");
		$this->var->add_param("$id_parametro");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$sw_oec");
		$this->var->add_param("'$sw_aux'");
		$this->var->add_param("'$cuenta_sigma'");
		$this->var->add_param("'$sw_sigma'");
		$this->var->add_param("$id_cuenta_actualizacion");
		$this->var->add_param("$id_auxiliar_actualizacion");
		$this->var->add_param("'$sw_sistema_actualizacion'");
		$this->var->add_param("$id_cuenta_dif");
		$this->var->add_param("$id_auxiliar_dif");	
 		$this->var->add_param("'$cuenta_flujo_sigma'");	
 		$this->var->add_param("$nota_eeff");
 		$this->var->add_param("$id_cuenta_sigma");
 		$this->var->add_param("$id_partida_flu_debe");
 		$this->var->add_param("$id_partida_flu_haber");
 		$this->var->add_param("'$sw_caif'");
 		$this->var->add_param("'$sw_siet'");
 		
 		
		//Ejecuta la función 
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarCuentaArb
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_cuenta
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarCuentaArb($id_cuenta,$id_cuenta_padre){
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_tct_cuenta_arb_iud';
		$this->codigo_procedimiento = "'CT_CUENTA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cuenta");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_cuenta_padre");
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
	 * Nombre de la función:	EliminarCuentaRaiz
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_cuenta
	 * Autor:				    Fernando Prudencio
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarCuentaRaiz($id_cuenta){
		$this->salida = "";
		$this->nombre_funcion = 'sci.f_tct_cuenta_arb_iud';
		$this->codigo_procedimiento = "'CT_CUENRAIZ_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_cuenta");
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "query:".$this->query;

		return $res;
	}
}?>