<?php
/**
 * Nombre de la clase:	cls_DBUnidadOrganizacional.php
 * Prop?sito:			Permite ejecutar toda la funcionalidad de la tabla kard.tkp_unidad_organizacional
 * Autor:				(autogenerado)
 * Fecha creaci?n:		2007-11-07 15:46:18
 */
class cls_DBUnidadOrganizacionalArb
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
	 * ***********************************************************
	 * Para el Mannejo de ?rboles
	 * 
	 * 
	 ************************************************************* 
	 */
	
	/**
	 * Nombre de la funci?n:	ListarUnidadOrganizacionalRaiz
	 * Prop?sito:				Desplegar los registros de tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function ListarUnidadOrganizacionalRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_unidad_organizacional_arb_sel';
		$this->codigo_procedimiento = "'KP_UNIORG_RAIZ_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par?metros espec?ficos de la estructura program?tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");//raiz

		//Carga la definici?n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('cargo_individual','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_nivel_organizacional','integer');
		$this->var->add_def_cols('numero_nivel','integer');
		$this->var->add_def_cols('nombre_nivel','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('importe_max_apro','numeric');
		$this->var->add_def_cols('importe_max_pre','numeric');
		$this->var->add_def_cols('funcionarios','varchar');
		$this->var->add_def_cols('sw_presto','numeric');
		$this->var->add_def_cols('prioridad','varchar');
		$this->var->add_def_cols('area','varchar');	
		//ADICIONADO 28-03-2011 aayaviri
		$this->var->add_def_cols('correspondencia','varchar');
		//4may12 : Mercedes Zambrana
		$this->var->add_def_cols('url_archivo','varchar');
		$this->var->add_def_cols('extension','varchar');
		//------------------------------		
		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la funci?n:	ListarUnidadOrganizacional
	 * Prop?sito:				Desplegar los registros de tkp_estructura_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function ListarUnidadOrganizacionalArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_unidad_organizacional_arb_sel';
		$this->codigo_procedimiento = "'KP_UNIORG_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par?metros espec?ficos de la estructura program?tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("$agrupador");//raiz

		//Carga la definici?n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('cargo_individual','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_nivel_organizacional','integer');
		$this->var->add_def_cols('numero_nivel','integer');
		$this->var->add_def_cols('nombre_nivel','varchar');
		$this->var->add_def_cols('id_estructura_organizacional','integer');
		$this->var->add_def_cols('relacion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_padre','integer');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('importe_max_apro','numeric');
		$this->var->add_def_cols('importe_max_pre','numeric');
		$this->var->add_def_cols('funcionarios','varchar');
		$this->var->add_def_cols('sw_presto','numeric');
		$this->var->add_def_cols('prioridad','varchar');
		$this->var->add_def_cols('area','varchar');
		$this->var->add_def_cols('correspondencia','varchar');
		//4may12 : Mercedes Zambrana
		$this->var->add_def_cols('url_archivo','varchar');
		$this->var->add_def_cols('extension','varchar');
		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
	
		//echo "query:".$this->query;
		return $res;
	}

	/**
	 * Nombre de la funci?n:	ContarUnidadOrganizacional
	 * Prop?sito:				Contar los registros de tkp_estructura_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-06 16:27:45
	 */
	function ContarUnidadOrganizacionalArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_unidad_organizacional_arb_sel';
		$this->codigo_procedimiento = "'KP_UNIORG_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par?metros espec?ficos de la estructura program?tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("$raiz");//raiz


		//Carga la definici?n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci?n
		$this->salida = $this->var->salida;

		//Si la ejecuci?n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuci?n
		return $res;
	}

	/**
	 * Nombre de la funci?n:	InsertarUnidadOrganizacionalRaiz
	 * Prop?sito:				Permite ejecutar la funci?n de inserci?n de la tabla tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function InsertarUnidadOrganizacionalRaiz($id,$id_padre,$relacion,$observaciones,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$id_padre_nuevo,$estado_reg,$importe_max_apro,$importe_max_pre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_unidad_organizacional_arb_iud';
		$this->codigo_procedimiento = "'KP_UNORRAI_INS'";
		
		//Instancia la clase midlle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_unidad'");
		$this->var->add_param("'$nombre_cargo'");
		$this->var->add_param("'$centro'");
		$this->var->add_param("'$cargo_individual'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("$importe_max_apro");
		$this->var->add_param("$importe_max_pre");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//adicion 28-03-2011 aayaviri
		$this->var->add_param("NULL");
		//4may12: Mercedes Zambrana
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//----------------------------
		//Ejecuta la funci?n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la funci?n:	InsertarUnidadOrganizacional
	 * Prop?sito:				Permite ejecutar la funci?n de inserci?n de la tabla tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function InsertarUnidadOrganizacionalArb($id,$id_padre,$relacion,$observaciones,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$id_padre_nuevo,$estado_reg,$importe_max_apro,$importe_max_pre,$sw_presto,$prioridad,$area,$correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_unidad_organizacional_arb_iud';
		$this->codigo_procedimiento = "'KP_UNIORG_INS'";
			
		//Instancia la clase midlle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre");
		$this->var->add_param("'$relacion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$nombre_unidad'");
		$this->var->add_param("'$nombre_cargo'");
		$this->var->add_param("'$centro'");
		$this->var->add_param("'$cargo_individual'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("$id_nivel_organizacional");
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("$importe_max_apro");
		$this->var->add_param("$importe_max_pre");
		$this->var->add_param("$sw_presto");
		$this->var->add_param("'$prioridad'");
		$this->var->add_param("'$area'");
		//Adicion 28-03-2011 aayaviri
		$this->var->add_param("'$correspondencia'");
		//4may12: Mercedes Zambrana
		$this->var->add_param("'$url_archivo'");
		$this->var->add_param("'$extension'");
		//---------------------------
		//Ejecuta la funci?n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la funci?n:	ModificarUnidadOrganizacional
	 * Prop?sito:				Permite ejecutar la funci?n de modificaci?n de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function ModificarUnidadOrganizacionalArb($id,$id_padre,$relacion,$observaciones,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$id_padre_nuevo,$estado_reg,$importe_max_apro,$importe_max_pre,$sw_presto,$prioridad,$area,$correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_unidad_organizacional_arb_iud';
		$this->codigo_procedimiento = "'KP_UNIORG_UPD'";
		
		//Instancia la clase midlle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
		$this->var->add_param("'$relacion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$nombre_unidad'");
		$this->var->add_param("'$nombre_cargo'");
		$this->var->add_param("'$centro'");
		$this->var->add_param("'$cargo_individual'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("$id_nivel_organizacional");
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("$importe_max_apro");
		$this->var->add_param("$importe_max_pre");
		$this->var->add_param("$sw_presto");
		$this->var->add_param("'$prioridad'");
		$this->var->add_param("'$area'");
		//Adicion 28-03-2011 aayaviri
		$this->var->add_param("'$correspondencia'");
		//4may12: Mercedes Zambrana
		$this->var->add_param("'$url_archivo'");
		$this->var->add_param("'$extension'");
		//---------------------------
		//Ejecuta la funci?n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}

	/**
	 * Nombre de la funci?n:	EliminarUnidadOrganizacional
	 * Prop?sito:				Permite ejecutar la funci?n de eliminaci?n de la tabla tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function EliminarUnidadOrganizacionalArb($id,$id_padre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_unidad_organizacional_arb_iud';
		$this->codigo_procedimiento = "'KP_UNIORG_DEL'";

		//Instancia la clase midlle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
		$this->var->add_param("$id_padre");
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
		$this->var->add_param("NULL");//importe_max_apro
		$this->var->add_param("NULL");//importe_max_pre
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//Adicion 28-03-2011
		$this->var->add_param("NULL");//correspondencia
		//4may12: Mercedes Zambrana
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//------------------
		//Ejecuta la funci?n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci?n:	EliminarUnidadOrganizacionalRaiz
	 * Prop?sito:				Permite ejecutar la funci?n de eliminaci?n de la tabla tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function EliminarUnidadOrganizacionalRaiz($id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_unidad_organizacional_arb_iud';
		$this->codigo_procedimiento = "'KP_UNORRAI_DEL'";

		//Instancia la clase midlle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
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
		$this->var->add_param("NULL");//importe_max_apro
		$this->var->add_param("NULL");//importe_max_pre
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//Adicion 28-03-2011
		$this->var->add_param("NULL");//correspondencia
		//4may12: Mercedes Zambrana
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//------------------
		//Ejecuta la funci?n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
		//echo "query:".$this->query;

		return $res;
	}
	
	//DRAG AND DROP//
	/**
	 * Nombre de la funci?n:	DragAndDrop
	 * Prop?sito:				Permite ejecutar la funci?n de DragAndDrop para las Unidades Organizacionales
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function DragAndDrop($id,$id_padre,$id_padre_nuevo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_unidad_organizacional_arb_iud';
		$this->codigo_procedimiento = "'KP_DRADRO_RAM'";

		//Instancia la clase midlle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre_nuevo");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//importe_max_apro
		$this->var->add_param("NULL");//importe_max_pre
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//Adicion 28-03-2011
		$this->var->add_param("NULL");//correspondencia
		//4may12: Mercedes Zambrana
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//------------------
		//Ejecuta la funci?n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
//echo $this->query; exit;
		return $res;
	}


	/**
	 * Nombre de la funci?n:	ValidarUnidadOrganizacional
	 * Prop?sito:				Permite ejecutar la validaci?n del lado del servidor de la tabla tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function ValidarUnidadOrganizacionalArb($id,$id_padre,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$estado_reg)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();

		//Ejecuta la validaci?n por el tipo de operaci?n
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_tipo_unidad_constructiva - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_AllowBlank(false);
				$tipo_dato->set_Columna("id_unidad_organizacional");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional",$id))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_unidad");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_unidad", $nombre_unidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_cargo");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_cargo", $nombre_cargo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("centro");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "centro", $centro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cargo_individual");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cargo_individual", $cargo_individual))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
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
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validaci?n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_unidad_constructiva - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validaci?n exitosa
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
		/**
	 * Nombre de la funci?n:	ListarUnidadOrganizacional
	 * Prop?sito:				Desplegar los registros de tkp_estructura_organizacional
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creaci?n:		2010
	 */
	function FiltrarOrganigramaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$v_id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'kard.f_tkp_organigrama_recursivo_inicia';
		$this->codigo_procedimiento = "'KP_UNIORG_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

	
		$this->var->add_param("$v_id");//raiz

		//Carga la definici?n de columnas con sus tipos de datos
		$this->var->add_def_cols('niveles','varchar');
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('centro','varchar');
		$this->var->add_def_cols('cargo_individual','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('id_nivel_organizacional','integer');
		$this->var->add_def_cols('numero_nivel','integer');
		$this->var->add_def_cols('nombre_nivel','varchar');
		$this->var->add_def_cols('id_estructura_organizacional','integer');
		$this->var->add_def_cols('relacion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_padre','integer');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('importe_max_apro','numeric');
		$this->var->add_def_cols('importe_max_pre','numeric');
		$this->var->add_def_cols('funcionarios','varchar');
		$this->var->add_def_cols('resaltar','varchar');
		
		$this->var->add_def_cols('sw_presto','varchar');
		$this->var->add_def_cols('prioridad','varchar');
		$this->var->add_def_cols('area','varchar');
		$this->var->add_def_cols('correspondencia','varchar');
		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
		//if($_SESSION["ss_id_usuario"]==120){
		//echo "query:".$this->query;}
		return $res;
	}
	
	/**
	 * Para subir archivos asociados a la UO: 8may12
	 *
	 * @param unknown_type $id_unidad_organizacional
	 * @param unknown_type $url_archivo
	 * @param unknown_type $extension
	 * @return unknown
	 */
	function SubirArchivo($id_unidad_organizacional,$url_archivo,$extension)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_unidad_organizacional_arb_iud';
		$this->codigo_procedimiento = "'KP_SUBFILE_UPD'";
		
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");//relacion
		$this->var->add_param("null");//observaciones
		$this->var->add_param("null");
		$this->var->add_param("NULL");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		//Adicion 28-03-2011 aayaviri
		$this->var->add_param("null");
		//4may12: Mercedes Zambrana
		$this->var->add_param("'$url_archivo'");
		$this->var->add_param("'$extension'");
		
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
		
		
		
	}
	
}?>