<?php
/**
 * Nombre de la clase:	cls_DBSalida.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_salida
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-25 15:07:58
 */

class cls_DBCierreAlmacen
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
	 * Nombre de la función:	Cierre Mensual Almacen
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function CierreAlmacenMensual($id_almacen,$fecha_cierre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_cierre_almacen_iud';
		$this->codigo_procedimiento = "'AL_CIEALM_MEN'";
      	//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_almacen");
		$this->var->add_param("'$fecha_cierre'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	function CierreAlmacenGestion($id_almacen,$fecha_cierre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_cierre_almacen_iud';
		$this->codigo_procedimiento = "'AL_CIEALM_GES'";
      	//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_almacen");
		$this->var->add_param("'$fecha_cierre'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
function CierreAlmacenDefinitivo($id_almacen,$fecha_cierre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_cierre_almacen_iud';
		$this->codigo_procedimiento = "'AL_CIEALM_DEF'";
      	//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_almacen");
		$this->var->add_param("'$fecha_cierre'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
}?>