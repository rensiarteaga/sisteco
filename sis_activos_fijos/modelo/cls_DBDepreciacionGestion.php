<?php
/**
 * Nombre de la Clase:	cls_DBDepreciacionGestion
 * Propï¿½sito:			Permite ejecutar la funcionalidad de la tabla taf_depreciacion_gestion
 * Autor:				UNKNOW
 * Fecha creacion:		29092015
 *
 */
class cls_DBDepreciacionGestion
{
	//Variable que contiene la salida de la ejecuciï¿½n de la funciï¿½n
	//si la funciï¿½n tuvo error (false), salida contendrï¿½ el mensaje de error
	//si la funciï¿½n no tuvo error (true), salida contendrï¿½ el resultado, ya sea un conjunto de datos o un mensaje de confirmaciï¿½n
	var $salida;

	//Variable que contedrï¿½ la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecuciï¿½n de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la funciï¿½n a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBDepreciacionGestion.php";

	//Matriz de parï¿½metros de validaciï¿½n de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarï¿½n o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la funcion:	ListarDepreciacionGestion
	 * Propï¿½sito:				Desplegar los registros de taf_depreciacion en funciï¿½n de los parï¿½metros del filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creacion:		29092015
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarDepreciacionGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_gestion_sel';
		$this->codigo_procedimiento = "'AF_DEPGES_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_depreciacion_gestion','integer');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('fecha_reg','text');
		$this->var->add_def_cols('id_gestion_fin','integer');
		$this->var->add_def_cols('gestion_fin','numeric');
		$this->var->add_def_cols('mes_fin','integer');
		$this->var->add_def_cols('id_gestion_ini','integer');
		$this->var->add_def_cols('gestion_ini','numeric');
		$this->var->add_def_cols('mes_ini','integer');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('desc_depto','text');
		
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('desc_proyecto','text');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	ContarDepreciacionGestion
	 * Propï¿½sito:				Contar el total de registros desplegados en funciï¿½n de los parï¿½metros de filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creaciï¿½n:		11-06-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarDepreciacionGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_gestion_sel';
		$this->codigo_procedimiento = "'AF_DEPGES_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;

		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	

	/**
	 * Nombre de la funciï¿½n:	CrearDepreciacion
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de inserciï¿½n de la taf_depreciacion de la base de datos,
	 * 							con los parï¿½metros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creaciï¿½n:		29092015
	 *
	 * @param unknown_type $id_depreciacion
	 * @return unknown
	 */
	function InsertarDepreciacionGestion($id_gestion_ini,$id_gestion_fin,$proyecto,$id_depto,$estado,$mes_ini,$mes_fin,$id_proyecto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_gestion_iud';
		$this->codigo_procedimiento = "'AF_DEPGES_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)
		$this->var->add_param("NULL");//af_id_depreciacion_gestion
		$this->var->add_param($id_gestion_ini);//af_id_gestion_ini
		$this->var->add_param($id_gestion_fin);//af_id_gestion_fin
		$this->var->add_param($id_depto);//af_id_depto 
		$this->var->add_param("'$estado'");//af_estado
		$this->var->add_param("'$proyecto'");//af_proyecto
		$this->var->add_param($mes_ini);//af_mes_ini
		$this->var->add_param($mes_fin);//af_mes_fin
		$this->var->add_param($id_proyecto);//af_id_proyecto

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	EliminarDepreciacionGestion
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla taf_depreciacion_gestion de la base de datos
	 * con los parï¿½metros requeridos
	 * Autor:					unknow
	 * Fecha de creaciï¿½n:		29092015
	 *
	 * @param unknown_type $id_depreciacion_gestion
	 * @return unknown
	 */
	function  EliminarDepreciacionGestion($id_depreciacion_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_gestion_iud';
		$this->codigo_procedimiento = "'AF_DEPGES_DEL'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)

		
		$this->var->add_param($id_depreciacion_gestion);//af_id_depreciacion_gestion
		$this->var->add_param('NULL');//af_id_gestion_ini
		$this->var->add_param('NULL');//af_id_gestion_fin
		$this->var->add_param('NULL');//af_id_depto
		$this->var->add_param('NULL');//af_estado
		$this->var->add_param('NULL');//af_proyecto
		$this->var->add_param('NULL');//af_mes_ini
		$this->var->add_param('NULL');//af_mes_fin
		$this->var->add_param('NULL');//af_id_proyecto

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	ModificarDepreciacionGestion
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de modificaciï¿½n de la tabla taf_depreciacion_gestion de la base de datos
	 * con los parï¿½metros requeridos
	 * Autor:					Unknow
	 * Fecha de creacion:		29092015eewsa43
	 */
	function  ModificarDepreciacionGestion($id_depreciacion_gestion,$id_gestion_ini,$id_gestion_fin,$proyecto,$id_depto,$estado,$mes_ini,$mes_fin,$id_proyecto)
	{ 		
		$this->nombre_funcion = 'f_taf_depreciacion_gestion_iud';
		if($estado =='depreciado')//depreciar gestion
			$this->codigo_procedimiento="'AF_DEP_GESTION'";
		elseif($estado=='borrador')
			$this->codigo_procedimiento="'AF_REVDEP_GESTION'";
		else	
			$this->codigo_procedimiento = "'AF_DEPGES_UPD'";
		
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		//Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)
		$this->var->add_param($id_depreciacion_gestion);//af_id_depreciacion_gestion
		$this->var->add_param($id_gestion_ini);//af_id_gestion_ini
		$this->var->add_param($id_gestion_fin);//af_id_gestion_fin
		$this->var->add_param($id_depto);//af_id_depto
		$this->var->add_param("'$estado'");//af_estado
		$this->var->add_param("'$proyecto'");//af_proyecto
		$this->var->add_param($mes_ini);//af_mes_ini
		$this->var->add_param($mes_fin);//af_mes_fin
		$this->var->add_param($id_proyecto);//af_id_proyecto
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	function ReporteDepreciacionGestionActivosFijos($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_gestion_sel';
		$this->codigo_procedimiento = "'REP_DEPREC_GEST'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase midlle para la ejecuciÃ³n de la funciÃ³n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		//Carga los parÃ¡metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		
		if($criterio_filtro != ""){
			$parametro = "'{";
			foreach($criterio_filtro as $pm)
				$parametro .= "$pm,";
		
			$parametro = trim($parametro, ',');
		
			$parametro .= "}'";
		
			$this->var->criterio_filtro = "$parametro";
		
		}else {
		
			$this->var->criterio_filtro = "'$criterio_filtro'";
		}
		
		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		
		
		//Carga la definiciÃ³n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('tipo_activo','varchar');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('cod_activo_fijo','varchar');
		$this->var->add_def_cols('vida_util_actual','integer');
		$this->var->add_def_cols('valor_contable','numeric');
		$this->var->add_def_cols('actualizacion','numeric');
		$this->var->add_def_cols('valor_total','numeric');
		$this->var->add_def_cols('depreciacion_acum_ini','numeric');
		$this->var->add_def_cols('actualizacion_depre','numeric');
		$this->var->add_def_cols('deprec_acum_actualiz','numeric');
		$this->var->add_def_cols('deprec_periodo','numeric');
		$this->var->add_def_cols('deprec_acumulada','numeric');
		$this->var->add_def_cols('valor_neto_real','numeric');
		//$this->var->add_def_cols('fecha_hasta','date');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		$this->var->add_def_cols('revalorizado','varchar');
		//aÃ±adido 13/02/2014
		$this->var->add_def_cols('fecha_ini_dep','date');
		$this->var->add_def_cols('fecha_compra','date');
		$this->var->add_def_cols('nombre_completo','text');
		//aÃ±adido 25/02/2014
		$this->var->add_def_cols('descripcion_larga','varchar');
		//a�adido 30/06/2015
		$this->var->add_def_cols('tension','varchar');
		$this->var->add_def_cols('bienes_produccion','varchar');
		
		//Ejecuta la funciÃ³n de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la funciÃ³n y retorna el resultado de la ejecuciÃ³n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamÃ³ a la funciÃ³n de postgres
		$this->query = $this->var->query;
		
		return $res;
		
	}
	
}
?>
