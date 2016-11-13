<?php
/**
 * Nombre de la clase:	cls_DBCategoriaProg.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_categoria_prog
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-06 16:42:14
 */

class cls_DBCategoriaProg
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
	 * Nombre de la función:	ListarCategoriaProg
	 * Propósito:				Desplegar los registros de tpr_categoria_prog
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:42:14
	 */
	function ListarCategoriaProg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_categoria_prog_sel';
		$this->codigo_procedimiento = "'PR_CATPRO_SEL'";

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
		$this->var->add_def_cols('id_categoria_prog','integer');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('cod_programa','varchar');
		$this->var->add_def_cols('desc_programa','text');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('cod_proyecto','varchar');
		$this->var->add_def_cols('desc_proyecto','text');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('cod_actividad','varchar');
		$this->var->add_def_cols('desc_actividad','text');
		$this->var->add_def_cols('id_organismo_fin','integer');
		$this->var->add_def_cols('cod_organismo_fin','varchar');
		$this->var->add_def_cols('desc_organismo_fin','text');
		$this->var->add_def_cols('id_fuente_financiamiento','integer');
		$this->var->add_def_cols('cod_fuente_financiamiento','varchar');
		$this->var->add_def_cols('desc_fuente_financiamiento','text');
		$this->var->add_def_cols('login','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('cod_categoria_prog','text');
		$this->var->add_def_cols('descripcion_cp','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('usuario_mod','varchar');
		$this->var->add_def_cols('fecha_mod','timestamp');
		$this->var->add_def_cols('codigo_sisin','varchar');
		
		$this->var->add_def_cols('cant_presupuestos','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		 /*echo $this->query;
		 exit();*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCategoriaProg
	 * Propósito:				Contar los registros de tpr_categoria_prog
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:42:14
	 */
	function ContarCategoriaProg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_categoria_prog_sel';
		$this->codigo_procedimiento = "'PR_CATPRO_COUNT'";

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
	 * Nombre de la función:	InsertarCategoriaProg
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_categoria_prog
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:42:14
	 */
	function InsertarCategoriaProg($id_categoria_prog,$id_programa,$id_proyecto,$id_actividad,$id_organismo_fin,$id_fuente_financiamiento,$id_parametro,$descripcion,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_categoria_prog_iud';
		$this->codigo_procedimiento = "'PR_CATPRO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_programa);
		$this->var->add_param($id_proyecto);
		$this->var->add_param($id_actividad);
		$this->var->add_param($id_organismo_fin);
		$this->var->add_param($id_fuente_financiamiento);
		$this->var->add_param($id_parametro);
		$this->var->add_param("'$descripcion'");
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
	 * Nombre de la función:	ModificarCategoriaProg
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_categoria_prog
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:42:14
	 */
	function ModificarCategoriaProg($id_categoria_prog,$id_programa,$id_proyecto,$id_actividad,$id_organismo_fin,$id_fuente_financiamiento,$id_parametro,$descripcion,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_categoria_prog_iud';
		$this->codigo_procedimiento = "'PR_CATPRO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria_prog);
		$this->var->add_param($id_programa);
		$this->var->add_param($id_proyecto);
		$this->var->add_param($id_actividad);
		$this->var->add_param($id_organismo_fin);
		$this->var->add_param($id_fuente_financiamiento);
		$this->var->add_param($id_parametro);
		$this->var->add_param("'$descripcion'");
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
	 * Nombre de la función:	EliminarCategoriaProg
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_categoria_prog
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:42:14
	 */
	function EliminarCategoriaProg($id_categoria_prog)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_categoria_prog_iud';
		$this->codigo_procedimiento = "'PR_CATPRO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria_prog);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//Estado

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarCategoriaProg
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_categoria_prog
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:42:14
	 */
	function ValidarCategoriaProg($operacion_sql,$id_categoria_prog,$id_programa,$id_proyecto,$id_actividad,$id_organismo_fin,$id_fuente_financiamiento,$id_parametro)
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
				//Validar id_categoria_prog - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(100);
				$tipo_dato->set_Columna("id_categoriga_prog");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_prog", $id_categoria_prog))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_programa - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_programa");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_programa", $id_programa))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proyecto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proyecto");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proyecto", $id_proyecto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_actividad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_actividad");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_actividad", $id_actividad))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_organismo_fin - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_organismo_fin");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_organismo_fin", $id_organismo_fin))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_fuente_financiamiento - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_fuente_financiamiento");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fuente_financiamiento", $id_fuente_financiamiento))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_parametro - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_categoria_prog - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria_prog");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_prog", $id_categoria_prog))
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