<?php
/**
 * Nombre de la clase:	cls_DBInstitucion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_institucion
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-06 21:04:27
 */

class cls_DBInstitucion
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
	 * Nombre de la función:	ListarInstitucion
	 * Propósito:				Desplegar los registros de tpm_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:04:27
	 */
	function ListarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_institucion_sel';
		$this->codigo_procedimiento = "'PM_INSTIT_SEL'";

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
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('doc_id','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('casilla','varchar');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('celular1','varchar');
		$this->var->add_def_cols('celular2','varchar');
		$this->var->add_def_cols('fax','varchar');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('email2','varchar');
		$this->var->add_def_cols('pag_web','varchar');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');
		$this->var->add_def_cols('estado_institucion','varchar');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('id_tipo_doc_institucion','int4');
		$this->var->add_def_cols('desc_tipo_doc_institucion','varchar');
		$this->var->add_def_cols('codigo','varchar');

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
	 * Nombre de la función:	ContarInstitucion
	 * Propósito:				Contar los registros de tpm_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:04:27
	 */
	function ContarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_institucion_sel';
		$this->codigo_procedimiento = "'PM_INSTIT_COUNT'";

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
	 * Nombre de la función:	InsertarInstitucion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:04:27
	 */
	function InsertarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion,$id_tipo_doc_institucion,$codigo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_institucion_iud';
		$this->codigo_procedimiento = "'PM_INSTIT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$doc_id'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$casilla'");
		$this->var->add_param("'$telefono1'");
		$this->var->add_param("'$telefono2'");
		$this->var->add_param("'$celular1'");
		$this->var->add_param("'$celular2'");
		$this->var->add_param("'$fax'");
		$this->var->add_param("'$email1'");
		$this->var->add_param("'$email2'");
		$this->var->add_param("'$pag_web'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$estado_institucion'");
		$this->var->add_param($id_persona);
		$this->var->add_param("'$direccion'");
		$this->var->add_param($id_tipo_doc_institucion);
		$this->var->add_param("'$codigo'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarInstitucion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:04:27
	 */
	function ModificarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion,$id_tipo_doc_institucion,$codigo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_institucion_iud';
		$this->codigo_procedimiento = "'PM_INSTIT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_institucion);
		$this->var->add_param("'$doc_id'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$casilla'");
		$this->var->add_param("'$telefono1'");
		$this->var->add_param("'$telefono2'");
		$this->var->add_param("'$celular1'");
		$this->var->add_param("'$celular2'");
		$this->var->add_param("'$fax'");
		$this->var->add_param("'$email1'");
		$this->var->add_param("'$email2'");
		$this->var->add_param("'$pag_web'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$estado_institucion'");
		$this->var->add_param($id_persona);
		$this->var->add_param("'$direccion'");
		$this->var->add_param($id_tipo_doc_institucion);
		$this->var->add_param("'$codigo'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarInstitucion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:04:27
	 */
	function EliminarInstitucion($id_institucion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_institucion_iud';
		$this->codigo_procedimiento = "'PM_INSTIT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_institucion);
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

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarInstitucion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_institucion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 21:04:27
	 */
	function ValidarInstitucion($operacion_sql,$id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion,$id_tipo_doc_institucion)
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
				//Validar id_institucion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_institucion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion", $id_institucion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar doc_id - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("doc_id");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "doc_id", $doc_id))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar casilla - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("casilla");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "casilla", $casilla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono1");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono1", $telefono1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono2");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono2", $telefono2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular1");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular1", $celular1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar celular2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("celular2");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "celular2", $celular2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fax - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fax");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fax", $fax))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar email1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email1");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoEmail(), "email1", $email1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar email2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("email2");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoEmail(), "email2", $email2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar pag_web - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("pag_web");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "pag_web", $pag_web))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_registro", $fecha_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_registro - tipo time
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_registro");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_registro", $hora_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar fecha_ultima_modificacion - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ultima_modificacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ultima_modificacion", $fecha_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_ultima_modificacion - tipo time
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_ultima_modificacion");
			$tipo_dato->set_MaxLength(8);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_ultima_modificacion", $hora_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar estado_institucion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_institucion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_institucion", $estado_institucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_persona - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_persona");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_persona", $id_persona))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar direccion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("direccion");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "direccion", $direccion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_doc_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_doc_institucion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_doc_institucion", $id_tipo_doc_institucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado_institucion
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado_institucion,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_institucion': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarInstitucion";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_institucion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion", $id_institucion))
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