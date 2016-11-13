<?php
/**
 * Nombre de la clase:	cls_DBAlmacen.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_almacen
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-11 09:24:52
 */

class cls_DBAlmacen
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
	 * Nombre de la función:	ListarAlmacen
	 * Propósito:				Desplegar los registros de tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ListarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_sel';
		$this->codigo_procedimiento = "'AL_ALMACE_SEL'";

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
		$this->var->add_def_cols('id_almacen','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('via_fil_max','int4');
		$this->var->add_def_cols('via_col_max','int4');
		$this->var->add_def_cols('bloqueado','varchar');
		$this->var->add_def_cols('cerrado','varchar');
		$this->var->add_def_cols('nro_prest_pendientes','int4');
		$this->var->add_def_cols('nro_ing_no_finalizados','int4');
		$this->var->add_def_cols('nro_sal_no_finalizadas','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_ultimo_inventario','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_regional','int4');
		$this->var->add_def_cols('desc_regional','varchar');
        $this->var->add_def_cols('fecha_apertura','date');
		$this->var->add_def_cols('fecha_cierre','date');
		$this->var->add_def_cols('superficie_m2','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ListarAlmacenEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_sel';
		$this->codigo_procedimiento = "'AL_ALMACE_SELEP'";

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
		$this->var->add_param($func->iif($id_financiador == '', "'%'", "'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional    == '', "'%'", "'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa    == '', "'%'", "'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto    == '', "'%'", "'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad   == '', "'%'", "'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_almacen','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('via_fil_max','int4');
		$this->var->add_def_cols('via_col_max','int4');
		$this->var->add_def_cols('bloqueado','varchar');
		$this->var->add_def_cols('cerrado','varchar');
		$this->var->add_def_cols('nro_prest_pendientes','int4');
		$this->var->add_def_cols('nro_ing_no_finalizados','int4');
		$this->var->add_def_cols('nro_sal_no_finalizadas','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_ultimo_inventario','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_regional','int4');
		$this->var->add_def_cols('desc_regional','varchar');
		$this->var->add_def_cols('superficie_m2','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarAlmacen
	 * Propósito:				Contar los registros de tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ContarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_sel';
		$this->codigo_procedimiento = "'AL_ALMACE_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '', "'%'", "'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional    == '', "'%'", "'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa    == '', "'%'", "'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto    == '', "'%'", "'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad   == '', "'%'", "'$id_actividad'"));//id_actividad
		
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
	 * Nombre de la función:	ContarAlmacen
	 * Propósito:				Contar los registros de tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ContarAlmacenEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_sel';
		$this->codigo_procedimiento = "'AL_ALMACE_COUNTEP'";

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
		$this->var->add_param($func->iif($id_financiador == '', "'%'", "'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional    == '', "'%'", "'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa    == '', "'%'", "'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto    == '', "'%'", "'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad   == '', "'%'", "'$id_actividad'"));//id_actividad
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
				//echo "query:".$this->var->query;

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
	 * Nombre de la función:	InsertarAlmacen
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function InsertarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional,$superficie_m2)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_iud';
		$this->codigo_procedimiento = "'AL_ALMACE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$direccion'");
		$this->var->add_param($via_fil_max);
		$this->var->add_param($via_col_max);
		$this->var->add_param("'$bloqueado'");
		$this->var->add_param("'$cerrado'");
		$this->var->add_param($nro_prest_pendientes);
		$this->var->add_param($nro_ing_no_finalizados);
		$this->var->add_param($nro_sal_no_finalizadas);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_ultimo_inventario'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_regional);
		$this->var->add_param($superficie_m2);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarAlmacen
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ModificarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional,$superficie_m2)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_iud';
		$this->codigo_procedimiento = "'AL_ALMACE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_almacen);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$direccion'");
		$this->var->add_param($via_fil_max);
		$this->var->add_param($via_col_max);
		$this->var->add_param("'$bloqueado'");
		$this->var->add_param("'$cerrado'");
		$this->var->add_param($nro_prest_pendientes);
		$this->var->add_param($nro_ing_no_finalizados);
		$this->var->add_param($nro_sal_no_finalizadas);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_ultimo_inventario'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_regional);
		$this->var->add_param($superficie_m2);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ModificarAlmacenBloqueo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ModificarAlmacenBloqueo($id_almacen,$codigo,$nombre,$bloqueado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_iud';
		$this->codigo_procedimiento = "'AL_ALMACE_BLOQ'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_almacen);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("'$bloqueado'");
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
	 * Nombre de la función:	EliminarAlmacen
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function EliminarAlmacen($id_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_iud';
		$this->codigo_procedimiento = "'AL_ALMACE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_almacen);
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
	 * Nombre de la función:	ValidarAlmacen
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ValidarAlmacen($operacion_sql,$id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional,$superficie_m2)
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
				//Validar id_almacen - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_almacen");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar direccion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("direccion");
			$tipo_dato->set_MaxLength(150);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "direccion", $direccion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar via_fil_max - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("via_fil_max");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(1);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "via_fil_max", $via_fil_max))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar via_col_max - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("via_col_max");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(1);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "via_col_max", $via_col_max))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar bloqueado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("bloqueado");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "bloqueado", $bloqueado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cerrado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cerrado");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cerrado", $cerrado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_prest_pendientes - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_prest_pendientes");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_prest_pendientes", $nro_prest_pendientes))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_ing_no_finalizados - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_ing_no_finalizados");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_ing_no_finalizados", $nro_ing_no_finalizados))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_sal_no_finalizadas - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_sal_no_finalizadas");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_sal_no_finalizadas", $nro_sal_no_finalizadas))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank("true");		
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_ultimo_inventario - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ultimo_inventario");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");		
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ultimo_inventario", $fecha_ultimo_inventario))
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

			//Validar id_regional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_regional");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "id_regional", $id_regional))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar superficie_m2 - tipo nuermic
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("superficie_m2");
			$tipo_dato->set_MaxLength(21);
			$tipo_dato->set_AllowBlank("true");		
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "superficie_m2", $superficie_m2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar bloqueado
			$check = array ("si","no");
			if(!in_array($bloqueado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'bloqueado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarAlmacen";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar cerrado
			$check = array ("No","Definitivo","Periodico","Gestion");
			if(!in_array($cerrado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'cerrado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarAlmacen";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen))
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