<?php
/**
 * Nombre de la Clase:	cls_DBAjuste
 * Propósito:			Permite ejecutar el Proceso de Ajuste
 * Autor:				RCM
 * Fecha creación:		04/12/2008
 */
class cls_DBAjusteAct
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
	 * Nombre de la función:	Ajustar
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_auxiliar
	 * Autor:				    RCM
	 * Fecha de creación:		04/12/2008
	 */
	function Ajustar($id_periodo_subsis,$fecha_fin,$id_depto,$fecha_ini,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ct_ajuste_act_x_trans';
		$this->codigo_procedimiento = "'CT_AJUACT_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_periodo_subsis");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("$id_depto");
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("$id_moneda");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		return $res;
	}

	/**
	 * Nombre de la función:	ValidarAjustar
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_auxiliar
	 * Autor:				    RCM
	 * Fecha de creación:		04/12/2008
	 */
	function ValidarAjustar($operacion_sql,$id_periodo_subsis,$fecha_fin,$id_depto,$fecha_ini,$id_moneda)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();

		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='ajuste')
		{

			//Validar id_periodo_subsis - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_periodo_subsis");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_periodo_subsis", $id_periodo_subsis))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_hasta");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_fin", $fecha_fin))
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
