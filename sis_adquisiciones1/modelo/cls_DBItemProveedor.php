<?php
/**
 * Nombre de la clase:	cls_DBItemProveedor.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_item_proveedor
 * Autor:				(autogenerado)
 * Fecha creación:		2008-04-30 13:04:45
 */

 
class cls_DBItemProveedor
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
	 * Nombre de la función:	ListarItemProveedor
	 * Propósito:				Desplegar los registros de tad_item_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
	function ListarItemProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_item_proveedor_sel';
		$this->codigo_procedimiento = "'AD_IPROVE_SEL'";

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
		$this->var->add_def_cols('id_item_proveedor','int4');
		$this->var->add_def_cols('precio_ult','numeric');
		$this->var->add_def_cols('fecha_ult_mod','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('id_item_propuesto','int4');
		$this->var->add_def_cols('desc_item_propuesto','varchar');
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('desc_proveedor','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarItemProveedor
	 * Propósito:				Contar los registros de tad_item_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
	function ContarItemProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_item_proveedor_sel';
		$this->codigo_procedimiento = "'AD_IPROVE_COUNT'";

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
	 * Nombre de la función:	InsertarItemProveedor
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_item_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
									
	function InsertarItemProveedor($id_item_proveedor,$precio_ult,$fecha_ult_mod,$fecha_reg,$observaciones,$id_item,$id_moneda,$id_item_propuesto,$id_proveedor)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_item_proveedor_iud';
		$this->codigo_procedimiento = "'AD_IPROVE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($precio_ult);
		$this->var->add_param("'$fecha_ult_mod'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_item_propuesto);
		$this->var->add_param($id_proveedor);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarItemProveedor
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_item_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
	function ModificarItemProveedor($id_item_proveedor,$precio_ult,$fecha_ult_mod,$fecha_reg,$observaciones,$id_item,$id_moneda,$id_item_propuesto,$id_proveedor)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_item_proveedor_iud';
		$this->codigo_procedimiento = "'AD_IPROVE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_item_proveedor);
		$this->var->add_param($precio_ult);
		$this->var->add_param("'$fecha_ult_mod'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_item_propuesto);
		$this->var->add_param($id_proveedor);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarItemProveedor
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_item_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
	function EliminarItemProveedor($id_item_proveedor)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_item_proveedor_iud';
		$this->codigo_procedimiento = "'AD_IPROVE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_item_proveedor);
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
	 * Nombre de la función:	ValidarItemProveedor
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_item_proveedor
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
	function ValidarItemProveedor($operacion_sql,$id_item_proveedor,$precio_ult,$fecha_ult_mod,$fecha_reg,$observaciones,$id_item,$id_moneda,$id_proveedor)
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
				//Validar id_item_proveedor - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_item_proveedor");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item_proveedor", $id_item_proveedor))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar precio_ult - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_ult");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_ult", $precio_ult))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_ult_mod - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ult_mod");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ult_mod", $fecha_ult_mod))
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

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_item_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item_proveedor");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item_proveedor", $id_item_proveedor))
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
	/**
	 * Nombre de la función:	ListarItemCaracteristicasCostos
	 * Propósito:				Detalle de Items con sus respectivas caracteristicas y costos
	 * Autor:				    ana maria villegas quispe
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
	function ListarItemCaracteristicasCostos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_item_proveedor_sel';
		$this->codigo_procedimiento = "'AD_ITCACO_SEL'";

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
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('nombre_item','text');
		$this->var->add_def_cols('costo_estimado','numeric');
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
	 * Nombre de la función:	ListarProveedoresItem
	 * Propósito:				Desplegar los registros de proveedores
	 * Autor:				    ana maria villegas quispe
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
	function ListarProveedoresItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_item_proveedor_sel';
		$this->codigo_procedimiento = "'AD_PROITEM_SEL'";

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
		/*$this->var->add_def_cols('id_proveedor,','int4');
		$this->var->add_def_cols('precio_ult','numeric');
		*/
		$this->var->add_def_cols('nombres','text');
		//$this->var->add_def_cols('casilla','varchar');
		$this->var->add_def_cols('telefono1','varchar');
		//$this->var->add_def_cols('telefono2','varchar');
		/*$this->var->add_def_cols('celular1','varchar');
		$this->var->add_def_cols('celular2','varchar');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('email2','varchar');
		$this->var->add_def_cols('fax','varchar');
		*/
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('costo_ult','numeric');
		$this->var->add_def_cols('simbolo','varchar');
		$this->var->add_def_cols('fecha_ult_cot','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;
		*/return $res;
	}
/**
	 * Nombre de la función:	ListarItemCaracteristicasCostos
	 * Propósito:				Detalle de Items con sus respectivas caracteristicas y costos
	 * Autor:				    ana maria villegas quispe
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
	function ListarServiciosCaracteristicasCostos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_item_proveedor_sel';
		$this->codigo_procedimiento = "'AD_SECACO_SEL'";

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
		$this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('nombre_servicio','varchar');
		//$this->var->add_def_cols('costo_estimado','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
/*	echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarProveedoresItem
	 * Propósito:				Desplegar los registros de proveedores
	 * Autor:				    ana maria villegas quispe
	 * Fecha de creación:		2008-04-30 13:04:45
	 */
	function ListarProveedoresServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_item_proveedor_sel';
		$this->codigo_procedimiento = "'AD_PROSER_SEL'";

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
		/*$this->var->add_def_cols('id_proveedor,','int4');
		$this->var->add_def_cols('precio_ult','numeric');
		*/
		$this->var->add_def_cols('nombres','text');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('costo_ult','numeric');
		$this->var->add_def_cols('simbolo','varchar');
		$this->var->add_def_cols('fecha_ult_cot','text');
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
	
}?>