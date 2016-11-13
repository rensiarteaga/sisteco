<?php
/**
 * Nombre de la clase:	cls_DBUsuario.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_sesion
 * Autor:				Rensi ARteaga COpari
 * Fecha creación:		2010-05-07 
 */

class cls_DBSesion
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
	
	function InsertarSesion($id_sesion,$variable,$ip,$fecha_reg,$id_usuario,$estado,$hora_act,$hora_desc)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_sesion_iud';
		$this->codigo_procedimiento = "'SG_SESION_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$variable'");
		$this->var->add_param("'$ip'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$hora_act'");
		$this->var->add_param("NULL");
		

		//Ejecuta la función
		$res = $this->var->  exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		

		return $res;
	}
	
		
	
	/**
	 * Nombre de la función:	ModificarUsuario
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_usuario
	 * Autor:				    Rensi ARteaga Copari
	 * Fecha de creación:		2007-10-26 17:44:00
	 */
	function ModificarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$fecha_expiracion)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_sesion_iud';
		$this->codigo_procedimiento = "'SG_SESION_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_sesion);
		$this->var->add_param($id_sesion);
		$this->var->add_param("'$variable'");
		$this->var->add_param("'$ip'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_usuario);
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$hora_act'");
		$this->var->add_param("'$hora_desc'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		

		return $res;
	}
	

}?>