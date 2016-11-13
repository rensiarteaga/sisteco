<?php
/**
 * Nombre de la clase:	cls_DBTipoColumna.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_tipo_columna
 * Autor:				(autogenerado)
 * Fecha creación:		2010-08-10 17:59:44
 */

 
class cls_DBTipoColumna
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
	 * Nombre de la función:	ListarColumnaTipo
	 * Propósito:				Desplegar los registros de tkp_tipo_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-10 17:59:44
	 */
	function ListarColumnaTipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_columna_sel';
		$this->codigo_procedimiento = "'KP_COLTIP_SEL'";

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
		$this->var->add_def_cols('id_columna_tipo','int4');
		$this->var->add_def_cols('id_parametro_kardex','int4');
		$this->var->add_def_cols('desc_parametro_kardex','numeric');
		$this->var->add_def_cols('id_partida','int4');
		$this->var->add_def_cols('desc_partida','text');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('valor','numeric');
		$this->var->add_def_cols('tipo_dato','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('tipo_aporte','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('cotizable','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('descuento_incremento','varchar');
		$this->var->add_def_cols('observacion','varchar');		
		$this->var->add_def_cols('formula','varchar');
		
		$this->var->add_def_cols('id_tipo_descuento_bono','int4');
		$this->var->add_def_cols('desc_tipo_descuento_bono','varchar');
		$this->var->add_def_cols('codigo','varchar');
		

		$this->var->add_def_cols('compromete','varchar');
	//	$this->var->add_def_cols('id_tipo_columna_base','integer');
		$this->var->add_def_cols('id_cuenta_pasivo','integer');
		$this->var->add_def_cols('id_auxiliar_pasivo','integer');
		//$this->var->add_def_cols('desc_tipo_columna_base','varchar');
		$this->var->add_def_cols('desc_cuenta_pasivo','text');
		$this->var->add_def_cols('desc_auxiliar_pasivo','text');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('id_tipo_obligacion','integer');
		$this->var->add_def_cols('desc_tipo_obligacion','varchar');
		$this->var->add_def_cols('movimiento_contable','varchar');
		$this->var->add_def_cols('prorratea','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarColumnaTipo
	 * Propósito:				Contar los registros de tkp_tipo_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-10 17:59:44
	 */
	function ContarColumnaTipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_columna_sel';
		$this->codigo_procedimiento = "'KP_COLTIP_COUNT'";

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
	 * Nombre de la función:	InsertarColumnaTipo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_tipo_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-10 17:59:44
	 */
	function InsertarColumnaTipo($id_columna_tipo,$id_parametro_kardex,$id_partida,$nombre,$valor,$tipo_dato,$id_moneda,$tipo_aporte,$estado_reg,$fecha_reg,$cotizable,$descripcion,$descuento_incremento,$observacion,$formula,$id_tipo_descuento_bono,$codigo,$id_cuenta_pasivo,$id_auxiliar_pasivo,$compromete,$id_tipo_obligacion,$movimiento_contable,$prorratea)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_columna_iud';
		$this->codigo_procedimiento = "'KP_COLTIP_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_parametro_kardex);
		$this->var->add_param($id_partida);
		$this->var->add_param("'$nombre'");
		$this->var->add_param($valor);
		$this->var->add_param("'$tipo_dato'");
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$tipo_aporte'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$cotizable'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$descuento_incremento'");
		$this->var->add_param("'$observacion'");
		$this->var->add_param("'$formula'");
		
		$this->var->add_param($id_tipo_descuento_bono);
		$this->var->add_param("'$codigo'");
		
		
		$this->var->add_param($id_cuenta_pasivo);
		$this->var->add_param($id_auxiliar_pasivo);
		$this->var->add_param("'$compromete'");
		$this->var->add_param($id_tipo_obligacion);
		$this->var->add_param("'$movimiento_contable'");
		$this->var->add_param("'$prorratea'");
			
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
	
	/**
	 * Nombre de la función:	ModificarColumnaTipo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_tipo_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-10 17:59:44
	 */
	function ModificarColumnaTipo($id_columna_tipo,$id_parametro_kardex,$id_partida,$nombre,$valor,$tipo_dato,$id_moneda,$tipo_aporte,$estado_reg,$fecha_reg,$cotizable,$descripcion,$descuento_incremento,$observacion,$formula,$id_tipo_descuento_bono,$codigo,$id_cuenta_pasivo,$id_auxiliar_pasivo,$compromete,$id_tipo_obligacion,$movimiento_contable,$prorratea)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_columna_iud';
		$this->codigo_procedimiento = "'KP_COLTIP_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_columna_tipo);
		$this->var->add_param($id_parametro_kardex);
		$this->var->add_param($id_partida);
		$this->var->add_param("'$nombre'");
		$this->var->add_param($valor);
		$this->var->add_param("'$tipo_dato'");
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$tipo_aporte'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$cotizable'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$descuento_incremento'");
		$this->var->add_param("'$observacion'");	
		$this->var->add_param("'$formula'");
		
		$this->var->add_param($id_tipo_descuento_bono);
		$this->var->add_param("'$codigo'");
		
		
		$this->var->add_param($id_cuenta_pasivo);
		$this->var->add_param($id_auxiliar_pasivo);
		$this->var->add_param("'$compromete'");
		$this->var->add_param($id_tipo_obligacion);
		$this->var->add_param("'$movimiento_contable'");
		$this->var->add_param("'$prorratea'");
			
		
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
	
	/**
	 * Nombre de la función:	EliminarColumnaTipo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_tipo_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-10 17:59:44
	 */
	function EliminarColumnaTipo($id_columna_tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_tipo_columna_iud';
		$this->codigo_procedimiento = "'KP_COLTIP_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_columna_tipo);
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
		$this->var->add_param("NULL"); //formula
		
		$this->var->add_param("NULL"); //id_tipo_descuento_bono
		$this->var->add_param("NULL"); //codigo
		
		
	
		$this->var->add_param("NULL"); //($id_cuenta_pasivo);
		$this->var->add_param("NULL"); //($id_auxiliar_pasivo);
		$this->var->add_param("NULL"); //("'$compromete'");
		$this->var->add_param("NULL"); //($id_tipo_columna_base);
		$this->var->add_param("NULL"); //("'$movimiento_contable'");
		$this->var->add_param("NULL"); //("'$prorratea"');
			

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarColumnaTipo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_tipo_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-10 17:59:44
	 */
	function ValidarColumnaTipo($operacion_sql,$id_columna_tipo,$id_parametro_kardex,$id_partida,$nombre,$valor,$tipo_dato2,$id_moneda,$tipo_aporte,$estado_reg,$fecha_reg,$cotizable,$descripcion,$descuento_incremento,$observacion,$formula,$movimiento_contable,$prorratea)
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
				//Validar id_columna_tipo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_columna_tipo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_columna_tipo", $id_columna_tipo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_parametro_kardex - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro_kardex");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_kardex", $id_parametro_kardex))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida", $id_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar valor - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("valor");
			$tipo_dato->set_MaxLength(1310726);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "valor", $valor))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_dato - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_dato");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_dato", $tipo_dato2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_aporte - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_aporte");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_aporte", $tipo_aporte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_reg - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar cotizable - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cotizable");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cotizable", $cotizable))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descuento_incremento - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descuento_incremento");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descuento_incremento", $descuento_incremento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observacion");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observacion", $observacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			
			//Validar formula - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("formula");
			$tipo_dato->set_MaxLength(255);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "formula", $formula))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_columna_tipo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_columna_tipo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_columna_tipo", $id_columna_tipo))
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