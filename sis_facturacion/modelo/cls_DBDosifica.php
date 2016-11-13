<?php
/**
 * Nombre de la Clase:	cls_DBDosifica
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tfv_dosifica
 * Autor:				Julio Guarachi López
 * Fecha creación:		15-08-2007
 *
 */
class cls_DBDosifica
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
	var $nombre_archivo = "cls_DBDosifica.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct()
	{
		//Carga los parámetro de validación de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarDosifica
	 * Propósito:				Desplegar los registros de tfv_dosifica en función de los parámetros del filtro
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function ListarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_dosifica_sel';
		$this->codigo_procedimiento = "'FV_DOSIFI_SEL'";

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
		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_dosifica','integer');
		$this->var->add_def_cols('tipo_fac','numeric(1,0)');
		$this->var->add_def_cols('nro_autoriza','numeric(15,0)');
		$this->var->add_def_cols('fecha_vence','date');
		$this->var->add_def_cols('clave_activa','varchar(256)');
		$this->var->add_def_cols('sw_debito','varchar');
		$this->var->add_def_cols('nro_inicial','integer');
		$this->var->add_def_cols('nro_actual','integer');
		$this->var->add_def_cols('actividad','varchar');
		$this->var->add_def_cols('leyenda','varchar');
		$this->var->add_def_cols('estado','numeric(1,0)');
		$this->var->add_def_cols('desc_usr_reg','varchar');
		$this->var->add_def_cols('fecha_reg','timestamp');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarDosifica
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function ContarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_dosifica_sel';
		$this->codigo_procedimiento = "'FV_DOSIFI_COUNT'";

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
	 * Nombre de la función:	InsertarDosifica
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfv_dosifica
	 * 							con los parámetros requeridos
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
		
	function InsertarDosifica($id_dosifica,$tipo_fac,$nro_autoriza,$fecha_vence,$clave_activa,$sw_debito,$nro_inicial,$nro_actual,$actividad,$leyenda,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_dosifica_iud';
		$this->codigo_procedimiento = "'FV_DOSIFI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id de dosificacion
		$this->var->add_param("$tipo_fac");//tipo de la factura
		$this->var->add_param("$nro_autoriza");//numero de autorizacion
		$this->var->add_param("'$fecha_vence'");//fecha de vencimiento de la dosificacion
		$this->var->add_param("'$clave_activa'");//clave de activacion de la dosificacion
		$this->var->add_param("'$sw_debito'");//debito_fiscal
		$this->var->add_param("$nro_inicial");//numero inicial de la dosificacion
		$this->var->add_param("$nro_actual");//numero actual de la factura a emitir 
		$this->var->add_param("'$actividad'");//actividad
		$this->var->add_param("'$leyenda'");//leyenda
		$this->var->add_param("$estado");//estado de la dosificacion
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarDosifica
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfv_dosifica
	 * con los parámetros requeridos
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function ModificarDosifica($id_dosifica,$tipo_fac,$nro_autoriza,$fecha_vence,$clave_activa,$sw_debito,$nro_inicial,$nro_actual,$actividad,$leyenda,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_dosifica_iud';
		$this->codigo_procedimiento = "'FV_DOSIFI_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_dosifica");//id de dosificacion
		$this->var->add_param("$tipo_fac");//tipo de la factura
		$this->var->add_param("$nro_autoriza");//numero de autorizacion
		$this->var->add_param("'$fecha_vence'");//fecha de vencimiento de la dosificacion
		$this->var->add_param("'$clave_activa'");//clave de activacion de la dosificacion
		$this->var->add_param("'$sw_debito'");//debito_fiscal
		$this->var->add_param("$nro_inicial");//numero inicial de la dosificacion
		$this->var->add_param("$nro_actual");//numero actual de la factura a emitir 
		$this->var->add_param("'$actividad'");//actividad
		$this->var->add_param("'$leyenda'");//leyenda
		$this->var->add_param("$estado");//estado de la dosificacion

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la función:	EliminarDosifica
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfv_dosifica
	 * con los parámetros requeridos
	 * Autor:					MTSL
	 * Fecha de creación:		2014.05
	 */
	function EliminarDosifica($id_dosifica)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfv_dosifica_iud';
		$this->codigo_procedimiento = "'FV_DOSIFI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_dosifica");//id de dosificacion
		$this->var->add_param("null");//tipo de la factura
		$this->var->add_param("null");//numero inicial de la dosificacion
		$this->var->add_param("null");//numero actual de la factura a emitir 
		$this->var->add_param("null");//fecha de vencimiento de la dosificacion
		$this->var->add_param("null");//clave de activacion de la dosificacion
		$this->var->add_param("null");//numero de autorizacion
		$this->var->add_param("null");//actividad
		$this->var->add_param("null");//leyenda
		$this->var->add_param("null");//estado de la dosificacion
		$this->var->add_param("null");//sw_debito_fiscal
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarDosifica
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					MTSL			
	 * Fecha creación:			2014.05
	 */
	function ValidarDosifica($operacion_sql,$id_dosifica,$tipo_fac,$nro_autoriza,$fecha_vence,$clave_activa,$sw_debito,$nro_inicial,$nro_actual,$actividad,$leyenda,$estado)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validad el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		//Ejecuta la validación por el tipo de operación
		switch ($operacion_sql) {
			case 'insert' or 'update':

				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla
				
				if($operacion_sql == 'update')
				{				
					//Validar id_dosifica - tipo integer
					$tipo_dato->_reiniciar_valor();
					$tipo_dato->set_Columna("id_dosifica");	
					$tipo_dato->set_MaxLength(15);
					$tipo_dato->set_MinLength(0);
					$tipo_dato->set_Signo('2');
					 
					if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_dosifica", $id_dosifica))
					{
						$this->salida = $valid->salida;
						return false;
					}
				}
				
				//Validar tipo_fac - tipo numeric
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("tipo_fac");	
				$tipo_dato->set_MaxLength(1);
				$tipo_dato->set_MinLength(0);
				$tipo_dato->set_Signo('2');
				 
				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_fac", $tipo_fac))
				{
					$this->salida = $valid->salida;
					return false;
				}
				//Validar nro_inicial - tipo integer 
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("nro_inicial");
				$tipo_dato->set_MaxLength(1);	
				$tipo_dato->set_MinLength(0);		
				$tipo_dato->set_Signo('2');
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(),"nro_inicial",$nro_inicial))
				{
					$this->salida = $valid->salida;
					return false;
				}
				//Validar nro_actual - tipo integer 
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("nro_actual");
				$tipo_dato->set_MaxLength(1);	
				$tipo_dato->set_MinLength(0);		
				$tipo_dato->set_Signo('2');
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(),"nro_actual",$nro_actual))
				{
					$this->salida = $valid->salida;
					return false;
				}				
				
				//Validar fecha_vence - tipo date
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("fecha_vence");
				
				if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(),"fecha_vence",$fecha_vence))
				{
					$this->salida = $valid->salida;
					return false;
				}				
								
				//Validar nro_autoriza - tipo numeric
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("nro_autoriza");	
				$tipo_dato->set_MaxLength(15);
				$tipo_dato->set_MinLength(1);
				$tipo_dato->set_Signo('2');
				 
				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "nro_autoriza", $nro_autoriza))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				//Validación exitosa
				return true;
				break;
               
			case 'delete':
				break;
				
			default:
				return false;
				break;
		}
	}
}?>