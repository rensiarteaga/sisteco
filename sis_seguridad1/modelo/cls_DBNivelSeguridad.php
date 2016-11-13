<?php
/*
* Nombre de archivo:	    cls_DBTipoFormulario.php
* Propósito:				
* Fecha de Creación:		2010-12-20
* Autor:					Marcos A. Flores Valda
*/
class cls_DBNivelSeguridad
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
	 * Nombre de la función:	ListarColumna
	 * Propósito:				Desplegar los registros de tkp_columna
	 * Autor:				    Boris Claros Olivera
	 * Fecha de creación:		2010-04-21 10:28:39
	 */
	function ListarNivelSeguridad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_nivel_seguridad_sel';
		$this->codigo_procedimiento = "'SG_NSEG_SEL'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_nivel_seguridad','INTEGER');
		$this->var->add_def_cols('codigo','VARCHAR');
		$this->var->add_def_cols('nombre_nivel','VARCHAR');
		$this->var->add_def_cols('prioridad','INTEGER');
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarColumna
	 * Propósito:				Contar los registros de tkp_columna
	 * Autor:				    Boris Claros Olivera
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ContarNivelSeguridad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_nivel_seguridad_sel';
		$this->codigo_procedimiento = "'SG_NSEG_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('TotalCount','bigint');

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
	 * Nombre de la función:	InsertarColumna
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function InsertarNivelSeguridad($codigo,$nombre_nivel,$prioridad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_nivel_seguridad_iud';
		$this->codigo_procedimiento = "'SG_NSEG_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre_nivel'");
		$this->var->add_param($prioridad);
		
		
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
	 * Nombre de la función:	ModificarColumna
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ModificarNivelSeguridad($id_nivel_seguridad,$codigo,$nombre_nivel,$prioridad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_nivel_seguridad_iud';
		$this->codigo_procedimiento = "'SG_NSEG_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_nivel_seguridad);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre_nivel'");
		$this->var->add_param($prioridad);
				
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarColumna
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function EliminarNivelSeguridad($id_nivel_seguridad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_nivel_seguridad_iud';
		$this->codigo_procedimiento = "'SG_NSEG_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_nivel_seguridad);
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
	 * Nombre de la función:	ValidarColumna
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_columna
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-19 10:28:39
	 */
	function ValidarNivelSeguridad($operacion_sql,$id_nivel_seguridad,$codigo,$nombre_nivel,$prioridad)
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
				//Validar id_columna - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_nivel_seguridad");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nivel_seguridad", $id_nivel_seguridad))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			
			
			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
				
				echo $descripcion;
					exit;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_nivel");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_nivel", $nombre_nivel))
			{
				$this->salida = $valid->salida;
				return false;
				
				echo $nombre;
					exit;
			}
						
			//Validar prioridad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("prioridad");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "prioridad", $prioridad))
			{
				$this->salida = $valid->salida;
				return false;
				
				echo $id_subsistema;
				exit;		
			}

			

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_columna - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_nivel_seguridad");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nivel_seguridad", $id_nivel_seguridad))
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