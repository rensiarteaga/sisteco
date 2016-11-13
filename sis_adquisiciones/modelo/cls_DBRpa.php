<?php
/**
 * Nombre de la clase:	cls_DBRpa.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_rpa
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-12 17:40:12
 */

 
class cls_DBRpa
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
	 * Nombre de la función:	ListarRpa
	 * Propósito:				Desplegar los registros de tad_rpa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 17:40:12
	 */
	function ListarRpa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{    
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rpa_sel';
		$this->codigo_procedimiento = "'AD_RESCON_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
        /*echo $this->var->sortcol;
        exit;*/
		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_rpa','int4');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_empleado_frppa','int4');
		$this->var->add_def_cols('desc_empleado_tpm_frppa','text');
		$this->var->add_def_cols('id_categoria_adq','int4');
		$this->var->add_def_cols('desc_categoria_adq','varchar');
		$this->var->add_def_cols('desc_frppa','text');
		$this->var->add_def_cols('id_frppa','int');
		$this->var->add_def_cols('desc_financiador','varchar');
		$this->var->add_def_cols('id_regional','int');
		$this->var->add_def_cols('id_programa','int');
		$this->var->add_def_cols('id_proyecto','int');
		$this->var->add_def_cols('id_actividad','int');
		$this->var->add_def_cols('id_financiador','int');
		$this->var->add_def_cols('desc_regional','varchar');
		$this->var->add_def_cols('desc_programa','varchar');
		$this->var->add_def_cols('desc_proyecto','varchar');
		$this->var->add_def_cols('desc_actividad','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRpa
	 * Propósito:				Contar los registros de tad_rpa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 17:40:12
	 */
	function ContarRpa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rpa_sel';
		$this->codigo_procedimiento = "'AD_RESCON_COUNT'";

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
	 * Nombre de la función:	InsertarRpa
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_rpa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 17:40:12
	 */
	function InsertarRpa($id_rpa,$fecha_reg,$estado,$id_empleado_frppa,$id_categoria_adq)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rpa_iud';
		$this->codigo_procedimiento = "'AD_RESCON_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_empleado_frppa);
		$this->var->add_param($id_categoria_adq);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRpa
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_rpa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 17:40:12
	 */
	function ModificarRpa($id_rpa,$fecha_reg,$estado,$id_empleado_frppa,$id_categoria_adq)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rpa_iud';
		$this->codigo_procedimiento = "'AD_RESCON_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_rpa);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_empleado_frppa);
		$this->var->add_param($id_categoria_adq);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRpa
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_rpa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 17:40:12
	 */
	function EliminarRpa($id_rpa)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rpa_iud';
		$this->codigo_procedimiento = "'AD_RESCON_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_rpa);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarRpa
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_rpa
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 17:40:12
	 */
	function ValidarRpa($operacion_sql,$id_rpa,$fecha_reg,$estado,$id_empleado_frppa,$id_categoria_adq)
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
				//Validar id_rpa - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_rpa");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_rpa", $id_rpa))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empleado_frppa - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado_frppa");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_frppa", $id_empleado_frppa))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_categoria_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria_adq");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_adq", $id_categoria_adq))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarRpa";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_rpa - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_rpa");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_rpa", $id_rpa))
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