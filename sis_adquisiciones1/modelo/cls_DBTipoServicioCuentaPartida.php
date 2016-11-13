<?php
/**
 * Nombre de la clase:	cls_DBTipoServicioCuentaPartida.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_tipo_servicio_cuenta_partida
 * Autor:				(autogenerado)
 * Fecha creación:		2008-12-10 09:59:07
 */

 
class cls_DBTipoServicioCuentaPartida
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
	 * Nombre de la función:	ListarTipoServicioCuentaPartida
	 * Propósito:				Desplegar los registros de tad_tipo_servicio_cuenta_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-10 09:59:07
	 */
	function ListarTipoServicioCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_cuenta_partida_sel';
		$this->codigo_procedimiento = "'AD_SECUPA_SEL'";

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
		$this->var->add_def_cols('id_tipo_servicio_cuenta_partida','int4');//0
		$this->var->add_def_cols('id_cuenta','int4');//1
		$this->var->add_def_cols('desc_cuenta','text');//2
		$this->var->add_def_cols('id_partida','int4');//3
		$this->var->add_def_cols('desc_partida','text');//4
		$this->var->add_def_cols('id_gestion','int4');//5
		$this->var->add_def_cols('denominacion_empresa','varchar');//6
		$this->var->add_def_cols('gestion_gestion','numeric');//7
		$this->var->add_def_cols('desc_gestion','text');//8
		$this->var->add_def_cols('gestion','numeric');//9
		$this->var->add_def_cols('fecha_reg','date');//10
		$this->var->add_def_cols('id_tipo_servicio','int4');//11
		$this->var->add_def_cols('desc_tipo_servicio','varchar');//12
		$this->var->add_def_cols('id_auxiliar','int4');//13
		$this->var->add_def_cols('desc_auxiliar','text');//14
		$this->var->add_def_cols('id_tipo_adq','int4');//15
		$this->var->add_def_cols('nombre','varchar');//16
		$this->var->add_def_cols('id_servicio','int4');//17
		$this->var->add_def_cols('desc_servicio','text');//18
		$this->var->add_def_cols('id_presupuesto','int4');//19
		$this->var->add_def_cols('desc_presupuesto','text');//20
		$this->var->add_def_cols('detalle_usado','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoServicioCuentaPartida
	 * Propósito:				Contar los registros de tad_tipo_servicio_cuenta_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-10 09:59:07
	 */
	function ContarTipoServicioCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_cuenta_partida_sel';
		$this->codigo_procedimiento = "'AD_SECUPA_COUNT'";

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
	 * Nombre de la función:	InsertarTipoServicioCuentaPartida
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_tipo_servicio_cuenta_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-10 09:59:07
	 */
	function InsertarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio,$id_auxiliar,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_cuenta_partida_iud';
		$this->codigo_procedimiento = "'AD_SECUPA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_partida);
		$this->var->add_param($id_gestion);
		$this->var->add_param($gestion);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_servicio);
        $this->var->add_param($id_auxiliar);
        $this->var->add_param($id_presupuesto);
        
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoServicioCuentaPartida
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_tipo_servicio_cuenta_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-10 09:59:07
	 */
	function ModificarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio,$id_auxiliar,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_cuenta_partida_iud';
		$this->codigo_procedimiento = "'AD_SECUPA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_servicio_cuenta_partida);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_partida);
		$this->var->add_param($id_gestion);
		$this->var->add_param($gestion);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_servicio);
        $this->var->add_param($id_auxiliar);
        $this->var->add_param($id_presupuesto);
        
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoServicioCuentaPartida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_tipo_servicio_cuenta_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-10 09:59:07
	 */
	function EliminarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_cuenta_partida_iud';
		$this->codigo_procedimiento = "'AD_SECUPA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_servicio_cuenta_partida);
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
	 * Nombre de la función:	ValidarTipoServicioCuentaPartida
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_tipo_servicio_cuenta_partida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-12-10 09:59:07
	 */
	function ValidarTipoServicioCuentaPartida($operacion_sql,$id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_tipo_servicio)
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
				//Validar id_servicio_cuenta_partida - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_servicio_cuenta_partida");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_servicio_cuenta_partida", $id_tipo_servicio_cuenta_partida))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida", $id_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_gestion - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_gestion");
			$tipo_dato->set_MaxLength(262144);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "id_gestion", $id_gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}

				
			//Validar fecha_reg - tipo int4
//			$tipo_dato->_reiniciar_valor();
//			$tipo_dato->set_Columna("fecha_reg");
//			$tipo_dato->set_AllowBlank(false);
//			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
//			{
//				$this->salida = $valid->salida;
//				return false;
//			}

			//Validar id_tipo_servicio - tipo 
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_servicio");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "id_tipo_servicio", $id_tipo_servicio))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_servicio_cuenta_partida - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_servicio_cuenta_partida");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_servicio_cuenta_partida", $id_tipo_servicio_cuenta_partida))
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