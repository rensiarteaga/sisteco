<?php
/**
 * Nombre de la clase:	cls_DBActualizacionValor.php
 * Propósito:			Permite ejecutar la actualizacion de valor de los items que se encuentran en kardex logico
 * Autor:				
 * Fecha creación:		2007-11-22
 */

class cls_DBActualizacionValor
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
	
	function ActualizacionValor($id_almacen, $id_almacen_logico,$fecha)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_al_actualizacion_val';
		$this->codigo_procedimiento = "'AL_ACTUAL_VAL'";
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
	

		$this->var->add_param("'$id_almacen'");
		$this->var->add_param("'$id_almacen_logico'");
		$this->var->add_param("'$fecha'");
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;


		return $res;
	}
	
	function AjusteInventario($id_ep,$id_almacen, $id_almacen_logico,$tipo_ajuste,$id_item,$cantidad,$estado_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ajuste_inventario';
		$this->codigo_procedimiento = "'AL_AJUSTE_INV'";
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
	
		$this->var->add_param("$id_ep");
		$this->var->add_param("$id_almacen");
		$this->var->add_param("$id_almacen_logico");
		$this->var->add_param("'$tipo_ajuste'");
		$this->var->add_param("$id_item");
		$this->var->add_param("$cantidad");
		$this->var->add_param("'$estado_item'");
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
}?>
