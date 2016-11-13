<?php
/**
 * Nombre de la clase:	cls_DBDocumento.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpm_tpm_documento
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-29 09:44:13
 */

 
class cls_DBDocumento
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
	 * Nombre de la función:	ListarDocumento
	 * Propósito:				Desplegar los registros de tpm_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-29 09:44:13
	 */
	function ListarDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_documento_sel';
		$this->codigo_procedimiento = "'PM_DOCUME_SEL'";

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
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('documento','varchar');
		$this->var->add_def_cols('prefijo','varchar');
		$this->var->add_def_cols('sufijo','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('desc_subsistema','varchar');
		$this->var->add_def_cols('num_firma','integer');
		//MODIFICACION 23/03/2011 aayaviri
		$this->var->add_def_cols('tipo_numeracion','varchar');// Se agrego este campo en fecha 31-12-2010 13:40
		
		$this->var->add_def_cols('id_tipo_proceso','integer');// Se agrego este campo en fecha 31-12-2010 13:40
		$this->var->add_def_cols('tipo','varchar');// Se agrego este campo en fecha 31-12-2010 13:40
		$this->var->add_def_cols('desc_tipo_proceso','text');// Se agrego este campo en fecha 31-12-2010 13:40
		//-------------------------------------
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDocumento
	 * Propósito:				Contar los registros de tpm_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-29 09:44:13
	 */
	function ContarDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_documento_sel';
		$this->codigo_procedimiento = "'PM_DOCUME_COUNT'";

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
	 * Nombre de la función:	InsertarDocumento
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpm_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-29 09:44:13
	 */
	function InsertarDocumento($id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema,$num_firma,$tipo_numeracion,$id_tipo_proceso,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_documento_iud';
		$this->codigo_procedimiento = "'PM_DOCUME_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		//$this->var->add_param($id_documento);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$documento'");
		$this->var->add_param("'$prefijo'");
		$this->var->add_param("'$sufijo'");
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_subsistema);
		$this->var->add_param($num_firma);

		// MODIFICACION 23/03/2011
		$this->var->add_param("'$tipo_numeracion'");
		
		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param("'$tipo'");
		//--------------------------
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDocumento
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpm_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-29 09:44:13
	 */
	function ModificarDocumento($id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema,$num_firma,$tipo_numeracion,$id_tipo_proceso,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_documento_iud';
		$this->codigo_procedimiento = "'PM_DOCUME_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_documento);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$documento'");
		$this->var->add_param("'$prefijo'");
		$this->var->add_param("'$sufijo'");
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_subsistema);
		$this->var->add_param($num_firma);
		
		// MODIFICACION 23/03/2011
		$this->var->add_param("'$tipo_numeracion'");//agregado el campo 31-12-2010 13:50

		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param("'$tipo'");
		//------------------

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDocumento
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpm_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-29 09:44:13
	 */
	function EliminarDocumento($id_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_documento_iud';
		$this->codigo_procedimiento = "'PM_DOCUME_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_documento);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		//MODIFICACION 23/03/2011 aayaviri
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//------------------
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarDocumento
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpm_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-29 09:44:13
	 */
	function ValidarDocumento($operacion_sql,$id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema, $num_firma)
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
				//Validar id_documento - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_documento");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_documento", $id_documento))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar documento - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("documento");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "documento", $documento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar prefijo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("prefijo");
			$tipo_dato->set_MaxLength(18);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "prefijo", $prefijo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar sufijo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sufijo");
			$tipo_dato->set_MaxLength(18);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "sufijo", $sufijo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(18);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_subsistema - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subsistema");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subsistema", $id_subsistema))
			{
				$this->salida = $valid->salida;
				return false;
			}	
			//Validar $num_firma - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("num_firma");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "num_firma", $num_firma))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_documento - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_documento");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_documento", $id_documento))
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