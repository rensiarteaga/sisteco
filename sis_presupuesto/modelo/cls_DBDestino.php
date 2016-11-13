<?php
/**
 * Nombre de la clase:	cls_DBDestino.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_destino
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-04 08:54:28
 */

 
class cls_DBDestino
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
	 * Nombre de la función:	ListarDestino
	 * Propósito:				Desplegar los registros de tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function ListarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_destino_sel';
		$this->codigo_procedimiento = "'PR_DESTIN_SEL'";

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
		$this->var->add_param($id_moneda);//$id_moneda

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_destino','integer');
		$this->var->add_def_cols('importe_pasaje','numeric');
		$this->var->add_def_cols('importe_hotel','numeric');
		$this->var->add_def_cols('importe_viaticos','numeric');
		$this->var->add_def_cols('id_categoria','integer');
		$this->var->add_def_cols('desc_categoria','varchar');
		$this->var->add_def_cols('id_lugar','integer');
		$this->var->add_def_cols('desc_lugar','varchar');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('tipo_destino','numeric');
		$this->var->add_def_cols('desc_tipo','varchar');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('imp_mon_pasaje','numeric');
		$this->var->add_def_cols('imp_mon_hotel','numeric');
		$this->var->add_def_cols('imp_mon_viatico','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit();*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDestino
	 * Propósito:				Contar los registros de tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function ContarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_destino_sel';
		$this->codigo_procedimiento = "'PR_DESTIN_COUNT'";

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
		$this->var->add_param("NULL");//id_actividad

		
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
	 * Nombre de la función:	InsertarDestino
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function InsertarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda,$tipo_destino)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_destino_iud';
		$this->codigo_procedimiento = "'PR_DESTIN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($importe_pasaje);
		$this->var->add_param($importe_hotel);
		$this->var->add_param($importe_viaticos);
		$this->var->add_param($id_categoria);
		$this->var->add_param($id_lugar);
		$this->var->add_param($id_moneda);
		$this->var->add_param($tipo_destino);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDestino
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function ModificarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda,$tipo_destino)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_destino_iud';
		$this->codigo_procedimiento = "'PR_DESTIN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_destino);
		$this->var->add_param($importe_pasaje);
		$this->var->add_param($importe_hotel);
		$this->var->add_param($importe_viaticos);
		$this->var->add_param($id_categoria);
		$this->var->add_param($id_lugar);
		$this->var->add_param($id_moneda);
		$this->var->add_param($tipo_destino);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDestino
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function EliminarDestino($id_destino)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_destino_iud';
		$this->codigo_procedimiento = "'PR_DESTIN_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_destino);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL"); //tipo destino

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarDestino
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function ValidarDestino($operacion_sql,$id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda)
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
				//Validar id_destino - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_destino");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_destino", $id_destino))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar importe_pasaje - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_pasaje");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_pasaje", $importe_pasaje))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_hotel - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_hotel");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_hotel", $importe_hotel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_viaticos - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_viaticos");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_viaticos", $importe_viaticos))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_categoria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria", $id_categoria))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_lugar - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_lugar");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_lugar", $id_lugar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_destino");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_destino", $id_destino))
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