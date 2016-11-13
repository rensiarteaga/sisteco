<?php
/**
 * Nombre de la clase:	cls_DBModificacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_modificacion
 * Autor:				(autogenerado)
 * Fecha creación:		2010-05-10 18:01:22
 */

 
class cls_DBModificacion
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
	 * Nombre de la función:	ListarModificacion
	 * Propósito:				Desplegar los registros de tpr_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:01:22
	 */
	function ListarModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_modificacion_sel';
		$this->codigo_procedimiento = "'PR_MODIFI_SEL'";

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
		$this->var->add_def_cols('id_modificacion','integer');
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('tipo_modificacion','numeric');
		$this->var->add_def_cols('justificacion','text');
		$this->var->add_def_cols('tipo_presupuesto','numeric');
		$this->var->add_def_cols('desc_tipo_pres','varchar');
		$this->var->add_def_cols('nro_modificacion','varchar');
		$this->var->add_def_cols('estado_modificacion','varchar');
		$this->var->add_def_cols('fecha_regis','text');
		$this->var->add_def_cols('fecha_conclusion','text');
		$this->var->add_def_cols('id_usuario_reg','int4');
		$this->var->add_def_cols('desc_usuario_reg','text');
		$this->var->add_def_cols('total_disminucion','numeric');
		$this->var->add_def_cols('total_incremento','numeric');
		$this->var->add_def_cols('id_gestion','int4');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit();
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarModificacion
	 * Propósito:				Contar los registros de tpr_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:01:22
	 */
	function ContarModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_modificacion_sel';
		$this->codigo_procedimiento = "'PR_MODIFI_COUNT'";

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
	 * Nombre de la función:	InsertarModificacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:01:22
	 */
	function InsertarModificacion($id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_traspaso,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_modificacion_iud';
		$this->codigo_procedimiento = "'PR_MODIFI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_parametro);
		$this->var->add_param($tipo_modificacion);
		$this->var->add_param("'$justificacion'");
		$this->var->add_param($tipo_presupuesto);
		$this->var->add_param("'$nro_modificacion'");
		$this->var->add_param("'$estado_modificacion'");
		$this->var->add_param("'$fecha_regis'");
		$this->var->add_param("'$fecha_conclusion'");
		$this->var->add_param($id_usuario_reg);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarModificacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:01:22
	 */
	function ModificarModificacion($id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_modificacion_iud';
		$this->codigo_procedimiento = "'PR_MODIFI_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_modificacion);
		$this->var->add_param($id_parametro);
		$this->var->add_param($tipo_modificacion);
		$this->var->add_param("'$justificacion'");
		$this->var->add_param($tipo_presupuesto);
		$this->var->add_param("'$nro_modificacion'");
		$this->var->add_param("'$estado_modificacion'");
		$this->var->add_param("'$fecha_regis'");
		$this->var->add_param("'$fecha_conclusion'");
		$this->var->add_param($id_usuario_reg);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		/*echo $this->query;
		exit();*/
		
		return $res;
	}
	
	function CambiarEstadoModificacion($id_modificacion,$accion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_modificacion_iud';
		
		if($accion=='enviar_autorizar'){
			$this->codigo_procedimiento = "'PR_MODIFI_ENVIAR_AUTORIZAR'";
		}
		elseif ($accion=='aprobar_modificacion'){
			$this->codigo_procedimiento = "'PR_MODIFI_APROBAR'";
		}
		elseif ($accion=='rechazar_modificacion'){
			$this->codigo_procedimiento = "'PR_MODIFI_RECHAZAR'";
		}
		elseif ($accion=='concluir_modificacion'){
			$this->codigo_procedimiento = "'PR_MODIFI_CONCLUIR'";
		}

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_modificacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	EliminarModificacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:01:22
	 */
	function EliminarModificacion($id_modificacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_modificacion_iud';
		$this->codigo_procedimiento = "'PR_MODIFI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_modificacion);
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
	 * Nombre de la función:	ValidarModificacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:01:22
	 */
	function ValidarModificacion($operacion_sql,$id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg)
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
				//Validar id_modificacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_modificacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_modificacion", $id_modificacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_parametro - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_modificacion - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_modificacion");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_modificacion", $tipo_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar justificacion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("justificacion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "justificacion", $justificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_presupuesto - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_presupuesto");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_presupuesto", $tipo_presupuesto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_modificacion - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_modificacion");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_modificacion", $nro_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar estado_modificacion - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_modificacion");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_modificacion", $estado_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar fecha_regis - tipo timestamp
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_regis");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fecha_regis", $fecha_regis))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar fecha_conclusion - tipo timestamp
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_conclusion");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fecha_conclusion", $fecha_conclusion))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar id_usuario_reg - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario_reg");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario_reg", $id_usuario_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_modificacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_modificacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_modificacion", $id_modificacion))
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