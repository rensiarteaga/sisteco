<?php
/**
 * Nombre de la clase:	cls_DBCategoriaAdq.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_categoria_adq
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-14 16:23:16
 */

 
class cls_DBCategoriaAdq
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
	 * Nombre de la función:	ListarCategoriaAdq
	 * Propósito:				Desplegar los registros de tad_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-14 16:23:16
	 */
	function ListarCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_categoria_adq_sel';
		$this->codigo_procedimiento = "'AD_CATADQ_SEL'";

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
		$this->var->add_def_cols('id_categoria_adq','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('precio_min','numeric');
		$this->var->add_def_cols('precio_max','numeric');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
        $this->var->add_def_cols('norma','varchar');
        $this->var->add_def_cols('simplificada','integer');
        $this->var->add_def_cols('defecto','integer');
        //8ago11
        $this->var->add_def_cols('doc_respaldo','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarCategoriaAdq
	 * Propósito:				Contar los registros de tad_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-14 16:23:16
	 */
	function ContarCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_categoria_adq_sel';
		$this->codigo_procedimiento = "'AD_CATADQ_COUNT'";

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
	 * Nombre de la función:	InsertarCategoriaAdq
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-14 16:23:16
	 */
	function InsertarCategoriaAdq($id_categoria_adq,$nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto,$doc_respaldo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_CATADQ_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($precio_min);
		$this->var->add_param($precio_max);
		$this->var->add_param($id_moneda);
        $this->var->add_param("'$norma'");
        $this->var->add_param($simplificada); 
        $this->var->add_param($defecto);
        //8ago11
        $this->var->add_param("'$doc_respaldo'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCategoriaAdq
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-14 16:23:16
	 */
	function ModificarCategoriaAdq($id_categoria_adq,$nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto,$doc_respaldo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_CATADQ_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria_adq);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($precio_min);
		$this->var->add_param($precio_max);
		$this->var->add_param($id_moneda);
        $this->var->add_param("'$norma'");
        $this->var->add_param($simplificada); 
        $this->var->add_param($defecto);
        //8ago11
        $this->var->add_param("'$doc_respaldo'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCategoriaAdq
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-14 16:23:16
	 */
	function EliminarCategoriaAdq($id_categoria_adq)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_CATADQ_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria_adq);
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
		//8ago11
		$this->var->add_param("NULL"); //doc_respaldo
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarCategoriaAdq
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_categoria_adq
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-14 16:23:16
	 */
	function ValidarCategoriaAdq($operacion_sql,$id_categoria_adq,$nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto)
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
				//Validar id_categoria_adq - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_categoria_adq");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_adq", $id_categoria_adq))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(600);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(600);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar precio_min - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_min");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_min", $precio_min))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar precio_max - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_max");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_max", $precio_max))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar norma - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("norma");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "norma",$norma))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar simplificada - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("simplificada");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(),"simplificada",$simplificada))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar defecto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("defecto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(),"defecto",$defecto))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_categoria_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria_adq");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_adq", $id_categoria_adq))
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
	
	
	function ClonarCategoriaAdq($id_categoria_adq)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_categoria_adq_iud';
		$this->codigo_procedimiento = "'AD_CLONCAT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_categoria_adq);
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
		//8ago11
		$this->var->add_param("NULL");//doc_respaldo
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
}?>