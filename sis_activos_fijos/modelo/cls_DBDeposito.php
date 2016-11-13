<?php
/**
 * Nombre de la clase:	cls_DBDeposito.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla taf_deposito
 * Autor:				Williams Escobar 
 * Fecha creación:		2011-01-07 10:30:51
 */

 
/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
* Se debe revisar el
* */
class cls_DBDeposito
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
	 * Nombre de la función:	ListarDeposito
	 * Propósito:				Desplegar los registros de taf_deposito
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-01-07 10:35:51
	 */
	function ListarDeposito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_deposito_sel';
		$this->codigo_procedimiento = "'AF_DEPOSI_SEL'";

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
		$this->var->add_def_cols('id_deposito','int4');
		$this->var->add_def_cols('nombre_deposito','varchar');
		$this->var->add_def_cols('estado','varchar');		
		$this->var->add_def_cols('id_empleado_responsable','int4');		
		$this->var->add_def_cols('id_depto_af','int4');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('desc_persona','text');//parametros extras que viene desde la funcion creada en posgtres
		$this->var->add_def_cols('nombre_depto','varchar');//parametros extras que viene desde la funcion creada en posgtres
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDeposito
	 * Propósito:				Contar los registros de taf_deposito
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-01-07 10:36:51
	 */
	function ContarDeposito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_deposito_sel';
		$this->codigo_procedimiento = "'AF_DEPOSI_COUNT'";

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
	 * Nombre de la función:	InsertarDeposito
	 * Propósito:				Permite ejecutar la función de inserción de la tabla taf_deposito
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-01-07 10:37:59
	 */
	function InsertarDeposito($nombre_deposito,$id_empleado_responsable,$id_depto_af)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_deposito_iud';
		$this->codigo_procedimiento = "'AF_DEPOSI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//id_deposito
		$this->var->add_param("'$nombre_deposito'");//nombre_deposito
		$this->var->add_param($id_empleado_responsable);//id_empleado_responsable
		$this->var->add_param($id_depto_af);//id_depto_af		
		
		
        //Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
       
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDeposito
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_deposi
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-01-07 10:46:01
	 */
	function ModificarDeposito($id_deposito,$nombre_deposito,$id_empleado_responsable,$id_depto_af)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_deposito_iud';
		$this->codigo_procedimiento = "'AF_DEPOSI_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_deposito);//id_deposito
		$this->var->add_param("'$nombre_deposito'");//nombre_deposito
		$this->var->add_param($id_empleado_responsable);//id_empleado_responsable
		$this->var->add_param($id_depto_af);//id_depto_af		
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
     
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoProcesoDepto	
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_tipo_proceso_depto
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2010-12-27 16:22:51
	 */
	function EliminarDeposito($id_deposito)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_deposito_iud';
		$this->codigo_procedimiento = "'AF_DEPOSI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_deposito);
		$this->var->add_param("NULL");//id_tipo_proceso
		$this->var->add_param("NULL");//id_depto
		$this->var->add_param("NULL");//id_depto
		
        
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarDeposito
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla taf_deposito
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-01-07 10:52:52
	 */
	
			  
	function ValidarDeposito($operacion_sql,$id_deposito,$nombre_deposito,$id_empleado_responsable,$id_depto_af)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación del $id_proceso_depto tipo integer
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar $id_deposito - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_deposito");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_deposito", $id_deposito))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar $nombre_deposito - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_deposito");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_deposito",$nombre_deposito))
			{
				$this->salida = $valid->salida;
				return false;
			}

         //Validar $id_empleado_responsable  - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado_responsable");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_responsable", $id_empleado_responsable))
			{
				$this->salida = $valid->salida;
				return false;
			}
		//Validar $id_depto_af  - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto_af");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_af", $id_depto_af))
			{
				$this->salida = $valid->salida;
				return false;
			}
        return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_proceso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_deposito");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_deposito", $id_deposito))
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