<?php
/**
 * Nombre de la clase:	cls_DBPresupuesto.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_presupuesto
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-10 08:45:10
 */

 
class cls_DBVerificarPresto
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
	 * Nombre de la función:	ListarFormulacionPresupuesto
	 * Propósito:				Desplegar los registros de tpr_presupuesto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-10 08:45:10
	 */
	function VerificarPresUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto,$id_usuario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_verificacionesusuario_rep';
		$this->codigo_procedimiento = "'PR_VERPRE_REP'";

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
		$this->var->add_param("$id_presupuesto");//id_presupuesto
		$this->var->add_param("$id_usuario");//id_usuario  
		$this->var->add_param("'NULL'");//id_depto
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('desc_epe','TEXT');
		$this->var->add_def_cols('id_asignacion_estructura','INTEGER');
		$this->var->add_def_cols('nombre','VARCHAR(100)');
		$this->var->add_def_cols('asignacion_estructura','TEXT');
		$this->var->add_def_cols('asignacion_empleado','TEXT');
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query(); 
  
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
 
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
	/*if($_SESSION['ss_id_usuario']==131){
	    echo $this->query;
		exit();
		}*/

		return $res;
	}
	
	
	
	/**
	 * Nombre de la función:	ListarFormulacionPresupuesto
	 * Propósito:				Desplegar los registros de tpr_presupuesto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-10 08:45:10
	 */
	function VerificarDepUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_depto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_verificacionesusuario_rep';
		$this->codigo_procedimiento = "'PR_VERDEP_REP'";
		
	
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
		$this->var->add_param("NULL");//id_presupuesto
		$this->var->add_param("NULL");//id_usuario
		$this->var->add_param("'$id_depto'");//id_usuario
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_depto','VARCHAR(200)');
		$this->var->add_def_cols('nombre_completo','TEXT');
		$this->var->add_def_cols('estado','VARCHAR(20)');
		$this->var->add_def_cols('cargo','VARCHAR');
		
			
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		/*if($_SESSION['ss_id_usuario']==131){
		 echo $this->query;
		exit();
		}*/
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarFormulacionPresupuesto
	 * Propósito:				Desplegar los registros de tpr_presupuesto
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-10 08:45:10
	 */
	function VerificarDepEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto)
	{
		$this->salida = "";
	$this->nombre_funcion = 'f_tpr_verificacionesusuario_rep';
		$this->codigo_procedimiento = "'PR_VERDEPEP_REP'";
	
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
		$this->var->add_param("$id_presupuesto");//id_presupuesto
		$this->var->add_param("NULL");//id_usuario
		$this->var->add_param("'NULL'");//id_depto
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('desc_presupuesto','TEXT');
		$this->var->add_def_cols('desc_epe','TEXT');
		$this->var->add_def_cols('nombre_financiador','VARCHAR(100)');
		$this->var->add_def_cols('nombre_regional','VARCHAR(100)');
		$this->var->add_def_cols('nombre_programa','VARCHAR(100)');
		$this->var->add_def_cols('nombre_proyecto','VARCHAR(100)');
		$this->var->add_def_cols('nombre_actividad','VARCHAR(100)');
	    $this->var->add_def_cols('nombre_depto','VARCHAR(200)');
		$this->var->add_def_cols('estado','VARCHAR(10)');
		
		
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		/*if($_SESSION['ss_id_usuario']==131){
		 echo $this->query;
		exit();
		}*/
	
		return $res;
	}
	
}?>