<?php
/**
 * Nombre de la clase:	cls_DBTipoCategoriaAdq.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_tipo_categoria_adq
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-12 10:18:00
 */

 
class cls_DBTipoCategoriaAdq
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
	 * Nombre de la función:	ListarTipoCategoriaAdq
	 * Propósito:				Desplegar los registros de tad_tipo_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:00
	 */
	function ListarTipoCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_categoria_adq_sel';
		$this->codigo_procedimiento = "'AD_TIPCAT_SEL'";

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
		$this->var->add_def_cols('id_tipo_categoria_adq','int4');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_categoria_adq','int4');
		$this->var->add_def_cols('desc_categoria_adq','varchar');
		$this->var->add_def_cols('estado_categoria','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('precio_min','numeric');
		$this->var->add_def_cols('precio_max','numeric');
		$this->var->add_def_cols('doc_respaldo','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarTipoCategoriaAdq
	 * Propósito:				Contar los registros de tad_tipo_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:00
	 */
	function ContarTipoCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_categoria_adq_sel';
		$this->codigo_procedimiento = "'AD_TIPCAT_COUNT'";

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
	 * Nombre de la función:	InsertarTipoCategoriaAdq
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_tipo_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:00
	 */
	function InsertarTipoCategoriaAdq($id_tipo_categoria_adq,$fecha_reg,$id_categoria_adq,$estado_categoria,$tipo,$nombre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_TIPCAT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_categoria_adq);
		$this->var->add_param("'$estado_categoria'");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$nombre'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarTipoCategoriaAdq
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_tipo_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:00
	 */
	function ModificarTipoCategoriaAdq($id_tipo_categoria_adq,$fecha_reg,$id_categoria_adq,$estado_categoria,$tipo,$nombre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_TIPCAT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_categoria_adq);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_categoria_adq);
		$this->var->add_param("'$estado_categoria'");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$nombre'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoCategoriaAdq
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_tipo_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:00
	 */
	function EliminarTipoCategoriaAdq($id_tipo_categoria_adq)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_tipo_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_TIPCAT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_tipo_categoria_adq);
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
	 * Nombre de la función:	ValidarTipoCategoriaAdq
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_tipo_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 10:18:00
	 */
	function ValidarTipoCategoriaAdq($operacion_sql,$id_tipo_categoria_adq,$fecha_reg,$id_categoria_adq,$estado_categoria,$tipo,$nombre)
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
				//Validar id_tipo_categoria_adq - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_categoria_adq");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_categoria_adq", $id_tipo_categoria_adq))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar fecha_reg - tipo date
//			$tipo_dato->_reiniciar_valor();
//			$tipo_dato->set_Columna("fecha_reg");
//			$tipo_dato->set_MaxLength(10);
//			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
//			{
//				$this->salida = $valid->salida;
//				return false;
//			}

			//Validar id_categoria_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria_adq");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_adq", $id_categoria_adq))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_categoria - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_categoria");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_categoria", $estado_categoria))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo", $tipo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado_categoria
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado_categoria,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_categoria': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarTipoCategoriaAdq";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar tipo
			$check = array ("Cotizacion","Solicitud","Proceso");
			if(!in_array($tipo,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'tipo': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarTipoCategoriaAdq";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_categoria_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_categoria_adq");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_categoria_adq", $id_tipo_categoria_adq))
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