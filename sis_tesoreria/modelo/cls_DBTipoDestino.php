<?php
/**
 * Nombre de la clase:	cls_DBTipoDestino.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_tipo_destino
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2009-10-27 12:25:01
 */

 
class cls_DBTipoDestino
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
	 * Nombre de la funci�n:	ListarTipoDestino
	 * Prop�sito:				Desplegar los registros de tts_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 12:25:01
	 */
	function ListarTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_tipo_destino_sel';
		$this->codigo_procedimiento = "'TS_TIPDES_SEL'";

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
		$this->var->add_def_cols('id_tipo_destino','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_usr_reg','int4');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('tipo_destino','varchar');
		$this->var->add_def_cols('estado','varchar');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ContarTipoDestino
	 * Prop�sito:				Contar los registros de tts_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 12:25:01
	 */
	function ContarTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_tipo_destino_sel';
		$this->codigo_procedimiento = "'TS_TIPDES_COUNT'";

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
	 * Nombre de la funci�n:	InsertarTipoDestino
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tts_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 12:25:01
	 */
	function InsertarTipoDestino($id_tipo_destino,$codigo,$descripcion,$id_moneda,$tipo_destino,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_tipo_destino_iud';
		$this->codigo_procedimiento = "'TS_TIPDES_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$tipo_destino'");
		$this->var->add_param("'$estado'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarTipoDestino
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tts_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 12:25:01
	 */
	function ModificarTipoDestino($id_tipo_destino,$codigo,$descripcion,$id_moneda,$tipo_destino,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_tipo_destino_iud';
		$this->codigo_procedimiento = "'TS_TIPDES_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_destino);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$tipo_destino'");
		$this->var->add_param("'$estado'");
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	EliminarTipoDestino
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tts_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 12:25:01
	 */
	function EliminarTipoDestino($id_tipo_destino)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_tipo_destino_iud';
		$this->codigo_procedimiento = "'TS_TIPDES_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_destino);
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
	 * Nombre de la funci�n:	ValidarTipoDestino
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tts_tipo_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2009-10-27 12:25:01
	 */
	function ValidarTipoDestino($operacion_sql,$id_tipo_destino,$codigo,$descripcion,$id_moneda)
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
				//Validar id_tipo_destino - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_destino");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_destino", $id_tipo_destino))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
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
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_destino");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_destino", $id_tipo_destino))
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