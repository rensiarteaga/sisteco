<?php
/**
 * Nombre de la clase:	cls_DBDeptoConta.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_depto_conta
 * Autor:				avq
 * Fecha creación:		2009-06-16 18:30:13
 */

 
class cls_DBDeptoConta
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
	 * Nombre de la función:	ListarDepartamentoConta
	 * Propósito:				Desplegar los registros de tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-16 18:32:13
	 */
	function ListarDepartamentoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_conta_sel';
		$this->codigo_procedimiento = "'PM_DEPCON_SEL'";

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
		$this->var->add_def_cols('id_depto_conta','integer');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('id_ep','integer');
		$this->var->add_def_cols('id_uo','integer');
		$this->var->add_def_cols('sw_central','varchar');
		$this->var->add_def_cols('sw_estado','varchar');
		$this->var->add_def_cols('nombre_depto','varchar');
        $this->var->add_def_cols('desc_ep','text');
        $this->var->add_def_cols('desc_uo','varchar');
        $this->var->add_def_cols('id_financiador','integer');
        $this->var->add_def_cols('id_regional','integer');
        $this->var->add_def_cols('id_programa','integer');
        $this->var->add_def_cols('id_proyecto','integer');
        $this->var->add_def_cols('id_actividad','integer');
        $this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('id_cuenta_auxiliar','integer');
		$this->var->add_def_cols('desc_cta_aux','text');
		$this->var->add_def_cols('sw_rendicion','varchar');
		$this->var->add_def_cols('sw_documento','varchar');
		$this->var->add_def_cols('id_depto_tesoro','integer');
		$this->var->add_def_cols('id_depto_conta_central','integer');
		$this->var->add_def_cols('nombre_depto_conta','varchar');
		$this->var->add_def_cols('nombre_depto_tesoro','varchar');
        $this->var->add_def_cols('id_presupuesto','integer');
        $this->var->add_def_cols('desc_presupuesto','text');
       //agregado en fecha 02 feb 2011
        $this->var->add_def_cols('id_partida_sueldos','integer');
        $this->var->add_def_cols('id_cuenta_sueldos','integer');
        $this->var->add_def_cols('id_auxiliar_sueldos','integer');
        $this->var->add_def_cols('id_cuenta_auxiliar_sueldos','integer');
        $this->var->add_def_cols('cuenta_aux_sueldo','text');
        $this->var->add_def_cols('partida_sueldo','text');
       	$this->var->add_def_cols('id_sucursal','integer');
       	$this->var->add_def_cols('nombre','varchar');
        
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDepartamento
	 * Propósito:				Contar los registros de tpm_depto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-01-23 10:58:13
	 */
	function ContarDepartamentoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_conta_sel';
		$this->codigo_procedimiento = "'PM_DEPCON_COUNT'";

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
	 * Nombre de la función:	InsertarDepartamentoContabilidad
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-17 8:58:13
	 */
	function InsertarDepartamentoConta($id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_conta_iud';
		$this->codigo_procedimiento = "'PM_DEPCON_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_depto);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param("'$sw_central'");
		$this->var->add_param("'$sw_estado'");
		$this->var->add_param($id_cuenta_auxiliar);
		$this->var->add_param("'$sw_rendicion'");
        $this->var->add_param("'$sw_documento'");
        $this->var->add_param($id_depto_tesoro);
        $this->var->add_param($id_depto_conta_central);
        $this->var->add_param($id_partida_sueldos);
        $this->var->add_param($id_cuenta_auxiliar_sueldos);
        $this->var->add_param($id_sucursal);
         
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
       /* echo $this->query;
        exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDepartamentoConta
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-18 9:10:13
	 */
	function ModificarDepartamentoConta($id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_conta_iud';
		$this->codigo_procedimiento = "'PM_DEPCON_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto_conta);
		$this->var->add_param($id_depto);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param("'$sw_central'");
		$this->var->add_param("'$sw_estado'");
		$this->var->add_param($id_cuenta_auxiliar);
		$this->var->add_param("'$sw_rendicion'");
		$this->var->add_param("'$sw_documento'");
		$this->var->add_param($id_depto_tesoro);
        $this->var->add_param($id_depto_conta_central);
        
        // agregado en fecha 02 feb 2011
        $this->var->add_param($id_partida_sueldos);
        $this->var->add_param($id_cuenta_auxiliar_sueldos);
		$this->var->add_param($id_sucursal);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDepartamentoConta
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-18 9:19:13
	 */
	function EliminarDepartamentoConta($id_depto_conta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_conta_iud';
		$this->codigo_procedimiento = "'PM_DEPCON_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto_conta);
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

		//agregado en fecha 03 feb 2011
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
	 * Nombre de la función:	ValidarDepartamentoConta
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_depto_conta
	 * Autor:				    avq
	 * Fecha de creación:		2009-06-17 9:20:13
	 */
	function ValidarDepartamentoConta($operacion_sql,$id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal)
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
				//Validar id_depto - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_depto_conta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_conta", $id_depto_conta))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
					
			//$id_depto
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_depto");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto))
				{
					$this->salida = $valid->salida;
					return false;
				}
			//$id_epe	
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_presupuesto");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_presupuesto", $id_presupuesto))
				{
					$this->salida = $valid->salida;
					return false;
				}
			
			
			
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cuenta_auxiliar");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_auxiliar", $id_cuenta_auxiliar))
				{
					$this->salida = $valid->salida;
					return false;
				}
			

			//Validar sw_central
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_central");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "sw_central", $sw_central))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar sw_estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_estado");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "sw_estado", $sw_estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//return true;
			//Validar sw_estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_rendicion");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "sw_rendicion", $sw_rendicion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
				//Validar sw_estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_documento");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "sw_documento", $sw_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//$id_partida_sueldos integer 
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_partida_sueldos");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_sueldos", $id_partida_sueldos))
				{ 
					$this->salida = $valid->salida;
					return false;
				}
			
			//$id_cuenta_auxiliar_sueldos integer
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cuenta_auxiliar_sueldos");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_auxiliar_sueldos", $id_cuenta_auxiliar_sueldos))
				{    
					$this->salida = $valid->salida;
					return false;
				}
			
			
			
			/*
			//$id_depto_tesoro
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_AllowBlank(true);
				$tipo_dato->set_Columna("id_depto_tesoro");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_tesoro", $id_depto_tesoro))
				{
					$this->salida = $valid->salida;
					return false;
				}
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_AllowBlank(true);
				$tipo_dato->set_Columna("id_depto_conta_central");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_conta_central", $id_depto_conta_central))
				{
					$this->salida = $valid->salida;
					return false;
				}*/
			
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_depto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto_conta");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_conta", $id_depto_conta))
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