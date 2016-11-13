<?php
/**
 * Nombre de la clase:	cls_DBTipoProcesoDepto.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_tipo_proceso_depto
 * Autor:				Williams Escobar 
 * Fecha creación:		2010-12-27 17:04:51
 */

 
/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
* Se debe revisar el
* */
class cls_DBTransaccionValor
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
	 * Nombre de la función:	ListarTransValor
	 * Propósito:				Desplegar los registros de tct_gestion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2011-03-11 12:20:31
	 */
	function ListarTransValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_comprobante,$id_transaccion,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_valor_update_sel';
		$this->codigo_procedimiento = "'CT_TRANS_VALOR_SEL'";

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
		$this->var->add_param($id_comprobante);//id_comprobante
		$this->var->add_param($id_transaccion);//id_transaccion
		$this->var->add_param($id_moneda);//id_moneda
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_transac_valor','integer');
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
		$this->var->add_def_cols('tipo_moneda','varchar');
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('id_transaccion','integer');
		$this->var->add_def_cols('id_moneda','integer');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ContarTransValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_comprobante,$id_transaccion,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_valor_update_sel';
		$this->codigo_procedimiento = "'CT_TRANS_VALOR_COUNT'";

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
		$this->var->add_param($id_comprobante);//id_comprobante
		$this->var->add_param($id_transaccion);//id_transaccion
		$this->var->add_param($id_moneda);//id_moneda
		
		//Carga la definición de columnas con sus tipos de datos		
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	/**
	 * Nombre de la función:	ModificarTransaccionValor
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_transaccion_valor
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-03-11 10:17:51
	 */
	function ModificarTransaccionValor($id_comprobante,$id_transaccion,$id_moneda,$importe_debe,$importe_haber)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_valor_update';
		$this->codigo_procedimiento = "'CT_TRANS_VALOR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprobante);
		$this->var->add_param($id_transaccion);
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_debe);
		$this->var->add_param($importe_haber);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
      /* echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarTransaccionValor
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_transaccion_valor
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2011-03-11 10:21:51
	 */
	
			  
	function ValidarTransaccionValor($operacion_sql,$id_comprobante,$id_transaccion,$id_moneda,$importe_debe,$importe_haber)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación del id_comprobante tipo integer
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_tipo_proceso - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna($id_comprobante);

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_comprobante", $id_comprobante))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar $id_transaccion - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_transaccion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_transaccion",$id_transaccion))
			{
				$this->salida = $valid->salida;
				return false;
			}
         
         //Validar $id_moneda  - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}
		 //Validar $importe  - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_debe");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(65536);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_debe", $importe_debe))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar $valor  - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_haber");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(65536);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_haber", $importe_haber))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
        return true;
		}		
		else
		{
			return false;
		}
	}
}?>