<?php
/**
 * Nombre de la clase:	cls_DBUbicacion
 * Proposito:			Permite ejecutar toda la funcionalidad de la tabla taf_ubicacion
 * Autor:				unknow
 * Fecha creacion:		29/07/2013
 */
class cls_DBUbicacion
{
	//Variable que contiene la salida de la ejecuciï¿½n de la funcion
	
	var $salida;

	//Variable que contedra la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecucion de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la funcion a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBUnidadConstructiva";

	//Matriz de parametros de validacion de todas las columnas
	var $matriz_validacion = array(); 

	//Bandera que indica si los datos se decodificaron o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la funciï¿½n:	ListarUbicacionFisica
	 * Proposito:				Desplegar los registros de taf_ubicacion en funcionn de los parametros del filtro
	 * Autor:					unknow
	 * Fecha de creacion:		
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */
	
	/***************************************************************************************************/
	function ListarUbicacionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_ubicacion_sel';
		$this->codigo_procedimiento = "'AF_UBIC_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecucion de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parametros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga la definicion de columnas con sus tipos de datos 
		$this->var->add_def_cols('id_ubicacion','integer');
		$this->var->add_def_cols('id_lugar','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('ubicacion','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('desc_lugar','text');
		
		//Ejecuta la funcion de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funcion y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llama la funcion de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	/**
	 * Nombre de la funcion:	CountUnidadConstructiva
	 * Proposito:				Contar los registros de taf_ubicacion			 
	 * Autor:					unknow
	 * Fecha de creacion:		05/07/2013
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */
	
	function ContarListaUbicacionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_ubicacion_sel';
		$this->codigo_procedimiento = "'AF_UBIC_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parametros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga la definicion de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funcion de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funcion
		$this->salida = $this->var->salida;

		//Si la ejecucion fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llama a la funcion de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecucion
		return $res;
	}
	/**
	 * Nombre de la funcion:	CrearUbicacion
	 * Proposito:				anadir registro a la tabla taf_ubicacion			 
	 * Autor:					unknow
	 * Fecha de creacion:		05/08/2013
	 *
	 * @param unknown_type $id_ubicacion
	 * @param unknown_type $codigo
	 * @param unknown_type $estado
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_lugar
	 * @param unknown_type $ubicacion
	 * @return unknown
	 */
	function CrearUbicacion($id_ubicacion,$codigo,$estado,$fecha_reg,$id_lugar, $ubicacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_ubicacion_iud';
		$this->codigo_procedimiento = "'AF_UBIC_INS'";

		//Instancia la clase midlle para la ejecucion de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parametros especificos(no incluyen los parametros fijos)
		$this->var->add_param("NULL");//af_id_ubicacion
		$this->var->add_param("$id_lugar");//af_id_lugar
		$this->var->add_param("'$codigo'");//af_codigo
		$this->var->add_param("'$ubicacion'");//af_ubicacion
		$this->var->add_param("NULL");//af_fk_id_ubicacion
		$this->var->add_param("'$estado'");//af_estado
		$this->var->add_param("'$fecha_reg'");//af_fecha_reg
		
		
		//Ejecuta la funcion
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funcion y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llama a la funcion de postgres
		$this->query = $this->var->query;

		return $res;
	}

	
	/**
	 * Nombre de la funcion:	EliminarUbicacion
	 * Proposito:				Permite ejecutar la funcion de eliminacion de la tabla taf_ubicacion de la base de datos
	 * con los parametros requeridos
	 * Autor:					unknow
	 * Fecha de creacion:		05/08/2013
	 *
	 * @param unknown_type $id_ubicacion
	 * @return unknown
	 */
	function EliminarUbicacion($id_ubicacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_ubicacion_iud';
		$this->codigo_procedimiento = "'AF_UBIC_DEL'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funcion de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parametros especificos (no incluyen los parametros fijos)
		$this->var->add_param("$id_ubicacion");//af_id_ubicacion
		$this->var->add_param("NULL");//af_id_lugar
		$this->var->add_param("NULL");//af_codigo
		$this->var->add_param("NULL");//af_ubicacion
		$this->var->add_param("NULL");//af_fk_id_ubicacion
		$this->var->add_param("NULL");//af_estado
		$this->var->add_param("NULL");//af_fecha_reg
		
		//Ejecuta la funcin
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funcion y retorna el resultado de la ejecucion
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llama a la funcion de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la funcion:	$id_ubicacion
	 * Proposito:				Permite ejecutar la funcion de modificacion de la tabla taf_ubicacion de la base de datos
	 * con los parametros requeridos
	 * Autor:					unknow
	 * Fecha de creacion:		05/08/2013
	 *
	 * @param unknown_type $id_unidad_constructiva
	 * @param unknown_type $descripcion
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @return unknown
	 */
	function ModificarUbicacion($id_ubicacion,$codigo,$estado,$fecha_reg,$id_lugar, $ubicacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_ubicacion_iud';
		$this->codigo_procedimiento = "'AF_UBIC_UPD'";

		//Instancia la clase midlle para la ejecuciion de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		$this->var->add_param("$id_ubicacion");//af_id_ubicacion
		$this->var->add_param("$id_lugar");//af_id_lugar
		$this->var->add_param("'$codigo'");//af_codigo
		$this->var->add_param("'$ubicacion'");//af_ubicacion
		$this->var->add_param("NULL");//af_fk_id_ubicacion
		$this->var->add_param("'$estado'");//af_estado
		$this->var->add_param("'$fecha_reg'");//af_fecha_reg
		

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la funcion:	ValidarUnidadConstructiva
	 * Proposito:				Realiza una validacion de datos del lado del servidor (sin consultar a BD)
	 * Autor:					Unknow
	 * Fecha creaciï¿½n:		29/07/2013
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_ubicacion
	 * @param unknown_type $codigo
	 * @param unknown_type $estado
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $id_lugar
	 * @param unknown_type $ubicacion
	 * @return unknown
	 */

	
	function ValidarUbicacion($operacion_sql,$id_ubicacion,$codigo,$estado,$fecha_reg,$id_lugar, $ubicacion)
	{
		///operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)

		$this->salida = "";
		$valid = new cls_validacion_serv();
		$tipo_dato = new cls_define_tipo_dato();
		
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_Columna("codigo");
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_Columna("estado");
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(18);
			$tipo_dato->set_Columna("fecha_reg");
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg",$fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_Columna("id_lugar");
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_lugar",$id_lugar))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_Columna("ubicacion");
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "ubicacion",$ubicacion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			return true;
		}
		

	}

	
		
}?>
