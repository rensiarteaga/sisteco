<?php
/**
 * Nombre de la clase:	cls_DBTareaPendiente.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_tarea_pendiente
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-30 11:27:00
 */

class cls_DBTareaPendiente
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
	 * Nombre de la función:	ListarTareaPendiente
	 * Propósito:				Desplegar los registros de tsg_tarea_pendiente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 11:27:00
	 */
	function ListarTareaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tarea_pendiente_sel';
		$this->codigo_procedimiento = "'SG_TARPEN_SEL'";

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
		$this->var->add_def_cols('id_tarea_pendiente','int4');
		$this->var->add_def_cols('id_usuario','int4');
		$this->var->add_def_cols('desc_usuario','int4');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('desc_subsistema','varchar');
		$this->var->add_def_cols('tarea','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('fecha_concluido_anulado','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('tipo','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTareaPendiente
	 * Propósito:				Contar los registros de tsg_tarea_pendiente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 11:27:00
	 */
	function ContarTareaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tarea_pendiente_sel';
		$this->codigo_procedimiento = "'SG_TARPEN_COUNT'";

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
	 * Nombre de la función:	InsertarTareaPendiente
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_tarea_pendiente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 11:27:00
	 */
	function InsertarTareaPendiente($id_tarea_pendiente,$id_usuario,$id_subsistema,$tarea,$descripcion,$codigo_procedimiento,$estado,$fecha_concluido_anulado,$fecha_reg,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tarea_pendiente_iud';
		$this->codigo_procedimiento = "'SG_TARPEN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_usuario);
		$this->var->add_param($id_subsistema);
		$this->var->add_param("'$tarea'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$fecha_concluido_anulado'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$tipo'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTareaPendiente
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_tarea_pendiente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 11:27:00
	 */
	function ModificarTareaPendiente($id_tarea_pendiente,$id_usuario,$id_subsistema,$tarea,$descripcion,$codigo_procedimiento,$estado,$fecha_concluido_anulado,$fecha_reg,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tarea_pendiente_iud';
		$this->codigo_procedimiento = "'SG_TARPEN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tarea_pendiente);
		$this->var->add_param($id_usuario);
		$this->var->add_param($id_subsistema);
		$this->var->add_param("'$tarea'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$fecha_concluido_anulado'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$tipo'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTareaPendiente
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_tarea_pendiente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 11:27:00
	 */
	function EliminarTareaPendiente($id_tarea_pendiente)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_tarea_pendiente_iud';
		$this->codigo_procedimiento = "'SG_TARPEN_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tarea_pendiente);
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
	 * Nombre de la función:	ValidarTareaPendiente
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_tarea_pendiente
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 11:27:00
	 */
	function ValidarTareaPendiente($operacion_sql,$id_tarea_pendiente,$id_usuario,$id_subsistema,$tarea,$descripcion,$codigo_procedimiento,$estado,$fecha_concluido_anulado,$fecha_reg,$tipo)
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
				//Validar id_tarea_pendiente - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tarea_pendiente");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tarea_pendiente", $id_tarea_pendiente))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_usuario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario", $id_usuario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_subsistema - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subsistema");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subsistema", $id_subsistema))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tarea - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tarea");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tarea", $tarea))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo_procedimiento - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_procedimiento");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_procedimiento", $codigo_procedimiento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			//Validar estado
			$check = array ("Pendiente","Anulada","Concluida");
			if(!in_array($estado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarTareaPendiente";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}

			//Validar fecha_concluido_anulado - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_concluido_anulado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_concluido_anulado", $fecha_concluido_anulado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar tipo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo", $tipo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tarea_pendiente - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tarea_pendiente");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tarea_pendiente", $id_tarea_pendiente))
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