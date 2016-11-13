<?php
/**
 * Nombre de la clase:	cls_DBEeffCompara.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_eeff
 * Autor:				(autogenerado)
 * Fecha creación:		2013-03-31 11:34:33
*/

class cls_DBEeffCompara
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
	
	function ListarEeffCom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_sel';
		$this->codigo_procedimiento = "'CT_EEFF_SEL'";

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
		$this->var->add_def_cols('id_eeff','int4');
		$this->var->add_def_cols('id_gestion_act','integer');
		$this->var->add_def_cols('desges_act','numeric');
		$this->var->add_def_cols('id_gestion_ant','integer');
		$this->var->add_def_cols('desges_ant','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('eeff_actual','varchar');
		$this->var->add_def_cols('eeff_fecran','numeric');
		$this->var->add_def_cols('eeff_nivel','numeric');
		$this->var->add_def_cols('eeff_texto','varchar');
		$this->var->add_def_cols('mat_contador','varchar');
		$this->var->add_def_cols('id_empleado_fc','integer');
		$this->var->add_def_cols('nombre_fc','text');
		$this->var->add_def_cols('id_empleado_f1','integer');
		$this->var->add_def_cols('nombre_f1','text');
		$this->var->add_def_cols('id_empleado_f2','integer');
		$this->var->add_def_cols('nombre_f2','text');
		$this->var->add_def_cols('id_empleado_f3','integer');
		$this->var->add_def_cols('nombre_f3','text');
		$this->var->add_def_cols('id_reporte_eeff','integer');
		$this->var->add_def_cols('nombre_eeff','varchar');
		$this->var->add_def_cols('eeff_fecha','timestamp');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	function ContarEeffCom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_sel';
		$this->codigo_procedimiento = "'CT_EEFF_COUNT'";

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
		if($res){
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}

	function InsertarEeffCom($id_eeff,$id_gestion_act,$id_gestion_ant,$eeff_texto,$id_reporte_eeff,$id_moneda,$eeff_actual,$eeff_fecran,$eeff_nivel)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_iud';
		$this->codigo_procedimiento = "'CT_EEFF_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_gestion_act");
		$this->var->add_param("$id_gestion_ant");
		$this->var->add_param("'$eeff_texto'");
		$this->var->add_param("$id_reporte_eeff");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("'$eeff_actual'");
		$this->var->add_param("$eeff_fecran");
		$this->var->add_param("$eeff_nivel");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ModificarEeffCom($id_eeff,$id_gestion_act,$id_gestion_ant,$eeff_texto,$id_reporte_eeff,$id_moneda,$eeff_actual,$eeff_fecran,$eeff_nivel)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_iud';
		$this->codigo_procedimiento = "'CT_EEFF_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_eeff);
		$this->var->add_param("$id_gestion_act");
		$this->var->add_param("$id_gestion_ant");
		$this->var->add_param("'$eeff_texto'");
		$this->var->add_param("$id_reporte_eeff");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("'$eeff_actual'");
		$this->var->add_param("$eeff_fecran");
		$this->var->add_param("$eeff_nivel");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function EliminarEeffCom($id_eeff)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_iud';
		$this->codigo_procedimiento = "'CT_EEFF_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_eeff);
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
	
	function ValidarEeffCom($operacion_sql,$id_eeff,$id_gestion_act,$id_gestion_ant,$eeff_texto,$id_reporte_eeff,$id_moneda,$eeff_actual,$eeff_fecran,$eeff_nivel)
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
				//Validar id_reporte_eeff - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_eeff");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_eeff", $id_eeff))
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
			//Validar id_reporte_eeff - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_eeff");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_eeff", $id_eeff))
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
	
	function ListarEeffLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_linea_sel';
		$this->codigo_procedimiento = "'CT_EEFFLIN_SEL'";

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
		$this->var->add_def_cols('id_eeff_linea','int4');
		$this->var->add_def_cols('id_eeff','integer');
		$this->var->add_def_cols('linea_nro','integer');
		$this->var->add_def_cols('id_cuenta_act','integer');
		$this->var->add_def_cols('descta_act','text');
		$this->var->add_def_cols('id_cuenta_uno','integer');
		$this->var->add_def_cols('descta_ant','text');
		$this->var->add_def_cols('linea_letra','numeric');
		$this->var->add_def_cols('linea_dato','numeric');
		$this->var->add_def_cols('linea_saldo','numeric');
		$this->var->add_def_cols('linea_n','numeric');
		$this->var->add_def_cols('linea_s','numeric');
		$this->var->add_def_cols('linea_t','numeric');
		$this->var->add_def_cols('linea_b','numeric');
		$this->var->add_def_cols('id_eeff_nota','integer');
		$this->var->add_def_cols('nota_nro','integer');
		$this->var->add_def_cols('linea_desope','varchar');
		$this->var->add_def_cols('linea_impre','text');
		
		//Ejecuta la función de consulta 
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	function ContarEeffLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_linea_sel';
		$this->codigo_procedimiento = "'CT_EEFFLIN_COUNT'";

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
		if($res){
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}

	function InsertarEeffLinea($id_eeff_linea,$id_eeff,$id_cuenta_act,$linea_letra,$linea_dato,$linea_saldo,$linea_n,$linea_s,$id_eeff_nota,$linea_desope,$linea_b,$linea_nro,$linea_t)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_linea_iud';
		$this->codigo_procedimiento = "'CT_EEFFLIN_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_eeff");
		$this->var->add_param("$id_cuenta_act");
		$this->var->add_param("$linea_letra");
		$this->var->add_param("$linea_dato");
		$this->var->add_param("$linea_saldo");
		$this->var->add_param("$linea_n");
		$this->var->add_param("$linea_s");
		$this->var->add_param("$id_eeff_nota");
		$this->var->add_param("'$linea_desope'");
		$this->var->add_param("$linea_b");
		$this->var->add_param("$linea_nro");
		$this->var->add_param("$linea_t");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ModificarEeffLinea($id_eeff_linea,$id_eeff,$id_cuenta_act,$linea_letra,$linea_dato,$linea_saldo,$linea_n,$linea_s,$id_eeff_nota,$linea_desope,$linea_b,$linea_nro,$linea_t)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_linea_iud';
		$this->codigo_procedimiento = "'CT_EEFFLIN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_eeff_linea);
		$this->var->add_param("$id_eeff");
		$this->var->add_param("$id_cuenta_act");
		$this->var->add_param("$linea_letra");
		$this->var->add_param("$linea_dato");
		$this->var->add_param("$linea_saldo");
		$this->var->add_param("$linea_n");
		$this->var->add_param("$linea_s");
		$this->var->add_param("$id_eeff_nota");
		$this->var->add_param("'$linea_desope'");
		$this->var->add_param("$linea_b");
		$this->var->add_param("$linea_nro");
		$this->var->add_param("$linea_t");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function EliminarEeffLinea($id_eeff_linea)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_linea_iud';
		$this->codigo_procedimiento = "'CT_EEFFLIN_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_eeff_linea);
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
	
	function ValidarEeffLinea($operacion_sql,$id_eeff_linea,$id_eeff,$id_cuenta_act,$linea_letra,$linea_dato,$linea_saldo,$linea_n,$linea_s,$id_eeff_nota,$linea_desope,$linea_b,$linea_nro,$linea_t)
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
				//Validar id_reporte_eeff - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_eeff_linea");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_eeff_linea", $id_eeff_linea))
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
			//Validar id_reporte_eeff - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_eeff_linea");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_eeff_linea", $id_eeff_linea))
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
	
	function ListarEeffNota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_nota_sel';
		$this->codigo_procedimiento = "'CT_EEFFNOT_SEL'";

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
		$this->var->add_def_cols('id_eeff_nota','int4');
		$this->var->add_def_cols('id_eeff','integer');
		$this->var->add_def_cols('nota_nro','integer');
		$this->var->add_def_cols('nota_texto','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	function ContarEeffNota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_nota_sel';
		$this->codigo_procedimiento = "'CT_EEFFNOT_COUNT'";

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
		if($res){
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}

	function InsertarEeffNota($id_eeff_nota,$id_eeff,$nota_nro,$nota_texto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_nota_iud';
		$this->codigo_procedimiento = "'CT_EEFFNOT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_eeff");
		$this->var->add_param("$nota_nro");
		$this->var->add_param("'$nota_texto'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ModificarEeffNota($id_eeff_nota,$id_eeff,$nota_nro,$nota_texto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_nota_iud';
		$this->codigo_procedimiento = "'CT_EEFFNOT_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_eeff_nota);
		$this->var->add_param("$id_eeff");
		$this->var->add_param("$nota_nro");
		$this->var->add_param("'$nota_texto'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function EliminarEeffNota($id_eeff_nota)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_nota_iud';
		$this->codigo_procedimiento = "'CT_EEFFNOT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_eeff_nota);
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
	
	function ValidarEeffNota($operacion_sql,$id_eeff_nota,$id_eeff,$nota_nro,$nota_texto)
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
				//Validar id_reporte_eeff - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_eeff_nota");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_eeff_nota", $id_eeff_nota))
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
			//Validar id_reporte_eeff - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_eeff_nota");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_eeff_nota", $id_eeff_nota))
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
	
	function ListarEeffOpera($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_opera_sel';
		$this->codigo_procedimiento = "'CT_EEFFOPE_SEL'";

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
		$this->var->add_def_cols('id_eeff_opera','int4');
		$this->var->add_def_cols('id_eeff_linea','integer');
		$this->var->add_def_cols('id_cuenta_act','integer');
		$this->var->add_def_cols('descta_act','text');
		$this->var->add_def_cols('id_cuenta_uno','integer');
		$this->var->add_def_cols('descta_ant','text');
		$this->var->add_def_cols('linea_opera','numeric');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	function ContarEeffOpera($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_opera_sel';
		$this->codigo_procedimiento = "'CT_EEFFOPE_COUNT'";

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
		if($res){
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}

	function InsertarEeffOpera($id_eeff_opera,$id_eeff_linea,$id_cuenta_act,$linea_opera)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_opera_iud';
		$this->codigo_procedimiento = "'CT_EEFFOPE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_eeff_linea");
		$this->var->add_param("$id_cuenta_act");
		$this->var->add_param("$linea_opera");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ModificarEeffOpera($id_eeff_opera,$id_eeff_linea,$id_cuenta_act,$linea_opera)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_opera_iud';
		$this->codigo_procedimiento = "'CT_EEFFOPE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_eeff_opera);
		$this->var->add_param("$id_eeff_linea");
		$this->var->add_param("$id_cuenta_act");
		$this->var->add_param("$linea_opera");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function EliminarEeffOpera($id_eeff_opera)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_eeff_opera_iud';
		$this->codigo_procedimiento = "'CT_EEFFOPE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_eeff_opera);
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
	
	function ValidarEeffOpera($operacion_sql,$id_eeff_opera,$id_eeff_linea,$id_cuenta_ant,$linea_opera)
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
				//Validar id_reporte_eeff - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_eeff_opera");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_eeff_opera", $id_eeff_opera))
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
			//Validar id_reporte_eeff - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_eeff_opera");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_eeff_opera", $id_eeff_opera))
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