<?php
/**
 * Nombre de la Clase:	cls_DBParametroCuentaAuxiliar
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tkp_parametro_cuenta_auxiliar
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		13-10-2010
 *
 */
class cls_DBParametroCuentaAuxiliar
{
	//Variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;
	
	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecución de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la función a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBParametroCuentaAuxiliar.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los parámetro de validación de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarParametroCuentaAuxiliar
	 * Propósito:				Desplegar los registros de tkp_parametro_cuenta_auxiliar en función de los parámetros del filtro
	 * Autor:					Fernando Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 *
	 */
	function ListarParametroCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_cuenta_auxiliar_sel';
		$this->codigo_procedimiento = "'KP_PARCUAUX_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_parametro_cuenta_auxiliar','integer');
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('codigo_auxiliar','varchar');
		$this->var->add_def_cols('nombre_auxiliar','varchar');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','integer');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('id_actividad','integer');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('id_columna_tipo','integer');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('id_orden_trabajo','integer');
		$this->var->add_def_cols('desc_orden','varchar');
		$this->var->add_def_cols('motivo_orden','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('desc_presupuesto','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarParametroCuentaAuxiliar
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Fernando Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 *
	 */
	function ContarParametroCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_cuenta_auxiliar_sel';
		$this->codigo_procedimiento = "'KP_PARCUAUX_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

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
	 * Nombre de la función:	InsertarParametroCuentaAuxiliar
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_parametro_cuenta_auxiliar
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 * Descripción:             
	
	 */
	function InsertarParametroCuentaAuxiliar($id_parametro_cuenta_auxiliar,$id_cuenta,$id_auxiliar,$id_gestion,$id_presupuesto,$id_columna_tipo,$id_orden_trabajo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_cuenta_auxiliar_iud';
		$this->codigo_procedimiento = "'KP_PARCUAUX_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_columna_tipo);
		$this->var->add_param($id_orden_trabajo);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarParametroCuentaAuxiliar
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_parametro_cuenta_auxiliar
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 */
	function ModificarParametroCuentaAuxiliar($id_parametro_cuenta_auxiliar,$id_cuenta,$id_auxiliar,$id_gestion,$id_presupuesto,$id_columna_tipo,$id_orden_trabajo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_cuenta_auxiliar_iud';
		$this->codigo_procedimiento = "'KP_PARCUAUX_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro_cuenta_auxiliar);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_columna_tipo);
		$this->var->add_param($id_orden_trabajo);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarParametroCuentaAuxiliar
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_parametro_cuenta_auxiliar
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 */
	function EliminarParametroCuentaAuxiliar($id_parametro_cuenta_auxiliar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_parametro_cuenta_auxiliar_iud';
		$this->codigo_procedimiento = "'KP_PARCUAUX_DEL'";
      
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_parametro_cuenta_auxiliar);
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
	 * Nombre de la función:	ValidarParametroCuentaAuxiliar
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_parametro_cuenta_auxiliar
	 * Autor:				    Fernando Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 */
	function ValidarParametroCuentaAuxiliar($operacion_sql,$id_parametro_cuenta_auxiliar,$id_cuenta,$id_auxiliar,$id_gestion,$id_presupuesto,$id_columna_tipo,$id_orden_trabajo)
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
				//Validar id_parametro_cuenta_auxiliar - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_parametro_cuenta_auxiliar");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_cuenta_auxiliar", $id_parametro_cuenta_auxiliar))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			
				
				//Validar id_cuenta - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cuenta");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
				{
					$this->salida = $valid->salida;
					return false;
				}

			//Validar id_auxiliar - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_auxiliar");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_auxiliar", $id_auxiliar))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_gestion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_presupuesto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_presupuesto", $id_presupuesto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_columna_tipo");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_columna_tipo", $id_columna_tipo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_orden_trabajo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_orden_trabajo", $id_orden_trabajo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro_cuenta_auxiliar");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro_cuenta_auxiliar", $id_parametro_cuenta_auxiliar))
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
	
}
?>