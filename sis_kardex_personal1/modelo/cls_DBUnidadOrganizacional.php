<?php
/**
 * Nombre de la clase:	cls_DBUnidadOrganizacional.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_unidad_organizacional
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-12 09:24:17
 */

 
class cls_DBUnidadOrganizacional
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
	 * Nombre de la función:	ListarUnidadOrganizacional
	 * Propósito:				Desplegar los registros de tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ListarUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_unidad_organizacional_sel';
		$this->codigo_procedimiento = "'KP_UNIORG_SEL'";

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
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('centro','varchar');
		$this->var->add_def_cols('cargo_individual','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_nivel_organizacional','int4');
		$this->var->add_def_cols('nombre_nivel','varchar');
		$this->var->add_def_cols('estado_reg','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
	/*if ($_SESSION['ss_id_usuario']==120){
		 echo $this->query;
		 exit;   
		 }*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarUnidadOrganizacional
	 * Propósito:				Contar los registros de tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ContarUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_unidad_organizacional_sel';
		$this->codigo_procedimiento = "'KP_UNIORG_COUNT'";

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
	 * ListarCentros
	 */
	
	function ListarUnidadOrganizacionalCentro($id_empleado)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_unidad_organizacional_centro_sel';
		$this->codigo_procedimiento = "'KP_UNORCE_SEL'";
		
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_empleado");
		//$this->var->add_param("$id_ep");
	
		//Ejecuta la función
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida[0][0];

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	InsertarUnidadOrganizacional
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function InsertarUnidadOrganizacional($id_unidad_organizacional,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$fecha_reg,$id_nivel_organizacional,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_unidad_organizacional_iud';
		$this->codigo_procedimiento = "'KP_UNIORG_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_unidad'");
		$this->var->add_param("'$nombre_cargo'");
		$this->var->add_param("'$centro'");
		$this->var->add_param("'$cargo_individual'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_nivel_organizacional);
		$this->var->add_param("'$estado_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	
	
	
	/**
	 * Nombre de la función:	ModificarUnidadOrganizacional
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ModificarUnidadOrganizacional($id_unidad_organizacional,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$fecha_reg,$id_nivel_organizacional,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_unidad_organizacional_iud';
		$this->codigo_procedimiento = "'KP_UNIORG_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param("'$nombre_unidad'");
		$this->var->add_param("'$nombre_cargo'");
		$this->var->add_param("'$centro'");
		$this->var->add_param("'$cargo_individual'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_nivel_organizacional);
		$this->var->add_param("'$estado_reg'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarUnidadOrganizacional
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function EliminarUnidadOrganizacional($id_unidad_organizacional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_unidad_organizacional_iud';
		$this->codigo_procedimiento = "'KP_UNIORG_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_unidad_organizacional);
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
	 * Nombre de la función:	ListarUnidadOrganizacionalEP
	 * Propósito:				Desplegar los registros de tkp_unidad_organizacional en función de tps_presupuesto
	 * Autor:				    RCM
	 * Fecha de creación:		03/02/2009
	 */
	function ListarUnidadOrganizacionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_unidad_organizacional_sel';
		$this->codigo_procedimiento = "'KP_UOEP_SEL'";

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
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('centro','varchar');
		$this->var->add_def_cols('cargo_individual','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_nivel_organizacional','int4');
		$this->var->add_def_cols('nombre_nivel','varchar');
		$this->var->add_def_cols('estado_reg','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query ;
		//exit;
		return $res;
	}
	
	 /* Nombre de la función:	ContarUnidadOrganizacionalEP
	 * Propósito:				Contar los registros de tkp_unidad_organizacional en función de tpr_presupuesto
	 * Autor:				    RCM
	 * Fecha de creación:		03/02/2009
	 */
	function ContarUnidadOrganizacionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_unidad_organizacional_sel';
		$this->codigo_procedimiento = "'KP_UOEP_COUNT'";

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
	 * Nombre de la función:	ValidarUnidadOrganizacional
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-12 09:24:17
	 */
	function ValidarUnidadOrganizacional($operacion_sql,$id_unidad_organizacional,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$fecha_reg,$id_nivel_organizacional,$estado_reg)
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
				//Validar id_unidad_organizacional - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_unidad_organizacional");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre_unidad - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_unidad");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_unidad", $nombre_unidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_cargo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_cargo");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_cargo", $nombre_cargo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar centro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("centro");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "centro", $centro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cargo_individual - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cargo_individual");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cargo_individual", $cargo_individual))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
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

			//Validar id_nivel_organizacional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_nivel_organizacional");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_nivel_organizacional", $id_nivel_organizacional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_reg - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_unidad_organizacional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
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
