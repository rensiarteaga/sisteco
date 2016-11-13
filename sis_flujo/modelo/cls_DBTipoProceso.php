<?php
/**
 * Nombre de la clase:	cls_DBTipoProceso.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_tipo_proceso
 * Autor:				(autogenerado)
 * Fecha creación:		2010-12-22 17:04:51
 */

 
/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
* Se debe revisar el
* */
/*
 * Adición del atributo: estado
 * Autor: Ariel Ayaviri Omonte
 * Fecha: 03-02-2011
 */

class cls_DBTipoProceso
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
	 * Nombre de la función:	ListarTipoProceso
	 * Propósito:				Desplegar los registros de tfl_tipo_proceso
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2008-05-07 15:34:51
	 */
	
	function ListarTipoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_proceso_sel';
		$this->codigo_procedimiento = "'FL_TIPPRO_SEL'";

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
		$this->var->add_def_cols('id_tipo_proceso','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('id_usuario_reg','int4');
		$this->var->add_def_cols('nombre_proceso','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_nodo_inicio','int4');
		$this->var->add_def_cols('id_formulario_inicio','int4');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		
		//echo $this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoProceso
	 * Propósito:				Contar los registros de tfl_tipo_proceso
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2010-12-22 17:04:51
	 */
	function ContarTipoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_proceso_sel';
		$this->codigo_procedimiento = "'FL_TIPPRO_COUNT'";

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
	 * Nombre de la función:	InsertarTipoProceso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfl_tipo_proceso
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2010-12-22 17:04:51
	 */
	function InsertarTipoProceso($codigo,$nombre_proceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_proceso_iud';
		$this->codigo_procedimiento = "'FL_TIPPRO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//id_tipoproceso
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre_proceso'");
		$this->var->add_param("NULL");//estado
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
	 * Nombre de la función:	ModificarTipoProceso
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfl_tipo_proceso
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2010-12-22 17:04:51
	 */
	function ModificarTipoProceso($id_tipo_proceso,$codigo,$nombre_proceso,$estado,$id_nodo_inicio,$id_formulario_inicio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_proceso_iud';
		$this->codigo_procedimiento = "'FL_TIPPRO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre_proceso'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$id_nodo_inicio'");
		$this->var->add_param("'$id_formulario_inicio'");
		
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
	 * Nombre de la función:	EliminarTipoProceso	
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_tipo_proceso
	 * Autor:				    Williams Escobar
	 * Fecha de creación:		2010-12-22 17:04:51
	 */
	function EliminarTipoProceso($id_tipo_proceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_tipo_proceso_iud';
		$this->codigo_procedimiento = "'FL_TIPPRO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_proceso);
		$this->var->add_param("NULL");//codigo
		$this->var->add_param("NULL");//nombre_reg
		$this->var->add_param("NULL");//estado
		$this->var->add_param("NULL");//id_nodo_inicio
		$this->var->add_param("NULL");//id_formulario_inicio
        
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarTipoProceso
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_tipo_procesador
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-07 15:34:51
	 */
	
			  
	function ValidarTipoProceso($operacion_sql,$id_tipo_proceso,$codigo,$nombre_proceso,$estado)
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
				//Validar id_tipo_proceso - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_proceso");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_proceso", $id_tipo_proceso))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre_proceso - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_proceso");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_proceso", $nombre_proceso))
			{
				$this->salida = $valid->salida;
				return false;
			}

		    /*//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

         //Validar $codigo  - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(4);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
		//Validar $estado  - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
            //Validación de reglas de datos

			//Validar estado_reg
			/*$check = array ("Activo","Inactivo");
			if(!in_array($estado_reg,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_reg': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarTipoProc";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
*/
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_proceso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_proceso");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_proceso", $id_tipo_proceso))
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