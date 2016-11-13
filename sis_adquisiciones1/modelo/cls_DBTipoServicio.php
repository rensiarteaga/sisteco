<?php
/**
 * Nombre de la clase:	cls_DBTipoServicio.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_tipo_servicio
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-07 15:35:28
 */

 
class cls_DBTipoServicio
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
	 * Nombre de la función:	ListarTipoServicio
	 * Propósito:				Desplegar los registros de tad_tipo_servicio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:35:28
	 */
	function ListarTipoServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_sel';
		$this->codigo_procedimiento = "'AD_TIPSER_SEL'";

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
		$this->var->add_def_cols('id_tipo_servicio','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_tipo_adq','int4');
		$this->var->add_def_cols('desc_tipo_adq','text');
		$this->var->add_def_cols('codigo','varchar');
		
//		$this->var->add_def_cols('id_cuenta','int4');
//		$this->var->add_def_cols('nombre_cuenta','text');
//		$this->var->add_def_cols('id_partida','int4');
//		$this->var->add_def_cols('nombre_partida','text');
		$this->var->add_def_cols('estado','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoServicio
	 * Propósito:				Contar los registros de tad_tipo_servicio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:35:28
	 */
	function ContarTipoServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_sel';
		$this->codigo_procedimiento = "'AD_TIPSER_COUNT'";

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
	 * Nombre de la función:	InsertarTipoServicio
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_tipo_servicio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:35:28
	 */
	function InsertarTipoServicio($id_tipo_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_adq,$codigo,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_iud';
		$this->codigo_procedimiento = "'AD_TIPSER_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_tipo_adq);
        $this->var->add_param("'$codigo'");
        
        
        $this->var->add_param("'$estado'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
        
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoServicio
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_tipo_servicio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:35:28
	 */
	function ModificarTipoServicio($id_tipo_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_adq,$codigo,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_iud';
		$this->codigo_procedimiento = "'AD_TIPSER_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_servicio);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_tipo_adq);
	    $this->var->add_param("'$codigo'");
	    
        
         $this->var->add_param("'$estado'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
       
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoServicio
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_tipo_servicio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:35:28
	 */
	function EliminarTipoServicio($id_tipo_servicio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_servicio_iud';
		$this->codigo_procedimiento = "'AD_TIPSER_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_servicio);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarTipoServicio
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_tipo_servicio
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:35:28
	 */
	function ValidarTipoServicio($operacion_sql,$id_tipo_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_adq,$codigo,$estado)	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_tipo_servicio - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_servicio");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_servicio", $id_tipo_servicio))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(500);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
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

			//Validar id_tipo_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_adq");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_adq", $id_tipo_adq))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
			

			//Validar estadp - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_servicio - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_servicio");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_servicio", $id_tipo_servicio))
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