<?php
/**
 * Nombre de la clase:	cls_DBCampo.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_campo
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-29 17:10:45
 */

 
class cls_DBCampo
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
	 * Nombre de la función:	ListarCampo
	 * Propósito:				Desplegar los registros de tsg_campo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-29 17:10:45
	 */
	function ListarCampo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_campo_sel';
		$this->codigo_procedimiento = "'SG_CAMVIS_SEL'";

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
		$this->var->add_def_cols('id_campo','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('id_tabla','int4');
		$this->var->add_def_cols('nombre_metaproceso','text');
		$this->var->add_def_cols('descripcion_metaproceso','text');
		$this->var->add_def_cols('nombre_tabla','varchar');
		$this->var->add_def_cols('desc_tabla','text');
		$this->var->add_def_cols('funcion_grupo','varchar');
		$this->var->add_def_cols('label','varchar');
		$this->var->add_def_cols('width_reporte','int4');
		$this->var->add_def_cols('funcion','text');
		$this->var->add_def_cols('casting','varchar');
		$this->var->add_def_cols('filtro','varchar');
		$this->var->add_def_cols('filtro_grupo','varchar');
		$this->var->add_def_cols('formulario','varchar');
		$this->var->add_def_cols('grupo','varchar');
		$this->var->add_def_cols('dato_descriptivo','varchar');
		$this->var->add_def_cols('grid_indice','int4');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCampo
	 * Propósito:				Contar los registros de tsg_campo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-29 17:10:45
	 */
	function ContarCampo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_campo_sel';
		$this->codigo_procedimiento = "'SG_CAMVIS_COUNT'";

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
	 * Nombre de la función:	InsertarCampo
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_campo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-29 17:10:45
	 */
	function InsertarCampo($id_campo,$nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo,$grid_indice)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_campo_iud';
		$this->codigo_procedimiento = "'SG_CAMVIS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param($id_tabla);
		$this->var->add_param("'$funcion_grupo'");
		$this->var->add_param("'$label'");
		$this->var->add_param($width_reporte);
		$this->var->add_param("'$funcion'");
		$this->var->add_param("'$casting'");
		$this->var->add_param("'$filtro'");
		$this->var->add_param("'$filtro_grupo'");
		$this->var->add_param("'$formulario'");
		$this->var->add_param("'$grupo'");
		$this->var->add_param("'$dato_descriptivo'");
		$this->var->add_param("$grid_indice");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCampo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_campo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-29 17:10:45
	 */
	function ModificarCampo($id_campo,$nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo,$grid_indice)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_campo_iud';
		$this->codigo_procedimiento = "'SG_CAMVIS_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_campo);
		$this->var->add_param("'$nombre'");
		$this->var->add_param($id_tabla);
		$this->var->add_param("'$funcion_grupo'");
		$this->var->add_param("'$label'");
		$this->var->add_param($width_reporte);
		$this->var->add_param("'$funcion'");
		$this->var->add_param("'$casting'");
		$this->var->add_param("'$filtro'");
		$this->var->add_param("'$filtro_grupo'");
		$this->var->add_param("'$formulario'");
		$this->var->add_param("'$grupo'");
		$this->var->add_param("'$dato_descriptivo'");
		$this->var->add_param("$grid_indice");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCampo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_campo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-29 17:10:45
	 */
	function EliminarCampo($id_campo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_campo_iud';
		$this->codigo_procedimiento = "'SG_CAMVIS_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_campo);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
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
	 * Nombre de la función:	ValidarCampo
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_campo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-29 17:10:45
	 */
	function ValidarCampo($operacion_sql,$id_campo,$nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo)
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
				//Validar id_campo - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_campo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_campo", $id_campo))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tabla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tabla");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tabla", $id_tabla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar funcion_grupo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("funcion_grupo");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "funcion_grupo", $funcion_grupo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar label - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("label");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "label", $label))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar width_reporte - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("width_reporte");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "width_reporte", $width_reporte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar funcion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("funcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "funcion", $funcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar casting - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("casting");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "casting", $casting))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar filtro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("filtro");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "filtro", $filtro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar filtro_grupo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("filtro_grupo");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "filtro_grupo", $filtro_grupo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar formulario - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("formulario");
			$tipo_dato->set_MaxLength(5);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "formulario", $formulario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			
			//Validar grupo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("dato_descriptivo");
			$tipo_dato->set_MaxLength(5);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "dato_descriptivo", $dato_descriptivo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar formulario
			$check = array ("true","false");
			if(!in_array($formulario,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'formulario': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarCampo";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			
			//Validar grupo
			$check = array ("true","false");
			if(!in_array($dato_descriptivo,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'dato_descriptivo': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarCampo";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_campo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_campo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_campo", $id_campo))
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