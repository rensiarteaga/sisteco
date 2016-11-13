<?php
/**
 * Nombre de la clase:	cls_DBPlantilla.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_plantilla
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-16 12:20:40
 */

 
class cls_DBPlantilla
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
	 * Nombre de la función:	ListarPlantilla
	 * Propósito:				Desplegar los registros de tct_plantilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:40
	 */
	function ListarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_sel';
		$this->codigo_procedimiento = "'CT_EJEPLA_SEL'";

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
		$this->var->add_def_cols('id_plantilla','int4');
		$this->var->add_def_cols('tipo_plantilla','numeric');
		$this->var->add_def_cols('nro_linea','numeric');
		$this->var->add_def_cols('desc_plantilla','varchar');
		$this->var->add_def_cols('tipo','numeric');
		$this->var->add_def_cols('sw_tesoro','numeric');
		$this->var->add_def_cols('sw_compro','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPlantilla
	 * Propósito:				Contar los registros de tct_plantilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:40
	 */
	function ContarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_sel';
		$this->codigo_procedimiento = "'CT_EJEPLA_COUNT'";

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
	 * Nombre de la función:	InsertarPlantilla
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_plantilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:40
	 */
	function InsertarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea,$desc_plantilla,$tipo,$sw_tesoro,$sw_compro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_iud';
		$this->codigo_procedimiento = "'CT_EJEPLA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($tipo_plantilla);
		$this->var->add_param($nro_linea);
		$this->var->add_param("'$desc_plantilla'");
		$this->var->add_param($tipo);
		$this->var->add_param($sw_tesoro);
		$this->var->add_param($sw_compro);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
        /*echo $this->query;
        exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPlantilla
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_plantilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:40
	 */
	function ModificarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea,$desc_plantilla,$tipo,$sw_tesoro,$sw_compro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_iud';
		$this->codigo_procedimiento = "'CT_EJEPLA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plantilla);
		$this->var->add_param($tipo_plantilla);
		$this->var->add_param($nro_linea);
		$this->var->add_param("'$desc_plantilla'");
		$this->var->add_param($tipo);
		$this->var->add_param($sw_tesoro);
        $this->var->add_param($sw_compro);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPlantilla
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_plantilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:40
	 */
	function EliminarPlantilla($id_plantilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_plantilla_iud';
		$this->codigo_procedimiento = "'CT_EJEPLA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plantilla);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//desc_plantilla
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
	 * Nombre de la función:	EliminarPlantilla
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_plantilla
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-10-16 12:20:40
	 */
	function CalculaSujetoLiquido($importe,$tipo_documento,$sw_sujeto_liquido)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ct_importe_sujeto_documento';
		$this->codigo_procedimiento = "'CT_CALSUJLIQ_IUD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($importe);
		$this->var->add_param($tipo_documento);
		$this->var->add_param($sw_sujeto_liquido);
		//Ejecuta la función
		
		$res = $this->var-> exec_function();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
           	
		return $this->salida[0][0];

		
	}
	
	

	
	/**
	 * Nombre de la función:	ValidarPlantilla
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_plantilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-16 12:20:40
	 */
	function ValidarPlantilla($operacion_sql,$id_plantilla,$tipo_plantilla,$nro_linea,$desc_plantilla,$tipo,$sw_tesoro,$sw_compro)
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
				//Validar id_plantilla - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_plantilla");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plantilla", $id_plantilla))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar tipo_plantilla - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_plantilla");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_plantilla", $tipo_plantilla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_linea - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_linea");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "nro_linea", $nro_linea))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			//return true;
			
			
			//Validar nro_linea - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_MaxLength(40);
			$tipo_dato->set_Columna("desc_plantilla");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "desc_plantilla", $desc_plantilla))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			
			
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("tipo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "tipo", $tipo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("sw_tesoro");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "sw_tesoro", $sw_tesoro))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("sw_compro");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "sw_compro", $sw_compro))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_plantilla - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_plantilla");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plantilla", $id_plantilla))
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