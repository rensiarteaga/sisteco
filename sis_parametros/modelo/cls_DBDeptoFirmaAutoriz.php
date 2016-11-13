<?php
/**
 * Nombre de la clase:	cls_DBDeptoFirmaAutoriz.php
 * Prop�sito:			
 * Autor:				RCM
 * Fecha creaci�n:		02/04/2009
 */

 
class cls_DBDeptoFirmaAutoriz
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
	 * Nombre de la funci�n:	ListarDepartamentoFirmaAutoriz
	 * Prop�sito:				Desplegar los registros de tpm_depto_usuario
	 * Autor:				    RCM
	 * Fecha de creaci�n:		02/04/2009
	 */
	function ListarDeptoFirmaAutoriz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_firma_autoriz_sel';
		$this->codigo_procedimiento = "'PM_DEPFIR_SEL'";

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
		$this->var->add_def_cols('id_depto_firma_autoriz','int4');
		$this->var->add_def_cols('importe_min','numeric');
		$this->var->add_def_cols('importe_max','numeric');
		$this->var->add_def_cols('prioridad','numeric');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('id_documento','integer');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('codigo_doc','varchar');
		$this->var->add_def_cols('desc_doc','varchar');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('sw_obliga','varchar');
		$this->var->add_def_cols('desc_firma','varchar');
 
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit();
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarDepartamentoFirmaAutoriz
	 * Prop�sito:				Contar los registros de tpm_depto_usuario
	 * Autor:				    RCM
	 * Fecha de creaci�n:		02/04/2009
	 */
	function ContarDeptoFirmaAutoriz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_firma_autoriz_sel';
		$this->codigo_procedimiento = "'PM_DEPFIR_COUNT'";

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
	 * Nombre de la funci�n:	InsertarDepartamentoFirmaAutoriz
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function InsertarDeptoFirmaAutoriz($importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg, $sw_obliga,$desc_firma,$fecha_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_firma_autoriz_iud';
		$this->codigo_procedimiento = "'PM_DEPFIR_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($importe_min);
		$this->var->add_param($importe_max);
		$this->var->add_param($prioridad);
		$this->var->add_param($id_depto);
		$this->var->add_param($id_documento);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$sw_obliga'");
		$this->var->add_param("'$desc_firma'");
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarDepartamentoFirmaAutoriz
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function ModificarDeptoFirmaAutoriz($id_depto_firma_autoriz,$importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$sw_obliga,$desc_firma,$fecha_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_firma_autoriz_iud';
		$this->codigo_procedimiento = "'PM_DEPFIR_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto_firma_autoriz);
		$this->var->add_param($importe_min);
		$this->var->add_param($importe_max);
		$this->var->add_param($prioridad);
		$this->var->add_param($id_depto);
		$this->var->add_param($id_documento);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$sw_obliga'");
		$this->var->add_param("'$desc_firma'");

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo  $this->query ; exit();

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarDepartamentoFirmaAutoriz
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function EliminarDeptoFirmaAutoriz($id_depto_firma_autoriz)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpm_depto_firma_autoriz_iud';
		$this->codigo_procedimiento = "'PM_DEPFIR_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depto_firma_autoriz);
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

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ValidarDepartamentoFirmaAutoriz
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tpm_depto_usuario
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-01-23 10:58:14
	 */
	function ValidarDeptoFirmaAutoriz($operacion_sql,$id_depto_firma_autoriz,$importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$fecha_reg, $sw_obliga,$desc_firma)
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
				//Validar id_depto_usuario - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_depto_usuario");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_usuario", $id_depto_usuario))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_depto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_usuario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario", $id_usuario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar $sw_obliga - tipo varchar
			 
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_obliga");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "sw_obliga", $sw_obliga))
			{
				$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("desc_firma");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "desc_firma", $desc_firma))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_depto_usuario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto_usuario");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto_usuario", $id_depto_usuario))
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