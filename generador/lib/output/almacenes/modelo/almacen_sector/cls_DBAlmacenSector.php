<?php
/**
 * Nombre de la clase:	cls_DBAlmacenSector.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_almacen_sector
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-11 16:17:02
 */

class cls_DBAlmacenSector
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
	 * Nombre de la función:	ListarAlmacenSector
	 * Propósito:				Desplegar los registros de tal_almacen_sector
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:02
	 */
	function ListarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_sector_sel';
		$this->codigo_procedimiento = "'AL_ALMSEC_SEL'";

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
		$this->var->add_def_cols('id_almacen_sector','int4');
		$this->var->add_def_cols('superficie','numeric');
		$this->var->add_def_cols('altura','int4');
		$this->var->add_def_cols('via_fil','int4');
		$this->var->add_def_cols('via_col','int4');
		$this->var->add_def_cols('techado','varchar');
		$this->var->add_def_cols('aire_acond','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_tipo_sector','int4');
		$this->var->add_def_cols('desc_tipo_sector','varchar');
		$this->var->add_def_cols('id_almacen','int4');
		$this->var->add_def_cols('desc_almacen','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarAlmacenSector
	 * Propósito:				Contar los registros de tal_almacen_sector
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:02
	 */
	function ContarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_sector_sel';
		$this->codigo_procedimiento = "'AL_ALMSEC_COUNT'";

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
	 * Nombre de la función:	InsertarAlmacenSector
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen_sector
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:02
	 */
	function InsertarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_sector_iud';
		$this->codigo_procedimiento = "'AL_ALMSEC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($superficie);
		$this->var->add_param($altura);
		$this->var->add_param($via_fil);
		$this->var->add_param($via_col);
		$this->var->add_param("'$techado'");
		$this->var->add_param("'$aire_acond'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_tipo_sector);
		$this->var->add_param($id_almacen);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarAlmacenSector
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_almacen_sector
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:02
	 */
	function ModificarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_sector_iud';
		$this->codigo_procedimiento = "'AL_ALMSEC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_almacen_sector);
		$this->var->add_param($superficie);
		$this->var->add_param($altura);
		$this->var->add_param($via_fil);
		$this->var->add_param($via_col);
		$this->var->add_param("'$techado'");
		$this->var->add_param("'$aire_acond'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_tipo_sector);
		$this->var->add_param($id_almacen);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarAlmacenSector
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_almacen_sector
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:02
	 */
	function EliminarAlmacenSector($id_almacen_sector)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_sector_iud';
		$this->codigo_procedimiento = "'AL_ALMSEC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_almacen_sector);
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
	 * Nombre de la función:	ValidarAlmacenSector
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_almacen_sector
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 16:17:02
	 */
	function ValidarAlmacenSector($operacion_sql,$id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen)
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
				//Validar id_almacen_sector - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_almacen_sector");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_sector", $id_almacen_sector))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar superficie - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("superficie");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "superficie", $superficie))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar altura - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("altura");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "altura", $altura))
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

			//Validar techado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("techado");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "techado", $techado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar aire_acond - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("aire_acond");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "aire_acond", $aire_acond))
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

			//Validar id_tipo_sector - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_sector");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_sector", $id_tipo_sector))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar techado
			$check = array ("si","no");
			if(!in_array($techado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'techado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarAlmacenSector";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar aire_acond
			$check = array ("si","no");
			if(!in_array($aire_acond,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'aire_acond': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarAlmacenSector";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_almacen_sector - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_sector");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_sector", $id_almacen_sector))
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