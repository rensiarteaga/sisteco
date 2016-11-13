<?php
/**
 * Nombre de la clase:	cls_DBPartidaModificacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_partida_modificacion
 * Autor:				(autogenerado)
 * Fecha creación:		2010-05-10 18:19:16
 */

 
class cls_DBPartidaModificacion
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
	 * Nombre de la función:	ListarPartidaModificacion
	 * Propósito:				Desplegar los registros de tpr_partida_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:19:16
	 */
	function ListarPartidaModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_modificacion_sel';
		$this->codigo_procedimiento = "'PR_PARMOD_SEL'";

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
		$this->var->add_def_cols('id_partida_modificacion','int4');
		$this->var->add_def_cols('id_modificacion','int4');
		$this->var->add_def_cols('id_partida_presupuesto','int4');
		$this->var->add_def_cols('id_usuario_autorizado','int4');
		$this->var->add_def_cols('desc_usuario_autorizado','text');
		$this->var->add_def_cols('id_partida_ejecucion','int4');
		$this->var->add_def_cols('tipo_modificacion','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_usuario_reg','int4');
		$this->var->add_def_cols('desc_usuario_reg','text');
		$this->var->add_def_cols('fecha_reg','timestamp');
		
		$this->var->add_def_cols('id_partida','int4');
		$this->var->add_def_cols('id_partida_gasto','int4');
		$this->var->add_def_cols('desc_partida','text');	

		$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('cod_categoria_prog','text');
		$this->var->add_def_cols('desc_disponibilidad','varchar');
		
		$this->var->add_def_cols('mes_01','numeric');
		$this->var->add_def_cols('mes_02','numeric');
		$this->var->add_def_cols('mes_03','numeric');
		$this->var->add_def_cols('mes_04','numeric');
		$this->var->add_def_cols('mes_05','numeric');
		$this->var->add_def_cols('mes_06','numeric');
		$this->var->add_def_cols('mes_07','numeric');
		$this->var->add_def_cols('mes_08','numeric');
		$this->var->add_def_cols('mes_09','numeric');
		$this->var->add_def_cols('mes_10','numeric');
		$this->var->add_def_cols('mes_11','numeric');
		$this->var->add_def_cols('mes_12','numeric');
		$this->var->add_def_cols('total','numeric');

		//Ejecuta la función de consult
		$res = $this->var->exec_query(); 

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPartidaModificacion
	 * Propósito:				Contar los registros de tpr_partida_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:19:16
	 */
	function ContarPartidaModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_modificacion_sel';
		$this->codigo_procedimiento = "'PR_PARMOD_COUNT'";
		
		//echo var_dump($criterio_filtro); exit;

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
	 * Nombre de la función:	InsertarPartidaModificacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_partida_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:19:16
	 */
	function InsertarPartidaModificacion($id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg,$id_partida,$id_presupuesto,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total)
	{
		//echo 'id partida'.$id_partida.'id pres'.$id_presupuesto; exit;
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_modificacion_iud';
		$this->codigo_procedimiento = "'PR_PARMOD_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_modificacion);
		$this->var->add_param($id_partida_presupuesto);
		$this->var->add_param($id_usuario_autorizado);
		$this->var->add_param($id_partida_ejecucion);
		$this->var->add_param("'$tipo_modificacion'");
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_usuario_reg);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_partida);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($mes_01);
		$this->var->add_param($mes_02);
		$this->var->add_param($mes_03);
		$this->var->add_param($mes_04);
		$this->var->add_param($mes_05);
		$this->var->add_param($mes_06);
		$this->var->add_param($mes_07);
		$this->var->add_param($mes_08);
		$this->var->add_param($mes_09);
		$this->var->add_param($mes_10);
		$this->var->add_param($mes_11);
		$this->var->add_param($mes_12);
		$this->var->add_param($total);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;	exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPartidaModificacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_partida_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:19:16
	 */
	function ModificarPartidaModificacion($id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg,$id_partida,$id_presupuesto,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_modificacion_iud';
		$this->codigo_procedimiento = "'PR_PARMOD_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_modificacion);
		$this->var->add_param($id_modificacion);
		$this->var->add_param($id_partida_presupuesto);
		$this->var->add_param($id_usuario_autorizado);
		$this->var->add_param($id_partida_ejecucion);
		$this->var->add_param("'$tipo_modificacion'");
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_usuario_reg);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_partida);
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($mes_01);
		$this->var->add_param($mes_02);
		$this->var->add_param($mes_03);
		$this->var->add_param($mes_04);
		$this->var->add_param($mes_05);
		$this->var->add_param($mes_06);
		$this->var->add_param($mes_07);
		$this->var->add_param($mes_08);
		$this->var->add_param($mes_09);
		$this->var->add_param($mes_10);
		$this->var->add_param($mes_11);
		$this->var->add_param($mes_12);
		$this->var->add_param($total);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPartidaModificacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_partida_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:19:16
	 */
	function EliminarPartidaModificacion($id_partida_modificacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_modificacion_iud';
		$this->codigo_procedimiento = "'PR_PARMOD_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_modificacion);
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
		$this->var->add_param("NULL");//id_partida
		$this->var->add_param("NULL");//id_presupuesto
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
	 * Nombre de la función:	ValidarPartidaModificacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_partida_modificacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-05-10 18:19:16
	 */
	function ValidarPartidaModificacion($operacion_sql,$id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg)
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
				//Validar id_partida_modificacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_partida_modificacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_modificacion", $id_partida_modificacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_modificacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_modificacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_modificacion", $id_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida_presupuesto - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_presupuesto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_presupuesto", $id_partida_presupuesto))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar id_usuario_autorizado - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usuario_autorizado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usuario_autorizado", $id_usuario_autorizado))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			
			//Validar tipo_modificacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_modificacion");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_modificacion", $tipo_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar importe - tipo numeric
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe");
			$tipo_dato->set_MaxLength(1310722);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe", $importe))
			{
				$this->salida = $valid->salida;
				return false;
			}*/
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_partida_modificacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_modificacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_modificacion", $id_partida_modificacion))
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