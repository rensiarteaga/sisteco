<?php
/**
 * Nombre de la clase:	cls_DBOrdenTrabajo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_orden_trabajo
 * Autor:				(autogenerado)
 * Fecha creación:		2008-08-27 09:14:44
 */

 
class cls_DBOrdenTrabajo
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
	 * Nombre de la función:	ListarOrdenTrabajo
	 * Propósito:				Desplegar los registros de tct_orden_trabajo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-27 09:14:44
	 */
	function ListarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_orden_trabajo_sel';
		$this->codigo_procedimiento = "'CT_ORDTRA_SEL'";

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
		$this->var->add_def_cols('id_orden_trabajo','int4');
		$this->var->add_def_cols('desc_orden','varchar');
		$this->var->add_def_cols('motivo_orden','varchar');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_final','date');
		$this->var->add_def_cols('estado_orden','numeric');
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('fecha_activa','date');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarOrdenTrabajo
	 * Propósito:				Contar los registros de tct_orden_trabajo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-27 09:14:44
	 */
	function ContarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_orden_trabajo_sel';
		$this->codigo_procedimiento = "'CT_ORDTRA_COUNT'";

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
	 * Nombre de la función:	InsertarOrdenTrabajo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_orden_trabajo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-27 09:14:44
	 */
	function InsertarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_orden_trabajo_iud';
		$this->codigo_procedimiento = "'CT_ORDTRA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$desc_orden'");
		$this->var->add_param("'$motivo_orden'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_final'");
		$this->var->add_param($estado_orden);
		$this->var->add_param($id_usuario);
		$this->var->add_param("'$fecha_activa'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarOrdenTrabajo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_orden_trabajo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-27 09:14:44
	 */
	function ModificarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_orden_trabajo_iud';
		$this->codigo_procedimiento = "'CT_ORDTRA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_orden_trabajo);
		$this->var->add_param("'$desc_orden'");
		$this->var->add_param("'$motivo_orden'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_final'");
		$this->var->add_param($estado_orden);
		$this->var->add_param($id_usuario);
		$this->var->add_param("'$fecha_activa'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarOrdenTrabajo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_orden_trabajo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-27 09:14:44
	 */
	function EliminarOrdenTrabajo($id_orden_trabajo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_orden_trabajo_iud';
		$this->codigo_procedimiento = "'CT_ORDTRA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_orden_trabajo);
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
	 * Nombre de la función:	ValidarOrdenTrabajo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_orden_trabajo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-08-27 09:14:44
	 */
	function ValidarOrdenTrabajo($operacion_sql,$id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa)
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
				//Validar id_orden_trabajo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_orden_trabajo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_orden_trabajo", $id_orden_trabajo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar desc_orden - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("desc_orden");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "desc_orden", $desc_orden))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar motivo_orden - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("motivo_orden");
			$tipo_dato->set_MaxLength(500);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "motivo_orden", $motivo_orden))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_inicio - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_inicio");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_inicio", $fecha_inicio))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar fecha_activa - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_activa");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_activa", $fecha_activa))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_final - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_final");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_final", $fecha_final))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_orden - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_orden");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_orden", $estado_orden))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_orden_trabajo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_orden_trabajo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_orden_trabajo", $id_orden_trabajo))
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