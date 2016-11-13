<?php
/**
 * Nombre de la Clase:	cls_DBContrato
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tkp_Contrato
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		11-08-2010
 *
 */
class cls_DBContrato
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
	var $nombre_archivo = "cls_DBContrato.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los parámetro de validación de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarContrato
	 * Propósito:				Desplegar los registros de tkp_Contrato en función de los parámetros del filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 *
	 */
	function ListarContrato($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_contrato_sel';
		$this->codigo_procedimiento = "'KP_CONTRA_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_contrato','integer');
		$this->var->add_def_cols('nro_contrato','integer');
		$this->var->add_def_cols('tipo_contrato','varchar');
		$this->var->add_def_cols('sueldo','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('fecha_ini','date');
		$this->var->add_def_cols('fecha_fin','date');
		
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('desc_moneda','varchar');
		
		$this->var->add_def_cols('forma_pago','varchar');
		$this->var->add_def_cols('tiene_quincena','varchar');
		$this->var->add_def_cols('porcen_quincena','numeric');
		$this->var->add_def_cols('socio_cooperativa','varchar');
		$this->var->add_def_cols('monto_fijo','numeric');
		$this->var->add_def_cols('porcen_fijo_cooperativa','numeric');
		$this->var->add_def_cols('fecha_inicio_quincena','date');
		$this->var->add_def_cols('tipo_registro_contrato','varchar');
		
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarContrato
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 *
	 */
	function ContarContrato($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_contrato_sel';
		$this->codigo_procedimiento = "'KP_CONTRA_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

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
	 * Nombre de la función:	InsertarContrato
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_Contrato
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		11-08-2010
	 * Descripción:             Se añadio los atributos fecha_reg, estado_reg
	
	 */
	function InsertarContrato($id_contrato,$nro_contrato,$tipo_contrato,$sueldo,$id_moneda,$fecha_ini,$fecha_fin,$fecha_reg,$estado_reg,$id_empleado,
	$forma_pago,$tiene_quincena,$porcen_quincena,$socio_cooperativa,$monto_fijo,$porcen_fijo_cooperativa,$fecha_inicio_quincena,$tipo_registro_contrato)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_contrato_iud';
		$this->codigo_procedimiento = "'KP_CONTRA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($nro_contrato);
		$this->var->add_param("'$tipo_contrato'");
		$this->var->add_param($sueldo);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param($id_empleado);
		
		$this->var->add_param("'$forma_pago'");
		$this->var->add_param("'$tiene_quincena'");
		$this->var->add_param($porcen_quincena);
		$this->var->add_param("'$socio_cooperativa'");
		$this->var->add_param($monto_fijo);
		$this->var->add_param($porcen_fijo_cooperativa);
		$this->var->add_param("'$fecha_inicio_quincena'");
		$this->var->add_param("'$tipo_registro_contrato'");
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarContrato
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_Contrato
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function ModificarContrato($id_contrato,$nro_contrato,$tipo_contrato,$sueldo,$id_moneda,$fecha_ini,$fecha_fin,$fecha_reg,$estado_reg,$id_empleado,
	$forma_pago,$tiene_quincena,$porcen_quincena,$socio_cooperativa,$monto_fijo,$porcen_fijo_cooperativa,$fecha_inicio_quincena,$tipo_registro_contrato)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_contrato_iud';
		$this->codigo_procedimiento = "'KP_CONTRA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_contrato);
		$this->var->add_param($nro_contrato);
		$this->var->add_param("'$tipo_contrato'");
		$this->var->add_param($sueldo);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param($id_empleado);
		
		
		$this->var->add_param("'$forma_pago'");
		$this->var->add_param("'$tiene_quincena'");
		$this->var->add_param($porcen_quincena);
		$this->var->add_param("'$socio_cooperativa'");
		$this->var->add_param($monto_fijo);
		$this->var->add_param($porcen_fijo_cooperativa);
	
		$this->var->add_param("'$fecha_inicio_quincena'");
		$this->var->add_param("'$tipo_registro_contrato'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarContrato
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_Contrato
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function EliminarContrato($id_contrato)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_contrato_iud';
		$this->codigo_procedimiento = "'KP_CONTRA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_contrato);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//
		
		
		$this->var->add_param("NULL");//("'$forma_pago'");
		$this->var->add_param("NULL");//("'$tiene_quincena'");
		$this->var->add_param("NULL");//($porcen_quincena);
		$this->var->add_param("NULL");//("'$socio_cooperativa'");
		$this->var->add_param("NULL");//($monto_fijo);
		$this->var->add_param("NULL");//($porcen_fijo_cooperativa);
		
		$this->var->add_param("NULL");//$this->var->add_param("'$fecha_inicio_quincena'");
		$this->var->add_param("NULL");//$this->var->add_param("'$fecha_inicio_socio'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarContrato
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_Contrato
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		11-08-2010
	 */
	function ValidarContrato($operacion_sql,$id_contrato,$nro_contrato,$tipo_contrato,$sueldo,$id_moneda,$fecha_ini,$fecha_fin,$fecha_reg,$estado_reg,$id_empleado)
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
				//Validar id_Contrato - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_contrato");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_contrato", $id_contrato))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			//Validar id_Contrato - tipo int4
//				$tipo_dato->_reiniciar_valor();
//				$tipo_dato->set_MaxLength(10);
//				$tipo_dato->set_Columna("nro_contrato");
//
//				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_contrato", $nro_contrato))
//				{
//					$this->salida = $valid->salida;
//					return false;
//				}
				
				//Validar id_Contrato - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_moneda");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
				{
					$this->salida = $valid->salida;
					return false;
				}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_contrato");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_contrato", $tipo_contrato))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ini");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ini", $fecha_ini))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_fin");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_fin", $fecha_fin))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_contrato");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_contrato", $id_contrato))
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
	
}
?>