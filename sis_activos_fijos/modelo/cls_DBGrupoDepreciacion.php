<?php
/**
 * Nombre de la clase:	cls_DBGrupoDepreciacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla taf_taf_grupo_depreciacion
 * Autor:				(autogenerado)
 * Fecha creación:		2010-07-20 14:54:38
 */

 
class cls_DBGrupoDepreciacion
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
	 * Nombre de la función:	ListarDepreciacion2
	 * Propósito:				Desplegar los registros de taf_grupo_depreciacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-07-20 14:54:38
	 */
	function ListarDepreciacion2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_grupo_depreciacion_sel';
		$this->codigo_procedimiento = "'AF_DEPREC2_SEL'";

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
		$this->var->add_def_cols('id_grupo_depreciacion','int4');
		$this->var->add_def_cols('ano_fin','numeric');
		$this->var->add_def_cols('mes_fin','numeric');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_usuario_reg','int4');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_usuario_reg2','int4');
		$this->var->add_def_cols('desc_usuario2','text');
		$this->var->add_def_cols('proyecto','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDepreciacion2
	 * Propósito:				Contar los registros de taf_grupo_depreciacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-07-20 14:54:38
	 */
	function ContarDepreciacion2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_grupo_depreciacion_sel';
		$this->codigo_procedimiento = "'AF_DEPREC2_COUNT'";

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
	 * Nombre de la función:	InsertarDepreciacion2
	 * Propósito:				Permite ejecutar la función de inserción de la tabla taf_grupo_depreciacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-07-20 14:54:38
	 */
	function InsertarDepreciacion2($id_grupo_depreciacion,$ano_fin,$mes_fin,$id_depto,$estado,$id_usuario_reg,$fecha_reg,$id_usuario_reg2,$proyecto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_grupo_depreciacion_iud';
		$this->codigo_procedimiento = "'AF_DEPREC2_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($ano_fin);
		$this->var->add_param($mes_fin);
		$this->var->add_param($id_depto);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_usuario_reg);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_usuario_reg2);
		$this->var->add_param("NULL");//codigo_temp para depreciación
		$this->var->add_param("NULL");//fecha_fin para depreciación
		$this->var->add_param("NULL");
		$this->var->add_param("'$proyecto'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDepreciacion2
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_grupo_depreciacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-07-20 14:54:38
	 */
	function ModificarDepreciacion2($id_grupo_depreciacion,$ano_fin,$mes_fin,$id_depto,$estado,$id_usuario_reg,$fecha_reg,$id_usuario_reg2,$fecha_fin,$codigo_temp,$proyecto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_grupo_depreciacion_iud';
		/*echo $estado;
		exit();*/
		if($estado=='depreciado')
			$this->codigo_procedimiento = "'AF_DEP2DEPRE_UPD'";
		elseif ($estado=='pendiente')
			$this->codigo_procedimiento = "'AF_PRODEPRE_UPD'";
		elseif ($estado=='contabilizado')
			$this->codigo_procedimiento = "'AF_FINDEPRE_UPD'";
		else 
			$this->codigo_procedimiento = "'AF_DEPREC2_UPD'";
				
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_grupo_depreciacion);
		$this->var->add_param($ano_fin);
		$this->var->add_param($mes_fin);
		$this->var->add_param($id_depto);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_usuario_reg);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_usuario_reg2);
		$this->var->add_param("'$codigo_temp'");//codigo_temp para depreciación
		$this->var->add_param("'$fecha_fin'");//fecha_fin para depreciación
		$this->var->add_param("NULL");
		$this->var->add_param("'$proyecto'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo $this->query;exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDepreciacion2
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_grupo_depreciacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-07-20 14:54:38
	 */
	function EliminarDepreciacion2($id_grupo_depreciacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_grupo_depreciacion_iud';
		$this->codigo_procedimiento = "'AF_DEPREC2_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_grupo_depreciacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//codigo_temp para depreciación
		$this->var->add_param("NULL");//fecha_fin para depreciación
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
	 * Nombre de la función:	ValidarDepreciacion2
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla taf_grupo_depreciacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-07-20 14:54:38
	 */
	function ValidarDepreciacion2($operacion_sql,$id_grupo_depreciacion,$ano_fin,$mes_fin,$id_depto,$estado,$id_usuario_reg,$fecha_reg,$id_usuario_reg2)
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
				//Validar id_grupo_depreciacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_grupo_depreciacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo_depreciacion", $id_grupo_depreciacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar ano_fin - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("ano_fin");
			$tipo_dato->set_MaxLength(262144);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "ano_fin", $ano_fin))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mes_fin - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mes_fin");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "mes_fin", $mes_fin))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_depto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_usuario_reg - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario_reg");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario_reg", $id_usuario_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			

			//Validar id_usuario_reg2 - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario_reg2");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario_reg2", $id_usuario_reg2))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_grupo_depreciacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_grupo_depreciacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_grupo_depreciacion", $id_grupo_depreciacion))
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
