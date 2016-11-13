<?php
/**
 * Nombre de la Clase:	cls_DBObligacion
 * Propósito:			Permite ejecutar la funcionalidad de la tabla cls_DBObligacion
 * Autor:				Resni Artega Copari
 * Fecha creación:		11-08-2010
 *
 */

class cls_DBObligacion
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
	var $nombre_archivo = "cls_DBObligacion.php";

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
	 * Nombre de la función:	ListarTipoObligacion
	 * Propósito:				Desplegar los registros de tkp_TipoObligacion en función de los parámetros del filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 *
	 */
	function ListarObligacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_obligacion_sel';
		$this->codigo_procedimiento = "'KP_OBLIGA_SEL'";

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
		$this->var->add_def_cols('id_obligacion','integer');
		$this->var->add_def_cols('id_tipo_obligacion','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('id_planilla','integer');
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('nro_cuenta_banco','varchar');
		$this->var->add_def_cols('id_institucion','integer');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('desc_cuenta','text');
		$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('desc_auxiliar','text');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
		$this->var->add_def_cols('fecha_pago','date');
		$this->var->add_def_cols('obs_pago','text');
		$this->var->add_def_cols('acreedor','varchar');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('gestion','numeric');
		
		$this->var->add_def_cols('id_institucion_acreedor','integer');
		$this->var->add_def_cols('desc_institucion_acreedor','varchar');
		$this->var->add_def_cols('id_lugar','integer');
		$this->var->add_def_cols('nombre_lugar','varchar');
		
		$this->var->add_def_cols('id_persona','integer');
		$this->var->add_def_cols('desc_person','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query; 
		return $res;
	}

	/**
	 * Nombre de la función:	ContarTipoObligacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 *
	 */
	function ContarObligacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_obligacion_sel';
		$this->codigo_procedimiento = "'KP_OBLIGA_COUNT'";

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
	 * Nombre de la función:	InsertarObligacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_Obligacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		11-08-2010
	 * Descripción:             Se añadio los atributos fecha_reg, estado_reg
	
	 */
	function InsertarObligacion($id_obligacion,$id_tipo_obligacion,$id_planilla,$id_comprobante,$monto,$estado_reg,$observaciones,$id_cuenta_bancaria,$tipo_pago,$id_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_obligacion_iud';
		$this->codigo_procedimiento = "'KP_OBLIGA_INS'";
		
		//echo 'XXXXXXXX  '.$id_tipo_obligacion;
		//exit;

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_tipo_obligacion");
		$this->var->add_param("$id_planilla");
		$this->var->add_param("'$id_gestion'");  //--> aqui se enviará el id_gestion para pago unico de obligaciones (24jun11)
        $this->var->add_param("'$monto'");
        $this->var->add_param("'$estado_reg'");
        $this->var->add_param("'$observaciones'");
        $this->var->add_param("$id_cuenta_bancaria");
        $this->var->add_param("'$tipo_pago'");
        $this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");//id_cta
		$this->var->add_param("null");//id_aux
		$this->var->add_param("NULL");//fecha_pago
		$this->var->add_param("NULL");//observ_pago
		$this->var->add_param("NULL");//acreedor
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarObligacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_Obligacion
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function ModificarObligacion($id_obligacion,$id_tipo_obligacion,$id_planilla,$id_comprobante,$monto,$estado_reg,$observaciones,$id_cuenta_bancaria,$tipo_pago,$id_cuenta,$id_auxiliar,$id_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_obligacion_iud';
		$this->codigo_procedimiento = "'KP_OBLIGA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_obligacion);
		$this->var->add_param("$id_tipo_obligacion");
		$this->var->add_param("$id_planilla");
		$this->var->add_param("'$id_gestion'");//--> aqui se enviará el id_gestion para pago unico de obligaciones (24jun11)
        $this->var->add_param("'$monto'");
        $this->var->add_param("'$estado_reg'");
        $this->var->add_param("'$observaciones'");
        $this->var->add_param("$id_cuenta_bancaria");
		$this->var->add_param("'$tipo_pago'");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param("NULL");//fecha_pago
		$this->var->add_param("NULL");//observ_pago
		$this->var->add_param("NULL");//acreedor
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarObligacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_Obligacion
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function EliminarObligacion($id_obligacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_obligacion_iud';
		$this->codigo_procedimiento = "'KP_OBLIGA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_obligacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");

        $this->var->add_param("NULL");//'$observaciones'");
        $this->var->add_param("NULL");//$id_cuenta_bancaria);
		$this->var->add_param("NULL");//tipo_pago
		$this->var->add_param("NULL");//mi_array
		$this->var->add_param("NULL");//$id_cuenta_bancaria);
		$this->var->add_param("NULL");//tipo_pago
		$this->var->add_param("NULL");//mi_array
		
		$this->var->add_param("NULL");//fecha_pago
		$this->var->add_param("NULL");//observ_pago
		$this->var->add_param("NULL");//acreedor --20jun11
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function PagarObligacion($id_obligacion,$id_tipo_obligacion,$id_planilla,$id_comprobante,$monto,$estado_reg,$observaciones,$id_cuenta_bancaria,$tipo_pago,$mi_array,$cantidad_obligaciones
	, $fecha_pago,$obs_pago, $id_acreedor,$id_lugar
	)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_obligacion_iud';
		$this->codigo_procedimiento = "'KP_PAGOBL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_obligacion);
		$this->var->add_param("$id_tipo_obligacion");
		$this->var->add_param("$id_planilla");
		$this->var->add_param("'$id_lugar'");//se envia el id_lugar
        $this->var->add_param("'$monto'");
        $this->var->add_param("'$estado_reg'");
        $this->var->add_param("'$observaciones'");
        $this->var->add_param("$id_cuenta_bancaria");
        $this->var->add_param("'$tipo_pago'");
		$this->var->add_param("'$mi_array'");//tipo_pago
		$this->var->add_param($cantidad_obligaciones);//cantidad_obligaciones
		$this->var->add_param("NULL");//$id_cuenta_bancaria);
		$this->var->add_param("NULL");//tipo_pago
		$this->var->add_param("'$fecha_pago'");//fecha_pago
		$this->var->add_param("'$obs_pago'");//observ_pago
		$this->var->add_param("'$id_acreedor'");//acreedor
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
}
?>