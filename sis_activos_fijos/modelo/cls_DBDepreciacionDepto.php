<?php

class cls_DBDepreciacionDepto
{
	//Variable que contiene la salida de la ejecuciÃ³n de la funciÃ³n
	//si la funciÃ³n tuvo error (false), salida contendrÃ¡ el mensaje de error
	//si la funciÃ³n no tuvo error (true), salida contendrÃ¡ el resultado, ya sea un conjunto de datos o un mensaje de confirmaciÃ³n
	var $salida;

	//Variable que contendrÃ¡ la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecuciÃ³n de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la funciÃ³n a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBDepreciacionDepto.php";

	//Matriz de parÃ¡metros de validaciÃ³n de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarÃ¡n o no
	var $decodificar = false;

	function __construct($decodificar)
	{
			
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	
	function ListarDepreciacionDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_depto_sel';
		$this->codigo_procedimiento = "'AF_DEPDEPTO_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parÃƒÂ¡metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		
		$parametro = "'{";
			foreach ($criterio_filtro as $pm)
					$parametro .= "$pm,";
			$parametro = trim($parametro,',');
			$parametro .= "}'";
			
		$this->var->criterio_filtro = "$parametro";
		
		$this->var->add_def_cols('id_depreciacion_depto', 'integer');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('comprobantes', 'varchar');
		$this->var->add_def_cols('id_cbte_depto', 'integer');
		$this->var->add_def_cols('id_depto', 'integer');
		$this->var->add_def_cols('desc_depto', 'text');
		$this->var->add_def_cols('id_grupo_depreciacion', 'integer');
		
	
		//Ejecuta la funciÃƒÂ³n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciÃƒÂ³n y retorna el resultado de la ejecuciÃƒÂ³n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamÃƒÂ³ a la funciÃƒÂ³n de postgres
		$this->query = $this->var->query; 

		return $res;
	}
	

	function ListarDepreciacionDeptoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_depto_sel';
		$this->codigo_procedimiento = "'AF_DEPDEPTODET_SEL'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		//Carga los parÃƒÂ¡metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_def_cols('id_activo_fijo', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('codigo_financiador', 'varchar');
		$this->var->add_def_cols('codigo_regional', 'varchar');
		$this->var->add_def_cols('codigo_programa', 'varchar');
		$this->var->add_def_cols('codigo_proyecto', 'varchar');
		$this->var->add_def_cols('codigo_actividad', 'varchar');
		
		//Ejecuta la funciÃƒÂ³n de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la funciÃƒÂ³n y retorna el resultado de la ejecuciÃƒÂ³n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamÃƒÂ³ a la funciÃƒÂ³n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function countDepreciacionDeptoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_depto_sel';
		$this->codigo_procedimiento = "'AF_DEPDEPTODET_COUNT'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		
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
	 

	function PDFRespaldoDepreciacionDepto($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_depto_sel';
		$this->codigo_procedimiento = "'REP_DEPRECDEPTO_RESP'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		
		if($criterio_filtro != "")
		{
			$parametro = "'{";
			foreach($criterio_filtro as $pm)
				$parametro .= "$pm,";
		
			$parametro = trim($parametro, ',');
		
			$parametro .= "}'";
		
			$this->var->criterio_filtro = "$parametro";
		}
		else
		{
			$this->var->criterio_filtro = "'$criterio_filtro'";
		}
		
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('actualizacion','numeric');
		$this->var->add_def_cols('actualizacion_depre','numeric');
		$this->var->add_def_cols('depreciacion_periodo','numeric');
		$this->var->add_def_cols('tension','varchar');
		$this->var->add_def_cols('bienes_produccion','varchar');
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('desc_tipo_activo','text');
		$this->var->add_def_cols('desc_regional','text');
		$this->var->add_def_cols('id_plan_ctas','integer');
		$this->var->add_def_cols('id_frppa','integer');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('desc_cta_activo','text');
		$this->var->add_def_cols('desc_cta_depacum','text');
		$this->var->add_def_cols('desc_cta_gasto','text');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function obtenerCabeceraDepreciacionDepto($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_depto_sel';
		$this->codigo_procedimiento = "'REP_DEPDEPTO_CAB'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_def_cols('mes_fin','numeric'); 
		$this->var->add_def_cols('ano_fin','numeric');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('desc_depto','text');
		$this->var->add_def_cols('proyecto','varchar');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
		
	}
	
	function RegistrarDepreciacionDepto($id_grupo_dep,$id_deprec_depto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_depto_iud';
		$this->codigo_procedimiento = "'AF_DEPDEPTO_REGCBTE'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_deprec_depto);
		$this->var->add_param("NULL");
		$this->var->add_param($id_grupo_dep);
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
}?>