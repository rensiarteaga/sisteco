<?php
/**
 * Nombre de la clase:	cls_DBCuentaBancaria.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_cuenta_bancaria
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2008-10-16 11:07:12
 */

 
class cls_DBCuentaBancaria
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
	 * Nombre de la funci�n:	ListarCuentaBancaria
	 * Prop�sito:				Desplegar los registros de tts_cuenta_bancaria
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-16 11:07:12
	 */
	function ListarCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_bancaria_sel';
		$this->codigo_procedimiento = "'TS_CUEBAN_SEL'";

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
		$this->var->add_def_cols('id_cuenta_bancaria','int4');//id_cuenta_bancaria
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('id_institucion','int4');//id_institucion
		$this->var->add_def_cols('desc_institucion','varchar');//desc_institucion
		$this->var->add_def_cols('id_cuenta','int4');//id_cuenta
		$this->var->add_def_cols('desc_cuenta','text');//desc_cuenta
		$this->var->add_def_cols('id_auxiliar','int4');//id_auxiliar
		$this->var->add_def_cols('desc_auxiliar','text');//desc_auxiliar
		$this->var->add_def_cols('nro_cheque','int4');
		$this->var->add_def_cols('estado_cuenta','numeric');
        $this->var->add_def_cols('nro_cuenta_banco','varchar');
        $this->var->add_def_cols('id_moneda','int4');
        $this->var->add_def_cols('nombre_moneda','varchar');
        $this->var->add_def_cols('gestion','numeric');
        
        
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res;
	}	
	/**
	 * Nombre de la funci�n:	ContarCuentaBancaria
	 * Prop�sito:				Contar los registros de tts_cuenta_bancaria
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-16 11:07:12
	 */
	function ContarCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_bancaria_sel';
		$this->codigo_procedimiento = "'TS_CUEBAN_COUNT'";

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
	 * Nombre de la funci�n:	InsertarCuentaBancaria
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tts_cuenta_bancaria
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-16 11:07:12
	 */
	function InsertarCuentaBancaria($id_cuenta_bancaria,$id_institucion,$id_cuenta,$id_auxiliar,$nro_cheque,$estado_cuenta,$nro_cuenta_banco,$id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_bancaria_iud';
		$this->codigo_procedimiento = "'TS_CUEBAN_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param($nro_cheque);
		$this->var->add_param($estado_cuenta);
		$this->var->add_param("'$nro_cuenta_banco'");
		$this->var->add_param($id_parametro);
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
       /* echo $this->query;
	    exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarCuentaBancaria
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_cuenta_bancaria
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-16 11:07:12
	 */
	function ModificarCuentaBancaria($id_cuenta_bancaria,$id_institucion,$id_cuenta,$id_auxiliar,$nro_cheque,$estado_cuenta,$nro_cuenta_banco,$id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_bancaria_iud';
		$this->codigo_procedimiento = "'TS_CUEBAN_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param($nro_cheque);
		$this->var->add_param($estado_cuenta);
		$this->var->add_param("'$nro_cuenta_banco'");
		$this->var->add_param($id_parametro);
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarCuentaBancaria
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tts_cuenta_bancaria
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-16 11:07:12
	 */
	function EliminarCuentaBancaria($id_cuenta_bancaria)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_cuenta_bancaria_iud';
		$this->codigo_procedimiento = "'TS_CUEBAN_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cuenta_bancaria);
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
	 * Nombre de la funci�n:	ValidarCuentaBancaria
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tts_cuenta_bancaria
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-10-16 11:07:12
	 */
	function ValidarCuentaBancaria($operacion_sql,$id_cuenta_bancaria,$id_institucion,$id_cuenta,$id_auxiliar,$nro_cheque,$estado_cuenta,$nro_cuenta_banco,$id_parametro)
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
				//Validar id_cuenta_bancaria - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cuenta_bancaria");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_bancaria", $id_cuenta_bancaria))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_institucion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion", $id_institucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar  - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
			{	$this->salida = $valid->salida;
				return false;
			}
			
			//Validar  - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_auxiliar");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_auxiliar", $id_auxiliar))
			{	$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_cheque - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_cheque");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_cheque", $nro_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_cuenta - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_cuenta");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_cuenta", $estado_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_cuenta_banco");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_cuenta_banco", $nro_cuenta_banco))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar  - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
			{	$this->salida = $valid->salida;
				return false;
			}

			
			//Validaci�n exitosa
			return true;
				
		}
		
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cuenta_bancaria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_bancaria");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_bancaria", $id_cuenta_bancaria))
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