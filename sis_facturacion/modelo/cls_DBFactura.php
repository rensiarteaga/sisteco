<?php
/**
 * Nombre de la Clase:	cls_DBFactura
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tfv_factura
 * Autor:				MTSL
 * Fecha creación:		2014.05
 *
 */
class cls_DBFactura
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
	var $nombre_archivo = "cls_DBFactura.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct()
	{
		//Carga los parámetro de validación de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarFactura
	 * Propósito:				Desplegar los registros de tfv_factura en función de los parámetros del filtro
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function ListarFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_factura_sel';
		$this->codigo_procedimiento = "'FV_FACTUR_SEL'";

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
		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_factura','integer');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('id_cliente','integer');
		$this->var->add_def_cols('id_dosifica','integer');
		$this->var->add_def_cols('nro_autoriza','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('simbolo','varchar');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('fac_nombre','varchar');
		$this->var->add_def_cols('fac_nronit','numeric');
		$this->var->add_def_cols('fac_tcambio','numeric');
		$this->var->add_def_cols('fac_fecha','date');
		$this->var->add_def_cols('fac_concepto','varchar');
		$this->var->add_def_cols('fac_importe','numeric');
		$this->var->add_def_cols('fac_numero','integer');
		$this->var->add_def_cols('fac_control','varchar');
		$this->var->add_def_cols('fac_formula','integer');
		$this->var->add_def_cols('fac_estado_vig','varchar');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarFactura
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function ContarFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_factura_sel';
		$this->codigo_procedimiento = "'FV_FACTUR_COUNT'";

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
	 * Nombre de la función:	InsertarFactura
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfv_factura
	 * 							con los parámetros requeridos
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
		
	function InsertarFactura($id_factura, $id_gestion, $id_cliente, $id_dosifica, $id_moneda, $id_depto, $fac_tcambio, $fac_fecha, $fac_concepto, $fac_formula)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_factura_iud';
		$this->codigo_procedimiento = "'FV_FACTUR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id factura
		$this->var->add_param("$id_gestion");
		$this->var->add_param("$id_cliente");
		$this->var->add_param("$id_dosifica");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$id_depto");
		$this->var->add_param("$fac_tcambio");
		$this->var->add_param("'$fac_fecha'");
		$this->var->add_param("'$fac_concepto'");
		$this->var->add_param("$fac_formula");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarFactura
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfv_factura
	 * con los parámetros requeridos
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function ModificarFactura($id_factura, $id_gestion, $id_cliente, $id_dosifica, $id_moneda, $id_depto, $fac_tcambio, $fac_fecha, $fac_concepto, $fac_formula)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_factura_iud';
		$this->codigo_procedimiento = "'FV_FACTUR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_factura");
		$this->var->add_param("$id_gestion");
		$this->var->add_param("$id_cliente");
		$this->var->add_param("$id_dosifica");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$id_depto");
		$this->var->add_param("$fac_tcambio");
		$this->var->add_param("'$fac_fecha'");
		$this->var->add_param("'$fac_concepto'");
		$this->var->add_param("$fac_formula");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	EditarFactura
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfv_factura
	 * con los parámetros requeridos
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function EditarFactura($id_factura, $fac_concepto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_factura_iud';
		$this->codigo_procedimiento = "'FV_FACTUR_MOD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_factura");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("'$fac_concepto'");
		$this->var->add_param("null");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarFactura
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfv_factura
	 * con los parámetros requeridos
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function EliminarFactura($id_factura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_factura_iud';
		$this->codigo_procedimiento = "'FV_FACTUR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_factura");//id de Factura
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarFactura
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					MTSL			
	 * Fecha creación:			2014.05
	 */
	function ValidarFactura($operacion_sql, $id_factura, $id_gestion, $id_cliente, $id_dosific, $id_moneda, $id_depto, $fac_tcambio, $fac_fecha, $fac_concepto, $fac_formula)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validad el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		//Ejecuta la validación por el tipo de operación
		switch ($operacion_sql) {
			case 'insert' or 'update':
				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla
				
				if($operacion_sql == 'update')
				{				
					//Validar id_factura - tipo integer
					$tipo_dato->_reiniciar_valor();
					$tipo_dato->set_Columna("id_factura");	
					$tipo_dato->set_MaxLength(15);
					$tipo_dato->set_MinLength(0);
					$tipo_dato->set_Signo('2');
					 
					if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_factura", $id_factura))
					{
						$this->salida = $valid->salida;
						return false;
					}
				}
				
				//Validación exitosa
				return true;
				break;
               
			case 'delete':
				break;
				
			default:
				return false;
				break;
		}
	}
	
	/**
	 * Nombre de la función:	ListarTCambio
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function ListarTCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_factura_sel';
		$this->codigo_procedimiento = "'FV_TCAMBI_SEL'";
	
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
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('resultado','int4');
		$this->var->add_def_cols('oficial','numeric');
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo "query:".$this->query; exit;*/
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	ProcesarFactura
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfv_factura
	 * con los parámetros requeridos
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function ProcesarFactura($accion,$id_factura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_factura_iud';
		
		if($accion=='devengar'){
			$this->codigo_procedimiento = "'FV_FACDEV_PRO'";
		}
		elseif ($accion=='emitir'){
			$this->codigo_procedimiento = "'FV_FACEMI_PRO'";
		}
		elseif ($accion=='anular'){
			$this->codigo_procedimiento = "'FV_FACNUL_PRO'";
		}
		elseif ($accion=='revertir'){
			$this->codigo_procedimiento = "'FV_FACREV_PRO'";
		}
		elseif ($accion=='percibir'){
			$this->codigo_procedimiento = "'TS_FACEMI_PRO'";
		}
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_factura");//id de Factura
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarFacturaQR
	 * Propósito:				Desplegar los registros de tfv_factura en función de los parámetros del filtro
	 * Autor:					MTSL
	 * Fecha de creación:		2016.01
	 */
	function ListarFacturaQR($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_factura_sel';
		$this->codigo_procedimiento = "'FV_FACDQR_SEL'";
	
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
		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nro_nit','numeric');
		$this->var->add_def_cols('fac_numero','integer');
		$this->var->add_def_cols('nro_autoriza','numeric');
		$this->var->add_def_cols('fac_fecha','varchar');
		$this->var->add_def_cols('fac_importe','varchar');
		$this->var->add_def_cols('fac_control','varchar');
		$this->var->add_def_cols('fac_nronit','numeric');
		$this->var->add_def_cols('sw_debito','varchar');
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
}?>