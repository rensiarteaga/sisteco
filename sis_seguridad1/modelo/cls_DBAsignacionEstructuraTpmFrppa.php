<?php
/**
 * Nombre de la clase:	cls_DBAsignacionEstructuraTpmFrppa.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_asignacion_estructura_tpm_frppa
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2007-10-31 11:34:04
 */

class cls_DBAsignacionEstructuraTpmFrppa
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
	 * Nombre de la funci�n:	ListarAsignacionEstructuraTpmFrppa
	 * Prop�sito:				Desplegar los registros de tsg_asignacion_estructura_tpm_frppa
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:04
	 */
	function ListarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_tpm_frppa_sel';
		$this->codigo_procedimiento = "'SG_ASESTF_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_asignacion_estructura_frppa','int4');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('id_asignacion_estructura','int4');
		$this->var->add_def_cols('desc_asignacion_estructura','varchar');
		$this->var->add_def_cols('editar','varchar');
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','int4');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('desc_financiador','varchar');
		$this->var->add_def_cols('desc_regional','varchar');
		$this->var->add_def_cols('desc_programa','varchar');
		$this->var->add_def_cols('desc_proyecto','varchar');
		$this->var->add_def_cols('desc_actividad','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
	exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarAsignacionEstructuraTpmFrppa
	 * Prop�sito:				Contar los registros de tsg_asignacion_estructura_tpm_frppa
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:04
	 */
	function ContarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_tpm_frppa_sel';
		$this->codigo_procedimiento = "'SG_ASESTF_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;

		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	InsertarAsignacionEstructuraTpmFrppa
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tsg_asignacion_estructura_tpm_frppa
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:04
	 */
	function InsertarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa,$fecha_registro,$hora_registro,$id_asignacion_estructura,$editar,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_tpm_frppa_iud';
		$this->codigo_procedimiento = "'SG_ASESTF_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param($id_asignacion_estructura);
		$this->var->add_param("'$editar'");
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarAsignacionEstructuraTpmFrppa
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tsg_asignacion_estructura_tpm_frppa
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:04
	 */
	function ModificarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa,$fecha_registro,$hora_registro,$id_asignacion_estructura,$editar,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_tpm_frppa_iud';
		$this->codigo_procedimiento = "'SG_ASESTF_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_asignacion_estructura_frppa);
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param($id_asignacion_estructura);
		$this->var->add_param("'$editar'");
		$this->var->add_param("'$id_financiador'");
		$this->var->add_param("'$id_regional'");
		$this->var->add_param("'$id_programa'");
		$this->var->add_param("'$id_proyecto'");
		$this->var->add_param("'$id_actividad'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarAsignacionEstructuraTpmFrppa
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tsg_asignacion_estructura_tpm_frppa
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:04
	 */
	function EliminarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_asignacion_estructura_tpm_frppa_iud';
		$this->codigo_procedimiento = "'SG_ASESTF_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_asignacion_estructura_frppa);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarAsignacionEstructuraTpmFrppa
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tsg_asignacion_estructura_tpm_frppa
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2007-10-31 11:34:04
	 */
	function ValidarAsignacionEstructuraTpmFrppa($operacion_sql,$id_asignacion_estructura_frppa,$fecha_registro,$hora_registro,$id_asignacion_estructura,$editar,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validaci�n por el tipo de operaci�n
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_asignacion_estructura_frppa - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_asignacion_estructura_frppa");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_asignacion_estructura_frppa", $id_asignacion_estructura_frppa))
				{
					$this->salida = $valid->salida;
					return false;
				}
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

			//Validar id_asignacion_estructura - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_asignacion_estructura");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_asignacion_estructura", $id_asignacion_estructura))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar editar - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("editar");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "editar", $editar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_financiador - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_financiador");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_financiador", $id_financiador))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_regional - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_regional");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_regional", $id_regional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_programa - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_programa");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_programa", $id_programa))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proyecto - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proyecto");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proyecto", $id_proyecto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_actividad - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_actividad");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_actividad", $id_actividad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validaci�n de reglas de datos

			//Validar editar
			$check = array ("si","no");
			if(!in_array($editar,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validaci�n en columna 'editar': El valor no est� dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarAsignacionEstructuraTpmFrppa";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_asignacion_estructura_frppa - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_asignacion_estructura_frppa");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_asignacion_estructura_frppa", $id_asignacion_estructura_frppa))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validaci�n exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
}?>