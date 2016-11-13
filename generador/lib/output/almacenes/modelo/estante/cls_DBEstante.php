<?php
/**
 * Nombre de la clase:	cls_DBEstante.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_estante
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-11 16:17:36
 */

class cls_DBEstante
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
	 * Nombre de la función:	ListarEstante
	 * Propósito:				Desplegar los registros de tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:36
	 */
	function ListarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_estante_sel';
		$this->codigo_procedimiento = "'AL_ESTANT_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_estante','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('nivel_max','int4');
		$this->var->add_def_cols('via_fil','int4');
		$this->var->add_def_cols('via_col','int4');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_almacen_sector','int4');
		$this->var->add_def_cols('desc_almacen_sector','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarEstante
	 * Propósito:				Contar los registros de tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:36
	 */
	function ContarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_estante_sel';
		$this->codigo_procedimiento = "'AL_ESTANT_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		
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
	 * Nombre de la función:	InsertarEstante
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:36
	 */
	function InsertarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_estante_iud';
		$this->codigo_procedimiento = "'AL_ESTANT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($nivel_max);
		$this->var->add_param($via_fil);
		$this->var->add_param($via_col);
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_almacen_sector);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarEstante
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:36
	 */
	function ModificarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_estante_iud';
		$this->codigo_procedimiento = "'AL_ESTANT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_estante);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($nivel_max);
		$this->var->add_param($via_fil);
		$this->var->add_param($via_col);
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_almacen_sector);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarEstante
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:36
	 */
	function EliminarEstante($id_estante)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_estante_iud';
		$this->codigo_procedimiento = "'AL_ESTANT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_estante);
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
	 * Nombre de la función:	ValidarEstante
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_estante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:36
	 */
	function ValidarEstante($operacion_sql,$id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector)
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
				//Validar id_estante - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_estante");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estante", $id_estante))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nivel_max - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nivel_max");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nivel_max", $nivel_max))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar via_fil - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("via_fil");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "via_fil", $via_fil))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar via_col - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("via_col");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "via_col", $via_col))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado_registro))
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

			//Validar id_almacen_sector - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_sector");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_sector", $id_almacen_sector))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado_registro
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado_registro,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_registro': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarEstante";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_estante - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_estante");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estante", $id_estante))
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