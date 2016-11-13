<?php
/**
 * Nombre de la Clase:	cls_DBMovimientoProyectoDet.php
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_movimiento_proyecto_det
 * Autor:				UNKNOW
 * Fecha creación:		27-10-2014
 *
 */
class cls_DBMovimientoProyectoDet 
{
	var $salida;
	var $query;
	// Variables para la ejecución de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la función a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBMovimientoProyectoDet.php";
	
	// Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array ();
	
	// Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;
	function __construct() {
		// Carga los parámetro de validación de todas las columnas
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	function ListarMovimientoProyectoDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_det_sel';
		$this->codigo_procedimiento = "'AL_DETPROYMOV_SEL'";
		
		$func = new cls_funciones();
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('id_proyecto_mov_det', 'integer');
		$this->var->add_def_cols('id_movimiento_proyecto', 'integer');
		$this->var->add_def_cols('cantidad', 'numeric'); 
		$this->var->add_def_cols('unidad_medida', 'text');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('desc_item', 'text');
		$this->var->add_def_cols('id_unidad_medida_base', 'integer');
		$this->var->add_def_cols('nombre_medida', 'varchar');
		//a�adido 12-05-2015
		$this->var->add_def_cols('precio_unitario', 'numeric');	 
		$this->var->add_def_cols('costo_unitario', 'numeric');
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ContarMovimientoProyectoDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_det_sel';
		$this->codigo_procedimiento = "'AL_DETPROYMOV_COUNT'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		
		// Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		// Retorna el resultado de la ejecución
		return $res;
	}
	function InsertarItemsArchivo($id_mov_proy, $id_item, $cantidad, $unidad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_det_iud';
		$this->codigo_procedimiento = "'AL_DETPROYMOV_INS2'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param("NULL");//al_id_proyecto_mov_det
		$this->var->add_param($id_mov_proy);//al_id_movimiento_proyecto
		$this->var->add_param($id_item);//al_id_item
		$this->var->add_param("'$cantidad'");//al_cantidad
		$this->var->add_param("'$unidad'");//al_unidad_medida
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function InsertarMovimientoProyectoDet($id_mov_proy, $id_item, $cantidad, $unidad,$costo_unitario) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_det_iud';
		$this->codigo_procedimiento = "'AL_DETPROYMOV_INS'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param("NULL");//al_id_proyecto_mov_det
		$this->var->add_param($id_mov_proy);//al_id_movimiento_proyecto
		$this->var->add_param($id_item);//al_id_item 
		$this->var->add_param("'$cantidad'");//al_cantidad
		$this->var->add_param("'$unidad'");//al_unidad_medida
		//a�adido 12-05-2015
		$this->var->add_param("$costo_unitario");//al_costo_unitario

		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function ModificarMovimientoProyectoDet($id_mov_proy_det, $id_mov_proy, $id_item, $cantidad, $unidad,$costo_unitario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_det_iud';
		$this->codigo_procedimiento = "'AL_DETPROYMOV_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param("$id_mov_proy_det");//al_id_proyecto_mov_det
		$this->var->add_param($id_mov_proy);//al_id_movimiento_proyecto
		$this->var->add_param($id_item);//al_id_item 
		$this->var->add_param("'$cantidad'");//al_cantidad
		$this->var->add_param("'$unidad'");//al_unidad_medida
		//a�adido 12-05-2015
		$this->var->add_param("$costo_unitario");//al_costo_unitario
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function EliminarMovimientoProyectoDet($id_mov_proy_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_det_iud';
		$this->codigo_procedimiento = "'AL_DETPROYMOV_DEL'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_mov_proy_det");
		$this->var->add_param("NULL");//al_id_movimiento_proyecto
		$this->var->add_param("NULL");//al_id_item 
		$this->var->add_param("NULL");//al_cantidad
		$this->var->add_param("NULL");//al_unidad_medida
		//a�adido 12-05-2015
		$this->var->add_param("NULL");//al_costo_unitario
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	} 
	
	function ProcesarArchivo($file,$id_proy,$ruta)
	{
		/*$archivo= fopen("../../archivos_proyectos/$file" , "r");
		$cont = 0;
		
		if($archivo)
		{
			//mientras no estemos en el final del archivo realizamos lo siguiente
			while (!feof($archivo))
			{
				//obtenemos una linea completa del archivo y la almacenamos en la variable $registro
				$registro=fgets($archivo);
				$registro=str_replace(';', '', $registro);
				$split=split(',',$registro);
				
				$res =$this->InsertarItemsArchivo($split[1], $split[0], $split[2], $split[3]);
				
				if(!res) return false;
				
			}
			return true;
		} 
		fclose($archivo);*/ 
		$nombre_archivo=$ruta.$file;
		$this->salida="";
		$this->nombre_funcion = 'alma.f_tai_movimiento_proyecto_det_iud';
		$this->codigo_procedimiento = "'AL_ITPROY_INS'";
		
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
	
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//al_id_proyecto_mov_det
		$this->var->add_param("$id_proy");//al_id_movimiento_proyecto
		$this->var->add_param("NULL");//al_id_item
		$this->var->add_param("NULL");//al_cantidad
		$this->var->add_param("'$nombre_archivo'");//al_unidad_medida o ruta de ejecucion del archivo
	
		 
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
		
		
	}
	//añadido 12-05-2015
	function ProcesarArchivoItemsProyecto($file,$id_proy,$ruta)
	{	
		$archivo= fopen("../../archivos_proyectos/$file" , "r");

		//$archivo = f_open("$ruta.$file","r+"); 
		if($archivo)
		{
			$texto="";
			//mientras no estemos en el final del archivo realizamos lo siguiente
			while(!feof($archivo))
			{
				//obtenemos una linea completa del archivo y la almacenamos en la variable $registro
				$registro=fgets($archivo);
				//si la linea recuperada es diferente de vacio, procesamos su contenido
				if($registro!="")
				{
					$split=split(',',$registro);
					
					if($split [2] != '' OR $split [2] > 0)
						$texto .= " insert into tt_tfv_mov_proyecto_det_items values ( ''$split[0]'' , $split[1] , $split[2] ) ;  ";
					else 
						$texto .= " insert into tt_tfv_mov_proyecto_det_items values ( ''$split[0]'' , $split[1] , NULL ) ;  ";
				}//fin del if registro diferente de vacio
			}
			fclose($archivo);
			$res=$this->CargarDatosMovimientoProyectoDetalleItems($id_proy,$texto);
		}//fin del if de verificacion del archivo
		else {echo "No existe el archivo";exit;}
		return $res;
	}
	
	function CargarDatosMovimientoProyectoDetalleItems($id_proy,$texto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_det_iud';
		$this->codigo_procedimiento = "'AL_MOVPROYDETIT_INS'";
		
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	
		$this->var->add_param("NULL");//al_id_proyecto_mov_det
		$this->var->add_param("$id_proy");//al_id_movimiento_proyecto
		$this->var->add_param("NULL");//al_id_item
		$this->var->add_param("NULL");//al_cantidad
		$this->var->add_param("'$texto'");//al_unidad_medida o script de insercion
		$this->var->add_param("NULL");//al_costo_unitario
		 
		$res = $this->var->exec_non_query();
		
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	//fin añadido 12-05-2015
	function ValidarMovimientoProyectoDet($sql, $id_mov_proy_det, $id_mov_proy, $id_item, $cantidad, $unidad)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		// Ejecuta la validación por el tipo de operación
		if ($sql == 'insert' || $sql == 'update') {
			if ($operacion_sql == 'update') 
			{
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_proyecto_mov_det");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proyecto_mov_det", $id_mov_proy_det)) 
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_movimiento_proyecto");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_movimiento_proyecto", $id_mov_proy)) 
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad", $cantidad)) {
				$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("unidad_medida");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "unidad_medida", $unidad)) {
				$this->salida = $valid->salida;
				return false;
			}
			// validación exitosa
			return true;
		} elseif ($operacion_sql == 'delete') {
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_detalle_movimiento");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_detalle_movimiento", $id_detalle_movimiento)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}
}
?>
