<?php
/**
 * Nombre de la clase:	cls_DBSietCbtePartida.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsi_siet_partida
 * Autor:				A.V.Q.
 * Fecha creación:		2015-11-12
 */

 
class cls_DBSietCbtePartida
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
	 * Nombre de la función:	ListarSietPartida
	 * Propósito:				Desplegar los registros de tsi_siet_partida
	 * Autor:				    a.v.q.
	 * Fecha de creación:		2015-11-12
	 */
	function ListarSietCbtePartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_partida_sel';
		$this->codigo_procedimiento = "'PR_SIEPAR_SEL'";

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
		$this->var->add_def_cols('id_siet_cbte_partida','INTEGER');
		$this->var->add_def_cols('id_siet_cbte','bigint');
		$this->var->add_def_cols('id_partida','INTEGER');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('codigo_partida','varchar');
		$this->var->add_def_cols('id_oec','INTEGER');
		$this->var->add_def_cols('codigo_oec','varchar');
		$this->var->add_def_cols('nombre_partida','varchar');
		$this->var->add_def_cols('nombre_oec','varchar');
		$this->var->add_def_cols('id_siet_ent_ua_transf','INTEGER');
		$this->var->add_def_cols('desc_entidad','varchar');
		$this->var->add_def_cols('desc_ua','varchar');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSietPartida
	 * Propósito:				Contar los registros de tsi_siet_partida
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ContarSietCbtePartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_partida_sel';
		$this->codigo_procedimiento = "'PR_SIEPAR_COUNT'";

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
	 * Nombre de la función:	InsertarSietPartida
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsi_siet_partida
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function InsertarSietCbtePartida($id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe,$id_oec,$id_siet_ent_ua_transf)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_partida_iud';
		$this->codigo_procedimiento = "'PR_SIEPAR_INS'";
        
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param($id_partida);
		$this->var->add_param($importe);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_oec);
		$this->var->add_param($id_siet_ent_ua_transf);
      //Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	InsertarSietCbtePartidaExcel
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsi_siet_partida
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function InsertarSietCbtePartidaExcel($id_siet_cbte,$importe,$codigo_partida,$codigo_oec)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_partida_iud';
		$this->codigo_procedimiento = "'PR_SIEPAREXC_INS'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param("NULL");
		$this->var->add_param($importe);
		$this->var->add_param("'$codigo_partida'");
		$this->var->add_param("'$codigo_oec'");
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
	 * Nombre de la función:	ModificarSietPartida
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsi_siet_partida
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ModificarSietCbtePartida($id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe,$id_oec,$id_siet_ent_ua_transf)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_partida_iud';
		$this->codigo_procedimiento = "'PR_SIEPAR_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_cbte_partida);
		$this->var->add_param($id_siet_cbte);
		$this->var->add_param($id_partida);
		$this->var->add_param($importe);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_oec);
		$this->var->add_param($id_siet_ent_ua_transf);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
       /* echo $this->query;
        exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarSietPartida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsi_siet_partida
	 * Autor:				    avq
	 * Fecha de creación:		01/11/2015
	 */
	function EliminarSietCbtePartida($id_siet_cbte_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_cbte_partida_iud';
		$this->codigo_procedimiento = "'PR_SIEPAR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_cbte_partida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL"); //descripcion
		$this->var->add_param("NULL");//CODIGO PARTIDA
		$this->var->add_param("NULL");//CODIGO oec
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
	 * Nombre de la función:	ValidarSietPartida
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsi_siet_partida
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ValidarSietCbtePartida($operacion_sql,$id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe)
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
				//Validar id_cobertura - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_siet_cbte_partida");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_siet_cbte_partida", $id_siet_cbte_partida))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

		//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cobertura - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_siet_cbte_partida");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_siet_cbte_partida", $id_siet_cbte_partida))
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
