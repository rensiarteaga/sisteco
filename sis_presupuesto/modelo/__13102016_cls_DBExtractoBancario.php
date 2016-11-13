<?php
/**
 * Nombre de la clase:	cls_DBExtractoBancario.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_extracto_bancario
 * Autor:				A.V.Q.
 * Fecha creación:		2015-11-12
 */

 
class cls_DBExtractoBancario
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
	 * Nombre de la función:	ListarExtractoBancario
	 * Propósito:				Desplegar los registros de tts_extracto_bancario
	 * Autor:				    a.v.q.
	 * Fecha de creación:		2015-11-12
	 */
	function ListarExtractoBancario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_extracto_bancario_sel';
		$this->codigo_procedimiento = "'PR_EXTBAN_SEL'";

		$func = new cls_funciones();//Instancia de laPR_EXTBAN_SELs funciones generales
		
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
		
		$this->var->add_def_cols('id_extracto_bancario','integer');
		$this->var->add_def_cols('fecha_movimiento','date');
		$this->var->add_def_cols('agencia','VARCHAR');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('nro_documento','VARCHAR');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
		$this->var->add_def_cols('tipo_importe','VARCHAR');
		$this->var->add_def_cols('sub_tipo_importe ','VARCHAR');
		$this->var->add_def_cols('observaciones','TEXT');
        $this->var->add_def_cols('nro_cuenta_banco','varchar');
		$this->var->add_def_cols('id_siet_cbte','integer');
		$this->var->add_def_cols('sw_asocia','varchar');
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
	 * Nombre de la función:	ContarExtractoBancario
	 * Propósito:				Contar los registros de tts_extracto_bancario
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ContarExtractoBancario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_extracto_bancario_sel';
		$this->codigo_procedimiento = "'PR_EXTBAN_COUNT'";

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
	 * Nombre de la función:	InsertarExtractoBancario
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_extracto_bancario
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function InsertarExtractoBancario($id_extracto_bancario,$id_cuenta_bancaria,$fecha_movimiento,$agencia,$descripcion,$nro_documento,$monto,$tipo_importe,$sub_tipo_importe,$id_parametro,$id_periodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_extracto_bancario_iud';
		$this->codigo_procedimiento = "'PR_EXTBANC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param("NULL");
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("'$fecha_movimiento'");
		$this->var->add_param("'$agencia'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($nro_documento);  
		$this->var->add_param($monto);
		$this->var->add_param("'$tipo_importe'");
		$this->var->add_param("'$sub_tipo_importe'");
		$this->var->add_param($id_parametro);
		$this->var->add_param($id_periodo);
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
	 * Nombre de la función:	ModificarExtractoBancario
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_extracto_bancario
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ModificarExtractoBancario($id_extracto_bancario,$sub_tipo_importe,$observaciones,$id_cbte,$monto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_extracto_bancario_iud';
		$this->codigo_procedimiento = "'PR_EXTBANC_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_extracto_bancario);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$monto");
		$this->var->add_param("NULL");
		$this->var->add_param("'$sub_tipo_importe'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");
              $this->var->add_param("$id_cbte");
             
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarExtractoBancario
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_extracto_bancario
	 * Autor:				    avq
	 * Fecha de creación:		01/11/2015
	 */
	function EliminarExtractoBancario($id_extracto_bancario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_extracto_bancario_iud';
		$this->codigo_procedimiento = "'PR_EXTBANC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_extracto_bancario);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL"); //descripcion
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
              $this->var->add_param("NULL");
              $this->var->add_param("NULL");
              $this->var->add_param("NULL");
         //     $this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Propósito:				Permite buscar las transferencias dado el id_cuenta y diferenciarlas del extracto _bancario
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function DefinirTransferencias($id_cuenta_bancaria,$id_parametro,$id_periodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_extracto_bancario_iud';
		$this->codigo_procedimiento = "'PR_EXTBANTRA_IUD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	
		$this->var->add_param("NULL");
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_parametro);
		$this->var->add_param($id_periodo);
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
	 * Propósito:				Permite generar backup del Extracto Bancario
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function GenerarBackupEB($id_periodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_extracto_bancario_iud';
		$this->codigo_procedimiento = "'PR_GENBACEB_IUD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	
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
		$this->var->add_param("$id_periodo");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
	
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
	 * Propósito:				Permite subir el backup del Extracto Bancario
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function SubirBackupEB($id_periodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_extracto_bancario_iud';
		$this->codigo_procedimiento = "'PR_SUBBACEB_IUD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	
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
		$this->var->add_param("$id_periodo");
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
	 * Nombre de la función:	ActualizarExtractoBancario
	 * Propósito:				Permite ejecutar la función de inserción de la tabla presto.tpr_extracto_bancario
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	
	function ActualizarAsociarExtractoBancario($id_extracto_bancario,$id_cuenta_bancaria,$monto,$tipo_importe,$id_parametro,$id_periodo,$id_siet_cbte)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_extracto_bancario_iud';
		$this->codigo_procedimiento = "'PR_ASOCEB_UPD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	
		$this->var->add_param($id_extracto_bancario);
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("NULL");
		$this->var->add_param("$monto");
		$this->var->add_param("'$tipo_importe'");
		$this->var->add_param("'NULL'");
		$this->var->add_param($id_parametro);
		$this->var->add_param($id_periodo);
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
	
	
}?>
